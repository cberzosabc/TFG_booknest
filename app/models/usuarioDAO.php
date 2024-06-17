<?php
class usuarioDAO
{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getByEmail($email): Usuario|null
    {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuario WHERE email = ?")) {
            echo "Error en la SQL " . $this->conn->error;
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            $user = $result->fetch_object(Usuario::class);
            return $user;
        } else {
            return null;
        }
    }
    

    function insert(Usuario $user): int|bool
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO usuario (nombre, apellidos, email, password, foto, poblacion, rol, sid) VALUES (?,?,?,?,?,?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }
        $nombre = $user->getNombre();
        $apellidos = $user->getApellidos();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $foto = $user->getFoto();
        $poblacion = $user->getPoblacion();
        $rol = $user->getRol();
        $sid = $user->getSid();
        $stmt->bind_param('ssssssss', $nombre, $apellidos, $email, $password, $foto, $poblacion, $rol, $sid);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    function insertDesdeAdmin(Usuario $user): int|bool
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO usuario (nombre, apellidos, email, password, foto, poblacion, rol, sid) VALUES (?,?,?,?,?,?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }
        $nombre = $user->getNombre();
        $apellidos = $user->getApellidos();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $foto = $user->getFoto();
        $poblacion = $user->getPoblacion();
        $rol = $user->getRol();
        $sid = $user->getSid();
        $stmt->bind_param('ssssssss', $nombre, $apellidos, $email, $password, $foto, $poblacion, $rol, $sid);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function getBySid($sid)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE sid = ?");
        $stmt->bind_param('s', $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object(Usuario::class);
        } else {
            return null;
        }
    }

    public function actualizarSid($idUsuario, $sid)
    {
        $stmt = $this->conn->prepare("UPDATE usuario SET sid = ? WHERE id = ?");
        $stmt->bind_param('si', $sid, $idUsuario);
        $stmt->execute();
    }

    public function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM usuario ORDER BY apellidos ASC, poblacion ASC, rol ASC";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update(Usuario $usuario):bool{
        $id=$usuario->getId();
        $nombre=$usuario->getNombre();
        $apellidos=$usuario->getApellidos();
        $email=$usuario->getEmail();
        $poblacion=$usuario->getPoblacion();
        $rol=$usuario->getRol();
        $foto=$usuario->getFoto();

        $sql="UPDATE usuario SET nombre=?, apellidos=?, email=?,foto=?,poblacion=?,rol=? WHERE id=?";
        $stmt=$this->conn->prepare($sql);
        if(!$stmt){
            echo "Error al preparar la consulta ".$this->conn->error;
            return false;
        }
        $stmt->bind_param('ssssssi', $nombre,$apellidos,$email,$foto,$poblacion,$rol,$id);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }
    }
    public function eliminarUsuario($idUsuario): bool {
        if (!$stmt = $this->conn->prepare("DELETE FROM usuario WHERE id=?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false; 
        }

        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }

    public function findById($id){
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return null;
        }

        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return null;
        }

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "No se encontró el autor con ID: {$id}";
            return null;
        }

        $usuario = $result->fetch_assoc();
        return $usuario;
    }
}
