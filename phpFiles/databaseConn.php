<?php
    $myServer = "SQ21DDB\SQ21DDB";
    $myUser = "matrix_rw";
    $myPass = "ssms2014Matrix";
    $myDB = "Metrics";

     // Connection to the database
    $conn = odbc_connect("DSNmetrics", $myUser, $myPass);
