<?php
	
	include_once 'funciones-error-handle.php';

    function getWeekDay($strDate) {
        return date('w', strtotime($strDate));
    }
?>