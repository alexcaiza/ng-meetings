<?php
    include_once("database.php");

    function findEstudianteByCedulaMail($mysqli, $cedula, $email) {
        
        $sql = "SELECT * FROM estudiantes WHERE cedula='$cedula' AND email='$email'";

        $user = null;

        $data = new StdClass;

        $data->sql = $sql;

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

    function findProfesorByCedulaMail($mysqli, $cedula, $email) {
        
        $sql = "SELECT * FROM profesores WHERE cedula='$cedula' AND email='$email'";

        $user = null;

        $data = new StdClass;

        $data->sql = $sql;

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