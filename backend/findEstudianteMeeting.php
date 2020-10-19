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

  $estudianteid = mysqli_real_escape_string($mysqli, $request->estudianteid);

  //var_dump($estudianteid);

  $meeting = array();

  $sql = "SELECT ";
  $sql .= " m.* ";
  $sql .= " , p.nombres nombresprofesor ";
  $sql .= " , h.horainicio, h.horafin ";
  $sql .= " FROM meetings m ";
  $sql .= " INNER JOIN profesores p on p.profesorid = m.profesorid";
  $sql .= " INNER JOIN horas h on h.horaid = m.horaid";
  $sql .= " WHERE m.estudianteid = '$estudianteid' ";
  $sql .= " AND m.estado = '1' ";
  $sql .= " AND h.estado = '1' ";
  $sql .= " ORDER BY m.fecharegistro DESC ";
  $sql .= " LIMIT 0, 1 ";

  $response['sqlMeetings'] = $sql;

  if($result = mysqli_query($mysqli, $sql)) {

    while($row = mysqli_fetch_assoc($result)) {
	  	//$meeting = $row;
      $meeting['meetingid'] = $row['meetingid'];
      $meeting['profesorid'] = $row['profesorid'];
      $meeting['estudianteid'] = $row['estudianteid'];
      $meeting['fechameeting'] = $row['fechameeting'];
      $meeting['horaid'] = $row['horaid'];
      $meeting['status'] = $row['status'];
      $meeting['estado'] = $row['estado'];

      $profesor = array();
      $profesor['profesorid'] = $row['profesorid'];
      $profesor['nombres'] = $row['nombresprofesor'];

      $hora = array();
      $hora['horaid'] = $row['horaid'];
      $hora['horainicio'] = $row['horainicio'];
      $hora['horafin'] = $row['horafin'];

      $meeting['profesor'] = $profesor;
      $meeting['hora'] = $hora;

    }
    $response['meeting'] = $meeting;   
  } 
  else {

  } 
  echo json_encode($response); 
}
else {
  //http_response_code(404);
}
