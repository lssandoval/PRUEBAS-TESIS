<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-50 leading-tight">
            {{ __('Historial de Carga de Información') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Historial de Carga</h3>
                <p class="text-sm text-gray-500 dark:text-gray-300 mb-6">Ver el historial de archivos cargados.</p>

                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr>
                            <th class="w-1/3 py-2 text-left text-gray-600 dark:text-gray-200">Usuario</th>
                            <th class="w-1/3 py-2 text-left text-gray-600 dark:text-gray-200">Nombre del Archivo</th>
                            <th class="w-1/3 py-2 text-left text-gray-600 dark:text-gray-200">Fecha de Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historial as $registro)
                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                <td class="py-2 px-4 text-gray-600 dark:text-gray-200">{{ $registro->usuario }}</td>
                                <td class="py-2 px-4 text-gray-600 dark:text-gray-200">{{ $registro->nombre_archivo }}</td>
                                <td class="py-2 px-4 text-gray-600 dark:text-gray-200">{{ $registro->fecha_subida }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
