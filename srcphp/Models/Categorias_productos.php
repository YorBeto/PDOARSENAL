<?php

namespace proyecto\Models;

use proyecto\Models\Models;
use proyecto\Response\Success;
use proyecto\Models\Table;

class categorias_productos {
    protected $table = "categoria_productos";
    protected $id = "ID_CATEGORIA";
    protected $filleable = ['ID_CATEGORIA', 'NOMBRE'];

    public function obtenerCategorias() {
        $categoria = new Table();
        $todaslascategorias = $categoria->query("SELECT ID_CATEGORIA, NOMBRE FROM categoria_productos");

        $success = new Success($todaslascategorias);
        return $success->send();
    }
} 