CREATE TABLE info (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
DEFAULT CHARSET=utf8;

CREATE TABLE data (
  id int(11) NOT NULL AUTO_INCREMENT,
  info_id int(11) NOT NULL,
  date date NOT NULL,
  value int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_info_id FOREIGN KEY (info_id)
  REFERENCES info (id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
DEFAULT CHARSET=utf8;

-- Если подразумевается, что в "data" содержатся данные, связанные с "info" то делаем выборку JOINом по внешнему ключу "info_id":

SELECT info.*, data.id AS data_id, data.date, data.value FROM info
	LEFT JOIN data ON data.info_id = info.id;