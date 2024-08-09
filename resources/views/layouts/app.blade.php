<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/577c509b41.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</head>

<body class="font-sans antialiased">
    <x-banner />

       <div class="min-h-screen bg-gray-100">
        <div class="shrink-0 flex items-center p-4 bg-gray-800">
            <div class="flex items-center justify-center h-16 bg-gray-800">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-mark class="block h-12 w-auto" />
                </a>
            </div>

            <div class="mx-auto" style="width: calc(100% - 4rem); max-width: 100%; padding: 0 2rem;">
                <img src="{{ asset('images/TITULO.png') }}" alt="SISTEMA DE GESTIÓN DE BIENES TECNOLÓGICOS COSEDE" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
            </div>
            @livewire('navigation-menu')
        </div>

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-gray-800 shadow w-full">
            <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
                @isset($coordinacion)
                <p>Coordinación: {{ $coordinacion }}</p>
                @endisset
                @isset($roleAsignado)
                <p>Role Asignado: {{ $roleAsignado }}</p>
                @endisset
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')
</body>

</html>