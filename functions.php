<?php
if(isset($_POST['id'])){
    getProdcuts($_POST['id']);
}

if(isset($_POST['id_code'])){
    getCause($_POST['id_code']);
}

if(isset($_POST['id_area'])){
    getWc($_POST['id_area']);
}

if(isset($_POST['option'])){
    callProcedure($_POST['option']);
}
                
function getProdcuts($id){
    include 'phpFiles/databaseConn.php';
    
     $_queryProducts ="EXEC [sp_products_by_brand] $id";

    $resultProducts= odbc_exec($conn, $_queryProducts);
    $_dataProduct = array(); 
    while ($row=odbc_fetch_array($resultProducts)) {
        $_dataProduct[] = $row;
     }
     
     print_r($row);
    echo '<option value=0>All</option>';
    foreach ($_dataProduct as $row) {
        echo '<option value='.$row['id'].'>'.$row['product'].'</option>';
    }


    odbc_free_result($resultProducts);
}

function getCause($id_code){
    include 'phpFiles/databaseConn.php';
    
     $_queryCause ="EXEC [sp_cause_by_code] $id_code";

    $resultCause = odbc_exec($conn, $_queryCause);
    $_dataCause = array(); 
    while ($row=odbc_fetch_array($resultCause)) {
        $_dataCause[] = $row;
     }
    echo '<option value=0>All</option>';
    foreach ($_dataCause as $row) {
        echo '<option value='.$row['id'].'>'.$row['new_cause_desc'].'</option>';
    }

    echo $_queryCause;
    odbc_free_result($resultCause);
}

function getWc($id_area){
    include 'phpFiles/databaseConn.php';
    
     $_queryWc ="EXEC [sp_wc_by_area] $id_area";

    $resultWc = odbc_exec($conn, $_queryWc);
    $_dataWc = array(); 
    while ($row=odbc_fetch_array($resultWc)) {
        $_dataWc[] = $row;
     }

    echo '<option value=0>All</option>';
    foreach ($_dataWc as $row) {
        echo '<option value='.$row['id'].'>'.$row['wc'].'</option>';
    }

    odbc_free_result($resultWc);
}

function callProcedure($_opt){
     include 'phpFiles/databaseConn.php';
    
     $_query ="EXEC [sp_dashboard_year] '$_opt' ";

    $result = odbc_exec($conn, $_query);
    $_data = array(); 
    while ($row=odbc_fetch_array($result)) {
        $_data[] = $row;
     }
     
    odbc_free_result($result);
}