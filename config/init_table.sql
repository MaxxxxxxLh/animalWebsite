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

CREATE TABLE Conversation (
  conversationId INT NOT NULL AUTO_INCREMENT,
  personne1Id INT NOT NULL,
  personne2Id INT NOT NULL,
  createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (conversationId),
  FOREIGN KEY (personne1Id) REFERENCES Personne(personneId),
  FOREIGN KEY (personne2Id) REFERENCES Personne(personneId)
);

CREATE TABLE Message (
  messageId INT NOT NULL AUTO_INCREMENT,
  conversationId INT NOT NULL,
  senderId INT NOT NULL,
  content TEXT NOT NULL,
  sentAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  isRead TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (messageId),
  FOREIGN KEY (conversationId) REFERENCES Conversation(conversationId),
  FOREIGN KEY (senderId) REFERENCES Personne(personneId)
);

CREATE TABLE AvisUtilisateur
(
  id INT NOT NULL AUTO_INCREMENT,
  commentaire VARCHAR(255) NOT NULL,
  notes INT NOT NULL,
  date DATE NOT NULL DEFAULT CURRENT_DATE,
  envoyeurId INT NOT NULL,
  receveurId INT NOT NULL,
  annonceId INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (envoyeurId) REFERENCES Personne(personneId),
  FOREIGN KEY (receveurId) REFERENCES Personne(personneId),
  FOREIGN KEY (annonceId) REFERENCES Annonce(annonceId)
);

CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    expires DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
