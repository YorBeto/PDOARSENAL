<?php

namespace proyecto\Controller;

use proyecto\Models\productos_servicios;
use Exception;
use proyecto\Models\Table;

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

// Buscar producto por ID
public function buscarProducto()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        try {
            $producto = productos_servicios::find($id_producto);
            if ($producto) {
                echo json_encode(["status" => 200, "data" => $producto]);
            } else {
                echo json_encode(["status" => 404, "message" => "Producto no encontrado."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => 500, "message" => "Error: " . $e->getMessage()]);
        }
    }
}

// Actualizar producto por ID
public function actualizarProducto()
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
            $producto = productos_servicios::find($id_producto);
            if ($producto) {
                $producto->NOMBRE = $nombre;
                $producto->DESCRIPCION = $descripcion;
                $producto->PRECIO = $precio;
                $producto->STOCK = $stock;
                $producto->ID_CATEGORIA = $id_categoria;
                $producto->save();
                echo json_encode(["status" => 200, "message" => "Producto actualizado correctamente."]);
            } else {
                echo json_encode(["status" => 404, "message" => "Producto no encontrado."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => 500, "message" => "Error: " . $e->getMessage()]);
        }
    }
}

// Eliminar producto por ID
public function eliminarProducto()
{
    if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
        $data = json_decode(file_get_contents("php://input"), true);
        $id_producto = $data['id_producto'] ?? null;

        if (!$id_producto) {
            echo json_encode(["status" => 400, "message" => "ID Producto es obligatorio."]);
            return;
        }

        try {
            productos_servicios::delete($id_producto);
            echo json_encode(["status" => 200, "message" => "Producto eliminado correctamente."]);
        } catch (Exception $e) {
            echo json_encode(["status" => 500, "message" => "Error: " . $e->getMessage()]);
        }
    }
}



}
?>
