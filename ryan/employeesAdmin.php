<!--
Main Employee Admin Page.
By: Ryan Lenea.
-->
<html lang="EN">
<head>
    <title>Employee Admin Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

</head>

<body>
<h2>Employee Admin</h2>
<a href="../index.html">Back To Main Admin Portal</a>
<h5>Enter Employee ID or that employee's first and last name to search</h5>

<?php
include 'connect.php';
include 'commonFunctions.php';
?>

<section>

        <!--Main search menu-->
        <form action="editEmployee.php" method="post">
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
                        <input type="submit" value="See All" onclick="showAllEmployees(); return false;">
                    </form>
                </td>
                <td>
                    <form action="addEmployee.php">
                        <input type="submit" value="Add Employee" id="addEmployeeBtn">
                    </form>
                </td>
            </tr>
        </table>
        <!--End buttons-->

        <!--Where ajax places result of see all employees button click query-->
        <div id="tableDisplaySpace"></div>

</section>

<script>
    // Ajax call to get all employees and display on same page.
    function showAllEmployees() {
        document.getElementById("tableDisplaySpace").innerHTML = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tableDisplaySpace").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getAllEmployeesDB.php",true);
        xmlhttp.send();
    }

    // function showEmployee(id, first, last) {
    //     document.getElementById("tableDisplaySpace").innerHTML = "";
    //     document.getElementById("editEmployeeBtn").hidden = false;
    //     var xmlhttp = new XMLHttpRequest();
    //     xmlhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             document.getElementById("tableDisplaySpace").innerHTML = this.responseText;
    //         }
    //     };
    //     xmlhttp.open("GET","searchEmployee.php?id="+id+"&first="+first+"&last="+last, true);
    //     xmlhttp.send();
    //     // TODO: why does this break it? don't want it to display edit button if not employees found to display
    //     // if (document.getElementById("tableDisplaySpace").innerHTML.indexOf("Error") !== -1 {
    //     //     document.getElementById("editEmployeeBtn").hidden = true;
    //     // }
    //
    // }
</script>

</body>
</html>