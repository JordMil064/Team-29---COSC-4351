<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Reserve</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <script>
function valid_credit_card(value) {
            // accept only digits, dashes or spaces
                if (/[^0-9-\s]+/.test(value)) return false;
            
            // The Luhn Algorithm. It's so pretty.
                var nCheck = 0, nDigit = 0, bEven = false;
                value = value.replace(/\D/g, "");
            
                for (var n = value.length - 1; n >= 0; n--) {
                    var cDigit = value.charAt(n),
                        nDigit = parseInt(cDigit, 10);
            
                    if (bEven) {
                        if ((nDigit *= 2) > 9) nDigit -= 9;
                    }
            
                    nCheck += nDigit;
                    bEven = !bEven;
                }
            
                return (nCheck % 10) == 0;
            }
            </script>
<?php
    require('db.php');
    session_start();
    
    $username = $_COOKIE["username"];
    $query = "DELETE FROM `temp`";
    $result = mysqli_query($con, $query);
    // When form submitted, find table combo.
    if (isset($_REQUEST['partysize'])) 
    {
        $date = stripslashes($_REQUEST['date']);
        $date = mysqli_real_escape_string($con, $date);
        $time = stripslashes($_REQUEST['time']);
        $time = mysqli_real_escape_string($con, $time);
        $cNumber = stripslashes($_REQUEST['cardNumber']);

        
        if($cNumber != "5425233430109903")
        {
            echo "<div class='form'>
                    <h2>Your Reservation Could Not Be Made!</h2><br/>
                    <h3> Not A Valid Credit Card.</h3><br/>
                    <p class='link'>Click here to go back to the <a href='reserve.php'>Reserve</a> page to try again.</p>
                    </div>";
        }
        else
        {
            
        setcookie("date", $date);
        setcookie("time", $time);

        $query = "SELECT `size8`, `size6`, `size4`, `size2` FROM `reservation` WHERE `date` = '$date' AND `time` = '$time'";
        $result = mysqli_query($con, $query);
        $existingrow = mysqli_num_rows($result);
        if($existingrow == 0)
        {
            $query = "INSERT INTO `reservation` VALUES ('$date', '$time', 5, 5, 5, 5)";
            $result = mysqli_query($con, $query);
        }
        $query = "SELECT `size8`, `size6`, `size4`, `size2` FROM `reservation` WHERE `date` = '$date' AND `time` = '$time'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $available[8] = $row['size8'];
        $available[6] = $row['size6'];
        $available[4] = $row['size4'];
        $available[2] = $row['size2'];

        $total = 0;
        $threshold = 10;
        for($i = 8; $i > 0; $i -= 2)
        {
            $total = $total + $available[$i];
        }

        $partysize = stripslashes($_REQUEST['partysize']);
        setcookie("partysize", $partysize);
        $name = stripslashes($_REQUEST['name']);
        setcookie("name", $name);

        $partysize = stripslashes($_REQUEST['partysize']);
        $partysize = mysqli_real_escape_string($con, $partysize);
        $_SESSION['partysize'] = $partysize;

        //round up one if odd
        if($partysize % 2 == 1)
        {
            $partysize++;
        }

        if($partysize % 8 == 0 || $partysize % 6 == 0 || $partysize % 4 == 0 || $partysize % 2 == 0)
        {
            /*
            $i = 0;
            for($j = 8; $j > 0; $j -= 2)
            {
                if($partysize % $j == 0)
                {
                    $i = $j;
                }
            }
            $query = "SELECT * from `reservation` WHERE `date` = '$date' AND `time` = '$time' AND size$i > 0";
            $findsamesize = mysqli_query($con, $query);
            $result = mysqli_num_rows($findsamesize);
            //find table is same as party size
            if ($result >= 1 && $available[$i] > 0) 
            {
                $query = "UPDATE `reservation` SET size$i = size$i - 1 WHERE `date` = '$date' AND `time` = '$time'"; //make sure to put available = available - 1 back later
                $updatetable = mysqli_query($con, $query);
                if($updatetable)
                {
                    ?>
                            <div class='form'>
                            <h1>Your Reservation Is Confirmed!</h1><br/>
                            <h3> Name: <?php echo $name ?></h3><br/>
                            <h3> Time: <?php echo $time ?>:00</h3><br/>
                            <?php
                                if($total < $threshold)
                                {
                                    echo "<p class='link'>*HOLDING FEE APPLIED*</p>";
                                }
                            ?>
                            <p class='link'>NO SHOWS WILL BE CHARGED A MINIMUM $10 FEE!</p>
                            <p class='link'>Click here to go back to the <a href='mainmenu.php'>HomePage</a>.</p>
                            </div>
                    <?php
                }
            }*/
            //else if($result == 0)
            {
                for($j = 0; $j <= 6; $j += 2)
                {
                    for($i = 8; $i > 0; $i -= 2)
                    {
                        $temp2[$i] = 0;
                    }
                    $currentsize = $partysize;
                    $futuresize = $currentsize;
                    for($i = 8 - $j; $i > 0; $i -= 2)
                    {
                        $futuresize = $currentsize - $i;
                        while($futuresize >= 0 && $temp2[$i] < 5 && ($available[$i] - $temp2[$i]) > 0)
                        {
                            $temp2[$i] = $temp2[$i] + 1;
                            $currentsize = $currentsize - $i;
                            $futuresize = $currentsize - $i;
                        }
                        if($futuresize >= 0 && $temp2[$i] >= 5 && $i == 2)
                        {
                            $i = -1;
                            for($k = 8; $k > 0; $k -= 2)
                            {
                                $temp2[$k] = 0;
                            }
                        }
                    }

                    $query = "INSERT INTO `temp`(size8, size6, size4, size2) VALUES ($temp2[8], $temp2[6], $temp2[4], $temp2[2])";
                    $result = mysqli_query($con, $query);
                    if($result)
                    {
                        header("Location: combinedTables.php");
                    }
                }
            }
        }
        }
    } 
    else 
    {
        /*<select style = "width:85px;" name = "select1" id ="select1">
        <?php
            for($hours = 0;$hours < 24; $hours++)
            {
                echo '<option>'.str_pad($hours, 2, '0', STR_PAD_LEFT)."</option>";
            }
        ?>
        </select>*/
    $name = " ";
    // form for getting party size    
    if($username != " ")
    {
        $query = "SELECT `name` FROM `cardinfo` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        $isthere = mysqli_num_rows($result);
        if($isthere == 1)
        {
            $cardName = $row[0];
        }
        
        $query = "SELECT `number` FROM `cardinfo` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        if($isthere == 1)
        {
            $cardNumber = $row[0];
        }
        $query = "SELECT `expdate` FROM `cardinfo` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        if($isthere == 1)
        {
            $cardDate = $row[0];
        }
        $query = "SELECT `cvv` FROM `cardinfo` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        if($isthere == 1)
        {
            $cardCvv = $row[0];
        }
        $query = "SELECT `fname` FROM `users` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        $fname = $row[0];
        if($isthere == 1)
        {
            $fname = $row[0];
        }
        $query = "SELECT `lname` FROM `users` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        if($isthere == 1)
        {
            $lname = $row[0];
        }
        $lname = $row[0];
        $name = $fname . "" . $lname;
    }
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Make A Reservation!</h1>
        <h2 class = "login-title">Reservation Information</h2>
        <label>Name:</label><br>
        <input type="text" class="login-input" name="name" value = <?php if($username != " "){ echo $name;} ?>>
        <label>Date:</label><br>
        <input type="date" class="login-input" name="date" min = "2022-12-01">
        <label for="time">Time of Reservation: </label>
        <select style = "width:100px" name="time" id="time">
            <option value="9">09:00AM</option>
            <option value="10">10:00AM</option>
            <option value="11">11:00AM</option>
            <option value="12">12:00PM</option>
            <option value="1">1:00PM</option>
            <option value="2">2:00PM</option>
            <option value="3">3:00PM</option>
            <option value="4">4:00PM</option>
            <option value="5">5:00PM</option>
        </select>
        <br></br>
        <label>Party Size:</label><br>
        <input type="text" class="login-input" name="partysize">
        <br>
        <br>

        <h2 class = "login-title">Payment Information</h2>
        <label>Name On Card:</label><br>
        <input type="text" class="login-input" name="cardName" value = <?php if($username != " "){ echo $cardName;}?>>
        <label>Card Number:</label><br>
        <input type="number" class="login-input" name="cardNumber" placeholder = "1234 1234 1234 1234">
        <label>Expiration Date:</label><br>
        <input type="text" class="login-input" name="cardExp" min = "2022-12-01" value = <?php if($username != " "){ echo $cardDate;}?>>
        <label>CVV:</label><br>
        <input type="number" class="login-input" name="cardCvv" min = 1 max = 999 value = <?php if($username != " "){ echo $cardCvv;}?>>
        <p>
          <label for="">Mailing Address:</label><br>
          <input class="login-input" id="address1" type="text" maxlength="100" required />
        </p>
        <p>
        <label for = "BillingAd">Billing Address:</label><br>
        <textarea id="BillingAd"></textarea><br/>
            </p>
            <script>
            function myFunction() {
                var checkBox = document.getElementById("myCheck");
                var textShip = document.getElementById("address1");
                var textBil = document.getElementById("BillingAd");
                if (checkBox.checked == true){
                    textBil.value=textShip.value;
                } else {
                    textBil.value="";
                }
            }
            </script>
            
        <input type="checkbox" id="myCheck" onclick="myFunction()">
        <label for="myCheck">Same as Shipping Address:</label><br>
        <label>City:</label><br>
        <input type="text" class="login-input" name="cardCity">
        <label>State:</label><br>
        <input type="text" class="login-input" name="cardState" maxlength = "2">
        <label>Zipcode:</label><br>
        <input type="number" class="login-input" name="cardZipcode" min = 1 max = 99999>

        <?php
            if($username == " ")
            { 
                ?>
                <p class="link">Register an Account to Earn Points on this Reservation!!</p>
                <?php
            }
        ?>
        <br>
        <p class="link">A Holding Fee will be added to high traffic days!</p>
        <input type="submit" name="submit" value="Reserve" class="login-button">
        <p class="link">Go Back to <a href="mainmenu.php">Main Menu</a></p>
    </form>
<?php
    }
?>
</body>
</html>
