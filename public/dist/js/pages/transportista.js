var table = "";
var table2 = "";
$(document).ready(function () {
    getTransportistas();
});
function limpiar() {
    $('#txtplaca').val('');
    $('#txtmarca').val('');
    $('#txtmodelo').val('');
    $('#txtaño').val('');
    $('#cmbestado').val('ACT');
    $('#txttonelaje').val('');
    $('#txtcert').val('');
    $('#txtcategoria').val('');
}
function limpiar_documentacion() {
    $('#txtnombredoc').val('');
    $('#txtnumerodoc').val('');
    $('#dtpdoc').val('');
}
function abrir_modal(opcion) {
    limpiar();
    if (opcion === 'N') {
        $('#lbltitulo').html('Nuevo Transportista');
        $('#btnregistrar').removeClass('d-none');
        $('#btneditar').addClass('d-none');
        
        $('#cmbestado').val('ACTIVO');
        $('#txtruc').val('');
        $('#txtdescripcion').val('');
        $('#txtdireccion').val('');
        $('#txtruc').focus();
    }
    else {
        $('#lbltitulo').html('Editar Transportista');
        $('#btneditar').removeClass('d-none');
        $('#btnregistrar').addClass('d-none');
    }
    $('#modal_datos').modal('show');
}
function mostrarDatos(cod) {
    const url = baseURL + 'transportista/buscarxid';
    abrir_modal('E');
    $.ajax({
        type: "post",
        url: url,
        data: { id: cod },
        success: function (response) {
            //console.log(response);
            $('#txtruc').val(response.data.ruc);
            $('#txtdescripcion').val(response.data.descripcion);
            $('#txtdireccion').val(response.data.direccion);
            $('#cmbestado').val(response.data.estado);
        }
    });
    $('#txtid').val(cod);
}



function getTransportistas() {
    const url = baseURL + 'transportista/datatable';
    table = $('#tblunidades').DataTable({
        "destroy": true,
        "language": Español,
        "lengthChange": true,
        "autoWidth": true,
        "responsive": true,
        "order": [[1, "asc"]],
        "ajax": {
            'method': 'GET',
            'url': url,
            'dataSrc': function (json) {
                //console.log(json); // Verifica que los datos sean correctos
                return json.data;
            }
        },
        "columns": [
            { "data": "ruc" },
            { "data": "descripcion" },
            { "data": "direccion" },

            {
                "data": "estado",
                "render": function (data) {
                    // Convertir valores y asignar color
                    if (data === 'ACTIVO') {
                        return '<span class="text-success font-weight-bold">ACTIVO</span>';
                    } else if (data === 'INACTIVO') {
                        return '<span class="text-danger font-weight-bold">INACTIVO</span>';
                    }
                    return data; // Por si hay otro valor no contemplado
                }
            },

            {
                "data": null,
                "orderable": false,
                "render": function (data, type, row) {
                    let buttons = `
                    <div class="btn-group">
                        <button type="button" onclick="mostrarDatos('${data.idtransportista}')" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </button>`;


                    buttons += `</div>`;
                    return buttons;
                }
            }

        ],
        "createdRow": function (row, data, dataIndex) {
            if (data.estado === 'INACTIVO') {
                // Aplica a todas las celdas excepto la última (botones)
                $(row).find('td:not(:last-child)').addClass('text-danger');
            }
        }
    });
}
function busca_ruc() {
    var ruc = $('#txtruc').val();
    if (ruc.length < 11) {
        Swal.fire({
            icon: "error",
            title: "BUSCA RUC",
            text: "INGRESE UN RUC VÁLIDO"
        });
        return;
    } else 
    {
        $.ajaxblock();
        const url = baseURL + 'api/ruc';
        $.ajax({
            type: "POST",
            url: url,  
            data: { ruc: ruc },
            success: function (response) {
                //console.log(response);
                $.ajaxunblock();
                $('#txtdescripcion').val(response.nombre_o_razon_social);
                $('#txtdireccion').val(response.direccion);
            }
        });
    }
}

