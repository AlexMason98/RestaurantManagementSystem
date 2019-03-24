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

                            
    $sql = "SELECT * FROM TempOrders WHERE IP = '$ip'";
    $res = $conn->query($sql);
    if(!is_null($res)) {
        $i = 1;
        while($row = mysqli_fetch_assoc($res)){
            echo("Row is: ".$i++);
            $ID = $row['ID'];
            $Item = $row['Item'];
            $Quantity = $row['Quantity'];
            $Price = $row['Price'];
            $TotalAmount = $Quantity * $Price;
            echo("ID: ".$ID);
            echo("Item: ".$Item);
            echo("Price: ".$Price);
            echo("Total: ".$TotalAmount);
        }
    } else {
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
    $param_value_array = array(
        $stripeResponse["balance_transaction"],
        $_POST['name'],
        $_POST['email'],
        $amount,
        $stripeResponse["currency"],
        $stripeResponse["status"],
        json_encode($stripeResponse)
    );
    $query = "INSERT INTO Payment (TransactionID, Name, Email, TotalAmount, Currency, PaymentStatus, PaymentResponse) values (?, ?, ?, ?, ?, ?, ?)";
    $id = $databaseConn->insert($query, $param_type, $param_value_array);
    
    if ($stripeResponse['amount_refunded'] == 0 && empty($stripeResponse['failure_code']) && $stripeResponse['paid'] == 1 && $stripeResponse['captured'] == 1 && $stripeResponse['status'] == 'succeeded') {
        $successMessage = "Payment Successful! The Transaction ID is " . $stripeResponse["balance_transaction"];
    }
}
?>

    <?php if(!empty($successMessage)) { ?>
    <div id="success-message"><?php echo $successMessage; ?></div>
    <?php  } ?>
    <div id="error-message"></div>
                
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

                    <div id="loader">
                        <img alt="loader" src="LoaderIcon.gif">
                    </div>
                </div>
                <input type='hidden' name='amount' value='<?php echo($TotalAmount); ?>'> 
                <input type='hidden' name='currency_code' value='GBP'>
                <input type='hidden' name='item_name' value='<?php echo($Item); ?>'>
                <input type='hidden' name='item_number' value='<?php echo($ID); ?>'>
            </form>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"
        type="text/javascript"></script>
    <script>
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

    if(valid == false) {
        $("#error-message").html("All Fields are required").show();
    }

    return valid;
}
//set your publishable key
Stripe.setPublishableKey("<?php echo STRIPE_PUBLISHABLE_KEY; ?>");

//callback to handle the response from stripe
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

        //submit from callback
        return false;
    }
}
</script>

<?php
require_once "../../../footer.php";
?>