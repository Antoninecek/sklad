<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SpravaImeiKontroler
 *
 * @author František
 */
class SpravaImeiKontroler extends Kontroler {

    protected $inventuraEan;
    protected $listImei;
    protected $pridej = FALSE;
    protected $zobraz = FALSE;
    protected $smaz = FALSE;
    protected $akce = "";

    public function zpracuj($params) {

        $sz = new SpravceZaznamu;

        switch (empty($params[1]) ? false : $params[1]) {
            case "smaz":
                $this->smaz = TRUE;
                $this->akce = "smaz";
                $this->inventuraEan = $params[2];
                $imei = empty($params[3]) ? NULL : $params[3];
                $imei1 = empty($params[4]) ? NULL : $params[4];

                $sz->pridejZaznam($this->inventuraEan, $imei, $imei1, -1, "1", "inventura", $_COOKIE[COOKIENAME]);
                $this->listImei = $sz->ziskejVsechnaImei($params[2], $_COOKIE[COOKIENAME]);
                $this->zobraz = TRUE;
                $this->akce = "zobraz";
                break;
            case "pridej":
                $this->akce = "pridej";
                $this->pridej = TRUE;
                if (!empty($_POST['ean'])) {
                    $ean = empty($_POST['ean']) ? NULL : $_POST['ean'];
                    $imei = empty($_POST['imei']) ? NULL : $_POST['imei'];
                    $imei1 = empty($_POST['imei1']) ? NULL : $_POST['imei1'];
                    


                    $sz->pridejZaznam($ean, $imei, $imei1, 1, "1", "inventura", $_COOKIE[COOKIENAME]);
                }
                break;
            case "zobraz":
                
                $this->akce = "zobraz";
                $this->zobraz = TRUE;
                $this->inventuraEan = $params[2];
                $this->listImei = $sz->ziskejVsechnaImei($params[2], $_COOKIE[COOKIENAME]);
                break;
        }

        $this->pohled = "spravaImei";
    }

    private function zkontrolujImei($imei, $imei1) { // udelat RT overovani imei pres js, dodelat kontrolu imei s db, zda se uz nenachazi
        if (is_string($imei)) {
            if (ereg('^[0-9]{15}$', $imei)) {
                for ($i = 0, $sum = 0; $i < 14; $i++) {
                    $tmp = $imei[$i] * (($i % 2) + 1 );
                    $sum += ($tmp % 10) + intval($tmp / 10);
                }
                return (((10 - ($sum % 10)) % 10) == $imei[14]);
            }
        }
        return false;
    }

//put your code here
}
