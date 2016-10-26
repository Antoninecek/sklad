<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZkontrolujImeiKontroler
 *
 * @author František
 */
class ZkontrolujImeiKontroler extends Kontroler {

    public function zpracuj($params) {
        $sz = new SpravceZaznamu();
        //print_r($params);
        $imei = $this->zjistiImei($params[1])[0];
        if ($sz->vratSumuImei($imei)[0] > 0) {
            ?>
            true
            <?php
        } else {
            ?>
            false
            <?php
        }
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

}
