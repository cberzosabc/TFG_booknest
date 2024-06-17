<?php 
include 'templates/head.php'; 
$librosPorPagina = 16;
$totalLibros = count($libros);
$totalPaginas = ceil($totalLibros / $librosPorPagina);

$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;


$indiceInicial = ($paginaActual - 1) * $librosPorPagina;
$indiceFinal = $indiceInicial + $librosPorPagina - 1;

$librosPagina = array_slice($libros, $indiceInicial, $librosPorPagina);
?>

<body>
    <?php if (isset($_SESSION['mensaje_error'])) : ?>
        <p class="error"><?= $_SESSION['mensaje_error']; ?></p>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>
    <?php include 'templates/menu.php'; ?>

    <div class="container mt-4">
    <div class="c-links__goBack">
        <a href="#" id="enlaceVolver">Volver atrás</a>
        </div>
        <div class="row">
            <?php foreach ($librosPagina as $libro) : ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <img class="card-img-top"
                        src="web/images/fotosPortadas/<?= htmlspecialchars($libro['foto_portada']); ?>"
                        alt="Portada del libro">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($libro['titulo']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($libro['autor_nombre'] . ' ' . $libro['autor_apellidos']); ?></p>
                        <?php if ($libro['disponible']) : ?>
                        <button class="agregar-prestamo btn btn-primary" data-libro-id="<?= $libro['id']; ?>">Efectuar préstamo</button>
                        <?php else : ?>
                        <p class="text-danger">Libro prestado</p>
                        <?php endif; ?>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación dinámica -->
        <?php if ($totalPaginas > 1) : ?>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($paginaActual > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?= ($paginaActual - 1); ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                <li class="page-item <?= ($i == $paginaActual) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?pagina=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($paginaActual < $totalPaginas) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?= ($paginaActual + 1); ?>">Siguiente</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'templates/scripts.php'; ?>
</body>
</html>
