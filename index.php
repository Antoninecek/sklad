<?php

if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
    define("COOKIENAME", "pobocka");
    define("SERVERURL", "127.0.0.1:8080");
    define("DATABASE", "sklad_db_jednodussi_n");
    define("DBHOST", "127.0.0.1");
    define("DBUSER", "root");
    define("DBPASS", "");
    define("PATHBASE", "/sklad_new/sklad/");
    define("PATHEMPTYURL", "sklad_new/sklad/pridej");
    define("PATHERR", "sklad_new/sklad/chyba");
    define("PATHSETPOBOCKA", "sklad_new/sklad/pobocka");
    $phpver = phpversion();
} else {
    define("COOKIENAME", "pobocka");
    $phpver = phpversion();
    define("SERVERURL", "nay2.sk");
    define("DATABASE", "nay2");
    define("DBHOST", "mysql5.nic.sk");
    define("DBUSER", "nay2");
    define("DBPASS", "cNe874p");
    define("PATHBASE", "/sklad_new/sklad/");
    define("PATHEMPTYURL", "sklad_new/sklad/pridej");
    define("PATHERR", "sklad_new/sklad/chyba");
    define("PATHSETPOBOCKA", "sklad_new/sklad/pobocka");
}

function parseVersion($phpver) {
    $arr = explode('.', $phpver);
    if (intval($arr[0]) >= 5) {
        if (intval($arr[1]) >= 5) {
            if (intval($arr[2]) >= 8) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

if (parseVersion($phpver)) {

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
} else {
    print_r($phpver);
    echo "<br>";
    echo "must have 5.5.8 or higher";
}
?>