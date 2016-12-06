<?php
if (isset($this->upraveno)) {
    print_r($this->upraveno);
} else {
    ?>
    <form class="form-group" action="uzivatel/upraveno" method="POST">

        <input name="id" value="<?= $this->uzivatel['id'] ?>" style="width: 50px" readonly>

        <input value="<?= $this->uzivatel['oscislo'] ?>" style="width: 100px" disabled>

        <input name="jmeno" value="<?= $this->uzivatel['jmeno'] ?>" style="width: 200px">

        <input type="email" name="email" value="<?= $this->uzivatel['email'] ?>" style="width: 200px">

        <input name="aktivni" value="<?= $this->uzivatel['aktivni'] ?>" style="width: 20px" pattern="[0,1]{1}">

        <input name="admin" value="<?= $this->uzivatel['admin'] ?>" style="width: 20px" pattern="[0,1]{1}">

        <input value="<?= $this->uzivatel['datum'] ?>" disabled>

        <input type="submit">

    </form>

    <?php
}