CREATE DATABASE assad;
USE assad;

CREATE TABLE admin(
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    emai VARCHAR(150),
    password VARCHAR(256)
);

CREATE TABLE utilisateur(
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    emai VARCHAR(150),
    password VARCHAR(256),
    role VARCHAR(50)
);

CREATE TABLE habitats(
    id_habitat INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    typeclimat VARCHAR(50),
    description VARCHAR(256),
    zonezoo VARCHAR(50)
);

CREATE TABLE animaux (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    espèce VARCHAR(100),
    alimentation VARCHAR(100),
    image VARCHAR(256),
    paysorigine VARCHAR(100),
    descriptioncourte VARCHAR(256),
    id_habitat INT,
    FOREIGN KEY (id_habitat) REFERENCES habitats(id_habitat)

);

CREATE TABLE visitesguidees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(100),
    dateheure DATE,
    langue VARCHAR(50),
    capacite_max INT,
    statut VARCHAR(50),
    duree VARCHAR(50),
    prix VARCHAR(50)
);

CREATE TABLE etapesvisite (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titreetape VARCHAR(100),
    descriptionetape VARCHAR(256),
    ordreetape INT,
    id_visite INT,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees(id)
);

CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idvisite INT,
    idutilisateur INT,
    nbpersonnes INT,
    datereservation DATE,
    FOREIGN KEY (idvisite) REFERENCES visitesguidees(id),
    FOREIGN KEY (idutilisateur) REFERENCES utilisateur(id_user)
);

CREATE TABLE commentaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idvisitesguides INT,
    idutilisateur INT,
    note VARCHAR(256),
    texte VARCHAR(256),
    date_commentaire DATE,
    FOREIGN KEY (idvisitesguides) REFERENCES visitesguidees(id),
    FOREIGN KEY (idutilisateur) REFERENCES utilisateur(id_user)
);
