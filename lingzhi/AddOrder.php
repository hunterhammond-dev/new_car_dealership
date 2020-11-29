<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->
<!DOCTYPE html>
<html>
<body>
<?php 
    if (!isset($_GET['customerid'])) {
        header("Location: ./CustomerOrder.php"); 
        return;
    } 
?>
<div id="start">
    <h2> Adding a New Order 
        <?php if(isset($_GET['customerName'])) echo " for " . $_GET['customerName'];?> 
    </h2>
    
    <p>
        <label for = "productSearch">Search Cars by Brand:</label>
        <input type = "text" id = "product" name = "product" value = "">
        <!--click on the search button, call showCars function and pass in the keyword entered. -->
        <button type = "button" onclick = "showCars(document.getElementById('product').value)" style = "background-color:blue;">Search</button>
    </p>

    <div id="addCars"></div>
    

</div>


<script>
    var cart = [];
    var tableHead = "<table style=\"width:100%; border: 1px solid black; text-align: center;\">" +
                    "<caption> Cars Added to Order</caption>" +
                    "<thead>" +
                    "<tr>" +
                    "<th>Product Name</th>" +
					"<th>Product Code</th>" +
                    "<th>Sales Price</th>" +
                    "<th>Quantity</th>" +
                    "<th>Delete</th>" +
                    "</tr>" +
                    "</thead><tbody>";
    var tableBody = "";
    var tableTail = "</tbody></Table>";
    var tableSubmitButton="<p><input type=\"button\" id = \"orderBtn\" value=\"Submit\" onclick=\"insertOrders()\"></p>";

    // selectCars
    // it is called when selecting a car from search results and add to the order; 
    // its productName, productCode and quantity in stock will be passed in as parameters.
    function selectCars(str1, str2, str3) {  //maybe validate the inputs here???
        for (var i = 0; i < cart.length; i++) {
            if(cart[i][1] == str2) return; // if cars'product code selected already exist in array, don't add it to the array   
        }

        var carinfo = [];

        carinfo[0] = str1; // product name
        carinfo[1] = str2; // productCode
        carinfo[2] = "0"; // price
        carinfo[3] = "1"; // quantity
        carinfo[4] = str3; // quantity in stock

       
        cart.push(carinfo);
    
        tableBody = "";//reset the content of tableBody when selecting a new car and print all the cars selected in the array 
        //Display Table
        for (var i = 0; i < cart.length; i++) {
            tableBody += "<tr>";
            tableBody += "<td >" + cart[i][0] + "</td>";
            tableBody += "<td>" + cart[i][1] + "</td>";
            tableBody += '<td><input type="number" id="price'+cart[i][1]+'" value="' + cart[i][2]+'" onchange = "getPrice(this.value, \'' + cart[i][1] + '\')" name="price"></td>';
            tableBody += '<td><input type="number" id="quantity'+cart[i][1]+'" value="' + cart[i][3]+'" onchange = "getQuantity(this.value, \'' + cart[i][1] + '\')" name="quantity"></td>';
            tableBody += '<td><button type = "button" onclick="deleteCars(\''+cart[i][1]+'\')" style="background-color:red;">Delete</button></td>';
            tableBody += "</tr>";
           
        }

        document.getElementById("addCars").innerHTML = tableHead + tableBody + tableTail + tableSubmitButton;
    }//end selectCars

    function getPrice(val, pc){
        for (var i = 0; i < cart.length; i++){
            if(cart[i][1] == pc && val != ""){
                cart[i][2] = val;
            }
              
        }
    }

    function getQuantity(val, pc){
        for (var i = 0; i < cart.length; i++){
            if(cart[i][1] == pc && val != ""){
                cart[i][3] = val;
            }
        }  
    }

    function deleteCars(pc){
        for (var i = 0; i < cart.length; i++){
            if(cart[i][1] == pc){
                cart.splice(i,1); // starting from index i of the array, delete 1 item 
            }    
        }
        tableBody = "";//reset the content of tableBody when selecting a new car and printing all the cars selected in the array 
        //Display Table
        var i = 0;
        for (; i < cart.length; i++) {
            tableBody += "<tr>";
            tableBody += "<td >" + cart[i][0] + "</td>";
            tableBody += "<td>" + cart[i][1] + "</td>";
            tableBody += '<td><input type="number" id="price'+cart[i][1]+'" value="' + cart[i][2]+'" onchange = "getPrice(this.value, \'' + cart[i][1] + '\')" name="price"></td>';
            tableBody += '<td><input type="number" id="quantity'+cart[i][1]+'" value="' + cart[i][3]+'" onchange = "getQuantity(this.value, \'' + cart[i][1] + '\')" name="quantity"></td>';
            tableBody += '<td><button type = "button" onclick="deleteCars(\''+cart[i][1]+'\')" style="background-color:red;">Delete</button></td>';
            tableBody += "</tr>";
        }
        if(i != 0)
            document.getElementById("addCars").innerHTML = tableHead + tableBody + tableTail + tableSubmitButton;
        else
            document.getElementById("addCars").innerHTML = "";
    }
</script>


<!-- build the search results table here -->
<div id="searchCars"></div>

<script> 

    //Ajax--display all the cars that meet the search keyword(brand)
    function showCars(str) {
    var xhttp;    
    if (str == "") {
        document.getElementById("searchCars").innerHTML = "";
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("searchCars").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "searchCars.php?q="+str, true);
    xhttp.send();
    }
</script>


<div id="orderInsertResult"></div>
<br><br>
<button id ="backBtn" type = "button" style="float: right;" onclick="location.href='./CustomerOrder.php?customerid=<?php echo $_GET['customerid']; ?>'">Back to Orders History</button>

<script>
    function insertOrders() {
        var customerid = <?php echo $_GET['customerid']; ?>;//get the target customer id in the URL and pass it to SubmitOrder.php
        var cartJSON = JSON.stringify(cart);
        var xhttp;    
        var output;
        xhttp = new XMLHttpRequest();
        
        //need to have a button to go back to add an order page
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {  
                var data = JSON.parse(this.responseText); //generate array from json string
                document.getElementById("orderInsertResult").innerHTML = data[1];
                if (data[0] == "pass") {
                    //document.getElementById("backBtn").style.display = "block";
                    document.getElementById("searchCars").innerHTML = "";
                    document.getElementById("addCars").innerHTML ="";
                    cart = [];//clear the cart array for next order insertion after successfully submitting an order
                }
               
            }
        };
        xhttp.open("GET", "SubmitOrder.php?p=" + customerid+"&q=" + cartJSON, true);
        xhttp.send();
    }
</script>
</body>
</html>
