<?php

namespace App\Models\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;
    use Uuids;

    protected $table = 'postulaciones';

    protected $fillable = [
        'estado',
        'puntaje',
        'comentario',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }
}
