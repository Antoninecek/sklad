<?php
if (isset($this->spatnyHeslo) && $this->spatnyHeslo) {
    echo "spatny heslo";
}
if (isset($this->nastavenoCookies) && $this->nastavenoCookies) {
    echo "prodejna nastavena";
}
?>

<h3>AKTUALNI POBOCKA: <?php echo isset($_COOKIE[COOKIENAME]) ? $_COOKIE[COOKIENAME] . " - " . $_COOKIE['pobockaJmeno'] : "Neni vybrana pobocka" ?></h3>
<br>
<form class="form-group" action="pobocka/nastav" method="POST">
    <select name="pobockyJmeno">
        <?php
        foreach ($this->pobockyList as $a) {
            ?>
            <?php print_r($a) ?>
            <option value="<?= $a['id'] ?>"><?= $a['nazev'] ?></option>
            <?php
        }
        ?>

    </select> 
    <input name="pobockyHeslo" type="password" placeholder="HESLO">
    <input type="submit" class="btn btn-default" value="NASTAV">
</form>

<br>

<a href="pobocka/zrus" class="btn btn-danger">zrus vybranou pobocku</a>

<script type="text/javascript">
    
    $(document).ready(function () {
        if (window.location.href == "http://<?= SERVERURL ?><?= PATHBASE ?>pobocka/nastav" || window.location.href == "http://<?= SERVERURL ?><?= PATHBASE ?>pobocka/zrus") {
            window.location.replace("pobocka");
        }

    });
</script>