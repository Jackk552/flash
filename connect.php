<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_flashpoint";
   


    /*$conn = mysqli_connect($host,
                            $user,
                            $pass,
                            $db) or die("Could not connect.");*/

    $mysqli = new mysqli($host, $user, $pass, $db) or die("Could not connect.");;