<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NavodKontroler
 *
 * @author František
 */
class NavodKontroler extends Kontroler {

    public function zpracuj($params) {
        switch (isset($params[1]) ? $params[1] : false) {
            default :
                $this->pohled = "navod";
                $this->titulekS = "navod";
                break;
        }
    }

}
