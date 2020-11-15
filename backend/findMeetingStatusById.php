<?php
/**
 * Returns the list of policies.
 */
include_once 'database.php';
include_once 'funciones-fechas.php';
include_once 'findMeetingStatusByIdFunctions.php';
include_once 'meetingsStatusConstants.php';

$response = array();

try {
	$postdata = file_get_contents("php://input");
	
	if(isset($postdata) && !empty($postdata)) {
		
		$params = json_decode($postdata);
		
		//var_dump($params);
		
		$response = findMeetingStatusById($params, $mysqli);		
	}
	else {
		$response['error'] = 1;
		$response['message'] = "Datos vacios para consultar las estados de la reunión";
	}
} catch (Exception $e) {
	$response['error'] = 1;
	$response['mensaje'] = $e->getMessage();
}

echo json_encode($response);