function registrar() {
    var descripcion = $('#txtdescripcion').val();
    var ruc = $('#txtruc').val();
    var estado = $('#cmbestado').val();
    var direccion = $('#txtdireccion').val();  
    const url = baseURL + 'transportista/insertar';

     if (descripcion === '') {
        Swal.fire({
            icon: "error",
            title: "EDICIÓN DE TRANSPORTISTA",
            text: "LA DESCRIPCION NO PUEDE ESTAR VACIA"
        });
        return;
    }
    else if (ruc === '') {
        Swal.fire({
            icon: "error",
            title: "EDICIÓN DE TRANSPORTISTA",
            text: "EL RUC NO PUEDE ESTAR VACIO"
        });
        return;
    }
    else if (direccion === '') {
        Swal.fire({
            icon: "error",
            title: "EDICIÓN DE TRANSPORTISTA",
            text: "LA DIRECCION NO PUEDE ESTAR VACIA"
        });
        return;
    }
    else {
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                descripcion: descripcion,
                ruc: ruc,               
                estado: estado,
                direccion: direccion
            },
            success: function (response) {
                //console.log(response);
                if (response.error) {
                    Swal.fire({
                        icon: "error",
                        title: "REGISTRO DE TRANSPORTISTA",
                        text: response.error
                    });

                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'REGISTRO DE TRANSPORTISTA',
                        text: response.message,
                    }).then(function () {
                        var paginaActual = table.page.info().page;
                        table.ajax.reload();
                        setTimeout(function () {
                            table.page(paginaActual).draw('page');
                        }, 800);
                        limpiar();
                        $('#modal_datos').modal('hide');
                    });
                }
            },
            error: function (xhr) {
                alert(xhr.responseText); // Mostrar el mensaje de error
            }
        });
    }
}
function editar() {

    var descripcion = $('#txtdescripcion').val();
    var ruc = $('#txtruc').val();
    var estado = $('#cmbestado').val();
    var direccion = $('#txtdireccion').val();   
    var cod = $('#txtid').val();
    const url = baseURL + 'transportista/update';

    if (descripcion === '') {
        Swal.fire({
            icon: "error",
            title: "EDICIÓN DE TRANSPORTISTA",
            text: "LA DESCRIPCION NO PUEDE ESTAR VACIA"
        });
        return;
    }
    else if (ruc === '') {
        Swal.fire({
            icon: "error",
            title: "EDICIÓN DE TRANSPORTISTA",
            text: "EL RUC NO PUEDE ESTAR VACIO"
        });
        return;
    }
    else if (direccion === '') {
        Swal.fire({
            icon: "error",
            title: "EDICIÓN DE TRANSPORTISTA",
            text: "LA DIRECCION NO PUEDE ESTAR VACIA"
        });
        return;
    }
    
    else {
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                descripcion: descripcion,
                ruc: ruc,               
                estado: estado,
                direccion: direccion,
                cod: cod
            },
            success: function (response) {
                //console.log(response);
                if (response.error) {
                    Swal.fire({
                        icon: "error",
                        title: "EDICIÓN DE TRANSPORTISTA",
                        text: response.error
                    });

                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'EDICIÓN DE TRANSPORTISTA',
                        text: response.message,
                    }).then(function () {
                        var paginaActual = table.page.info().page;
                        table.ajax.reload();
                        setTimeout(function () {
                            table.page(paginaActual).draw('page');
                        }, 800);
                        limpiar();
                        $('#modal_datos').modal('hide');
                    });
                }
            },
            error: function (xhr) {
                alert(xhr.responseText); // Mostrar el mensaje de error
            }
        });
    }
}

function registrar_documentacion() {
    var nombre = $('#txtnombredoc').val();
    var numero = $('#txtnumerodoc').val();
    var fecha = $('#dtpdoc').val();
    var unidades = $('#txtidunidad').val();

    const url = baseURL + 'documentacion/insertar';

    if (nombre === '') {
        Swal.fire({
            icon: "error",
            title: "REGISTRO DE DOCUMENTACION",
            text: "EL NOMBRE NO PUEDE ESTAR VACIO"
        });
        return;
    }
    else if (numero === '') {
        Swal.fire({
            icon: "error",
            title: "REGISTRO DE DOCUMENTACION",
            text: "NECESITA INDICAR EL NUMERO"
        });
        return;
    }
    else if (fecha === '') {
        Swal.fire({
            icon: "error",
            title: "REGISTRO DE DOCUMENTACION",
            text: "INDIQUE EL VENCIMIENTO DE LA DOCUMENTACION"
        });
        return;
    }

    else {
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                unidades: unidades,
                descripcion: nombre,
                numero: numero,
                fecha_vencimiento: fecha
            },
            success: function (response) {
                //console.log(response);
                if (response.error) {
                    Swal.fire({
                        icon: "error",
                        title: "REGISTRO DE DOCUMENTACION",
                        text: response.error
                    });

                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'REGISTRO DE DOCUMENTACION',
                        text: response.message,
                    }).then(function () {
                        var paginaActual = table2.page.info().page;
                        table2.ajax.reload();
                        setTimeout(function () {
                            table2.page(paginaActual).draw('page');
                        }, 800);
                        limpiar_documentacion();
                        //$('#modal_documentacion').modal('hide');
                    });
                }
            },
            error: function (xhr) {
                alert(xhr.responseText); // Mostrar el mensaje de error
            }
        });
    }
}

// Función para actualizar los datos
function actualizarDocumentacion(id) {
    const descripcion = $(`.editable-descripcion[data-id="${id}"]`).val();
    const numero = $(`.editable-numero[data-id="${id}"]`).val();
    const fecha = $(`.editable-fecha[data-id="${id}"]`).val();

    if (!descripcion) {
        Swal.fire('EDICIÓN DE DOCUMENTACION', 'NECESITA INGRESAR LA DESCRIPCION DEL DOCUMENTO', 'error');
        return;
    }
    if (!numero) {
        Swal.fire('EDICIÓN DE DOCUMENTACION', 'INDIQUE EL NUMERO', 'error');
        return;
    }

    $.ajax({
        url: baseURL + 'documentacion/actualizar',
        method: 'POST',
        data: {
            cod: id,
            descripcion: descripcion,
            numero: numero,
            fecha_vencimiento: fecha
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('EDICIÓN DE DOCUMENTACION', 'Documentación actualizada correctamente', 'success');
                table2.ajax.reload(null, false); // Recarga sin resetear paginación
            } else {
                Swal.fire('EDICIÓN DE DOCUMENTACION', 'Error al actualizar: ' + response.message, 'error');
            }
        },
        error: function (xhr) {
            Swal.fire('EDICIÓN DE DOCUMENTACION', 'Error al conectar con el servidor', 'error');
        }
    });
}