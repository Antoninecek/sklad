<form action="#" method="post" style="display: none;">
    ean <input type="number" name="ean" min="1" required><br>
    imei <input type="number" name="imei" min="1"><br>
    kusy <input type="number" name="kusy" value="1" min="1" required><br>
    vydej <input type="checkbox" name='vydej'><br>
    <input type="submit" value="Submit">
</form> 

<script>
<?php
if ($this->vypisZnova) {
    ?>
        window.onload = disableIt;
        var zmenaFocus = true;
    <?php
} else {
    ?>
        var zmenaFocus = false;
    <?php
}
?>


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

    var imeiOk;
    var imei1Ok;

    function disableIt() {

        if (document.getElementById('imei-input').value != "") {
            document.getElementById('pocet-input').value = 1;
            document.getElementById("pocet-input").disabled = true;
            document.getElementById("imei1-input").disabled = false;
            var a = validateIMEI(document.getElementById('imei-input').value);
            if (a) {
                document.getElementById('imei-input').style.backgroundImage = "url('pics/Apply.png')";
                document.getElementById('imei-input').style.backgroundRepeat = "no-repeat";
                document.getElementById('imei-input').style.backgroundPosition = "right";
                imeiOk = true;
            } else {
                document.getElementById('imei-input').style.backgroundImage = "url('pics/dialog-close.png')";
                document.getElementById('imei-input').style.backgroundRepeat = "no-repeat";
                document.getElementById('imei-input').style.backgroundPosition = "right";
                imeiOk = false;
            }
        } else {
            document.getElementById("pocet-input").disabled = false;
            document.getElementById("imei1-input").disabled = true;
            document.getElementById("imei1-input").value = '';
        }

        if (document.getElementById('imei1-input').value != "") {
            var a = validateIMEI(document.getElementById('imei1-input').value);
            console.log(a);
            if (a) {
                document.getElementById('imei1-input').style.backgroundImage = "url('pics/Apply.png')";
                document.getElementById('imei1-input').style.backgroundRepeat = "no-repeat";
                document.getElementById('imei1-input').style.backgroundPosition = "right";
                imei1Ok = true;
            } else {
                document.getElementById('imei1-input').style.backgroundImage = "url('pics/dialog-close.png')";
                document.getElementById('imei1-input').style.backgroundRepeat = "no-repeat";
                document.getElementById('imei1-input').style.backgroundPosition = "right";
                imei1Ok = false;
            }
        }

        if (zmenaFocus) {
            document.getElementById('jmenoPridejForm').focus();
            zmenaFocus = false;
        } else {
            if (document.getElementById("skok").checked) {
                setTimeout(function () {
                    document.getElementById("imei1-input").focus();
                }, 1500);
            }
        }


    }



    function validateIMEI(value) {
        if (/[^0-9-\s]+/.test(value))
            return false;

        // The Luhn Algorithm. It's so pretty.
        var nCheck = 0, nDigit = 0, bEven = false;
        value = value.replace(/\D/g, "");

        for (var n = value.length - 1; n >= 0; n--) {
            var cDigit = value.charAt(n),
                    nDigit = parseInt(cDigit, 10);

            if (bEven) {
                if ((nDigit *= 2) > 9)
                    nDigit -= 9;
            }

            nCheck += nDigit;
            bEven = !bEven;
        }

        return (nCheck % 10) == 0;
    }

    function zobrazeniUndo() {
        document.getElementById('formUndo').className = "show";
    }

    function validate() {
        if (document.getElementById('imei-input').value != "") {
            if (document.getElementById('imei1-input').value != "") {
                if (imeiOk != true || imei1Ok != true) {
                    document.getElementById('imeiMsg').className = "show";
                    document.getElementById('imeiMsg').setAttribute("data-content", "Krizek znaci nespravne IMEI");
                    document.getElementById('imeiMsg').setAttribute("data-original-title", "Nespravne IMEI");
                }
                return imeiOk == true && imei1Ok == true;
            }
            if (imeiOk != true) {
                document.getElementById('imeiMsg').className = "show";
                document.getElementById('imeiMsg').setAttribute("data-content", "Krizek znaci nespravne IMEI");
                document.getElementById('imeiMsg').setAttribute("data-original-title", "Nespravne IMEI");
            }
            return imeiOk == true;
        } else
            return true;
    }
</script>


