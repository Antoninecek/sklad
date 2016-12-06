<?php
if ($this->errmsg) {
    echo $this->errmsg;
}
?>
<?php
if (!isset($_SESSION['prihlasen']) || !$_SESSION['prihlasen']) {
    ?>

    <div class="row">
        <div class="pull-right">
            <h3>Nech si poslat zapomenute heslo</h3>
            <form class="form-horizontal" style="width: 300px" action="uzivatel/zapomenute" method="POST">
                <input class="form-control" type="number" name="oscislo" placeholder="osobni cislo" required>
                <input class="form-control" type="email" name="email" placeholder="email" required>
                <input class="btn btn-default" type="submit" value="posli">
            </form>
        </div>

        <div class="pull-left">
            <h3>Zmen si heslo</h3>
            <form class="form-horizontal" style="width: 300px" action="uzivatel/zmena-hesla" method="POST">
                <input class="form-control" type="number" name="oscislo" placeholder="osobni cislo" required>
                <input class="form-control" type="password" name="starepasswd" placeholder="stare heslo" required>
                <input class="form-control" type="password" name="novepasswd" placeholder="nove heslo" required>
                <input class="btn btn-default" type="submit" value="posli">
            </form>
        </div>
    </div>

    <div class="row">
        <h1>Prihlaseni pro lidi se specialnim pravem</h1> 
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
    </div>
    <?php
}
?>