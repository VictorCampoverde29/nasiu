var table="";
$(function () {
    // Rango automático para el mes actual
    const inicioDefault = moment().startOf('month').format('YYYY-MM-DD');
    const finDefault = moment().endOf('month').format('YYYY-MM-DD');

    // Actualiza el input visualmente
    $('#reservation').val(
        moment().startOf('month').format('DD/MM/YYYY') + ' - ' + 
        moment().endOf('month').format('DD/MM/YYYY')
    );

    // Ejecuta la carga inicial de la tabla
    getCertificados(inicioDefault, finDefault);
});
$('#reservation').on('apply.daterangepicker', function(ev, picker) {
   var inicio = picker.startDate.format('YYYY-MM-DD');
   var fin = picker.endDate.format('YYYY-MM-DD');
   getCertificados(inicio, fin); 
});

function getCertificados(inicio, fin) {
    const url = baseURL + 'certificados/datatable';    
    table = $('#tblcertificados').DataTable({
        "destroy": true,
        "language": Español,
        "lengthChange": true,
        "autoWidth": true,
        "responsive": true,
        "ajax": {
            'method': 'POST',
            'url': url,
            'data': function(d) {
                d.inicio = inicio;
                d.fin = fin;
            },
            'dataSrc': function (json) {
                // Mostrar el botón si hay más de un certificado
                if (json.data.length > 1) {
                    $('#btnImprimirTodos').show();
                } else {
                    $('#btnImprimirTodos').hide();
                }
                return json.data;
            }
        },
        "columns": [
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button type="button" onclick="imprimirCertificado('${data.idcertificados}')" class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>`;
                }
            },
            {"data": "expediente"},
            {"data": "fecha_certificado"},
            {"data": "modelo"},
            {"data": "cilindridada"},
            {"data": "potencia"},
            {"data": "color"},
            {"data": "año_modelo"},
            {"data": "año_fabricacion"},
            {"data": "version"},
            {"data": "motor"},
            {"data": "chasis"},
        ]
    });
}

function imprimirCertificado(id) {
    window.open(baseURL + 'certificados/rptCertificado/' + id, '_blank');
}
function imprimirTodos() {
    const data = table.rows().data().toArray();
    const ids = data.map(item => item.idcertificados);

    if (ids.length > 1) {
        // Crear un formulario oculto y enviarlo por POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseURL + 'certificados/rptCertificados'; // Cambia al método que acepte POST
        form.target = '_blank'; // Para abrir en una nueva pestaña

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids';
        input.value = JSON.stringify(ids); // Pasamos el array como JSON

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    } else {
        alert("No hay múltiples certificados para imprimir.");
    }
}

