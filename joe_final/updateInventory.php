<?php
    $inv = $_REQUEST["inv"];
    $field = $_REQUEST["field"];
    $val = $_REQUEST["val"];
    include 'connect.php';
    include 'commonFunctions.php';
    $conn = OpenCon();
    if($field == 1) {
        $sql = "UPDATE cardealership.products SET Price = $val WHERE inventoryNumber =$inv";
        if (mysqli_query($conn,$sql)) {
            echo "Records were updated successfully";
        } else {
            echo "There was an issue with the update";
        }
    } else {
        $sql = "UPDATE cardealership.products SET Quantity = $val WHERE inventoryNumber =$inv";
        if (mysqli_query($conn,$sql)) {
            echo "Records were updated successfully";
        } else {
            echo "There was an issue with the update";
        }
    }
    CloseCon($conn);
?>