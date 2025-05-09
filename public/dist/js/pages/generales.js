$(document).ready(function() {
    llenarempresa();
   $('#cmbempresa').change(function (e) { 
        llenarSucursal($(this).val());    
   });   
   $('#cmbsucursal').change(function (e) { 
    llenarAlmacen($(this).val());    
   });
   
});
var Español={
  "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
               
                    "sNext":     ">",
                    "sPrevious": "<"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
}
function cambio_almacen() {
  var empresa=$('#cmbempresa').val();
  var sucursal=$('#cmbsucursal').val(); 
  var almacen=$('#cmbalmacen').val();

  if (empresa==="") {
    Swal.fire({
      icon: "error",
      title: "CAMBIO DE ALMACEN",
      text: "Seleccione una empresa"
    });
    return;   
  }
  if (sucursal==="") {
    Swal.fire({
      icon: "error",
      title: "CAMBIO DE ALMACEN",
      text: "Seleccione una sucursal"
    });
    return;   
  }
  if (almacen==="") {
    Swal.fire({
      icon: "error",
      title: "CAMBIO DE ALMACEN",
      text: "Seleccione un almacen"
    });
    return;  
 }

  var url=baseURL+'acceso/cambioalmacen';
    $.ajax({
      type: "post",
      url: url,
      data: {"sucursal":sucursal,
            "almacen":almacen},
      success: function (response) {
        console.log(response);
        if (response.success) {
            location.reload();
        }
      }
    });
}
function llenarempresa() {
  var url=baseURL+ 'acceso/empresa';

    $.ajax({
      type: "GET",
      url: url,
     
      success: function(response) {
       
          const empresaSelect = $('#cmbempresa');
          empresaSelect.empty(); // Limpia el select existente  
          // Llena el select con las sucursales
          $.each(response.empresas, function(index, empresa) {
            empresaSelect.append(
              $('<option>', { value: empresa.idempresa, text: empresa.descripcion })
            );
          });
         if(response.empresas.length>0){
            llenarSucursal(empresaSelect.val());
         }      
       
      },
      error: function(jqXHR, textStatus) {
        console.log('Error: ' + textStatus);
      }
    });
}
function llenarSucursal(cod) {
  var url=baseURL+'acceso/sucursales';
    $.ajax({
      type: "POST",
      url: url,
      data: { cod },
      success: function(response) {
          //  console.log(response);
          const sucursalSelect = $('#cmbsucursal');
          sucursalSelect.empty(); // Limpia el select existente
  
          // Llena el select con las sucursales
          $.each(response.sucursales, function(index, sucursal) {
            sucursalSelect.append(
              $('<option>', { value: sucursal.idsucursal, text: sucursal.descripcion })
            );
          });
  
          if (response.sucursales.length>0) {
            llenarAlmacen(sucursalSelect.val());
          }
          
      
      },
      error: function(jqXHR, textStatus) {
        console.log('Error: ' + textStatus);
      }
    });
}
function llenarAlmacen(cod) {
  var url=baseURL+ 'acceso/almcactivos';
    $.ajax({
      type: "POST",
      url: url,
      data: { cod },
      success: function(response) {
        
          const almacenSelect = $('#cmbalmacen');
          almacenSelect.empty(); // Limpia el select existente
  
          // Llena el select con los almacenes
          $.each(response.almacenes, function(index, almacen) {
            almacenSelect.append(
              $('<option>', { value: almacen.idalmacen, text: almacen.descripcion })
            );
          });
        
      },
      error: function(jqXHR, textStatus) {
        console.log('Error: ' + textStatus);
      }
    });
}
function actualizar_password() {
  var nuevaClave=$('#txtclave').val();
  const url=baseURL+'acceso/clave';
  $.ajax({
    type: "post",
    url: url,
    data:{np: nuevaClave},
    success: function(response) {

      if (response.success) {
        Swal.fire({
          icon: "success",
          title: "CAMBIO DE CLAVE",
          text: response.mensaje
        }).then(function() {
          $('#txtclave').val('');
          $('#modal-clave').modal('hide');
        });  
      } else {
        Swal.fire({
          icon: "error",
          title: "CAMBIO DE CLAVE",
          text: response.mensaje
        });
      }
    },
    error: function(jqXHR, textStatus) {
      console.log('Error: ' + textStatus);
    }
  });
}
document.addEventListener('DOMContentLoaded', function () {
  // Agregar un evento de escucha a todo el documento
  document.addEventListener('input', function (event) {
      // Verificar si el elemento que disparó el evento es un input o textarea
      if ((event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') &&
          event.target.id !== 'txtclave'&& event.target.id !== 'txtpassword') { // Ignorar el campo con id 'txtclave'
          // Convertir el valor del input/textarea a mayúsculas
          event.target.value = event.target.value.toUpperCase();
      }
  });
});

document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});

