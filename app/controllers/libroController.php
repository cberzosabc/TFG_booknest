<?php

class libroController
{
    public function inicio()
    {
        // Crear la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();
        
        // Instanciar LibroDAO
        $libroDAO = new LibroDAO($conn);
        
        // Obtener los libros marcados como portada
        $librosPortada = $libroDAO->getLibrosPortada();
        
        // Pasar los libros a la vista
        require 'app/views/inicio.php';
    }
    public function verLibros()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();

        $libroDAO = new LibroDAO($conn);
        $libros = $libroDAO->getAllBooks();
        $autorDAO = new AutorDAO($conn);
        $autores = $autorDAO->getAll();
        $generoDAO = new GeneroDAO($conn);
        $generos = $generoDAO->getAll();


        require 'app/views/listaLibros.php';
    }

    public function todosLibros()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();

        $libroDAO = new LibroDAO($conn);
        $libros = $libroDAO->getAllBooks();
        $autorDAO = new AutorDAO($conn);
        $autores = $autorDAO->getAll();
        $generoDAO = new GeneroDAO($conn);
        $generos = $generoDAO->getAll();


        require 'app/views/verLibros.php';
    }
    public function librosPorAutor()
    {
        if (isset($_GET['autor_id'])) {
            $autorId = $_GET['autor_id'];

            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            // Instanciar LibroDAO
            $libroDAO = new LibroDAO($conn);


            $libros = $libroDAO->getLibrosPorAutor($autorId);


            require 'app/views/librosPorAutor.php';
        } else {

            echo "ID de autor no proporcionado";
        }
    }
    public function librosPorGenero()
    {
        if (isset($_GET['genero_id'])) {
            $generoId = $_GET['genero_id'];

            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            // Instanciar LibroDAO
            $libroDAO = new LibroDAO($conn);


            $libros = $libroDAO->getLibrosPorGenero($generoId);


            require 'app/views/librosPorGenero.php';
        } else {

            echo "ID de género no proporcionado";
        }
    }
    public function registrarLibros()
    {
        $error = '';
        $fotoPredeterminada = 'imagen-por-defecto.png'; //creamos una foto predeterminada por si el usuario no selecciona una
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Limpiamos los datos
            $titulo = $_POST['titulo'];
            $resumen = $_POST['resumen'];
            $isbn = $_POST['isbn'];
            $edicion = $_POST['edicion'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $foto = '';

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();


            //Compruebo que no haya un usuario registrado con el mismo email
            $librosDAO = new LibroDAO($conn);

            if (
                isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 &&
                in_array($_FILES['foto']['type'], ['image/jpeg', 'image/webp', 'image/png'])
            ) {

                // Procesamiento de la foto subida
                $foto = generarNombreArchivo($_FILES['foto']['name']);
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosPortadas/$foto")) {
                    $error = "Error al copiar la foto a la carpeta fotosPortadas";
                    $foto = $fotoPredeterminada; // Usa la imagen predeterminada si falla
                }
            } else {
                // Si no se sube una foto, asigna la predeterminada
                $foto = $fotoPredeterminada;
            }


            //Insertamos en la BD
            $libro = new Libro();
            $libro->setTitulo($titulo);
            $libro->setResumen($resumen);
            $libro->setIsbn($isbn);
            $libro->setEdicion($edicion);
            $libro->setIdAutor($autor);
            $libro->setIdGenero($genero);
            $libro->setFotoPortada($foto);

            if ($librosDAO->insert($libro)) {
                $idLibro = $conn->insert_id; //Forzamos que inserte un id al usuario y no salga a null
                $libro->setId($idLibro);
                header("location: index.php?action=verLibros");

                exit();
            } else {
                $error = "No se ha podido insertar el libro";
            }
        }
    }
    public function deleteLibro()
    {
        if (isset($_GET['id'])) {
            $libroId = $_GET['id'];

            // Conectarse a la base de datos
            $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connection->getConnection();

            // Crear instancia de UsuarioDAO
            $libroDAO = new LibroDAO($conn);

            if ($libroDAO->eliminarLibro($libroId)) {
                header("Location: index.php?action=verLibros");
                exit;
            } else {
                echo "Error al eliminar el libro";
            }
        } else {
            echo "ID de libro no proporcionado";
        }
    }

    public function marcarPortada() {
        if (isset($_GET['id'])) {
            $libroId = $_GET['id'];

            // Conectar a la base de datos
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            // Instanciar LibroDAO
            $libroDAO = new LibroDAO($conn);

            // Llamar al método en LibroDAO para marcar como portada
            if ($libroDAO->marcarComoPortada($libroId)) {
                header("Location: index.php?action=verLibros");
                exit();
            } else {
                echo "Error al marcar como portada";
            }
        } else {
            echo "ID de libro no proporcionado";
        }
    }

    public function desmarcarPortada() {
        if (isset($_GET['id'])) {
            $libroId = $_GET['id'];

            // Conectar a la base de datos
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            // Instanciar LibroDAO
            $libroDAO = new LibroDAO($conn);

            // Llamar al método en LibroDAO para desmarcar como portada
            if ($libroDAO->desmarcarComoPortada($libroId)) {
                header("Location: index.php?action=verLibros");
                exit();
            } else {
                echo "Error al desmarcar como portada";
            }
        } else {
            echo "ID de libro no proporcionado";
        }
    }

    public function editarLibro() {
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $resumen = $_POST['resumen'];
            $isbn = $_POST['isbn'];
            $edicion = $_POST['edicion'];
            $idAutor = $_POST['idAutor'];
            $idGenero = $_POST['idGenero'];
            $foto = '';
    
            // Manejo de la foto de portada si se ha subido una nueva
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $foto = generarNombreArchivo($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosPortadas/" . $foto);
            }

            $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connection->getConnection();
            $libroDAO = new LibroDAO($conn);
    
            $libro = new Libro();
            $libro->setId($id);
            $libro->setTitulo($titulo);
            $libro->setResumen($resumen);
            $libro->setIsbn($isbn);
            $libro->setEdicion($edicion);
            $libro->setIdAutor($idAutor);
            $libro->setIdGenero($idGenero);
            $libro->setFotoPortada($foto);
            if ($libroDAO->update($libro)) {
                // Obtener el libro actualizado
                $libroActualizado = $libroDAO->findById($id);

    
                $autorDAO = new AutorDAO($conn);
                $generoDAO = new GeneroDAO($conn); 
    
                $nombreAutor = $autorDAO->findById($idAutor); 
                $nombreGenero = $generoDAO->getGeneroById($idGenero); 
    
                $response = [
                    'success' => true,
                    'libro' => [
                        'id' => $id,
                        'titulo' => $titulo,
                        'resumen' => $resumen,
                        'isbn' => $isbn,
                        'edicion' => $edicion,
                        'autor_nombre' => $nombreAutor,
                        'genero_nombre' => $nombreGenero,
                        'foto' => $foto 
                    ]
                ];
    
                echo json_encode($response);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el libro']);
                exit;
            }
    }
    
    
    public function isLibroDisponible($idLibro) {
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();
        
        $libroDAO = new LibroDAO($conn);
        
        return $libroDAO->checkDisponibilidad($idLibro);
    }

    public function efectuarPrestamo() {
        // Verificar que la solicitud sea POST y que se haya enviado el libro_id
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['libro_id'])) {
            $libroId = $_POST['libro_id'];
    
            $usuario = Session::getUsuario();
            if (!$usuario) {
                echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
                exit;
            }
            $usuarioId = $usuario->getId(); 
    
            
            $prestamo = new Prestamo();
            $prestamo->setUsuarioId($usuarioId);
            $prestamo->setLibroId($libroId);
            $prestamo->setFechaPrestamo(date('Y-m-d')); 

    
            
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();
    
            try {
                $prestamoDAO = new PrestamoDAO($conn);
    
                
                $prestamoId = $prestamoDAO->insert($prestamo);
                if (!$prestamoId) {
                    throw new Exception('Error al insertar el préstamo');
                }
                $libroDAO = new LibroDAO($conn);
            if (!$libroDAO->marcarComoNoDisponible($libroId)) {
                throw new Exception('Error al marcar el libro como no disponible');
            }
    
                // Éxito: devolver una respuesta JSON indicando que el préstamo se realizó correctamente
                echo json_encode(['success' => true]);
                exit;
            } catch (Exception $e) {
                // Capturar cualquier excepción y devolver un mensaje de error JSON
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        } else {
            // Si la solicitud no es POST o falta el libro_id, devolver un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Método de solicitud incorrecto o falta el ID del libro']);
            exit;
        }
    }
    

    
    
    
}
