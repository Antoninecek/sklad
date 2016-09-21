<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VystavKontroler
 *
 * @author František
 */
class VystavKontroler extends Kontroler {

    //put your code here

    protected $synchromessage = "";
    protected $uploaded = "";
    protected $nevystavene = array();
    private $skupina = "";

    //put your code here
    public function zpracuj($params) {

        switch (isset($params[1]) ? $params[1] : false) {
            case "znovu":
                $this->uploaded = true;
                break;
            case "zahaj":
                $this->uploaded = $this->upload();
                break;
            case "skupina":
                $this->uploaded = true;
                if (isset($params[2])) {
                    $this->skupina = $params[2];
                } else if (isset($_POST['skupinaInput'])) {
                    $this->skupina = strtoupper($_POST['skupinaInput']);
                }
                $this->skupina = $this->skupina . "%";
        }

        if ($this->uploaded && $this->skupina != "") {

            $sz = new SpravceZaznamu();
            $this->nevystavene = $sz->zobrazNevystaveneSkupina($this->skupina);
            $this->synchromessage = sizeof($this->nevystavene);
        } else if ($this->uploaded) {
            $this->synchronizuj();
            $sz = new SpravceZaznamu();
            $this->nevystavene = $sz->zobrazNevystavene();
            $this->synchromessage = sizeof($this->nevystavene);
            //print_r($this->nevystavene);
        }

        $this->pohled = "vystav";
        $this->titulekS = "vystav";
    }

    private function upload() {
        $target_dir = "up/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

        if ($_FILES["fileToUpload"]["name"] != "vystav.csv") {
            $uploadOk = 0;
        }
// Check if file already exists
        if (file_exists($target_file) && $_FILES["fileToUpload"]["name"] == "vystav.csv") {
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
        $databasehost = "localhost";
        $databasename = DATABASE;
        $databasetable = "vystav";
        $databaseusername = "root";
        $databasepassword = "";
        $fieldseparator = ";";
        $lineseparator = "\n";
        $csvfile = "up/vystav.csv";
        
        $sz = new SpravceZaznamu();
        $sz->smazTabulkuVystav();


        if (!file_exists($csvfile)) {
            die("Soubor nenalezen, opravdu byl nahran? <a href='/projects/sklad/vystav'>ZPET</a>");
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

        $affectedRows = $pdo->exec("
      LOAD DATA LOCAL INFILE " . $pdo->quote($csvfile) . " INTO TABLE `$databasetable`
      FIELDS TERMINATED BY " . $pdo->quote($fieldseparator) . "
      LINES TERMINATED BY " . $pdo->quote($lineseparator));

        return $affectedRows;
    }

}
