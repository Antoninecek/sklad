<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include 'PHPExcel.php';

/**
 * Description of InventuraKontroler
 *
 * @author František
 */
class InventuraKontroler extends Kontroler {

    protected $vysledek = "";
    protected $vysledek1 = "";
    protected $vysledek2 = "";
    protected $uploaded = "";
    private $opravaNacteno;
    private $opravaBezpecak;
    protected $stav;
    protected $zobrazitNuly;
    protected $zmenenePolozky = [];
    private $inventuraDatum;
    protected $iAktivni;

    public function zpracuj($params) {

        $parametr = empty($params[1]) ? NULL : $params[1];

        $iArray = parse_ini_file("inventura.ini");
        if (empty($iArray['iStop'])) {
            $this->iAktivni = TRUE;
        } else {
            $this->iAktivni = FALSE;
        }

        switch ($this->iAktivni ? $parametr : false) {
//            case "znovu":
//                $this->uploaded = true;
//                $this->zobrazitNuly = "hidden";
//                break;
            case "ukonci":
                $this->endInventuraConfig();
                $this->iAktivni = FALSE;
                break;
            case "aktualizace":
                $this->zmenenePolozky = $this->zmenvDB($this->opravaNacteno = $_POST['opravaNacteno'], $this->opravaBezpecak = $_POST['opravaBezpecak']);
                $this->zobrazitNuly = "hidden";
                break;
            case "zobraznuly":
                if ($params[2] == "hidden") {
                    $this->zobrazitNuly = "visible";
                } else {
                    $this->zobrazitNuly = "hidden";
                }

                break;
            default :
        }

        if (!$this->iAktivni && $parametr == "zahaj") {
            $this->uploaded = $this->upload();
            if ($this->uploaded) {
                $this->synchronizuj();
                $this->initInventuraConfig();
                $this->iAktivni = TRUE;
            }
            $this->zobrazitNuly = "hidden";
        }

        if ($this->iAktivni) {

            $spravceZaznamu = new SpravceZaznamu();

// je v inventure, neni v zarizeni
// select I.ean, I.kusy from zarizeni as Z, inventura as I where I.ean not in (select ean from zarizeni) group by I.ean
            //$vInZ = "select I.ean, I.kusy, S.model, S.zbozi from zarizeni as Z, inventura as I, sap as S where S.ean = I.ean and I.ean not in (select ean from zarizeni) group by I.ean";
            //$vInZ = "select inventura.ean, inventura.kusy, sap.model, sap.zbozi, sap.popis, sap.kusy from inventura left join sap on inventura.ean = sap.ean having inventura.ean not in (select ean from zarizeni) ";
            $vInZ = "select R.ean, model, zbozi, popis, sap.kusy as sapKusy, R.kusy as invKusy from (select ean, kusy from inventura where ean not in (select ean from zarizeni)) as R left join sap on R.ean = sap.ean having invKusy != 0";
            $this->vysledek = $spravceZaznamu->vratVsechno($vInZ);
            
// // je v zarizeni, neni v inventure
// select Z.ean, Z.kusy from zarizeni as Z, inventura as I where Z.ean not in (select ean from inventura) group by Z.ean 
            //$vZnI = "select zarizeni.ean, SUM(zarizeni.kusy) as zarKusy, sap.model, sap.zbozi as zbozi, sap.popis, sap.kusy as sapKusy from zarizeni, sap where zarizeni.ean not in (select ean from inventura) group by zarizeni.ean";
            $vZnI = "select R.ean, model, zbozi, popis, sap.kusy as sapKusy, R.kusy as zarKusy from (select ean, sum(kusy)as kusy from zarizeni where ean not in (select ean from inventura) group by ean) as R left join sap on R.ean = sap.ean having zarKusy != 0";
            $this->vysledek1 = $spravceZaznamu->vratVsechno($vZnI);
            
// rozdily inventura a zarizeni
//select Z.ean, (I.kusy - Z.kus) as rozdil from (select ean, sum(kusy) as kus from zarizeni group by ean) as Z, inventura as I where Z.ean = I.ean having rozdil != 0 
            //$rozdily = "select Z.ean, I.kusy as invKusy, Z.kus as zarKusy, S.model, S.zbozi, S.popis, S.kusy as sapKusy from (select ean, sum(kusy) as kus from zarizeni group by ean) as Z, inventura as I, sap as S where Z.ean = S.ean and Z.ean = I.ean having I.kusy != Z.kus ";
            $rozdily = "select R.invEan as ean, sap.zbozi, sap.popis, sap.model, sap.kusy as sapKusy, R.invKusy, R.zarKusy from (select inventura.ean as invEan, inventura.kusy as invKusy, Z.zarKusy as zarKusy from inventura join (select ean, sum(kusy) as zarKusy from zarizeni group by ean) as Z on inventura.ean = Z.ean) as R left join sap on R.invEan = sap.ean ";
            $this->vysledek2 = $spravceZaznamu->vratVsechno($rozdily);
            
            //print_r($this->vysledek);
//            print_r($this->vysledek1);
//            print_r($this->vysledek2);
            $exper = $this->vysledek1;
            foreach ($this->vysledek1 as $a){
                print_r($a['ean']);
                print_r($spravceZaznamu->vratVsechnaImei($a['ean']));
                print("<br>");
            }
            print_r($exper);
        }
        $this->pohled = "inventura";
        $this->titulekS = "inventura";
    }

