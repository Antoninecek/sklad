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
        //window.onload = disableIt;
        $(document).ready(function () {
            $("#imei-input").focus();
            setTimeout(function () {
                $('#jmenoPridejForm').focus();
            }, 10);
        });
        var zmenaFocus = true;
    <?php
} else {
    ?>
        var zmenaFocus = false;

    <?php
    if (!$this->zachovatHeslo) {
        ?>
            $(document).ready(function () {
                setTimeout(function () {
                $('#textPridejForm').focus();
            }, 10);
            });
        <?php
    }
    ?>
    <?php
}
?>
    function showIt(str) {
        str = smazMezery("pridejEan");
        fce1(str);
        dualsimCheck(str);
    }

    function fce1(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            //document.getElementById("txtHint").innerHTML = str;
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
            xmlhttp.open("GET", "ZiskejInfo/" + str + "/pridej", false);
            xmlhttp.send();
        }
        //setTimeout(function(){document.getElementById("imei-input").focus();},2000);



    }

    function jump() {
        if (document.getElementById("skok").checked) {
            setTimeout(function () {
                document.getElementById("imei-input").focus();
            }, 1500);
        }
    }

    function dualsimCheck(str) {
        if (str == "") {
            document.getElementById("imei1-input").placeholder = "IMEI 2";
            return;
        } else {

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    ans = xmlhttp.responseText;
                    var reg = new RegExp("\s*true\s*");
                    console.log(reg.test(ans));
                    if (reg.test(ans)) {
//                        document.getElementById("imei1-input").placeholder = "DUAL SIM";
//                        document.getElementById("imei1-input").style.backgroundColor = "#ffb3b3";
                        $("#imei1-input").css("border-color", "red");
                        $('#zisk1Dualsim').css("display", "block");
                        return true;
                    } else {
//                        document.getElementById("imei1-input").placeholder = "IMEI 2";
//                        $("#imei1-input").css('background-color', 'transparent');
                        $("#imei1-input").css("border-color", "grey");
                        if (document.getElementById("imei-input").value == "") {
                            $("imei1-input").prop("disabled", "true");
//                            $("#imei1-input").css('background-color', '#EBEBE4');
                        }
                        return true;
                    }
                }
            };
            xmlhttp.open("GET", "ZkontrolujDualsim/" + str, true);
            xmlhttp.send();
        }
    }

    var imeiOk;
    var imei1Ok;
    $(document).ready(function () {
        $('#imei-input').on('input', function () {
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
        });
        $('#imei1-input').on('input change', function () {
            if (document.getElementById('imei1-input').value != "") {
                var a = validateIMEI(document.getElementById('imei1-input').value);
                if (a) {
                    document.getElementById('imei1-input').style.backgroundImage = "url('pics/Apply.png')";
                    imei1Ok = true;
                } else {
                    document.getElementById('imei1-input').style.backgroundImage = "url('pics/dialog-close.png')";
                    imei1Ok = false;
                }
            } else {
                $('#imei1-input').css("background-image", "none");
            }
        });
    });
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
                    $('#pridejHlasky').css("display", "block");
                    $('#imeiMsg').css("display", "block");
                    document.getElementById('imeiMsg').setAttribute("data-content", "V poli oznacenym krizkem neni IMEI");
                    document.getElementById('imeiMsg').setAttribute("data-original-title", "Nespravne IMEI");
                }
                return imeiOk == true && imei1Ok == true;
            }
            if (imeiOk != true) {
                $('#pridejHlasky').css("display", "block");
                $('#imeiMsg').css("display", "block");
                document.getElementById('imeiMsg').setAttribute("data-content", "V poli oznacenym krizkem neni IMEI");
                document.getElementById('imeiMsg').setAttribute("data-original-title", "Nespravne IMEI");
            }
            return imeiOk == true;
        } else
            return true;
    }

    $(document).ready(function () {
        $("#imei-input").on('focusout', function () {
            console.log("a");
            var ans;
            var reg = new RegExp("\s*true\s*");
            var str = $('#imei-input').val();
            if (str != "") {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        ans = xmlhttp.responseText;
                        var a = validateIMEI(str);
                        if (a) {
                            $('#imei-input').css('background-image', "url('pics/Apply.png')");
                            imeiOk = true;
                            var b = reg.test(ans);
                            if (b) {
                                $('#submitVydej').css('background-color', "lightgreen");
                                $('#submitVydej').css("border-color", "darkgreen");
                                if ($('#imeiMsg').css('display') == "none") {
                                    $('#pridejHlasky').css("display", "none");
                                }
                                $('#vydejMsg').css("display", "none");
                            } else {
                                $('#submitVydej').css("background-color", "red");
                                $('#submitVydej').css("border-color", "darkred");
                                $('#pridejHlasky').css("display", "block");
                                $('#vydejMsg').css("display", "block");
                            }
                        } else {
                            $('#imei-input').css("background-image", "url('pics/dialog-close.png')");
                            $('#submitVydej').css("background-color", "transparent");
                            $('#submitVydej').css("border-color", "black");
                            if ($('#imeiMsg').css('display') == "none") {
                                $('#pridejHlasky').css("display", "none");
                            }
                            $('#vydejMsg').css("display", "none");
                            imeiOk = false;
                        }
                    }
                };
                xmlhttp.open("GET", "ZkontrolujImei/" + str, true);
                xmlhttp.send();
            } else {
                resetImeiForm();
            }
        });
    });
    function resetImeiForm() {
        $('#imei-input').css('background-image', "none");
        $('#imei1-input').css('background-image', "none");
        $('#vydejMsg').css("display", "none");
        $('#imeiMsg').css("display", "none");
        $('#submitVydej').css("background-color", "transparent");
        $('#submitVydej').css("border-color", "black");
    }

    function myTrim(x) {
        return x.replace(/^\s+|\s+$/gm, '');
    }

    function smazMezery(str) {
        var txt = document.getElementById(str).value;
        document.getElementById(str).value = myTrim(txt);
        return document.getElementById(str).value;
    }

    $(document).ready(function () {
        $('#imei-input').focusout(function () {
            $('#imei-input').val(smazMezery('imei-input'));
        });
    });
    function smazMezeryImei() {
        smazMezery('imei-input');
        smazMezery('imei1-input');
    }

    $(document).ready(function () {
        $("#formZachovejHeslo").on("change", function () {
            if ($("#formZachovejHeslo").prop("checked") == false) {
                $("#jmenoPridejForm").val("");
                $("#textPridejForm").val("");
            }
        });
        $("#smazEan").click(function () {

            $("#imei-input").val("");
            $("#imei1-input").val("");
            $("#imei1-input").prop("disabled", true);
            $("#pridejEan").val("");
            $("#pridejEan").focus();
            $("#pocet-input").prop("disabled", false);
            resetImeiForm();
        });
        $("#smazImeiInput").click(function () {
            if ($("#imei-input").val() != "") {
                $("#imei-input").val("");
                $("#imei1-input").val("");
                $("#imei1-input").prop("disabled", true);
                $("#imei-input").focus();
                $("#pocet-input").prop("disabled", false);
                resetImeiForm();
            } else {
                $("#imei-input").focus();
            }
        });
        $("#smazImei1Input").click(function () {
            if ($("#imei1-input").val() != "") {
                $("#imei1-input").val("");
                $("#imei-input").focus();
                resetImeiForm();
            } else {
                $("#imei1-input").focus();
            }
        });
        $("#submitVydej").on("mouseenter", function () {
            if ($("#submitVydej").is(":disabled") == true) {
                $("#sel1").css("border-color", "red");
                $("#sel1").css("-webkit-box-shadow", "1px -1px 53px 1px rgba(252,3,3,1)");
                $("#sel1").css("box-shadow", "1px -1px 53px 1px rgba(252,3,3,1)");
                $("#sel1").css("-moz-box-shadow", "1px -1px 53px 1px rgba(252,3,3,1)");
            }
        });
        $("#submitVydej").on("mouseout", function () {
            if ($("#submitVydej").is(":disabled") == true) {
                $("#sel1").css("border-color", "black");
                $("#sel1").css("-webkit-box-shadow", "none");
                $("#sel1").css("box-shadow", "none");
                $("#sel1").css("-moz-box-shadow", "none");
            }
        });
        $("#submitPrijem").on("mouseenter", function () {
            if ($("#submitPrijem").is(":disabled") == true) {
                $("#sel1").css("border-color", "red");
                $("#sel1").css("-webkit-box-shadow", "1px -1px 53px 1px rgba(252,3,3,1)");
                $("#sel1").css("box-shadow", "1px -1px 53px 1px rgba(252,3,3,1)");
                $("#sel1").css("-moz-box-shadow", "1px -1px 53px 1px rgba(252,3,3,1)");
            }
        });
        $("#submitPrijem").on("mouseout", function () {
            if ($("#submitPrijem").is(":disabled") == true) {
                $("#sel1").css("border-color", "black");
                $("#sel1").css("-webkit-box-shadow", "none");
                $("#sel1").css("box-shadow", "none");
                $("#sel1").css("-moz-box-shadow", "none");
            }
        });
    });
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
                    <input type="password" name="formUndoHeslo" placeholder="HESLO" autocomplete="off" required>
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

        <form id="insert" role="form" method="post" action="pridej/pridano" style="max-width: 100%;" onsubmit="return validate()">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5" style="padding-right: 0px;">
                        <select name="typyPohybu" class="form-control" id="sel1" style="padding: 0px;">
                            <option value="" disabled="true" style="border-bottom: black dashed thin; border-top: black dashed thin; background-color: grey; color: white;">VYBER VYDEJ</option>
                            <option id="selProdej" value="PRODEJ">PRODEJ</option>
                            <option id="selPrevodka" value="PREVODKA">PREVODKA</option>
                            <option id="selInternet" value="INTERNET">INTERNET</option>
                            <option id="selVystaveni" value="VYSTAVENI">VYSTAVENI</option>
                            <option id="selVydejJine" value="JINE VYDEJ">JINY VYDEJ:</option>
                            <option value="" disabled="true" style="border-top: black dashed thin; border-bottom: black dashed thin; background-color: grey; color: white;">VYBER PRIJEM</option>
                            <option id="selKamion" value="KAMION">KAMION</option>
                            <option id="selRefakt" value="REFAKT">REFAKT</option>
                            <option id="selPrijemInternet" value="INTERNET PRIJEM">INTERNET</option>
                            <option id="selNeprodano" value="NEPRODANO">NEPRODANO</option>
                            <option id="selPrijemJine" value="JINE PRIJEM">JINY PRIJEM:</option>
                        </select>
                    </div>
                    <div class="col-sm-7" style="padding-left: 0px;">
                        <input id="textPridejForm" type="text" class="form-control" name="text" placeholder="TEXT" value="<?= $this->zachovatHeslo || $this->vypisZnova ? $this->text : "" ?>"  >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9" style="padding: 0;">
                    <input type="password" class="form-control" id="jmenoPridejForm" name="jmeno" value="<?= $this->zachovatHeslo ? $this->heslo : "" ?>" placeholder="HESLO" autocomplete="off" required>
                </div>
                <div class="col-sm-3 text-center" style="display: inline-block">
                    <input id="formZachovejHeslo" type="checkbox" name="formZachovejHeslo" <?= $this->zachovatHeslo ? "checked" : "" ?> tabindex="-1"><abbr title="nech zaskrtnute pro zachovani tveho hesla v kolonce i po provedeni prijmu/vydeje (vhodne pro prijem kamionu)">Zapamatuj</abbr>
                </div>
            </div>
            <br/>

            <div class="row">
                <div class="col-sm-10" style="padding-top: 10px; padding-right: 0px;">
                    <div class="row" style="width: 100%; margin-right: 0px;">
                        <div class="col-sm-9" style="padding-right: 0px;">
                            <input id="pridejEan" class="form-control" pattern="[0-9]{11,13}" name="ean" title="EAN" value="<?= $this->vypisZnova ? $_POST['ean'] : "" ?>" oninput="jump()" onblur="showIt(this.value)" placeholder="EAN" required <?php echo $this->zachovatHeslo ? "autofocus" : "" ?>>
                        </div>
                        <div class="col-sm-1" style="padding: 0px; text-align: right; vertical-align: middle; height: 34px; line-height: 34px;">

                            <span title="smaz pole EAN a IMEI" id="smazEan" class="glyphicon glyphicon-remove-sign" style="color: black; cursor: pointer;"></span>

                        </div>
                        <div class="col-sm-2" style="padding: 0; text-align: right">

                            <input id="skok" type="checkbox" name="skoc" tabindex="-1" checked> 
                            <br>
                            <abbr title="odskrtni pro zadani eanu/imei rucne">Skok</abbr>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div id="txtHint" class="col-sm-6">
                    </div>
                </div>

            </div>
            <div class="row" style="">
                <div class="col-sm-11" style="padding-right: 10px;">
                    <div class="form-group" style="padding-top: 15px;">
                        <input id="imei-input" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei" value="<?= $this->vypisZnova ? $_POST['imei'] : "" ?>" placeholder="IMEI 1" style="background-repeat: no-repeat; background-position: right;">

                    </div>
                </div>
                <div class="col-sm-1" style="padding: 0px; text-align: left; vertical-align: bottom; line-height: 64px; height: 64px">
                    <span title="smaz pole imei 1 a imei 2" id="smazImeiInput" class="glyphicon glyphicon-remove-sign" style="color: black; cursor: pointer;"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-11" style="padding-right: 10px;">
                    <div class="form-group">
                        <input id="imei1-input" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei1" value="<?= $this->vypisZnova && isset($_POST['imei1']) ? $_POST['imei1'] : "" ?>" placeholder="IMEI 2" <?php echo $this->vypisZnova ? "" : "disabled" ?> onblur="smazMezeryImei()" style="background-repeat: no-repeat; background-position: right;">
                    </div>
                </div>
                <div class="col-sm-1" style="padding: 0px; text-align: left; vertical-align: top; height: 30px; line-height: 30px;">
                    <span title="smaz pole imei 2" id="smazImei1Input" class="glyphicon glyphicon-remove-sign" style="color: black; cursor: pointer;"></span>
                </div>
            </div>
            <div class="form-group">
                <input id="pocet-input" type="number" class="form-control" name="kusy" value="<?= $this->vypisZnova && isset($_POST['kusy']) ? $_POST['kusy'] : "1" ?>" min="1" required >
            </div>

            <button id="submitPrijem" type="submit" class="prijem btn btn-default" name="summ" value="prijem">Prijem</button>
            <button id="submitVydej" type="submit" class="vydej btn btn-default" name="summ" value="vydej">Vydej</button>
        </form>

        <div id="pridejHlasky" style="text-align: center">
            <h5 style="margin-top: 0px;">Klikni na hlasku pro napovedu.</h5>
            <a id="imeiMsg" href="#" onclick="return false" class="" data-content="" data-original-title="" style="display: none; color: red; cursor: pointer; border: red solid 1px; margin-bottom: 5px;" data-toggle="popover" data-trigger="focus" tabindex="-1">
                <span class="glyphicon glyphicon-remove"></span>
                Proc se mi nedari pridat/vydat?<span class="glyphicon glyphicon-remove">

                </span>
            </a>
            <a id="vydejMsg" href="#" onclick="return false" data-content="Zkus misto tohodle druhe IMEI" data-original-title="Spatne zadane IMEI" style="color: red; cursor: pointer; border: red solid 1px; margin-bottom: 5px; display: none;" data-toggle="popover" data-trigger="focus" tabindex="-1">
                <span class="glyphicon glyphicon-remove"></span>
                Proc je tlacitko VYDEJ rude?
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </div>
        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });
        </script>
    </div>
