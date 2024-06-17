<?php

require_once 'app/config/config.php';
require_once 'app/config/functions.php';
require_once 'app/models/connectionDB.php';
require_once 'app/models/usuario.php';
require_once 'app/models/usuarioDAO.php';
require_once 'app/controllers/usuarioController.php';
require_once 'app/models/libro.php';
require_once 'app/models/libroDAO.php';
require_once 'app/controllers/libroController.php';
require_once 'app/models/autor.php';
require_once 'app/models/autorDAO.php';
require_once 'app/controllers/autorController.php';
require_once 'app/models/genero.php';
require_once 'app/models/generoDAO.php';
require_once 'app/controllers/generoController.php';
require_once 'app/models/prestamo.php';
require_once 'app/models/prestamoDAO.php';
require_once 'app/controllers/prestamoController.php';
require_once 'app/models/session.php';
session_start();

$map = array(
    'inicio' => array(
        'controller' => 'LibroController',
        'method' => 'inicio',
        'private' => false,
    ),
    'verRegistro' => array(
        'controller' => 'UsuarioController',
        'method' => 'verRegistro',
        'private' => false,
    ),
    'login' => array(
        'controller' => 'UsuarioController',
        'method' => 'login',
        'private' => false,
    ),
    'registrar' => array(
        'controller' => 'UsuarioController',
        'method' => 'registrar',
        'private' => false,
    ),
    'registrarDesdeAdmin' => array(
        'controller' => 'UsuarioController',
        'method' => 'registrarDesdeAdmin',
        'private' => false,
    ),
    'create_superadmin' => array(
        'controller' => 'UsuarioController',
        'method' => 'crearSuperAdmin',
        'private' => true,
    ),
    'listaUsuarios' => array(
        'controller' => 'UsuarioController',
        'method' => 'listaUsuarios',
        'private' => true,
    ),
    'listaAutores' => array(
        'controller' => 'AutorController',
        'method' => 'listaAutores',
        'private' => true,
    ),
    'listaGeneros' => array(
        'controller' => 'GeneroController',
        'method' => 'listaGeneros',
        'private' => true,
    ),
    'deleteGenero' => array(
        'controller' => 'GeneroController',
        'method' => 'deleteGenero',
        'private' => true,
    ),
    'editarGenero' => array(
        'controller' => 'GeneroController',
        'method' => 'editarGenero',
        'private' => true,
    ),
    'editarLibro' => array(
        'controller' => 'LibroController',
        'method' => 'editarLibro',
        'private' => true,
    ),
    'editarUsuario' => array(
        'controller' => 'UsuarioController',
        'method' => 'editarUsuario',
        'private' => true,
    ),
    'deleteAutor' => array(
        'controller' => 'AutorController',
        'method' => 'deleteAutor',
        'private' => true,
    ),
    'editarAutor' => array(
        'controller' => 'AutorController',
        'method' => 'editarAutor',
        'private' => true,
    ),
    'deleteUser' => array(
        'controller' => 'UsuarioController',
        'method' => 'deleteUser',
        'private' => true,
    ),
    'deleteLibro' => array(
        'controller' => 'LibroController',
        'method' => 'deleteLibro',
        'private' => true,
    ),
    'logout' => array(
        'controller' => 'UsuarioController',
        'method' => 'logout',
        'private' => true,
    ),
     'registrarAutorDesdeLibros' => array(
        'controller' => 'AutorController',
        'method' => 'registrarAutorDesdeLibros',
        'private' => false,
    ), 
    'nuevoGeneroDesdeLibros' => array(
        'controller' => 'GeneroController',
        'method' => 'registrarGeneroDesdeLibros',
        'private' => false,
    ),
    'registrarGenero' => array(
        'controller' => 'GeneroController',
        'method' => 'registrar',
        'private' => false,
    ),
    'registrarLibros' => array(
        'controller' => 'LibroController',
        'method' => 'registrarLibros',
        'private' => false,
    ), 
    'verAdministracion'=>array(
        'controller'=>'UsuarioController',
        'method'=>'verAdministracion',
        'private'=>true,
    ),
    'verLibros' => array(
        'controller' => 'LibroController',
        'method' => 'verLibros',
        'private' => true
    ),
    'marcarPortada' => array(
        'controller' => 'LibroController',
        'method' => 'marcarPortada',
        'private' => true,
    ),
    'desmarcarPortada' => array(
        'controller' => 'LibroController',
        'method' => 'desmarcarPortada',
        'private' => true,
    ),
    'agregarAlCarrito' => array(
        'controller' => 'CarritoController',
        'method' => 'agregarAlCarrito',
        'private' => true,
    ),
    'quitarDelCarrito' => array(
        'controller' => 'CarritoController',
        'method' => 'quitarDelCarrito',
        'private' => true,
    ),
    'mostrarCarrito' => array(
        'controller' => 'CarritoController',
        'method' => 'mostrarCarrito',
        'private' => true,
    ),
    'todosLibros' => array(
        'controller' => 'LibroController',
        'method' => 'todosLibros',
        'private' => false,
    ),
    'verAutores' => array(
        'controller' => 'AutorController',
        'method' => 'verAutores',
        'private' => false,
    ),
    'verGeneros' => array(
        'controller' => 'GeneroController',
        'method' => 'verGeneros',
        'private' => false,
    ),
    'librosPorAutor' => array(
        'controller' => 'LibroController',
        'method' => 'librosPorAutor',
        'private' => false,
    ),
    'librosPorGenero' => array(
        'controller' => 'LibroController',
        'method' => 'librosPorGenero',
        'private' => false,
    ),
    'efectuarPrestamo' => array(
        'controller' => 'LibroController',
        'method' => 'efectuarPrestamo',
        'private' => true,
    ),
    'verPrestamosUsuario' => [
        'controller' => 'UsuarioController',
        'method' => 'verPrestamosUsuario',
        'private' => true,
    ],
    'devolverLibro' => [
        'controller' => 'UsuarioController',
        'method' => 'devolverLibro',
        'private' => true,
    ],
    'sobreMi' => [
        'controller' => 'UsuarioController',
        'method' => 'sobreMi',
        'private' => false,
    ],

);

