<?php if ($this->uploaded) { ?>
    <div class = "alert alert-success">
        <strong>Soubor byl nahran</strong>
    </div>
    <?php
} else if ($this->uploaded === FALSE){
    ?>
    <div class = "alert alert-danger">
        <strong>Soubor nebyl nahran</strong>
    </div>
    <?php
}
?>



<form action = "vystav/zahaj" method = "post" enctype = "multipart/form-data">
    <h4>Nahraj soubor <code style="font-size: small;">vystav.csv</code></h4>
    <input style="cursor:pointer" type = "file" name = "fileToUpload" id = "fileToUpload" class="btn btn-default">  
    <input type = "submit" value = "Posli a vystavuj" name = "submit" class="btn btn-default" style="margin-top: 20px;">
</form>
<br>
<a href="vystav/znovu" class="btn btn-default">Znovu se stejnym souborem</a>

<?php
if ($this->uploaded) {
    ?>
    <div class="pull-right">
        <form action="vystav/skupina" method="post">
            <input type="text" name="skupinaInput" id="skupinaInput">
            <input type="submit" value="zobraz skupinu" name="submitSkupinu" class="btn btn-default">
        </form>
    </div>
    <h3>Nevystaveno: <?php echo $this->synchromessage ?></h3>
    <table id="nevystavene" class="table table-hover">
        <thead>
            <tr>
                <td>ean</td>
                <td>ora</td>
                <td>item</td>
                <td>popis</td>
                <td>skupina</td>
                <td>bezpecak</td>
                <td>SAP</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->nevystavene as $a) { ?>
                <tr>
                    <td> <?php echo $a['ean']; ?> </td>
                    <td> <?php echo $a['zbozi']; ?> </td>
                    <td> <?php echo $a['item']; ?> </td>
                    <td> <?php echo $a['popis']; ?> </td>
                    <td><a href="vystav/skupina/<?php echo $a['skup']; ?>"><?php echo $a['skup']; ?></a> </td>
                    <td> <?php echo $a['zarKusy'] ?></td>
                    <td> <?php echo $a['sapKusy']; ?> </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>