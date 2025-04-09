<?= $this->extend('dashboard/template.php'); ?>
<?= $this->section('titulo'); ?>
Bienvenid@
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
                <h3>150</h3>
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
                <h3>53<sup style="font-size: 20px">%</sup></h3>

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
              Sales
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                </li>
              </ul>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content p-0">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart"
                style="position: relative; height: 300px;">
                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
              </div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->



      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-4 connectedSortable">

        <!-- Map card -->
        <div class="card bg-gradient-primary d-none">
          <div class="card-header border-0">
            <h3 class="card-title">
              <i class="fas fa-map-marker-alt mr-1"></i>
              Visitors
            </h3>
            <!-- card tools -->
            <div class="card-tools">
              <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                <i class="far fa-calendar-alt"></i>
              </button>
              <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <div class="card-body">
            <div id="world-map" style="height: 250px; width: 100%;"></div>
          </div>
          <!-- /.card-body-->
          <div class="card-footer bg-transparent">
            <div class="row">
              <div class="col-4 text-center">
                <div id="sparkline-1"></div>
                <div class="text-white">Visitors</div>
              </div>
              <!-- ./col -->
              <div class="col-4 text-center">
                <div id="sparkline-2"></div>
                <div class="text-white">Online</div>
              </div>
              <!-- ./col -->
              <div class="col-4 text-center">
                <div id="sparkline-3"></div>
                <div class="text-white">Sales</div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.card -->

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
            <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>

          </div>
        </div>

      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<?= $this->endsection() ?>

<?php $this->section('scripts') ?>
<script src="<?= base_url('public/plugins//moment/moment.min.js') ?>"></script>
<script src="<?= base_url('public/plugins//daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= base_url('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('public/dist/js/demo.js') ?>"></script>
<script src="<?= base_url('public/dist/js/pages/dashboard.js') ?>"></script>
<?php $this->endSection() ?>