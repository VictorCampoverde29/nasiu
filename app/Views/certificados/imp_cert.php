<?= $this->extend('dashboard/template') ?>
<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('public/plugins/daterangepicker/daterangepicker.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">





<?= $this->endsection() ?>
<?= $this->section('content') ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Certificados Generados por Fechas </h3>

          </div>

          <div class="card-body">
            <div>
              <div class="form-group">
                <label>RANGO DE FECHAS:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservation">
                </div>
                <!-- /.input group -->
              </div>
            </div>
            <div class="table-responsive">
            


              <table id="tblcertificados" class="table table-bordered table-hover">
                <thead>
                  <tr style="background-color: #000000; color:#FFFFFF;">
                    <th></th>
                    <th>EXPEDIENTE</th>
                    <th>FECHA</th>
                    <th>MODELO</th>
                    <th>CILINDRADA</th>
                    <th>POTENCIA</th>
                    <th>COLOR</th>
                    <th>AÑO</th>
                    <th>A_FABRICACION</th>
                    <th>VERSION</th>
                    <th>MOTOR</th>
                    <th>CHASIS</th>

                  </tr>
                </thead>
                <tbody>
                  <!-- Datos de la tabla -->
                </tbody>

              </table>
            </div>
          </div>
          <div class="card-footer text-left">
            <button id="btnImprimirTodos" class="btn btn-primary" onclick="imprimirTodos()" style="display: none;">
              <i class="fas fa-print"></i> Imprimir Todos
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endsection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('public/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/daterangepicker/daterangepicker.js') ?>"></script>

<script src="<?= base_url('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('public/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<script>
  $(function() {
    // Configurar idioma en español
    moment.locale('es');

    // Definir rango inicial (últimos 30 días)
    var startDate = moment().subtract(6, 'days'); // Fecha inicial (hoy - 29 días)
    var endDate = moment(); // Fecha final (hoy)

    $('#reservation').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY',
        applyLabel: 'Aplicar',
        cancelLabel: 'Cancelar',
        fromLabel: 'Desde',
        toLabel: 'Hasta',
        customRangeLabel: 'Personalizado',
        daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        monthNames: [
          'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
          'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ],
        firstDay: 1, // Lunes como primer día
      },
      opens: 'right', // Posición del calendario
      autoUpdateInput: true, // Ahora sí actualiza el input al inicio
      startDate: startDate, // Fecha inicial
      endDate: endDate, // Fecha final
      ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes': [moment().startOf('month'), moment().endOf('month')],
        'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    });

    // Mostrar el rango seleccionado en el input
    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(
        picker.startDate.format('DD/MM/YYYY') +
        ' - ' +
        picker.endDate.format('DD/MM/YYYY')
      );
    });

    // Limpiar el campo si se cancela
    $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

    // Mostrar el rango inicial al cargar la página
    $('#reservation').val(
      startDate.format('DD/MM/YYYY') +
      ' - ' +
      endDate.format('DD/MM/YYYY')
    );
  });
</script>

<script src="<?= base_url('public/dist/js/pages/impcert.js') ?>"></script>


<?= $this->endsection() ?>