<?php
/**
*    File        : backend/controllers/subjectsController.php
*    Project     : CRUD PHP
*    Author      : Tecnologías Informáticas B - Facultad de Ingeniería - UNMdP
*    License     : http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
*    Date        : Mayo 2025
*    Status      : Prototype
*    Iteration   : 3.0 ( prototype )
*/

require_once("./models/subjects.php");

function handleGet($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['id'])) 
    {
        $subject = getSubjectById($conn, $input['id']);
        echo json_encode($subject);
    } 
    else 
    {
        $subjects = getAllSubjects($conn);
        echo json_encode($subjects);
    }
}

function handlePost($conn) //modificaciones ppara el inciso A
{
    // OBS: Leer input JSON recibido
    $input = json_decode(file_get_contents("php://input"), true);

    // OBS: Intentar crear la materia
    $result = createSubject($conn, $input['name']);

    // OBS: Verificar si la creación devolvió un error (ej: materia duplicada)
    if (isset($result['error'])) {
        http_response_code(409); // OBS: Código 409 Conflict para indicar duplicado
        echo json_encode(['error' => $result['error']]);
    }
    // OBS: Si se insertó correctamente
    else if ($result['inserted'] > 0) {
        echo json_encode(["message" => "Materia creada correctamente"]);
    } 
    // OBS: Si ocurrió otro error inesperado
    else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo crear"]);
    }
}


function handlePut($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);

    $result = updateSubject($conn, $input['id'], $input['name']);
    if ($result['updated'] > 0) 
    {
        echo json_encode(["message" => "Materia actualizada correctamente"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo actualizar"]);
    }
}

function handleDelete($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);
    
    $result = deleteSubject($conn, $input['id']);
    if ($result['deleted'] > 0) 
    {
        echo json_encode(["message" => "Materia eliminada correctamente"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo eliminar"]);
    }
}
?>