    private function endInventuraConfig() {
        file_put_contents("inventura.ini", 'iStop = "' . date("Y-m-d g:i:s") . '"', FILE_APPEND);
    }

    private function initInventuraConfig() {
        file_put_contents("inventura.ini", 'iStart = "' . date("Y-m-d g:i:s") . "\"\n");
    }

    private function zmenvDB($list1, $list2) {
        $sz = new SpravceZaznamu();
        foreach ($list1 as $var => $val) {
            if ($sz->jeVInventura($var)) {
                $sz->zmenInventuru($var, $val);
            } else {
                $sz->pridejDoInventura($var, $val);
            }
        }

        foreach ($list2 as $var => $val) {
            $sumaDatum = $sz->vratSumuDatum($var, $this->inventuraDatum);
            $suma = $sz->vratSumu($var);
            if ($sumaDatum[0] != $suma[0]) {
                $zmenenePolozky[$var] = ($suma[0] - $sumaDatum[0]);
            } else {
                $sz->zmenZarizeni($var, $val - $suma[0]);
            }
        }

        return $zmenenePolozky;
    }

    private function upload() {
        $target_dir = "up/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
        if ($_FILES["fileToUpload"]["name"] != "trans.dat") {
            $uploadOk = 0;
        }
// Check if file already exists
        if (file_exists($target_file) && $_FILES["fileToUpload"]["name"] == "trans.dat") {
            //echo "Sorry, file already exists.";
            @unlink($target_file);
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
            //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                return true;
                //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                return false;
                //echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    private function synchronizuj() {
// nacist do db z csv
        $databasehost = DBHOST;
        $databasename = DATABASE;
        $databasetable = "inventura";
        $databaseusername = DBUSER;
        $databasepassword = DBPASS;
        $fieldseparator = "   ";
        $lineseparator = "\n";
        $csvfile = "up/trans.dat";


        if (!file_exists($csvfile)) {
            die("Soubor nenalezen, opravdu byl nahran? <a href='/projects/sklad/inventura'>zpatky</a>");
        }

        try {
            $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepassword, array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    )
            );
        } catch (PDOException $e) {
            die("database connection failed: " . $e->getMessage());
        }

        $pdo->exec("TRUNCATE TABLE inventura");

        $affectedRows = $pdo->exec("
      LOAD DATA LOCAL INFILE " . $pdo->quote($csvfile) . " INTO TABLE `$databasetable`
      FIELDS TERMINATED BY " . $pdo->quote($fieldseparator) . "
      LINES TERMINATED BY " . $pdo->quote($lineseparator));

        return $affectedRows;
    }

//put your code here
}
