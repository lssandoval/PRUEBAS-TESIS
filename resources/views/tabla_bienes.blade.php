<x-app-layout>
    <x-slot name="header">
        @can('utic.bienes')
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Gestión Bienes Tecnológicos') }}
        </h2>
        @endcan
        @can('visualizador.datatable.bienes')
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Mis Bienes') }}
        </h2>
        @endcan

    </x-slot>

    <div class="container-fluid py-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 flex justify-between items-center">
                        <!-- Botón Generar Códigos QR en Masa -->
                        <div class="mb-3">
                            @can('utic.generate-qrcode')
                            <form action="{{ route('generar.qrs') }}" method="POST" wire:submit.prevent="showLoadingModal">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-qrcode text-yellow-500"></i> <!-- Icono QR amarillo -->
                                    Generar Códigos QR en Masa
                                </button>
                            </form>
                            @endcan
                        </div>
                        <!-- Recuadro informativo (Tutorial) -->
                        <div class="mb-3 bg-gray-200 p-3 rounded">
                            <div class="text-center text-lg font-bold mb-2">
                                --IMPORTANTE--
                            </div>
                            <span class="text-sm ml-2">
                                <span class="tooltip-icon text-yellow-500"><i class="fa-solid fa-pen-to-square fa-lg"></i></span> Modificar: Permite editar la información del activo seleccionado.
                                <br>
                                <span class="tooltip-icon text-blue-500"><i class="fa-solid fa-qrcode fa-lg"></i></span> Generar QR: Permite generar un código QR para el activo seleccionado.
                                <br>
                                <span class="tooltip-icon text-red-500"><i class="fa-solid fa-trash fa-lg"></i></span> Eliminar: Permite eliminar el activo seleccionado.
                            </span>
                        </div>

                        <!-- Botón Generar Excel con QR -->
                        <div class="mb-3">
                            @can('utic.generar.qrs')
                            <a href="{{ route('generar.pdf') }}" class="btn btn-success" wire:click.prevent="showLoadingModal">
                                <i class="fa-regular fa-file-excel"></i> <!-- Icono de Excel -->
                                Generar Excel con QR
                            </a>
                            @endcan
                        </div>

                        <div class="mb-3">
                            @can('utic.generar.pdf')
                            <a href="{{ route('generar.pdfReporte') }}" class="btn btn-danger" wire:click.prevent="showLoadingModal">
                                <i class="fa-solid fa-file-pdf"></i> <!-- Icono de PDF -->
                                Generar PDF
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="tablaBienes">
                        <thead>
                            <tr class="bg-gray-100">
                                <th scope="col" class="fixed-column">Información</th>
                                <th scope="col" class="fixed-column">Acciones</th>
                                <th scope="col">ID</th>
                                <th scope="col">Código Bien</th>
                                <th scope="col">En Uso</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Serial</th>
                                <th scope="col">Ubicación</th>
                                <th scope="col">Custodio Identificado</th>
                                <th scope="col">Fecha Ingreso</th>
                                <th scope="col">Periodo Garantía</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha Último Mantenimiento</th>
                                <th scope="col">Recomendación 1</th>
                                <th scope="col">Recomendación 2</th>
                                <th scope="col">Cédula Esbye</th>
                                <th scope="col">Custodio Esbye</th>
                                <th scope="col">Serial Esbye</th>
                                <th scope="col">Modelo Esbye</th>
                                <th scope="col">Descripción Esbye</th>
                                <th scope="col">Fecha Creación</th>
                                <th scope="col">Fecha Actualización</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @livewire('modales.modal-codigo-q-r')
    @push('scripts')


    <!-- Variable JavaScript para la ruta -->
    <script>
        const routeBienes = "{{ route('datatable.bienes') }}";
    </script>
    <script>
        var generateQRUrl = "{{ route('generate-qrcode') }}";
    </script>
    <!-- Aquí asumo que tienes algo así en tu vista Blade -->
    <script>
        var urlEliminarBien = "{{ route('eliminar-bien') }}";
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.dispatch('mostrarModal');
            Livewire.dispatch('ocultarModal');
        })
    </script>

    <!-- Scripts personalizados -->
    <script src="{{ asset('js/components/modalEditarBien.js') }}"></script>
    <script src="{{ asset('js/components/modalQR.js') }}"></script>
    <script src="{{ asset('js/components/dataTables.js') }}"></script>
    @endpush
</x-app-layout>