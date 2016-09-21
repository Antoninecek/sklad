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
    
    public function vratJmenoUzivatele($heslo){
        return Db::dotazJeden('SELECT jmeno FROM uzivatele WHERE heslo = ?', array($heslo));
    }
    
    public function vratOscislo($heslo){
        return Db::dotazJeden('SELECT oscislo FROM uzivatele WHERE heslo = ?', array($heslo));
    }
    
    public function jeImei1($imei){
        return Db::dotazJeden('SELECT imei FROM zarizeni WHERE imei1 = ? AND imei IS NOT NULL', array($imei));
    }
    
    public function jeImei0($imei){
        return Db::dotazJeden('SELECT imei1 FROM zarizeni WHERE imei = ? AND imei1 IS NOT NULL', array($imei));
    }
    
    public function zjistiHeslo($jmeno){
        return Db::dotazJeden('SELECT heslo FROM uzivatele WHERE jmeno = ?', array($jmeno));
    }
    
    public function posledniZaznamZarizeni(){
        return Db::dotazJeden('SELECT * FROM zarizeni ORDER BY ID DESC LIMIT 1');
    }

    public function pridejUzivatele($udaje) {
        return Db::dotazJeden('INSERT INTO uzivatele (oscislo, jmeno, heslo, email) VALUES (?, ?, ?, ?)', array($udaje['oscislo'], $udaje['jmeno'], $udaje['heslo'], $udaje['email']));
    }

    public function existujeAktivniHeslo($heslo){
        return Db::dotazJeden('SELECT jmeno FROM uzivatele WHERE heslo = ? AND aktivni = 1', $heslo);
    }
    
    public function existenceJmenaUzivatele($jmeno) {
        return Db::dotazJeden('SELECT jmeno FROM uzivatele WHERE jmeno = ?', $jmeno);
    }
    
    public function existenceHeslaUzivatele($heslo) {
        return Db::dotazJeden('SELECT oscislo FROM uzivatele WHERE heslo = ?', $heslo);
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

    public function vypisAktivniUzivatele() {
        return Db::dotazVsechny('SELECT * FROM uzivatele WHERE aktivni = 1');
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

    public function zmenAktivujUzivatele($oscislo, $jmeno, $heslo, $email) {
        return Db::dotazJeden('UPDATE uzivatele SET oscislo = ? ,jmeno = ?, heslo = ?, email = ?, aktivni = 1 WHERE oscislo = ?', array($oscislo, $jmeno, $heslo, $email, $oscislo));
    }

    public function smazTabulkuSap() {
        return Db::dotazJeden('TRUNCATE TABLE sap');
    }

    public function smazTabulkuVystav() {
        return Db::dotazJeden('TRUNCATE TABLE vystav');
    }

    public function pridejZaznam($ean, $imei, $imei1, $kusy, $jmeno, $text) {
        return Db::vlozZaznam(
                        'INSERT INTO zarizeni (ean, imei, imei1, kusy, jmeno, text) VALUES(?,?,?,?,?,?)', array($ean, $imei, $imei1, $kusy, $jmeno, $text)
        );
    }

    public function pridejDoInventura($ean, $kusy) {
        return Db::vlozZaznam(
                        'INSERT INTO inventura (ean, kusy) VALUES(?,?)', array($ean, $kusy)
        );
    }

    public function zmenVyresenoLog($id, $hodnota) {
        return Db::dotazJeden('update logy set vyreseno = ? where ID = ?', array($hodnota, $id));
    }

    public function pridejLog($text) {
        return Db::dotazJeden('INSERT into logy (text) values (?)', array($text));
    }

    public function vratSumuImei($imei) {
        return Db::dotazJeden('select sum(kusy) from zarizeni where imei = ? OR imei1 = ?', array($imei, $imei));
    }

    public function jeVInventura($ean) {
        return Db::dotazJeden('select 1 from inventura where ? in (select ean from inventura)', array($ean));
    }

    public function zmenInventuru($ean, $hodnota) {
        return Db::dotazJeden('UPDATE inventura SET kusy = ? WHERE ean = ?', array($hodnota, $ean));
    }

    public function zmenZarizeni($ean, $kusy) {
        return Db::dotazJeden('INSERT INTO zarizeni (ean, imei, kusy, jmeno) VALUES(?, NULL, ?, "inventura")', array($ean, $kusy));
    }

    public function ziskejOra($ean) {
        return Db::dotazJeden('SELECT zbozi FROM sap WHERE ean = ?', array($ean));
    }

    public function ziskejEan($ora) {
        return Db::dotazJeden('SELECT ean from sap WHERE zbozi = ?', array($ora));
    }

    public function zobrazZaznamyEAN($ean) {
        return Db::dotazVsechny('SELECT zarizeni.ID, imei, imei1, kusy, uzivatele.jmeno, zarizeni.text, zarizeni.datum FROM zarizeni, uzivatele WHERE ean = ? AND uzivatele.oscislo = zarizeni.jmeno', array($ean));
    }

    public function zobrazZaznamyORA($ora) {
        $a = $this->ziskejEan($ora);
        return $this->zobrazZaznamyEAN($a['ean']);
    }

    public function zobrazInfo($ean) {
        return Db::dotazVsechny('SELECT * FROM zarizeni, sap WHERE zarizeni.? = sap.?', array($ean));
    }

    public function vratSumu($ean) {
        return Db::dotazJeden('SELECT SUM(kusy) FROM zarizeni WHERE ean = ?', array($ean));
    }

    public function vratSumuORA($ora) {
        $a = $this->ziskejEan($ora);
        return $this->vratSumu($a[0]);
    }

    public function vratVsechno($dotaz) {
        return Db::dotazVsechny($dotaz);
    }

    public function zobrazNevystavene() {
        return Db::dotazVsechny('select R.ean, R.zbozi, R.popis, R.model as item, R.zarKusy, R.sapKusy as sapKusy, vystav.kusy as vysKusy, vystav.skup from ( select sap.ean, model, zbozi, popis, sum(zarizeni.kusy) as zarKusy, sap.kusy as sapKusy from zarizeni left join sap on sap.ean = zarizeni.ean group by sap.ean ) as R left join vystav on R.zbozi = vystav.ora group by zbozi having vystav.kusy = 0');
    }

    public function zobrazNevystaveneSkupina($skupina) {
        return Db::dotazVsechny('select R.ean, R.zbozi, R.popis, R.model as item, R.zarKusy, R.sapKusy as sapKusy, vystav.kusy as vysKusy, vystav.skup from ( select sap.ean, model, zbozi, popis, sum(zarizeni.kusy) as zarKusy, sap.kusy as sapKusy from zarizeni left join sap on sap.ean = zarizeni.ean group by sap.ean ) as R left join vystav on R.zbozi = vystav.ora group by zbozi having vystav.kusy = 0 && vystav.skup LIKE ?', array($skupina));
    }

}
