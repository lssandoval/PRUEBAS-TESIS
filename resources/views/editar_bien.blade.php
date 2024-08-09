<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Editar Bien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('actualizar-bien', $bien->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Contenedor Izquierda -->
                        <div class="space-y-8">
                            <!-- Sección A: INFORMACION ESBYE -->
                            <div class="bg-gray-200 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">A. INFORMACION ESBYE</h3>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="codigo_bien" class="block text-sm font-medium text-gray-700">Código del Bien</label>
                                        <input type="text" id="codigo_bien" name="codigo_bien" value="{{ $bien->codigo_bien }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="descripcion_esbye" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <input type="text" id="descripcion_esbye" name="descripcion_esbye" value="{{ $bien->descripcion_esbye }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="cedula_esbye" class="block text-sm font-medium text-gray-700">Cédula Esbye</label>
                                        <input type="text" id="cedula_esbye" name="cedula_esbye" value="{{ $bien->cedula_esbye }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                                        <input type="text" id="fecha_ingreso" name="fecha_ingreso" value="{{ $bien->fecha_ingreso }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="serial_esbye" class="block text-sm font-medium text-gray-700">Serial Esbye</label>
                                        <input type="text" id="serial_esbye" name="serial_esbye" value="{{ $bien->serial_esbye }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="custodio_esbye" class="block text-sm font-medium text-gray-700">Custodio Esbye</label>
                                        <input type="text" id="custodio_esbye" name="custodio_esbye" value="{{ $bien->custodio_esbye }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="periodo_garantia" class="block text-sm font-medium text-gray-700">Periodo de Garantía</label>
                                        <input type="text" id="periodo_garantia" name="periodo_garantia" value="{{ $bien->periodo_garantia }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="modelo_esbye" class="block text-sm font-medium text-gray-700">Modelo Esbye</label>
                                        <input type="text" id="modelo_esbye" name="modelo_esbye" value="{{ $bien->modelo_esbye }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                    <div>
                                        <label for="proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
                                        <input type="text" id="proveedor" name="proveedor" value="{{ $bien->proveedor }}" class="form-control mt-1 block w-full border-gray-300 rounded-md" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección B: LEVANTAMIENTO TECNOLOGICO -->
                            <div class="bg-gray-200 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">B. LEVANTAMIENTO TECNOLOGICO</h3>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo Hardware</label>
                                        <input type="text" id="tipo" name="tipo" value="{{ $bien->tipo }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                                        <input type="text" id="marca" name="marca" value="{{ $bien->marca }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                                        <input type="text" id="modelo" name="modelo" value="{{ $bien->modelo }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="serial" class="block text-sm font-medium text-gray-700">Serial</label>
                                        <input type="text" id="serial" name="serial" value="{{ $bien->serial }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
                                        <input type="text" id="ubicacion" name="ubicacion" value="{{ $bien->ubicacion }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="custodio_identificado" class="block text-sm font-medium text-gray-700">Custodio Identificado</label>
                                        <input type="text" id="custodio_identificado" name="custodio_identificado" value="{{ $bien->custodio_identificado }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="en_uso" class="block text-sm font-medium text-gray-700">En Uso</label>
                                        <input type="text" id="en_uso" name="en_uso" value="{{ $bien->en_uso }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                                        <input type="text" id="estado" name="estado" value="{{ $bien->estado }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="fecha_ultimo_mantenimiento" class="block text-sm font-medium text-gray-700">Fecha Último Mantenimiento</label>
                                        <input type="text" id="fecha_ultimo_mantenimiento" name="fecha_ultimo_mantenimiento" value="{{ $bien->fecha_ultimo_mantenimiento }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="recomendacion_1" class="block text-sm font-medium text-gray-700">Recomendación 1</label>
                                        <input type="text" id="recomendacion_1" name="recomendacion_1" value="{{ $bien->recomendacion_1 }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="recomendacion_2" class="block text-sm font-medium text-gray-700">Recomendación 2</label>
                                        <input type="text" id="recomendacion_2" name="recomendacion_2" value="{{ $bien->recomendacion_2 }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contenedor Derecha -->
                        <div class="space-y-8">
                            <!-- Sección C: COMPONENTES TECNOLOGICOS -->
                            <div class="bg-gray-200 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">C. COMPONENTES TECNOLOGICOS</h3>
                                @foreach ($nuevaCs as $nuevaC)
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="codigo_bien_compuesto" class="block text-sm font-medium text-gray-700">Código Bien Compuesto</label>
                                        <input type="text" id="codigo_bien_compuesto" name="codigo_bien_compuesto[]" value="{{ $nuevaC->codigo_bien_compuesto }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="tipoC" class="block text-sm font-medium text-gray-700">Tipo</label>
                                        <input type="text" id="tipoC" name="tipoC[]" value="{{ $nuevaC->tipoC }}" class="form-control mt-1 block w-full border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="descripcionC" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea id="descripcionC" name="descripcionC[]" rows="3" class="form-control mt-1 block w-full border-gray-300 rounded-md">{{ $nuevaC->descripcionC }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Guardar Cambios</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>