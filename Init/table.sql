CREATE TABLE IF NOT EXISTS test (
  id INT NOT NULL AUTO_INCREMENT ,
  script_name VARCHAR(25) NOT NULL ,
  start_time INT NOT NULL ,
  end_time INT NOT NULL ,
  result ENUM('normal','illegal','failed','success') NOT NULL ,
  PRIMARY KEY (id),
  INDEX(result)
  );