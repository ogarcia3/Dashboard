<?php 
include 'phpFiles/databaseConn.php';
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <title>Amex Dashboard</title>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container-fluid">
        <div class="row register-form">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal custom-form" method="post"  id="indexForm" target="_target">
                    <div id="options" align="center">
                        <label for="mfg" class="radio"><input type="radio" name="dateradio" id="mfg" value=1>MFG DATE</label>
                        <label for="noti" class="radio"><input type="radio" name="dateradio" id="noti" value=2>NOTIFICATION DATE</label>
                        <label for="day" class="radio-inline"><input type="radio" onclick="display();" name="optradio" id="day" value=1>DATE RANGE</label>
                        <label for="week" class="radio-inline"><input type="radio" onclick="display();" name="optradio" id="week" value=2>WEEK</label>
                        <label for="period" class="radio-inline"><input type="radio" onclick="display();" name="optradio" id="period" value=3>PERIOD</label>
                        <label for="year" class="radio-inline"><input type="radio" onclick="display();" name="optradio" id="year" value=4>YEAR</label>
                    </div>

                    <div id="datepicker" align="center">
                        <div class="form-group">
                            <label for="date1">FROM:</label>
                            <input type=date name="date1"  id="dateInput1"/>
                        </div>
                        <div class="form-group">
                            <label for="date2">TO:</label>
                            <input type=date name="date2"  id="dateInput2" onchange="validateDate();"/>
                        </div>
                    </div>

                    <div id="semana"  align="center">
                        <label for="week1">FROM:</label>
                        <?php
                            echo '<select id="weekStart" name="week1" class="week" form="indexForm">';
                            for ($i = 1; $i <= 52; $i ++ ){
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                }
                            echo '</select>';
                        ?>
                        <select  id="yearStart" name="wyear1" class="week" form="indexForm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                        <br>
                        <label for="week2">TO:</label>
                        <?php
                            echo '<select id="weekEnd" name="week2" class="week" onchange="validateWeek();" form="indexForm">';
                            for ($i = 1; $i <= 52; $i ++ ){
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                }
                            echo '</select>';
                        ?>
                        <select id="yearEnd" name="wyear2" class="week" onchange="validateWeek();" form="indexForm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                    </div>

                    <div id="periodo" class="none" align="center">
                        <label for="period1">FROM:</label>
                        <?php
                            echo '<select id="periodStart" name="period1" class="period" form="indexForm">';
                            for ($i = 1; $i <= 12; $i ++ ){
                                    echo '<option value='.$i.'>P'.$i.'</option>';
                                }
                            echo '</select>';
                        ?>
                        <select  id="pYearStart" name="pyear1" class="period" form="indexForm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                        <br>
                        <label for="period2">TO:</label>
                        <?php
                            echo '<select id="periodEnd" name="period2" class="period" onchange="validatePeriod();" form="indexForm">';
                            for ($i = 1; $i <= 12; $i ++ ){
                                    echo '<option value='.$i.'>P'.$i.'</option>';
                                }
                            echo '</select>';
                        ?> 
                        <select  id="pYearEnd" name="pyear2" class="period" onchange="validatePeriod();" form="indexForm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                    </div>

                    <div id="año" class="none" align="center">
                        <label for="year1">FROM:</label>
                        <select  id="year1" name="year1" class="year" form="indexForm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                        <br>
                        <label for="year2">TO:</label>
                        <select id="year2" name="year2" class="year" onchange="sendYear();" form="indexForm">
                            <option value="17">2017</option>
                            <option value="16">2016</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">VSM</label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <?php
                            $_queryArea = "SELECT id, area FROM tb_cat_area ORDER BY area;";

                            $resultArea= odbc_exec($conn, $_queryArea);

                            // Get data
                            $_dataArea = array();
                            while ($row=odbc_fetch_array($resultArea)) {
                                $_dataArea[] = $row;
                             }
                             echo '<select id="area" name="area" class="form-control" onchange="getWc(this.value)" form="indexForm">';
                             echo '<option value=0  selected="selected" hidden>All</option>';
                             echo '<option value=0>All</option>';
                            foreach ($_dataArea as $row) {
                                echo '<option value='.$row['id'].'>'.$row['area'].'</option>';
                            }
                            echo '</select> ';

                            odbc_free_result($resultArea);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">WC </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <select id="wc" name="wc" class="form-control" form="indexForm">
                                <option value=0 selected="selected">All</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">Order Type</label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <select id="select_order" name="order" class="form-control" form="indexForm">
                                <option value=0 selected>All</option>
                                <option value=1>Special</option>
                                <option value=2>Mockup</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label" for="name-input-field">Category</label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <?php
                                $_queryBrand = "SELECT id, gm_cat FROM tb_cat_product_gm_cat ORDER BY gm_cat;";

                                $resultBrand= odbc_exec($conn, $_queryBrand);

                                // Get data
                                $_data = array();
                                while ($row=odbc_fetch_array($resultBrand)) {
                                    $_data[] = $row;
                                }
                                echo '<select id="brands" name="brand" class="form-control" onchange="getProduct(this.value)" form="indexForm">';
                                echo '<option value=0>All</option>';
                                foreach ($_data as $row) {
                                    echo '<option value='.$row['id'].'>'.$row['gm_cat'].'</option>';
                                }
                                echo '</select> ';
                                odbc_free_result($resultBrand);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">Products </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <select id="products" name="product" class="form-control" form="indexForm">
                                <option value=0 selected="selected">All</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">Functional Owner</label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <?php
                            $_queryCode = "SELECT id, func_own FROM tb_cat_func_own WHERE is_active = 1 ORDER BY func_own;";

                            $resultCode= odbc_exec($conn, $_queryCode);

                            // Get data
                            $_dataCode = array();
                            while ($row=odbc_fetch_array($resultCode)) {
                                $_dataCode[] = $row;
                             }
                             echo '<select id="code" name="code" class="form-control"  form="indexForm">';
                             echo '<option value=0>All</option>';
                            foreach ($_dataCode as $row) {
                                echo '<option value='.$row['id'].'>'.$row['func_own'].'</option>';
                            }
                            echo '</select> ';

                            odbc_free_result($resultCode);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">RDC</label>
                        </div>
                        <div class="col-sm-6 input-column">
                        <?php
                            $_queryRdc = "SELECT id, rdc FROM tb_cat_rdc WHERE is_rdc = '1';";

                            $resultRdc = odbc_exec($conn, $_queryRdc);

                            // Get data
                            $_dataRdc = array();
                            while ($row=odbc_fetch_array($resultRdc)) {
                                $_dataRdc[] = $row;
                             }
                             echo '<select id="rdc" name="rdc" class="form-control" form="indexForm">';
                             echo '<option value= 0>All</option>';
                            foreach ($_dataRdc as $row) {
                                echo '<option value='.$row['id'].'>'.$row['rdc'].'</option>';
                            }
                            echo '</select> ';

                            odbc_free_result($resultRdc);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label">Shift </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <select id="shift" name="shift" class="form-control" form="indexForm">
                                <option value=0 selected hidden>All</option>
                                <option value=0>All</option>
                                <option value=1>Morning</option>
                                <option value=2>Night</option>
                            </select>
                        </div>
                    </div>
                    <input class="btn btn-default submit-button" type="submit" onclick="page_select();">
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="JS/index.js" type="text/javascript"></script>
</body>
</html> 