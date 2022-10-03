CREATE TABLE mtgUsers (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(80) UNIQUE, password VARCHAR(80));

CREATE TABLE mtgCards (
                      id INT PRIMARY KEY AUTO_INCREMENT,
                      name VARCHAR(80),
                      url VARCHAR(80),
                      ownerId INT REFERENCES mtgUsers (id)
);

