<?php

namespace proyecto\Controller;

use proyecto\Models\socios;
use proyecto\Response\Success;
use proyecto\Models\Table;


class MostrarSociosController{

    public function mostrarsocios(){

        $socios=new Table();
        $todoslossocios=$socios ->query("SELECT socios.id_socio,persona.nombre,socios.membresia, 
        socios.fecha_inicio, socios.fecha_fin,socios.estado_de_memb
        FROM persona INNER JOIN clientes ON persona.id_persona = clientes.id_persona
        INNER JOIN socios ON socios.id_cliente = clientes.id_clientes
        WHERE socios.estado_de_memb = 'ACTIVO';");

        $success=new Success($todoslossocios);
        return $success ->send();
    }
}
