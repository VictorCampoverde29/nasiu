function importar(){
    var filas = [];
           
           if( $("#tblregimport tr").length == 1){
             toastr.error('Necesita agregar articulos al detalle','IMPORTAR CERTIFICADO');
           }
           else if($("#cmbexp").val()==null)
            {
             toastr.error('No tiene serie de certificados en esta sucursal','IMPORTAR CERTIFICADO');
             }   
            else {
            $.ajaxblock();
             $('#tblregimport tbody tr').each(function() {
              var fecha=$(this).find('td').eq(1).text();
              var modelo=$(this).find('td').eq(2).text();
              var cilindra=$(this).find('td').eq(3).text();
              var potencia=$(this).find('td').eq(4).text();
              var color=$(this).find('td').eq(5).text();
              var amodelo=$(this).find('td').eq(6).text();
              var afabrica=$(this).find('td').eq(7).text();
              var version=$(this).find('td').eq(8).text();
              var motor=$(this).find('td').eq(9).text();
              var chasis=$(this).find('td').eq(10).text();
              var codser=$("#cmbexp").val();                       
              var fila = {
                fecha,modelo,cilindra,potencia,color,amodelo,afabrica,version,motor,chasis,codser
              };
              filas.push(fila);
            });
            console.log(JSON.stringify(filas))
        //      $.ajax({
        //            type: "POST",
        //            url: "../procesos_bd/importarcertificados.php",
        //            data: {valores : JSON.stringify(filas)},         
        //            success: function(response) {
        //             $.ajaxunblock();
        //              var mensaje= response.split("|");
        //              var imp=mensaje[0];
        //              var noimp=filas.length-imp;
        //              $('#txtnoimp').val(mensaje[1]);
        //              $('#txtimportados').val(imp);
        //              $('#txtnoimportados').val(noimp);
        //              $('#listaelementosnoimp').html(mensaje[1]);
        //              $('#listaelementosimp').html(mensaje[2]);  
        //              $('#modalresultados').modal('show'); 
        //            },
        //            error:function( req, status, err){
        //                 $.ajaxunblock();
        //                 alert("error"+ status + err);
        //               }
        //      });
           }
       
           
}
