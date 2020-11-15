<?php

	function insertMeetingStatusTable($params, $mysqli) {
		$meetingsstatusid = null;
		$error = null;
		$message = null;
		$isvalid = false;
		$sql = null;
		try {
			
			$estado = 1;
			$fecharegistro = date('Y-m-d H:i:s');
			
			// Make insert on table meetingsstatus
			$sql = "INSERT INTO `meetingsstatus` ";
			$sql .= "(`meetingsstatusid`, `meetingid`, `estadoanteriortipo`, `estadoanteriorvalor`, `estadoactualtipo`, `estadoactualvalor`, `fechainicio`, `fechafin`, `fecharegistro`, `estado`, `observacion`, `usuarioregistro`) ";
			$sql .= " VALUES ";
			$sql .= "(";
			$sql .= "null,";
			$sql .= "'$params->meetingid',";
			$sql .= "'$params->estadoanteriortipo',";
			$sql .= "'$params->estadoanteriorvalor',";
			$sql .= "'$params->estadoactualtipo',";
			$sql .= "'$params->estadoactualvalor',";
			$sql .= "'$params->fechainicio',";
			if ($params->fechafin == null) {
				$sql .= "null,";
			} else {
				$sql .= "'$params->fechafin',";
			}
			$sql .= "'$fecharegistro',";
			$sql .= "'$estado',";
			//Campo observacion
			if ($params->observacion == null) {
				$sql .= " null, ";
			} else {
				$sql .= "'$params->observacion',";
			}
			//Campo usuarioregistro
			if ($params->usuarioid == null) {
				$sql .= " null ";
			} else {
				$sql .= "'$params->usuarioid'";
			}			
			$sql .= ")";
			
			//var_dump($sql);
		
			$resultset = mysqli_query($mysqli, $sql) or die(mysqli_error());
			
			if($resultset) {				
				$meetingsstatusid = mysqli_insert_id($mysqli);
				$error = 0;
				$isvalid = true;
				$message = "Los datos se registraron correctamente";				
			} else  {
				$error = 1;
				$message = "Error statement insert table meetingsstatus";
			}
		} catch (Exception $e) {
			$error = 1;
			$message = $e->getMessage();
		}
		
		$params->sql = $sql;
		$params->error = $error;
		$params->isvalid = $isvalid;
		$params->message = $message;
		$params->meetingsstatusid = $meetingsstatusid;
		
		return $params;
	}

	function updateMeetingStatusTable($params, $mysqli) {
		$sql = null;
		$error = null;
		$message = null;
		$bandF = false;
		$bandR = false;
		$isvalid = false;
		try {
			
			$fechamodificacion = date('Y-m-d H:i:s');
			
			// Registra un insert on table meetings
			$sql = "UPDATE `meetingsstatus` SET ";
			
			$sql .= " fechamodificacion='$fechamodificacion'";
			
			if (isset($params->estadoanteriortipo) && $params->estadoanteriortipo != null) {
				$sql .= ", estadoanteriortipo='$params->estadoanteriortipo'";
				$bandF = true;
			}
			if (isset($params->estadoanteriorvalor) && $params->estadoanteriorvalor != null) {
				$sql .= ", estadoanteriorvalor='$params->estadoanteriorvalor'";
				$bandF = true;
			}
			if (isset($params->estadoactualtipo) && $params->estadoactualtipo  != null) {
				$sql .= ", estadoactualtipo='$params->estadoactualtipo'";
				$bandF = true;
			}
			if (isset($params->fechainicio) && $params->fechainicio  != null) {
				$sql .= ", fechainicio='$params->fechainicio'";
				$bandF = true;
			}
			if (isset($params->fechafin) && $params->fechafin  != null) {
				$sql .= ", fechafin='$params->fechafin'";
				$bandF = true;
			}
			if (isset($params->estado) && $params->estado  != null) {
				$sql .= ", estado='$params->estado'";
				$bandF = true;
			}
			if (isset($params->observacion) && $params->observacion  != null) {
				$sql .= ", observacion='$params->observacion'";
				$bandF = true;
			}
			if (isset($params->usuarioid) && $params->usuarioid != null) {
				$sql .= ", usuariomodificacion 	='$params->usuarioid'";
				$bandF = true;
			}
			
			$sql .= " WHERE 1=1";
			
			if (isset($params->meetingid) && $params->meetingid != null) {
				$sql .= " AND meetingid='$params->meetingid'";
				$bandR = true;
			}
			if (isset($params->meetingsstatusid) && $params->meetingsstatusid != null) {
				$sql .= " AND meetingsstatusid='$params->meetingsstatusid'";
				$bandR = true;
			}
			
			//var_dump($sqlUpdate);
			
			if ($bandF == true && $bandR == true) {
					
				$resultset = mysqli_query($mysqli, $sql) or die(mysqli_error());
				
				if($resultset) {				
					$error = 0;
					$isvalid = true;
					$message = "Los datos se actualizaron correctamente";				
				} else  {
					$error = 1;
					$message = "Error statement update table meetingsstatus";
				}
			} else {
				if ($bandF == false) {
					$message = "Valores vacios en los campos para actualizar meetingsstatus";
				}
				else if ($bandR == false) {
					$message = "Valores vacios en las restricciones para actualizar meetingsstatus";
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