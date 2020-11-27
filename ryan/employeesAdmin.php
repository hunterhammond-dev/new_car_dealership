
<html>
<!--QUESTIONS: how do you make the php and html render in order - first value doesn't actually appear first.-->
<!--how do we want to handle deleteing an employee in other tables? Just put null for no salesperson?-->
<h2>Employee Admin</h2>
<a href="adminPortalPage.html">Back To Main Admin Portal</a>
<h3>Enter Employee ID or that employee's first and last name to search</h3>
<body>

<?php
include 'connect.php';
include 'commonFunctions.php';
$id="";
?>

<section class="features-icons bg-light text-center">
    <div class="container">

        <form action="editEmployee.php" method="post">

            First Name: <input type="text" name="first"><br>
            Last Name : <input type="text" name="last"><br><br>
            OR<br><br>
            Employee Number : <input type="text" name="id"><br><br>
            <input type="submit" value="Search">
        </form>

        <!--        TODO would be nice if this would work...-->
        <!--            <input type="submit" value="Search" name="addEmployeeBtn" onclick="showEmployee(document.getElementById('idField').value,-->
        <!--                                                                                            document.getElementById('firstNameField').value,-->
        <!--                                                                                            document.getElementById('lastNameField').value); return false;">-->


        <form>
        <input type="submit" value="See All" name="seeAllEmployeesBtn" onclick="showAllEmployees(); return false;">
        </form>

        <form action="editEmployee.php">
            <input hidden type="submit" value="Edit Employee" id="editEmployeeBtn">
        </form>
        <form action="addEmployee.php">
            <input  type="submit" value="Add Employee" id="addEmployeeBtn">
        </form>

        <div id="tableDisplaySpace"></div>


    </div>

</section>

<script>
    function showAllEmployees() {
        document.getElementById("tableDisplaySpace").innerHTML = "";
        document.getElementById("editEmployeeBtn").hidden = true;
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