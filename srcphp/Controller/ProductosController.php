<?php

namespace proyecto\Controller;

use proyecto\Models\productos_servicios;
use Exception;
use proyecto\Models\Table;
use proyecto\Models\Success;

class ProductosController 
{
    // Insertar producto
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
            $url_imagen = $data['imagen'] ?? null; // Añadir este campo

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
                    'ID_CATEGORIA' => $id_categoria,
                    'IMAGEN' => $url_imagen // Añadir este campo
                ]);
                echo json_encode(["status" => 200, "message" => "Producto insertado correctamente."]);
            } catch (Exception $e) {
                echo json_encode(["status" => 500, "message" => "Error: " . $e->getMessage()]);
            }
        }
    }

    // Actualizar producto
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
            $imagen = $data['imagen'] ?? null; // Añadir este campo

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
                    $producto->IMAGEN = $imagen; // Actualizar este campo
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

    // Mostrar todos los productos
    public function mostrarProductos()
    {
        $producto = new Table();
        $todoslosproductos = $producto->query("SELECT productos_servicios.ID_PRODUCTO,
                                                     productos_servicios.NOMBRE,
                                                     productos_servicios.DESCRIPCION,
                                                     productos_servicios.PRECIO,
                                                     productos_servicios.STOCK,
                                                     productos_servicios.IMAGEN,
                                                     categoria_productos.NOMBRE AS CATEGORIA
                                              FROM categoria_productos
                                              INNER JOIN productos_servicios
                                              ON categoria_productos.ID_CATEGORIA = productos_servicios.ID_CATEGORIA");

        $success = new Success($todoslosproductos);
        return $success->send();
    }
}
?>
