<?php
    include_once("database.php");

    function findEstudianteByCedulaMail($cedula, $email) {
        
        $sql = "SELECT * FROM estudiantes WHERE cedula='$cedula' AND email='$email'";

        $user = null;

        $data = new StdClass;

        $data->sqlEstudiante = $sql;

        if($result = mysqli_query($mysqli, $sql)) {
            
            $user = null;
            
            while($row = mysqli_fetch_assoc($result)) {
                $user = $row;
            }

            if ($user != null) {
                $data->user = $user;
                $data->error = "0";
            } else {
                $data->error = "1";
            }
        } else {
            $data->error = "2";
        }
        return $data;
    }

    function findProfesorByCedulaMail($cedula, $email) {
        
        $sql = "SELECT * FROM profesores WHERE cedula='$cedula' AND email='$email'";

        $user = null;

        $data = new StdClass;

        $data->sqlEstudiante = $sql;

        if($result = mysqli_query($mysqli, $sql)) {
            
            $user = null;
            
            while($row = mysqli_fetch_assoc($result)) {
                $user = $row;
            }

            if ($user != null) {
                $data->user = $user;
                $data->error = "0";
            } else {
                $data->error = "1";
            }
        } else {
            $data->error = "2";
        }
        return $data;
    }
?>