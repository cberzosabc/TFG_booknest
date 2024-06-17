<?php

class PrestamoDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert(Prestamo $prestamo): int|bool {
        // Calcular la fecha de devolución esperada (3 semanas después de la fecha de préstamo)
        $fechaPrestamo = $prestamo->getFechaPrestamo();
        $fechaDevolucionEsperada = date('Y-m-d', strtotime($fechaPrestamo . ' + 3 weeks'));

        // Definir el estado como "prestado"
        $estado = 'prestado';

        // Query SQL para la inserción
        $sql = "INSERT INTO prestamo (id_usuario, id_libro, fecha_prestamo, fecha_devolucionEsperada, estado) VALUES (?, ?, ?, ?,?)";
        
        // Preparar la consulta
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        // Obtener los valores del objeto $prestamo
        $usuarioId = $prestamo->getUsuarioId();
        $libroId = $prestamo->getLibroId();

        // Vincular parámetros y tipos
        $stmt->bind_param('iisss', $usuarioId, $libroId, $fechaPrestamo, $fechaDevolucionEsperada, $estado);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la inserción fue exitosa, devolver el ID insertado
            return $stmt->insert_id;
        } else {
            // Si hubo un error en la ejecución de la consulta, devolver false
            return false;
        }
    }


    public function obtenerPrestamosPorUsuario($usuarioId) {
        $sql = "SELECT p.id, p.fecha_prestamo, p.fecha_devolucionEsperada, p.estado, l.titulo
                FROM prestamo p
                JOIN libro l ON p.id_libro = l.id
                WHERE p.id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die("Error al preparar la consulta obtenerPrestamosPorUsuario: " . $this->conn->error);
        }
    
        $stmt->bind_param('i', $usuarioId);
    
        if (!$stmt->execute()) {
            die("Error al ejecutar la consulta obtenerPrestamosPorUsuario: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
        $prestamos = [];
        while ($row = $result->fetch_assoc()) {
            $prestamos[] = $row;
        }
    
        return $prestamos;
    }
    public function marcarComoDevuelto($prestamoId) {
        $sql = "UPDATE prestamo SET estado = 'devuelto' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta marcarComoDevuelto: " . $this->conn->error);
        }
    
        $stmt->bind_param('i', $prestamoId);
    
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta marcarComoDevuelto: " . $stmt->error);
        }
    
        // Ahora, también actualizamos el estado del libro relacionado a 'disponible'
        $sqlUpdateLibro = "UPDATE libro l
                           JOIN prestamo p ON l.id = p.id_libro
                           SET l.disponible = 1
                           WHERE p.id = ?";
        $stmtUpdateLibro = $this->conn->prepare($sqlUpdateLibro);
    
        if (!$stmtUpdateLibro) {
            throw new Exception("Error al preparar la consulta de actualización del libro: " . $this->conn->error);
        }
    
        $stmtUpdateLibro->bind_param('i', $prestamoId);
    
        if (!$stmtUpdateLibro->execute()) {
            throw new Exception("Error al actualizar el estado del libro: " . $stmtUpdateLibro->error);
        }
    
        return true; 
    }
    
    
    public function findById($prestamoId) {
        $sql = "SELECT id, fecha_prestamo, fecha_devolucionEsperada, estado, id_libro, id_usuario
                FROM prestamo
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta findById: " . $this->conn->error);
        }

        $stmt->bind_param('i', $prestamoId);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta findById: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $prestamo = $result->fetch_assoc();

        if (!$prestamo) {
            throw new Exception("No se encontró el préstamo con ID: " . $prestamoId);
        }

        return $prestamo;
    }
    public function actualizarFechaDevolucionEsperada($prestamoId, $fechaActual)
{
    $sql = "UPDATE prestamo SET estado = 'devuelto', fecha_devolucionEsperada = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta actualizarFechaDevolucionEsperada: " . $this->conn->error);
    }

    $stmt->bind_param('si', $fechaActual, $prestamoId);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta actualizarFechaDevolucionEsperada: " . $stmt->error);
    }

    return true;
}

    
}