DROP DATABASE IF EXISTS TODO_LIST;
CREATE DATABASE TODO_LIST;
USE TODO_LIST;

CREATE TABLE TODO_DATA(
	DATA_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	DATA_NAME VARCHAR(45) NOT NULL UNIQUE,
    DATA_DATE DATETIME NOT NULL DEFAULT NOW(),
    DATA_STATUS BOOLEAN NOT NULL DEFAULT FALSE,
    DATA_RESPONSIBLE VARCHAR(45) NOT NULL
);

INSERT INTO TODO_DATA(DATA_NAME,DATA_RESPONSIBLE) 
VALUES ('varrer a casa','Guilherme'), ('ir a merda','Guilherme'), ('lavar os pratos','Guilherme'), 
('estudar','Guilherme'), ('hello world','Guilherme');