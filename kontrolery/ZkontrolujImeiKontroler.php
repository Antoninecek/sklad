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
        if ($sz->vratSumuImei($params[1])[0] > 0) {
            ?>
            true
            <?php
        } else {
            ?>
            false
            <?php
        }
    }

}
