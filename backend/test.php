<?php
	include_once 'funciones-error-handle.php';
	
	try {
		$data = new StdClass; 
		$data->nombre = "Alex Caiza";
		//echo($data);
		
		var_dump($data->nombre);
		
		$apellido = $data->apellido;
		
		var_dump($data->nombre);
		
		//var_dump($data->apellido);
	} catch (Error $e) {
		echo "Error caught: " . $e->getMessage();
	} catch (\Exception $e) {
		echo "Exception: " . $e->getMessage();
	} catch (\Throwable $e) {
		echo "Throwable: " . $e->getMessage();
	} catch (\ErrorException $e) {
		echo "ErrorException: " . $e->getMessage();
	}
?>