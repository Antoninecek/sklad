<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pobocka
 *
 * @author František
 */
class PobockaKontroler extends Kontroler {

    //put your code here

    protected $pobockyList;
    protected $spatneHeslo = FALSE;
    protected $nastavenoCookies;
    protected $zrusenoCookies;

    public function zpracuj($params) {

        $sz = new SpravceZaznamu;

        switch (isset($params[1]) ? $params[1] : FALSE) {
            case "nastav":
                $id = empty($_POST['pobockyJmeno']) ? "" : $_POST['pobockyJmeno'];
                $heslo = empty($_POST['pobockyHeslo']) ? "" : $_POST['pobockyHeslo'];
                if ($heslo == $sz->ziskejHesloPobocky($id)[0]) {
                    $this->nastavenoCookies = $this->nastavCookie($id, $sz->ziskejNazevPobocky($id)[0]);
                } else {
                    $this->spatneHeslo = TRUE;
                }
                break;
            case "zrus":
                $this->zrusenoCookie = $this->zrusCookie(@$_COOKIE[COOKIENAME], $sz->ziskejNazevPobocky(@$_COOKIE[COOKIENAME])[0]);
                break;
            default :

                break;
        }



        $this->pobockyList = $sz->ziskejVsechnyPobocky();

        $this->pohled = "pobocka";
        $this->titulekS = "pobocka";
    }

    private function nastavCookie($id, $jmeno) {
        setcookie(COOKIENAME, $id, time() + (365 * 24 * 60 * 60), "/");
        setcookie("inventura", "FALSE", time() + (365 * 24 * 60 * 60), "/");
        return setcookie("pobockaJmeno", $jmeno, time() + (365 * 24 * 60 * 60), "/");
    }

    private function zrusCookie($id, $jmeno) {
        setcookie("pobockaJmeno", $jmeno, time() - (365 * 24 * 60 * 60), "/");
        setcookie("inventura", "", time() - (365 * 24 * 60 * 60), "/");
        return setcookie(COOKIENAME, $id, time() - (365 * 24 * 60 * 60), "/");
    }

}
