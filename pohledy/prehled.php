<script type="text/javascript">
    function oznac(id) {
        var b = $("tr[id*='" + id + "']").length;
        //var b = $(("#").concat(id)).length;
        var oznacit;
        if (b < 2) {
            oznacit = "oznacenoC";
        } else {
            oznacit = "oznaceno";
        }
        //document.getElementById("eanek").value = b;
        while (b) {
            var a = document.getElementById(id).className = oznacit;
            document.getElementById(id).id = "";
            b = $(("#").concat(id)).length;
        }

    }

    function showIt(str) {
        str = smazMezery('eanek');
        if (str == ""){
            return;
        } else {
            document.getElementById("eanek").value = str;
            document.getElementById("txtHint").innerHTML = str;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "ZiskejInfo/" + str + "/ean", true);
            xmlhttp.send();
        }
    }
    
     function myTrim(x) {
        return x.replace(/^\s+|\s+$/gm, '');
    }

    function smazMezery(str) {
        var txt = document.getElementById(str).value;
        return myTrim(txt);
    }
    
    function showItOra(str) {
        str = smazMezery('oracek');
        if (str == "") {
            return;
        } else {
            document.getElementById("oracek").value = str;
            document.getElementById("txtHint").innerHTML = str;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "ZiskejInfo/" + str + "/ora", true);
            xmlhttp.send();
        }
    }
</script>

<form action="#" method="post" style="display: none;">
    ean <input type="number" name="ean" required><br>
    <input type="submit" value="Submit">
</form> 


<form id="prehled-form" role="form" action="prehled" method="post">
    <div class="form-group" style="width: 1230px;">
        <div class="row" style="width: 500px;">
            <div class="col-sm-6" >
                <input id="eanek" pattern="[0-9]{11,13}" class="form-control" name="eankod" value="<?php echo(isset($this->ean) ? $this->ean : "") ?> " onblur="showIt(this.value)" value="" autofocus>
                <button type="submit" name="submit" class="btn btn-default" value="eanKodSubmit">EAN</button>
            </div>

            <div class="col-sm-6" style="padding-left: 55px;">
                <input id="oracek" pattern="[0-9]{7}" class="form-control" name="orakod" value="<?php echo(isset($this->ora) ? $this->ora : "") ?>" onblur="showItOra(this.value)" >
                <button type="submit" name="submit" class="btn btn-default" value="oraKodSubmit">ORA</button>

            </div>

            <div id="txtHint" class="col-sm-6">
            </div>
        </div>        
    </div>



</form>
<h6 class="napoveda">Pro zobrazeni informaci o naskenovanem EANu nebo zadanem ORA kodu, staci kliknout mimo policko.</h6>
<hr>
<h3>Dotaz: </h3> 
<?php echo $this->ean . $this->ora ?>

<?php
if (empty($this->vysledek)) {
    ?>
    <h3>0 vysledku </h3>
    <?php
} else {
    ?>
    <div id="vypis">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMEI 1</th>
                    <th>IMEI 2</th>
                    <th>KUSY</th>
                    <th>JMENO</th>
                    <th>TEXT</th>
                    <th>DATUM</th>
                </tr>
            </thead>
            <?php
            $isImei = false;
            foreach ($this->vysledek as $b) {
                if ($b['imei'] != 0) {
                    $isImei = true;
                }
                ?>
                <tr id="<?php echo $b['imei'] ?>">
                    <td><?php echo $b['ID'] ?></td>
                    <td><?php echo $b['imei'] ?></td>
                    <td><?php echo $b['imei1'] ?></td>
                    <td><?php echo $b['kusy']; ?></td>
                    <td><?php echo $b['jmeno'] ?></td>
                    <td><?php echo $b['text'] ?></td>
                    <td><?php echo $b['datum'] ?></td>
                </tr>
                <?php
                if ($isImei && $b['kusy'] === -1) {
                    echo("<script>oznac(" . $b['imei'] . ")</script>");
                }
            }
            ?>
            <tr class="vysledek">
                <td colspan="3">SUM:</td>
                <td colspan="5"><?= $this->suma[0] ?></td>
            </tr>
        </table>
    </div>
    <?php
}
?>
