<?php
if ($this->errmsg) {
    echo $this->errmsg;
}
?>

<?php
if (!isset($_SESSION['prihlasen']) || !$_SESSION['prihlasen']) {
    ?>
    <h1>Prihlas se</h1> 
    <form class="form-horizontal" action="uzivatel/login" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" for="oscislo">Osobni cislo:</label>
            <div class="col-sm-5">
                <input type="number" class="form-control" id="loginFormOscislo" name="loginFormOscislo" placeholder="Osobni cislo" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="heslo">Heslo:</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" id="loginFormHeslo" name="loginFormHeslo" placeholder="Heslo" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Odesli</button>
            </div>
        </div>
    </form>
    <?php
}
?>