<?php

namespace App\Http\Requests\Postulaciones;

use Illuminate\Foundation\Http\FormRequest;

class CalificacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'puntaje' => 'required|integer|between:1,10',
            'comentario' => 'nullable|string|max:1000',
        ];
    }
}
