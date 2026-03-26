-- =====================================================
-- BASE DE DONNÉES GSB - Galaxy Swiss Bourdin
-- Site web de présentation des médicaments et activités
-- =====================================================

DROP DATABASE IF EXISTS gsb_site;
CREATE DATABASE gsb_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gsb_site;

-- =====================================================
-- TABLE : medicaments
-- Stocke les médicaments fabriqués par GSB
-- =====================================================
CREATE TABLE medicaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    composition TEXT,
    forme VARCHAR(100) COMMENT 'Comprimé, gélule, sirop, etc.',
    prix DECIMAL(10,2),
    image VARCHAR(255),
    date_mise_marche DATE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLE : effets_therapeutiques
-- Effets thérapeutiques des médicaments
-- =====================================================
CREATE TABLE effets_therapeutiques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medicament INT NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (id_medicament) REFERENCES medicaments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLE : effets_secondaires
-- Effets secondaires / indésirables des médicaments
-- =====================================================
CREATE TABLE effets_secondaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medicament INT NOT NULL,
    description TEXT NOT NULL,
    gravite ENUM('faible', 'modere', 'grave') DEFAULT 'faible',
    FOREIGN KEY (id_medicament) REFERENCES medicaments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLE : interactions
-- Interactions entre médicaments
-- =====================================================
CREATE TABLE interactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medicament_1 INT NOT NULL,
    id_medicament_2 INT NOT NULL,
    description TEXT NOT NULL,
    niveau_risque ENUM('faible', 'modere', 'eleve', 'critique') DEFAULT 'modere',
    FOREIGN KEY (id_medicament_1) REFERENCES medicaments(id) ON DELETE CASCADE,
    FOREIGN KEY (id_medicament_2) REFERENCES medicaments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLE : activites
-- Activités complémentaires proposées par GSB
-- =====================================================
CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    date_activite DATE,
    lieu VARCHAR(200),
    places_max INT DEFAULT 0,
    places_restantes INT DEFAULT 0,
    image VARCHAR(255),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLE : inscriptions
