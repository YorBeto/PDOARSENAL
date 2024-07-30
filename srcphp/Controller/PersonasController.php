<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Models\Personas;

class PersonasController {

    public function registroclientes() {
        // Leer datos del cuerpo de la solicitud
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Verificar que las propiedades existen en el objeto
        if (!isset($dataObject->nombre) || !isset($dataObject->apellidos) || 
            !isset($dataObject->fechaNacimiento) || !isset($dataObject->sexo) || 
            !isset($dataObject->correo) || !isset($dataObject->telefono) || 
            !isset($dataObject->contrasena)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            return;
        }

        // Obtener los datos del objeto JSON
        $nombre = $dataObject->nombre;
        $apellidos = $dataObject->apellidos;
        $fechaNacimiento = $dataObject->fechaNacimiento;
        $sexo = $dataObject->sexo;
        $correo = $dataObject->correo;
        $telefono = $dataObject->telefono;
        $contrasena = $dataObject->contrasena;

        // Clave de encriptación (asegúrate de manejar esto de manera segura)
        $encryptionKey = 'tu_clave_de_encriptacion';  // Cambia esto por tu clave real

        // Llamar al procedimiento almacenado para registrar a la persona
        $query = "CALL RegistrarPersonaLogin(
            '$nombre', 
            '$apellidos', 
            '$fechaNacimiento', 
            '$sexo', 
            '$correo', 
            '$telefono', 
            '$contrasena', 
            'ROL001',
            '$encryptionKey'
        )";

        // Ejecutar la consulta
        $resultados = Table::query($query);

        // Retornar la respuesta
        $r = new Success($resultados);
        return $r->send();
    }
}