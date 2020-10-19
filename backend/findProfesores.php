<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$profesores = [];
$sql = "SELECT * FROM profesores";

if($result = mysqli_query($mysqli,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $profesores[$i]['profesorid']    = $row['profesorid'];
    $profesores[$i]['nombres'] = $row['nombres'];
    $i++;
  }

  echo json_encode($profesores);
}
else
{
  http_response_code(404);
}