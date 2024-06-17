<?php include 'templates/head.php'; ?>

<body>

    <?php include 'templates/menu.php'; ?>

    <div class="container mt-3">
        <div id="carouselExampleIndicators" class="o-carousel__inicio carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="web/images/img/bridgerton.webp" alt="Colección bridgerton">
                    <div class="carousel-caption d-none d-md-block">
    <h5>¡Engánchate a Lady Whistledown!</h5>
    <p>Disfruta de los libros de la serie del momento</p>
  </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="web/images/img/novelas-y-cuentos-de-terror-1.jpg" alt="Novelas y cuentos de terror">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="web/images/img/biblioteca.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="row mt-5">
            <?php if (!empty($librosPortada)) : ?>
            <?php foreach ($librosPortada as $libro) : ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <img class="card-img-top"
                        src="web/images/fotosPortadas/<?= htmlspecialchars($libro['foto_portada']); ?>"
                        alt="Portada del libro">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($libro['titulo']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($libro['autor_nombre'] . ' ' . $libro['autor_apellidos']); ?></p>
                        <?php if ($libro['disponible']) : ?>
                        <button class="agregar-prestamo btn " data-libro-id="<?= $libro['id']; ?>">Efectuar préstamo</button>
                        <?php else : ?>
                        <p class="text-danger">Libro prestado</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else : ?>
            <div class="col-12">
                <p>No se encontraron libros en portada.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
    <?php include 'templates/footer.php'; ?>
    <?php include 'templates/scripts.php'; ?>


</body>

</html>