<?php

require_once 'databaseConn.php';

include 'variables.php';

if(isset($_POST['dateradio'])){
    $opt = ($_POST['dateradio']);
}

if(isset($_POST['year1'])){
    $year1 = ($_POST['year1']);
}

if(isset($_POST['year2'])){
    $year2 = ($_POST['year2']);
}
                
if(isset($_POST['brand'])){
    $brand = ($_POST['brand']);
}

if(isset($_POST['product'])){
    $product = ($_POST['product']);
}

if(isset($_POST['code'])){
    $code = ($_POST['code']);
}

if(isset($_POST['area'])){
    $area = ($_POST['area']);
}

if(isset($_POST['wc'])){
    $wc = ($_POST['wc']);
}

if(isset($_POST['shift'])){
    $shift = ($_POST['shift']);
}

if(isset($_POST['rdc'])){
    $rdc = ($_POST['rdc']);
}

if(isset($_POST['order'])){
    $order = ($_POST['order']);
}

$query = "EXEC [sp_dashboard_year] '$opt','$year1','$year2','$brand' ,'$product' ,'$code' ,'$cause' ,'$area' ,'$wc' ,'$shift' ,'$rdc','$order';";

$result = odbc_exec($conn, $query);

$period = array();
$dppm = array();
$goal = array();

while ($row = odbc_fetch_array($result)){
    $period[]=$row['PERIOD'];
    $dppm[]=$row['DPPM'];
    $goal[] = $row['GOAL'];
}

if($code == 0){
    $queryPareto = "EXEC [sp_dashboard_year_pareto] '$opt','$year1','$year2','$brand' ,'$product' ,'$code' ,'$cause' ,'$area' ,'$wc' ,'$shift' ,'$rdc','$order';";
}else{
    $queryPareto = "EXEC [sp_dashboard_year_pareto_func_own] '$opt','$year1','$year2','$brand' ,'$product' ,'$code','$area' ,'$wc' ,'$shift' ,'$rdc','$order';";
}


$resultPareto = odbc_exec($conn, $queryPareto);

$codePareto = array();
$dppmPareto = array();
$pareto = array();

while ($row = odbc_fetch_array($resultPareto)){
    $codePareto[]=$row['code'];
    $dppmPareto[]=$row['dppm'];
    $pareto[] = $row['pareto'];
}
odbc_free_result($resultPareto);

$queryConvert = "EXEC [sp_convert_year_to_period] '$year1','$year2';";

$resultConvert = odbc_exec($conn, $queryConvert);

while($rowConvert = odbc_fetch_array($resultConvert)){
    $period1 = $rowConvert['minPeriod'];
    $period2 = $rowConvert['maxPeriod'];
    $fy = $rowConvert['fiscal_year'];
}

$queryNames = "EXEC [sp_get_names] $area,$wc,$brand,$product,$code,$rdc,$shift";

$resultNames = odbc_exec($conn, $queryNames);

while ($rowName = odbc_fetch_array($resultNames)){
    $vsmText =$rowName['vsm'];
    $areaText= $rowName['wc'];
    $categoryText = $rowName['category'];
    $productText = $rowName['product'];
    $funcText = $rowName['func'];
    $rdcText = $rowName['rdc'];
    $shiftText = $rowName['shift'];
   }
   
   odbc_free_result($resultNames);

if($order == 0){
    $orderText =  'ALL';
}
elseif ($order ==1) {
    $orderText =  'SPECIAL';
}
elseif ($order == 2) {
    $orderText =  'MOCKUP';
}

$queryYtd = "EXEC [sp_dashboard_year_ytd] '$opt','$year1','$year2','$brand' ,'$product' ,'$code' ,'$cause' ,'$area' ,'$wc' ,'$shift' ,'$rdc','$order';";

$resultYtd = odbc_exec($conn, $queryYtd);


while ($row = odbc_fetch_array($resultYtd)){
    $defects=$row['defects'];
    $shipped=$row['shipped'];
    $ytd = $row['Value'];
}

