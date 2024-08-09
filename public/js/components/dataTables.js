
$(document).ready(function () {
    var token = $('meta[name="csrf-token"]').attr('content');
    var tablaBienes = $('#tablaBienes').DataTable({
        ajax: routeBienes,
        columns: [
            {
                data: null,
                className: 'fixed-column',
                render: function (data, type, row) {
                    return `
                        <div class="flex flex-col justify-center items-center space-y-2 px-2">
                            <button type="button" class="btn btn-link text-info btnShowInfo" title="Mostrar Información" data-id="${data.id}">
                                <i class="fa-solid fa-info-circle fa-lg"></i>
                            </button>
                        </div>`;
                }
            },
            {
                data: null,
                className: 'fixed-column',
                render: function (data, type, row) {
                    return `
                        <div class="grid grid-cols-2 gap-2 justify-center items-center px-2">
                            <!-- Columna izquierda: Modificar y Eliminar -->
                            <div class="flex flex-col space-y-2">
                                <button type="button" class="btn btn-link text-warning btnEdit" title="Modificar" onclick="window.location.href='/editar-bien/${data.id}'">
                                    <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                </button>
                                <button type="button" class="btn btn-link text-danger btnDelete" title="Eliminar" data-id="${data.id}" data-codigo_bien="${data.codigo_bien}">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </button>
                            </div>
                            <!-- Columna derecha: QR y Mantenimientos -->
                            <div class="flex flex-col space-y-2">
                                <button type="button" class="btn btn-link nav-link text-actualizar btnShowModalQR" title="Botón Cargar QR" data-id="${data.id}" data-codigo_bien="${data.codigo_bien}">
                                    <i class="fa-solid fa-qrcode fa-lg"></i>
                                </button>
                                <button type="button" class="btn btn-link text-info btnMaintenance" title="Mantenimientos" onclick="window.location.href='/mantenimientos/${data.id}'">
                                    <i class="fa-solid fa-screwdriver-wrench fa-lg"></i>
                                </button>
                            </div>
                        </div>`;
                }
            },
            { data: 'id' },
            { data: 'codigo_bien' },
            { data: 'en_uso' },
            { data: 'tipo' },
            { data: 'marca' },
            { data: 'modelo' },
            { data: 'serial' },
            { data: 'ubicacion' },
            { data: 'custodio_identificado' },
            { data: 'fecha_ingreso' },
            { data: 'periodo_garantia' },
            { data: 'proveedor' },
            { data: 'estado' },
            { data: 'fecha_ultimo_mantenimiento' },
            { data: 'recomendacion_1' },
            { data: 'recomendacion_2' },
            { data: 'cedula_esbye' },
            { data: 'custodio_esbye' },
            { data: 'serial_esbye' },
            { data: 'modelo_esbye' },
            { data: 'descripcion_esbye' },
            { data: 'created_at' },
            { data: 'updated_at' },
        ],
        responsive: true,
        autoWidth: false,
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'No hay registros - intenta otra vez',
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'No hay registros disponibles',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            search: 'Buscar:',
            paginate: {
                next: 'Siguiente',
                previous: 'Anterior'
            }
        }
    });


    // Evento para abrir el modal de edición
    $('#tablaBienes').on('click', '.btnShowModalQR', function () {
        var id = $(this).data('id');
        var codigo_bien = $(this).data('codigo_bien');

        $.ajax({
            url: generateQRUrl,
            method: "POST",
            data: {
                id: id,
                codigo_bien: codigo_bien,
                _token: token
            },
            success: function (response) {
                $('#modalQRId').text(id);
                $('#modalQRCodigoBien').text(codigo_bien);
                $('#modalQRCode').html(response.qrCode);
                $('#modalQR').modal('show');
            },
            error: function (xhr) {
                console.error('Error al generar el código QR:', xhr);
            }
        });
    });

    // Evento para abrir el modal de QR
    // Evento para abrir el modal de QR
    $('#tablaBienes').on('click', '.btnShowModalQR', function () {
        var id = $(this).data('id');
        var codigo_bien = $(this).data('codigo_bien');

        $.ajax({
            url: generateQRUrl,
            method: "POST",
            data: {
                id: id,
                codigo_bien: codigo_bien,
                _token: token
            },
            success: function (response) {
                $('#modalQRId').text(id);
                $('#modalQRCodigoBien').text(codigo_bien);
                $('#modalQRCode').html(`<img src="${response.qr_code_url}" alt="QR Code">`);
                $('#modalQR').modal('show');
            },
            error: function (xhr) {
                console.error('Error al generar el código QR:', xhr);
            }
        });
    });


    $('#tablaBienes').on('click', '.btnShowInfo', function () {
        var id = $(this).data('id');
        // Lógica para mostrar toda la información de la fila
        // Aquí puedes cargar los datos de la fila y mostrarlos en un modal o de otra manera.
    });

    $('#tablaBienes').on('click', '.btnDelete', function () {
        var codigo_bien = $(this).data('codigo_bien');

        // Confirmar eliminación
        if (confirm('¿Estás seguro de eliminar este bien?')) {
            // Enviar solicitud de eliminación al servidor
            $.ajax({
                url: urlEliminarBien,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    codigo_bien: codigo_bien
                },
                success: function (response) {
                    tablaBienes.ajax.reload();
                    alert(response.message); // Mostrar mensaje de éxito
                },
                error: function (xhr) {
                    alert('Error al eliminar el bien.');
                    console.error(xhr);
                }
            });
        }
    });
    // Evento para limpiar el contenido del modal cuando se oculta
    $('#modalQR').on('hidden.bs.modal', function () {
        $('#modalQRId').text('');
        $('#modalQRCodigoBien').text('');
        $('#modalQRCode').html('');
    });


    // Evento para cerrar el modal de QR
    document.addEventListener('close-modal', event => {
        $('#modalQR').modal('hide');
    });



});

