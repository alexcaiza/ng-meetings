<?php
include_once("database.php");
include_once("funciones-login.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$response = array();

if(isset($postdata) && !empty($postdata)) {

    //var_dump($postdata);

	$cedula = mysqli_real_escape_string($mysqli, trim($request->cedula));
    $email = mysqli_real_escape_string($mysqli, trim($request->email));
   
    $dataEstudiante = findEstudianteByCedulaMail($mysqli, $cedula, $email);

    if (isset($dataEstudiante->error) && $dataEstudiante->error == "0") {
        $response['user'] = $dataEstudiante->user;
        $response['typeUser'] = "ESTUDIANTE";
        $response['sql'] = $dataEstudiante->sql;
        $response['mensaje'] = "Los datos del estudiante se consultaron correctamente";
        $response['error'] = "0";
    }
    else {
        $dataDocente = findProfesorByCedulaMail($mysqli, $cedula, $email);

        if (isset($dataDocente->error) && $dataDocente->error == "0") {
            $response['user'] = $dataDocente->user;
            $response['typeUser'] = "PROFESOR";
            $response['sql'] = $dataDocente->sql;
            $response['mensaje'] = "Los datos del docente se consultaron correctamente";
            $response['error'] = "0";
        } 
        else {
            //http_response_code(404);
            $response['mensaje'] = "No se encontraron los datos del usuario con los datos ingresados: '$cedula', '$email'";
            $response['error'] = "1";
            $response['error_data'] = $dataDocente;
        }
    }
} else {
  $response['mensaje'] = "Ingrese los datos para ingresar al sistema";
  $response['error'] = "1";
}

echo json_encode($response);
?>