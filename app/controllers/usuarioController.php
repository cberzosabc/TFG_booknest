<?php
class UsuarioController
{
    public function verRegistro()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();
        require 'app/views/start.php';
    }

    public function registrar()
    {
        $error = '';
        $fotoPredeterminada = 'imagen-por-defecto.png'; //creamos una foto predeterminada por si el usuario no selecciona una
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Limpiamos los datos
            $nombre = $_POST['name'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $poblacion = $_POST['poblacion'];
            $rol = $_POST['rol'];
            $foto = '';

            //Conectamos con la BD
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            //Compruebo que no haya un usuario registrado con el mismo email
            $usuariosDAO = new UsuarioDAO($conn);
            if ($usuariosDAO->getByEmail($email) != null) {
                $error = "Ya hay un usuario con ese email";
            } elseif (empty($password)) {
                $error = "Introduce una contraseña";
            } elseif (strlen($password) < 6) {
                $error = "La contraseña debe tener, al menos, 6 dígitos";
            } else {
                if (
                    isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 &&
                    in_array($_FILES['foto']['type'], ['image/jpeg', 'image/webp', 'image/png'])
                ) {
                    // Procesamiento de la foto subida
                    $foto = generarNombreArchivo($_FILES['foto']['name']);
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosUsuarios/$foto")) {
                        $error = "Error al copiar la foto a la carpeta fotosUsuarios";
                        $foto = $fotoPredeterminada; // Usa la imagen predeterminada si falla
                    }
                } else {
                    // Si no se sube una foto, asigna la predeterminada
                    $foto = $fotoPredeterminada;
                }
                //Insertamos en la BD
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                //encriptamos el password
                $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                $usuario->setPassword($passwordCifrado);
                $usuario->setPoblacion($poblacion);
                $usuario->setFoto($foto);
                $usuario->setRol('user');
                $usuario->setSid(sha1(rand() + time()), true);

                if ($usuariosDAO->insert($usuario)) {
                    $idUsuario = $conn->insert_id; 
                    $usuario->setId($idUsuario);
                    Session::iniciarSesion($usuario);
                    header("location: index.php?action=inicio");

                    exit();
                } else {
                    $error = "No se ha podido insertar el usuario";
                }
            }
        }
    }
    public function registrarDesdeAdmin()
    {
        $error = '';
        $fotoPredeterminada = 'imagen-por-defecto.png'; //creamos una foto predeterminada por si el usuario no selecciona una
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Limpiamos los datos
            $nombre = $_POST['name'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $poblacion = $_POST['poblacion'];
            $rol = $_POST['rol'];
            $foto = '';

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();


            //Compruebo que no haya un usuario registrado con el mismo email
            $usuariosDAO = new UsuarioDAO($conn);
            if ($usuariosDAO->getByEmail($email) != null) {
                $error = "Ya hay un usuario con ese email";
            } elseif (empty($password)) {
                $error = "Introduce una contraseña";
            } elseif (strlen($password) < 6) {
                $error = "La contraseña debe tener, al menos, 6 dígitos";
            } else {
                if (
                    isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 &&
                    in_array($_FILES['foto']['type'], ['image/jpeg', 'image/webp', 'image/png'])
                ) {

                    // Procesamiento de la foto subida
                    $foto = generarNombreArchivo($_FILES['foto']['name']);
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosUsuarios/$foto")) {
                        $error = "Error al copiar la foto a la carpeta fotosUsuarios";
                        $foto = $fotoPredeterminada; // Usa la imagen predeterminada si falla
                    }
                } else {
                    // Si no se sube una foto, asigna la predeterminada
                    $foto = $fotoPredeterminada;
                }


                //Insertamos en la BD
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                //encriptamos el password
                $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                $usuario->setPassword($passwordCifrado);
                $usuario->setPoblacion($poblacion);
                $usuario->setFoto($foto);
                $usuario->setRol('user');
                $usuario->setSid(sha1(rand() + time()), true);

                if ($usuariosDAO->insert($usuario)) {
                    $idUsuario = $conn->insert_id; //Forzamos que inserte un id al usuario y no salga a null
                    $usuario->setId($idUsuario);
                    Session::iniciarSesion($usuario);
                    header("location: index.php?action=listaUsuarios");

                    exit();
                } else {
                    $error = "No se ha podido insertar el usuario";
                }
            }
        }
    }

    public function login()
    {
        //Volvemos a crear la conexion
        $conexion = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $conexion->getConnection();
        //Limpia los datos
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            //Valida el usuario 
            $usuarioDAO = new UsuarioDAO($conn);
            $usuario = $usuarioDAO->getByEmail($email);
            if ($usuario != null) {

                if (password_verify($password, $usuario->getPassword())) {
                    $sid = sha1(uniqid(rand(), true)); // Genera un nuevo SID aquí
                    $usuarioDAO->actualizarSid($usuario->getId(), $sid); // Actualiza el SID en la base de datos

                    // Establece la cookie 'sid' con el nuevo SID
                    setcookie('sid', $sid, time() + (86400 * 30), "/"); // Expira en 30 días

                    Session::iniciarSesion($usuario);

                    if ($usuario->getRol() === "Super-admin") {
                        $this->listaUsuarios();
                    } else {
                        header('location: index.php?action=inicio');
                    }
                } else {
                    mostrarMensaje("La contraseña no es correcta");
                }
            } else {
                mostrarMensaje("Usuario no encontrado");
            }
        }
    }
    public function verAdministracion()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();
        /*if(Session::existeSesion()){
                    header('location: index.php?accion=ver_inicio');
                    die();
                }*/
        require 'app/views/administracion.php';
    }
    public function listaUsuarios()
    {
        // Crear conexión a la base de datos
        $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connection->getConnection();

        // Crear instancia de UsuarioDAO
        $usuarioDAO = new UsuarioDAO($conn);

        // Obtener los usuarios ordenados
        $usuarios = $usuarioDAO->getAllUsers();

        // Cerrar la conexión
        $connection = null;

        // Pasar los resultados a la vista
        require 'app/views/listaUsuarios.php';
    }
    public function getUserByEmail($email)
    {
        // Verificar si se proporcionó un correo electrónico
        if (!isset($email) || empty($email)) {
            echo json_encode(array('error' => 'No se proporcionó un correo electrónico'));
            exit();
        }

        // Crear conexión a la base de datos
        $conexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $conexionDB->getConnection();

        // Crear instancia de UsuarioDAO
        $usuarioDAO = new UsuarioDAO($conn);

        // Obtener usuario por correo electrónico
        $usuario = $usuarioDAO->getByEmail($email);

        // Verificar si se encontró un usuario
        if ($usuario) {
            // Convertir el objeto usuario a un array asociativo
            $usuarioArray = array(
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'apellidos' => $usuario->getApellidos(),
                'email' => $usuario->getEmail(),
                'poblacion' => $usuario->getPoblacion(),
                'rol' => $usuario->getRol(),
                'foto' => $usuario->getFoto(),
            );

            // Devolver los datos del usuario en formato JSON
            echo json_encode($usuarioArray);
        } else {
            // Usuario no encontrado
            echo json_encode(array('error' => 'Usuario no encontrado'));
        }
    }

    public function deleteUser()
    {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            // Conectarse a la base de datos
            $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connection->getConnection();

            // Crear instancia de UsuarioDAO
            $usuarioDAO = new UsuarioDAO($conn);

            if ($usuarioDAO->eliminarUsuario($userId)) {
                $this->listaUsuarios();
                exit;
            } else {
                echo "Error al eliminar el usuario";
            }
        } else {
            echo "ID de usuario no proporcionado";
        }
    }
    public function logout()
    {

        $conexion = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $conexion->getConnection();


        $usuarioDAO = new UsuarioDAO($conn);

        $usuario = Session::getUsuario();
        if ($usuario != null) {

            $usuarioDAO->actualizarSid($usuario->getId(), null);
        }


        Session::cerrarSesion();
        setcookie('sid', '', time() - 3600, "/");

        header('location: index.php?action=verRegistro');
    }

    public function crearSuperAdmin()
    {
        $error = '';
        $fotoPredeterminada = 'imagen-por-defecto.png'; //creamos una foto predeterminada por si el usuario no selecciona una

        //Conectamos con la BD
        $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnection();
        //Compruebo que no haya un usuario registrado con el mismo email
        $usuariosDAO = new UsuarioDAO($conn);

        //Insertamos en la BD
        $usuario = new Usuario();
        $usuario->setNombre("Consuelo");
        $usuario->setApellidos("Berzosa");
        $usuario->setEmail("superadmin@booknest.es");
        //encriptamos el password
        $passwordCifrado = password_hash("booknest12345", PASSWORD_DEFAULT);
        $usuario->setPassword($passwordCifrado);
        $usuario->setFoto($fotoPredeterminada);
        $usuario->setPoblacion("Tomelloso");
        $usuario->setRol("Super-admin");
        $usuario->setSid(sha1(rand() + time()), true);

        if ($usuariosDAO->insert($usuario)) {
            $idUsuario = $conn->insert_id;
            $usuario->setId($idUsuario);
            Session::iniciarSesion($usuario);
            header("location: index.php?accion=ver_usuarios");
            die();
        } else {
            $error = "No se ha podido insertar el usuario";
        }
    }

    public function verPrestamosUsuario()
    {
        if (isset($_GET['id'])) {
            $usuarioId = $_GET['id'];
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            $usuarioDAO = new UsuarioDAO($conn);
            $usuario = $usuarioDAO->findById($usuarioId);

            $prestamoDAO = new PrestamoDAO($conn);
            $prestamos = $prestamoDAO->obtenerPrestamosPorUsuario($usuarioId);

            include 'app/views/verPrestamos.php';
        }
    }

    public function devolverLibro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prestamo_id'])) {
            $prestamoId = $_POST['prestamo_id'];
    
            // Conectar a la base de datos
            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();
    
            try {
                // Actualizar el estado del préstamo a 'devuelto'
                $prestamoDAO = new PrestamoDAO($conn);
                if (!$prestamoDAO->marcarComoDevuelto($prestamoId)) {
                    throw new Exception('Error al marcar el préstamo como devuelto');
                }
    
                // Obtener la fecha actual para actualizar la fecha de devolución esperada
                $fechaActual = date('Y-m-d');
                $prestamoDAO->actualizarFechaDevolucionEsperada($prestamoId, $fechaActual);
    
                // Éxito: devolver una respuesta JSON indicando que se devolvió el libro correctamente
                echo json_encode(['success' => true, 'fecha_devolucion' => 'Devuelto']);
                exit;
            } catch (Exception $e) {
                // Capturar cualquier excepción y devolver un mensaje de error JSON
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        } else {
            // Si la solicitud no es POST o falta el prestamo_id, devolver un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Método de solicitud incorrecto o falta el ID del préstamo']);
            exit;
        }
    }
    
    
    public function marcarPrestamoComoDevuelto()
    {
        if (isset($_GET['id'])) {
            $prestamoId = $_GET['id'];

            $connexionDB = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnection();

            $prestamoDAO = new PrestamoDAO($conn);

            try {
                $prestamoDAO->marcarComoDevuelto($prestamoId);
                header("Location: index.php?action=verPrestamosUsuario&id=" . $_SESSION['usuario_id']);
                exit;
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Falta el ID del préstamo']);
            exit;
        }
    }

    public function editarUsuario(){
        $id=$_POST['id'];
        $nombre=$_POST['nombre'];
        $apellidos=$_POST['apellidos'];
        $email=$_POST['email'];
        $foto = '';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Guardar la imagen y obtener el nombre
            $foto = generarNombreArchivo($_FILES['foto']['name']);
            move_uploaded_file($_FILES['foto']['tmp_name'], "web/images/fotosUsuarios/" . $foto);
        }
        $poblacion=$_POST['poblacion'];
        $rol=$_POST['rol'];

        // Conectar a la base de datos y actualizar el autor
        $connection = new ConnectionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connection->getConnection();
        $usuarioDAO=new UsuarioDAO($conn);

        $usuario=new Usuario();
        $usuario->setId($id);
        $usuario->setNombre($nombre);
        $usuario->setApellidos($apellidos);
        $usuario->setEmail($email);
        $usuario->setFoto($foto);
        $usuario->setPoblacion($poblacion);
        $usuario->setRol($rol);

        if($usuarioDAO->update($usuario)){
            $usuarioActualizado=$usuarioDAO->findById($id);

            $response=[
                'success'=>true,
                'usuario'=>[
                    'id'=>$id,
                    'nombre'=>$nombre,
                    'apellidos'=>$apellidos,
                    'email'=>$email,
                    'foto'=>$usuarioActualizado['foto'],
                    'poblacion'=>$poblacion,
                    'rol'=>$rol
                ]
                ];
                echo json_encode($response);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario']);
                    exit;
                }
        }
        public function sobreMi(){
            require 'app/views/sobreMi.php';
        }
    }


