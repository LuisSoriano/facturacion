<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracionSiat extends Model
{
    protected $guarded = ['id'];

    protected $table = 'configuracion_siat';

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function getUrls()
    {
        return [
            'sincronizacion' => $this->url_sincronizacion ?? config('siat.urls.sincronizacion'),
            'operaciones' => $this->url_operaciones ?? config('siat.urls.operaciones'),
            'codigos' => $this->url_codigos ?? config('siat.urls.codigos'),
            'facturacion' => $this->url_facturacion ?? config('siat.urls.facturacion'),
        ];
    }

    public static function getConfig()
    {
        $config = self::first();
        return [
            'nit' => $config->nit ?? config('siat.nit'),
            'razon_social' => $config->razon_social ?? config('siat.razon_social'),
            'codigo_sistema' => $config->codigo_sistema ?? config('siat.codigo_sistema'),
            'nombre_sistema' => $config->nombre_sistema ?? config('siat.nombre_sistema'),
            'codigo_ambiente' => $config->codigo_ambiente ?? config('siat.codigo_ambiente'),
            'codigo_modalidad' => $config->codigo_modalidad ?? config('siat.modalidad'),
            'sucursal' => $config->codigo_sucursal ?? config('siat.sucursal'),
            'punto_venta' => $config->codigo_punto_venta ?? config('siat.punto_venta'),
            'cuis' => $config->cuis ?? config('siat.cuis'),
            'token' => $config->token_api ?? config('siat.token'),
            'usuario' => config('siat.usuario'), // Este no cambia
            'urls' => $config ? $config->getUrls() : config('siat.urls'),
        ];
    }
}