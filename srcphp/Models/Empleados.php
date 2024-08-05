<?php

namespace proyecto\Models;
use proyecto\Models\Models;
use proyecto\Response\Success;


class Empleados extends Models{

    
    protected $fillable = ["ID_EMPLEADO", "ID_PERSONA", "FECHA_REGISTRO", "DIRECCION", "CURP", "RFC", "NUMERO_SEGURO"];
    protected $table = "Empleados";
}