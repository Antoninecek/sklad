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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO zarizeni VALUES("1","3","0","","0","1","d","2016-03-27 10:29:31");
INSERT INTO zarizeni VALUES("2","2147483647","0","","0","1","s","2016-03-27 13:07:50");
INSERT INTO zarizeni VALUES("3","4901780820672","0","","0","1","s","2016-03-27 13:10:21");
INSERT INTO zarizeni VALUES("4","33","0","","22","10","d","2016-03-27 14:43:28");
INSERT INTO zarizeni VALUES("5","6920702742241","0","","0","7","d","2016-03-27 14:48:00");
INSERT INTO zarizeni VALUES("6","3","0","","2","1","d","2016-03-27 15:15:39");
INSERT INTO zarizeni VALUES("7","3","0","","4","1","d","2016-03-27 15:15:45");
INSERT INTO zarizeni VALUES("8","3","0","","5","1","d","2016-03-27 15:15:49");
INSERT INTO zarizeni VALUES("9","3","0","","1","1","e","2016-03-27 15:17:45");
INSERT INTO zarizeni VALUES("10","3","0","","2","1","e","2016-03-27 15:19:27");
INSERT INTO zarizeni VALUES("11","3","0","","1","1","e","2016-03-27 15:19:36");
INSERT INTO zarizeni VALUES("12","3","0","","2","1","e","2016-03-27 15:20:29");
INSERT INTO zarizeni VALUES("13","3","0","","2","1","e","2016-03-27 15:21:09");
INSERT INTO zarizeni VALUES("14","3","0","","1","-1","e","2016-03-27 15:21:33");
INSERT INTO zarizeni VALUES("15","3","0","","1","-1","e","2016-03-27 15:21:45");
INSERT INTO zarizeni VALUES("16","4905524505597","","","0","1","jk","2016-03-27 17:01:10");
INSERT INTO zarizeni VALUES("17","3232","","","0","1","d","2016-03-27 17:06:17");
INSERT INTO zarizeni VALUES("18","3","","","0","1","d","2016-03-27 17:07:19");
INSERT INTO zarizeni VALUES("19","4905524505504","","","0","1","d","2016-03-27 17:08:10");
INSERT INTO zarizeni VALUES("20","4905524505504","","","0","1","d","2016-03-27 17:11:55");
INSERT INTO zarizeni VALUES("21","4905524505504","","","0","1","d","2016-03-27 17:13:01");
INSERT INTO zarizeni VALUES("22","4905524505504","","","0","1","d","2016-03-27 17:13:13");
INSERT INTO zarizeni VALUES("23","4905524505504","","","0","1","d","2016-03-27 17:14:20");
INSERT INTO zarizeni VALUES("24","4905524505504","","","0","1","d","2016-03-27 17:14:52");
INSERT INTO zarizeni VALUES("25","4905524505504","","","0","1","d","2016-03-27 17:23:28");
INSERT INTO zarizeni VALUES("26","4905524505504","","","0","1","d","2016-03-27 17:24:37");
INSERT INTO zarizeni VALUES("27","4905524505504","","","0","1","d","2016-03-27 17:25:38");
INSERT INTO zarizeni VALUES("28","4905524505504","","","0","1","d","2016-03-27 17:26:41");
INSERT INTO zarizeni VALUES("29","4905524505504","","","0","1","d","2016-03-27 17:28:37");
INSERT INTO zarizeni VALUES("30","4905524505504","1000017","KDL26U4000","0","1","d","2016-03-27 17:29:08");
INSERT INTO zarizeni VALUES("31","4901780820672","1000015","KV21CL10K","0","1","dfas","2016-03-27 19:16:14");



