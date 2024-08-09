<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Mantenimientos del Bien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Mantenimientos del Bien: {{ $bien->codigo_bien }}</h3>
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Historial de Mantenimientos</h4>
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Tipo</th>
                                    <th class="px-4 py-2">Observación</th>
                                    <th class="px-4 py-2">Recomendación</th>
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Técnico</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mantenimientos as $mantenimiento)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $mantenimiento->tipo_mantenimiento }}</td>
                                        <td class="border px-4 py-2">{{ $mantenimiento->observacion_mantenimiento }}</td>
                                        <td class="border px-4 py-2">{{ $mantenimiento->recomendacion_mantenimiento }}</td>
                                        <td class="border px-4 py-2">{{ $mantenimiento->fecha_mantenimiento }}</td>
                                        <td class="border px-4 py-2">{{ $mantenimiento->tecnico_mantenimiento }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="border px-4 py-2 text-center" colspan="5">No hay mantenimientos registrados para este bien.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Registrar Mantenimiento</h4>
                        <form action="{{ route('guardar-mantenimiento') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_nuevat" value="{{ $bien->id }}">
                            <div class="form-group">
                                <label for="codigoBien" class="form-label">Código Bien</label>
                                <input type="text" class="form-control" id="codigoBien" name="codigo_bien" value="{{ $bien->codigo_bien }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tipoMantenimiento">Tipo de Mantenimiento</label>
                                <select class="form-control" id="tipoMantenimiento" name="tipo_mantenimiento">
                                    <option value="">Seleccionar</option>
                                    <option value="preventivo">Preventivo</option>
                                    <option value="correctivo">Correctivo</option>
                                </select>
                            </div>
                            <div id="detalleMantenimiento" style="display: none;">
                                <div class="form-group">
                                    <label for="detallePreventivo">Detalle de Mantenimiento Preventivo</label>
                                    <select class="form-control" id="detallePreventivo" name="detalle_preventivo">
                                        <option value="">Seleccionar</option>
                                        <option value="fuera_vigencia">Mantenimiento a equipos fuera de vigencia tecnológica</option>
                                        <option value="dentro_vigencia">Mantenimiento a equipos dentro de vigencia tecnológica</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observacionMantenimiento">Observación</label>
                                <textarea class="form-control" id="observacionMantenimiento" name="observacion_mantenimiento"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="recomendacionMantenimiento">Recomendación</label>
                                <textarea class="form-control" id="recomendacionMantenimiento" name="recomendacion_mantenimiento"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fechaMantenimiento">Fecha de Mantenimiento</label>
                                <input type="date" class="form-control" id="fechaMantenimiento" name="fecha_mantenimiento">
                            </div>
                            <div class="form-group">
                                <label for="tecnicoMantenimiento">Técnico de Mantenimiento</label>
                                <input type="text" class="form-control" id="tecnicoMantenimiento" name="tecnico_mantenimiento">
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoMantenimientoSelect = document.getElementById('tipoMantenimiento');
        const detalleMantenimientoDiv = document.getElementById('detalleMantenimiento');

        tipoMantenimientoSelect.addEventListener('change', function () {
            if (this.value === 'preventivo') {
                detalleMantenimientoDiv.style.display = 'block';
            } else {
                detalleMantenimientoDiv.style.display = 'none';
            }
        });
    });
</script>
@endpush
