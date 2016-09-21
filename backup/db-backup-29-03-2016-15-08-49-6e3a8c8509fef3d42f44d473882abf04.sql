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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO zarizeni VALUES("1","8806086692694","1103356","SAMI9195VEBLA","359353062445663","1","telefon","2016-03-29 10:34:31");
INSERT INTO zarizeni VALUES("2","8806086692694","1103356","SAMI9195VEBLA","359353062428677","1","telefon","2016-03-29 10:35:07");
INSERT INTO zarizeni VALUES("3","8806086692694","1103356","SAMI9195VEBLA","359353062445663","-1","telefon","2016-03-29 10:35:18");
INSERT INTO zarizeni VALUES("4","8806086278218","1096859","SAMG800FBL","355007074308046","1","telefon","2016-03-29 10:35:55");
INSERT INTO zarizeni VALUES("5","889955601995","1109079","IDEAPAD 305-15ABM","0","1","ntb","2016-03-29 10:36:23");
INSERT INTO zarizeni VALUES("6","889955601995","1109079","IDEAPAD 305-15ABM","0","10","ntb","2016-03-29 10:36:40");
INSERT INTO zarizeni VALUES("7","889955370686","1109075","IDEAPAD 100-15IBD","0","1","ntb","2016-03-29 10:36:59");
INSERT INTO zarizeni VALUES("8","889955370686","1109075","IDEAPAD 100-15IBD","0","-1","ntb","2016-03-29 10:37:06");



