<?php

class AutorController
{

    public function registrarAutorDesdeLibros()
    {

            $error = '';
            $fotoPredeterminada = 'imagen-por-defecto.png'; //creamos una foto predeterminada por si el usuario no selecciona una
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Limpiamos los datos
                $nombre = $_POST['name'];
                $apellidos = $_POST['apellidos'];
                $biografia = $_POST['biografia'];
                $fecha_nacimiento = new DateTime($_POST['fecha_nacimiento']);
                $pais = $_POST['pais'];
                $foto = '';

                //Validación 

                //Conectamos con la BD
                $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
                $conn = $connexionDB->getConnection();

            $autoresDAO = new AutorDAO($conn);
            if (
                isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 &&
                in_array($_FILES['foto']['type'], ['image/jpeg', 'image/webp', 'image/png'])
            ) {

                // Procesamiento de la foto subida
                $foto = generarNombreArchivo($_FILES['foto']['name']);
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosAutores/$foto")) {
                    $error = "Error al copiar la foto a la carpeta fotosAutores";
                    $foto = $fotoPredeterminada; // Usa la imagen predeterminada si falla
                }
            } else {
                // Si no se sube una foto, asigna la predeterminada
                $foto = $fotoPredeterminada;
            }

            //Insertamos en la BD
            $autor = new Autor();
            $autor->setNombre($nombre);
            $autor->setApellidos($apellidos);
            $autor->setBiografia($biografia);
            $autor->setFoto($foto);
            $autor->setFechaNacimiento($fecha_nacimiento);
            $autor->setPais($pais);

            if ($autoresDAO->insert($autor)) {
                $idAutor = $conn->insert_id;
                $autor->setId($idAutor);
                header("location: index.php?action=verLibros");
                exit();
            } else {
                $error = "No se ha podido insertar el autor";
            }
        }
    }

    public function listaAutores()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();

        $autorDAO = new AutorDAO($conn);
        $autores = $autorDAO->getAll();


        require 'app/views/listaAutores.php';
    }

    public function verAutores()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();

        $autorDAO = new AutorDAO($conn);
        $autores = $autorDAO->getAll();


        require 'app/views/verAutores.php';
    }

    public function deleteAutor()
    {
        if (isset($_GET['id'])) {
            $autorId = $_GET['id'];

            // Conectarse a la base de datos
            $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connection->getConnection();

            // Crear instancia de UsuarioDAO
            $autorDAO = new AutorDAO($conn);

            if ($autorDAO->eliminarAutor($autorId)) {
                header("Location: index.php?action=listaAutores");
                exit;
            } else {
                echo "Error al eliminar el autor";
            }
        } else {
            echo "ID de autor no proporcionado";
        }
    }
    public function editarAutor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener datos del formulario AJAX
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $biografia = $_POST['biografia'];
            $fechaNacimiento = new DateTime($_POST['fechaNacimiento']);
            $pais = $_POST['pais'];
            
            // Manejo de la foto
            $foto = '';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                // Guardar la imagen y obtener el nombre
                $foto = generarNombreArchivo($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosAutores/" . $foto);
            }
    
            // Conectar a la base de datos y actualizar el autor
            $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connection->getConnection();
            $autorDAO = new AutorDAO($conn);
    
            // Crear instancia de Autor
            $autor = new Autor();
            $autor->setId($id);
            $autor->setNombre($nombre);
            $autor->setApellidos($apellidos);
            $autor->setBiografia($biografia);
            $autor->setFechaNacimiento($fechaNacimiento);
            $autor->setPais($pais);
            $autor->setFoto($foto); 
    
            // Actualizar en la base de datos
            if ($autorDAO->update($autor)) {

                $autorActualizado = $autorDAO->findById($id);
                
                $response = [
                    'success' => true,
                    'autor' => [
                        'id' => $id,
                        'nombre' => $nombre,
                        'apellidos' => $apellidos,
                        'biografia' => $biografia,
                        'fecha_nacimiento' => $fechaNacimiento->format('Y-m-d'),
                        'pais' => $pais,
                        'foto' => $autorActualizado['foto'] 
                    ]
                ];
    
                echo json_encode($response);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el autor']);
                exit;
            }
        }
    }
    
    
}
