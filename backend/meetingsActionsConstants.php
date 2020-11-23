<?php

	include_once 'funciones-error-handle.php';

	class MeetingsActionsConstants
	{
		const CONSTANT = 'constant value';
		
		const CT_MEETING_ACTION = 2;
		const CV_MEETING_ACTION_ESTUDIANTE_REGISTRAR = 'REGEST';
		const CV_MEETING_ACTION_ESTUDIANTE_CANCELAR = 'CANEST';
		const CV_MEETING_ACTION_DOCENTE_AGENDAR = 'AGEPRO';
		const CV_MEETING_ACTION_DOCENTE_CANCELAR = 'CANPRO';
		
		function showConstant() {
			echo  self::CONSTANT . "\n";
		}
	}

	//echo MeetingsStatusConstants::STATUS_REGISTRADO . "\n";
?>