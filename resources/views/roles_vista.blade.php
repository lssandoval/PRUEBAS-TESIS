<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Bienvenid@') }} {{ Auth::user()->name }}
        </h2>
        <div class="flex justify-between items-center font-semibold text-xl text-gray-50 leading-tight bg-gray-400 border border-black p-4 rounded-lg">
            <!-- Coordinación a la izquierda -->
            @isset($coordinacion)
            <div class="flex-1 bg-gray-300 p-2 rounded-lg">
                <p>Coordinación: {{ $coordinacion }}</p>
            </div>
            @endisset

            <!-- Roles asignados a la derecha -->
            @isset($rolesAsignadosNombres)
            <div class="flex-1 text-right bg-gray-300 p-2 rounded-lg">
                <p>Roles Asignados:</p>
                <ul class="list-none">
                    @foreach($rolesAsignadosNombres as $rol)
                    @php
                    // Reemplazar nombres de roles según la lógica especificada
                    $roleLabels = [
                    'UTIC' => 'Administrador UTIC',
                    'UIN' => 'Administrador Tecnológico',
                    'VISUALIZADOR' => 'VISUALIZADOR',
                    ];
                    $displayRole = $roleLabels[$rol] ?? $rol; // Usar el rol si no está en el array de reemplazos
                    @endphp
                    <li>{{ $displayRole }}</li>
                    @endforeach
                </ul>
            </div>
            @endisset
        </div>

    </x-slot>

    <div class="container-fluid py-12 px-3 mx-3">
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold mb-4">Listado de Roles</h3>
                <div class="table-responsive">
                    <table id="rolesTable" class="table table-striped">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordinación</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles Asignados</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se llenarán automáticamente con DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#rolesTable').DataTable({
                ajax: {
                    url: '/roles/data/',
                    type: 'GET',
                    dataType: 'json',
                    dataSrc: function(json) {
                        if (json.roles) {
                            window.rolesData = json.roles;
                        } else {
                            window.rolesData = {};
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: 'nombre_apellido',
                        name: 'nombre_apellido'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'coordinacion',
                        name: 'coordinacion'
                    },
                    {
                        data: 'role_asignado',
                        name: 'role_asignado'
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!window.rolesData) {
                                return 'No se han cargado los roles';
                            }

                            var options = Object.entries(window.rolesData).map(([id, name]) =>
                                `<option value="${id}" ${data.includes(parseInt(id)) ? 'selected' : ''}>${name}</option>`
                            ).join('');

                            return `<select multiple class="form-select" data-user-username="${row.nombre_apellido}">${options}</select>`;
                        }
                    },
                    {
                        data: null,
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-primary save-role" data-user-username="${row.nombre_apellido}">Guardar</button>
                        <button class="btn btn-danger remove-role" data-user-username="${row.nombre_apellido}">Eliminar Roles</button>
                    `;
                        }
                    }
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

            $('#rolesTable').on('click', '.save-role', function() {
                var nombre_apellido = $(this).data('user-username');
                var roles = $(this).closest('tr').find('select.form-select').val();

                if (!nombre_apellido) {
                    alert('Nombre de usuario no encontrado');
                    return;
                }

                if (!roles) {
                    alert('No se han seleccionado roles');
                    return;
                }

                var formData = {
                    roles: roles
                };

                $.ajax({
                    url: '/roles/update/' + encodeURIComponent(nombre_apellido),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Roles actualizados correctamente');
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        alert('Hubo un error al actualizar los roles');
                    }
                });
            });

            $('#rolesTable').on('click', '.remove-role', function() {
                var nombre_apellido = $(this).data('user-username');
                var roles = $(this).closest('tr').find('select.form-select').val();

                if (!nombre_apellido) {
                    alert('Nombre de usuario no encontrado');
                    return;
                }

                if (!roles) {
                    alert('No se han seleccionado roles');
                    return;
                }

                var formData = {
                    roles: roles
                };

                $.ajax({
                    url: '/roles/remove/' + encodeURIComponent(nombre_apellido),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Respuesta del servidor:', response);
                        alert('Roles eliminados correctamente');
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        alert('Hubo un error al eliminar los roles');
                    }
                });
            });
        });
    </script>
    @endpush

    <style>
        .table-container {
            margin: 0 1mm;
        }

        #rolesTable {
            width: calc(100% - 2mm);
            /* Ajusta el ancho de la tabla */
        }
    </style>
</x-app-layout>