<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'nuevat'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla

    // Aquí puedes especificar los campos que puedes rellenar
    protected $fillable = [
        'codigo_bien',
        'codigo_anterior',
        'identificador',
        'nro_acta_matriz',
        'bld_bca',
        'bien',
        'serie_identificacion',
        'modelo_caracteristicas',
        'marca_otros',
        'critico',
        'moneda',
        'valor_compra',
        'recompra',
        'color',
        'material',
        'dimensiones',
        'condicion_bien',
        'habilitado',
        'estado_bien',
        'id_bodega',
        'bodega',
        'id_ubicacion',
        'ubicacion_bodega',
        'nro_cedula_ruc',
        'custodio_actual',
        'custodio_activo',
        'origen_ingreso',
        'tipo_ingreso',
        'nro_compromiso',
        'estado_acta',
        'contabilizado_acta',
        'contabilizado_bien',
        'descripcion',
        'item_renglon',
        'cuenta_contable',
        'depreciable',
        'fecha_creacion',
        'fecha_ingreso',
        'fecha_ultima_depreciacion',
        'vida_util',
        'fecha_termino_depreciacion',
        'valor_contable',
        'valor_residual',
        'valor_en_libros',
        'valor_depreciacion_acumulada',
        'comodato'
    ];
}
