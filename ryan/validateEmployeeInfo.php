<?php
    include 'connect.php';
    include 'commonFunctions.php';
    echo "here";
    validate_employee_info($_GET["extension"], $_GET["firstName"], $_GET["lastName"], $_GET["email"]);
?>