</div>




<div class="pull-right">
    <div>
        <div class="row" style="position: relative">
            <h4 class="pull-left">CO JE CO?</h4>
            <h6 id="napoveda" class="napoveda pull-right"></h6>

            <button id="zobrazPosledniZaznamy" class="btn btn-default pull-right" style="position: absolute; top: 30px"><</button>
        </div>
        <table id="posledniZaznamy" class="table table-hover" style="display: none; right: 20px; position: relative; background-color: white; border: black solid thin">
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
    <div id="popis" class="pull-left" style="width: 800px;">
        <div id="popisPohyby" class="hidden">
            <p>
                SPRAVNY TYP POHYBU:
            <ul>
                VYDEJE
                <li>
                    PRODEJ -> prisel prodejce, ze chce neco prodat, nebo odbavujes zakaznika u kasy
                </li>
                <li>
                    PREVODKA -> je potreba prevest zbozi na jinou prodejnu, vhodne uvest nazev prodejny do TEXTu
                </li>
                <li>
                    INTERNET -> pripraveni internetove objednavky za kasu
                </li>
                <li>
                    VYSTAVENI -> prodejce si bere zbozi za ucelem vystaveni
                </li>
                <li>
                    JINY VYDEJ -> je nutne upresnit duvod vydeje do pole TEXT
                </li>
                <br>
                PRIJMY
                <li>
                    KAMION -> prijem zbozi prevzateho z kamionu
                </li>
                <li>
                    REFAKT -> prijem zbozi prevzateho z refaktu
                </li>
                <li>
                    INTERNET -> vracena internetova objednavka (storno, vyprseni,...)
                </li>
                <li>
                    NEPRODANO -> prodejce vraci zbozi zpet (opak vydeje PRODEJ)
                </li>
                <li>
                    JINY PRIJEM -> je nutne upresnit duvod prijmu do pole TEXT
                </li>
            </ul>
            </p>
        </div>
        <div id="popisText" class="hidden">
            <p>Do TEXTu napis pouze upresneni, uz sem nepis druh pohybu, ten vybiras vedle!
                <br>
                TEXT je nutny vyplnit, kdyz mas JINY PRIJEM/VYDEJ
                <br>
                TEXT je vhodne vyplnit, kdyz jde o:
            <ul>
                <li>
                    prevodku (nazev pobocky)
                </li>
                <li>
                    davas vec prodejci do ruky (jmeno prodejce)
                </li>
                <li>
                    spravny pohyb, ale specialni udalost, ktera potrebuje blizsi specifikaci
                </li>
            </ul>
            </p>
        </div>
        <div id="popisHeslo" class="hidden">
            
        </div>
        <div id="popisEan" class="hidden">
            <p>fuck</p>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $("#sel1").focus(function () {
            $("#popisPohyby").toggleClass("hidden");
        });
        $("#sel1").focusout(function () {
            $("#popisPohyby").toggleClass("hidden");
        });
        $("#textPridejForm").focus(function () {
            $("#popisText").toggleClass("hidden");
        });
        $("#textPridejForm").focusout(function () {
            $("#popisText").toggleClass("hidden");
        });
        $("#pridejEan").focus(function () {
            $("#popisEan").toggleClass("hidden");
        });
    });

