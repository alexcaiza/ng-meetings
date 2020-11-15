<?php
/**
 * Consulta todos los estados de un meeting.
 */
include_once 'database.php';
include_once 'funciones-fechas.php';
include_once 'funciones-sql.php';

function findMeetingStatusById($params, $mysqli) {

	$response = array();

	$response['params'] = $params;

	//var_dump($request);

	if(isset($params) && !empty($params)) {

		$meetingid = null;
		if(isset($params->meetingid) && !empty($params->meetingid)) {
			$meetingid = mysqli_real_escape_string($mysqli, $params->meetingid);
		}
			
		$meetingstatus = array();

		$sql = "SELECT ";
		$sql .= " m.* ";
		$sql .= " , ms.meetingsstatusid ";
		$sql .= " , ms.fecharegistro fecharegistroms ";
		$sql .= " , ms.observacion observacionms ";
		$sql .= " , ms.meetingsstatusid ";
		$sql .= " , cm.catalogovalornombre meetingstatusname ";
		$sql .= " , p.nombres nombresprofesor ";
		$sql .= " , e.nombres nombresestudiante ";
		$sql .= " , h.horainicio, h.horafin ";
		$sql .= " , u.nombres nombresms";
		$sql .= " FROM meetings m ";
		$sql .= " INNER JOIN meetingsstatus ms on ms.meetingid = m.meetingid";
		$sql .= " INNER JOIN profesores p on p.profesorid = m.profesorid";
		$sql .= " INNER JOIN estudiantes e on e.estudianteid = m.estudianteid";
		$sql .= " INNER JOIN horas h on h.horaid = m.horaid";
		$sql .= " INNER JOIN catalogos cm on cm.catalogotipo = ms.estadoactualtipo and cm.catalogovalor = ms.estadoactualvalor ";
		$sql .= " LEFT JOIN usuarios u on u.usuarioid = ms.usuarioregistro";
		$sql .= " WHERE 1=1 ";		
		if ($meetingid != null) {
			$sql .= " AND m.meetingid = '$meetingid' ";
		}
		$sql .= " AND m.estado = '1' ";
		$sql .= " AND h.estado = '1' ";
		
		$sql .= " ORDER BY ms.fecharegistro ASC ";
		
		$response['sqlMeetings'] = $sql;
		
		$result = mysqli_query($mysqli, $sql);
		
		if(empty(mysqli_errno($mysqli))) {
			if(mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$meeting = array();
					
					// Campos meeting status
					$meeting['meetingsstatusid'] = $row['meetingsstatusid'];
					$meeting['fecharegistro'] = $row['fecharegistroms'];
					$meeting['observacion'] = $row['observacionms'];
					$meeting['nombresms'] = $row['nombresms'];
					
					// Campos meeting
					$meeting['meetingid'] = $row['meetingid'];
					$meeting['profesorid'] = $row['profesorid'];
					$meeting['estudianteid'] = $row['estudianteid'];
					$meeting['fechameeting'] = $row['fechameeting'];
					$meeting['fecharegistro'] = $row['fecharegistro'];
					$meeting['horaid'] = $row['horaid'];
					$meeting['meetingstatuscode'] = $row['meetingstatuscode'];
					$meeting['meetingstatusvalue'] = $row['meetingstatusvalue'];
					$meeting['meetingstatusname'] = $row['meetingstatusname'];
					$meeting['meetingurl'] = $row['meetingurl'];
					$meeting['estado'] = $row['estado'];
					
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
	
					$meetingstatus[] = $meeting;
				}
			}
			$response['error'] = 0;
			$response['meetingstatus'] = $meetingstatus;			
			$response['count'] = count($meetingstatus);
			if (count($meetingstatus) > 0) {
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


