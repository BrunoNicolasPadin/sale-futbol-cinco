<?php

namespace App\Services\Slugs;

use Illuminate\Support\Str;

class SlugService
{
    public function obtenerSlug($nombre)
    {
        $randomNumber = substr(mt_rand(), 0, 4);
        $str = Str::slug($nombre, '-');
        return $str . '-' . $randomNumber;
    }
}
