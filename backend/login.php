<?php
include_once("database.php");
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$response = array();

if(isset($postdata) && !empty($postdata)) {

	$cedula = mysqli_real_escape_string($mysqli, trim($request->cedula));
  $email = mysqli_real_escape_string($mysqli, trim($request->email));
   
  $sql = "SELECT * FROM estudiantes where cedula='$cedula' and email='$email'";

  $response['sql'] = $sql;

  if($result = mysqli_query($mysqli, $sql)) {
    
    $user = null;
    
    while($row = mysqli_fetch_assoc($result)) {
      $user = $row;
    }

    $response['user'] = $user;
    $response['mensaje'] = "Los datos del usuario se consultaron correctamente";
    $response['error'] = "0";
  }
  else {
    //http_response_code(404);
    $response['mensaje'] = "No se encontraron los datos del usuario con los datos ingresados";
    $response['error'] = "1";
  }
} else {
  $response['mensaje'] = "Ingrese los datos para ingresar al sistema";
  $response['error'] = "1";
}

echo json_encode($response);
?>