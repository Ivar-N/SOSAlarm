CREATE DATABASE sos_database;

USE sos_database;

CREATE TABLE sos_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    header VARCHAR(10),
    properties VARCHAR(10),
    length INT,
    sequence_id INT,
    message_body TEXT
);
