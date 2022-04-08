<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'deelstar');
    define('DB_USER','root');
    define('DB_PASS' ,'');

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

    
    //$conn = mysqli_connect('localhost', 'root', '', 'deelstar');
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    function prettyprint($arr){ //prettyprint 
        echo '<pre>';           // Kan Verwijderd worden
            print_r($arr);
        echo '</pre>';
    }
?>