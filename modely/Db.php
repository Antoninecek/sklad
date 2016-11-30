<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 *
 * @author F@nny
 */
class Db {

    //put your code here

    private static $spojeni;
    private static $nastaveni = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function pripoj($host, $uzivatel, $heslo, $databaze) {
        try {
            if (!isset(self::$spojeni)) {
                self::$spojeni = @new PDO(
                        "mysql:host=$host;dbname=$databaze", $uzivatel, $heslo, self::$nastaveni
                );
            }
        } catch (PDOException $e) {
            exit('Database error<br>Probiha neplanovana odstavka serveru, snad se to samo opravi.');
        }
        //print_r(self::$spojeni->getAttribute(PDO::ATTR_SERVER_INFO));
    }

    public static function vlozZaznam($dotaz, $parametry = array()) {
        $vloz = self::$spojeni->prepare($dotaz);
        $res = $vloz->execute($parametry);
        return $res;
    }

    public static function dotazJeden($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    public static function dotazVsechny($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    public static function dotazSamotny($dotaz, $parametry = array()) {
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek[0];
    }

    public static function dotaz($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->rowCount();
    }

}
