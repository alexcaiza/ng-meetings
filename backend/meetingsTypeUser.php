<?php

	include_once 'funciones-error-handle.php';

	class MeetingsTypeUser
	{
		const CONSTANT = 'constant value';
		
		const CT_TYPE_USER = 3;
		const CT_TYPE_USER_ESTUDIANTE = 'EST';
		const CT_TYPE_USER_DOCENTE = 'PRO';

		function showConstant() {
			echo  self::CONSTANT . "\n";
		}
	}

	//echo MeetingsStatusConstants::STATUS_REGISTRADO . "\n";
?>