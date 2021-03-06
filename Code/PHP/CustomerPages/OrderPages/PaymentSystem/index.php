<?php
use \PhpPot\Service\StripePayment;

require_once "../../../Header.php";
require_once "config.php";
require_once "/var/www/html/Main/PHP/Connections/ConnectionCustomer.php";

    // This code gets the user's IP public address and uses it to distinguish the user's order between different systems
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  // Checks if IP is from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
                                
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // Checks if IP is passed from a proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                
    } else { // Else, get IP address of connecting party 
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Select all the Orders from the TempOrders where the IP stored in the table equals the user's IP
    $sql = "SELECT * FROM TempOrders WHERE IP = '$ip'";
    $res = $conn->query($sql);
    if(!is_null($res)) {
        $TotalAmount = 0;
        while($row = mysqli_fetch_assoc($res)){
            $TableNumber = $row['TableNo'];
            $ID = $row['ID'];
            $Item = $row['Item'];
            $Quantity = $row['Quantity'];
            $Price = $row['Price'];
            // Set Total Amount by doing Total Amount = itself + Quantity of Item * Price of Item
            $TotalAmount = $TotalAmount + ($Quantity * $Price);
        }
    } else {
        // Else, display error while parsing order
        echo('Error While Parsing Order');
    }


if (!empty($_POST["token"])) {
    require_once 'StripePayment.php';
    $stripePayment = new StripePayment();
    
    $stripeResponse = $stripePayment->chargeAmountFromCard($_POST);
    
    require_once "Database.php";
    $databaseConn = new Database();
    
    $amount = $stripeResponse["amount"] /100;

    $param_type = 'sssssss'; // Indicates type of parameters, 's' denotes String, 'd' denotes Number/Decimal
    // Array containing values to be inserted into Payment table
    $param_value_array = array(
        $stripeResponse["balance_transaction"],
        $_POST['name'],
        $_POST['email'],
        $amount,
        $stripeResponse["currency"],
        $stripeResponse["status"],
        json_encode($stripeResponse)
    );
    // SQL query to actually insert data into Payment database table. The '?' in values denotes that these values will be coming from the array later on
    $query = "INSERT INTO Payment (TransactionID, Name, Email, TotalAmount, Currency, PaymentStatus, PaymentResponse) values (?, ?, ?, ?, ?, ?, ?)";
    $id = $databaseConn->insert($query, $param_type, $param_value_array);
    
    // If the Payment Status/Response is successful/succeeded, do this:
    if ($stripeResponse['amount_refunded'] == 0 && empty($stripeResponse['failure_code']) && $stripeResponse['paid'] == 1 && $stripeResponse['captured'] == 1 && $stripeResponse['status'] == 'succeeded') {
        // Concatenate transaction ID and string into success message
        $successMessage = "Your Transaction ID is: " . $stripeResponse["balance_transaction"];
        
        // Insert paid-for order into the Orders table. Note that the PaymentStatus being entered is "Paid"
        $sql = "INSERT INTO Orders (IP, TableNo, ID, Item, Quantity, Price, Status, PaymentStatus, Time) SELECT TempOrders.IP, TempOrders.TableNo, TempOrders.ID, TempOrders.Item, TempOrders.Quantity, TempOrders.Price, 'Order Placed', 'Paid', now() FROM TempOrders WHERE TempOrders.IP = '$ip'";

            if (mysqli_query($conn, $sql)) {
                // If SQL query was successful, delete the order from the temporary TempOrders table where IP matches user's IP
                $sql = "DELETE FROM TempOrders WHERE IP = '$ip'";
                if (mysqli_query($conn, $sql)) {
                ?>
                    <!-- Make these divs hidden to display new content, which is the payment success divs -->
                    <style>
                        #totalAmount {
                            display: none;
                        }

                        #yourTableNumber {
                            display: none;
                        }

                        #frmStripePayment {
                            display: none;
                        }
                    </style>

                    <?php 
                        // Final validation check that the success message is not empty, which it won't be after a successful payment
                        if(!empty($successMessage)) { ?>
                            <div id="success">
                                <!-- Display Confirmation Image (A green tick) -->
                                <img src="Confirmation.png" id="confirmationImg" height="200" width="200">
                                <!-- Print to user "We have displayed your order" and their transaction ID -->
                                <h4 id="receivedOrder">We have received your order!</h5>
                                <h5 id="successMessage"><?php echo $successMessage; ?></h5>
                                <br>
                                <h5 id="deliverWhenReady">We will be delivering your meal to your table as soon as it is ready!</h6>
                                <!-- Button to allow user to navigate back to home page once payment completed -->
                                <a class="btn btn-success btn-md" id="backToHome" href="/Main/PHP/CustomerPages/IndexPage/indexPage.php">Back to Home Page</a>

                            </div>
                    <?php  } ?>
                
                <?php
                } else {
                    // If DELETE FROM TempOrders query failed, print "Error Removing Order from Basket" and the error from the connection
                    echo('<h5>Error Removing Order From Basket. Please request assistance from one of our waiters.</h5>');
                    echo('<br>');
                    echo(mysqli_error($conn));
                }
            } else {
                // If INSERT INTO Orders query failed, print "Error Placing Order" with the error from the connection
                echo('<h5>Error Placing Order. Please request assistance from one of our waiters.</h5>');
                echo(mysqli_error($conn));
            }
    }
}
?>
    <!-- Div which displays the error message. It is hidden until the user encounters an error, like not filling in all forms for example -->
    <div id="error-message"></div>
            <br>
            <!-- Echo Total Amount and Table Number, as a final confirmation to the user -->
            <h4 id="totalAmount">Total Amount: £<?php echo($TotalAmount); ?></h4>
            <h4 id="yourTableNumber">Your Table Number: <?php echo($TableNumber); ?></h4>
                
            <!-- Stripe Payment Form to take card details -->
            <form id="frmStripePayment" action="" method="post">
                <div class="field-row">
                    <label>Card Holder Name</label>
                    <span id="card-holder-name-info" class="info"></span><br>
                    <input type="text" id="name" name="name" class="demoInputBox">
                </div>
                <div class="field-row">
                    <label>Email</label> 
                    <span id="email-info" class="info"></span><br>
                    <input type="text" id="email" name="email" class="demoInputBox">
                </div>
                <div class="field-row">
                    <label>Card Number</label>
                    <span id="card-number-info" class="info"></span><br>
                    <input type="text" id="card-number" name="card-number" class="demoInputBox">
                </div>
                <div class="field-row">
                    <div class="contact-row column-right">
                        <label>Expiry Month / Year</label>
                        <span id="userEmail-info" class="info"></span><br>
                        <select name="month" id="month" class="demoSelectBox">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select> <select name="year" id="year"
                            class="demoSelectBox">
                            <option value="19">2019</option>
                            <option value="20">2020</option>
                            <option value="21">2021</option>
                            <option value="22">2022</option>
                            <option value="23">2023</option>
                            <option value="24">2024</option>
                            <option value="25">2025</option>
                            <option value="26">2026</option>
                            <option value="27">2027</option>
                            <option value="28">2028</option>
                            <option value="29">2029</option>
                            <option value="30">2030</option>
                        </select>
                    </div>
                    <div class="contact-row cvv-box">
                        <label>CVC</label> <span id="cvv-info"
                            class="info"></span><br> <input type="text"
                            name="cvc" id="cvc"
                            class="demoInputBox cvv-input">
                    </div>
                </div>
                <div>
                    <input type="submit" name="pay_now" value="Submit"
                        id="submit-btn" class="btnAction"
                        onClick="stripePay(event);">

                    <!-- Display LoaderIcon.gif when user clicks submit and all forms are not empty -->
                    <div id="loader">
                        <img alt="loader" src="LoaderIcon.gif">
                    </div>
                </div>
                <!-- These input types are hidden because they are data for the Stripe Dashboard online -->
                <input type='hidden' name='amount' value='<?php echo($TotalAmount); ?>'> 
                <input type='hidden' name='currency_code' value='GBP'>
                <input type='hidden' name='description' value='Oaxaca Restaurants Order'>
                <input type='hidden' name='table_number' value='<?php echo($TableNumber); ?>'>
            </form>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"
        type="text/javascript"></script>
    <script>
