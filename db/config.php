<?php

session_start();

if(isset($_SESSION['lms_logon'])){$userid = $_SESSION['lms_logon'];}
else{$userid = "";}

?>

