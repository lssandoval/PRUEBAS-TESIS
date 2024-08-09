<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Bienvenid@') }} {{ Auth::user()->name }}
        </h2>
        <div class="flex justify-between items-center font-semibold text-xl text-gray-50 leading-tight">
            <!-- Coordinación a la izquierda -->
            @isset($coordinacion)
            <div class="flex-1">
                <p>Coordinación: {{ $coordinacion }}</p>
            </div>
            @endisset

            <!-- Roles asignados a la derecha -->
            @isset($rolesAsignadosNombres)
            <div class="flex-1 text-right">
                <p>Roles Asignados:</p>
                <ul class="list-none">
                    @foreach($rolesAsignadosNombres as $rol)
                    <li>{{ $rol }}</li>
                    @endforeach
                </ul>
            </div>
            @endisset
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Contenedor Superior -->
            <div class="flex space-x-6">
                <!-- Contenedor Izquierdo -->
                <div class="w-1/2 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Programación Mantenimientos</h3>
                    <p>Seleccione una fecha en el calendario y complete el formulario para registrar un nuevo mantenimiento.</p>
                    <button id="registerMaintenanceBtn" class="mt-4 px-4 py-2 bg-white text-gray-800 rounded-md">Registrar Mantenimiento</button>
                </div>

                <!-- Contenedor Derecho -->
                <div class="w-1/2 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Seleccionar Fecha</h3>
                    <input type="text" id="datepicker" class="p-2 border border-gray-300 rounded-md shadow-sm w-full">
                </div>
            </div>

            <!-- Tabla de Mantenimientos -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">FECHA Mantenimiento Programada</th>
                            <th class="py-2 px-4 border-b">CÓDIGO DEL BIEN</th>
                            <th class="py-2 px-4 border-b">TIPO DE BIEN</th>
                            <th class="py-2 px-4 border-b">USO DEL BIEN</th>
                            <th class="py-2 px-4 border-b">CUSTODIO DEL BIEN</th>
                            <th class="py-2 px-4 border-b">HORA DE INICIO</th>
                            <th class="py-2 px-4 border-b">HORA DE FINALIZACIÓN</th>
                            <th class="py-2 px-4 border-b">TÉCNICO ASIGNADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mantenimientos as $mantenimiento)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->fecha_mantenimiento }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->codigo_bien }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->tipo_bien }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->uso_bien }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->custodio_bien }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->hora_inicio }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->hora_fin }}</td>
                            <td class="py-2 px-4 border-b">{{ $mantenimiento->tecnico_asignado }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pikaday CSS -->
    <link href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css" rel="stylesheet">

    <!-- Pikaday JS -->
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectedDate = null;
            var picker = new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'YYYY-MM-DD',
                onSelect: function(date) {
                    selectedDate = date.toISOString().split('T')[0];
                }
            });

            document.getElementById('registerMaintenanceBtn').addEventListener('click', function() {
                if (selectedDate) {
                    // Enviar un evento personalizado con la fecha seleccionada
                    document.dispatchEvent(new CustomEvent('register-maintenance', {
                        detail: {
                            date: selectedDate
                        }
                    }));
                } else {
                    alert('Por favor, seleccione una fecha antes de registrar el mantenimiento.');
                }
            });



            document.addEventListener('close-modal', event => {
                var modalElement = document.getElementById('modalProgramarMantenimientos');
                var modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
            });

            // Escuchar el evento personalizado y despachar el evento Livewire
            document.addEventListener('register-maintenance', function(event) {
                Livewire.dispatch('openModal', {
                    date: event.detail.date
                });
            });


            Livewire.on('openModalMantenimientos', function(date) {
                console.log("ENTRO")
                var modal = new bootstrap.Modal(document.getElementById('modalProgramarMantenimientos'));
                modal.show();
            });


        });
    </script>

    @livewire('maintenance-modal')
</x-app-layout>