
$(document).ready(function () {
  vervencidos();
});
function vervencidos() {
  if ($('#modal-documentacion').length) {
    llenaunidades();
    $('#modal-documentacion').modal('show'); 
  } else {
    // no existe
  }
}

function llenaunidades() {
  var url_comp=baseURL + 'documentacion/vencidos';
  var table = $('#tblunidades').dataTable({
    "language":Español,
    "bDestroy": true,
    "bProcessing": true,
    "sAjaxSource": url_comp ,    
    "aoColumns":[ 
            { mData: 'nombre_unidad'},
            { mData: 'descripcion' },
            { mData: 'numero' },
            { mData: 'fecha_vencimiento' }           
          ]
               
      });
}