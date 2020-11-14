<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json; charset=utf-8');
	
require_once 'database.php';
require_once 'funciones-fechas.php';
require_once 'workflowMeetingFunctions.php';
require_once 'crudTableMeetings.php';
require_once 'crudTableMeetingsStatus.php';
require_once 'meetingsStatusConstants.php';
require_once 'meetingsTypeUser.php';

$response = array();

$stdClass = new stdClass();
$stdClass->error = "0";
$stdClass->message = null;

try {
	if(isset($_GET['meetingid'])) {
		
		$params = null;
		$postdata = file_get_contents("php://input");
		
		try {
			if(isset($postdata) && !empty($postdata)) {
				// Datos del request
				$params = json_decode($postdata);
				
				$validationFields = validarCamposRequeridosForWorkflowMeeting($params, $mysqli);
				
				if ($validationFields->isvalid == true) {
					
					$meeting = $params->meeting;
					$meetingEnginieStatus = $params->meeting->meetingEnginieStatus;
					
					$objMeeting = new stdClass();
					$objMeeting->meetingid = $meeting->meetingid;
					$objMeeting->meetingurl = $meeting->meetingurl;
					$objMeeting->observacion = $meeting->observacion;
					$objMeeting->meetingstatusvalue = $meetingEnginieStatus->estadoactual->catalogovalor;
					
					// <1> Actualiza el nuevo estado de la reunion en la cabecera
					$objMeeting = updateMeetingTable($objMeeting, $mysqli);
					
					if($objMeeting->isvalid) {
						
						$fechafin = date('Y-m-d H:i:s');
						
						// <2> Cierra de estado actual de la reunion (fechafin) en los detalles
						$objMeetingStatus = new stdClass();
						$objMeetingStatus->meetingid = $meeting->meetingid;
						$objMeetingStatus->meetingsstatusid = $meeting->meetingsstatusid;
						$objMeetingStatus->fechafin = $fechafin;
						
						$objMeetingStatus = updateMeetingStatusTable($objMeetingStatus, $mysqli);
						
						// <3> Crea el nuevo estado de la reunion
						$objMeetingStatus = new stdClass();
						$objMeetingStatus->meetingid = $objMeeting->meetingid;
						$objMeetingStatus->estadoanteriortipo = MeetingsStatusConstants::CT_MEETING_STATUS;
						$objMeetingStatus->estadoanteriorvalor = $meetingEnginieStatus->estadoanterior->catalogovalor;
						$objMeetingStatus->estadoactualtipo = MeetingsStatusConstants::CT_MEETING_STATUS;
						$objMeetingStatus->estadoactualvalor = $meetingEnginieStatus->estadoactual->catalogovalor;
						$objMeetingStatus->fechainicio = $fechafin;
						$objMeetingStatus->observacion = $meeting->observacion;
						$objMeetingStatus->fechafin = null;
						
						// Realiza el insert en la tabla MEETINGS-STATUS
						$objMeetingStatus = insertMeetingStatusTable($objMeetingStatus, $mysqli);
						
						if($objMeetingStatus->meetingsstatusid != null) {
							$response['error'] = 0;
							$response['message'] = $objMeetingStatus->message;					
							$response['meetingsstatusid'] = $objMeetingStatus->meetingsstatusid;
							$response['meetingid'] = $objMeeting->meetingid;
						} else {
							$response['error'] = 1;
							$response['message'] = $objMeetingStatus->message;;
						}						
					} else  {
						$response['error'] = 1;
						if (MeetingsTypeUser::CT_TYPE_USER_ESTUDIANTE == $objMeetingStatus->tipousuario->catalogovalor) {
							$response['message'] = "Error al gestionar el cambio de estado de la reunion solicitada por el estudiante";
						} else if (MeetingsTypeUser::CT_TYPE_USER_DOCENTE == $objMeetingStatus->tipousuario->catalogovalor) {
							$response['message'] = "Error al gestionar el cambio de estado de la la reunion solicitada por el docente";
						} else {
							$response['message'] = "Error al gestionar el cambio de estado de la reunion solicitada";
						}
					}
				} else {
					$response['error'] = 1;
					$response['message'] = $validationFields->message;
				}				
			} else {
				$response['params'] = null;
				$response['error'] = 1;
				$response['message'] = "Datos vacios para registrar la reunion";
			}
		} catch (Exception $e) {
			$response['error'] = 1;
			$response['mensaje'] = $e->getMessage();
		}
	} else {
		$response['error'] = 1;
		$response['mensaje'] = 'Parametro meetingid vacio';	
	}
} catch (Exception $e) {
	$response['error'] = 1;
	$response['mensaje'] = $e->getMessage();
}

echo json_encode($response);
?>