<?php

namespace proyecto\Models;
use proyecto\Models\Models;
use proyecto\Response\Success;


/**
 * Class Inbody_citas
 */
class inbody_citas extends Models
{
    
    protected $filleable = ["ID_CITA,ID_CLIENTE,ID_FECHA_HORA,PRECIO,FORMA_PAGO,ESTADO_CITA"];
    protected $table = "inbody_citas";

    public function mostrarcitas(){
        $inbody_citas = inbody_citas::all();
        $success = new Success($inbody_citas);
        return $success->send();
    }


}