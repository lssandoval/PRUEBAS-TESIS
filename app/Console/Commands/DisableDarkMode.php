<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DisableDarkMode extends Command
{
    protected $signature = 'app:disable-dark-mode';

    protected $description = 'Disable dark mode in the application';

    public function handle()
    {
        // Paso 1: Modificar tailwind.config.js
        // Aquí podrías modificar tailwind.config.js si tuvieras configuraciones específicas de modo oscuro

        // Paso 2: Modificar app.blade.php
        $path = base_path('resources/views/layouts/app.blade.php');
        $content = file_get_contents($path);

        // Eliminar clases dark: de Tailwind CSS
        $content = str_replace('dark:', '', $content);

        file_put_contents($path, $content);

        $this->info('Dark mode disabled successfully.');
    }
}
