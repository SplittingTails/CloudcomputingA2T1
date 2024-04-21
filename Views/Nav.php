<?php
/***** HEADER OF WEBSITE ******/
function nav_module($pageTitle)
{

    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    //change page title based on active page
    ($pageTitle == "HomePage") ? $Home = "class=\"active\"" : $Home = "";
    ($pageTitle == "Register") ? $Register = "class=\"active\"" : $Register = "";
    ($pageTitle == "Mainpage") ? $Mainpage = "class=\"active\"" : $Mainpage = "";


    echo '<nav>' . PHP_EOL;
    echo '<ul>' . PHP_EOL;
    if (!isset ($_SESSION['user'])) {
        echo '<li ' . $Home . '><a href="/">Home</a></li>' . PHP_EOL;
        echo '<li ' . $Register . '><a href="/register">Register</a></li>' . PHP_EOL;
    }
    ;
    if (isset ($_SESSION['user'])) {
        echo '<li ' . $Mainpage . '><a href="/Mainpage"> Main Page</a></li>' . PHP_EOL;
        echo '<li><a href="Logout">Logout</a></li>' . PHP_EOL;
    }
    echo '</ul>' . PHP_EOL;
    echo '</nav>' . PHP_EOL;

}
?>