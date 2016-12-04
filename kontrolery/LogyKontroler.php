<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogyKontroler
 *
 * @author František
 */
class LogyKontroler extends Kontroler {

    protected $logy;

    public function zpracuj($params) {

        $sz = new SpravceZaznamu();

        switch (isset($params[1]) ? $params[1] : false) {
            case "zmen":
                $this->zmenVyreseno($params[2], $params[3]);
                break;
        }

        $this->logy = $sz->vratLogy($_COOKIE[COOKIENAME]);
        //print_r($this->logy);

        $this->pohled = "logy";
        $this->titulekS = "logy";
    }
    
    private function zmenVyreseno($id, $hodnota){
        $sz = new SpravceZaznamu();
        $sz->zmenVyresenoLog($id, $hodnota);
    }

//put your code here
}
