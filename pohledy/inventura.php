<!--<?php if ($this->uploaded) { ?>
    <div class = "alert alert-success">
        <strong>Soubor byl nahran</strong>
    </div>
    <?php
} else if ($this->uploaded === FALSE) {
    ?>
                                                                                            <div class = "alert alert-danger">
                                                                                                <strong>Soubor nebyl nahran</strong>
                                                                                            </div>
    <?php
}
?>-->

<?php
if (!$this->iAktivni) {
    ?>
    <form action = "inventura/zahaj" method = "post" enctype = "multipart/form-data">
        <h4>Nahraj soubor <code style="font-size: small;">trans.dat</code></h4>
        <input style="cursor:pointer" type = "file" name = "fileToUpload" id = "fileToUpload" class="btn btn-default"> 
        <button type = "submit" value = "zahaj" name = "submit" class="btn btn-default" style="margin-top: 20px;">Posli a zahaj inventuru</button>

    </form>
    <?php
} else {
    ?>
    <h1>inventura aktivni</h1>
    <a id="inventuraKonec" class="btn btn-warning" href="inventura/ukonci">ukonci inventuru</a>
    <?php
    ?>
    <br>
    <br>
    <br>
    <!--
    <table>
        <thead>zmenene polozky behem dohledavani</thead>
        <tr>
    <?php
    foreach ($this->zmenenePolozky as $a) {
        ?>
                        <td><?php echo $a['ean'] ?></td>
                        <td><?php echo $a['zbozi'] ?></td>
                        <td><?php echo $a['model'] ?></td>            
                        <td><?php echo $a['popis'] ?></td>            
                        <td><?php echo $a['invKusy'] ?></td>
                        <td><?php echo $a['zarKusy'] ?></td>
                        <td><?php echo $a['invKusy'] ?></td>
                        <td><?php echo $a['sapKusy'] ?></td>
        <?php
    }
    ?>
        </tr>
    </table>-->
    <?php
    ?>

    <!--<a class="btn btn-default" href="inventura/znovu">Znova se stejnym souborem</a>-->
    <form action="inventura/aktualizace" method="post" style="width: 1200px">
        <?php
        ?>
        <button id="inventuraAktualizace" class="btn btn-info pull-right">Aktualizuj</button>
        <!--<a class="btn btn-default pull-right" href="inventura/zobraznuly/<?php echo $this->zobrazitNuly ?>">Zobraz nuly</a>-->

        <a class="btn btn-default" id="inventuraPridejImei" onclick="inventuraPridejImei()">pridej polozku s Imei</a>
        <table id="inventuraVysledek" class="table" style="width: 1301px">



            <thead><h3>rozdily</h3></thead><col width=10%>

            <tr>
                <td>ean</td>
                <td>ora</td>
                <td>item</td>
                <td>popis</td>
                <td>imei</td>
                <td>imei1</td>
                <td>scan</td>
                <td>bezp.</td>
                <td>rozdil</td>
                <td>SAP</td>
                <td>O. nacteno</td>
                <td>O. bezpecak</td>
            </tr>
            <?php
            //$a = $this->vysledek0;
            // TODO for loop, zjisteni dalsiho prvku, smrstit eany, zobrazovat jen imei
            $posledniEan = NULL;
            foreach ($this->vysledek0 as $a) {
                $pocet = $a['celkem'];

                if ($pocet == NULL) {
                    if ($a['invKusy'] - $a['zarKusy'] == 0) {
                        continue;
                    }
                    $posledniEan = $a['ean'];
                    ?>
                    <tr>
                        <td><?php echo $a['ean'] ?></td>
                        <td><?php echo $a['zbozi'] ?></td>
                        <td><?php echo $a['model'] ?></td>            
                        <td><?php echo $a['popis'] ?></td>   
                        <td><?php echo $a['imei'] ?></td>
                        <td><?php echo $a['imei1'] ?></td>
                        <td style="width: 50px"><?php echo empty($a['invKusy']) ? 0 : $a['invKusy'] ?></td>
                        <td style="width: 50px"><?php echo empty($a['zarKusy']) ? 0 : $a['zarKusy'] ?></td>
                        <td style="width: 50px"><?php echo $a['invKusy'] - $a['zarKusy'] ?></td>

                        <td><?php echo $a['sapKusy'] ?></td>
                        <td><input style="width: 50px;" type="number" value="<?php echo empty($a['invKusy']) ? 0 : $a['invKusy'] ?>" name="opravaNacteno[<?php echo $a['ean'] ?>]" ></td>
                        <td><input style="width: 50px;" type="number" value="<?php echo empty($a['zarKusy']) ? 0 : $a['zarKusy'] ?>" name="opravaBezpecak[<?php echo $a['ean'] ?>]"></td>

                    </tr>
                    <?php
                } else {
                    if ($a['invKusy'] - $a['celkem'] == 0) {
                        continue;
                    }
                    if ($posledniEan != $a['ean']) {
                        $posledniEan = $a['ean'];
                        ?>

                        <tr>
                            <td><?php echo $a['ean'] ?></td>
                            <td><?php echo $a['zbozi'] ?></td>
                            <td><?php echo $a['model'] ?></td>            
                            <td><?php echo $a['popis'] ?></td>   
                            <td><?php echo $a['imei'] ?></td>
                            <td><?php echo $a['imei1'] ?></td>
                            <td><?php echo empty($a['invKusy']) ? 0 : $a['invKusy'] ?></td>
                            <td><?php echo $a['celkem'] ?></td>
                            <td><?php echo $a['invKusy'] - $a['celkem'] ?></td>
                            <td><?php echo $a['sapKusy'] ?></td>
                            <!--<td><input type="number" value="<?= $a['invKusy'] ?>" name="opravaNacteno[<?= $a['ean'] ?>]"</td>
                            <td><input type="number" value="<?= $a['zarKusy'] ?>" name="opravaBezpecak[<?= $a['ean'] ?>]"></td>-->
                            <td colspan="2"><a class="btn btn-default btn-block" onclick="inventuraVymaz(<?= $a['ean'] ?>)"><center>oprav</center></a></td>
                        </tr>
                        <?php
                    } else {
                        $posledniEan = $a['ean'];
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>            
                            <td></td>   
                            <td><?php echo $a['imei'] ?></td>
                            <td><?php echo $a['imei1'] ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $a['sapKusy'] ?></td>
                            <!--<td><input type="number" value="<?= $a['invKusy'] ?>" name="opravaNacteno[<?= $a['ean'] ?>]"</td>
                            <td><input type="number" value="<?= $a['zarKusy'] ?>" name="opravaBezpecak[<?= $a['ean'] ?>]"></td>-->
                        </tr>
                        <?php
                    }
                }
            }
            ?>
            </tbody>
        </table>
    </form>

    <?php
}
?>
<div id="imeika" style="background-color: white; border: black solid thin; display: none; ">
    fadsfa