</script>

<script type="text/javascript">

    $(document).ready(function () {
        $("#zobrazPosledniZaznamy").click(function () {
            $("#posledniZaznamy").toggleClass("vysun");
            if ($("#zobrazPosledniZaznamy").html() == "&lt;") {
                $("#zobrazPosledniZaznamy").html(">");
                $("#popis").css("display", "none");
            } else {
                $("#zobrazPosledniZaznamy").html("<");
                $("#popis").css("display", "block");
            }
        });
    });</script>

<script type="text/javascript">

    var pohyb = function pohyba(pohyb) {
        var t;
        console.log(pohyb);
        switch (pohyb) {
            case "PRODEJ":
                t = "selProdej";
                $("#submitPrijem").prop("disabled", true);
                $("#submitVydej").prop("disabled", false);
                break;
            case "INTERNET":
                t = "selInternet";
                $("#submitPrijem").prop("disabled", true);
                $("#submitVydej").prop("disabled", false);
                break;
            case "PREVODKA":
                t = "selPrevodka";
                $("#submitPrijem").prop("disabled", true);
                $("#submitVydej").prop("disabled", false);
                break;
            case "VYSTAVENI":
                t = "selVystaveni";
                $("#submitPrijem").prop("disabled", true);
                $("#submitVydej").prop("disabled", false);
                break;
            case "JINE PRIJEM":
                t = "selPrijemJine";
                $("#submitPrijem").prop("disabled", false);
                $("#submitVydej").prop("disabled", true);
                break;
            case "JINE VYDEJ":
                t = "selVydejJine";
                $("#submitPrijem").prop("disabled", true);
                $("#submitVydej").prop("disabled", false);
                break;
            case "KAMION":
                t = "selKamion";
                $("#submitPrijem").prop("disabled", false);
                $("#submitVydej").prop("disabled", true);
                break;
            case "REFAKT":
                t = "selRefakt";
                $("#submitPrijem").prop("disabled", false);
                $("#submitVydej").prop("disabled", true);
                break;
            case "INTERNET PRIJEM":
                t = "selPrijemInternet";
                $("#submitPrijem").prop("disabled", false);
                $("#submitVydej").prop("disabled", true);
                break;
            case "NEPRODANO":
                t = "selNeprodano";
                $("#submitPrijem").prop("disabled", false);
                $("#submitVydej").prop("disabled", true);
                break;
            default:
                pohyba($("#sel1").val());
                return true;
                break;
        }
        if (t == "selVydejJine" || t == "selPrijemJine") {
            $("#textPridejForm").prop("required", true);
        } else {
            $("#textPridejForm").prop("required", false);
        }

        if (t != null) {
            document.getElementById(t).selected = "true";
        }
    }

    $(document).ready(pohyb("<?= $this->pohyb ?>"));
    $("#sel1").on('change', function () {
        pohyb($("#sel1").val())
    });
    $(document).ready(function () {

        $("#napoveda").text(function () {
            var arr = [
                "Zaskrtavaci policko Zapamatuj ti pomuze prijmout vice veci, bez zbytecneho opakovani hesla a textu.",
                "Kdyz potrebujes zadat EAN/IMEI rucne, odskrtni policko SKOK.",
                "Krizek/Fajfka u IMEI kontroluje, zda nactene cislo je IMEI.",
                "Cervene/Zelene tlacitko Vydej ti kontroluje dostupnost nacteneho IMEI pro vydej.",
                "Zcervenani ohraniceni IMEI 2 ti pripomina povinnost skenovat pri prijmu obe IMEI.",
                "Pri vypnuti skoku musis pro zobrazeni informaci o EANu kliknout mimo pole.",
                "Po 3 minutach dojde automaticky k odhlaseni, pokud nahodou nechas zaskrtle Zapamatuj.",
                "V pripade jakehokoliv problemu muzes bud nadavat, nebo mi dat vedet (kontakt je vpravo nahore).",
                "Samsung telefony maji vetsinou na krabicce jen jedno IMEI, i kdyz jsou dualsimovy.",
                "Kdyz nevis, co jaky prvek dela, vetsinou staci najet na jeho nazev nebo primo na nej."
            ];
            var a = Math.floor((Math.random() * arr.length) + 1);
            return arr[a - 1];
        });
        var stopTime;
        if ($("#formZachovejHeslo").is(":checked")) {
            var d = new Date();
            stopTime = d.getTime();
            console.log(stopTime);
        }

        $("#formZachovejHeslo").on("click", function () {
            checkIt = $("#formZachovejHeslo").is(":checked");
            if (checkIt) {
                var d = new Date();
                stopTime = d.getTime();
                console.log(stopTime);
            } else {
                console.log("not checked");
            }
        });
        $("#insert").on("submit", function (e) {
            checkIt = $("#formZachovejHeslo").is(":checked");
            if (checkIt) {
                var d = new Date();
                if ((stopTime + 180000) <= d.getTime()) {
                    $("#jmenoPridejForm").val("");
                    $("#textPridejForm").val("");
                    $("#formZachovejHeslo").prop('checked', false);
                    e.preventDefault();
                    console.log("stop");
                } else {
                    console.log("continue");
                }

            } else {
                console.log("controll not checked");
            }
        });
    });
</script>
