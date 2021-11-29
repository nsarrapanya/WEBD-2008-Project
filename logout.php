<?php
    session_start();
    require('connect.php');

    echo "Logout Successfully ";
    session_unset();
    session_destroy();   // function that Destroys Session
    header("Location: index.php");
?>
