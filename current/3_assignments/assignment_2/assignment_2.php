<?php
/**
 * Assignment #2
 * These are the tables structures of the tables:
 *
 * 
 CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `status` enum('forwarded','pending','authorised') DEFAULT NULL,
  `totalPrice` int(11) DEFAULT NULL,
  `methodID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
 *
 *  
 CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
 *
 *
 *
 *
 * Make a backend script, select all payments for user "Henk"
 * Output should be something like this:
 * <payment.id>   <user.firstname> <user.lastname>    <payment.totalPrice>     <payment.status>    <payment.methodID>
 *
 *
 */

require_once 'db.php';

$rows = query('SELECT
                 payment.*,
                 user.firstname, user.lastname
               FROM payment
               LEFT JOIN user ON user.id = payment.userID
               WHERE userID = 1
               LIMIT 100');

foreach ($rows as $value)
    echo "$value[id] | $value[firstname] $value[lastname] | $value[totalPrice] | $value[status] |  $value[methodID] <br><br>";