</div>
<!--
<?= print_r($this->vysledek) ?>
<?= print_r($this->vysledek1) ?>
<?= print_r($this->vysledek2) ?>
-->


<script type="text/javascript">

    function inventuraPridejImei() {
        var winb = window.open("spravaimei/pridej", "popupWindow", "width=1000,height=500");
        console.log(winb);
        while (!winb.closed) {
            alert("Zavri okno se spravou imei, pak potvrd!");
            if (winb.closed) {
                console.log("a1");
            } else {
                console.log("b1");
            }
        }
        document.getElementById('inventuraAktualizace').click();
    }

    function inventuraVymaz(ean) {
        var wina = window.open("spravaimei/zobraz/" + ean, "popupWindow", "width=1000,height=500");
        console.log(wina);
        while (!wina.closed) {
            alert("Zavri okno se spravou imei, pak potvrd!");
            if (wina.closed) {
                console.log("a");
            } else {
                console.log("b");
            }
        }
        document.getElementById('inventuraAktualizace').click();
    }

    $(document).ready(function () {

        jQuery.fn.center = function () {
            this.css("display", "block");
            this.css("position", "absolute");
            this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                    $(window).scrollTop()) + "px");
            this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                    $(window).scrollLeft()) + "px");
            //this.css("position", "fixed");
            return this;
        }

        $('#inventuraVysledek tr td input[type="button"]').click(function () {
            var id = $(this).attr('data-ean');
            console.log(id);
            $("#imeika").center();
            $("#imeika").attr('data-ean', id);
            $("#imeika").html(vsechno);
        });
        
        $('#inventuraKonec').click(function(event){
           var ans = confirm("Opravdu ukoncit inventuru?");
           if(ans != true){
               event.preventDefault();
           }
        });
    });

</script>
