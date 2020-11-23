<?php

include_once 'funciones-error-handle.php';

include_once 'database.php';
include_once 'funciones-fechas.php';
include_once 'funciones-sql.php';

function findMeetingsEstudiante($params, $mysqli) {

	$response = array();

	$response['params'] = $params;

	//var_dump($request);

	if(isset($params) && !empty($params)) {

		$estudianteid = null;
		if(isset($params->estudianteid) && !empty($params->estudianteid)) {
			$estudianteid = mysqli_real_escape_string($mysqli, $params->estudianteid);
		}
			
		$profesorid = null;
		if(isset($params->profesorid) && !empty($params->profesorid)) {
			$profesorid = mysqli_real_escape_string($mysqli, $params->profesorid);
		}
			
		$orderType = null;
		if(isset($params->orderType) && !empty($params->orderType)) {
			$orderType = $params->orderType;
		}
			
		$limit = null;
		if(isset($params->limit) && !empty($params->limit)) {
			$limit = $params->limit;
		}
			
		$notStatusIN = null;
		if(isset($params->notStatusIN) && !empty($params->notStatusIN)) {
			$notStatusIN = armarInValue($params->notStatusIN);
		}		
			
		$meetings = array();

		$sql = "SELECT ";
		$sql .= " m.* ";
		$sql .= " , ms.meetingsstatusid ";
		$sql .= " , ms.observacion ";
		$sql .= " , c.catalogovalornombre meetingstatusname ";
		$sql .= " , p.nombres nombresprofesor ";
		$sql .= " , e.nombres nombresestudiante ";
		$sql .= " , h.horainicio, h.horafin ";
		$sql .= " FROM meetings m ";
		$sql .= " INNER JOIN meetingsstatus ms on ms.meetingid = m.meetingid";
		$sql .= " INNER JOIN profesores p on p.profesorid = m.profesorid";
		$sql .= " INNER JOIN estudiantes e on e.estudianteid = m.estudianteid";
		$sql .= " INNER JOIN horas h on h.horaid = m.horaid";
		$sql .= " INNER JOIN catalogos c on c.catalogotipo = m.meetingstatuscode and c.catalogovalor = m.meetingstatusvalue ";
		$sql .= " WHERE 1=1 ";
		$sql .= " AND ms.fechafin IS NULL ";
		if ($estudianteid != null) {
			$sql .= " AND m.estudianteid = '$estudianteid' ";
		}
		if ($profesorid != null) {
			$sql .= " AND m.profesorid = '$profesorid' ";
		}
		if ($notStatusIN != null) {
			$sql .= " AND m.meetingstatusvalue NOT IN ($notStatusIN)";
		}
		$sql .= " AND m.estado = '1' ";
		$sql .= " AND h.estado = '1' ";
			
		if($orderType != null) {
			$sql .= " ORDER BY m.fechameeting ".$orderType;
		}
		if($limit != null) {
			$sql .= " LIMIT 0, 1";
		}

		$response['sqlMeetings'] = $sql;
		
		$result = mysqli_query($mysqli, $sql);
		
		if(empty(mysqli_errno($mysqli))) {
			if(mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$meeting = array();
					
					$meeting['meetingid'] = $row['meetingid'];
					$meeting['meetingsstatusid'] = $row['meetingsstatusid'];
					$meeting['profesorid'] = $row['profesorid'];
					$meeting['estudianteid'] = $row['estudianteid'];
					$meeting['fechameeting'] = $row['fechameeting'];
					$meeting['horaid'] = $row['horaid'];
					$meeting['meetingstatuscode'] = $row['meetingstatuscode'];
					$meeting['meetingstatusvalue'] = $row['meetingstatusvalue'];
					$meeting['meetingstatusname'] = $row['meetingstatusname'];
					$meeting['meetingurl'] = $row['meetingurl'];
					$meeting['estado'] = $row['estado'];
					$meeting['observacion'] = $row['observacion'];
	
					$profesor = array();
					$profesor['profesorid'] = $row['profesorid'];
					$profesor['nombres'] = $row['nombresprofesor'];
	
					$estudiante = array();
					$estudiante['estudianteid'] = $row['estudianteid'];
					$estudiante['nombres'] = $row['nombresestudiante'];
	
					$hora = array();
					$hora['horaid'] = $row['horaid'];
					$hora['horainicio'] = $row['horainicio'];
					$hora['horafin'] = $row['horafin'];
	
					$meeting['profesor'] = $profesor;
					$meeting['estudiante'] = $estudiante;
					$meeting['hora'] = $hora;
	
					$meetings[] = $meeting;
				}
			}
			$response['error'] = 0;
			$response['meetings'] = $meetings;			
			$response['count'] = count($meetings);
			if (count($meetings) > 0) {
				$response['message'] = 'Los citas del estudiante se consultaron correctamente';
			} else {
				$response['message'] = 'El estudiante no tiene citas registradas';
			}
		} else {
			$response['error'] = 1;
			$response['message'] = 'Error al consultar las reuniones del estudiante '.mysqli_error($mysqli);
		}
	}
	else {
		$response['error'] = 1;
		$response['message'] = 'Datos vacios para consultar las citas del estudiante';
	}

	return $response;
}


