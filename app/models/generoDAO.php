<?php

class GeneroDAO{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function insert(Genero $genero): bool {
        $nombre = $genero->getNombre();
        
        $sql = "INSERT INTO genero (nombre) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return false;
        }
        
        $stmt->bind_param('s', $nombre);
        
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM genero ORDER BY nombre ASC";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }

            $generos = [];
            while ($row = $result->fetch_assoc()) {
                $generos[] = $row;
            }

            return $generos;
        } catch (Exception $e) {
            // Manejo de errores generales
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getGeneroById($idGenero) {
        $sql = "SELECT * FROM genero WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return null;
        }

        $stmt->bind_param('i', $idGenero);

        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return null;
        }

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "No se encontró el género con ID: {$idGenero}";
            return null;
        }

        $genero = $result->fetch_assoc();
        return $genero;
    }
    
    public function eliminarGenero($idGenero): bool {
        if (!$stmt = $this->conn->prepare("DELETE FROM genero WHERE id=?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false; 
        }
    
        $stmt->bind_param("i", $idGenero);
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }
    public function update(Genero $genero): bool
{
    $id = $genero->getId();
    $nombre = $genero->getNombre();

    $sql = "UPDATE genero SET nombre = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        echo "Error al preparar la consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param('si', $nombre, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
        return false;
    }
}

}