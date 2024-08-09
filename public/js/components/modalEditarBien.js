// components/modalEditarBien.js

$(document).ready(function() {
    $('#tablaBienes').on('click', '.btnEdit', function() {
        var id = $(this).data('id');
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '{{ route("editar-bien") }}',
            type: 'POST',
            data: {
                id: id,
                _token: token
            },
            success: function(response) {
                $('#modalEditarBien .modal-body').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener la información del bien:', error);
            }
        });
        $('#modalEditarBien').modal('show');
    });
});
