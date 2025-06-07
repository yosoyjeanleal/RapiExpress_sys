<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RapiExpress - Registro</title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/password-validation.css" />
    <link rel="stylesheet" href="vendor/twbs/bootstrap/css/core.css" />
    <link rel="stylesheet" href="vendor/twbs/bootstrap/css/icon-font.min.css" />
    <link rel="stylesheet" href="vendor/twbs/bootstrap/css/style.css" />
    <link rel="stylesheet" href="assets/css/password-validation.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="login-page">

    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="#"><img src="assets/img/logo.png" alt="RapiExpress Logo" /></a>
            </div>
        </div>
    </div>

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="assets/img/login-page-img.png" alt="Imagen de registro" class="img-fluid" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10 p-4">
                        <div class="login-title mb-4">
                            <h2 class="text-center text-primary">Registro RapiExpress</h2>
                        </div>

<?php
// Mostrar mensajes de error/success solo cuando corresponda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($error)) {
        echo '<div class="alert alert-danger mt-3">'.$error.'</div>';
    }
    if (isset($success)) {
        echo '<div class="alert alert-success mt-3">'.$success.'</div>';
    }
}
?> 
                        <form method="POST" action="index.php?c=auth&a=register">
                            <!-- Datos de identificación -->
                            <div class="form-section">
                                <h5 class="form-section-title">Datos de Identificación</h5>
                                <div class="input-group custom mb-3">
                                    <input name="documento" class="form-control form-control-lg" placeholder="C.I/DNI/C.C" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-id-card"></i></span>
                                    </div>
                                </div>
                                <div class="input-group custom mb-3">
                                    <input name="username" class="form-control form-control-lg" placeholder="Nombre de Usuario" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Datos personales -->
                            <div class="form-section">
                                <h5 class="form-section-title">Datos Personales</h5>
                                <div class="input-group custom mb-3">
                                    <input name="nombres" class="form-control form-control-lg" placeholder="Nombres" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                    </div>
                                </div>
                                <div class="input-group custom mb-3">
                                    <input name="apellidos" class="form-control form-control-lg" placeholder="Apellidos" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Datos de contacto -->
                            <div class="form-section">
                                <h5 class="form-section-title">Datos de Contacto</h5>
                                <div class="input-group custom mb-3">
                                    <input name="email" type="email" class="form-control form-control-lg" placeholder="Correo electrónico" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-email"></i></span>
                                    </div>
                                </div>
                                <div class="input-group custom mb-3">
                                    <input name="telefono" type="text" class="form-control form-control-lg" placeholder="Teléfono" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-smartphone-1"></i></span>
                                    </div>
                                </div>
                                <div class="input-group custom mb-3">
                                    <select name="sucursal" class="form-control form-control-lg" required>
                                        <option value="" disabled selected>Seleccione su sucursal</option>
                                        <option value="sucursal_usa">Sucursal Estados Unidos</option>
                                        <option value="sucursal_ec">Sucursal Ecuador</option>
                                        <option value="sucursal_ven">Sucursal Venezuela</option>
                                    </select>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-location"></i></span>
                                    </div>
                                </div>
                                <div class="input-group custom mb-3">
                                    <select name="cargo" class="form-control form-control-lg" required>
                                        <option value="" disabled selected>Seleccione su cargo</option>
                                        <option value="encargado_bodega">Encargado de Bodega</option>
                                        <option value="jefe_logística">Jefe de logística</option>
                                        <option value="jefe_operaciones">Jefe de Operaciones</option>
                                    </select>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Seguridad -->
                                <div class="form-section">
  <h5 class="form-section-title">Seguridad</h5>
  <div class="input-group custom mb-4">
    <input name="password" type="password" class="form-control form-control-lg password-input" placeholder="Contraseña" required>
    <div class="input-group-append custom toggle-password" style="cursor: pointer;">
      <span class="input-group-text"><i class="fa fa-eye"></i></span>
    </div>
  </div>
</div>



                            <!-- Botones -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Registrarse</button>
                                    </div>
                                    <div class="text-center font-16 weight-600 pt-2 pb-2" data-color="#707373">
                                        O
                                    </div>
                                    <div class="input-group mb-0">
                                        <a href="index.php?c=auth&a=login" class="btn btn-outline-primary btn-lg btn-block">¿Ya tienes cuenta? Iniciar sesión</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- login-box -->
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="assets/js/password_view.js"></script>
    <script src="assets/js/password-validation.js"></script>
    <script src="vendor/twbs/bootstrap/js/core.js"></script>
    <script src="vendor/twbs/bootstrap/js/script.min.js"></script>
    <script src="vendor/twbs/bootstrap/js/layout-settings.js"></script>
    <script src="assets/js/script.js"></script>
    
    
</body>
</html>
