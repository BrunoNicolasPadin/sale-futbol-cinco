<?php

namespace App\Models\Partidos;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionPartido extends Model
{
    use HasFactory;
    use Uuids;

    protected $table = 'calificaciones_partidos';

    protected $fillable = [
        'puntaje',
        'comentario',
    ];

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
