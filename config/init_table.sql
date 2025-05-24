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


-- Insertion dans Personne
INSERT INTO Personne (nom, prenom, email, password, isAdmin, photoUrl) VALUES
('Dupont', 'Alice', 'alice.dupont@example.com', 'password1', 0, 'https://example.com/photos/alice.jpg'),
('Martin', 'Bob', 'bob.martin@example.com', 'password2', 0, 'https://example.com/photos/bob.jpg'),
('Durand', 'Claire', 'claire.durand@example.com', 'password3', 1, 'https://example.com/photos/claire.jpg');

-- Insertion dans EspeceAnimal
INSERT INTO EspeceAnimal (nom, age, type, informations, proprietaireId) VALUES
('Milo', 3, 'Chien', 'Chihuahua joueur', 1),
('Whiskers', 5, 'Chat', 'Calme et affectueux', 2),
('Bella', 2, 'Chien', 'Golden Retriever énergique', 1);

-- Insertion dans Annonce
INSERT INTO Annonce (nom, date, service, lieu, tarif, description, personneId, animalId) VALUES
('Gardiennage Milo', '2025-05-15', 'Gardiennage', 'Paris', 20, 'Garde à domicile pour Milo', 1, 1),
('Promenade Whiskers', '2025-05-16', 'Promenade', 'Lyon', 15, 'Sortie quotidienne pour Whiskers', 2, 2),
('Gardiennage Bella', '2025-05-17', 'Gardiennage', 'Paris', 25, 'Gardiennage pour Bella pendant les vacances', 1, 3);

-- Insertion dans Messagerie
INSERT INTO Messagerie (message, date, isProprietaireMessage, proprietaireId, personneId) VALUES
('Bonjour, je suis intéressé par la garde de Milo.', '2025-05-01', 0, 1, 2),
('Merci pour votre message, je confirme la disponibilité.', '2025-05-02', 1, 1, 2),
('Pouvez-vous me donner plus d\'infos sur Whiskers?', '2025-05-03', 0, 2, 3);

-- Insertion dans AvisUtilisateur
INSERT INTO AvisUtilisateur (commentaire, notes, date, envoyeurId, receveurId, annonceId) VALUES
('Très bon service, Milo était content.', 5, '2025-05-20', 2, 1, 1),
('Bob est très sérieux et attentionné.', 4, '2025-05-21', 3, 2, 2),
('Claire est super sympa, je recommande.', 5, '2025-05-22', 1, 3, 3);