<?php
if ($this->uspesnePridani) {

    if ($this->summ == "prijem") {
        ?>
        <div class="alert alert-success">
            <strong>pridano</strong>
            <br>
            <div onclick="zobrazeniUndo()" style="cursor:pointer">
                <span class="glyphicon glyphicon-fast-backward"></span> zobraz opraveni akce
            </div>
            <form  id="formUndo" class="hidden" role="form" method="post" action="pridej/undo">
                <div class="form-group">
                    <input type="password" name="formUndoHeslo" placeholder="HESLO" required>
                </div>
                <button class="btn btn-default" type="submit">Oprav posledni akci</button>
            </form>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-success">
            <strong>vydano</strong>
            <br>
            <div onclick="zobrazeniUndo()" style="cursor:pointer">
                <span class="glyphicon glyphicon-fast-backward"></span> zobraz opraveni akce
            </div>
            <form  id="formUndo" class="hidden" role="form" method="post" action="pridej/undo">
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
        <form  id="insert" role="form" method="post" action="pridej/pridano" style="max-width: 100%;" onsubmit="return validate()">
            <div class="form-group">
                <input type="text" class="form-control" name="text" placeholder="TEXT" value="<?= $this->zachovatHeslo || $this->vypisZnova ? $this->text : "" ?>"  <?php echo $this->zachovatHeslo ? "" : "autofocus" ?>>
            </div>
            <div class="form-group">
                <div class="col-sm-9" style="padding: 0;">
                    <input type="password" class="form-control" id="jmenoPridejForm" name="jmeno" value="<?= $this->zachovatHeslo ? $this->heslo : "" ?>" placeholder="HESLO" autocomplete="off" required>
                </div>
                <div class="col-sm-3 text-center" style="display: inline-block">
                    <input type="checkbox" name="formZachovejHeslo" <?= $this->zachovatHeslo ? "checked" : "" ?> tabindex="-1"><abbr title="nech zaskrtnute pro zachovani tveho hesla v kolonce i po provedeni prijmu/vydeje (vhodne pro prijem kamionu)">Zapamatuj</abbr>
                </div>
            </div>
            <br/>

            <div class="row">
                <div class="col-sm-8" style="padding-top: 10px;">
                    <input class="form-control" pattern="[0-9]{11,13}" name="ean" title="EAN" value="<?= $this->vypisZnova ? $_POST['ean'] : "" ?>" oninput="showIt(this.value)" placeholder="EAN" required <?php echo $this->zachovatHeslo ? "autofocus" : "" ?>>
                </div>
                <div class="col-sm-1" style="padding: 0;">
                    <input id="skok" type="checkbox" name="skoc" tabindex="-1" checked> 
                    <br>
                    <abbr title="odskrtni pro zadani eanu/imei rucne">Skok</abbr>
                </div>
                <div class="col-sm-3">
                    <div id="txtHint" class="col-sm-6">
                    </div>
                </div>

            </div>
            <div class="form-group" style="padding-top: 15px;">
                <input id="imei-input" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei" value="<?= $this->vypisZnova ? $_POST['imei'] : "" ?>" placeholder="IMEI 1" oninput="disableIt()" onchange="disableIt()">
            </div>
            <p id="test"></p>
            <div class="form-group">
                <input id="imei1-input" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei1" value="<?= $this->vypisZnova && isset($_POST['imei1']) ? $_POST['imei1'] : "" ?>" placeholder="IMEI 2" <?php echo $this->vypisZnova ? "" : "disabled" ?> oninput="disableIt()" onchange="disableIt()">
            </div>

            <div class="form-group">
                <input id="pocet-input" type="number" class="form-control" name="kusy" value="<?= $this->vypisZnova && isset($_POST['kusy']) ? $_POST['kusy'] : "1" ?>" min="1" required >
            </div>

            <!--<div class="form-group">
                <label><input type="checkbox" name="vydej"> Vydej</label>
            </div>-->
            <a id="imeiMsg" href="#" class="hidden" onclick="return false" class="" data-content="" data-original-title="" style="color: red; cursor: pointer; border: red solid 1px; margin-bottom: 5px;" data-toggle="popover" data-trigger="focus" tabindex="-1">
                <span class="glyphicon glyphicon-remove"></span>
                Proc se mi nedari pridat/vydat?<span class="glyphicon glyphicon-remove">

                </span>
            </a>
            <script>
                $(document).ready(function () {
                    $('[data-toggle="popover"]').popover();
                });
            </script>
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
