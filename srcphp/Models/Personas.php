<?php


namespace proyecto\Models;
use proyecto\Models\Models;
use proyecto\Response\Success;




class Personas extends Models{

    
    
    protected $fillable = ["ID_PERSONA", "ID_USUARIO", "NOMBRE", "APELLIDO", "FECHA_NAC", "SEXO", "CORREO", "TELEFONO"];
    protected $table = "persona";
}