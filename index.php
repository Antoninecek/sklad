<?php

if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
    define("DATABASE", "sklad_db_jednodussi_n");
    define("DBHOST", "127.0.0.1");
    define("DBUSER", "root");
    define("DBPASS", "");
    define("PATHBASE", "/sklad_new/sklad/");
    define("PATHEMPTYURL", "sklad_new/sklad/pridej");
    define("PATHERR", "sklad_new/sklad/chyba");
} else {
    define("DATABASE", "skladdbjednodussi");
    define("DBHOST", "localhost");
    define("DBUSER", "fannyjukl");
    define("DBPASS", "frantisek");
    define("PATHEMPTYURL", "projects/sklad/pridej");
    define("PATHERR", "projects/sklad/chyba");
}

function autoloadFunkce($trida) {
    if (preg_match("/Kontroler$/", $trida)) {
        require("kontrolery/" . $trida . ".php");
    } else {
        require("modely/" . $trida . ".php");
    }
}

session_start();


spl_autoload_register("autoloadFunkce");

Db::pripoj(DBHOST, DBUSER, DBPASS, DATABASE);

$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
$smerovac->vypisPohled();
?>