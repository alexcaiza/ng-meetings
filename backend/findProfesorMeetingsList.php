<?php
/**
 * Returns the list of policies.
 */
require 'database.php';
require 'funciones-fechas.php';

$response = [];

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$response['params'] = $request;

//var_dump($request);

if(isset($postdata) && !empty($postdata)) {

  $profesorid = mysqli_real_escape_string($mysqli, $request->profesorid);

  //var_dump($profesorid);

  $meetings = array();

  $sql = "SELECT ";
  $sql .= " m.* ";
  $sql .= " , p.nombres nombresprofesor, p.cedula cedulaprofesor, p.email emailprofesor ";
  $sql .= " , e.nombres nombresestudiante, e.cedula cedulaestudiante, e.email emailestudiante, e.curso, e.paralelo ";
  $sql .= " , h.horainicio, h.horafin ";
  $sql .= " FROM meetings m ";
  $sql .= " INNER JOIN profesores p on p.profesorid = m.profesorid";
  $sql .= " INNER JOIN estudiantes e on e.estudianteid = m.estudianteid";
  $sql .= " INNER JOIN horas h on h.horaid = m.horaid";
  $sql .= " WHERE m.profesorid = '$profesorid' ";
  $sql .= " AND m.estado = '1' ";
  $sql .= " AND h.estado = '1' ";
  $sql .= " ORDER BY m.fecharegistro ";
  
  $response['sqlMeetings'] = $sql;

  if($result = mysqli_query($mysqli, $sql)) {

    while($row = mysqli_fetch_assoc($result)) {

      $meeting = array();

	  	

      $estudiante = array();
      $estudiante['estudianteid'] = $row['estudianteid'];
      $estudiante['nombres'] = $row['nombresestudiante'];
      $estudiante['curso'] = $row['curso'];
      $estudiante['paralelo'] = $row['paralelo'];
      $estudiante['cedula'] = $row['cedulaestudiante'];
      $estudiante['email'] = $row['emailestudiante'];

      $profesor = array();
      $profesor['profesorid'] = $row['profesorid'];
      $profesor['nombres'] = $row['nombresprofesor'];
      $profesor['cedula'] = $row['cedulaprofesor'];
      $profesor['email'] = $row['emailprofesor'];

      $hora = array();
      $hora['horaid'] = $row['horaid'];
      $hora['horainicio'] = $row['horainicio'];
      $hora['horafin'] = $row['horafin'];

      $meeting['meetingid'] = $row['meetingid'];
      $meeting['profesorid'] = $row['profesorid'];
      $meeting['estudianteid'] = $row['estudianteid'];
      $meeting['fechameeting'] = $row['fechameeting'];
      $meeting['horaid'] = $row['horaid'];
      $meeting['status'] = $row['status'];
      $meeting['estado'] = $row['estado'];
      $meeting['estudiante'] = $estudiante;
      $meeting['profesor'] = $profesor;
      $meeting['hora'] = $hora;

      $meetings[] = $meeting;

    }
    $response['meetings'] = $meetings;   
  } 
  else {

  } 
  echo json_encode($response); 
}
else {
  //http_response_code(404);
}
