DROP TABLE zarizeni;

CREATE TABLE `zarizeni` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ean` bigint(20) NOT NULL,
  `ora` int(11) DEFAULT NULL,
  `item` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `imei` bigint(20) DEFAULT NULL,
  `kusy` int(11) NOT NULL DEFAULT '1',
  `jmeno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;




