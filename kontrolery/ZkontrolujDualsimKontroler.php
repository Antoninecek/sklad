<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZkontrolujDualsim
 *
 * @author František
 */
class ZkontrolujDualsimKontroler extends Kontroler {

    //put your code here

    public function zpracuj($params) {
        $sz = new SpravceZaznamu();

        $ora = $sz->ziskejOra($params[1])[0];
        $dual = $sz->jeDualsim($ora)[0];

        if ($dual) {
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
