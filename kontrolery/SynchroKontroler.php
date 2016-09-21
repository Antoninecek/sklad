<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SynchroKontroler
 *
 * @author František
 */
class SynchroKontroler extends Kontroler {

    protected $synchromessage = "";
    protected $uploaded = "";

    //put your code here
    public function zpracuj($params) {

        if (isset($_POST['submit'])) {

            $this->uploaded = $this->upload();

            if ($this->uploaded) {
                $this->synchromessage = $this->synchronizuj();
            }
        }

        $this->pohled = "synchro";
        $this->titulekS = "synchro";
    }

    private function upload() {
        $target_dir = "up/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
        
        if ($_FILES["fileToUpload"]["name"] != "sap.csv") {
            $uploadOk = 0;
        }
// Check if file already exists
        if (file_exists($target_file) && $_FILES["fileToUpload"]["name"]=="sap.csv") {
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
        $databasetable = "sap";
        $databaseusername = "root";
        $databasepassword = "";
        $fieldseparator = ";";
        $lineseparator = "\n";
        $csvfile = "up/sap.csv";

        $sz = new SpravceZaznamu();
        $sz->smazTabulkuSap();

        if (!file_exists($csvfile)) {
            die("File not found.");
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
