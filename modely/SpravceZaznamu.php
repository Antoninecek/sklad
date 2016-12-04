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
    
    public function vratVysledekInventura(){
        return Db::dotazVsechny("select D.ean, imei, imei1, zarKusy, invKusy, zbozi, model, popis, sapKusy, C.celkem from (  select B.ean, B.imei, B.imei1, B.zarKusy, B.invKusy, zbozi, model, popis, sap.kusy as sapKusy from ( select coalesce(A.ean, inventura.ean) as ean, imei, imei1, A.kusy as zarKusy, inventura.kusy as invKusy from ( select ean, imei, imei1, sum(kusy) as kusy from zarizeni where pobocka = 2017 and imei is null group by ean having sum(kusy) != 0  union  select ean, imei, imei1, kusy from zarizeni where pobocka = 2017 and imei is not null group by imei having sum(kusy) != 0 ) as A left join inventura on A.ean = inventura.ean  union  select coalesce(A.ean, inventura.ean) as ean, imei, imei1, A.kusy as zarKusy, inventura.kusy as invKusy from ( select ean, imei, imei1, sum(kusy) as kusy from zarizeni where pobocka = 2017 and imei is null group by ean having sum(kusy) != 0  union  select ean, imei, imei1, kusy from zarizeni where pobocka = 2017 and imei is not null group by imei having sum(kusy) != 0 ) as A right join inventura on A.ean = inventura.ean ) as B     left join sap on B.ean = sap.ean order by ean  ) as D  left join (select sum(kusy) as celkem, ean from zarizeni where imei is not null group by ean having sum(kusy) != 0) as C on D.ean = C.ean ");
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

    
    // opravit select z inventury na fucking pobocku
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
        return Db::dotazJeden('INSERT INTO zarizeni (ean, imei, kusy, jmeno) VALUES(?, NULL, ?, "1")', array($ean, $kusy));
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
    
    public function vratSumuDatum($ean, $datum){
        return Db::dotazJeden('SELECT SUM(kusy) FROM zarizeni WHERE ean = ? AND datum < ?', array($ean, $datum));
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