odbc_free_result($resultYtd);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Graphs</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"/>
        <link href="../CSS/graphStyle.css" rel="stylesheet" type="text/css"/>
        <link href="../CSS/magnific-popup.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/jszip-2.5.0/dt-1.10.12/af-2.1.2/b-1.2.1/b-html5-1.2.1/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.2/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/> 
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.php">Amex QA Dashboard</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <div class="navbar-form navbar-right">
                        <a href="#" class="my-popup iframe-link btn btn-primary">Back to search</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ORDER TYPE</th>
                                    <th>VSM</th>
                                    <th>WC</th>
                                    <th>CATEGORY</th>
                                    <th>PRODUCT</th>
                                    <th>FUNCTIONAL OWNER</th>
                                    <th>RDC</th>
                                    <th>SHIFT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $orderText?></td>
                                    <td><?php echo $vsmText?></td>
                                    <td><?php echo $areaText?></td>
                                    <td><?php echo $categoryText?></td>
                                    <td><?php echo $productText?></td>
                                    <td><?php echo $funcText?></td>
                                    <td><?php echo $rdcText?></td>
                                    <td><?php echo $shiftText?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="material-icons" style="font-size:6em;">warning</i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php echo $defects; ?> </h1>
                                    <h4>Defects</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="material-icons" style="font-size:6em;">local_shipping</i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php echo $shipped; ?> </h1>
                                    <h4>Shipped</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="material-icons" style="font-size:6em;">trending_down</i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php echo $ytd; ?> </h1>
                                    <h4>DPPMS FYTD</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div id="container1"></div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div id="container2"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <h4 class="text-center">Pareto By Product</h4>
                    <table id="productPareto" class="table display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>DPPM</th>
                                <th>PARETO</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>PRODUCT</th>
                                <th>DPPM</th>
                                <th>PARETO</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $queryProducts = "EXEC [sp_dashboard_year_pareto_product] '$opt','$year1','$year2','$brand' ,'$product' ,'$code' ,'$cause' ,'$area' ,'$wc' ,'$shift' ,'$rdc','$order';";
                                
                            $resultProducts = odbc_exec($conn, $queryProducts);
                            
                            while($row = odbc_fetch_array($resultProducts)){
                                echo '<tr>';
                                echo '<td>'. $row['code'] . '</td>';
                                echo '<td>'. round($row['dppm']) . '</td>';
                                echo '<td>'. round($row['pareto'],2) . '%</td>';
                                echo '</tr>'; 

                            }
                            odbc_free_result($resultProducts);
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <h4 class="text-center">TOP ISSUES</h4>
                    <table  id="example" class="table display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NOTIFICATION</th>
                                <th>FUNCTIONAL OWNER</th>
                                <th>PRODUCT</th>
                                <th>QTY</th>
                                <th>PERIOD</th>
                                <th>CUSTOMER</th>
                                <th>SALES ORDER</th>
                                <th>SO ITEM</th>
                                <th>LONG TEXT</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>NOTIFICATION</th>
                                <th>FUNCTIONAL OWNER</th>
                                <th>PRODUCT</th>
                                <th>QTY</th>
                                <th>PERIOD</th>
                                <th>CUSTOMER</th>
                                <th>SALES ORDER</th>
                                <th>SO ITEM</th>
                                <th>LONG TEXT</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            
                            $query_noti = "EXEC [sp_noti_year] '$opt','$year1' ,'$year2','$product','$code','$brand','$order','$area','$wc','$shift','$rdc';";

                            $result_noti = odbc_exec($conn, $query_noti);

                            while ($row = odbc_fetch_array($result_noti)){
                                echo '<tr>';
                                echo '<td>'. $row['noti'] . '</td>';
                                echo '<td>'. $row['func_own'] . '</td>';
                                echo '<td>'. $row['product'] . '</td>';
                                echo '<td>'. $row['qty'] . '</td>';
                                echo '<td>'. $row['fiscal_period'] . '</td>';
                                echo '<td>'. $row['customer'] . '</td>';
                                echo '<td>'. $row['so'] . '</td>';
                                echo '<td>'. $row['so_item'] . '</td>';
                                echo '<td>'. $row['noti_text'] . '</td>';
                                echo '</tr>';
                            }
                            
                            odbc_free_result($result_noti);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/jszip-2.5.0/dt-1.10.12/af-2.1.2/b-1.2.1/b-html5-1.2.1/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.2/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
    <script src="../JS/no-data-to-display.js" type="text/javascript"></script>
    <script src="../JS/magnific-popup.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var goal=<?php echo json_encode($goal,JSON_NUMERIC_CHECK);?>;
        var dppm=<?php echo json_encode($dppm,JSON_NUMERIC_CHECK);?>;
        var period=<?php echo json_encode($period);?>;
        var code = <?php echo json_encode($codePareto);?>;
        var dppm_pareto = <?php echo json_encode($dppmPareto,JSON_NUMERIC_CHECK);?>;
        var pareto = <?php echo json_encode($pareto,JSON_NUMERIC_CHECK);?>;
        var p1 = <?php echo $period1?>;
        var p2 = <?php echo $period2?>;
    </script>
    <script src="../JS/charts.js" type="text/javascript"></script>
    </body>
</html>

