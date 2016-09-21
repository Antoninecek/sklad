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

INSERT INTO zarizeni(ID,ean,imei,imei1,kusy,jmeno,text,datum) VALUES("1","1234567890124","123456789012411","123456789012418","1","a","","2016-08-28 01:28:41"),
("2","1234567890124","123456789012411","123456789012418","-1","a","oprava zaznamu","2016-08-28 01:28:47"),
("3","1234567890124","123456789012419","","-1","a","a","2016-08-28 01:29:04"),
("4","1234567890124","123456789012419","","1","a","a oprava zaznamu","2016-08-28 01:29:10"),
("5","1234567890124","123456789012413","123456789012410","1","a","","2016-08-28 01:29:30"),
("6","1234567890124","123456789012413","123456789012410","-1","a","","2016-08-28 01:29:47"),



