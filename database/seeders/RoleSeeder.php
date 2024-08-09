<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        if (!Role::where('name', 'UTIC')->exists()) {
            $roleUTIC = Role::create(['name' => 'UTIC']);
        } else {
            $roleUTIC = Role::where('name', 'UTIC')->first();
        }

        if (!Role::where('name', 'UIN')->exists()) {
            $roleUIN = Role::create(['name' => 'UIN']);
        } else {
            $roleUIN = Role::where('name', 'UIN')->first();
        }

        // Crear el rol Consulta_Visualizador si no existe
        if (!Role::where('name', 'VISUALIZADOR')->exists()) {
            $roleVisualizador = Role::create(['name' => 'VISUALIZADOR']);
        } else {
            $roleVisualizador = Role::where('name', 'VISUALIZADOR')->first();
        }

        // Crear permisos para el rol UTIC
        $permissionsUTIC = [
            'utic.dashboard',
            'utic.bienes',
            'utic.datatable.bienes',
            'utic.editar-bien',
            'utic.eliminar-bien',
            'utic.actualizar-bien',
            'utic.subirArchivo',
            'utic.subirArchivoComponentes',
            'utic.historial-carga',
            'utic.generate-qrcode',
            'utic.generar.qrs',
            'utic.generar.pdf',
            'utic.mostrarMantenimientos',
            'utic.guardar-mantenimiento',
            'utic.programacion-mantenimientos',
            'utic.generar.pdfReporte',
            'utic.asistencias_tecnologicas',
            'utic.asistencias.store',
            'utic.asistencias.storeSolution',
            'utic.notificaciones',
        ];

        foreach ($permissionsUTIC as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Crear permisos para el rol UIN
        $permissionsUIN = [
            'uin.roles',
            'uin.notificaciones',
            'uin.dashboard',
            'uin.bienes',
            'uin.datatable.bienes',
            'uin.editar-bien',
            'uin.eliminar-bien',
            'uin.actualizar-bien',
            'uin.subirArchivo',
            'uin.subirArchivoComponentes',
            'uin.historial-carga',
            'uin.generate-qrcode',
            'uin.generar.qrs',
            'uin.generar.pdf',
            'uin.mostrarMantenimientos',
            'uin.guardar-mantenimiento',
            'uin.programacion-mantenimientos',
            'uin.generar.pdfReporte',
            'uin.asistencias_tecnologicas',
            'uin.asistencias.store',
            'uin.asistencias.storeSolution',
        ];

        foreach ($permissionsUIN as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Crear permisos para el rol Consulta_Visualizador
        $permissionsVisualizador = [
            'visualizador.bienes',
            'visualizador.dashboard',
            'visualizador.notificaciones',
        ];

        foreach ($permissionsVisualizador as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Asignar permisos a los roles
        $roleUTIC->givePermissionTo($permissionsUTIC);
        $roleUIN->givePermissionTo($permissionsUIN);
        $roleVisualizador->givePermissionTo($permissionsVisualizador);
    }
}
