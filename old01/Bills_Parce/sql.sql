CREATE TABLE bills_ru_events (
  id int(11) NOT NULL AUTO_INCREMENT,
  date datetime NOT NULL,
  title varchar(230) NOT NULL,
  url varchar(240) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id (id),
  UNIQUE INDEX url (url)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;