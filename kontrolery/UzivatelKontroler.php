<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UzivatelKontroler
 *
 * @author František
 */
class UzivatelKontroler extends Kontroler {

    protected $errmsg = "";
    protected $vsichniUzivatele = array();
    protected $aktivovatUzivatele = FALSE;
    protected $udaje;
    protected $vypsatUdaje = FALSE;

    public function zpracuj($params) {
        $sz = new SpravceZaznamu();
        if (isset($_SESSION['prihlasen']) && $_SESSION['prihlasen']) {
            switch (isset($params[1]) ? $params[1] : false) {
                case "pridej":
                    $this->pohled = "uzivatel-pridej";
                    break;
                case "pridano":
                    $this->pridejUzivatele($_POST['pridejFormOscislo'], $_POST['pridejFormJmeno'], $_POST['pridejFormHeslo'], $_POST['pridejFormEmail']);
                    $this->pohled = "uzivatel-pridej";
                    break;
                case "odeber":

                    $this->vsichniUzivatele = $sz->vypisAktivniUzivatele($_COOKIE[COOKIENAME]);
                    $this->pohled = "uzivatel-odeber";
                    break;
                case "odebrano":
                    if (isset($params[2])) {
                        $this->deaktivujUzivatele($params[2]);
                        $this->errmsg = "deaktivovan";
                    } else {
                        $this->errmsg = "neni vybranej clovek";
                    }

                    $this->vsichniUzivatele = $sz->vypisAktivniUzivatele($_COOKIE[COOKIENAME]);
                    $this->pohled = "uzivatel-odeber";
                    break;
                case "heslo":
                    $this->pohled = "zapomenute-heslo";
                    break;

                case "odhlasit":
                    $this->errmsg = "odhlasen";
                    $_SESSION['prihlasen'] = FALSE;
                    $_SESSION = array();
                    $this->pohled = "uzivatel";
                    break;
                case "aktivuj":
                    if (!$this->existenceHesla(array($_SESSION['udaje']['heslo']))) {
                        $sz->zmenAktivujUzivatele($_SESSION['udaje']['oscislo'], $_SESSION['udaje']['jmeno'], $_SESSION['udaje']['heslo'], $_SESSION['udaje']['email'], $_COOKIE[COOKIENAME]);
                        $this->errmsg = "uzivatel aktivovan";
                    } else {
                        $this->errmsg = "toto heslo jiz existuje, zadejte jine";
                        $this->vypsatUdaje = TRUE;
                    }
                    $this->pohled = "uzivatel-pridej";
                    break;
                default :
                    $this->pohled = "uzivatel";
                    break;
            }
        } else {
            switch (isset($params[1]) ? $params[1] : FALSE) {
                case "login":
                    if (!$vysl = $this->prihlasUzivatele($_POST['loginFormOscislo'], $_POST['loginFormHeslo'])) {
                        $this->errmsg = "prihlaseni se nezdarilo";
                    } else {
                        $this->errmsg = "vitej " . $vysl['jmeno'];
                        $_SESSION['prihlasen'] = TRUE;
                        $_SESSION['uzivatelID'] = $vysl['id'];
                        $_SESSION['uzivatelOscislo'] = $vysl['oscislo'];

                        //print_r($_SESSION);
                    }
                    break;
            }

            $this->pohled = "uzivatel";
        }

        $this->titulekS = "uzivatel";
    }

    private function prihlasUzivatele($oscislo, $heslo) {
        $sz = new SpravceZaznamu();
        if (!empty($vysledek = $sz->prihlasAdmina(array($oscislo, $heslo)))) {
            return $vysledek;
        } else {
            return false;
        }
    }

    private function deaktivujUzivatele($id) {
        $sz = new SpravceZaznamu();
        $sz->deaktivujUzivatele(array($id));
    }

    private function pridejUzivatele($oscislo, $jmeno, $heslo, $email) {
        $sz = new SpravceZaznamu();
        $_SESSION['udaje'] = array("oscislo" => $oscislo, "jmeno" => $jmeno, "heslo" => $heslo, "email" => $email, "pobocka" => $_COOKIE[COOKIENAME]);

        $existuje = $this->existenceUzivatele($oscislo);
        $existHeslo = $this->existenceHesla(array($heslo));
        if (!is_bool($existHeslo) && $existHeslo == $_SESSION['udaje']['oscislo']) {
            $existHeslo = FALSE;
        } else if (!is_bool($existHeslo) && $existHeslo != $_SESSION['udaje']['oscislo']) {
            $existHeslo = TRUE;
        }

        if (!$existuje && !$existHeslo) {
            $sz->pridejUzivatele($_SESSION['udaje']);
            $this->errmsg = "uzivatel pridan";
        } else if (!$existuje && $existHeslo) {
            $this->errmsg = "heslo jiz existuje";
            $this->vypsatUdaje = TRUE;
        } else {
            if ($sz->jeUzivatelAktivni(array($oscislo))[0]) {
                $this->errmsg = "uzivatel s timto osobnim cislem jiz existuje a je aktivni";
                $this->aktivovatUzivatele = TRUE;
            } else {
                $this->aktivovatUzivatele = TRUE;
                $this->errmsg = "uzivatel s timto osobnim cislem existuje a je neaktivni";
            }
        }
    }

    private function existenceUzivatele($oscislo) {
        $sz = new SpravceZaznamu();
        if (!empty($sz->existenceOscislaUzivatele(array($oscislo)))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function existenceHesla($heslo) {
        $sz = new SpravceZaznamu();
        if (empty($oscislo = $sz->existenceHeslaUzivatele($heslo))) {
            return FALSE;
        } else {
            return $oscislo;
        }
    }

}
