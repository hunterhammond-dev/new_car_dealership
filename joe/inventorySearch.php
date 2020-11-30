<!--
Get All Inventory.
By: Joe Wright.
-->
<table class="w-75 table" id="tabela1">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Inv. #</th>
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
                include 'connect.php';
                include 'commonFunctions.php';
                $conn = OpenCon();
                $sql = "SELECT inventoryNumber, Brand, Model, Year, Price, Type, Color, Quantity, city FROM cardealership.products 
                JOIN cardealership.offices ON cardealership.products.officeCode = cardealership.offices.officeCode
                WHERE inventoryNumber = '".$_GET['q']."'";

                $result = $conn->query($sql);
                $price =1;
                $quant = 2;

                if ($result = mysqli_query($conn, $sql)) {
                    while($row = mysqli_fetch_assoc($result)) {
                        printf(
                            "<tbody>
                                <tr>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td class=\"price\"><input type=\"number\" id=\"price\" value=\"%s\" onchange=\"updateInv(%s, %s);\"></td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td class=\"quantity\"><input type=\"number\" id=\"quant\" value=\"%s\" onchange=\"updateInv(%s, %s);\"></td>
                                    <td>%s</td>
                                </tr>",
                                $row["inventoryNumber"],
                                $row["Brand"],
                                $row["Model"],
                                $row["Year"],
                                $row["Price"],
                                $row["inventoryNumber"],
                                $price,
                                $row["Type"],
                                $row["Color"],
                                $row["Quantity"],
                                $row["inventoryNumber"],
                                $quant,
                                $row["city"]);
                    }
                    mysqli_free_result($result);
                    printf( "</tbody>
                    </table>");
                } 
                
                CloseCon($conn);
            ?>
</table>