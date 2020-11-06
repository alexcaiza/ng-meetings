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

  $estadoanteriorvalor = null;
  if(isset($request->estadoanteriorvalor) && !empty($request->estadoanteriorvalor)) { 
	$estadoanteriorvalor = mysqli_real_escape_string($mysqli, $request->estadoanteriorvalor);
  }
  
  $valortipousuario = null;
  if(isset($request->valortipousuario) && !empty($request->valortipousuario)) { 
	$valortipousuario = mysqli_real_escape_string($mysqli, $request->valortipousuario);
  }

  //var_dump($profesorid);

  $estados = array();

  $sql = "SELECT ";
  $sql .= " estadoanteriortipo,estadoanteriorvalor,estadoactualtipo,estadoactualvalor,estadoacciontipo,estadoaccionvalor, ";
  $sql .= " codigotipousuario,valortipousuario, ";
  $sql .= " c1.nombre nombreestadoanterior, c2.nombre nombreestadoactual, c3.nombre nombreestadoaccion, c4.nombre nombretipousuario ";
  $sql .= " FROM meetingsenginestatus mes ";
  $sql .= " inner join catalogos c1 on c1.catalogotipo = mes.estadoanteriortipo and c1.catalogovalor = mes.estadoanteriorvalor  ";
  $sql .= " inner join catalogos c2 on c2.catalogotipo = mes.estadoactualtipo and c2.catalogovalor = mes.estadoactualvalor ";
  $sql .= " inner join catalogos c3 on c3.catalogotipo = mes.estadoacciontipo and c3.catalogovalor = mes.estadoaccionvalor ";
  $sql .= " inner join catalogos c4 on c4.catalogotipo = mes.codigotipousuario and c4.catalogovalor = mes.valortipousuario ";
  $sql .= " WHERE 1=1 ";
  if(isset($estadoanteriorvalor) && !empty($estadoanteriorvalor)) {
	$sql .= " AND mes.estadoanteriorvalor = '$estadoanteriorvalor' ";
  }
  if(isset($valortipousuario) && !empty($valortipousuario)) {
	$sql .= " AND mes.valortipousuario = '$valortipousuario' ";
  }
  
  $sql .= " AND mes.estado = '1' ";
  
  $response['sqlMES'] = $sql;

  if($result = mysqli_query($mysqli, $sql)) {

    while($row = mysqli_fetch_assoc($result)) {

      $estado = array();

      $estadoanterior = array();
      $estadoanterior['catalogotipo'] = $row['estadoanteriortipo'];
      $estadoanterior['catalogovalor'] = $row['estadoanteriorvalor'];
      $estadoanterior['nombre'] = $row['nombreestadoanterior'];

      $estadoactual = array();
      $estadoactual['catalogotipo'] = $row['estadoactualtipo'];
      $estadoactual['catalogovalor'] = $row['estadoactualvalor'];
      $estadoactual['nombre'] = $row['nombreestadoactual'];
	  
	  $estadoaccion = array();
      $estadoaccion['catalogotipo'] = $row['estadoacciontipo'];
      $estadoaccion['catalogovalor'] = $row['estadoaccionvalor'];
      $estadoaccion['nombre'] = $row['nombreestadoaccion'];
	  
	  $tipousuario = array();
      $tipousuario['catalogotipo'] = $row['codigotipousuario'];
      $tipousuario['catalogovalor'] = $row['valortipousuario'];
      $tipousuario['nombre'] = $row['nombretipousuario'];

      $estado['estadoanterior'] = $estadoanterior;
      $estado['estadoactual'] = $estadoactual;
      $estado['estadoaccion'] = $estadoaccion;
      $estado['tipousuario'] = $tipousuario;

      $estados[] = $estado;
    }
	
	if (count($estados) > 0) {
		$response['count'] = count($estados);
	} else {
		if (empty($estadoanteriorvalor)) {
			$response['message'] = "No existe estados configurados para el estado ";
		} else {
			$response['message'] = "No existe estados configurados para el estado: ".$estadoanteriorvalor;
		}
		$response['count'] = 0;
	}
	
    $response['estados'] = $estados;   
  } 
  else {

  } 
  echo json_encode($response); 
}
else {
  //http_response_code(404);
}
