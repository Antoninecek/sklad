<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SpravceClanku
 *
 * @author F@nny
 */
class SpravceZaznamu {
    
    public function zmenHeslo($oscislo, $heslo){
        return Db::dotazJeden("update uzivatele set heslo = ? where oscislo = ?", array($heslo, $oscislo));
    }
    
    public function vratEmail($oscislo){
        return Db::dotazJeden("select email from uzivatele where oscislo = ?", array($oscislo));
    }
    
    public function vratUzivatele($id){
        return Db::dotazJeden("select * from uzivatele where id = ?", array($id));
    }

    public function zmenUzivatele($id, $jmeno, $email, $aktivni, $admin){
        return Db::dotazJeden("update uzivatele set jmeno = ?, email = ?, aktivni = ?, admin = ? where id = ?", array($jmeno, $email, $aktivni, $admin, $id));
    }

    public function vratInfoSapEan($ean){
        return Db::dotazJeden("SELECT * FROM sap WHERE ean = ?", array($ean));
    }
    
    public function vratInfoSapOra($ora){
        return Db::dotazJeden("SELECT * FROM sap WHERE ean = ?", array($this->ziskejEan($ora)));
    }
    
    public function vratPosledniZaznamy($pobocka){
        return Db::dotazVsechny("SELECT E.id, E.ean, E.imei, E.imei1, E.kusy, E.jmeno, E.text, E.datum, sap.zbozi FROM (SELECT Z.id as id, Z.ean as ean, Z.imei as imei, Z.imei1 as imei1, Z.kusy as kusy, U.jmeno as jmeno, Z.text as text, Z.datum as datum FROM zarizeni as Z, uzivatele as U WHERE Z.pobocka = ? AND Z.jmeno = U.oscislo order by Z.id desc LIMIT 10) as E LEFT JOIN sap on sap.ean = E.ean order by E.id desc", array($pobocka));
    }
    
    public function vratLogy($pobocka){
        return Db::dotazVsechny("select * from logy where pobocka = ?", array($pobocka));
    }
    
    public function vratVysledekInventura($pobocka){
        return Db::dotazVsechny("select D.ean, imei, imei1, zarKusy, invKusy, zbozi, model, popis, sapKusy, C.celkem, D.pobocka from (  select B.ean, B.imei, B.imei1, B.zarKusy, B.invKusy, zbozi, model, popis, sap.kusy as sapKusy, B.pobocka from ( select coalesce(A.ean, inventura.ean) as ean, imei, imei1, A.kusy as zarKusy, inventura.kusy as invKusy, A.pobocka from ( select ean, imei, imei1, sum(kusy) as kusy, pobocka from zarizeni where pobocka = ? and imei is null group by ean having sum(kusy) != 0  union  select ean, imei, imei1, kusy, pobocka from zarizeni where pobocka = ? and imei is not null group by imei having sum(kusy) != 0 ) as A left join inventura on A.ean = inventura.ean and A.pobocka = inventura.pobocka  union  select coalesce(A.ean, inventura.ean) as ean, imei, imei1, A.kusy as zarKusy, inventura.kusy as invKusy, A.pobocka from ( select ean, imei, imei1, sum(kusy) as kusy, pobocka from zarizeni where pobocka = ? and imei is null group by ean having sum(kusy) != 0  union  select ean, imei, imei1, kusy, pobocka from zarizeni where pobocka = ? and imei is not null group by imei having sum(kusy) != 0 ) as A right join inventura on A.ean = inventura.ean and A.pobocka = inventura.pobocka ) as B     left join sap on B.ean = sap.ean order by ean  ) as D  left join (select sum(kusy) as celkem, ean from zarizeni where imei is not null group by ean having sum(kusy) != 0) as C on D.ean = C.ean having D.pobocka = ?", array($pobocka, $pobocka, $pobocka, $pobocka, $pobocka));
    }
    
    public function ziskejNazevPobocky($pobocka){
        return Db::dotazJeden("select nazev from pobocky where id = ?", array($pobocka));
    }
    
    public function ziskejHesloPobocky($pobocka){
        return Db::dotazJeden("select heslo from pobocky where id = ?", array($pobocka));
    }
    
    public function ziskejVsechnyPobocky(){
        return Db::dotazVsechny("select * from pobocky");
    }
    
    public function ziskejVsechnaImei($ean, $pobocka){
        return Db::dotazVsechny("select imei, imei1, sum(kusy) from zarizeni where ean = ? and pobocka = ? group by imei having sum(kusy) != 0", array($ean, $pobocka));
    }
    
    public function vratVsechnaImei($ean, $pobocka){
        return Db::dotazVsechny('SELECT imei, imei1 FROM zarizeni WHERE ean = ? AND imei is not NULL AND pobocka = ?', array($ean, $pobocka));
    }

