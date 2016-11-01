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
    <a href="inventura/ukonci">ukonci inventuru</a>
    <?php
    ?>
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
    </table>
    <?php
    ?>

    <!--<a class="btn btn-default" href="inventura/znovu">Znova se stejnym souborem</a>-->
    <form action="inventura/aktualizace" method="post">
        <?php
        ?>
        <button class="btn btn-default pull-right">Aktualizuj</button>
        <a class="btn btn-default pull-right" href="inventura/zobraznuly/<?php echo $this->zobrazitNuly ?>">Zobraz nuly</a>


        <table id="inventuraVysledek">
            <thead><h3>rozdily</h3></thead>
            <tr>
                <td>ean</td>
                <td>ora</td>
                <td>item</td>
                <td>popis</td>
                <td>nacteno</td>
                <td>bezpecak</td>
                <td>rozdil</td>
                <td>SAP</td>
                <td>O. nacteno</td>
                <td>O. bezpecak</td>
            </tr>
            <?php
            foreach ($this->vysledek as $a) {
                ?>
                <tr>
                    <td><?php echo $a['ean'] ?></td>
                    <td><?php echo $a['zbozi'] ?></td>
                    <td><?php echo $a['model'] ?></td>            
                    <td><?php echo $a['popis'] ?></td>            
                    <td><?php echo $a['invKusy'] ?></td>
                    <td>0</td> <!-- zarizeni kusy -->
                    <td><?php echo $a['invKusy'] ?></td>
                    <td><?php echo $a['sapKusy'] ?></td>
                    <td><input type="number" value="<?php echo $a['invKusy'] ?>" name="opravaNacteno[<?php echo $a['ean'] ?>]"></td>
                    <td><input type="number" value="0" name="opravaBezpecak[<?php echo $a['ean'] ?>]"></td>
                </tr>
                <?php
            }
            ?>


            <?php
            foreach ($this->vysledek1 as $a) {
                ?>
                <tr>
                    <td><?php echo $a['ean'] ?></td>
                    <td><?php echo $a['zbozi'] ?></td>
                    <td><?php echo $a['model'] ?></td>            
                    <td><?php echo $a['popis'] ?></td> 
                    <td>0</td> <!-- inventura kusy -->
                    <td><?php echo $a['zarKusy'] ?></td>
                    <td><?php echo 0 - $a['zarKusy'] ?></td>
                    <td><?php echo $a['sapKusy'] ?></td>
                    <td><input type="number" value="0" name="opravaNacteno[<?php echo $a['ean'] ?>]"></td>
                    <td><input type="number" value="<?php echo $a['zarKusy'] ?>" name="opravaBezpecak[<?php echo $a['ean'] ?>]"></td>
                </tr>
                <?php
            }
            ?>


            <?php
            foreach ($this->vysledek2 as $a) {
                ?>
                <tbody <?php echo (($a['invKusy'] - $a['zarKusy']) == 0) ? "class='" . $this->zobrazitNuly . "'" : "class='visible'" ?>>
                    <tr>
                        <td><?php echo $a['ean'] ?></td>
                        <td><?php echo $a['zbozi'] ?></td>
                        <td><?php echo $a['model'] ?></td>
                        <td><?php echo $a['popis'] ?></td>
                        <td><?php echo $a['invKusy'] ?></td>
                        <td><?php echo $a['zarKusy'] ?></td>
                        <?php
                        if ($a['zarKusy'] < 0) {
                            ?>
                            <td><?php echo $a['invKusy'] - $a['zarKusy'] ?></td>
                            <?php
                        } else {
                            ?>
                            <td><?php echo $a['invKusy'] - $a['zarKusy'] ?></td>
                            <?php
                        }
                        ?>
                        <td><?php echo $a['sapKusy'] ?></td>
                        <td><input type="number" value="<?php echo $a['invKusy'] ?>" name="opravaNacteno[<?php echo $a['ean'] ?>]"></td>
                        <td><input type="number" value="<?php echo $a['zarKusy'] ?>" name="opravaBezpecak[<?php echo $a['ean'] ?>]"></td>
                    </tr>
                </tbody>
                <?php
            }
            ?>
        </table>
    </form>

    <?php
}
?>

<!--
<?= print_r($this->vysledek) ?>
<?= print_r($this->vysledek1) ?>
<?= print_r($this->vysledek2) ?>
-->
