<?php

namespace App\Services\Archivos;

class ArchivoService
{
    public function subirArchivo($request, $carpeta)
    {
        $archivo = $request->file('archivo');
        $unique = substr(base64_encode(mt_rand()), 0, 6);
        $nombreArchivo = $unique . '-' . $archivo->getClientOriginalName();
        /* $request->file('archivo')->storePubliclyAs($carpeta, $nombreArchivo, 's3'); */
        $archivo->storeAs($carpeta, $nombreArchivo);
        return $nombreArchivo;
    }

    public function subirArchivoArray($archivo, $carpeta)
    {
        $unique = substr(base64_encode(mt_rand()), 0, 6);
        $nombreArchivo = $unique . '-' . $archivo->getClientOriginalName();
        $archivo->storeAs($carpeta, $nombreArchivo, 's3');
        /* $archivo->storeAs($carpeta, $nombreArchivo); */
        return $nombreArchivo;
    }
}
