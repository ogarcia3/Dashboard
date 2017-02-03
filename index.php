<?php 
include 'phpFiles/databaseConn.php';
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css" type="text/css">
    <style>
        #toolbar {
            margin: 5px;
        }
    </style>
    <title>Amex Dashboard</title>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-lg-12 col-md-12">
                <form id="frm" action="phpFiles/Charts.php" method="post" target="_target">
                    
                    <div id='toolbar' class="text-center">
                        <div id="buttons" class="btn-group text-center" data-toggle="buttons">
                            <label class="btn btn-default center-block">
                                <input type="radio" id="date" class="radio" name="option" value="1">DATE
                            </label>
                            <label class="btn btn-default center-block">
                                <input type="radio" id="week" class="radio" name="option" value="2" onclick="display();">WEEK
                            </label>
                            <label class="btn btn-default center-block">
                                <input type="radio" id="period" class="radio" name="option" value="3" onclick="display();">PERIOD
                            </label>
                            <label class="btn btn-default center-block active">
                                <input type="radio" id="year" class="radio" name="option" value="4" onclick="display();">YEAR
                            </label>
                        </div>
                    </div>
                    
                    <div id="dateRange" class="form-inline" align="center">
                        <div class="form-group">
                            <label for="startDate">FROM:</label>
                            <input id="startDate" name="startDate" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="endDate">TO:</label>
                            <input id="endDate" name="endDate" type="date" class="form-control">
                        </div>
                    </div>
                    
                    <div id="weekRange" class="form-inline" align="center">
                        <div class="form-group">
                            <label for="startWeek">FROM:</label>
                            <select id="startWeek" name="startWeek" class="form-control" form="frm">
                                <?php
                                for ($i = 1; $i <= 52; $i ++ ){
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                }
                                ?>
                            </select>
                            <select  id="startWeekYear" name="startWeekYear" class="form-control" form="frm">
                                <option value="17">2017</option>
                                <option value="16">2016</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="endWeek">TO:</label>
                            <select id="endWeek" name="endWeek" class="form-control" onchange="validateWeek();" form="frm">
                                <?php
                                for ($i = 1; $i <= 52; $i ++ ){
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                }
                                ?>
                            </select>
                            
                            <select id="endWeekYear" name="endWeekYear" class="form-control" onchange="validateWeek();" form="frm">
                                <option value="17">2017</option>
                                <option value="16">2016</option>
                            </select>
                        </div>
                    </div>

                    <div id="periodRange" class="form-inline" align="center">
                        <div class="form-group">
                            <label for="startPeriod">FROM:</label>
                            <select id="startPeriod" name="startPeriod" class="form-control" form="frm">
                                <?php
                                for ($i = 1; $i <= 12; $i ++ ){
                                    echo '<option value='.$i.'>P'.$i.'</option>';
                                }
                                ?>
                            </select>
                            <select  id="startPeriodYear" name="startPeriodYear" class="form-control" form="frm">
                                <option value="17">2017</option>
                                <option value="16">2016</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="endPeriod">TO:</label>
                            <select id="endPeriod" name="endPeriod" class="form-control" onchange="validatePeriod();" form="frm">
                                <?php

                                for ($i = 1; $i <= 12; $i ++ ){
                                    echo '<option value='.$i.'>P'.$i.'</option>';
                                }
                                ?> 
                            </select>
                            <select  id="endPeriodYear" name="endPeriodYear" class="form-control" onchange="validatePeriod();" form="frm">
                                <option value="17">2017</option>
                                <option value="16">2016</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="yearRange" class="form-inline" align="center">
                        <div class="form-group">
                            <label for="startYear">FROM:</label>
                            <select  id="startYear" name="startYear" class="form-control" form="frm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="endYear">TO:</label>
                            <select id="endYear" name="endYear" class="form-control" onchange="sendYear();" form="frm">
                                <option value="17">2017</option>
                                <option value="16">2016</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date">DATE(select one):</label>
                        <select id="date" name="date" class="form-control" form="frm">
                            <option value="1">MFG DATE</option>
                            <option value="2" selected="selected">NOTIFICATION DATE</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="area">VSM</label>
                        <select id="area" name="area" class="form-control" onchange="getWc(this.value)" form="frm">
                            <option value=0>All</option>
                            <?php
                            $_queryArea = "SELECT id, area FROM tb_cat_area ORDER BY area;";

                            $resultArea= odbc_exec($conn, $_queryArea);

                            // Get data
                            while ($row=odbc_fetch_array($resultArea)) {
                                echo '<option value='.$row['id'].'>'.$row['area'].'</option>';
                             }
                            odbc_free_result($resultArea);
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="wc">WC </label>
                        <select id="wc" name="wc[]" multiple class="selectpicker form-control">
                            <option value=0 selected="selected">All</option>
                        </select>
                        <span id="helpBlock" class="help-block">Select one or multiple options. To see all just select 'ALL' option.</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="order">Order Type</label>
                        <select id="order" name="order" class="form-control" form="frm">
                            <option value=0 selected>All</option>
                            <option value=1>Special</option>
                            <option value=2>Mockup</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="brand">Category</label>
                        <select id="brand" name="brand" class="form-control" onchange="getProduct(this.value)" form="frm">
                            <option value=0>All</option>
                            <?php
                            $_queryBrand = "SELECT id, gm_cat FROM tb_cat_product_gm_cat ORDER BY gm_cat;";

                            $resultBrand= odbc_exec($conn, $_queryBrand);

                            // Get data
                            ;
                            while ($row=odbc_fetch_array($resultBrand)) {
                                echo '<option value='.$row['id'].'>'.$row['gm_cat'].'</option>';
                            }
                            odbc_free_result($resultBrand);
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="product">Products </label>
                        <select id="product" name="product" class="form-control" form="frm">
                            <option value=0 selected="selected">All</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="code">Functional Owner</label>
                        
                        <select id="code" name="code" class="form-control" form="frm">
                            <option value=0>All</option>
                            <?php
                            $_queryCode = "SELECT id, func_own FROM tb_cat_func_own WHERE is_active = 1 ORDER BY func_own;";

                            $resultCode= odbc_exec($conn, $_queryCode);

                            while ($row=odbc_fetch_array($resultCode)) {
                                echo '<option value='.$row['id'].'>'.$row['func_own'].'</option>';
                             }

                            odbc_free_result($resultCode);
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="rdc">RDC</label>
                        <select id="rdc" name="rdc" class="form-control" form="frm">
                            <option value=0>All</option>
                            <?php
                            $_queryRdc = "SELECT id, rdc FROM tb_cat_rdc WHERE is_rdc = '1';";

                            $resultRdc = odbc_exec($conn, $_queryRdc);

                            while ($row=odbc_fetch_array($resultRdc)) {
                                echo '<option value='.$row['id'].'>'.$row['rdc'].'</option>';
                             }
                            odbc_free_result($resultRdc);
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <select id="shift" name="shift" class="form-control" form="frm">
                            <option value=0 selected hidden>All</option>
                            <option value=0>All</option>
                            <option value=1>Morning</option>
                            <option value=2>Night</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
    <script src="JS/index.js" type="text/javascript"></script>
</body>
</html> 