function round(num, decimales = 5) {
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0) //con 0 decimales
      return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
  }
  
  

function decodeHTMLEntities(texto) {
    var textarea = document.createElement('textarea');
    textarea.innerHTML = texto;
    return textarea.value;
}

function validarNumero(input) {
    // Eliminar caracteres no permitidos (dejar solo números y un punto decimal)
    input.value = input.value.replace(/[^0-9.]/g, '');
  
    // Verificar si hay más de un punto decimal y eliminar los extras
    if (input.value.split('.').length > 2) {
      input.value = input.value.substring(0, input.value.lastIndexOf('.'));
    }
}

(function($) {
  $.ajaxblock = function() {
     $("body").prepend(`
        <div id='ajax-overlay'>
           <div id='ajax-overlay-body' class='text-center'>
              <img src="${baseURL}public/dist/img/carga.gif" alt="Cargando..." />
              <p class='mt-1' style='font-size: 30px;'>Espere un momento...</p>
           </div>
        </div>
     `);

     // Estilos para el overlay
     $("#ajax-overlay").css({
        position: 'fixed',
        top: '0',
        left: '0',
        width: '100%',
        height: '100%',
        background: 'rgba(39, 38, 46, 0.67)',
        color: '#FFFFFF',
        'text-align': 'center',
        'z-index': '9999'
     });

     // Estilos para el contenido
     $("#ajax-overlay-body").css({
        position: 'absolute',
        top: '40%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: 'auto',
        height: 'auto',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        'border-radius': '10px'
     });

     // Mostrar el overlay
     $("#ajax-overlay").fadeIn(50);
  };

  $.ajaxunblock = function() {
     $("#ajax-overlay").fadeOut(100, function() {
        $(this).remove(); // Asegúrate de que se elimine correctamente
     });
  };
})(jQuery);


 (function($, window) {
   'use strict';

   var MultiModal = function(element) {
       this.$element = $(element);
       this.modalCount = 0;
   };

   MultiModal.BASE_ZINDEX = 1040;

   MultiModal.prototype.show = function(target) {
       var that = this;
       var $target = $(target);
       var modalIndex = that.modalCount++;

       $target.css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20) + 10);

       // Bootstrap triggers the show event at the beginning of the show function and before
       // the modal backdrop element has been created. The timeout here allows the modal
       // show function to complete, after which the modal backdrop will have been created
       // and appended to the DOM.
       window.setTimeout(function() {
           // we only want one backdrop; hide any extras
           if(modalIndex > 0)
               $('.modal-backdrop').not(':first').addClass('hidden');

           that.adjustBackdrop();
       });
   };

   MultiModal.prototype.hidden = function(target) {
       this.modalCount--;

       if(this.modalCount) {
          this.adjustBackdrop();
           // bootstrap removes the modal-open class when a modal is closed; add it back
           $('body').addClass('modal-open');
       }
   };

   MultiModal.prototype.adjustBackdrop = function() {
       var modalIndex = this.modalCount - 1;
       $('.modal-backdrop:first').css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20));
   };

   function Plugin(method, target) {
       return this.each(function() {
           var $this = $(this);
           var data = $this.data('multi-modal-plugin');

           if(!data)
               $this.data('multi-modal-plugin', (data = new MultiModal(this)));

           if(method)
               data[method](target);
       });
   }

   $.fn.multiModal = Plugin;
   $.fn.multiModal.Constructor = MultiModal;

   $(document).on('show.bs.modal', function(e) {
       $(document).multiModal('show', e.target);
   });

   $(document).on('hidden.bs.modal', function(e) {
       $(document).multiModal('hidden', e.target);
   });

 
  
}(jQuery, window));
if (codalmacenses==="NL") {
   $('#modal-cambio').modal('show');
}