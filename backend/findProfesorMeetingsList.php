<?php
/**
 * Returns the list of policies.
 */
require 'database.php';
require 'funciones-fechas.php';

$response = array();

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$response['params'] = $request;

//var_dump($request);

if(isset($postdata) && !empty($postdata)) {

  $profesorid = mysqli_real_escape_string($mysqli, $request->profesorid);

  //var_dump($profesorid);

  $meetings = array();

  $sql = "SELECT ";
  $sql .= " m.meetingid, m.profesorid, m.estudianteid, m.fechameeting, m.horaid, m.meetingstatuscode, m.meetingstatusvalue ,m.estado, m.fecharegistro ";
  $sql .= " , ms.meetingsstatusid, ms.estadoanteriortipo, ms.estadoanteriorvalor, ms.estadoactualtipo, ms.estadoactualvalor";
  $sql .= " , ms.estadoactualvalor, ms.fechainicio, ms.fechafin, ms.fecharegistro, ms.estado, ms.observacion ";
  $sql .= " , p.nombres nombresprofesor, p.cedula cedulaprofesor, p.email emailprofesor ";
  $sql .= " , e.nombres nombresestudiante, e.cedula cedulaestudiante, e.email emailestudiante, e.curso, e.paralelo ";
  $sql .= " , h.horainicio, h.horafin ";
  $sql .= " , c1.catalogovalornombre nombreestadoanterior, c2.catalogovalornombre nombreestadoactual ";
  $sql .= " FROM meetings m "; 
  $sql .= " LEFT JOIN meetingsstatus ms on ms.meetingid = m.meetingid";
  $sql .= " LEFT JOIN profesores p on p.profesorid = m.profesorid";
  $sql .= " LEFT JOIN estudiantes e on e.estudianteid = m.estudianteid";
  $sql .= " LEFT JOIN horas h on h.horaid = m.horaid";
  $sql .= " LEFT JOIN catalogos c1 on c1.catalogotipo = ms.estadoanteriortipo and c1.catalogovalor = ms.estadoanteriorvalor";
  $sql .= " LEFT JOIN catalogos c2 on c2.catalogotipo = ms.estadoactualtipo and c2.catalogovalor = ms.estadoactualvalor";
  $sql .= " WHERE 1=1 ";
  $sql .= " AND ms.fechafin is NULL ";
  $sql .= " AND m.profesorid = '$profesorid' ";
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
      $meeting['meetingsstatusid'] = $row['meetingsstatusid'];      
      $meeting['profesorid'] = $row['profesorid'];
      $meeting['estudianteid'] = $row['estudianteid'];
      $meeting['fechameeting'] = $row['fechameeting'];
      $meeting['horaid'] = $row['horaid'];
      $meeting['meetingstatuscode'] = $row['meetingstatuscode'];
      $meeting['meetingstatusvalue'] = $row['meetingstatusvalue'];
      $meeting['estado'] = $row['estado'];
      
	  $estadoanterior = array();
      $estadoanterior['catalogotipo'] = $row['estadoanteriortipo'];
      $estadoanterior['catalogovalor'] = $row['estadoanteriorvalor'];
      $estadoanterior['nombre'] = $row['nombreestadoanterior'];
	  
	  $estadoactual = array();
      $estadoactual['catalogotipo'] = $row['estadoactualtipo'];
      $estadoactual['catalogovalor'] = $row['estadoactualvalor'];
      $estadoactual['nombre'] = $row['nombreestadoactual'];
	  
	  $meeting['estudiante'] = $estudiante;
      $meeting['profesor'] = $profesor;
      $meeting['hora'] = $hora;
	  $meeting['estadoanterior'] = $estadoanterior;
	  $meeting['estadoactual'] = $estadoactual;

      $meetings[] = $meeting;
    }
    $response['meetings'] = $meetings;   
  } 
  else {
	$response['error'] = '1';
	$response['message'] = mysqli_error($mysqli);
  } 
  echo json_encode($response); 
}
else {
  //http_response_code(404);
}
