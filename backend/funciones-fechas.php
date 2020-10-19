<?php
    function getWeekDay($strDate) {
        return date('w', strtotime($strDate));
    }
?>