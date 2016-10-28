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
    protected $pohyb;

    public function zpracuj($params) {
        $spravceZaznamu = new SpravceZaznamu();

        switch (isset($params[1]) ? $params[1] : FALSE) {
            case "pridano":
                $this->heslo = $_POST['jmeno'];
                $this->text = filter_input(INPUT_POST, 'text');
                $this->pohyb = $_POST['typyPohybu'];
                $this->pokusPridat = TRUE;
                $textToDb = $this->pohyb . " " . $this->text;
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

            $imei = empty($_POST['imei']) ? NULL : $_POST['imei'];
            $imei1 = empty($_POST['imei1']) ? NULL : $_POST['imei1'];

            if ($imei != NULL) {
                $kusy = 1;
            } else {
                $kusy = $_POST['kusy'];
            }

            if (isset($_POST['ean'])) {

                //$oraItem = $spravceZaznamu->ziskejOra($_POST['ean']);
                //print_r($oraItem);
                //print_r($_POST);

                $sz = new SpravceZaznamu();
                $v = $sz->vratSumuImei($imei);
                $posledniId;
                //print_r($v);
                //print_r($_POST['summ']);
                if (($_POST['summ']) == "prijem" && $v[0] > 0) {
                    $this->message = "Tenhle imei uz je pridanej";
                    $this->uspesnePridani = FALSE;
                } else {
                    if (($_POST['summ']) == "vydej") {
                        $kusy = $kusy * (-1);

                        if ($imei != NULL) {
                            $imeiArr = $this->zjistiImei($imei);
                            $imei = $imeiArr[0];
                            $imei1 = $imeiArr[1];
                        }
                    }
                    //print_r($_POST);

                    $pridejOscislo = $spravceZaznamu->vratOscislo($this->heslo)[0];
                    $vraceni = $spravceZaznamu->pridejZaznam($_POST['ean'], $imei, $imei1, $kusy, $pridejOscislo, $textToDb);
                    $posledniId = $vraceni[0];
                    $this->message = $vraceni;
                    $this->uspesnePridani = TRUE;
                }

                if (($this->summ = $_POST['summ']) == "vydej") {

                    if (!empty($imei)) {
                        if (($this->kontrolaVydeje($imei) ) < 0) {
                            $this->loguj($posledniId, $_POST['ean'], $imei, $imei1, $_POST['jmeno']);
                        }
                    } else {
                        if (($this->kontrolaVydejeEAN($_POST['ean']) ) < 0) {
                            $this->logujKusy($posledniId, $_POST['ean'], NULL, $_POST['jmeno'], $kusy);
                        }
                    }
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
            return [$imei, $imei1];
        } else if ($imei0 = $sz->jeImei1($imei)[0]) {
            return [$imei0, $imei];
        } else {
            return [$imei, NULL];
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

    public function loguj($id, $ean, $imei, $imei1, $jmeno) {
        $sz = new SpravceZaznamu();
        $text = "id: " . $id . " ean: " . $ean . " imei: " . $imei . " imei1: " . $imei1 . " jmeno: " . $sz->vratJmenoUzivatele($jmeno)[0];
        $sz->pridejLog($text);
        $this->logMsg = "Byl vydan telefon do minusu, zalogovano.";
    }

    public function logujKusy($id, $ean, $imei, $jmeno, $kusy) {
        $sz = new SpravceZaznamu();
        $text = "id: " . $id . " ean: " . $ean . " imei: " . $imei . " kusy: " . $kusy . " jmeno: " . $sz->vratJmenoUzivatele($jmeno)[0];
        $sz->pridejLog($text);
        $this->logMsg = "Bylo vydano zbozi do minusu, zalogovano.";
    }

//put your code here
}
