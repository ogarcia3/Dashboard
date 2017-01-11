<?php
include '../phpFiles/databaseConn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <form id="frm">
                <div class="form-group">
                    <label for="txtProject">Project Name</label>
                    <input type="text" class="form-control" id="txtProject" name="txtProject" placeholder="Project Name" required>
                </div>
                <div class="form-group">
                    <label for="comboCat">Brand</label>
                    <select class="form-control" id="comboCat" name="comboCat" form="frm" onchange="getProduct(this.value);">
                        <option value="0">All</option>
                        <?php
                        $_queryBrand = "SELECT id, gm_cat FROM tb_cat_product_gm_cat ORDER BY gm_cat;";

                        $resultBrand= odbc_exec($conn, $_queryBrand);

                        while ($row=odbc_fetch_array($resultBrand)) {
                            echo '<option value='.$row['id'].'>'.$row['gm_cat'].'</option>';
                        }
                        odbc_free_result($resultBrand);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comboProd">Product</label>
                    <select class="form-control" id="comboProd" name="comboProd" form="frm">
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="txtChamp">Champion</label>
                    <input type="text" class="form-control" id="txtChamp" name="txtChamp" placeholder="Champion">
                </div>
                <div class="form-group">
                    <label for="comboArea">Area</label>
                    <select class="form-control" id="comboArea" name="comboArea" form="frm" onchange="getWc(this.value);">
                        <option value="0">All</option>
                        <?php
                        $_queryArea = "SELECT id, area FROM tb_cat_area ORDER BY area;";

                        $resultArea= odbc_exec($conn, $_queryArea);

                        while ($row=odbc_fetch_array($resultArea)) {
                            echo '<option value='.$row['id'].'>'.$row['area'].'</option>';
                         }
                        odbc_free_result($resultArea);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comboWc">Work Center</label>
                    <select class="form-control" id="comboWc" name="comboWc" form="frm">
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="comboFunc">Functional Owner</label>
                    <select class="form-control" id="comboFunc" name="comboFunc" form="frm">
                        <?php
                        $_queryCode = "EXEC [sp_func_own];";

                        $resultCode= odbc_exec($conn, $_queryCode);

                        while ($row=odbc_fetch_array($resultCode)) {
                            echo '<option value='.$row['id'].'>'.$row['func_own'].'</option>';
                         }
                        odbc_free_result($resultCode);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="txtImple">Implement Date</label>
                    <input type="date" class="form-control" id="txtImple" name="txtImple">
                </div>
                <div class="form-group">
                    <label for="txtImpa">Impact Date</label>
                    <input type="date" class="form-control" id="txtImpa" name="txtImpa">
                </div>
                <div class="form-group">
                    <label for="comboPeriod">Impact Period</label>
                    <select class="form-control" id="comboPeriod" name="comboPeriod" form="frm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comboFY">Impact Fiscal Year</label>
                    <select class="form-control" id="comboFY" name="comboFY" form="frm">
                        <option value="16">16</option>
                        <option value="17">17</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="txtQty">Impact Quantity</label>
                    <input type="number" class="form-control" id="txtQty" name="txtQty" placeholder="Impact Quantity" min="0">
                </div>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="JS/index.js"></script>
    </body>
</html>
