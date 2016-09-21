DROP TABLE zarizeni;

CREATE TABLE `zarizeni` (
  `ID` bigint(255) NOT NULL AUTO_INCREMENT,
  `ean` bigint(14) NOT NULL,
  `imei` bigint(16) DEFAULT NULL,
  `imei1` bigint(16) DEFAULT NULL,
  `kusy` int(11) NOT NULL DEFAULT '1',
  `jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE cp1250_czech_cs,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1250 COLLATE=cp1250_czech_cs;

INSERT INTO zarizeni(ID,ean,imei,imei1,kusy,jmeno,text,datum) VALUES


