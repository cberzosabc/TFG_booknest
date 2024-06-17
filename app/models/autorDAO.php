<?php

class AutorDAO{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function insert(Autor $autor): int|bool
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO autor (nombre, apellidos, foto, biografia, fecha_nacimiento, pais) VALUES (?,?,?,?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $nombre=$autor->getNombre();
        $apellidos=$autor->getApellidos();
        $foto=$autor->getFoto();
        $biografia=$autor->getBiografia();
        $fecha_nacimiento=$autor->getFechaNacimiento()->format('Y-m-d');
        $pais=$autor->getPais();
        $stmt->bind_param('ssssss', $nombre, $apellidos, $foto, $biografia,$fecha_nacimiento,$pais);
        if($stmt->execute()){
            return $stmt->insert_id;
        }else{
            return false;
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM autor ORDER BY apellidos ASC, nombre ASC";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }

            $autores = [];
            while ($row = $result->fetch_assoc()) {
                $autores[] = $row;
            }

            return $autores;
        } catch (Exception $e) {
            // Manejo de errores generales
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function eliminarAutor($idAutor): bool {
        if (!$stmt = $this->conn->prepare("DELETE FROM autor WHERE id=?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false; 
        }
    
        $stmt->bind_param("i", $idAutor);
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }
    public function findById($id){
        $sql = "SELECT * FROM autor WHERE id = ?";
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

        $autor = $result->fetch_assoc();
        return $autor;
    }

    public function update(Autor $autor):bool{
        $id=$autor->getId();
        $nombre=$autor->getNombre();
        $apellidos=$autor->getApellidos();
        $biografia=$autor->getBiografia();
        $fecha_nacimiento=$autor->getFechaNacimiento()->format('Y-m-d');
        $pais=$autor->getPais();
        $foto=$autor->getFoto();

        $sql="UPDATE autor SET nombre=?, apellidos=?, foto=?,biografia=?,fecha_nacimiento=?,pais=? WHERE id=?";
        $stmt=$this->conn->prepare($sql);

        if(!$stmt){
            echo "Error al preparar la consulta ".$this->conn->error;
            return false;
        }

        $stmt->bind_param('ssssssi', $nombre, $apellidos, $foto, $biografia,$fecha_nacimiento,$pais,$id);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }
    }

}