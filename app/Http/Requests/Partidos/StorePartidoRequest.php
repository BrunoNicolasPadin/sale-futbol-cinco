<?php

namespace App\Http\Requests\Partidos;

use Illuminate\Foundation\Http\FormRequest;

class StorePartidoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:150',
            'fechaHoraFinalizacion' => 'required|string|max:19',
            'lugar' => 'required|string|max:255',
            'cuantosFaltan' => 'required|string|max:2',
            'precio' => 'required|string|max:10',
            'tipoDeCancha' => 'required|string|min:1|max:2',
            'estado' => 'required|string|max:20',
            'detalles' => 'nullable|string|max:1000',
        ];
    }
}