    public function jeDualsim($ora) {
        return Db::dotazJeden('SELECT dualsim FROM dualsim WHERE zbozi = ?', array($ora));
    }

    public function vratJmenoUzivatele($heslo) {
        return Db::dotazJeden('SELECT jmeno FROM uzivatele WHERE heslo = ?', array($heslo));
    }

    public function vratOscislo($heslo) {
        return Db::dotazJeden('SELECT oscislo FROM uzivatele WHERE heslo = ?', array($heslo));
    }

    public function jeImei1($imei, $pobocka) {
        return Db::dotazJeden('SELECT imei FROM zarizeni WHERE imei1 = ? AND imei IS NOT NULL AND pobocka = ?', array($imei, $pobocka));
    }

    public function jeImei0($imei, $pobocka) {
        return Db::dotazJeden('SELECT imei1 FROM zarizeni WHERE imei = ? AND imei1 IS NOT NULL AND pobocka = ?', array($imei, $pobocka));
    }

    public function zjistiHeslo($jmeno) {
        return Db::dotazJeden('SELECT heslo FROM uzivatele WHERE oscislo = ?', array($jmeno));
    }

    public function posledniZaznamZarizeni($pobocka) {
        return Db::dotazJeden('SELECT * FROM zarizeni WHERE pobocka = ? ORDER BY ID DESC LIMIT 1', array($pobocka));
    }
    
    public function celyZaznamZarizeni($id) {
        return Db::dotazJeden('SELECT * FROM zarizeni WHERE id = ? ORDER BY ID DESC LIMIT 1', array($id));
    }

    public function pridejUzivatele($udaje) {
        return Db::dotazJeden('INSERT INTO uzivatele (oscislo, jmeno, heslo, email, pobocka) VALUES (?, ?, ?, ?, ?)', array($udaje['oscislo'], $udaje['jmeno'], $udaje['heslo'], $udaje['email'], $udaje['pobocka']));
    }

    public function existujeAktivniHeslo($heslo) {
        return Db::dotazJeden('SELECT jmeno FROM uzivatele WHERE heslo = ? AND aktivni = 1', $heslo);
    }

    public function existenceHeslaUzivatele($heslo) {
        return Db::dotazJeden('SELECT oscislo FROM uzivatele WHERE heslo = ?', array($heslo));
    }

    public function existenceEmailuUzivatele($email) {
        return Db::dotazJeden('SELECT jmeno FROM uzivatele WHERE email = ?', $email);
    }

    public function existenceOscislaUzivatele($oscislo) {
        return Db::dotazJeden('SELECT * FROM uzivatele WHERE oscislo = ?', $oscislo);
    }

    public function prihlasAdmina($udaje) {
        return Db::dotazJeden('Select * FROM uzivatele WHERE oscislo = ? AND heslo = ? AND admin = 1', $udaje);
    }

    public function vypisVsechnyUzivatele($pobocka){
        return Db::dotazJeden('SELECT * FROM uzivatele WHERE pobocka = ? order by oscislo', array($pobocka));
    }
    
    public function vypisAktivniUzivatele($pobocka) {
        return Db::dotazVsechny('SELECT * FROM uzivatele WHERE aktivni = 1 AND pobocka = ?', array($pobocka));
    }

    public function jeUzivatelAktivni($oscislo) {
        return Db::dotazJeden('SELECT aktivni FROM uzivatele WHERE oscislo = ?', $oscislo);
    }

    public function deaktivujUzivatele($id) {
        return Db::dotazJeden('UPDATE uzivatele SET aktivni = 0 WHERE id = ?', $id);
    }

    public function aktivujUzivatele($oscislo) {
        return Db::dotazJeden('UPDATE uzivatele SET aktivni = 1 WHERE oscislo = ?', $oscislo);
    }

    public function zmenAktivujUzivatele($oscislo, $jmeno, $heslo, $email, $pobocka) {
        return Db::dotazJeden('UPDATE uzivatele SET oscislo = ? ,jmeno = ?, heslo = ?, email = ?, pobocka = ?, aktivni = 1 WHERE oscislo = ?', array($oscislo, $jmeno, $heslo, $email, $pobocka, $oscislo));
    }

    public function smazTabulkuSap() {
        return Db::dotazJeden('TRUNCATE TABLE sap');
    }

    public function smazTabulkuVystav() {
        return Db::dotazJeden('TRUNCATE TABLE vystav');
    }
    
    // to jsem kurva zvedavej, tak tohle bude fungovat
    public function pridejZaznam($ean, $imei, $imei1, $kusy, $jmeno, $text, $pobocka) {
        if (Db::vlozZaznam(
                        'INSERT INTO zarizeni (ean, imei, imei1, kusy, jmeno, text, pobocka) VALUES(?,?,?,?,?,?,?)', array($ean, $imei, $imei1, $kusy, $jmeno, $text, $pobocka)
                )) {
            return Db::dotazJeden('SELECT max(id) FROM zarizeni where pobocka = ?', array($pobocka));
        } else {
            return -1;
        }
    }

