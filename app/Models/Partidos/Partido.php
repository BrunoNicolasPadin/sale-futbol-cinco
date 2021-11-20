<?php

namespace App\Models\Partidos;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'nombre',
        'slug',
        'detalles',
        'fechaHoraFinalizacion',
        'lugar',
        'cuantosFaltan',
        'tipoDeCancha',
        'precio',
        'estado',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
