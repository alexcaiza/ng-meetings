<?php

	include_once 'funciones-error-handle.php';
	
	class MeetingsStatusConstants
	{
		const CONSTANT = 'constant value';
		
		const CT_MEETING_STATUS = 1;
		const CV_MEETING_STATUS_INICIO = 'INI';
		const CV_MEETING_STATUS_REGISTRADO = 'REG';
		const CV_MEETING_STATUS_CANCELADO = 'CAN';
		const CV_MEETING_STATUS_CERRADO = 'CER';
		const CV_MEETING_STATUS_TERMINADO = 'TER';

		function showConstant() {
			echo  self::CONSTANT . "\n";
		}
	}

	//echo MeetingsStatusConstants::STATUS_REGISTRADO . "\n";
?>