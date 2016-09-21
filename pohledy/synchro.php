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


<form action = "synchro" method = "post" enctype = "multipart/form-data">
    <h4>Nahraj soubor <code style="font-size: small;">sap.csv</code></h4>
    <input style="cursor:pointer" type = "file" name = "fileToUpload" id = "fileToUpload" class="btn btn-default">  
    <input type = "submit" value = "Posli a zahaj synchronizaci" name = "submit" class="btn btn-default" style="margin-top: 20px;">
</form>


<?php
if ($this->uploaded) {
    ?>
    <h3>Ovlivneno: <?php echo $this->synchromessage ?></h3>
    <?php
}
?>