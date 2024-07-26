<?php

namespace proyecto\Controller;

use proyecto\Models\Personas;
use proyecto\Response\Success;
use proyecto\Models\Table;

class PersonasController {

    public function registroclientes() {
        // Leer datos del cuerpo de la solicitud
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Obtener los datos del objeto JSON
        $nombre = $dataObject->nombre;
        $apellidos = $dataObject->apellidos;
        $fechaNacimiento = $dataObject->fechaNacimiento;
        $sexo = $dataObject->sexo;
        $correo = $dataObject->correo;
        $telefono = $dataObject->telefono;
        $contrasena = $dataObject->contrasena;

        // Cifrar la contraseña (ajustar según tu método de cifrado)
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);

        // Llamar al procedimiento almacenado
        $query = "CALL RegistrarPersonaLogin(
            '$nombre', 
            '$apellidos', 
            '$fechaNacimiento', 
            '$sexo', 
            '$correo', 
            '$telefono', 
            '$contrasena_cifrada', 
            'your_encryption_key', 
            'ROL001'
        )";

        // Ejecutar la consulta
        $resultados = Table::query($query);

        // Retornar la respuesta
        $r = new Success($resultados);
        return $r->send();
    }
}