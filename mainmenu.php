<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Main Menu</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"
        />
        <link rel="stylesheet" href="mainmenu.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    
    <body>
        <br></br>
        <br></br>
    <div id="overallBox">
        <div id="Maintitle">Heaven's Kitchen
        </div>
        <div id="CompontentTwo" class="component">
            <a href="reserve.php" style="text-decoration: none; color:white; font-size: 40px">Reserve Table</a>
        </div>
        <?php
        session_start();
        $username = $_COOKIE["username"];
        if($username == " ")
        {
            ?>
            <div id="CompontentTwo" class="component">
            <a href="login.php" style="text-decoration: none; color:white; font-size: 40px">Login</a>
            </div>
            <div id="CompontentTwo" class="component">
            <a href="registration.php" style="text-decoration: none; color:white; font-size: 40px">Sign Up</a>
            </div>
            <?php
        }
        else
        {
            ?>
            <div id="CompontentThree" class="component">
            <a href="profManagement.php" style="text-decoration: none; color: white; font-size: 40px">Profile Management</a>
            </div>
            <div id="CompontentThree" class="component">
                <a href="logout.php" style="text-decoration: none; color: white; font-size: 40px">Log Out</a>
            </div>
            <?php
        }
        ?>
        
        
    </div>
    </div>
    </body>
</html>