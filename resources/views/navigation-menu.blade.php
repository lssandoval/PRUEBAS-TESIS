<nav class="bg-gray-700 shadow">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                    {{ Auth::user()->name }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Gestionar Cuenta') }}
                            </div>

                            @can('uin.roles')
                            <x-dropdown-link href="{{ route('roles.index') }}" :active="request()->routeIs('roles.index')">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-user-plus mr-4"></i> <!-- Agrega el ícono aquí -->
                                    {{ __('Asignación de Roles') }}
                                </div>
                            </x-dropdown-link>
                            @endcan

                            @canany(['uin.bienes', 'utic.bienes','visualizador.bienes'])
                            <x-dropdown-link @click="open = !open" class="cursor-pointer">
                                {{ __('Mis Bienes Tecnológicos') }}
                            </x-dropdown-link>
                            @endcan

                            @canany(['uin.bienes', 'utic.bienes'])
                            <x-dropdown-link @click="open = !open" class="cursor-pointer">
                                {{ __('Bienes Tecnológicos') }}
                            </x-dropdown-link>
                            <div x-show="open" @click.away="open = false" class="pl-4">
                                @canany(['uin.subirArchivo', 'utic.subirArchivo'])
                                <x-dropdown-link href="{{ route('subirArchivo') }}" :active="request()->routeIs('subirArchivo')">
                                    {{ __('Matriz Bienes Tecnológicos') }}
                                </x-dropdown-link>
                                @endcan
                                @canany(['uin.subirArchivoComponentes', 'utic.subirArchivoComponentes'])
                                <x-dropdown-link href="{{ route('subirArchivoComponentes') }}" :active="request()->routeIs('subirArchivoComponentes')">
                                    {{ __('Matriz Componentes Tecnológicos') }}
                                </x-dropdown-link>
                                @endcan
                                @canany(['uin.bienes', 'utic.bienes'])
                                <x-dropdown-link href="{{ route('bienes-tecnologicos') }}" :active="request()->routeIs('bienes-tecnologicos')">
                                    {{ __('Gestión Bienes Tecnológicos') }}
                                </x-dropdown-link>
                                @endcan
                                @canany(['uin.asistencias_tecnologicas', 'utic.asistencias_tecnologicas'])
                                <x-dropdown-link href="{{ route('asistencias_tecnologicas') }}" :active="request()->routeIs('asistencias_tecnologicas')">
                                    {{ __('Revisión Bienes Tecnológicos') }}
                                </x-dropdown-link>
                                @endcan
                                @canany(['uin.programacion-mantenimientos', 'utic.programacion-mantenimientos'])
                                <x-dropdown-link href="{{ route('programacion-mantenimientos') }}" :active="request()->routeIs('programacion-mantenimientos')">
                                    {{ __('Mantenimientos Bienes Tecnológicos') }}
                                </x-dropdown-link>
                                @endcan
                            </div>
                            @endcan

                            @canany(['uin.notificaciones', 'utic.notificaciones', 'visualizador.notificaciones'])
                            <x-dropdown-link href="{{ route('notificaciones') }}" :active="request()->routeIs('notificaciones')">
                                {{ __('Notificaciones') }}
                            </x-dropdown-link>
                            @endcan

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link @click="open = !open" class="cursor-pointer">
                {{ __('Gestionar Cuenta') }}
            </x-responsive-nav-link>
            <div x-show="open" @click.away="open = false" class="pl-4">
                @can('uin.roles')
                <x-responsive-nav-link href="{{ route('roles.index') }}" :active="request()->routeIs('roles.index')">
                    {{ __('Asignación de Roles') }}
                </x-responsive-nav-link>
                @endcan

                @canany(['uin.bienes', 'utic.bienes'])
                <x-responsive-nav-link @click="subMenuOpen = !subMenuOpen" class="cursor-pointer">
                    {{ __('Bienes Tecnológicos') }}
                </x-responsive-nav-link>
                <div x-show="subMenuOpen" @click.away="subMenuOpen = false" class="pl-4">
                    @canany(['uin.subirArchivo', 'utic.subirArchivo'])
                    <x-responsive-nav-link href="{{ route('subirArchivo') }}" :active="request()->routeIs('subirArchivo')">
                        {{ __('Matriz Bienes Tecnológicos') }}
                    </x-responsive-nav-link>
                    @endcan
                    @canany(['uin.subirArchivoComponentes', 'utic.subirArchivoComponentes'])
                    <x-responsive-nav-link href="{{ route('subirArchivoComponentes') }}" :active="request()->routeIs('subirArchivoComponentes')">
                        {{ __('Matriz Componentes Tecnológicos') }}
                    </x-responsive-nav-link>
                    @endcan
                    @canany(['uin.bienes', 'utic.bienes'])
                    <x-responsive-nav-link href="{{ route('bienes-tecnologicos') }}" :active="request()->routeIs('bienes-tecnologicos')">
                        {{ __('Gestión Bienes Tecnológicos') }}
                    </x-responsive-nav-link>
                    @endcan
                    @canany(['uin.asistencias_tecnologicas', 'utic.asistencias_tecnologicas'])
                    <x-responsive-nav-link href="{{ route('asistencias_tecnologicas') }}" :active="request()->routeIs('asistencias_tecnologicas')">
                        {{ __('Revisión Bienes Tecnológicos') }}
                    </x-responsive-nav-link>
                    @endcan
                    @canany(['uin.programacion-mantenimientos', 'utic.programacion-mantenimientos'])
                    <x-responsive-nav-link href="{{ route('programacion-mantenimientos') }}" :active="request()->routeIs('programacion-mantenimientos')">
                        {{ __('Mantenimientos Bienes Tecnológicos') }}
                    </x-responsive-nav-link>
                    @endcan
                </div>
                @endcan

                @canany(['uin.notificaciones', 'utic.notificaciones', 'visualizador.notificaciones'])
                <x-responsive-nav-link href="{{ route('notificaciones') }}" :active="request()->routeIs('notificaciones')">
                    {{ __('Notificaciones') }}
                </x-responsive-nav-link>
                @endcan

                @if (Auth::user()->roles->isEmpty())
                <div class="border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Lo sentimos.</strong>
                    <span class="block sm:inline">Comunícate con el área de UIN.</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-xs text-gray-400 dark:text-gray-300">
                    {{ __('Gestionar Cuenta') }}
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-responsive-nav-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
