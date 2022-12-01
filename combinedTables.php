<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Combined Tables</title>
    <style>
        body {
            position: fixed;
            left: 35%;
            text-align: center;
        }
        </style>
</head>
<body>
<?php
    require('db.php');
    session_start();
    $date = $_COOKIE["date"];
    $time = $_COOKIE["time"];


    $query = "SELECT * FROM `reservation` WHERE `date` = '$date' AND `time` = '$time'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $available[8] = $row['size8'];
    $available[6] = $row['size6'];
    $available[4] = $row['size4'];
    $available[2] = $row['size2'];

    $query = "SELECT * from `temp`";
    $result = mysqli_query($con, $query);
    for($i = 8; $i > 0; $i -= 2)
    {
        $size[$i] = 0;
    }
    while($row = mysqli_fetch_array($result))
    {
        $size[8] = $row['size8'];
        $size[6] = $row['size6'];
        $size[4] = $row['size4'];
        $size[2] = $row['size2'];

        for($i = 8; $i > 0; $i -= 2)
        {
            if($available[$i] - $size[$i] < 0)
            {
                $i = -1;
            }
            else
            {
                break 2;
            }
        }
    }
    $total = 0;
    $threshold = 10;
    for($i = 8; $i > 0; $i -= 2)
    {
        $total = $total + $available[$i];
    }
    if(isset($_POST['submit']))
    {
        $query = "SELECT * FROM `reservation` WHERE `date` = '$date' AND `time` = '$time'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $available[8] = $row['size8'];
        $available[6] = $row['size6'];
        $available[4] = $row['size4'];
        $available[2] = $row['size2'];

        $query = "SELECT * from `temp`";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_array($result))
        {
            $size[8] = $row['size8'];
            $size[6] = $row['size6'];
            $size[4] = $row['size4'];
            $size[2] = $row['size2'];

            for($i = 8; $i > 0; $i -= 2)
            {
                if($available[$i] - $size[$i] < 0)
                {
                    $i = -1;
                }
                else
                {
                    break 2;
                }
            }
        }
        $isfine = true;
        for($i = 8; $i > 0; $i -= 2)
        {
            $query = "UPDATE `reservation` SET size$i = size$i - $size[$i] WHERE `date` = '$date' AND `time` = '$time'";
            $updatetable = mysqli_query($con, $query);
        }
        $username = $_COOKIE["username"];
        $name = $_COOKIE["name"];
        if($username != " ")
        {
            $query = "SELECT * FROM `users` WHERE username = '$username'";
            $result = mysqli_query($con, $query);
            $userinfo = mysqli_fetch_array($result);
            $name = $userinfo['fname'] . " " . $userinfo['lname'];
        }
        $suntime = " ";
        if($time == 9 || $time == 10 || $time == 11)
        {
            $suntime = "am";
        }
        else{
            $suntime = "pm";
        }
        ?>
        <div class='form'>
                            <h1>Your Reservation Is Confirmed!</h1><br/>
                            <h3> Name: <?php echo $name ?></h3><br/>
                            <h3> Time: <?php echo $time ?>:00<?php echo $suntime?></h3><br/>
                            <?php
                                if($total < $threshold)
                                {
                                    echo "<p class='link'>*HOLDING FEE APPLIED*</p><br>";
                                }
                            ?>
                            <p class='link'>NO SHOWS WILL BE CHARGED A MINIMUM $10 FEE!</p>
                            <p class='link'>Click here to go back to the <a href='mainmenu.php'>HomePage</a>.</p>
                            </div>
        <?php
    }
    else
    {
        if($size[8] == 0 && $size[6] == 0 && $size[4] == 0 && $size[2] == 0)
        {
            echo "<div class='form'>
                    <h2>Your Reservation Could Not Be Made!</h2><br/>
                    <h3> There are no available tables.</h3><br/>
                    <p class='link'>Click here to go back to the <a href='mainmenu.php'>HomePage</a>.</p>
                    </div>";
        }
        else
        {
            echo "<table border=5>"; // start a table tag in the HTML
            echo "<tr><td>" . "Available Combinations" . "</td><td>" . "Size 8" . "</td><td>" . "Size 6" . "</td><td>" . "Size 4". "</td><td>" . "Size 2" ."</td></tr>"; 
            echo "<tr><td>" . "" . "</td><td>" . $size[8] . "</td><td>" . $size[6] . "</td><td>" . $size[4] . "</td><td>" . $size[2];  //$row['index'] the index here is a field name
            echo "</table>"; //Close the table in HTML 
            ?>
            <form action = "" method = "post">
                <input type = "submit"  name = "submit" value = "Reserve!">
            </form>
            

        <?php
        }
    }
    ?>
</body>
</html>