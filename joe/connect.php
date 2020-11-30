<?php
function OpenCon()
 {
    $user_info = getUser();
    $dbhost = $user_info[2];
    $dbuser = $user_info[0];
    $dbpass = $user_info[1];
    $db = "cardealership";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
    return $conn;
 }

 function getUser() {
     $myfile = fopen("../DB_USER.txt", "r") or die ("Unable to open user file");
     $file_input = fread($myfile, filesize("../DB_USER.txt"));
     $user_pw = explode(" ", $file_input);
     fclose($myfile);
     return $user_pw;
 }

function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>