-- Inscriptions des utilisateurs aux activités
-- =====================================================
CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_activite INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL,
    telephone VARCHAR(20),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_activite) REFERENCES activites(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- DONNÉES DE TEST : Médicaments
-- =====================================================
INSERT INTO medicaments (nom, description, composition, forme, prix, date_mise_marche) VALUES
('Doliprane 500mg', 'Antalgique et antipyrétique à base de paracétamol. Utilisé pour le traitement symptomatique des douleurs légères à modérées et des états fébriles.', 'Paracétamol 500mg, amidon de maïs, povidone, acide stéarique', 'Comprimé', 2.50, '2005-03-15'),
('Amoxicilline 1g', 'Antibiotique à large spectre de la famille des pénicillines. Utilisé pour traiter les infections bactériennes des voies respiratoires, urinaires et ORL.', 'Amoxicilline trihydratée 1g, stéarate de magnésium, cellulose microcristalline', 'Gélule', 5.80, '2008-06-20'),
('Ibuprofène 400mg', 'Anti-inflammatoire non stéroïdien (AINS). Indiqué dans le traitement des douleurs, de la fièvre et de l inflammation.', 'Ibuprofène 400mg, lactose, hypromellose, dioxyde de titane', 'Comprimé pelliculé', 3.20, '2010-01-10'),
('Ventoline 100µg', 'Bronchodilatateur bêta-2 agoniste de courte durée d action. Utilisé pour le traitement de la crise d asthme et la prévention de l asthme d effort.', 'Salbutamol sulfate 100µg/dose, propulseur HFA-134a', 'Suspension pour inhalation', 4.50, '2003-09-01'),
('Metformine 850mg', 'Antidiabétique oral de la famille des biguanides. Traitement du diabète de type 2, notamment chez les patients en surpoids.', 'Metformine chlorhydrate 850mg, povidone, stéarate de magnésium', 'Comprimé pelliculé', 4.10, '2007-11-25'),
('Oméprazole 20mg', 'Inhibiteur de la pompe à protons. Traitement du reflux gastro-oesophagien et des ulcères gastriques et duodénaux.', 'Oméprazole 20mg, saccharose, amidon de maïs, hydroxypropylcellulose', 'Gélule gastro-résistante', 3.90, '2006-04-12'),
('Lévothyrox 75µg', 'Hormone thyroïdienne de synthèse. Traitement des hypothyroïdies et prévention des rechutes après chirurgie thyroïdienne.', 'Lévothyroxine sodique 75µg, mannitol, acide citrique, gélatine', 'Comprimé sécable', 2.80, '2009-02-18'),
('Clopidogrel 75mg', 'Antiagrégant plaquettaire. Prévention des événements thrombotiques chez les patients atteints d athérosclérose.', 'Clopidogrel bisulfate 75mg, cellulose microcristalline, mannitol', 'Comprimé pelliculé', 8.50, '2011-07-30');

-- =====================================================
-- DONNÉES DE TEST : Effets thérapeutiques
-- =====================================================
INSERT INTO effets_therapeutiques (id_medicament, description) VALUES
(1, 'Réduction de la douleur légère à modérée (céphalées, douleurs dentaires, courbatures)'),
(1, 'Réduction de la fièvre (antipyrétique)'),
(2, 'Traitement des infections bactériennes des voies respiratoires (bronchite, pneumonie)'),
(2, 'Traitement des infections urinaires non compliquées'),
(2, 'Traitement des otites et sinusites'),
(3, 'Action anti-inflammatoire sur les douleurs articulaires et musculaires'),
(3, 'Effet antipyrétique (réduction de la fièvre)'),
(3, 'Soulagement des douleurs menstruelles'),
(4, 'Bronchodilatation rapide en cas de crise d asthme'),
(4, 'Prévention du bronchospasme induit par l effort'),
(5, 'Diminution de la glycémie à jeun et postprandiale'),
(5, 'Amélioration de la sensibilité à l insuline'),
(6, 'Réduction de la sécrétion acide gastrique'),
(6, 'Cicatrisation des ulcères gastriques et duodénaux'),
(7, 'Correction de l hypothyroïdie (rétablissement du métabolisme normal)'),
(8, 'Inhibition de l agrégation plaquettaire (prévention des caillots sanguins)');

-- =====================================================
-- DONNÉES DE TEST : Effets secondaires
-- =====================================================
INSERT INTO effets_secondaires (id_medicament, description, gravite) VALUES
(1, 'Réactions allergiques cutanées (rash, urticaire)', 'modere'),
(1, 'Toxicité hépatique en cas de surdosage', 'grave'),
(2, 'Diarrhées et troubles gastro-intestinaux', 'faible'),
(2, 'Réactions allergiques (éruption cutanée, choc anaphylactique possible)', 'grave'),
(2, 'Candidose buccale ou vaginale', 'faible'),
(3, 'Troubles gastro-intestinaux (douleurs abdominales, nausées)', 'modere'),
(3, 'Risque d ulcère gastrique en cas d utilisation prolongée', 'grave'),
(3, 'Vertiges et céphalées', 'faible'),
(4, 'Tremblements des extrémités', 'faible'),
(4, 'Tachycardie et palpitations', 'modere'),
(4, 'Céphalées', 'faible'),
(5, 'Troubles digestifs (nausées, diarrhées, douleurs abdominales)', 'faible'),
(5, 'Acidose lactique (rare mais grave)', 'grave'),
(6, 'Céphalées et vertiges', 'faible'),
(6, 'Troubles digestifs (nausées, diarrhées, constipation)', 'faible'),
(7, 'Tachycardie en cas de surdosage', 'modere'),
(7, 'Insomnie et nervosité', 'faible'),
(8, 'Saignements et hématomes', 'modere'),
(8, 'Troubles gastro-intestinaux', 'faible');

-- =====================================================
-- DONNÉES DE TEST : Interactions
-- =====================================================
INSERT INTO interactions (id_medicament_1, id_medicament_2, description, niveau_risque) VALUES
(1, 3, 'L association paracétamol-ibuprofène est possible mais doit être surveillée pour le risque hépatique et gastrique cumulé.', 'modere'),
(2, 8, 'L amoxicilline peut potentialiser l effet anticoagulant du clopidogrel, augmentant le risque de saignement.', 'eleve'),
(3, 8, 'L ibuprofène réduit l effet antiagrégant du clopidogrel, augmentant le risque thrombotique. Association déconseillée.', 'critique'),
(3, 5, 'L ibuprofène peut altérer la fonction rénale et affecter l élimination de la metformine. Surveillance rénale recommandée.', 'modere'),
(5, 6, 'Pas d interaction cliniquement significative connue. Association possible.', 'faible'),
(6, 7, 'L oméprazole peut diminuer l absorption de la lévothyroxine. Espacer les prises de 4 heures minimum.', 'modere');

-- =====================================================
-- DONNÉES DE TEST : Activités
-- =====================================================
INSERT INTO activites (nom, description, date_activite, lieu, places_max, places_restantes) VALUES
('Journée de sensibilisation au diabète', 'Conférence et ateliers sur la prévention et la gestion du diabète de type 2. Présentation des nouveaux traitements GSB et échanges avec des professionnels de santé.', '2026-05-15', 'Centre de congrès de Toulouse', 150, 120),
('Formation premiers secours', 'Formation certifiante PSC1 (Prévention et Secours Civiques de niveau 1). Apprenez les gestes qui sauvent avec des formateurs agréés.', '2026-04-20', 'Salle polyvalente GSB - Toulouse', 30, 22),
('Course solidaire GSB Run', 'Course de 5km et 10km au profit de la recherche médicale. Parcours accessible à tous les niveaux. T-shirt et ravitaillement offerts.', '2026-06-08', 'Parc de la Ramée, Toulouse', 500, 387),
('Atelier nutrition et bien-être', 'Séance interactive animée par des nutritionnistes sur l équilibre alimentaire et les compléments vitaminiques. Dégustation de produits bio incluse.', '2026-05-22', 'Espace Santé GSB - Toulouse', 40, 35),
('Conférence innovation pharmaceutique', 'Présentation des avancées en biotechnologie et en pharmacologie. Intervenants : chercheurs du laboratoire GSB et partenaires universitaires.', '2026-07-10', 'Amphithéâtre Université Paul Sabatier, Toulouse', 200, 178);
