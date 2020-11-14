<?php

function validarCamposRequeridosForWorkflowMeeting($params, $mysqli) {
	$stdClass = new stdClass();
	$stdClass->message = null;
	$stdClass->isvalid = true;
	
	if (isset($params)) {
		
		$meeting = null;
		$meetingEnginieStatus = null;
		
		// Tiene que pasar todas las validaciones para que isvalid no cambie a false
		
		// <1> Valida la maquina de estados para registrar el estado de la reunion
		$stdClass->meeting = null;
		
		if (!isset($params->meeting) || empty($params->meeting)) {
			$stdClass->message = "Los datos de la reunion estan vacios";
			$stdClass->isvalid = false;
			return $stdClass;
		} else {
			
			$meeting = $params->meeting;
			
			if (!isset($meeting->meetingid) || empty($meeting->meetingid)) {
				$stdClass->message = "El id para procesar la reunion esta vacio";
				$stdClass->isvalid = false;
				return $stdClass;
			} else {
				$stdClass->meeting = $meeting;				
			}
		}
		
		if ($meeting == null) {
			return $stdClass;
		}
		
		// <2> Valida la maquina de estados para cambiar el estado de la reunion
		$meetingEnginieStatus = $meeting->meetingEnginieStatus;
		
		if (!isset($meetingEnginieStatus) || empty($meetingEnginieStatus)) {
			$stdClass->message = "La maquina de estados para procesar la reunion esta vacio";
			$stdClass->isvalid = false;
			return $stdClass;
		} else {
			
			if (!isset($meetingEnginieStatus->estadoaccion) || empty($meetingEnginieStatus->estadoaccion)) {
				$stdClass->message = "El estado accion para procesar la reunion esta vacio";
				$stdClass->isvalid = false;
				return $stdClass;
			} else if (!isset($meetingEnginieStatus->estadoanterior) || empty($meetingEnginieStatus->estadoanterior)) {
				$stdClass->message = "El estado anterior para procesar la reunion esta vacio";
				$stdClass->isvalid = false;
				return $stdClass;
			} else if (!isset($meetingEnginieStatus->estadoactual) || empty($meetingEnginieStatus->estadoactual)) {
				$stdClass->message = "El estado actual para procesar la reunion esta vacio";
				$stdClass->isvalid = false;
				return $stdClass;
			} else if (!isset($meetingEnginieStatus->tipousuario) || empty($meetingEnginieStatus->tipousuario)) {
				$stdClass->message = "El tipo de usuario para procesar la reunion esta vacio";
				$stdClass->isvalid = false;
				return $stdClass;
			} else {
				$stdClass->meeting->meetingEnginieStatus = $meetingEnginieStatus;				
			}
		}
	} else {
		$stdClass->message = "Datos vacios para procesar la reunion";
		$stdClass->isvalid = false;
		return $stdClass;
	}	
	return $stdClass;
}
?>