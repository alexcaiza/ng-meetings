<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json; charset=utf-8');
	
include_once 'funciones-error-handle.php';

require 'database.php';
require 'funciones-fechas.php';
require 'cancelMeetingEstudianteFunctions.php';
require 'crudTableMeetings.php';
require 'crudTableMeetingsStatus.php';
require 'meetingsStatusConstants.php';

$response = array();

$stdClass = new stdClass();
$stdClass->error = "0";
$stdClass->message = null;

try {	
	$params = null;
		
	$postdata = file_get_contents("php://input");
	
	if(isset($postdata) && !empty($postdata)) {
		// Extract the data post.
		$params = json_decode($postdata);
		
		$paramsValid = validarCamposRequeridosForCancelMeetingEstudiante($params, $mysqli);
		
		if ($paramsValid->isvalid == true) {
			
			$objMeeting = new stdClass();
			$objMeeting->meetingid = $params->meetingid;
			$objMeeting->usuarioid = $params->usuarioid;
			$objMeeting->meetingstatuscode = MeetingsStatusConstants::CT_MEETING_STATUS;
			$objMeeting->meetingstatusvalue = MeetingsStatusConstants::CV_MEETING_STATUS_CANCELADO;
			
			// Actualiza el nuevo estado de la reunion en la cabecera
			$objMeeting = updateMeetingTable($objMeeting, $mysqli);
			
			if($objMeeting != null && $objMeeting->isvalid) {
				
				$fechafin = date('Y-m-d H:i:s');
				
				// <1> Cierra de estado actual de la reunion (fechafin) en los detalles
				$objMeetingStatus = new stdClass();
				$objMeetingStatus->meetingid = $params->meetingid;
				$objMeetingStatus->meetingsstatusid = $params->meetingsstatusid;
				$objMeetingStatus->fechafin = $fechafin;
				$objMeetingStatus->usuarioid = $params->usuarioid;
				
				$objMeetingStatus = updateMeetingStatusTable($objMeetingStatus, $mysqli);
				
				// <2> Crea el nuevo estado de la reunion
				$objMeetingStatus = new stdClass();
				$objMeetingStatus->meetingid = $objMeeting->meetingid;
				$objMeetingStatus->estadoanteriortipo = MeetingsStatusConstants::CT_MEETING_STATUS;
				$objMeetingStatus->estadoanteriorvalor = $params->meetingstatusvalue;
				$objMeetingStatus->estadoactualtipo = MeetingsStatusConstants::CT_MEETING_STATUS;
				$objMeetingStatus->estadoactualvalor = MeetingsStatusConstants::CV_MEETING_STATUS_CANCELADO;
				$objMeetingStatus->fechainicio = $fechafin;
				$objMeetingStatus->fechafin = null;
				$objMeetingStatus->observacion = $params->observacion;
				$objMeetingStatus->usuarioid = $params->usuarioid;
				
				// Realiza el insert en la tabla MEETINGS-STATUS
				$objMeetingStatus = insertMeetingStatusTable($objMeetingStatus, $mysqli);
				
				if($objMeetingStatus->meetingsstatusid != null) {
					$response['error'] = 0;
					$response['message'] = $objMeetingStatus->message;
					$response['meetingid'] = $objMeeting->meetingid;					
					$response['sqlMeeting'] = $objMeeting->sql;
					$response['meetingsstatusid'] = $objMeetingStatus->meetingsstatusid;
					$response['sqlMeetingStatus'] = $objMeetingStatus->sql;							
				} else {
					$response['error'] = 1;
					$response['message'] = $objMeetingStatus->message;
				}						
			} else  {
				$response['error'] = 1;
				$response['message'] = $objMeeting->message;
			}					
		} else {
			$response['error'] = 1;
			$response['message'] = $paramsValid->message;
		}				
	} else {
		$response['params'] = null;
		$response['error'] = 1;
		$response['message'] = "Datos vacios para registrar la cita de la reunion";
	}
} catch (Exception $e) {
	$response['error'] = 1;
	$response['mensaje'] = $e->getMessage();
}

echo json_encode($response);
?>