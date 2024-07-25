<?php

namespace proyecto\Models;
use proyecto\Models\Models;
use proyecto\Response\Success;


class productos_servicios extends Models
{
    
    protected $filleable = ["ID_PRODUCTO,NOMBRE,DESCRIPCION,PRECIO,STOCK,ID_CATEGORIA"];
    protected $table = "productos_servicios";

    public function mostrarproductos(){
        $productos_servicios = productos_servicios::all();
        $success = new Success($productos_servicios);
        return $success->send();
    }


}