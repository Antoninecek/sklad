<form action="#" method="post" style="display: none;">
    ean <input type="number" name="ean" min="1" required><br>
    imei <input type="number" name="imei" min="1"><br>
    kusy <input type="number" name="kusy" value="1" min="1" required><br>
    vydej <input type="checkbox" name='vydej'><br>
    <input type="submit" value="Submit">
</form> 

<script>
    function showIt(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
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
            xmlhttp.open("GET", "ZiskejInfo/" + str + "/pridej", true);
            xmlhttp.send();
        }
        //setTimeout(function(){document.getElementById("imei-input").focus();},2000);

        if (document.getElementById("skok").checked) {
            setTimeout(function () {
                document.getElementById("imei-input").focus();
            }, 1500);
        }
    }

    function disableIt() {

        if (document.getElementById('imei-input').value != "") {
            document.getElementById('pocet-input').value = 1;
            document.getElementById("pocet-input").disabled = true;
            document.getElementById("imei1-input").disabled = false;
        } else {
            document.getElementById("pocet-input").disabled = false;
            document.getElementById("imei1-input").disabled = true;
            document.getElementById("imei1-input").value = '';
        }


        if (document.getElementById("skok").checked) {
            setTimeout(function () {
                document.getElementById("imei1-input").focus();
            }, 1500);
        }
    }
</script>

<?php
if ($this->uspesnePridani) {

    if ($this->summ == "prijem") {
        ?>
        <div class="alert alert-success">
            <strong>pridano</strong>
            <form  id="formUndo" role="form" method="post" action="pridej/undo">
                <div class="form-group">
                    <input type="text" name="formUndoHeslo" placeholder="HESLO" required>
                </div>
                <button class="btn btn-default" type="submit">Oprav posledni akci</button>
            </form>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-success">
            <strong>vydano</strong>
            <form  id="formUndo" role="form" method="post" action="pridej/undo">
                <div class="form-group">
                    <input type="password" name="formUndoHeslo" placeholder="HESLO" required>
                </div>
                <button class="btn btn-default" type="submit">Oprav posledni akci</button>
            </form>
        </div>
        <?php
    }
} else if ($this->message === "") {
    
} else if (!$this->uspesnePridani) {
    ?>
    <div class="alert alert-danger">
        <strong><?= $this->message ?></strong>
    </div>
    <?php
} else if (!$this->message) {
    ?>
    <div class="alert alert-danger">
        <strong>neulozeno</strong>
    </div>
    <?php
}

if (isset($this->pokusUnda) && $this->pokusUnda) {
    if ($this->vysledekUnda) {
        ?>
        <div class="alert alert-success">
            <strong>opraveno</strong>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger">
            <strong>neopraveno</strong>
        </div>
        <?php
    }
}
?>


<?php
if ($this->logMsg != "") {
    ?>
    <div class="col-sm-12">
        <div class="alert alert-danger">
            <?php
            echo $this->logMsg;
            ?>
        </div>
    </div>
    <?php
}
?>

<?php
if (isset($this->vysledek)) {
    
}
?>

<div class="container formular pull-left" style="max-width: 300px;">
    <div class="row"style="max-width: 100%;">
        <form  id="insert" role="form" method="post" action="pridej/pridano" style="max-width: 100%;">
            <div class="form-group">
                <div class="col-sm-10" style="padding: 0;">
                    <input type="password" class="form-control" name="jmeno" value="<?= $this->zachovatHeslo || $this->vypisZnova ? $this->heslo : "" ?>" placeholder="HESLO" autocomplete="off" required <?php echo $this->zachovatHeslo ? "" : "autofocus" ?>>
                </div>
                <div class="col-sm-2 text-center">
                    <input type="checkbox" name="formZachovejHeslo" <?= $this->zachovatHeslo ? "checked" : "" ?> > <abbr title="nech zaskrtnute pro zachovani tveho hesla v kolonce i po provedeni prijmu/vydeje">Heslo? (najed)</abbr>
                </div>
            </div>
            <br/>
            <div>
                <input type="text" class="form-control" name="text" placeholder="TEXT" value="<?= $this->vypisZnova ? $_POST['text'] : "" ?>"
            </div>

            <br>
            <input id="skok" type="checkbox" name="skoc" checked> <abbr title="odskrtni pro zadani eanu/imei rucne">Automat skakani (najed mysi)</abbr>

            <div class="row">
                <div class="col-sm-10" style="padding-top: 30px;">
                    <input class="form-control" pattern="[0-9]{11,13}" name="ean" title="EAN" value="<?= $this->vypisZnova ? $_POST['ean'] : "" ?>" oninput="showIt(this.value)" placeholder="EAN" required <?php echo $this->zachovatHeslo ? "autofocus" : "" ?>>
                </div>
                <div class="col-sm-2">
                    <div id="txtHint" class="col-sm-6">
                    </div>
                </div>

            </div>
            <br>
            <div class="form-group">
                <input id="imei-input" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei" value="<?= $this->vypisZnova ? $_POST['imei'] : "" ?>" placeholder="IMEI 1" oninput="disableIt()" onchange="disableIt()">
            </div>
            <div class="form-group">
                <input id="imei1-input" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei1" value="<?= $this->vypisZnova && isset($_POST['imei1']) ? $_POST['imei1'] : "" ?>" placeholder="IMEI 2" disabled onmouseover="disableIt()">
            </div>

            <div class="form-group">
                <input id="pocet-input" type="number" class="form-control" name="kusy" value="<?= $this->vypisZnova && isset($_POST['kusy']) ? $_POST['kusy'] : "1" ?>" min="1" required onmouseover="disableIt()">
            </div>

            <!--<div class="form-group">
                <label><input type="checkbox" name="vydej"> Vydej</label>
            </div>-->

            <button type="submit" class="prijem btn btn-default" name="summ" value="prijem">Prijem</button>
            <button type="submit" class="vydej btn btn-default" name="summ" value="vydej">Vydej</button>
        </form>
    </div>
</div>
</div>



<div class="pull-right">
    <table class="table table-hover">
        <?php
        //print_r($this->seznamZaznamu);
        foreach ($this->seznamZaznamu as $a) {
            ?>
            <tr>
                <td> <?php echo $a['ean'] ?></td>
                <td> <?php echo $a['imei'] ?></td>
                <td> <?php echo $a['imei1'] ?></td>
                <td> <?php echo $a['kusy'] ?></td>
                <td> <?php echo $a['jmeno'] ?></td>
                <td style="max-width: 200px; word-wrap: break-word;"> <?php echo $a['text'] ?></td>
                <td> <?php echo $a['datum'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
