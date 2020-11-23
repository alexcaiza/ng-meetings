<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json; charset=utf-8');
	
include_once 'funciones-error-handle.php';
require 'database.php';
require 'funciones-fechas.php';
require 'saveMeetingEstudianteFunctions.php';
require 'crudTableMeetings.php';
require 'crudTableMeetingsStatus.php';
require 'meetingsStatusConstants.php';

$response = array();

$stdClass = new stdClass();
$stdClass->error = "0";
$stdClass->message = null;

try {
	if(isset($_GET['estudianteid'])) {
		
		$params = null;
		$postdata = file_get_contents("php://input");
		
		try {
			if(isset($postdata) && !empty($postdata)) {
				// Extract the data post.
				$params = json_decode($postdata);
				
				$validationFields = validarCamposRequeridosForSaveMeetingEstudiante($params, $mysqli);
				
				if ($validationFields->isvalid == true) {
					
					$objMeetingsEstudiante = validarMeetingsPendientesEstudianteForSaveMeetingEstudiante($params, $mysqli);

					if ($objMeetingsEstudiante->isvalid == true) {
					
						$validationFields->meetingstatuscode = MeetingsStatusConstants::CT_MEETING_STATUS;
						$validationFields->meetingstatusvalue = MeetingsStatusConstants::CV_MEETING_STATUS_REGISTRADO;
						
						// Realiza el insert en la tabla MEETINGS
						$objMeeting = insertMeetingTable($validationFields, $mysqli);
						
						if($objMeeting->meetingid != null) {
							
							// Inicializa los datos para la tabla meetingsstatus
							$validationFields->meetingid = $objMeeting->meetingid;
							$validationFields->estadoanteriortipo = MeetingsStatusConstants::CT_MEETING_STATUS;
							$validationFields->estadoanteriorvalor = MeetingsStatusConstants::CV_MEETING_STATUS_INICIO;
							$validationFields->estadoactualtipo = MeetingsStatusConstants::CT_MEETING_STATUS;
							$validationFields->estadoactualvalor = MeetingsStatusConstants::CV_MEETING_STATUS_REGISTRADO;
							$validationFields->fechainicio = date('Y-m-d H:i:s');
							$validationFields->fechafin = null;
							
							// Realiza el insert en la tabla MEETINGS-STATUS
							$objMeetingStatus = insertMeetingStatusTable($validationFields, $mysqli);
							
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
							$response['message'] = "Error al registrar los datos de la cita de la reunion solicitada por el estudiante";
						}
					} else {
						$response['error'] = 1;
						$response['message'] = $objMeetingsEstudiante->message;
					}
				} else {
					$response['error'] = 1;
					$response['message'] = $validationFields->message;
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
	} else {
		$response['error'] = 1;
		$response['mensaje'] = 'Parametro estudiante vacio';	
	}
} catch (Exception $e) {
	$response['error'] = 1;
	$response['mensaje'] = $e->getMessage();
}

echo json_encode($response);
?>