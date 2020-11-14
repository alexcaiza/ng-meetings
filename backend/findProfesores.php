<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$profesores = array();
$sql = "SELECT * FROM profesores WHERE estado = '1'";

if($result = mysqli_query($mysqli,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $profesores[$i]['profesorid']    = $row['profesorid'];
    $profesores[$i]['nombres'] = $row['nombres'];
    $profesores[$i]['usuarioid'] = $row['usuarioid'];
    $profesores[$i]['cedula'] = $row['cedula'];
    $i++;
  }

  echo json_encode($profesores);
}
else
{
  http_response_code(404);
}