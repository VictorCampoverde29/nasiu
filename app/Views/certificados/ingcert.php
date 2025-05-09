<?= $this->extend('dashboard/template'); ?>
<?= $this->section('titulo'); ?>
Ingreso de Certificados
<?= $this->endsection(); ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 8px;
        background: #f8f9fa;
        padding: 40px;
        text-align: center;
        font-size: 16px;
        color: #495057;
    }

    .dropzone .dz-message i {
        font-size: 3rem;
        color: #007bff;
    }
</style>
<?= $this->endsection(); ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ingresar Certificados desde Excel</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="<?= base_url('public/templates/PLANTILLA_EXPEDIENTES.xlsx') ?>" class="dropdown-item" >+ DESCARGAR PLANTILLA</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <!-- Dropzone -->
                        <form action="#" class="dropzone" id="dropzoneExcel">
                            <div class="dz-message">
                                <i class="fas fa-file-excel"></i><br>
                                <span>Arrastre aquí o haga clic para seleccionar un archivo Excel</span>
                            </div>
                        </form>

                        <!-- Tabla -->
                        <div class="table-responsive mt-4">
                            <table id="tblcertificados" class="table table-bordered table-hover">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>FECHA</th>
                                        <th>MODELO</th>
                                        <th>CILINDRADA</th>
                                        <th>POTENCIA</th>
                                        <th>COLOR</th>
                                        <th>A_MODELO</th>
                                        <th>A_FABRICACION</th>
                                        <th>VERSION</th>
                                        <th>MOTOR</th>
                                        <th>CHASIS</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <!-- Justo debajo de la tabla -->
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <h3 id="totalCertificados">Total de certificados: 0</h3>
                                <button class="btn btn-primary" id="btnGuardarCertificados" on click="importar()">
                                    <i class="fas fa-save"></i> Ingresar Certificados
                                </button>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalresultados">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Resultados de Importación</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="cuerpomodal">
                  <div class="row">
                          <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                              <label>IMPORTADOS:</label>
                              <input type="text" class="form-control" disabled="" id="txtimportados">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>NO IMPORTADOS</label>
                              <input type="text" class="form-control"  disabled="" id="txtnoimportados">
                            </div>
                          </div>
                  </div> 
                  <div class="row">
                          <div class="col-sm-6">
                          <div class="card-body">
                              <ul id="listaelementosimp">              
                              </ul>
                            </div>
                          </div>
                          <div class="col-sm-6">
                          <div class="card-body">
                              <ul id="listaelementosnoimp">              
                              </ul>
                            </div>
                          </div>
                  </div>                      
            </div>           
          </div>
        </div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    Dropzone.autoDiscover = false;

    const dropzone = new Dropzone("#dropzoneExcel", {
        url: "#", // No sube archivos
        autoProcessQueue: false,
        maxFiles: 1,
        acceptedFiles: ".xlsx,.xls",
        addRemoveLinks: true,
        dictRemoveFile: "Eliminar",
        dictDefaultMessage: "<i class='fas fa-file-excel fa-3x'></i><br>Arrastra o haz click para cargar tu archivo Excel",

        init: function() {
            this.on("addedfile", function(file) {
                if (!file.name.endsWith(".xlsx") && !file.name.endsWith(".xls")) {
                    alert("Solo se permiten archivos Excel");
                    this.removeFile(file);
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const sheet = workbook.Sheets[workbook.SheetNames[0]];
                    const jsonData = XLSX.utils.sheet_to_json(sheet, {
                        header: 1
                    });
                    renderTabla(jsonData);
                };
                reader.readAsArrayBuffer(file);
            });

            this.on("removedfile", function() {
                limpiarTabla();
            });
        }
    });

    function convertirFechaExcel(fechaNum) {
        if (typeof fechaNum === 'number') {
            const fecha = new Date((fechaNum - 25569) * 86400 * 1000);
            return fecha.toISOString().split('T')[0];
        }
        return fechaNum;
    }

    function renderTabla(data) {
        const tbody = $("#tblcertificados tbody");
        tbody.empty();

        let total = 0;

        for (let i = 1; i < data.length; i++) {
            let fila = data[i];
            if (fila.length === 0) continue;

            let tr = `<tr>
            <td>${i}</td>
            <td>${convertirFechaExcel(fila[0])}</td>
            <td>${fila[1] || ''}</td>
            <td>${fila[2] || ''}</td>
            <td>${fila[3] || ''}</td>
            <td>${fila[4] || ''}</td>
            <td>${fila[5] || ''}</td>
            <td>${fila[6] || ''}</td>
            <td>${fila[7] || ''}</td>
            <td>${fila[8] || ''}</td>
            <td>${fila[9] || ''}</td>
        </tr>`;

            tbody.append(tr);
            total++;
        }

        $("#totalCertificados").text("Total de certificados: " + total);
    }

    function limpiarTabla() {
        $("#tblcertificados tbody").empty();
        $("#totalCertificados").text("Total de certificados: 0");
    }

    $("#btnGuardarCertificados").click(function() {
        let certificados = [];

        $("#tblcertificados tbody tr").each(function() {
            let tds = $(this).find("td");
            certificados.push({
                fecha: $(tds[1]).text(),
                modelo: $(tds[2]).text(),
                cilindrada: $(tds[3]).text(),
                potencia: $(tds[4]).text(),
                color: $(tds[5]).text(),
                anio_modelo: $(tds[6]).text(),
                anio_fabricacion: $(tds[7]).text(),
                version: $(tds[8]).text(),
                motor: $(tds[9]).text(),
                chasis: $(tds[10]).text(),
            });
        });
    
        $.ajax({
            url: '<?= base_url('certificados/guardar_lote') ?>',
            method: 'POST',
            data: {
                certificados: certificados
            },
            success: function(response) {
                console.log(response);
                     var mensaje= response.split("|");
                     var imp=mensaje[0];
                    // var noimp=filas.length-imp;
                     $('#txtnoimp').val(mensaje[1]);
                     $('#txtimportados').val(imp);
                     $('#txtnoimportados').val(noimp);
                     $('#listaelementosnoimp').html(mensaje[1]);
                     $('#listaelementosimp').html(mensaje[2]);  
                     $('#modalresultados').modal('show');
            },
            error: function() {
                alert('Error al guardar los certificados');
            }
        });
    });
</script>

<?= $this->endsection(); ?>