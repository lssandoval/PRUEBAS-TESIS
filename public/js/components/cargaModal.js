$(document).ready(function () {
    $('#formGenerarQR').submit(function (event) {
        event.preventDefault();
        $('#cargandoModal').modal('show');
        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (response) {
                $('#cargandoModal').modal('hide');
                // Aquí puedes manejar la respuesta según sea necesario
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                $('#cargandoModal').modal('hide');
            }
        });
    });

    $('#btnGenerarExcel').click(function (event) {
        event.preventDefault();
        $('#cargandoModal').modal('show');
        var url = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (response) {
                $('#cargandoModal').modal('hide');
                // Aquí puedes manejar la respuesta según sea necesario
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                $('#cargandoModal').modal('hide');
            }
        });
    });
});
