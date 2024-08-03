<?php

namespace proyecto;

require("../vendor/autoload.php");

use proyecto\Controller\crearPersonaController;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\clientes;
use proyecto\Models\inbody_citas;
use proyecto\Models\productos_servicios;
use proyecto\Controller\PersonasController;
use proyecto\Models\Personas;
use proyecto\Controller\MostrarSociosController;
use proyecto\Controller\LoginController;
use proyecto\Controller\LoginSociosController;
use proyecto\Controller\ProductosController;



Router::get('/prueba', [crearPersonaController::class, "prueba"]);
Router::get('/clientes', [clientes::class, "mostrarclientes"]);
Router::get('/socios', [MostrarSociosController::class, "mostrarsocios"]);
Router::get('/citas', [inbody_citas::class, "mostrarcitas"]);
Router::get('/categorias', [productos_servicios::class, "obtenerCategorias"]);

Router::post('/registro',[PersonasController::class,"registroclientes"]);
Router::post('/loginClientes',[LoginController::class,"loginClientes"]);

Router::post('/loginSocios',[LoginSociosController::class,"loginsocios"]);

Router::get('/crearpersona', [crearPersonaController::class, "crearPersona"]);
Router::get('/productos', [productos_servicios::class, "mostrarProductos"]);
Router::get('/producto/buscar', [ProductosController::class, "buscarProducto"]);
Router::get('/usuario/buscar/$id', function ($id) {
    $user = User::find($id);
    if (!$user) {
        $r = new Failure(404, "no se encontró el usuario");
        return $r->Send();
    }
    $r = new Success($user);
    return $r->Send();
});
Router::get('/respuesta', [crearPersonaController::class, "response"]);

// Rutas POST
Router::post('/registro', [PersonasController::class, "registroclientes"]);

Router::post('/loginSocios', [LoginSociosController::class, "loginsocios"]);
Router::post('/insertarproducto', [ProductosController::class, "insertarProducto"]);
Router::post('/producto/actualizar', [ProductosController::class, "actualizarProducto"]);

// Rutas DELETE
Router::delete('/producto/eliminar', [ProductosController::class, "eliminarProducto"]);

// Ruta para manejar errores 404
Router::any('/404', '../views/404.php');