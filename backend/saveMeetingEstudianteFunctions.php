<?php

include_once 'funciones-error-handle.php';
include_once 'findEstudianteMeetingFunctions.php';

function validarCamposRequeridosForSaveMeetingEstudiante($params, $mysqli) {
	$stdClass = new stdClass();
	$stdClass->message = null;
	$stdClass->isvalid = true;
	
	if (isset($params)) {
		// Valida usuario registro
		$stdClass->usuarioid = null;
		if (!isset($params->usuarioid) || empty($params->usuarioid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo usuario esta vacio";
		} else {
			$stdClass->usuarioid = mysqli_real_escape_string($mysqli,(strip_tags($params->usuarioid, ENT_QUOTES)));
		}
		
		// Valida el profesor
		$stdClass->profesorid = null;
		if (!isset($params->profesorid) || empty($params->profesorid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo profesorid esta vacio";
		} else {
			$stdClass->profesorid = mysqli_real_escape_string($mysqli,(strip_tags($params->profesorid, ENT_QUOTES)));
		}
		
		// Valida el estudiante
		$stdClass->estudianteid = null;
		if (!isset($params->estudianteid) || empty($params->estudianteid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo estudianteid esta vacio";
		} else {
			$stdClass->estudianteid = mysqli_real_escape_string($mysqli,(strip_tags($params->estudianteid, ENT_QUOTES)));
		}
		
		// fechameeting
		$stdClass->fechameeting = null;
		if (!isset($params->fechameeting) || empty($params->fechameeting)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo fechameeting esta vacio";
		} else {
			$stdClass->fechameeting = mysqli_real_escape_string($mysqli,(strip_tags($params->fechameeting, ENT_QUOTES)));
		}
		
		// horaid
		$stdClass->horaid = null;
		if (!isset($params->horaid) || empty($params->horaid)) {
			$stdClass->isvalid = false;
			$stdClass->message = "El campo horaid esta vacio";
		} else {
			$stdClass->horaid = mysqli_real_escape_string($mysqli,(strip_tags($params->horaid, ENT_QUOTES)));
		}
		
		// meetingstatus
		$stdClass->meetingstatuscode = null;
		if (isset($params->meetingstatuscode) && !empty($params->meetingstatuscode)) {
			$stdClass->meetingstatuscode = mysqli_real_escape_string($mysqli,(strip_tags($params->meetingstatuscode, ENT_QUOTES)));
		}
		
		$stdClass->meetingstatusvalue = null;
		if (isset($params->meetingstatusvalue) && !empty($params->meetingstatusvalue)) {
			$stdClass->meetingstatusvalue = mysqli_real_escape_string($mysqli,(strip_tags($params->meetingstatusvalue, ENT_QUOTES)));
		}
		
		// meetingurl
		$stdClass->meetingurl = null;
		if (isset($params->meetingurl) && !empty($params->meetingurl)) {
			$stdClass->meetingurl = mysqli_real_escape_string($mysqli,(strip_tags($params->meetingurl, ENT_QUOTES)));
		}
		
		// observacion
		$stdClass->observacion = null;
		if (isset($params->observacion) && !empty($params->observacion)) {
			$stdClass->observacion = mysqli_real_escape_string($mysqli,(strip_tags($params->observacion, ENT_QUOTES)));
		}
			
	} else {
		$stdClass->isvalid = false;
		$stdClass->message = "Datos vacios para registrar la reunion";
	}
	
	return $stdClass;
}

function validarMeetingsPendientesEstudianteForSaveMeetingEstudiante($paramsP, $mysqli) {
	
	$params = new stdClass();
	$params->estudianteid = $paramsP->estudianteid;
	
	$message = null;
	$error = 0;
	$isvalid = true; 
	
	$notStatusIN = array(
		MeetingsStatusConstants::CV_MEETING_STATUS_CANCELADO,
		MeetingsStatusConstants::CV_MEETING_STATUS_CERRADO,
		MeetingsStatusConstants::CV_MEETING_STATUS_TERMINADO
	);
	
	$params->notStatusIN = $notStatusIN;
	$params->orderType = 'DESC';
	$params->limit = 1;
	
	$response = findMeetingsEstudiante($params, $mysqli);
	
	if (isset($response['count']) && $response['count'] > 0) {
		$meeting = $response['meetings'][0];
		$message = "Ud tiene una cita registrada para la fecha ". $meeting['fechameeting']." con el docente ".$meeting['profesor']['nombres'];
		$error = 1; 
		$isvalid = false;
	}
	
	$stdClass = new stdClass();
	$stdClass->message = $message;
	$stdClass->error = $error;
	$stdClass->isvalid = $isvalid;
	
	return $stdClass;
}
?>