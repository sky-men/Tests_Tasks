-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

--
-- Описание для таблицы users
--
CREATE TABLE users (
  uid INT(11) NOT NULL AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  PRIMARY KEY (uid),
  UNIQUE INDEX email (email)
)
ENGINE = INNODB
AUTO_INCREMENT = 17
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(16, 'gmail.com@0mEb7BtGuwU+vZBgg8R3ssuguPUt7H0MywCBWl1oND8='),
(14, 'gmail.com@lx/ywkFKCI7xYaQFH0cbnE/IKBiZ22tPpJ2R0eAjsfU='),
(15, 'mail.ru@O8PIZe/QcdyfDPeAZx6NqydUJ4XJSi03hzJ8SlsR54o=');