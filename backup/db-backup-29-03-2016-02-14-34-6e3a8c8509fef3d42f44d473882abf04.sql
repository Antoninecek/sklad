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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO zarizeni VALUES("1","6920702742241","1051808","HUAWEIG300BL","0","1","t","2016-03-29 00:56:29");
INSERT INTO zarizeni VALUES("2","6920702742241","1051808","HUAWEIG300BL","0","1","t","2016-03-29 00:56:32");
INSERT INTO zarizeni VALUES("3","6920702742241","1051808","HUAWEIG300BL","0","1","t","2016-03-29 00:56:38");
INSERT INTO zarizeni VALUES("4","6920702742241","1051808","HUAWEIG300BL","0","-1","t","2016-03-29 00:56:41");
INSERT INTO zarizeni VALUES("5","4","","","0","1","d","2016-03-29 00:57:35");
INSERT INTO zarizeni VALUES("6","11","","","1","1","telefon","2016-03-29 01:02:05");
INSERT INTO zarizeni VALUES("7","11","","","2","1","telefon","2016-03-29 01:02:08");
INSERT INTO zarizeni VALUES("8","11","","","1","-1","telefon","2016-03-29 01:02:11");
INSERT INTO zarizeni VALUES("9","6920702742241","1051808","HUAWEIG300BL","1","-1","telefon","2016-03-29 02:00:42");
INSERT INTO zarizeni VALUES("10","6920702742241","1051808","HUAWEIG300BL","1","1","telefon","2016-03-29 02:01:33");
INSERT INTO zarizeni VALUES("11","6920702742241","1051808","HUAWEIG300BL","1","-1","telefon","2016-03-29 02:02:30");
INSERT INTO zarizeni VALUES("12","6920702742241","1051808","HUAWEIG300BL","2","-1","telefon","2016-03-29 02:03:18");
INSERT INTO zarizeni VALUES("13","6920702742241","1051808","HUAWEIG300BL","2","-1","telefon","2016-03-29 02:03:22");
INSERT INTO zarizeni VALUES("14","6920702742241","1051808","HUAWEIG300BL","2","-1","telefon","2016-03-29 02:03:28");



