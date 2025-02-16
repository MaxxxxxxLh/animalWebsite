CREATE TABLE Personne
(
  personneId INT NOT NULL,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  isAdmin boolean NOT NULL,
  PRIMARY KEY (personneId),
  UNIQUE (email)
);

CREATE TABLE EspèceAnimal
(
  animalId INT NOT NULL,
  nom VARCHAR(255) NOT NULL,
  age VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL,
  informations VARCHAR(255) NOT NULL,
  proprietaireId INT NOT NULL,
  PRIMARY KEY (animalId),
  FOREIGN KEY (proprietaireId) REFERENCES Personne(personneId)
);

CREATE TABLE Annonce
(
  annonceId INT NOT NULL,
  nom VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  service VARCHAR(255) NOT NULL,
  lieu VARCHAR(255) NOT NULL,
  personneId INT NOT NULL,
  animalId INT NOT NULL,
  PRIMARY KEY (annonceId),
  FOREIGN KEY (personneId) REFERENCES EspèceAnimal(animalId),
  FOREIGN KEY (animalId) REFERENCES Personne(personneId)
);

CREATE TABLE Messagerie
(
  message VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  isProprietaireMessage boolean NOT NULL,
  messageId INT NOT NULL,
  proprietaireId INT NOT NULL,
  personneId INT NOT NULL,
  PRIMARY KEY (messageId),
  FOREIGN KEY (proprietaireId) REFERENCES Personne(personneId),
  FOREIGN KEY (personneId) REFERENCES Personne(personneId)
);

CREATE TABLE AvisUtilisateur
(
  commentaire VARCHAR(255) NOT NULL,
  notes INT NOT NULL,
  date DATE NOT NULL,
  id INT NOT NULL,
  envoyeurId INT NOT NULL,
  receveurId INT NOT NULL,
  annonceId INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (envoyeurId) REFERENCES Personne(personneId),
  FOREIGN KEY (receveurId) REFERENCES Personne(personneId),
  FOREIGN KEY (annonceId) REFERENCES Annonce(annonceId)
);