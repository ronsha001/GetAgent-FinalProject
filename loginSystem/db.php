<?php 
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DB", "getagent");
    
    $con = mysqli_connect(HOST, USER, PASSWORD, DB);
    mysqli_set_charset($con, "utf8");
?>