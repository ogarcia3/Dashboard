<?php
//$user = 'userwapp515'; 
//$pass = 'userwapp5151';
//$connection_string = 'DRIVER={SQL Server};SERVER=SQ21DDB\SQ21DDB;DATABASE=Metrics'; 
//
//$connection = odbc_connect("DSNwapp515", $user, $pass); 
//
//var_dump($connection);
//
//if($connection){
//    echo 'Success';
//}else {
//    echo 'error';
//}

$link = mssql_connect('TIJAPIAP05\AMEXSQL','wapp515', 'userwapp515', 'userwapp5151');

if (!$link) {
    die('Something went wrong while connecting to MSSQL');
}