<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Empresa extends Model
{
    protected $guarded = ['id'];

    protected $table = 'empresa';

    public function moneda(): BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }

    public function configuracionSiat(): HasOne
    {
        return $this->hasOne(ConfiguracionSiat::class);
    }
}
