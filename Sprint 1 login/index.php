<!DOCTYPER html>

<html lang="en">

<body>

    <h3>PDO Login And Registration</h3>
    <hr/>

    <h3>Welcome op de HOME-pagina</h3>

    <?php

    session_start();

    if(!isset($_SESSION['user'])){

        echo "Niet ingelogd<br>";

        echo '<a href="login_form.php">Login</a>';
    } else{

    }
    

?>
    <!-- <p>U bent niet ingelogd</p>
    <a href="">Login</a> -->

</body>
</html>
