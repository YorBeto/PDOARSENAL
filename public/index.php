<?php

namespace proyecto;
require("../vendor/autoload.php");


use proyecto\Controller\crearPersonaController;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\clientes;
use proyecto\Models\socios;
use proyecto\Models\inbody_citas;
use proyecto\Models\productos_servicios;




Router::get('/prueba',[crearPersonaController::class,"prueba"]);

Router::get('/clientes',[clientes::class,"mostrarclientes"]);
Router::get('/socios',[socios::class,"mostrarsocios"]);
Router::get('/citas',[inbody_citas::class,"mostrarcitas"]);
Router::get('/productos',[productos_servicios::class,"mostrarproductos"]);

Router::get('/crearpersona', [crearPersonaController::class, "crearPersona"]);
Router::get('/usuario/buscar/$id', function ($id) {



    $user= User::find($id);
    if(!$user)
    {
        $r= new Failure(404,"no se encontro el usuario");
        return $r->Send();
    }
   $r= new Success($user);
    return $r->Send();


});
Router::get('/respuesta', [crearPersonaController::class, "response"]);
Router::any('/404', '../views/404.php');