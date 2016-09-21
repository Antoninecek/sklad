DROP TABLE zarizeni;

CREATE TABLE `zarizeni` (
  `ID` bigint(255) NOT NULL AUTO_INCREMENT,
  `ean` bigint(14) NOT NULL,
  `imei` bigint(16) DEFAULT NULL,
  `kusy` int(11) NOT NULL DEFAULT '1',
  `jmeno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO zarizeni VALUES("1","4901780820672","","1","s","2016-06-03 15:59:27");
INSERT INTO zarizeni VALUES("2","4901780820672","","2","s","2016-06-03 15:59:34");
INSERT INTO zarizeni VALUES("3","4901780820672","","-1","s","2016-06-03 15:59:37");
INSERT INTO zarizeni VALUES("4","4905524505504","49055245055044","1","a","2016-06-03 16:50:36");
INSERT INTO zarizeni VALUES("5","4905524505504","49055245055044","-1","s","2016-06-03 16:51:00");
INSERT INTO zarizeni VALUES("6","8806086692694","","1","s","2016-06-03 17:21:16");
INSERT INTO zarizeni VALUES("7","889955601995","","14","s","2016-06-03 17:21:37");
INSERT INTO zarizeni VALUES("8","4905524511307","","-1","s","2016-06-03 17:27:44");



