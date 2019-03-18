CREATE TABLE `statistics` (
  `date` date NOT NULL,
  `country` varchar(2) NOT NULL,
  `event` enum('view','play','click','') NOT NULL,
  `counter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`date`,`country`,`event`),
  KEY `counter` (`counter`),
  KEY `event` (`event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


LOCK TABLES `statistics` WRITE;

INSERT INTO `statistics` (`date`, `country`, `event`, `counter`) VALUES ('2018-09-13','US','view',5),('2018-09-12','US','play',10),('2017-07-02','CA','click',50),('2017-07-01','US','play',100),('2018-09-11','US','click',100),('2018-09-12','CA','click',123),('2017-07-15','FR','view',150),('2018-09-11','CA','view',200),('2017-07-02','US','view',3000),('2017-07-01','US','view',50000);

UNLOCK TABLES;