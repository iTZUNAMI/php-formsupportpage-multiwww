

CREATE TABLE cliente(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
nome VARCHAR(30), 
url VARCHAR(100)
);


CREATE TABLE email(
id INT NOT NULL, 
email VARCHAR(50)
);

CREATE TABLE cliente_form_$lastid(id_richiesta INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id_richiesta),data DATETIME, letto INT DEFAULT 0, cancella INT DEFAULT 0)



