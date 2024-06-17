<header>
    <nav class="c-menu__navbar navbar navbar-expand-lg">
        <a class="c-menu__navbar-logo navbar-brand" href="index.php?action=inicio">
            <img src="web/images/img/fondo_menu.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
            <i class="uil uil-bars"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?action=inicio">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=todosLibros">Libros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mi-elemento" href="index.php?action=verAutores">Autores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mi-elemento" href="index.php?action=verGeneros">Géneros</a>
                </li>
                <?php if (Session::existeSesion() && (Session::getUsuario()->getRol() === "admin" || Session::getUsuario()->getRol() === "Super-admin")) : ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=verAdministracion">Administración</a></li>
                <?php endif; ?>
            </ul>
            <?php if (Session::getUsuario()) : ?>
                <img class="c-login__fotoSession" src="web/images/fotosUsuarios/<?= Session::getUsuario()->getFoto() ?>" class="fotoUsuario">
                <p class="c-login__logOut"><a href="index.php?action=logout"><i class="fa-solid fa-right-from-bracket"></i></a></p>
            <?php else : ?>
                <a href="index.php?action=verRegistro"><i class="fa fa-user" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div>
    </nav>
</header>