<?php
/**
 * Returns the list of policies.
 */
require 'database.php';
require 'funciones-fechas.php';

$response = [];

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$response['request'] = $request;

if(isset($postdata) && !empty($postdata)) {

  $profesorid = mysqli_real_escape_string($mysqli, $request->profesorid);
  $fechameeting = mysqli_real_escape_string($mysqli,  $request->fechameeting);

  $horas = [];
  $sql = "SELECT * FROM horas";

  $response['sqlHoras'] = $sql;

  if($result = mysqli_query($mysqli,$sql)) {

    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
      $horas[$i]['horaid'] = $row['horaid'];
      $horas[$i]['horainicio'] = $row['horainicio'];
      $horas[$i]['horafin'] = $row['horafin'];
      $horas[$i]['disabled'] = false;
      $i++;
    }
    $response['horas'] = $horas;

    $meetings = [];

    $sql = "SELECT * FROM meetings m ";
    $sql .= "WHERE 1=1 ";
    $sql .= "and m.profesorid = '$profesorid' and m.fechameeting = '$fechameeting' and m.estado = '1'";

    $response['sqlMeetings'] = $sql;
    $response['weekDay'] = getWeekDay($fechameeting);

    if($result = mysqli_query($mysqli, $sql)) {
      $i = 0;
      while($row = mysqli_fetch_assoc($result)) {
        $meetings[$i]['meetingid'] = $row['meetingid'];
        $meetings[$i]['profesorid'] = $row['profesorid'];
        $meetings[$i]['estudianteid'] = $row['estudianteid'];
        $meetings[$i]['fechameeting'] = $row['fechameeting'];
        $meetings[$i]['horaid'] = $row['horaid'];
        $meetings[$i]['status'] = $row['status'];
        $meetings[$i]['estado'] = $row['estado'];
        $i++;
      }
    }

    $response['meetings'] = $meetings;

    // Valida si el profesor tiene reuniones en esa fecha y hora
    if (count($meetings) > 0) {
      foreach ($meetings as $itemM) {        
        foreach ($horas as &$itemH) {
          if ($itemH['horaid'] == $itemM['horaid']) {
            //var_dump($itemM);
            //var_dump($itemH);
            $itemH['disabled'] = true;
            $response['hora'.$itemH['horaid']] = $itemH;           
          }
        }
      }
      $response['horas'] = &$horas;
    }
    echo json_encode($response);
  }
  else
  {
    http_response_code(404);
  }
}
