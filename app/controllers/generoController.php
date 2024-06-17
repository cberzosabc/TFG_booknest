<?php

class GeneroController
{
    public function listaGeneros()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();

        $generoDAO = new GeneroDAO($conn);
        $generos = $generoDAO->getAll();


        require 'app/views/listaGeneros.php';
    }
    public function verGeneros()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();

        $generoDAO = new GeneroDAO($conn);
        $generos = $generoDAO->getAll();


        require 'app/views/verGeneros.php';
    }


    public function deleteGenero()
    {
        if (isset($_GET['id'])) {
            $generoId = $_GET['id'];

            // Conectarse a la base de datos
            $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connection->getConnection();

            // Crear instancia de UsuarioDAO
            $generoDAO = new GeneroDAO($conn);

            if ($generoDAO->eliminarGenero($generoId)) {
                header("Location: index.php?action=listaGeneros");
                exit;
            } else {
                echo "Error al eliminar el género";
            }
        } else {
            echo "ID de género no proporcionado";
        }
    }

    public function registrar()
    {

            $error = '';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Limpiamos los datos
                $nombre = $_POST['nombre'];

                //Conectamos con la BD
                $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
                $conn = $connexionDB->getConnection();


            $generosDao = new GeneroDAO($conn);

            //Insertamos en la BD
            $genero = new Genero();
            $genero->setNombre($nombre);


            if ($generosDao->insert($genero)) {
                $idGenero = $conn->insert_id;
                $genero->setId($idGenero);
                header("location: index.php?action=listaGeneros");
                exit();
            } else {
                $error = "No se ha podido insertar el género";
            }
        }
    }

    public function registrarGeneroDesdeLibros()
    {

            $error = '';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Limpiamos los datos
                $nombre = $_POST['nombre'];

                //Conectamos con la BD
                $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
                $conn = $connexionDB->getConnection();


            $generosDao = new GeneroDAO($conn);

            //Insertamos en la BD
            $genero = new Genero();
            $genero->setNombre($nombre);


            if ($generosDao->insert($genero)) {
                $idGenero = $conn->insert_id;
                $genero->setId($idGenero);
                header("location: index.php?action=verLibros");
                exit();
            } else {
                $error = "No se ha podido insertar el género";
            }
        }
    }

    public function editarGenero()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        // Conectarse a la base de datos
        $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connection->getConnection();

        // Crear instancia de GeneroDAO
        $generoDAO = new GeneroDAO($conn);

        $genero = new Genero();
        $genero->setId($id);
        $genero->setNombre($nombre);

        if ($generoDAO->update($genero)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

}
