<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Available Tables</title>
    <style>
        body {
            position: fixed;
            left: 40%;
            text-align: center;
        }
        </style>
</head>
<body>
<?php
    require('db.php');
    session_start();
    $query = "SELECT * FROM `table`  ";
    $result = mysqli_query($con, $query);
    echo "<table border=5>"; // start a table tag in the HTML
    echo "<tr><td>" . "Table Size" . "</td><td>" . "Available Tables" . "</td></tr>"; 
    while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
        //$str = $row['DeliveryMonth'] . "-" . $row['DeliveryDay'] . "-" . $row['DeliveryYear'];
    echo "<tr><td>" . htmlspecialchars($row['size']) . "</td><td>" . htmlspecialchars($row['available']) ;  //$row['index'] the index here is a field name
    }

    echo "</table>"; //Close the table in HTML
    if(isset($_POST['submit']))
    {
        for($i = 8; $i > 0; $i -= 2)
        {
            $query = "UPDATE `table` SET available = 5 WHERE size = $i";
            $updatetable = mysqli_query($con, $query);
        }
        header("Refresh:0");
    }
    else if(isset($_POST['home']))
    {
        header("Location: mainmenu.php");
    }
    else{
?>
            
        <form action = "" method = "post">
            <input type = "submit"  name = "submit" value = "Reset Table">
            <input type = "submit" name = "home" value = "Back To Dashboard">
        </form>

    <?php
    }
    ?>
</body>
</html>
