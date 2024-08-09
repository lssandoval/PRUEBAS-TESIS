$(document).ready(function () {
    // Evento para cerrar el modal de QR
    document.addEventListener('close-modal', event => {
        $('#modalQR').modal('hide');
    });
});