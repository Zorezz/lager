CREATE DATABASE IF NOT EXISTS lagerdb;
CREATE TABLE IF NOT EXISTS lagerdb.lager (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(255),
	stock int,
	price int,
	cost int,
	manufacturer varchar(255),
	barcode varchar(100),
	PRIMARY KEY (id)
);

