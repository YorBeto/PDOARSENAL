<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;

class LoginController
{
    public function loginClientes() {
        // Leer el contenido de la solicitud JSON
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Obtener el correo y la contraseña del objeto JSON
        $correo = $dataObject->correo;
        $contrasena = $dataObject->contrasena;

        // Escapar los datos para evitar problemas con caracteres especiales
        $correo = addslashes($correo);
        $contrasena = addslashes($contrasena);

      
        $login=new Table();
        $loguearse=$login->query("SELECT PERSONA.CORREO, 
        cast(aes_decrypt(usuarios.contraseña,'administrador') as char) as contraseña
  FROM USUARIOS 
  INNER JOIN PERSONA ON USUARIOS.ID_USUARIO = PERSONA.ID_USUARIO
  WHERE PERSONA.CORREO = '$correo'
  and  cast(aes_decrypt(usuarios.contraseña,'administrador') as char)='$contrasena'; ");
    

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