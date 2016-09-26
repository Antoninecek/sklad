<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PridejKontroler
 *
 * @author F@nny
 */
class PridejKontroler extends Kontroler {

    protected $message = "";
    protected $heslo = "";
    protected $text = "";
    protected $summ = "";
    protected $logMsg = "";
    protected $seznamZaznamu;
    protected $pokusPridat = FALSE;
    protected $uspesnePridani = FALSE;
    protected $zachovatHeslo = FALSE;
    protected $pokusUnda = FALSE;
    protected $vysledekUnda = FALSE;
    protected $vypisZnova = FALSE;
    protected $zmenaFocus;

    public function zpracuj($params) {
        $spravceZaznamu = new SpravceZaznamu();

        switch (isset($params[1]) ? $params[1] : FALSE) {
            case "pridano":
                $this->heslo = $_POST['jmeno'];
                $this->text = $_POST['text'];
                $this->pokusPridat = TRUE;
                if (isset($_POST['formZachovejHeslo']) && $_POST['formZachovejHeslo'] == TRUE) {
                    $this->zachovatHeslo = TRUE;
                }
                break;
            case "undo":
                $this->pokusUnda = TRUE;
                $posledni = $this->zjistiPosledniZaznam();
                if (isset($_POST['formUndoHeslo'])) {
                    $heslo = $this->zjistiHeslo($_POST['formUndoHeslo']);
                } else {
                    $heslo = FALSE;
                }
                $heslo1 = $this->zjistiHeslo($posledni['jmeno']);
                if ($heslo == $heslo1) {
                    $sz = new SpravceZaznamu();
                    if ($posledni['text'] == "") {
                        $posledni['text'] = "oprava zaznamu";
                    } else {
                        $posledni['text'] = $posledni['text'] . " oprava zaznamu";
                    }
                    $this->vysledekUnda = $sz->pridejZaznam($posledni['ean'], $posledni['imei'], $posledni['imei1'], $posledni['kusy'] * (-1), $posledni['jmeno'], $posledni['text']);
                }
                break;
        }

        if ($this->existujeAktivniHeslo($this->heslo)) {


            if (isset($_POST['imei']) && !empty($_POST['imei'])) {
                if ($_POST['imei'] != "") {
                    $kusy = 1;
                }
                if(isset($_POST['imei1']) && $_POST['imei1'] == 0){
                    $_POST['imei1'] = NULL;
                }
            } else if (isset($_POST['kusy'])) {
                $_POST['imei'] = NULL;
                $_POST['imei1'] = NULL;
                $kusy = $_POST['kusy'];
            }


            if (isset($_POST['ean'])) {

                if (($this->summ = $_POST['summ']) == "vydej") {
                    if (isset($_POST['imei']) && !empty($_POST['imei'])) {
                        $this->zjistiImei($_POST['imei']);
                    }
                    $kusy = $kusy * (-1);
                    if (isset($_POST['imei']) && !empty($_POST['imei'])) {
                        if (($this->kontrolaVydeje($_POST['imei']) - 1) < 0) {
                            $this->loguj($_POST['ean'], $_POST['imei'], $_POST['imei1'], $_POST['jmeno']);
                        }
                    } else {
                        if (($this->kontrolaVydejeEAN($_POST['ean']) - 1) < 0) {
                            $this->logujKusy($_POST['ean'], NULL, $_POST['jmeno'], $kusy);
                        }
                    }
                }

                //$oraItem = $spravceZaznamu->ziskejOra($_POST['ean']);
                //print_r($oraItem);
                //print_r($_POST);

                $sz = new SpravceZaznamu();
                $v = $sz->vratSumuImei($_POST['imei']);
                //print_r($v);
                if (($_POST['summ']) == "prijem" && $v[0] > 0) {
                    $this->message = "Tenhle imei uz je pridanej";
                    $this->uspesnePridani = FALSE;
                } else {
                    //print_r($_POST);
                    $pridejOscislo = $spravceZaznamu->vratOscislo($this->heslo)[0];
                    $vraceni = $spravceZaznamu->pridejZaznam($_POST['ean'], $_POST['imei'], $_POST['imei1'], $kusy, $pridejOscislo, $_POST['text']);

                    $this->message = $vraceni;
                    $this->uspesnePridani = TRUE;

                    unset($_POST['ean']);
                    unset($_POST['imei']);
                    unset($_POST['imei1']);
                    unset($_POST['kusy']);
                }
            }
        } else if ($this->pokusPridat) {
            $this->vypisZnova = TRUE;
            $this->message = "spatne heslo, neaktivni uzivatel";
        }
        $this->seznamZaznamu = $spravceZaznamu->vratVsechno('SELECT Z.ean as ean, Z.imei as imei, Z.imei1 as imei1, Z.kusy as kusy, U.jmeno as jmeno, Z.text as text, Z.datum as datum FROM zarizeni as Z, uzivatele as U WHERE Z.jmeno = U.oscislo order by Z.ID desc limit 10 ');

        $this->titulekS = "pridej";
        $this->pohled = "pridej";
    }

    private function zjistiImei($imei) {
        $sz = new SpravceZaznamu();
        if ($imei1 = $sz->jeImei0($imei)[0]) {
            $_POST['imei'] = $imei;
            $_POST['imei1'] = $imei1;
        } else if ($imei0 = $sz->jeImei1($imei)[0]) {
            $_POST['imei'] = $imei0;
            $_POST['imei1'] = $imei;
        } else {
            $_POST['imei'] = $imei;
            $_POST['imei1'] = NULL;
        }
        if ($_POST['imei'][0] == 0) {
            $_POST['imei'] = NULL;
        } else if (!isset($_POST['imei1'][0]) || $_POST['imei1'][0] == 0) {
            $_POST['imei1'] = NULL;
        }
    }

    private function zjistiHeslo($jmeno) {
        $sz = new SpravceZaznamu();
        return $sz->zjistiHeslo($jmeno);
    }

    private function zjistiPosledniZaznam() {
        $sz = new SpravceZaznamu();
        $posledni = $sz->posledniZaznamZarizeni();
        return $posledni;
    }

    private function existujeAktivniHeslo($heslo) {
        $sz = new SpravceZaznamu();
        $jmeno = $sz->existujeAktivniHeslo(array($heslo));
        if (empty($jmeno)) {
            return FALSE;
        } else {
            return $jmeno;
        }
    }

    public function kontrolaVydejeEAN($ean) {
        $sz = new SpravceZaznamu();
        return $sz->vratSumu($ean)[0];
    }

    public function kontrolaVydeje($imei) {
        $sz = new SpravceZaznamu();
        return $sz->vratSumuImei($imei)[0];
    }

    public function loguj($ean, $imei, $imei1, $jmeno) {
        $sz = new SpravceZaznamu();
        $text = "ean: " . $ean . " imei: " . $imei . " imei1: " . $imei1 . " jmeno: " . $sz->vratJmenoUzivatele($jmeno)[0];
        $sz->pridejLog($text);
        $this->logMsg = "Byl vydan telefon do minusu, zalogovano.";
    }

    public function logujKusy($ean, $imei, $jmeno, $kusy) {
        $sz = new SpravceZaznamu();
        $text = "ean: " . $ean . " imei: " . $imei . " kusy: " . $kusy . " jmeno: " . $jmeno;
        $sz->pridejLog($text);
        $this->logMsg = "Bylo vydano zbozi do minusu, zalogovano.";
    }

//put your code here
}
