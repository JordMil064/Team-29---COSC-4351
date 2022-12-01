<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Update Profile</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
<body>
    <?php
        require('db.php');
        session_start();
        $username = $_COOKIE["username"];
        // When form submitted, check and create user session.
        if (isset($_POST['username'])) {
            $username = stripslashes($_REQUEST['username']);    // removes backslashes
            $username = mysqli_real_escape_string($con, $username);
            $fname = stripslashes($_REQUEST['fname']);    // removes backslashes
            $fname = mysqli_real_escape_string($con, $fname);
            $lname = stripslashes($_REQUEST['lname']);    // removes backslashes
            $lname = mysqli_real_escape_string($con, $lname);
            $addy = stripslashes($_REQUEST['addy']);    // removes backslashes
            $addy = mysqli_real_escape_string($con, $addy);
            $city = stripslashes($_REQUEST['city']);    // removes backslashes
            $city = mysqli_real_escape_string($con, $city);
            $state = stripslashes($_REQUEST['state']);    // removes backslashes
            $state = mysqli_real_escape_string($con, $state);
            $zipcode = stripslashes($_REQUEST['zipcode']);    // removes backslashes
            $zipcode = mysqli_real_escape_string($con, $zipcode);

            $cardName = stripslashes($_REQUEST['cardName']);    // removes backslashes
            $cardName = mysqli_real_escape_string($con, $cardName);
            $cardNumber = stripslashes($_REQUEST['cardNumber']);    // removes backslashes
            $cardNumber = mysqli_real_escape_string($con, $cardNumber);
            $cardDate = stripslashes($_REQUEST['cardDate']);    // removes backslashes
            $cardDate = mysqli_real_escape_string($con, $cardDate);
            $cardCvv = stripslashes($_REQUEST['cardCvv']);    // removes backslashes
            $cardCvv = mysqli_real_escape_string($con, $cardCvv);

            $query = "UPDATE `users` SET `username` = '$username' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `users` SET `fname` = '$fname' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `users` SET `lname` = '$lname' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `users` SET `address` = '$addy' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `users` SET `city` = '$city' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `users` SET `state` = '$state' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `users` SET `zipcode` = '$zipcode' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);

            $query = "UPDATE `cardinfo` SET `name` = '$cardName' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `cardinfo` SET `number` = '$cardNumber' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `cardinfo` SET `expdate` = '$cardDate' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $query = "UPDATE `cardinfo` SET `cvv` = '$cardCvv' WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo "<div class='form'>
                    <h3>Saved.</h3><br/>
                    <p class='link'>Click here to go back to the <a href='mainmenu.php'>HomePage</a>.</p>
                    </div>";
            } else {
                echo "<div class='form'>
                    <h3>Incorrect Username/password.</h3><br/>
                    <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                    </div>";
            }
        }
        else {
            $query = "SELECT `fname` FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $fname = $row[0];

            $query = "SELECT `lname` FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $lname = $row[0];

            $query = "SELECT `address` FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $addy = $row[0];

            $query = "SELECT `city` FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $city = $row[0];

            $query = "SELECT `state` FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $state = $row[0];

            $query = "SELECT `zipcode` FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $zipcode = $row[0];

            $query = "SELECT `name` FROM `cardinfo` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $cardName = $row[0];
            
            $query = "SELECT `number` FROM `cardinfo` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $cardNumber = $row[0];

            $query = "SELECT `expdate` FROM `cardinfo` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $cardDate = $row[0];

            $query = "SELECT `cvv` FROM `cardinfo` WHERE `username` = '$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);
            $cardCvv = $row[0];
    ?>
        <<form class="form" action="" method="post">
            <h1 class="login-title">Update Profile</h1>

            <h2 class = "login-title">Account Information</h2>
            <label>Preffered Diner:</label><br>
            <input type="text" class="login-input" name="prefDiner" value = "123" readonly>
            <label>Points:</label><br>
            <input type="text" class="login-input" name="points" value = 69 readonly>
            <br><br>

            <h2 class = "login-title">Personal Information</h2>
            <label>Username:</label><br>
            <input type="text" class="login-input" name="username" placeholder ="Username" value = <?php echo $username; ?>>
            <label>First Name:</label><br>
            <input type="text" class="login-input" name="fname" placeholder="First Name" value = <?php echo $fname; ?>>
            <label>Last Name:</label><br>
            <input type="text" class="login-input" name="lname" placeholder="Last Name" value = <?php echo $lname; ?>>
            <label>Address:</label><br>
            <input type="text" class="login-input" name="addy" id = "addy" placeholder="Address" value = <?php echo $addy; ?>>
            <label>City:</label><br>
            <input type="text" class="login-input" name="city" placeholder="City" value = <?php echo $city; ?>>
            <label>State:</label><br>
            <input type="text" class="login-input" name="state" placeholder="State" maxlength="2" value = <?php echo $state; ?>>
            <label>Zipcode:</label><br>
            <input type="number" class="login-input" name="zipcode" placeholder="Zipcode" min = 1 max = 99999 value = <?php echo $zipcode; ?>>
            <br><br>
            <h2 class = "login-title">Billing Information</h2>
            <label>Name on Card:</label><br>
            <input type="text" class="login-input" name="cardName" placeholder="John Doe" value = <?php echo $cardName; ?>>
            <label>Card Number:</label><br>
            <input type="number" class="login-input" name="cardNumber" placeholder="1234 1234 1324 1234">
            <label>Expiration Date:</label><br>
            <input type="text" class="login-input" name="cardDate" placeholder = "01/23" value = <?php echo $cardDate; ?>>
            <label>CVV:</label><br>
            <input type="number" class="login-input" name="cardCvv" placeholder="123" max = 999 value = <?php echo $cardCvv; ?>>
            <label for = "BillingAd">Billing Address:</label><br>
            <textarea id="BillingAd"></textarea>
                </p>
                <script>
                function myFunction() {
                    var checkBox = document.getElementById("myCheck");
                    var textShip = document.getElementById("addy");
                    var textBil = document.getElementById("BillingAd");
                    if (checkBox.checked == true){
                        textBil.value=textShip.value;
                    } else {
                        textBil.value="";
                    }
                }
            </script> 
	        <label for="myCheck">Same as Shipping Address:</label>
            <input type="checkbox" id="myCheck" onclick="myFunction()">
            <input type="submit" name="submit" value="Update" class="login-button">\
            <p class="link">Go Back to <a href="mainmenu.php">Main Menu</a></p>
        </form>
            
        <?php
            }
        ?>
</body>
</html>