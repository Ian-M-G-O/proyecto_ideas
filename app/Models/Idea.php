<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'autor',
        'categoria_id',
        'observacion', 
    ];
    
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

}