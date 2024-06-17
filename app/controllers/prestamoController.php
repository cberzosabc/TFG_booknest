<?php

class PrestamoController{
    public function listarPrestamosUsuario() {
        if (Session::existeSesion()) {
            $usuarioId = Session::getUsuario()->getId(); // Obtener el ID del usuario desde la sesión
    
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();
    
            // Crear instancia de PrestamoDAO
            $prestamoDAO = new PrestamoDAO($conn);
    
            // Obtener los préstamos del usuario
            $prestamos = $prestamoDAO->obtenerPrestamosPorUsuario($usuarioId);
    
            // Devolver los préstamos como JSON
            echo json_encode(['success' => true, 'prestamos' => $prestamos]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            exit;
        }
    }
    
}