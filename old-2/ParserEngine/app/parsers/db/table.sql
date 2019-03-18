CREATE TABLE rutracker (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  body text NOT NULL,
  url_hash varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX hash (url_hash)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
ROW_FORMAT = DYNAMIC;