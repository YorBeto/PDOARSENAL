<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;


class LoginSociosController{

    public function loginsocios(){

        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Obtener el correo y la contraseña del objeto JSON
        $usuario = $dataObject->usuario;
        $contrasena = $dataObject->contrasena;

        // Escapar los datos para evitar problemas con caracteres especiales
        $usuario = addslashes($usuario);
        $contrasena = addslashes($contrasena);

        $usuarios2 = new Table();
        $loguearse2 = $usuarios2->query("SELECT socios.ID_SOCIO, AES_DECRYPT(usuarios.CONTRASEÑA, 'administrador') AS contraseña_desencriptada
                    FROM socios
                    INNER JOIN clientes ON socios.ID_CLIENTE = clientes.ID_CLIENTES
                    INNER JOIN persona ON clientes.ID_PERSONA = persona.ID_PERSONA
                    INNER JOIN usuarios ON persona.ID_USUARIO = usuarios.ID_USUARIO
                    WHERE socios.ID_SOCIO = '$usuario'");
       

            if (count($loguearse2) > 0) {
                // Respuesta de éxito
                $response = [
                    'success' => true,
                    'user' => $loguearse2[0] // Puedes devolver más detalles del usuario aquí si lo deseas
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