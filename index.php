<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if (!empty($_SESSION['SES_USER']) && !empty($_SESSION['level']) == 'Admin') {
    //echo "sesion anda " .$_SESSION['SES_USER']; 
    //echo "<br>level anda " .$_SESSION['level'];
    //echo "<a href='../logout.php'>Logout</a>";
    include_once "home.php";
} elseif (!empty($_SESSION['SES_USER']) && !empty($_SESSION['level']) == 'Apotek') {
    //echo "sesion anda " .$_SESSION['SES_USER']; 
    //echo " <br>level anda " .$_SESSION['level'];
    //echo "<a href='../logout.php'>Logout</a>";
    include_once "home.php";
} else {
    header("location: login.php");
}
    /*echo "sesion anda" .$_SESSION['SES_USER'];
        echo "level anda" .$_SESSION['level'];
*/
