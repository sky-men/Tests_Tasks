CREATE TABLE orders (
  id int(11) NOT NULL AUTO_INCREMENT,
  shop_id int(11) NOT NULL,
  order_id bigint(20) NOT NULL,
  status varchar(20) NOT NULL,
  sum float NOT NULL,
  currency enum ('USD', 'EUR', 'RUB', 'UAH') NOT NULL,
  date datetime NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX shop_order (shop_id, order_id)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;