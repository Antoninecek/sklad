<?php
if ($this->errmsg) {
    echo $this->errmsg;
}
?>

<h1>Odeber uzivatele</h1> 
<div class="list-group">
    <?php
    foreach ($this->vsichniUzivatele as $i) {
        if ($_SESSION['uzivatelOscislo'] != $i['oscislo']) {
            ?>
            <a href="uzivatel/odebrano/<?= $i['id'] ?>" class="list-group-item" onclick="upozorneni(event, '<?= $i['jmeno'], $i['id'] ?>')">
                <?= $i['id'] . " " . $i['oscislo'] . " " . $i['jmeno'] . " " . $i['email'] . " " . $i['datum'] ?>
            </a>
            <?php
        }
    }
    ?>
</div>



<script type="text/javascript">
    function upozorneni(e, jmeno, id) {
        var ide = <?= $_SESSION['uzivatelID'] ?>

        var r = confirm("Opravdu zabranit '" + jmeno + "' pracovat?");

        if (r == false) {
            e.stopImmediatePropagation();
            e.preventDefault();
        }

    }
</script>