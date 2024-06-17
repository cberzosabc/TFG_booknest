<?php include 'templates/head.php'; ?>

<body class="c-login">
    <?php include 'templates/menu.php'; ?>

    <div class=".c-login__section">
        <div class="container">
            <div class="row c-login__section--full-height">
                <div class="col-12 text-center align-self-center">
                    <h4>Inicia sesión o regístrate</h4>
                    <div class="section pb-5 pt-5 pt-sm-2 text-center">
                        <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
                        <label for="reg-log"><i class="fa fa-arrow-up" aria-hidden="true"></i></label>
                        <div class="o-card__3d--wrap mx-auto">
                            <div class="o-card__3d--wrapper">
                                <div class="o-card__front">
                                    <div class="center-wrap">
                                        <form action="index.php?action=login" method="POST">
                                            <div class="section text-center">
                                                <div class="form-group">
                                                    <input type="email" name="email" class="o-input__form" placeholder="Email">
                                                    <i class="o-input__icon uil uil-at"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="o-input__form" placeholder="Password">
                                                    <i class="o-input__icon uil uil-lock-alt"></i>
                                                </div>
                                                <button type="submit" class="o-button__btn-login btn mt-4">Entrar</button>
                                                <br>
                                                <?php if (isset($_SESSION['mensaje_error'])) : ?>
                                                    <p class="error text-danger "><?= $_SESSION['mensaje_error']; ?></p>
                                                    <?php unset($_SESSION['mensaje_error']); ?>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="o-card__back">
                                    <div class="center-wrap">
                                        <form action="index.php?action=registrar" method="POST" enctype="multipart/form-data">
                                            <div class="section text-center">
                                                <div class="form-group">
                                                    <input type="text" name="name" class="o-input__form" placeholder="Nombre">
                                                    <i class="o-input__icon uil uil-user"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="text" name="apellidos" class="o-input__form" placeholder="Apellidos">
                                                    <i class="o-input__icon uil uil-user"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="email" name="email" class="o-input__form" placeholder="Email">
                                                    <i class="o-input__icon uil uil-at"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="o-input__form" placeholder="Password">
                                                    <i class="o-input__icon uil uil-lock-alt"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <select name="poblacion" class="four-boot-select" title="Poblacion" id="">
                                                        <option value="Alcazar">Alcázar de San Juan</option>
                                                        <option value="Argamasilla">Argamasilla de Alba</option>
                                                        <option value="Criptana">Campo de Criptana</option>
                                                        <option value="Herencia">Herencia</option>
                                                        <option value="Socuellamos">Socuellamos</option>
                                                        <option value="Tomelloso">Tomelloso</option>
                                                    </select>
                                                    <i class="o-input__icon uil uil-building"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="file" name="foto" class="o-input__form">
                                                    <i class="o-input__icon uil uil-image"></i>

                                                </div>
                                                <button type="submit" class="o-button__btn-login btn mt-4">Entrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="web/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="web/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="web/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="web\node_modules\four-boot\dist\JQuery.four-boot.min.js"></script>
    <script src="web/js/index.js"></script>
</body>

</html>