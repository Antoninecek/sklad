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
    
    public function zpracuj($params) {
        
        $this->inventuraEan = $params[1];
        $imei = empty($params[2]) ? NULL : $params[2];
        $imei1 = empty($params[3]) ? NULL : $params[3];
        
        $sz = new SpravceZaznamu;
        

        
        switch(empty($params[4]) ? false : $params[4]){
            case "smaz":
                $sz->pridejZaznam($this->inventuraEan, $imei, $imei1, -1, "1", "inventura");
            break;
        }

        $this->listImei = $sz->ziskejVsechnaImei($params[1]);        
        
        $this->pohled = "spravaImei";
    }

//put your code here
}
