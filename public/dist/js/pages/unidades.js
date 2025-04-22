var table="";
var table2="";
$(document).ready(function () {
    getunidades();
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
function abrir_modal(opcion){
    limpiar();
    if (opcion==='N') {
        $('#lbltitulo').html('Nueva Unidad');
        $('#btnregistrar').removeClass('d-none');
        $('#btneditar').addClass('d-none');
        $('#txtdescripcion').focus();
    }  
    else
    {
        $('#lbltitulo').html('Editar Unidad');
        $('#btneditar').removeClass('d-none');
        $('#btnregistrar').addClass('d-none');
    }
    $('#modal_datos').modal('show');
}
function mostrarDatos(cod) {
  const url = baseURL + 'unidades/buscarxid';
   abrir_modal('E');
   $.ajax({
    type: "post",
    url: url,
    data:{id:cod},
    success: function (response) {
        //console.log(response);
        $('#txtplaca').val(response.data.placa);
        $('#txtmodelo').val(response.data.modelo);
        $('#txtaño').val(response.data.año_de_unidad);
        $('#txtmarca').val(response.data.marca);
        $('#txttonelaje').val(response.data.tonelaje);
        $('#txtcategoria').val(response.data.cvehicular);
        $('#txtcert').val(response.data.cert_inscrip);
        $('#cmbestado').val(response.data.estado);
    }
   });
   $('#txtid').val(cod);
}

function mostrarDoc(cod) {
    getdocumentacion(cod);
    $('#txtidunidad').val(cod); 
    $('#modal_documentacion').modal('show');
  }
function busca_placa() {
    var placa = $('#txtplaca').val();
    if (placa.length < 6) {
        Swal.fire({
            icon: "error",
            title: "BUSCA PLACA",
            text: "INGRESE UNA PLACA VÁLIDA"
        });
        return;
    } else 
    {
        $.ajaxblock();
        const url = baseURL + 'api/unidades';
        $.ajax({
            type: "POST",
            url: url,  
            data: { placa: placa },
            success: function (response) {
                $.ajaxunblock();
                $('#txtmarca').val(response.marca);
                $('#txtmodelo').val(response.modelo);
            }
        });
    }
}
function getunidades() {
    const url = baseURL + 'unidades/datatable';    
    table = $('#tblunidades').DataTable({
        "destroy": true,
        "language": Español,
        "lengthChange": true,
        "autoWidth": true,
        "responsive": true,        
        "ajax": {
            'method': 'GET',
            'url': url,
            'dataSrc': function (json) {
                //console.log(json); // Verifica que los datos sean correctos
                return json.data; 
            }
        },
        "columns": [
            {"data": "descripcion"},
            {"data": "marca"},
            {"data": "modelo"},
            {"data": "año_de_unidad"},
            {"data": "placa"},
           
            {
                "data": "estado",
                "render": function(data) {
                    // Convertir valores y asignar color
                    if (data === 'ACT') {
                        return '<span class="text-success font-weight-bold">ACTIVO</span>';
                    } else if (data === 'INA') {
                        return '<span class="text-danger font-weight-bold">INACTIVO</span>';
                    }
                    return data; // Por si hay otro valor no contemplado
                }
            },
            {"data": "tonelaje"},
            {"data":"cert_inscrip"},
            {"data":"cvehicular"},
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    let buttons = `
                    <div class="btn-group">
                        <button type="button" onclick="mostrarDatos('${data.idunidades}')" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" onclick="mostrarDoc('${data.idunidades}')" class="btn btn-success btn-sm">
                        <i class="fas fa-clipboard"></i>
                    </button>`;
                    
                   
                    buttons += `</div>`;
                    return buttons;
                }
            }
           
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data.estado === 'INA') {
                // Aplica a todas las celdas excepto la última (botones)
                $(row).find('td:not(:last-child)').addClass('text-danger');
            }
        }
    });  
}

