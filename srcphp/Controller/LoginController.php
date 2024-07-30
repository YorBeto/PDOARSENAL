<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;


class LoginController
{
    public function login() {
        // Leer el contenido de la solicitud JSON
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Obtener el correo y la contraseña del objeto JSON
        $correo = $dataObject->correo;
        $contrasena = $dataObject->contrasena;

        // Escapar los datos para evitar problemas con caracteres especiales
        $correo = addslashes($correo);
        $contrasena = addslashes($contrasena);

        // Crear la consulta SQL con los valores directamente insertados
        $query = "SELECT persona.CORREO, usuarios.CONTRASEÑA 
                  FROM usuarios 
                  INNER JOIN persona ON usuarios.ID_USUARIO = persona.ID_USUARIO 
                  WHERE persona.CORREO = '$correo' 
                  AND usuarios.CONTRASEÑA = '$contrasena'";

        // Ejecutar la consulta usando el método query
        $usuarios = new Table();
        $loguearse = $usuarios->query($query);

        // Verificar si se encontró algún resultado
        if (count($loguearse) > 0) {
            // Respuesta de éxito
            $response = [
                'success' => true,
                'user' => $loguearse[0] // Puedes devolver más detalles del usuario aquí si lo deseas
            ];
        } else {
            // Respuesta de error
            $response = [
                'success' => false,
                'message' => 'Correo o contraseña incorrectos'
            ];
        }

        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

   
}