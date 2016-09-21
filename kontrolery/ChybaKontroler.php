<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChybaKontroler
 *
 * @author F@nny
 */
class ChybaKontroler extends Kontroler {

    //put your code here
    public function zpracuj($params) {

        header("HTTP/1.0 404 Not Found");
        $this->titulekS= "404";
        $this->pohled = "chyba";
    }

}
