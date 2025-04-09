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
                  <h5><i class="fa fa-building"></i> <?= esc(session()->get('n_sucursal') ?? '----') ?> / <i class="fa fa-home"></i> <?= esc(session()->get('nombrealmacen') ?? '----') ?>  </h5>
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
    <footer class="main-footer text-sm">
      <strong>Copyright &copy; 2018-<?php echo date('Y') ?> <a href="https://www.facebook.com/profile.php?id=100093616365707">Victor Campoverde Vega</a>.</strong>
      Todos los Derechos Reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?= $version ?>
      </div>
    </footer>

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
            <form action="acceso/cambioalmacen" method="post">
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
            <button type="sumbit" class="btn btn-primary"><i class="fa fa-arrows-rotate"></i> Cambiar Almacén</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- ./wrapper -->
  <script>
    var baseURL = '<?= base_url(); ?>';
  </script>
  <script>
    var codalmacenses="<?= session()->get('codigoalmacen')??'NL' ?>";
  </script>              
  <!-- jQuery -->
  <script src="<?= base_url('public/plugins/jquery/jquery.min.js') ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('public/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <!-- ChartJS -->



  <!-- Tempusdominus Bootstrap 4 -->

  <!-- Summernote -->

  <!-- overlayScrollbars -->
  <script src="<?= base_url('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
  <script src="<?= base_url('public/dist/js/adminlte.js') ?>"></script>
  <script src="<?= base_url('public/dist/js/pages/generales.js') ?>"></script>
  <?= $this->renderSection('scripts'); ?>

</body>

</html>