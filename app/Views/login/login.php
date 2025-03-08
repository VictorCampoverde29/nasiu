<!doctype html>

<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>GASIU - Login</title>
  <!-- CSS files -->

  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabler.min.css?1738096682')?>" />
  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-flags.min.css?1738096682')?>" />
  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-socials.min.css?1738096682')?>"  />
  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-payments.min.css?1738096682')?>"  />
  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-vendors.min.css?1738096682')?>"  />
  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabler-marketing.min.css?1738096682')?>" />
  <link rel="stylesheet" href="<?= base_url('public/dist/css/demo.min.css?1738096682')?>"  />
  <link rel="stylesheet" href="<?= base_url('public/dist/libs/sweetalert2/dist/sweetalert2.min.css')?>"  />
  <style>
    @import url('https://rsms.me/inter/inter.css');
  </style>
</head>

<body class=" d-flex flex-column bg-white">
  <script src="<?= base_url('public/dist/js/demo-theme.min.js?1738096682')?>"></script>
  <div class="row g-0 flex-fill">
    <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
      <div class="container container-tight my-5 px-lg-5">
       
        <h2 class="h3 text-center mb-3">
          INGRESE SUS DATOS
        </h2>
    
          <div class="mb-3">
            <label class="form-label">Empresa</label>
            <select class="form-select" id="cmbempresa" name="cmbempresa">
              <?php foreach ($empresas as $empresasreg): ?>
                <option value="<?= esc($empresasreg['idempresa']); ?>">
                  <?= esc($empresasreg['nombre']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Sucursal</label>
            <select class="form-select" id="cmbsucursal" name="cmbsucursal"></select>
          </div>
          <div class="mb-3">
            <label class="form-label">Almacén</label>
            <select class="form-select" id="cmbalmacen" name="cmbalmacen"></select>
          </div>
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <select class="form-select" id="cmbusuario" name="cmbusuario">
              <?php foreach ($usuarios as $usuariosreg): ?>
                <option value="<?= esc($usuariosreg['usuario']); ?>">
                  <?= esc($usuariosreg['usuario']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
            <div class="mb-2">
                <label class="form-label">Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control" id="txtpassword" placeholder="Su password" autocomplete="off">
                  <span class="input-group-text">
                    <a href="#" id="togglePassword" class="link-secondary" title="Mostrar password" data-bs-toggle="tooltip">
                      <!-- Icono de ojo abierto -->
                      <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                      </svg>
                      <!-- Icono de ojo cerrado (oculto por defecto) -->
                      <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                        <line x1="3" y1="3" x2="21" y2="21"/>
                      </svg>
                    </a>
                  </span>
                </div>
            </div>

         
          <div class="form-footer">
            <button class="btn btn-primary w-100" onclick="loguear_sistema()">Ingresar al Sistema</button>
          </div>
      
        <div class="text-center text-secondary mt-3">
          Todos los Derechos Reservados <a href="https://grupoasiu.com" tabindex="-1">Grupo Asiu</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
      <!-- Photo -->
      <div class="bg-cover h-100 min-vh-100" style="background-image: url(<?= base_url('public/static/photos/finances-us-dollars-and-bitcoins-currency-money-2.jpg')?>)"></div>
    </div>
  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="<?= base_url('public/dist/js/tabler.min.js?1738096682') ?>" defer></script>
  <script src="<?= base_url('public/dist/js/demo.min.js?1738096682') ?>" defer></script>
  <script src="<?= base_url('public/dist/libs/jquery/jquery-3.7.1.min.js')?>"></script>
  <script src="<?= base_url('public/dist/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
  <script src="<?= base_url('public/dist/js/paginas/login.js')?>"></script>
  <script> var URLPY='<?=base_url();?>'; </script>
</body>
</html>