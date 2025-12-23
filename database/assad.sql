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

INSERT INTO utilisateur (id_user, nom, prenom, email, password, role, statuse) VALUES
(5, 'aouni', 'ayoub', 'aouni@gmail.com', '$2y$10$KDnNj02nNGh9Fd/Qau8kCeVzVStCkCe8cGyEr.oWRw0nfldbbLBk.', 'visiteur', 'Activer'),
(6, 'cherkaoui', 'mehdi', 'mehdi@gamil.com', '$2y$10$OIMYPAbz/EqUiKNDzrIpsuGq9NS1238FwIyLyW.IyiaQwdj3nmp/i', 'guid', 'Activer'),
(7, 'ben chikhe', 'mohamed', 'mohamed@gmail.com', '$2y$10$K1Dl1UbcbA6e.WnfAg9S/unZ4qMUuI.5xDjdnyVlA1THuvS483BfO', 'visiteur', 'Activer');


INSERT INTO visitesguidees (id, titre, dateheure, langue, capacite_max, statut, duree, prix) VALUES
(3, 'Visite de la Médina de Fès', '2025-01-10 09:00:00', 'Français', 23, 'Active', '3 heures', '150'),
(4, 'Découverte de Marrakech historique', '2025-01-12 10:00:00', 'Français', 23, 'Active', '4 heures', '200'),
(5, 'Visite guidée de la Mosquée Hassan II', '2025-01-15 14:00:00', 'Français', 30, 'Active', '2 heures', '120'),
(6, 'Excursion dans la Kasbah d’Aït Ben Haddou', '2025-01-18 08:30:00', 'Français', 20, 'Active', '5 heures', '250'),
(7, 'Tour culturel de Chefchaouen', '2025-01-20 10:00:00', 'Espagnol', 10, 'Active', '3 heures', '180'),
(8, 'Visite du désert d’Agafay', '2025-01-22 16:00:00', 'Anglais', 20, 'Active', '4 heures', '300'),
(9, 'Découverte de la Médina de Rabat', '2025-01-25 09:30:00', 'Français', 25, 'Active', '2 heures', '100'),
(10, 'Visite guidée de Meknès et Volubilis', '2025-01-28 08:00:00', 'Français', 20, 'Active', '6 heures', '280'),
(11, 'Tour historique de Tanger', '2025-01-30 10:00:00', 'Anglais', 26, 'Active', '3 heures', '170');


INSERT INTO animaux (id, nomAnimal, espèce, alimentation, image, paysorigine, descriptioncourte, id_habitat) VALUES
(2, 'Lion', 'Panthera leo', 'Carnivore', 'https://images.unsplash.com/photo-1614027164847-1b28cfe1df60?q=80&w=800&auto=format&fit=crop', 'Afrique', 'Grand félin vivant en groupe, surnommé le roi de la savane', 1),
(3, 'Éléphant', 'Loxodonta africana', 'Herbivore', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQan1RgPcaOlW34pk7eAomBhdWRdo4kG15XTw&s', 'Afrique', 'Le plus grand mammifère terrestre connu', 1),
(4, 'Tigre', 'Panthera tigris', 'Carnivore', 'https://lumigny-safari-reserve.com/wp-content/uploads/2019/02/tigre-de-sumatra.webp', 'Inde', 'Félin solitaire et puissant aux rayures noires', 1),
(5, 'Panda', 'Ailuropoda melanoleuca', 'Herbivore', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuQUySxacYjEcDtUw7x6aNVbOvAuDlyiWrNg&s', 'Chine', 'Ours emblématique se nourrissant principalement de bambou', 3),
(6, 'Chameau', 'Camelus dromedarius', 'Herbivore', 'https://www.zoologiste.com/images/xl/chameau-tete.jpg', 'Afrique du Nord', 'Mammifère adapté aux conditions extrêmes du désert', 4),
(7, 'Dauphin', 'Delphinidae', 'Carnivore', 'https://www.cetaces.org/wp-content/uploads/2009/07/Dauphin-bleu-et-blanc-Sc108060.jpg', 'Océans', 'Mammifère marin très intelligent et sociable', 5),
(8, 'Requin', 'Selachimorpha', 'Carnivore', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSF1edlwTMlyemF26a_lU7CEBXirsXyyk5w3w&s', 'Océans', 'Grand prédateur marin au sens très développé', 5),
(9, 'Pingouin', 'Spheniscidae', 'Carnivore', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQs0TUlAryBYoDhTT5UXdwB8LC7Y32_Inzz-Q&s', 'Antarctique', 'Oiseau marin incapable de voler mais excellent nageur', 5);


