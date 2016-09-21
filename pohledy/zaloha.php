<?php 
if(isset($this->message) && $this->message){
    ?>
<h3>Provedena zaloha do souboru: </h3><code><?php echo $this->directory ?><?= $this->message ?></code>
<?php
}
else if($this->synchromessage){
    ?>
    <h3>Synchronizovano s vyjezdem SAP (zaznamy: <?= $this->synchromessage ?>)</h3>
    <?php
}

?>