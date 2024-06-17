<?php 
include 'templates/head.php'; 


$autoresPorPagina = 10;
$totalAutores = count($autores);
$totalPaginas = ceil($totalAutores / $autoresPorPagina); 


$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;


$indiceInicial = ($paginaActual - 1) * $autoresPorPagina;
$indiceFinal = $indiceInicial + $autoresPorPagina - 1;

$autoresPagina = array_slice($autores, $indiceInicial, $autoresPorPagina);
?>

<body>
    <?php if (isset($_SESSION['mensaje_error'])) : ?>
        <p class="error"><?= $_SESSION['mensaje_error']; ?></p>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>
    <?php include 'templates/menu.php'; ?>

    <div class="container mt-4">
    <h1 class="p-3">Listado de autores</h1>
        <div class="row">
            <?php foreach ($autoresPagina as $autor) : ?>
                <div class="col-6 col-md-4 col-lg-3 mb-3">
                <a href="index.php?action=librosPorAutor&autor_id=<?= htmlspecialchars($autor['id']); ?>" class="btn o-button__listados btn-block">
        <?= htmlspecialchars($autor['nombre'] . ' ' . $autor['apellidos']); ?>
    </a>

                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación dinámica -->
        <?php if ($totalPaginas > 1) : ?>
            <div class="row mt-4">
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
