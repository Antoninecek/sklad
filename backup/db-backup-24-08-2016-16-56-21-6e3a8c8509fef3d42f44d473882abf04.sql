DROP TABLE zarizeni;

CREATE TABLE `zarizeni` (
  `ID` bigint(255) NOT NULL AUTO_INCREMENT,
  `ean` bigint(14) NOT NULL,
  `imei` bigint(16) DEFAULT NULL,
  `kusy` int(11) NOT NULL DEFAULT '1',
  `jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1250 COLLATE=cp1250_czech_cs;

INSERT INTO zarizeni VALUES("1","1234567890123","","-1","jednicka","2016-08-01 00:00:00");
INSERT INTO zarizeni VALUES("2","1234567890124","","-1","dvojka","2016-07-01 00:00:00");
INSERT INTO zarizeni VALUES("3","1234567890125","","-1","a","2016-08-18 09:32:49");
INSERT INTO zarizeni VALUES("4","1234567890125","","-1","jednicka a","2016-08-16 00:00:00");



