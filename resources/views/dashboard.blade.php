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
    <div class="py-12 h-screen overflow-y-auto">
        <div class="mx-auto sm:px-6 lg:px-8">
            @if (Auth::user()->roles->isEmpty())
            <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg mb-8 px-4 mx-4">
                <div class="flex items-center p-6">
                    <div class="flex-grow text-center">
                        <img src="{{ asset('images/visualizador.png') }}" alt="Visualizador" style="width: 10cm; height: 10cm;" class="mx-auto mb-5">
                        <div class="bg-yellow-200 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">¡Hola!</strong>
                            <span class="block sm:inline">Parece que no tienes un rol definido. Por favor, contacta a la Unidad de Inteligencia de Negocios (UIN) para obtener un rol que te permita navegar por el sistema de gestión de bienes.</span>
                        </div>
                        <button onclick="logoutAndRedirect()" class="mt-4 inline-block px-6 py-3 bg-blue-500 text-red-500 text-lg font-bold rounded-lg shadow-md hover:bg-blue-600">
                            REGRESAR A LA INTRANET
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Primera Sección -->
        @can('uin.roles')
        <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg mb-8 px-4 mx-4">
            <div class="flex items-center p-6">
                <div class="flex-grow">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-1">Asignación Roles</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Asignar y gestionar roles para los usuarios del sistema.</p>
                </div>
                <div class="ml-6">
                    <a href="{{ route('roles.index') }}" class="nav-link" title="Ir a Roles">
                        <i class="fa-solid fa-users fa-3x text-gray-800"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan
        <!-- Primera Sección -->
        @canany(['uin.bienes', 'utic.bienes','visualizador.bienes'])
        <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg mb-8 px-4 mx-4">
            <div class="flex items-center p-6">
                <div class="flex-grow">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-1">Mis Bienes</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Mostrar Lista de Bienes Tecnológicos Asignados A Mi Nombre</p>
                </div>
                <div class="ml-6">
                    <a href="{{ route('bienes-tecnologicos') }}" class="nav-link" title="Ir a Bienes">
                        <i class="fa-regular fa-rectangle-list fa-3x text-gray-800"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan
        <!-- Sección para Bienes Tecnológicos -->
        @canany(['uin.bienes', 'utic.bienes'])
        <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg mb-8 px-4 mx-4">
            <div class="flex items-center p-6">
                <div class="flex-grow">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-1">Bienes Tecnológicos</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Gestion de bienes tecnológicos. (Listado Bienes Tecnológicos, Asistencia Tecnológica, Mantenimientos, Historial de Carga)</p>
                </div>
                <div class="ml-6">
                    <button id="toggle-tech-assets" class="nav-link" title="Mostrar Opciones">
                        <i class="fa-solid fa-network-wired fa-3x text-gray-800"></i>
                    </button>
                </div>
            </div>
            <!-- Opciones ocultas inicialmente -->
            <div id="tech-assets-options" class="hidden">
                <!-- Subir Listado Bienes -->
                @canany(['uin.subirArchivo', 'utic.subirArchivo'])
                <div class="bg-gray-300 shadow overflow-hidden shadow-xl sm:rounded-lg mb-4 px-4 mx-4">
                    <div class="flex items-center p-4">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Matris Bienes Tecnológicos</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">Cargar Archivo De Excel Con El Listado De Bienes Tecnológicos Del Maestro De Bienes UTIC.</p>
                        </div>
                        <div class="ml-6">
                            <a type="button" class="nav-link text-actualizar" title="Subir Archivo" data-bs-toggle="modal" data-bs-target="#modalSubir">
                                <i class="fa-solid fa-file-upload fa-2x text-gray-800"></i>
                            </a>
                            @livewire('modales.modal-subir')
                        </div>
                    </div>
                </div>
                @endcan

                <!-- Subir Listado Componentes Tecnológicos -->
                @canany(['uin.subirArchivoComponentes', 'utic.subirArchivoComponentes'])
                <div class="bg-gray-300 shadow overflow-hidden shadow-xl sm:rounded-lg mb-4 px-4 mx-4">
                    <div class="flex items-center p-4">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Matriz Componentes Tecnológicos</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">Cargar Archivo De Excel Con El Listado De Componentes Tecnológicos Del Maestro De Bienes UTIC.</p>
                        </div>
                        <div class="ml-6">
                            <a type="button" class="nav-link text-actualizar" title="Subir Archivo Componentes" data-bs-toggle="modal" data-bs-target="#modalSubirComponentes">
                                <i class="fa-solid fa-microchip fa-2x text-gray-800"></i>
                            </a>
                            @livewire('modales.modal-subir-componentes')
                        </div>
                    </div>
                </div>
                @endcan

                <!-- Mostrar Listado Bienes -->
                @canany(['uin.bienes', 'utic.bienes'])
                <div class="bg-gray-300 shadow overflow-hidden shadow-xl sm:rounded-lg mb-4 px-4 mx-4">
                    <div class="flex items-center p-4">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Gestión Bienes Tecnológicos</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">Ver Listado Actualizado de Bienes Tecnológicos y Componentes Tecnológicos.</p>
                        </div>
                        <div class="ml-6">
                            <a href="{{ route('bienes-tecnologicos') }}" class="nav-link" title="Ir a Bienes">
                                <i class="fa-regular fa-rectangle-list fa-2x text-gray-800"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endcan

                @canany(['uin.asistencias_tecnologicas', 'utic.asistencias_tecnologicas'])
                <div class="bg-gray-300 shadow overflow-hidden shadow-xl sm:rounded-lg mb-4 px-4 mx-4">
                    <div class="flex items-center p-4">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Revisión Bienes Tecnológicos</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">Realizar Una Revisión De Los Bienes Tecnológicos.</p>
                        </div>
                        <div class="ml-6">
                            <a href="{{ route('asistencias_tecnologicas') }}" class="nav-link" title="Ir a Historial">
                                <i class="fa-solid fa-square-check fa-2x text-gray-800"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endcan

                @canany(['uin.programacion-mantenimientos', 'utic.programacion-mantenimientos'])
                <div class="bg-gray-300 shadow overflow-hidden shadow-xl sm:rounded-lg mb-4 px-4 mx-4">
                    <div class="flex items-center p-4">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Mantenimientos Bienes Tecnológicos</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">Realizar Mantenimientos De Los Bienes Tecnológicos.</p>
                        </div>
                        <div class="ml-6">
                            <a href="{{ route('programacion-mantenimientos') }}" class="nav-link" title="Ir a Historial">
                                <i class="fa-solid fa-screwdriver fa-2x text-gray-800"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endcan
                <!-- Historial de Cargas -->
                @canany(['uin.historial-carga', 'utic.historial-carga'])
                <div class="bg-gray-300 shadow overflow-hidden shadow-xl sm:rounded-lg mb-4 px-4 mx-4">
                    <div class="flex items-center p-4">
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Historial de Cargas</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-300">Ver historial de archivos cargados.</p>
                        </div>
                        <div class="ml-6">
                            <a href="{{ route('historial-carga') }}" class="nav-link" title="Ir a Historial">
                                <i class="fa-solid fa-clock-rotate-left fa-2x text-gray-800"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        @endcan

        @canany(['uin.notificaciones', 'utic.notificaciones','visualizador.notificaciones'])
        <div class="bg-gray-400 shadow overflow-hidden shadow-xl sm:rounded-lg mb-8 px-4 mx-4">
            <div class="flex items-center p-6">
                <div class="flex-grow">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-1">Notificaciones</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Mis notificaciones (Asistencia Tecnológica, Mantenimentos)</p>
                </div>
                <div class="ml-6">
                    <a href="{{ route('bienes-tecnologicos') }}" class="nav-link" title="Ir a Bienes">
                        <i class="fa-regular fa-rectangle-list fa-3x text-gray-800"></i>
                    </a>
                </div>
            </div>
        </div>
        @endcan
    </div>
</x-app-layout>
<script>
    // Toggle para mostrar y ocultar las opciones de Bienes Tecnológicos
    document.getElementById('toggle-tech-assets').addEventListener('click', function() {
        var options = document.getElementById('tech-assets-options');
        options.classList.toggle('hidden');
    });
</script>


<script>
    function logoutAndRedirect() {
        fetch('{{ route("logout") }}', { // Asegúrate de que el helper route esté correctamente incluido
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) {
                    // Redirigir a la URL deseada después de cerrar sesión
                    window.location.href = 'http://depintranet.cosede.gob.ec/intranet/?page_id=2811';
                } else {
                    // Manejar el caso en que la respuesta no es exitosa
                    console.error('Error al cerrar sesión:', response.statusText);
                }
            })
            .catch(error => {
                // Manejar errores de la solicitud
                console.error('Error al cerrar sesión:', error);
            });
    }
</script>