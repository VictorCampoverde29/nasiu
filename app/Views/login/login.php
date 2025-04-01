<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GASIU - Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Estilos -->
  <link rel="stylesheet" href="<?= base_url('public/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/sweetalert2/sweetalert2.min.css'); ?>">
  <link rel="icon" type="image/png" href="<?= base_url('public/dist/img/favicon.png') ?>" />
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-body login-card-body">
        <p class="login-box-msg">
          <img src="<?= base_url('public/dist/img/logo/logogasiu.png') ?>" alt="Logo de la empresa" class="mb-3" style="max-width: 250px;">
        </p>

        <!-- Selector de usuario -->
        <div class="input-group mb-3">
          <select id="cmbusuario" name="cmbusuario" class="form-control">
            <?php foreach ($usuarios as $usuariosreg): ?>
              <option value="<?= esc($usuariosreg['idusuarios']); ?>">
                <?= esc($usuariosreg['usuario']); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- Campo de contraseña -->
        <div class="input-group mb-3">
          <input type="password" id="txtpassword" name="txtpassword" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span id="togglePassword" class="fas fa-eye" style="cursor: pointer;"></span>
            </div>
          </div>
        </div>

        <!-- Botón de inicio de sesión -->
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-primary btn-block" onclick="loguear()">
              <span class="fas fa-key"></span> INGRESAR AL SISTEMA
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- jQuery y Scripts -->
  <script src="<?= base_url('public/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
  <script src="<?= base_url('public/dist/js/adminlte.min.js') ?>"></script>
  <script src="<?= base_url('public/dist/js/pages/login.js') ?>"></script>
  <script>
    var URLPY = '<?= base_url(); ?>';
  </script>
</body>

</html>