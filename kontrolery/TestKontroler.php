<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestKontroler
 * WTF?! PROC JSEM TOHLE DELAL?
 * @author František
 */
class TestKontroler extends Kontroler {

    public function zpracuj($params) {
        $sz = new SpravceZaznamu();
        $a = $sz->vratVsechno("select * , sap.kusy as sapKusy from ( select ean, imei, imei1, sum(kusy) as zarKusy, 0 as invKusy from zarizeni where imei is NULL and ean not in (select ean from inventura) having zarKusy != 0 union select ean, imei, imei1, kusy as zarKusy, 0 as invKusy from zarizeni where imei is not NULL and ean not in (select ean from inventura) having zarKusy != 0 union select ean, null as imei, null as imei1, 0 as zarKusy, kusy as invKusy from inventura where ean not in (select distinct ean from zarizeni) having invKusy != 0 union select zarizeni.ean, imei, imei1, zarizeni.kusy as zarKusy, inventura.kusy as invKusy from zarizeni, inventura where zarizeni.ean = inventura.ean order by ean ) as A left join sap on A.ean = sap.ean");
        print_r($a);
    
        $this->pohled = "test";
    }

//put your code here
}