if (isset($_GET['action'])) {
    if (isset($map[$_GET['action']])) {
        $action = $_GET['action'];
    } else {
        header('Status: 404 Not found');
        echo 'Page not found';
        die();
    }
} else {
    $action = 'inicio';
}

if(isset($_GET['action']) && $_GET['action'] == 'getUserByEmail' && isset($_GET['email'])) {
    $controller = new UsuarioController();
    $controller->getUserByEmail($_GET['email']);
    exit(); 
}
//Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
//if( !isset($_SESSION['email']) && isset($_COOKIE['sid'])){
    if( !Session::existeSesion() && isset($_COOKIE['sid'])){
        //Conectamos con la bD
        $connexionDB = new ConnectionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnection();
        
        //Nos conectamos para obtener el id y la foto del usuario
        $usuariosDAO = new UsuarioDAO($conn);
        if($usuario = $usuariosDAO->getBySid($_COOKIE['sid'])){
            //$_SESSION['email']=$usuario->getEmail();
            //$_SESSION['id']=$usuario->getId();
            //$_SESSION['foto']=$usuario->getFoto();
            Session::iniciarSesion($usuario);
        }
        
    }
    
    //Si la acción es privada compruebo que ha iniciado sesión, sino, lo echamos a index
    // if(!isset($_SESSION['email']) && $mapa[$accion]['privada']){
    if(!Session::existeSesion() && $map[$action]['private']){
        header('location: index.php');
        guardarMensaje("Debes iniciar sesión para acceder a $action");
        die();
    }
    
$controller = $map[$action]['controller'];
$method = $map[$action]['method'];

$object = new $controller();
$object->$method();
