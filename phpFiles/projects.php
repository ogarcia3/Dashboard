<?php
$user = 'matrix_rw'; 
$pass = 'ssms2014Matrix';
$connection_string = 'DRIVER={SQL Native Client 10.0};SERVER=SQ21DDB\SQ21DDB;DATABASE=Metrics'; 

$connection = odbc_connect("DSNmetrics", $user, $pass); 

var_dump($connection);

if($connection){
    echo 'Success';
}else {
    echo 'error';
}


