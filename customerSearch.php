<div class="container-fluid">
    <div class="row no-gutters">
        <div class="w-25 bg-light border-right" id="sidebar-wrapper">
            <div class="accordion" id="accordionExample">
                <div class="card z-depth-0 bordered">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="false" aria-controls="collapseOne">
                        Model
                        </button>
                    </h5>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                    data-parent="#accordionExample">
                    <div class="card-body">
                        <?php
                            require 'connect.php';
                            $conn = OpenCon();
            
                            $sql = "SELECT DISTINCT Model 
                            FROM cardealership.products
                            WHERE Brand LIKE '%".$_GET['q']."%' ";
                            
                            if ($result = mysqli_query($conn, $sql)) {
                                $count = 0;
                                while($row = mysqli_fetch_assoc($result)) {
                                    printf(
                                        "<div>
                                            <input type=\"checkbox\" class=\"modelcheckbox\" value=\"%s\" id=\"model%s\" onclick=\"filterResults()\">
                                            <label for=\"model%s\">%s</label>
                                        </div>",$row["Model"], $count, $count, $row["Model"]);
                                        $count++;
                                    }
                                    mysqli_free_result($result);
                                }
                            mysqli_close($conn);
                        ?>           
                    </div>
                    </div>
                </div>

                <div class="card z-depth-0 bordered">
                    <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="false" aria-controls="collapseTwo">
                        Color
                        </button>
                    </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionExample">
                    <div class="card-body">
                        <?php
                            $conn = OpenCon();
            
                            $sql = "SELECT DISTINCT Color 
                            FROM cardealership.products
                            WHERE Brand LIKE '%".$_GET['q']."%' ";
                            
                            if ($result = mysqli_query($conn, $sql)) {
                                $count = 0;
                                while($row = mysqli_fetch_assoc($result)) {
                                    printf(
                                        "<div>
                                            <input type=\"checkbox\" class=\"colorcheckbox\" value=\"%s\" id=\"color%s\" onclick=\"filterResults()\">
                                            <label for=\"color%s\">%s</label>
                                        </div>", $row["Color"], $count, $count, $row["Color"]);
                                        $count++;
                                    }
                                    mysqli_free_result($result);
                                }
                            mysqli_close($conn);
                        ?>           
                    </div>
                    </div>
                </div>

                <div class="card z-depth-0 bordered">
                    <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        Price
                        </button>
                    </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                    data-parent="#accordionExample">
                    <div class="card-body">
                        <?php
                            $conn = OpenCon();
            
                            $sql = "SELECT DISTINCT Price 
                            FROM cardealership.products
                            WHERE Brand LIKE '%".$_GET['q']."%' ORDER BY Price ASC";
                            
                            if ($result = mysqli_query($conn, $sql)) {
                                $count = 0;
                                while($row = mysqli_fetch_assoc($result)) {
                                    printf(
                                        "<div>
                                            <input type=\"checkbox\" class=\"pricecheckbox\" value=\"%s\" id=\"price%s\">
                                            <label for=\"price%s\">%s</label>
                                        </div>", $row["Price"], $count, $count, $row["Price"]);
                                        $count++;
                                    }
                                    mysqli_free_result($result);
                                }
                            mysqli_close($conn);
                        ?>           
                    </div>
                    </div>
                </div>
            </div>

            <div>
                <button id="reset" onclick="reset()">Reset</button>
            </div>
            <div>
                <button id="reset" onclick="home()">Home</button>
            </div>

        </div>

        <table class="w-75 table" id="tabela1">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Make</th>
                <th scope="col">Model</th>
                <th scope="col">Year</th>
                <th scope="col">Price</th>
                <th scope="col">Type</th>
                <th scope="col">Color</th>
                <th scope="col">Quantity</th>
                <th scope="col">City</th>
                </tr>
            </thead>
            <?php
                $conn = OpenCon();
                // if there is no space in the string, it was either a brand or model
                // if there is a space in the string there is a brand and a model
                if($_GET['q'] == "SUV") {
                    $sql = "SELECT Brand, Model, Year, Price, Type, Color, Quantity, city 
                    FROM cardealership.products JOIN cardealership.offices ON cardealership.products.officeCode = cardealership.offices.officeCode
                    WHERE Type = 'SUV'";
                } else if ($_GET['q'] == "Cyber Truck") {
                    $sql = "SELECT Brand, Model, Year, Price, Type, Color, Quantity, city 
                    FROM cardealership.products JOIN cardealership.offices ON cardealership.products.officeCode = cardealership.offices.officeCode
                    WHERE Model = 'Cyber Truck'";
                } else {
                    $input = explode(" ", $_GET['q']);
                    $input = array_map( 'strtolower', $input );

                    if(count($input) > 1) {
                        
                        $brand = $input[0];
                        $model = $input[1];
    
                        $sql = "SELECT Brand, Model, Year, Price, Type, Color, Quantity, city 
                        FROM cardealership.products JOIN cardealership.offices ON cardealership.products.officeCode = cardealership.offices.officeCode
                        WHERE LOWER(Brand) LIKE '".$brand."' AND LOWER(Model) LIKE '".$model."' ";
    
                    } else if(count($input) == 1) {
                        $sql = "SELECT Brand, Model, Year, Price, Type, Color, Quantity, city 
                        FROM cardealership.products JOIN cardealership.offices ON cardealership.products.officeCode = cardealership.offices.officeCode
                        WHERE Brand LIKE '%".$_GET['q']."%' OR Model LIKE '%".$_GET['q']."%' ";
                        
                    } else {
                        $sql = "SELECT Brand, Model, Year, Price, Type, Color, Quantity, city 
                        FROM cardealership.products JOIN cardealership.offices ON cardealership.products.officeCode = cardealership.offices.officeCode";
                    } 
                }
            
                if ($result = mysqli_query($conn, $sql)) {
                    while($row = mysqli_fetch_assoc($result)) {
                        printf(
                            "<tbody>
                                <tr>
                                    <td>%s</td>
                                    <td class=\"model\">%s</td>
                                    <td>%s</td>
                                    <td class=\"price\">%s</td>
                                    <td>%s</td>
                                    <td class=\"color\">%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                </tr>",
                                $row["Brand"],
                                $row["Model"],
                                $row["Year"],
                                $row["Price"],
                                $row["Type"],
                                $row["Color"],
                                $row["Quantity"],
                                $row["city"]);
                    }
                    mysqli_free_result($result);
                    printf( "</tbody>
                    </table>");
                } 
                mysqli_close($conn);
            ?>
    </div>
</div>