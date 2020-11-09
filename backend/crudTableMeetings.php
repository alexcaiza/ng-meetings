<?php

	function insertMeetingTable($validationFields, $mysqli) {
		$meetingid = null;
		$error = null;
		$message = null;
		try {
			
			$estado = 1;
			$fecharegistro = date('Y-m-d H:i:s');
			
			// Registra un insert on table meetings
			$sqlInsertMeeting = "INSERT INTO `meetings` ";
			$sqlInsertMeeting .= "(`meetingid`, `profesorid`, `estudianteid`, `fechameeting`, `horaid`, `meetingurl`, `meetingstatuscode`, `meetingstatusvalue`, `estado`, `fecharegistro`) ";
			$sqlInsertMeeting .= " VALUES ";
			$sqlInsertMeeting .= "(";
			$sqlInsertMeeting .= "null,";
			$sqlInsertMeeting .= "'$validationFields->profesorid',";
			$sqlInsertMeeting .= "'$validationFields->estudianteid',";
			$sqlInsertMeeting .= "'$validationFields->fechameeting',";
			$sqlInsertMeeting .= "'$validationFields->horaid',";
			if ($validationFields->meetingurl == null) {
				$sqlInsertMeeting .= "null,";
			} else {
				$sqlInsertMeeting .= "'$validationFields->meetingurl',";
			}
			if ($validationFields->meetingstatuscode == null) {
				$sqlInsertMeeting .= "null,";
			} else {
				$sqlInsertMeeting .= "'$validationFields->meetingstatuscode',";
			}
			if ($validationFields->meetingstatusvalue == null) {
				$sqlInsertMeeting .= "null,";
			} else {
				$sqlInsertMeeting .= "'$validationFields->meetingstatusvalue',";
			}
			$sqlInsertMeeting .= "'$estado',";
			$sqlInsertMeeting .= "'$fecharegistro'";
			$sqlInsertMeeting .= ")";
			
			$response['sqlInsertMeeting'] = $sqlInsertMeeting;
			
			//var_dump($sqlInsertMeeting);
		
			$resultset = mysqli_query($mysqli, $sqlInsertMeeting) or die(mysqli_error());
			
			if($resultset) {				
				$meetingid = mysqli_insert_id($mysqli);
				$error = 0;
				$message = "Los datos se registraron correctamente";				
			} else  {
				$error = 1;
				$message = "Error statement insert table meeting";
			}
		} catch (Exception $e) {
			$error = 1;
			$message = $e->getMessage();
		}
		
		$obj = new stdClass();
		$obj->error = $error;
		$obj->message = $message;
		$obj->meetingid = $meetingid;
		
		return $obj;
	}
	
	function updateMeetingTable($params, $mysqli) {
		$error = null;
		$message = null;
		$bandF = false;
		$isvalid = false;
		$sql = null;
		try {
			
			$fechamodificacion = date('Y-m-d H:i:s');
			
			// Registra un insert on table meetings
			$sql = "UPDATE `meetings` SET ";
			
			$sql .= " fechamodificacion='$fechamodificacion'";
			
			if (isset($params->meetingurl) && $params->meetingurl != null) {
				$sql .= ", meetingurl='$params->meetingurl'";
				$bandF = true;
			}
			if (isset($params->meetingstatuscode) && $params->meetingstatuscode != null) {
				$sql .= ", meetingstatuscode='$params->meetingstatuscode'";
				$bandF = true;
			}
			if (isset($params->meetingstatusvalue) && $params->meetingstatusvalue != null) {
				$sql .= ", meetingstatusvalue='$params->meetingstatusvalue'";
				$bandF = true;
			}
			if (isset($params->estado) && $params->estado != null) {
				$sql .= ", estado='$params->estado'";
				$bandF = true;
			}
			
			$sql .= " WHERE 1=1";
			
			if (isset($params->meetingid) && $params->meetingid  != null) {
				$sql .= " AND meetingid='$params->meetingid'";
				$bandR = true;
			}
			
			//var_dump($sql);
			//var_dump($bandF);
			//var_dump($bandR);
			//var_dump($params);
			
			if ($bandF == true && $bandR == true) {
					
				$resultset = mysqli_query($mysqli, $sql) or die(mysqli_error());
				
				if($resultset) {				
					$error = 0;
					$isvalid = true;
					$message = "Los datos se actualizaron correctamente";				
				} else  {
					$error = 1;
					$message = "Error statement update table meeting";
				}
			} else {
				if ($bandF == false) {
					$message = "Valores vacios en los campos para actualizar meeting";
				} 
				else if ($bandR == false) {
					$message = "Valores vacios en las restricciones para actualizar meeting";
				}
				$error = 1;
			}
			
		} catch (Exception $e) {
			$error = 1;
			$message = $e->getMessage();			
		}
		
		$params->sql = $sql;
		$params->error = $error;
		$params->isvalid = $isvalid;
		$params->message = $message;
		
		return $params;
	}

?>