    public function pridejDoInventura($ean, $kusy, $pobocka) {
        return Db::vlozZaznam(
                        'INSERT INTO inventura (ean, kusy, pobocka) VALUES(?,?,?)', array($ean, $kusy, $pobocka)
        );
    }

    public function zmenVyresenoLog($id, $hodnota) {
        return Db::dotazJeden('update logy set vyreseno = ? where ID = ?', array($hodnota, $id));
    }

    public function pridejLog($text, $pobocka) {
        return Db::dotazJeden('INSERT into logy (text, pobocka) values (?, ?)', array($text, $pobocka));
    }

    public function vratSumuImei($imei, $pobocka) {
        return Db::dotazJeden('select sum(kusy) from zarizeni where imei = ? OR imei1 = ? AND pobocka = ?', array($imei, $imei, $pobocka));
    }

    public function jeVInventura($ean, $pobocka) {
        return Db::dotazJeden('select 1 from inventura where ? in (select ean from inventura where pobocka = ?)', array($ean, $pobocka));
    }

    public function zmenInventuru($ean, $hodnota, $pobocka) {
        return Db::dotazJeden('UPDATE inventura SET kusy = ? WHERE ean = ? AND pobocka = ?', array($hodnota, $ean, $pobocka));
    }

    public function zmenZarizeni($ean, $kusy, $pobocka) {
        return Db::dotazJeden('INSERT INTO zarizeni (ean, imei, kusy, jmeno, pobocka) VALUES(?, NULL, ?, "1", ?)', array($ean, $kusy, $pobocka));
    }

    public function ziskejOra($ean) {
        return Db::dotazJeden('SELECT zbozi FROM sap WHERE ean = ?', array($ean));
    }

    public function ziskejEan($ora) {
        return Db::dotazJeden('SELECT ean from sap WHERE zbozi = ?', array($ora));
    }

    public function zobrazZaznamyEAN($ean, $pobocka) {
        return Db::dotazVsechny('SELECT zarizeni.ID, imei, imei1, kusy, uzivatele.jmeno, zarizeni.text, zarizeni.datum FROM zarizeni, uzivatele WHERE ean = ? AND pobocka = ? AND uzivatele.oscislo = zarizeni.jmeno', array($ean, $pobocka));
    }

    public function zobrazZaznamyORA($ora, $pobocka) {
        $a = $this->ziskejEan($ora);
        return $this->zobrazZaznamyEAN($a['ean'], $pobocka);
    }

    /*public function zobrazInfo($ean) {
        return Db::dotazVsechny('SELECT * FROM zarizeni, sap WHERE zarizeni.? = sap.?', array($ean));
    }*/

    public function vratSumu($ean, $pobocka) {
        return Db::dotazJeden('SELECT SUM(kusy) FROM zarizeni WHERE ean = ? AND pobocka = ?', array($ean, $pobocka));
    }
    
    public function vratSumuDatum($ean, $pobocka, $datum){
        return Db::dotazJeden('SELECT SUM(kusy) FROM zarizeni WHERE ean = ? AND pobocka = ? AND datum < ?', array($ean, $pobocka, $datum));
    }

    public function vratSumuORA($ora, $pobocka) {
        $a = $this->ziskejEan($ora);
        return $this->vratSumu($a[0], $pobocka);
    }

    public function vratVsechno($dotaz) {
        return Db::dotazVsechny($dotaz);
    }

    
    // lepsi zamereni, zatim neupravene na pobocku!
    public function zobrazNevystavene() {
        return Db::dotazVsechny('select R.ean, R.zbozi, R.popis, R.model as item, R.zarKusy, R.sapKusy as sapKusy, vystav.kusy as vysKusy, vystav.skup from ( select sap.ean, model, zbozi, popis, sum(zarizeni.kusy) as zarKusy, sap.kusy as sapKusy from zarizeni left join sap on sap.ean = zarizeni.ean group by sap.ean ) as R left join vystav on R.zbozi = vystav.ora group by zbozi having vystav.kusy = 0');
    }

    public function zobrazNevystaveneSkupina($skupina) {
        return Db::dotazVsechny('select R.ean, R.zbozi, R.popis, R.model as item, R.zarKusy, R.sapKusy as sapKusy, vystav.kusy as vysKusy, vystav.skup from ( select sap.ean, model, zbozi, popis, sum(zarizeni.kusy) as zarKusy, sap.kusy as sapKusy from zarizeni left join sap on sap.ean = zarizeni.ean group by sap.ean ) as R left join vystav on R.zbozi = vystav.ora group by zbozi having vystav.kusy = 0 && vystav.skup LIKE ?', array($skupina));
    }

}