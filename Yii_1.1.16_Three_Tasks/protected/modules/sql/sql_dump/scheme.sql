CREATE TABLE service_group (
  service_group_id int(11) NOT NULL,
  service_group_name varchar(50) DEFAULT NULL,
  PRIMARY KEY (service_group_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE service (
  service_id int(11) NOT NULL AUTO_INCREMENT,
  service_group_id int(11) NOT NULL,
  service_name varchar(50) NOT NULL,
  PRIMARY KEY (service_id),
  INDEX service_group_id (service_group_id),
  CONSTRAINT FK_service_group_id FOREIGN KEY (service_group_id)
  REFERENCES service_group (service_group_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 7
AVG_ROW_LENGTH = 2730
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE billing (
  service_id int(11) DEFAULT NULL,
  abonent_id int(11) DEFAULT NULL,
  date date DEFAULT NULL,
  amount double DEFAULT NULL,
  INDEX abonent_id (abonent_id),
  INDEX date (date),
  INDEX service_id (service_id),
  INDEX serviceid_date (service_id, date),
  CONSTRAINT FK_service_id FOREIGN KEY (service_id)
  REFERENCES service (service_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 52
CHARACTER SET utf8
COLLATE utf8_general_ci;