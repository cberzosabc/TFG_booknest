<?php include 'templates/head.php'; ?>

<body>
    <?php if (isset($_SESSION['mensaje_error'])) : ?>
        <p class="error"><?= $_SESSION['mensaje_error']; ?></p>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>
    <?php include 'templates/menu.php'; ?>

    
    <div class="container mt-4">
    <h3 class="text-center mb-5">Bienvenido a tu zona de administración</h3>
    <a class="btn o-button__btn-green" href="index.php?action=listaUsuarios">Ver usuarios</a>
        <a class="btn o-button__btn-green" href="index.php?action=verLibros">Ver libros</a>
        
        <a class="btn o-button__btn-green" href="index.php?action=listaAutores">Ver autores</a>
        <a class="btn o-button__btn-green" href="index.php?action=listaGeneros">Ver géneros</a>
    </div>
    <?php include 'templates/scripts.php'; ?>
</body>

</html>