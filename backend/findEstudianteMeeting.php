<?php

include_once 'funciones-error-handle.php';

include_once 'database.php';
include_once 'funciones-fechas.php';
include_once 'findEstudianteMeetingFunctions.php';
include_once 'meetingsStatusConstants.php';

$response = array();

try {
	$postdata = file_get_contents("php://input");
	
	if(isset($postdata) && !empty($postdata)) {
		
		$params = json_decode($postdata);
		
		// Estados de las reunion no validados para presentar en la pantalla del estudiante
		$notStatusIN = array(
			MeetingsStatusConstants::CV_MEETING_STATUS_CANCELADO,
			MeetingsStatusConstants::CV_MEETING_STATUS_CERRADO,
			MeetingsStatusConstants::CV_MEETING_STATUS_TERMINADO
		);
		
		$params->notStatusIN = $notStatusIN;
		$params->orderType = 'DESC';
		$params->limit = 1;
		
		$response = findMeetingsEstudiante($params, $mysqli);		
	}
	else {
		$response['error'] = 1;
		$response['message'] = "Datos vacios para consultar las citas del estudiante";
	}
} catch (Exception $e) {
	$response['error'] = 1;
	$response['mensaje'] = $e->getMessage();
}

echo json_encode($response);
