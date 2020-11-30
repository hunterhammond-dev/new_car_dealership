<!--
Main Employee Admin Page.
By: Joe Wright and Ryan Lenea.
-->
<html lang="EN">
<head>
    <title>Inventory Admin Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<h2>Inventory Admin</h2>
<a href="../admin.html">Back To Main Admin Portal</a>
<h5>To update inventory, search for an inventory number. To add a product, click the 'Add Inventory' button. Otherwise, view all inventory.</h5>

<?php
include 'connect.php';
include 'commonFunctions.php';
?>

<section>

    <!--Main search menu-->
    <p>
        <label for="first">Inventory #:</label>
        <input type="number" id="invNum"><br>
    </p>
    <input type="submit" value="Search" onclick="searchInvNum(document.getElementById('invNum').value);">
    
    <!--End Main search menu-->

    <!--See all inventory and add inventory btn-->
    <table>
        <br>
        <tr>
            <td>
                <form>
                    <input type="submit" value="See All" onclick="showAllInventory(); return false;">
                </form>
            </td>
            <td>
                <form action="addInventory.php">
                    <input type="submit" value="Add Inventory" id="addInventory">
                </form>
            </td>
        </tr>
    </table>
    <!--End buttons-->

    <!--Where ajax places result of see all employees button click query-->
    <div id="tableDisplaySpace"></div>

</section>

<script>
    // Ajax call to get all inventory and display on same page.
    function showAllInventory() {
        document.getElementById("tableDisplaySpace").innerHTML = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tableDisplaySpace").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getAllInventoryDB.php",true);
        xmlhttp.send();
    }

    function searchInvNum (q) {
        var xhttp;
        xhttp = new XMLHttpRequest();
        // Define when we receive answer from server, write the data to result div
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tableDisplaySpace").innerHTML = this.responseText;
            }
        };
        // Make async get request to server
        xhttp.open("GET", "inventorySearch.php?q="+q, true);
        xhttp.send();
    }

    function updateInv (invN, field) {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        if (field == 1) {
            // Need send inventory number, field, and value
            xhttp.open("GET", "updateInventory.php?inv="+invN+"&field="+field+"&val="+document.getElementById("price").value, true);
            xhttp.send();
        } else {
            xhttp.open("GET", "updateInventory.php?inv="+invN+"&field="+field+"&val="+document.getElementById("quant").value, true);
            xhttp.send();
        }
        
        
    }
</script>

     <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>