<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrehledKontroler
 *
 * @author F@nny
 */
class PrehledKontroler extends Kontroler {

    protected $vysledek = array();
    protected $suma;
    public $ean;
    protected $vydany = array();
    protected $ora;

    public function zpracuj($params) {
        $spravceZaznamu = new SpravceZaznamu();
       
        
        if(isset($_POST['submit']) && $_POST['submit'] == 'eanKodSubmit'){
            
            $this->ean = $_POST['eankod'];
            
            $this->vysledek = $spravceZaznamu->zobrazZaznamyEAN($this->ean);
            $this->suma = $spravceZaznamu->vratSumu($this->ean);
        }
        else if (isset ($_POST['submit']) && $_POST['submit'] == 'oraKodSubmit'){
            $this->ora = $_POST['orakod'];
            
            $this->vysledek = $spravceZaznamu->zobrazZaznamyORA($this->ora);
            
            $this->suma = $spravceZaznamu->vratSumuORA($this->ora);
        }
        
        /*if (isset($_POST['ean'])) {
            $this->ean = $_POST['ean'];

            $this->vysledek = $spravceZaznamu->zobrazZaznamyEAN(array($this->ean));
            $this->suma = $spravceZaznamu->vratSumu($this->ean);
        } else if (isset($_POST['ora'])) {
            $this->ora = $_POST['ora'];
            
            $this->vysledek = $spravceZaznamu->zobrazZaznamyORA(array($this->ean));
            $this->suma = $spravceZaznamu->vratSumu($this->ean);
        }*/
        
        $this->titulekS = "prehled";
        $this->pohled = "prehled";
    }

//put your code here
}