// Card validation script which gets the value from each form and ensures the forms are not empty
function cardValidation () {
    var valid = true;
    var name = $('#name').val();
    var email = $('#email').val();
    var cardNumber = $('#card-number').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var cvc = $('#cvc').val();

    $("#error-message").html("").hide();

    if (name.trim() == "") {
        valid = false;
    }
    if (email.trim() == "") {
        valid = false;
    }
    if (cardNumber.trim() == "") {
        valid = false;
    }

    if (month.trim() == "") {
        valid = false;
    }
    if (year.trim() == "") {
        valid = false;
    }
    if (cvc.trim() == "") {
        valid = false;
    }

    // If any of the above values are empty, display the error message div with the text "All Fields are required"
    if(valid == false) {
        $("#error-message").html("All Fields are required").show();
    }

    return valid;
}
// Sets our publishable key
Stripe.setPublishableKey("<?php echo STRIPE_PUBLISHABLE_KEY; ?>");

// Callback to handle the response from Stripe API
function stripeResponseHandler(status, response) {
    if (response.error) {
        //enable the submit button
        $("#submit-btn").show();
        $( "#loader" ).css("display", "none");
        //display the errors on the form
        $("#error-message").html(response.error.message).show();
    } else {
        //get token id
        var token = response['id'];
        //insert the token into the form
        $("#frmStripePayment").append("<input type='hidden' name='token' value='" + token + "' />");
        //submit form to the server
        $("#frmStripePayment").submit();
    }
}
function stripePay(e) {
    e.preventDefault();
    var valid = cardValidation();

    if(valid == true) {
        $("#submit-btn").hide();
        $( "#loader" ).css("display", "inline-block");
        Stripe.createToken({
            number: $('#card-number').val(),
            cvc: $('#cvc').val(),
            exp_month: $('#month').val(),
            exp_year: $('#year').val()
        }, stripeResponseHandler);

        // Submit from Callback
        return false;
    }
}
</script>

<?php
require_once "../../../footer.php";
?>