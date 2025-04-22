$('#reservation').on('apply.daterangepicker', function(ev, picker) {
    $.ajax({
        url: '<?= base_url("certificados/filtrar") ?>',
        type: 'POST',
        data: {
            inicio: picker.startDate.format('YYYY-MM-DD'),
            fin: picker.endDate.format('YYYY-MM-DD')
        },
        success: function(response) {
            $('#tblunidades tbody').html(response); // Actualizar tabla
        }
    });
});