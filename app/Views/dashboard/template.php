<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>G.ASIU | Dashboard</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url('public/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="<?= base_url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/jqvmap/jqvmap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/daterangepicker/daterangepicker.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/summernote/summernote-bs4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/sweetalert2/sweetalert2.min.css'); ?>">
  <?= $this->renderSection('styles'); ?>
  <link rel="icon" type="image/png" href="<?= base_url('public/dist/img/favicon.png') ?>" />
</head>

<body class="layout-navbar-fixed sidebar-collapse layout-fixed text-sm">
  <div class="wrapper">

    <!-- 
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= base_url('public/dist/img/logo/logogasiu.png') ?>" alt="AdminLTELogo" height="80" width="130">
  </div> -->



    <!-- /.navbar -->
    <?= $this->include('Views/dashboard/nav') ?>
    <?= $this->include('Views/dashboard/aside') ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $this->renderSection('titulo'); ?> </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <h5><i class="fa fa-building"></i> <?= esc(session()->get('n_sucursal') ?? '----') ?> / <i class="fa fa-home"></i> <?= esc(session()->get('nombrealmacen') ?? '----') ?> </h5>
                </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <?= $this->renderSection('content'); ?>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
   <?= $this->include('Views/dashboard/footer') ?>

    <div class="modal fade" id="modal-cambio">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Elergir Almacén:</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Empresa:</label>
              <select class="form-control form-control-sm" id="cmbempresa" name="cmbempresa"></select>
            </div>
            
              <div class="form-group">
                <label>Sucursal:</label>
                <select class="form-control form-control-sm" id="cmbsucursal" name="cmbsucursal"></select>
              </div>
              <div class="form-group">
                <label>Almacén:</label>
                <select class="form-control form-control-sm" id="cmbalmacen" name="cmbalmacen"></select>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="cambio_almacen()"><i class="fa fa-arrows-rotate"></i> Cambiar Almacén</button>
          </div>
          
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-clave">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">CAMBIO DE CLAVE:</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="login-box-msg">Necesita indicar la nueva clave que utilizara para poder cambiarla.</p>

      
     
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Nueva Clave" id="txtclave" name="txtclave">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4"></div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block" onclick="actualizar_password()"><i class="fa-solid fa-user-lock"></i> Cambiar Clave</button>
              </div>
              <!-- /.col -->
            </div>

          </div>

       
        </div>
      </div>
    </div>
  </div>
  <!-- ./wrapper -->
  <script>
    var baseURL = '<?= base_url(); ?>';
  </script>
  <script>
    var codalmacenses = "<?= session()->get('codigoalmacen') ?? 'NL' ?>";
  </script>
  <!-- jQuery -->
  <script src="<?= base_url('public/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('public/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
  <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
  <script src="<?= base_url('public/dist/js/adminlte.js') ?>"></script>
  <script src="<?= base_url('public/dist/js/pages/generales.js') ?>"></script>
  <?= $this->renderSection('scripts'); ?>

</body>

</html>