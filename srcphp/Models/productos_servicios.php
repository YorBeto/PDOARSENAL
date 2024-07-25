<?php

namespace proyecto\Models;
use proyecto\Models\Models;
use proyecto\Response\Success;


class productos_servicios extends Models
{
    
    protected $filleable = ["NOMBRE,PRECIO"];
    protected $table = "productos_servicios";

    public function mostrarproductos(){
        $productos_servicios = productos_servicios::all();
        $success = new Success($productos_servicios);
        return $success->send();
    }


}