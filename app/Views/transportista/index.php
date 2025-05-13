<?= $this->extend('dashboard/template.php'); ?>
<?= $this->section('titulo'); ?>
Mant. Transportistas
<?= $this->endsection() ?>

<?= $this->section('styles'); ?>
  <link rel="stylesheet" href="<?= base_url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
<?= $this->endsection() ?>

<?= $this->section('content'); ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Transportistas Registrados</h3>
            <div class="card-tools">
              <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                  <a href="#" class="dropdown-item" onclick="abrir_modal('N')">+ AGREGAR NUEVO TRANSPORTISTA</a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card-body">
            <div class="table-responsive">
              <table id="tblunidades" class="table table-bordered table-hover">
                <thead>
                  <tr style="background-color: #000000; color:#FFFFFF;">
                    <th>RUC</th>
                    <th>DESCRIPCION</th>
                    <th>DIRECCION</th>                    
                    <th>ESTADO</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Datos de la tabla -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal para datos de unidades -->
<div class="modal fade" id="modal_datos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="lbltitulo" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="lbltitulo">Registrar Nuevo Transportista</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="txtdescripcion">Ruc:</label>
              <input type="hidden" id="txtid" name="txtid" value="0">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control form-control-sm" id="txtruc" name="txtruc" placeholder="RUC" required>
                <span class="input-group-append">
                  <button type="button" class="btn btn-info btn-flat btn-sm" onclick="busca_ruc()"><i class="fa-solid fa-magnifying-glass"></i> SUNAT</button>
                </span>
              </div>
            </div>
          </div>
          
          <div class="col-md-9">
            <div class="form-group">
              <label for="txtdescripcion">Descripción:</label>
              <input type="text" class="form-control form-control-sm" id="txtdescripcion" name="txtdescripcion" placeholder="Descripción" required>
            </div>
          </div>
          
          
          <div class="col-md-10">
            <div class="form-group">
              <label for="txtdescripcion">Dirección:</label>
              <input type="text" class="form-control form-control-sm" id="txtdireccion" name="txtdireccion" placeholder="Dirección" required>
            </div>
          </div>
          
        
          
          <div class="col-md-2">
            <div class="form-group">
              <label for="txtdescripcion">Estado:</label>
              <select class="form-control form-control-sm" id="cmbestado" name="cmbestado">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> CERRAR</button> 
        <button class="btn btn-primary" onclick="registrar()" id="btnregistrar" name="btnregistrar"><i class="fa-solid fa-floppy-disk"></i> REGISTRAR</button>
        <button class="btn btn-warning" onclick="editar()" id="btneditar" name="btneditar"><i class="fa-solid fa-pencil"></i> EDITAR</button>
      </div>
    </div>
  </div>
</div>


<?= $this->endsection() ?>

<?= $this->section('scripts'); ?>
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
<script src="<?= base_url('public/dist/js/pages/transportista.js') ?>"></script>
<?= $this->endsection() ?>