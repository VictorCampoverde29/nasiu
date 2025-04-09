$(document).ready(function () {
    $("#togglePassword").click(function () {
        let passwordInput = $("#txtpassword");
        let type = passwordInput.attr("type") === "password" ? "text" : "password";

        // Cambia el tipo de input entre "password" y "text"
        passwordInput.attr("type", type);

        // Cambia el ícono entre "fa-eye" (mostrar) y "fa-eye-slash" (ocultar)
        $(this).toggleClass("fa-eye fa-eye-slash");
    });
    $('#txtpassword').keyup(function (e) { 
        if (e.key=='Enter'||e.which===13) {
            loguear();
        }
    });
});

function loguear() {
    var clave = $('#txtpassword').val().trim();
    var usuario = $('#cmbusuario').val();

    // Validaciones antes de enviar la petición
    if (usuario === '' || usuario === null) {
        Swal.fire({
            icon: "error",
            title: "INICIO DE SESIÓN",
            text: "SELECCIONE UN USUARIO"
        });
        return;
    }

    if (clave === '') {
        Swal.fire({
            icon: "error",
            title: "INICIO DE SESIÓN",
            text: "INGRESE SU CONTRASEÑA"
        });
        return;
    }

    var parametros = $.param({ clave: clave, usuario: usuario });
    const url = URLPY + 'login/login';

    $.ajax({
        type: "POST",
        url: url,
        data: parametros,
        dataType: "json",
        success: function(response) {
           
            if (response.mensaje) {
                Swal.fire({
                    icon: "error",
                    title: "INICIO DE SESIÓN",
                    text: response.mensaje
                });
            } else {
                window.location.href = URLPY + 'dashboard';  // Redirige correctamente
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: "error",
                title: "ERROR EN LA PETICIÓN",
                text: "Ocurrió un problema al intentar iniciar sesión. Inténtelo de nuevo.",
                footer: "Detalles: " + textStatus + " - " + errorThrown
            });
        }
    });
}
