<?php

namespace proyecto\Controller;

use proyecto\Models\productos_servicios;
use proyecto\Models\Table;
use proyecto\Response\Success;
use Exception;

class ProductosController 
{
    public function insertarProducto() {
        // Leer datos del cuerpo de la solicitud
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Verificar que las propiedades existen en el objeto
        if (!isset($dataObject->nombre) || !isset($dataObject->descripcion) || 
            !isset($dataObject->precio) || !isset($dataObject->stock) || 
            !isset($dataObject->categoria)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            return;
        }

        // Obtener los datos del objeto JSON
        $nombre = $dataObject->nombre;
        $descripcion = $dataObject->descripcion;
        $precio = $dataObject->precio;
        $stock = $dataObject->stock;
        $categoria = $dataObject->categoria;

        // Llamar al procedimiento almacenado para registrar al empleado
        $query = "CALL RegistrarProductos(
            '$nombre', 
            '$descripcion', 
            '$precio', 
            '$stock', 
            '$categoria'
        )";

        // Ejecutar la consulta
        try {
            $resultados = Table::query($query);
            $r = new Success(['success' => true, 'message' => 'Registro exitoso']);
            return $r->send();
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
            return;
        }
    }
}



?>