CREATE DATABASE  IF NOT EXISTS `quintab_esercizio5`;
USE `quintab_esercizio5`; 
CREATE TABLE `credenziali` (
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `patente` varchar(45) NOT NULL,
  PRIMARY KEY (`email`)
);