function getdocumentacion(idunidades) {
    const url = baseURL + 'documentacion/datatable';    
    table2 = $('#tbldocumentacion').DataTable({
        "destroy": true,
        "language": Español,
        "lengthChange": true,
        "autoWidth": true,
        "responsive": true,        
        "ajax": {
            'method': 'POST',
            'url': url,
            'data': { id: idunidades },
            'dataSrc': function (json) {
                return json.data; 
            }
        },
        "columns": [
            {
                "data": "descripcion",
                "render": function(data, type, row) {
                    return `<input type="text" class="form-control form-control-sm editable-descripcion" value="${data || ''}" data-id="${row.iddocumentacion}">`;
                }
            },
            {
                "data": "numero",
                "render": function(data, type, row) {
                    return `<input type="text" class="form-control form-control-sm editable-numero" value="${data || ''}" data-id="${row.iddocumentacion}">`;
                }
            },
            {
                "data": "fecha_vencimiento",
                "render": function(data, type, row) {
                    return `<input type="date" class="form-control form-control-sm editable-fecha" value="${data || ''}" data-id="${row.iddocumentacion}">`;
                }
            },           
            {
                "data": "fecha_vencimiento",
                "render": function(data, type, row) {
                    if (!data) return '<span class="badge bg-secondary">SIN FECHA</span>';
                    
                    const fechaVencimiento = new Date(data);
                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    
                    const diffTime = fechaVencimiento - hoy;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    if (fechaVencimiento < hoy) {
                        return '<span class="badge bg-danger">VENCIDO</span>';
                    } else if (diffDays <= 30) {
                        return `<span class="badge bg-warning">POR VENCER (${diffDays}d)</span>`;
                    } else {
                        return '<span class="badge bg-success">VIGENTE</span>';
                    }
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    return `
                    <div class="btn-group">
                        <button type="button" onclick="actualizarDocumentacion('${data.iddocumentacion}')" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> GUARDAR
                        </button>
                    </div>`;
                }
            }
        ]
    });  
}
function registrar() {
    var marca=$('#txtmarca').val();
        var modelo=$('#txtmodelo').val();
        var a_unidad=$('#txtaño').val();
        var placa=$('#txtplaca').val();
        var estado=$('#cmbestado').val();
        var tonelaje=$('#txttonelaje').val();
        var cert=$('#txtcert').val();
        var categ=$('#txtcategoria').val();
        const url = baseURL + 'unidades/insertar';

        if (marca==='') {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE UNIDADES",
                text: "LA MARCA NO PUEDE ESTAR VACIA"
            });
            return;
        }
        else if ( modelo==='' ) {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE UNIDADES",
                text: "EL MODELO NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else if ( a_unidad==='' ) {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE UNIDADES",
                text: "EL AÑO DE LA UNIDAD NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else if (placa==='' ||  tonelaje==='' || cert==='' || categ==='') {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE UNIDADES",
                text: "LA PLACA NO PUEDE ESTAR VACIA"
            });
            return;
        }
        else if (cert==='') {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE UNIDADES",
                text: "EL CERTIFICADO NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else
        {
            $.ajax({
                url: url,
                type: 'POST',
                data:{
                       marca:marca,
                       modelo:modelo,
                       a_und:a_unidad,
                       placa:placa,
                       estado:estado,
                       tonelaje:tonelaje,
                       cert:cert,
                       categoria:categ
                }, 
                success: function(response) {
                    //console.log(response);
                    if (response.error) {
                        Swal.fire({
                              icon: "error",
                              title: "REGISTRO DE UNIDADES",
                              text: response.error
                        });
                       
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'REGISTRO DE UNIDADES',
                            text: response.message,            
                            }).then(function() {
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
                error: function(xhr) {
                   alert(xhr.responseText); // Mostrar el mensaje de error
                }
            });
        }
}
function editar() {
   
        var marca=$('#txtmarca').val();
        var modelo=$('#txtmodelo').val();
        var a_unidad=$('#txtaño').val();
        var placa=$('#txtplaca').val();
        var estado=$('#cmbestado').val();
        var tonelaje=$('#txttonelaje').val();
        var cert=$('#txtcert').val();
        var categ=$('#txtcategoria').val();
        var cod=$('#txtid').val();
        const url = baseURL + 'unidades/update';

        if (marca==='') {
            Swal.fire({
                icon: "error",
                title: "EDICIÓN DE UNIDADES",
                text: "LA MARCA NO PUEDE ESTAR VACIA"
            });
            return;
        }
        else if ( modelo==='' ) {
            Swal.fire({
                icon: "error",
                title: "EDICIÓN DE UNIDADES",
                text: "EL MODELO NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else if ( a_unidad==='' ) {
            Swal.fire({
                icon: "error",
                title: "EDICIÓN DE UNIDADES",
                text: "EL AÑO DE LA UNIDAD NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else if (placa==='') {
            Swal.fire({
                icon: "error",
                title: "EDICIÓN DE UNIDADES",
                text: "LA PLACA NO PUEDE ESTAR VACIA"
            });
            return;
        }
        else if (cert==='') {
            Swal.fire({
                icon: "error",
                title: "EDICIÓN DE UNIDADES",
                text: "EL CERTIFICADO NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else
        {
            $.ajax({
                url: url,
                type: 'POST',
                data:{
                       marca:marca,
                       modelo:modelo,
                       a_und:a_unidad,
                       placa:placa,
                       estado:estado,
                       tonelaje:tonelaje,
                       cert:cert,
                       categoria:categ,
                       cod:cod
                }, 
                success: function(response) {
                    //console.log(response);
                    if (response.error) {
                        Swal.fire({
                              icon: "error",
                              title: "EDICIÓN DE UNIDADES",
                              text: response.error
                        });
                       
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'EDICIÓN DE UNIDADES',
                            text: response.message,            
                            }).then(function() {
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
                error: function(xhr) {
                   alert(xhr.responseText); // Mostrar el mensaje de error
                }
            });
        }  
}

function registrar_documentacion() {
    var nombre=$('#txtnombredoc').val();
    var numero=$('#txtnumerodoc').val();
    var fecha=$('#dtpdoc').val();
    var unidades=$('#txtidunidad').val();
      
        const url = baseURL + 'documentacion/insertar';

        if (nombre==='') {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE DOCUMENTACION",
                text: "EL NOMBRE NO PUEDE ESTAR VACIO"
            });
            return;
        }
        else if ( numero==='' ) {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE DOCUMENTACION",
                text: "NECESITA INDICAR EL NUMERO"
            });
            return;
        }
        else if ( fecha==='' ) {
            Swal.fire({
                icon: "error",
                title: "REGISTRO DE DOCUMENTACION",
                text: "INDIQUE EL VENCIMIENTO DE LA DOCUMENTACION"
            });
            return;
        }
       
        else
        {
            $.ajax({
                url: url,
                type: 'POST',
                data:{
                       unidades:unidades,
                       descripcion:nombre,
                       numero:numero,
                       fecha_vencimiento:fecha
                }, 
                success: function(response) {
                    //console.log(response);
                    if (response.error) {
                        Swal.fire({
                              icon: "error",
                              title: "REGISTRO DE DOCUMENTACION",
                              text: response.error
                        });
                       
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'REGISTRO DE DOCUMENTACION',
                            text: response.message,            
                            }).then(function() {
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
                error: function(xhr) {
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
    
    if (!descripcion ) {
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
        success: function(response) {
            if (response.success) {
                Swal.fire('EDICIÓN DE DOCUMENTACION', 'Documentación actualizada correctamente', 'success');
                table2.ajax.reload(null, false); // Recarga sin resetear paginación
            } else {
                Swal.fire('EDICIÓN DE DOCUMENTACION', 'Error al actualizar: ' + response.message, 'error');
            }
        },
        error: function(xhr) {
            Swal.fire('EDICIÓN DE DOCUMENTACION', 'Error al conectar con el servidor', 'error');
        }
    });
}