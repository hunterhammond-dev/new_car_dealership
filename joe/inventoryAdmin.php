<!--
Main Employee Admin Page.
By: Joe Wright and Ryan Lenea.
-->
<html lang="EN">
<head>
    <title>Inventory Admin Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

</head>

<body>
<h2>Inventory Admin</h2>
<a href="../admin.html">Back To Main Admin Portal</a>
<h5>TODO: subhead hear</h5>

<?php
include 'connect.php';
include 'commonFunctions.php';
?>

<section>

    <!--Main search menu-->
    <form action="editEmployee.php" method="post">
        TODO: modify below to search product, not employee.
        <p>
            <label for="first">First Name:</label>
            <input type="text" name="first" id="first"><br>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last">
        </p>
        <p>OR</p>
        <p>
            <label for="last">Employee Number:</label>
            <input type="text" name="id" id="id">
        </p>
        <input type="submit" value="Search">
    </form>
    <!--End Main search menu-->

    <!--See all employees and add employees buttons-->
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
</script>

</body>
</html>