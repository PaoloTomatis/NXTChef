CREATE TABLE users(
    id INT(11) AUTO_INCREMENT NOT NULL,
    username VARCHAR(40) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    psw VARCHAR(255) NOT NULL,
    verified BOOLEAN NOT NULL DEFAULT FALSE,
    privacy BOOLEAN NOT NULL DEFAULT FALSE,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE verifications(
    id INT(11) AUTO_INCREMENT NOT NULL,
    code VARCHAR(255) NOT NULL UNIQUE,
    idUser INT(11) NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users (id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE recipes(
    id INT(11) AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL,
    idUser INT(11) NOT NULL,
    tipo VARCHAR(55) NOT NULL,
    privacy BOOLEAN NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users (id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE steps(
    id INT(11) AUTO_INCREMENT NOT NULL,
    testo TEXT NOT NULL,
    nStep INT(11) NOT NULL DEFAULT 1,
    idRep INT(11) NOT NULL,
    FOREIGN KEY (idRep) REFERENCES recipes (id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE ingredients(
    id INT(11) AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE recipe_ingredients(
    id INT(11) AUTO_INCREMENT NOT NULL,
    idRep INT(11) NOT NULL,
    idIng INT(11) NOT NULL,
    quantity TEXT NOT NULL,
    FOREIGN KEY (idRep) REFERENCES recipes (id) ON DELETE CASCADE,
    FOREIGN KEY (idIng) REFERENCES ingredients (id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE saved(
    id INT(11) AUTO_INCREMENT NOT NULL,
    idUser INT(11) NOT NULL,
    idRep INT(11) NOT NULL,
    FOREIGN KEY (idRep) REFERENCES recipes (id) ON DELETE CASCADE,
    FOREIGN KEY (idUser) REFERENCES users (id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);