CREATE DATABASE IF NOT EXISTS site_db;
USE `site_db`;

CREATE TABLE Personne
(
  personneId INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255),
  prenom VARCHAR(255),
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  isAdmin TINYINT(1) NOT NULL,
  photoUrl VARCHAR(255),
  PRIMARY KEY (personneId),
  UNIQUE (email)
);

CREATE TABLE EspeceAnimal
(
  animalId INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  age INT NOT NULL,  
  type VARCHAR(255) NOT NULL,
  informations VARCHAR(255) NOT NULL,
  proprietaireId INT NOT NULL,
  PRIMARY KEY (animalId),
  FOREIGN KEY (proprietaireId) REFERENCES Personne(personneId)
);

CREATE TABLE Annonce
(
  annonceId INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  service VARCHAR(255) NOT NULL,
  lieu VARCHAR(255) NOT NULL,
  tarif INT NOT NULL,
  description VARCHAR(255) NOT NULL,
  personneId INT NOT NULL,
  animalId INT NOT NULL,
  PRIMARY KEY (annonceId),
  FOREIGN KEY (personneId) REFERENCES Personne(personneId),
  FOREIGN KEY (animalId) REFERENCES EspeceAnimal(animalId)
);

CREATE TABLE Messagerie
(
  messageId INT NOT NULL AUTO_INCREMENT,
  message VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  isProprietaireMessage TINYINT(1) NOT NULL,
  proprietaireId INT NOT NULL,
  personneId INT NOT NULL,
  PRIMARY KEY (messageId),
  FOREIGN KEY (proprietaireId) REFERENCES Personne(personneId),
  FOREIGN KEY (personneId) REFERENCES Personne(personneId)
);

CREATE TABLE AvisUtilisateur
(
  id INT NOT NULL AUTO_INCREMENT,
  commentaire VARCHAR(255) NOT NULL,
  notes INT NOT NULL,
  date DATE NOT NULL,
  envoyeurId INT NOT NULL,
  receveurId INT NOT NULL,
  annonceId INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (envoyeurId) REFERENCES Personne(personneId),
  FOREIGN KEY (receveurId) REFERENCES Personne(personneId),
  FOREIGN KEY (annonceId) REFERENCES Annonce(annonceId)
);
