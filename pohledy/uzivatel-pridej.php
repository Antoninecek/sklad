<?php
if(!isset($this->vypsatUdaje)){
    $this->vypsatUdaje = FALSE;
}

if ($this->errmsg) {
    echo $this->errmsg;
}
if ($this->aktivovatUzivatele) {
    ?>
<!--<div>
    <a type="button" class="btn btn-default" href="uzivatel/aktivuj/<?= $_SESSION['udaje']['oscislo'] ?>">Aktualizovat uzivatele <?= $this->udaje['oscislo'] ?> s nove zadanyma hodnotama!</a>
    
</div>-->
    <?php
}
?>

<h1>Pridej uzivatele</h1> 
<form class="form-horizontal" action="uzivatel/pridano" method="post">
    <div class="form-group">
        <label class="control-label col-sm-2" for="oscislo">Osobni cislo:</label>
        <div class="col-sm-5">
            <input type="number" class="form-control" id="pridejFormOscislo" name="pridejFormOscislo" placeholder="Osobni cislo" value="<?= $this->vypsatUdaje ? $_SESSION['udaje']['oscislo'] : '' ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="jmeno">Jmeno:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="pridejFormJmeno" name="pridejFormJmeno" placeholder="Jmeno" value="<?= $this->vypsatUdaje ? $_SESSION['udaje']['jmeno'] : '' ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="heslo">Heslo:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="pridejFormHeslo" name="pridejFormHeslo" placeholder="Heslo" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="email">Em@il:</label>
        <div class="col-sm-5">
            <input type="email" class="form-control" id="pridejFormEmail" name="pridejFormEmail" placeholder="Em@il" value="<?= $this->vypsatUdaje ? $_SESSION['udaje']['email'] : '' ?>" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Odesli</button>
        </div>
    </div>
</form>