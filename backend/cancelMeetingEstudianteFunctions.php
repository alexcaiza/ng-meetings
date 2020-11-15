<?php

include_once 'findEstudianteMeetingFunctions.php';

function validarCamposRequeridosForCancelMeetingEstudiante($params, $mysqli) {
	$stdClass = new stdClass();
	$stdClass->message = null;
	$stdClass->isvalid = true;
	
	//var_dump($params);
	
	if (isset($params)) {
		
	// Valida el campo meetingid
		$stdClass->usuarioid = null;
		if (!isset($params->usuarioid) || empty($params->usuarioid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo usuarioid esta vacio";
			return $stdClass;
		} else {
			$stdClass->usuarioid = mysqli_real_escape_string($mysqli,(strip_tags($params->usuarioid, ENT_QUOTES)));
		}
		
		// Valida el campo meetingid
		$stdClass->meetingid = null;
		if (!isset($params->meetingid) || empty($params->meetingid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo meetingid esta vacio";
			return $stdClass;
		} else {
			$stdClass->meetingid = mysqli_real_escape_string($mysqli,(strip_tags($params->meetingid, ENT_QUOTES)));
		}	
		
		// Valida el campo meetingid
		$stdClass->meetingsstatusid = null;
		if (!isset($params->meetingsstatusid) || empty($params->meetingsstatusid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo meetingsstatusid esta vacio";
			return $stdClass;
		} else {
			$stdClass->meetingsstatusid = mysqli_real_escape_string($mysqli,(strip_tags($params->meetingsstatusid, ENT_QUOTES)));
		}
	} else {
		$stdClass->isvalid = false;
		$stdClass->message = "Datos vacios para cancelar la cita de la reunion";
		return $stdClass;
	}
	
	return $stdClass;
}

?>