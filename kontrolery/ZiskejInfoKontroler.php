<?php

class ZiskejInfoKontroler extends Kontroler {

    public function zpracuj($parametry) {
        //$q = intval($_GET['q']);

        $con = mysqli_connect(DBHOST, DBUSER, DBPASS, DATABASE);
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }

        mysqli_select_db($con, DATABASE);
        //print_r($parametry);
        if (@$parametry[2] == "pridej" || @$parametry[2] == "ean") {
            $sql = "SELECT * FROM sap WHERE ean = " . $parametry[1] . "";
            $result = mysqli_query($con, $sql);
            //echo $sql;

            $row = @mysqli_fetch_row($result);
            ?>

            <div id="zisk1" class="ziskejInfo <?= $parametry[2] == "pridej" ? "styla" : "stylb" ?>" >
                <div class="col-sm-6" style="width: 100%;">
                    <label for="ora">ORA </label>
                    <input type="text" class="form-control" name="" value="<?php echo(empty($row[0]) ? "novy, sparuj" : "$row[0]"); ?>" tabindex="-1" required readonly>
                </div>
                <div class="col-sm-6" style="width: 100%;">
                    <label for="popis">ITEM </label>
                    <input type="text" class="form-control" name="" value="<?php echo(empty($row[0]) ? "se SAPem" : "$row[1]"); ?>" tabindex="-1" required readonly>
                </div>
                <div id="zisk1Dualsim" class="col-sm-6" style="display: none; width: 100%;">
                    <h4>DUAL SIM - naskenuj obe IMEI !</h4>
                </div>
            </div>

            <?php
        } else {
            $sql = "SELECT * FROM sap WHERE zbozi = " . $parametry[1] . "";
            $result = mysqli_query($con, $sql);
            //echo $sql;

            $row = @mysqli_fetch_row($result);

            //print_r($row);
            ?>

            <?php // print_r($row)  ?>

            <div class="ziskejInfo stylc">
                <div class="col-sm-6" style="width: 100%">
                    <label for="ora">EAN </label>
                    <input type="text" class="form-control" name="" value="<?php echo(empty($row[0]) ? "novy, sparuj" : "$row[2]"); ?>" required readonly>
                </div>
                <div class="col-sm-6" style="width: 100%;">
                    <label for="popis">ITEM </label>
                    <input type="text" class="form-control" name="" value="<?php echo(empty($row[0]) ? "se SAPem" : "$row[1]"); ?>" tabindex="-1" required readonly>
                </div>
            </div>
            <?php
        }
        //print_r($row);
        ?>

        <?php
    }

}
?>
<script type="text/javascript">

function closeIt(){
    document.getElementById('zisk1').className="hidden";
}

</script>
