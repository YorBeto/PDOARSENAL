<?php
namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\Personas;

class PersonasController {

    public function registroclientes() {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        if (!isset($dataObject->nombre) || !isset($dataObject->apellidos) || 
            !isset($dataObject->fechaNacimiento) || !isset($dataObject->sexo) || 
            !isset($dataObject->correo) || !isset($dataObject->telefono) || 
            !isset($dataObject->contrasena)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            return;
        }

        $nombre = $dataObject->nombre;
        $apellidos = $dataObject->apellidos;
        $fechaNacimiento = $dataObject->fechaNacimiento;
        $sexo = $dataObject->sexo;
        $correo = $dataObject->correo;
        $telefono = $dataObject->telefono;
        $contrasena = $dataObject->contrasena;

        // Verificar si el correo ya existe
        $correoExistente = Table::query("SELECT * FROM personas WHERE correo = '$correo'");

        if (count($correoExistente) > 0) {
            echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado']);
            return;
        }

        $query = "CALL RegistrarPersonaLogin(
            '$nombre', 
            '$apellidos', 
            '$fechaNacimiento', 
            '$sexo', 
            '$correo', 
            '$telefono', 
            '$contrasena'
        )";

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