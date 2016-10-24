<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('/../PHPMailer/class.phpmailer.php');

/**
 * Description of ZalohKontroler
 *
 * @author František
 */
class ZalohKontroler extends Kontroler {

    protected $message;
    protected $directory;

    public function zpracuj($params) {
        $this->message = @$this->backup_tables(DBHOST, DBUSER, DBPASS, DATABASE, "zarizeni");
        $this->pohled = "zaloha";
        $this->titulekS = "zaloha";
    }

    /* backup the db OR just a table */

    private function backup_tables($host, $user, $pass, $name, $tables = '*') {

        $link = mysql_connect($host, $user, $pass);
        //echo $link;
        mysql_select_db($name, $link);

        //get all of the tables
        if ($tables == '*') {
            $tables = array();
            $result = mysql_query('SHOW TABLES');
            while ($row = mysql_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        //cycle through
        foreach ($tables as $table) {
            $result = mysql_query('SELECT * FROM ' . $table);
            $num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE ' . $table . ';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
            $return.= "\n\n" . $row2[1] . ";\n\n";

            $return.= 'INSERT INTO ' . $table . '(ID,ean,imei,imei1,kusy,jmeno,text,datum) VALUES';
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return.= '(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
                    $return.= "),\n";
                }
            }
            $return.="\n\n\n";
        }

        //save file
        $file = 'backup/db-backup-' . date("d-m-Y") . '-' . date("H-i-s") . '-' . (md5(implode(',', $tables))) . '.sql';
        $handle = fopen($file, 'w+');
        fwrite($handle, $return);
        fclose($handle);
        //mail("frantisek.jukl@gmail.com", "zaloha", $file);
        // mail it
        /*
          $file_to_attach = $file;

          $email = new PHPMailer();
          $email->From = 'zaloha@example.com';
          $email->FromName = 'zalohovani';
          $email->Subject = 'zalozicka';
          $email->Body = $file_to_attach;
          $email->AddAddress('frantisek.jukl@gmail.com');



          $email->AddAttachment($file_to_attach, 'cosi.sql');

          $email->Send();
         */


        if (!$handle) {
            return false;
        } else {

            // pocet filu

            $this->directory = $_SERVER['DOCUMENT_ROOT'] . PATHBASE . "backup/";
            $filecount = 0;
            $files = glob($this->directory . "*");
            if ($files) {
                $filecount = count($files);
            }
            //echo "There were $filecount files";
            if ($filecount > 20) {
                $files = glob($this->directory."*.*");

// Sort files by modified time, latest to earliest
// Use SORT_ASC in place of SORT_DESC for earliest to latest
                array_multisort(
                        array_map('filemtime', $files), SORT_NUMERIC, SORT_ASC, $files
                );

                unlink($files[0]);
                //echo $files[0]; // the latest modified file should be the first.
            }
            
            $this->directory = $_SERVER['DOCUMENT_ROOT'] . PATHBASE;
            return $file;
        }
    }

//put your code here
}
