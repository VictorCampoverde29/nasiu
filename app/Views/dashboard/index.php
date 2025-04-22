<?= $this->extend('dashboard/template.php'); ?>
<?= $this->section('titulo'); ?>
Bienvenid@
<?= $this->endsection() ?>

<?= $this->section('styles'); ?>
  <link rel="stylesheet" href="<?= base_url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->

    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-8 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="row">
          <div class="col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><sup style="font-size: 20px">S/.</sup> <?= number_format($mtoventas, 2) ?></h3>
                <p>Ventas Mes</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><sup style="font-size: 20px">S/.</sup> <?= number_format($mtocompras, 2) ?></h3>
                <p>Compras Mes</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-cart"></i>
              </div>

            </div>
          </div>

          <!-- ./col -->
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Compras y Ventas
            </h3>
           
          </div><!-- /.card-header -->
          <div class="card-body">
          <?php if (array_sum($compras) == 0 && array_sum($ventas) == 0): ?>
            <div class="alert alert-danger">No hay datos disponibles para mostrar el gráfico</div>
          <?php else: ?>  
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">S/.<?= number_format($mtoventas,2) ?></span>
                    <span>VENTAS MES ACTUAL</span>
                  </p>                  
                </div>
                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>
                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> COMPRAS
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> VENTAS
                  </span>
                </div>
              </div>
              <?php endif;?>  
        </div>
        <!-- /.card -->



      </section>

      <section class="col-lg-4 connectedSortable">
        <div class="card card-primary card-outline shadow-none">
          <div class="card-header border-0">

            <h3 class="card-title">
              <i class="fas fa-computer"></i>
              Inicio de Sesión
            </h3>

          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0">
            <!--The calendar -->
            <div class="row">
              <div class="col-3">
                <h6><b>FECHA:</b></h6>
              </div>
              <div class="col-9">
                <h7><?php echo date('d/m/Y h:i a'); ?></h7>
              </div>

            </div>
            <div class="row">

              <div class="col-3">
                <h6><b>NOMBRE:</b></h6>
              </div>
              <div class="col-9">
                <h7><?= esc(session()->get('nombrepersonal')); ?></h7>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h6><b>PERFIL:</b></h6>
              </div>
              <div class="col-9">
                <h7><?= esc(session()->get('nombreusuariocorto')); ?></h7>
              </div>

            </div>
            <div class="row"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card bg-gradient-warning">
          <div class="card-header border-0">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Situación Actual
            </h3>
          </div>
          <div class="card-body pt-0">
          <?php if (array_sum($compras) == 0 && array_sum($ventas) == 0): ?>
              <div class="alert alert-danger">No hay datos disponibles para mostrar el gráfico</div>
          <?php else: ?>
            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          <?php endif; ?>
          </div>
        </div>

      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>

<?php if (esc(session()->get('perfil'))==='SP CARROS'):  ?>
 <div class="modal fade" id="modal-documentacion">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Documentación por Vencer:</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <table id="tblunidades" class="table table-bordered table-striped">
                    <thead>
                    <tr  style="background-color: #000000; color:#FFFFFF;">
                      <th>Unidad</th>
                      <th>Documento</th>
                      <th>Numero</th>
                      <th>Fecha Vencimiento</th>
                    </tr>
                    </thead>
                  <tbody>
                  </tbody>
                  </table>
              </div>
          </div>
        </div>
</div>
<?php endif; ?>
<?= $this->endsection() ?>

<?php $this->section('scripts') ?>
<script src="<?= base_url('public/plugins//moment/moment.min.js') ?>"></script>
<script src="<?= base_url('public/plugins//daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= base_url('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('public/plugins/jszip/jszip.min.js')?>"></script>
<script src="<?= base_url('public/plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?= base_url('public/plugins/pdfmake/vfs_fonts.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>
<script src="<?= base_url('public/dist/js/pages/dashboard.js') ?>"></script>
<script type="text/javascript">
    var donutData = {
      labels: [
        'COMPRAS',
        'VENTAS'
      ],
      datasets: [{
        data: [<?=  $mtocompras; ?>, <?= $mtoventas; ?>],
        backgroundColor: ['#f56954', '#00a65a'],
      }]
    }



    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = donutData;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
  </script>
<script type="text/javascript">
  $(function () {
    'use strict'
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: ['ENE','FEB','MAR','ABR','MAY','JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'],
        datasets: [
          {
            label: 'COMPRAS',
            backgroundColor: '#f56954',
            borderColor: '#f56954',
            borderWidth: 2,
            data: <?= json_encode($compras) ?>
          },
          {
            label: 'VENTAS',
            backgroundColor: '#00a65a',
            borderColor: '#00a65a',
            borderWidth: 2,
            data: <?= json_encode($ventas) ?>
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: true
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, 0.2)',
              zeroLineColor: 'red'
            },
            ticks: $.extend({
              beginAtZero: true,
              callback: function (value) {
                return 'S/.' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: true
            },
            ticks: ticksStyle
          }]
        }
      }
    });
  });
</script>

<?php $this->endSection() ?>