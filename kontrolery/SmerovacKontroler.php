<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmerovacKontroler
 *
 * @author F@nny
 */
class SmerovacKontroler extends Kontroler {

    public function zpracuj($parametry) {
        
        $naparsovanaURL = $this->parsujURL($parametry[0]);
        
        
        
        if (empty($naparsovanaURL[0])) {
            $this->presmeruj(PATHEMPTYURL);
        }
        $tridaKontroleru = $this->pomlckyDoVelbloudiNotace($naparsovanaURL[0]) . "Kontroler";

        
        if (file_exists("kontrolery/" . $tridaKontroleru . ".php")) {
            $this->kontroler = new $tridaKontroleru;
        } else {
            $this->presmeruj(PATHERR);
        }
        
        
        
        $this->kontroler->zpracuj($naparsovanaURL);
        $this->data['titulek'] = $this->kontroler->titulekS;
        $this->pohled = 'rozlozeni';
        if(preg_match("/ZiskejInfo/", $naparsovanaURL[0])){
            $this->pohled = '';
        }
    }

    private function parsujURL($url) {
        $naparsovanaURL = parse_url($url);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $vysledna = explode("/", $naparsovanaURL["path"]);
        array_shift($vysledna);
        array_shift($vysledna);
        return $vysledna;
    }

    private function pomlckyDoVelbloudiNotace($text) {
        $text = str_replace("-", " ", $text);
        $text = ucwords($text);
        $text = str_replace(' ', '', $text);
        return $text;
    }

//put your code here
}
