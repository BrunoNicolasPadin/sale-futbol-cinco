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

    public function scopeFiltrar($query, $request)
    {
        return $query->when($request->nombre, function ($query, $nombre) {
            $query->where('nombre', 'LIKE', '%'.$nombre.'%');
        })->when($request->cuantosFaltan, function ($query, $cuantosFaltan) {
            $query->where('cuantosFaltan', $cuantosFaltan);
        })->when($request->tipoDeCancha, function ($query, $tipoDeCancha) {
            $query->where('tipoDeCancha', $tipoDeCancha);
        })->when($request->user_id, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        });
    }
}
