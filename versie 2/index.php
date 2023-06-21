<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO Login and Registration</title>
</head>

<body>
<h1>PDO Login and Registration</h1>
<hr>
<br>
<?php
include_once("./dbconnect.php");

// Functions
function GetDatabase($srvname, $uname, $pword, $dbname)
{
    // Try Connecting to the database
    try {
        $db = new PDO("mysql:host=$srvname;dbname=$dbname", $uname, $pword);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } 
    catch(PDOException $e) {
        // Throw the error
        echo "{$e}";
        exit;
    }
}

// Ready some things
$db = GetDatabase("localhost", "root", "", "inlog");

$user = new User();

if (!isset($_SESSION)) {
    session_start();
}


// Show the pages based on the state of the page
if (!isset($_SESSION["user"])) {
    // Not Logged in
    if (!isset($_POST["state"])) {
        // Home Page
        $str = "<h2>Welcome op de HOME-pagina!</h2><br>";
        $str .= "<p>U bent niet ingelogd. Login om verder te gaan.</p><br>";
        $str .= "<form method=post><input class=fakelink type=submit name=state value=Login></form>";
        echo $str;
    }
    else {
        // Login or Registration page
        if (($_POST["state"]) == "Login" && !isset($_POST["username"])) {
            // Show Login page
            $str = "<h2>Login here...</h2><br>";
            $str .= "<form method=post>";
            $str .= "<label for=Username>Username</label>";
            $str .= "<input type=text id=Username name=Username required><br>";
            $str .= "<label for=Username>Password</label>";
            $str .= "<input type=text id=Username name=Password required><br>";   
            $str .= "<input type=submit name=state value=Login></form>";
            
            $str .= "<form method=post><input type=submit name=state value=Register></form>";
            echo $str;
        }
        else if (($_POST["state"]) == "Login") {
            // Submitting the Login
            if ($user->LogIn($db, $_POST["username"], $_POST["password"])) {
                header("location: ./");
            }
            else {
                echo("<p>Failed to log in!</p> <br> <form method=post><input type=submit name=state value=Login></form>");
            }
        }

        if (($_POST["state"]) == "Register" && !isset($_POST["username"])) {
            // Show Registration page
            $str = "<h2>Register here...</h2><br>";
            $str .= "<form method=post>";
            $str .= "<label for=Username>Username</label>";
            $str .= "<input type=text id=Username name=Username required><br>";
            $str .= "<label for=Username>Password</label>";
            $str .= "<input type=text id=Username name=Password required><br>";   
            $str .= "<input type=submit name=state value=Register></form>";
            
            echo $str;
        }
        else if (($_POST["state"]) == "Register") {
            // Submitting the Registration
            if ($user->Register($db, $_POST["username"], $_POST["password"])) {
                header("location: ./");
            }
            else {
                echo("<p>Failed to Register!</p> <br> <form method=post><input class=fakelink type=submit name=state value=Register></form>");
            }
        }
    }
}
else {
    // Logged in
    if (isset($_POST["state"])) {
        $user->LogOut();
        header("location: ./");
    }
    $str = "<h2>Welcome op de HOME-pagina!</h2><br><br>";
    $str .= "<h1>Het spel kan beginnen</h1><br>";
    $str .= "<p>Je bent ingelogd met:<br>";
    $str .= "Inlognaam: {$_SESSION["user"]->username}<br>";
    $str .= "Password: {$_SESSION["user"]->password}<br><br>";
    $str .= "<form method=post><input type=submit name=state value=Logout></form>";
    echo $str;
}
?>
</body>
</html>