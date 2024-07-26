<?php

namespace proyecto\Controller;

use proyecto\Models\productos_servicios;
use Exception;

class ProductosController
{
    public function insertarProducto()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $id_producto = $data['id_producto'] ?? null;
            $nombre = $data['nombre'] ?? null;
            $descripcion = $data['descripcion'] ?? null;
            $precio = $data['precio'] ?? null;
            $stock = $data['stock'] ?? null;
            $id_categoria = $data['id_categoria'] ?? null;

            if (!$id_producto || !$nombre || !$descripcion || !$precio || !$id_categoria) {
                echo json_encode(["status" => 400, "message" => "Todos los campos son obligatorios."]);
                return;
            }

            try {
                $producto = new productos_servicios();
                $producto->create([
                    'ID_PRODUCTO' => $id_producto,
                    'NOMBRE' => $nombre,
                    'DESCRIPCION' => $descripcion,
                    'PRECIO' => $precio,
                    'STOCK' => $stock,
                    'ID_CATEGORIA' => $id_categoria
                ]);
                echo json_encode(["status" => 200, "message" => "Producto insertado correctamente."]);
            } catch (Exception $e) {
                echo json_encode(["status" => 500, "message" => "Error: " . $e->getMessage()]);
            }
        }
    }
}
?>
