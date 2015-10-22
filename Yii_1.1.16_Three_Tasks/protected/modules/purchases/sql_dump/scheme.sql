CREATE TABLE purchases (
  ts_day_start int(11) NOT NULL,
  pm_id int(11) NOT NULL,
  price int(11) NOT NULL,
  a_count int(11) NOT NULL,
  INDEX ts_day_start (ts_day_start)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 46
CHARACTER SET utf8
COLLATE utf8_general_ci;