-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 24 jan. 2021 à 18:42
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bddphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `appareil`
--

DROP TABLE IF EXISTS `appareil`;
CREATE TABLE IF NOT EXISTS `appareil` (
  `Id_Appareil` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `conso_par_h` int(11) DEFAULT NULL,
  `emission_par_h` varchar(50) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `Id_Type_appareil` int(11) NOT NULL,
  PRIMARY KEY (`Id_Appareil`),
  KEY `Id_Type_appareil` (`Id_Type_appareil`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `appareil`
--

INSERT INTO `appareil` (`Id_Appareil`, `description`, `conso_par_h`, `emission_par_h`, `libelle`, `Id_Type_appareil`) VALUES
(22, 'en face de la porte ', 4, NULL, 'refrigerateur', 1),
(23, 'devant le lit', 3, NULL, 'TÃ©lÃ©vision', 1),
(21, 'sur la table de nuit', 1, NULL, 'reveil', 1),
(20, 'quand on entre a gauche', 3, '1', 'gaziniÃ¨re', 3),
(24, 'au nord de la douche', 6, NULL, 'Chauffage', 1),
(25, 'zerty', 1, NULL, 'zerty', 4);

-- --------------------------------------------------------

--
-- Structure de la table `appartement`
--

DROP TABLE IF EXISTS `appartement`;
CREATE TABLE IF NOT EXISTS `appartement` (
  `Id_Appartement` int(11) NOT NULL AUTO_INCREMENT,
  `degre_de_secu` int(11) DEFAULT NULL,
  `piece` varchar(50) DEFAULT NULL,
  `Id_Maison` int(11) NOT NULL,
  `Id_type_appart` int(11) NOT NULL,
  `Id_Personne` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`Id_Appartement`),
  KEY `Id_Maison` (`Id_Maison`),
  KEY `Id_type_appart` (`Id_type_appart`),
  KEY `Id_Personne` (`Id_Personne`),
  KEY `date_debut` (`date_debut`,`date_fin`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `appartement`
--

INSERT INTO `appartement` (`Id_Appartement`, `degre_de_secu`, `piece`, `Id_Maison`, `Id_type_appart`, `Id_Personne`, `date_debut`, `date_fin`) VALUES
(1, 2, '2', 1, 0, 1, '2021-01-11', '2021-01-21'),
(3, 3, '5', 1, 0, 2, '2020-12-28', '2020-12-28'),
(4, 3, '2', 2, 0, 2, '2021-01-01', '2021-01-01'),
(5, 2, '5', 2, 0, 3, '2020-12-15', '2020-12-15');

-- --------------------------------------------------------

--
-- Structure de la table `appartient_piece`
--

DROP TABLE IF EXISTS `appartient_piece`;
CREATE TABLE IF NOT EXISTS `appartient_piece` (
  `Id_Piece` int(11) NOT NULL,
  `Id_Appareil` int(11) NOT NULL,
  PRIMARY KEY (`Id_Piece`,`Id_Appareil`),
  KEY `Id_Appareil` (`Id_Appareil`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `appartient_piece`
--

INSERT INTO `appartient_piece` (`Id_Piece`, `Id_Appareil`) VALUES
(6, 20),
(6, 22),
(7, 21),
(9, 23),
(10, 24),
(10, 25);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `Id_Compte` int(11) NOT NULL AUTO_INCREMENT,
  `date_creation` date DEFAULT NULL,
  `etat` tinyint(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `motdepasse` varchar(50) DEFAULT NULL,
  `Id_Personne` int(11) NOT NULL,
  PRIMARY KEY (`Id_Compte`),
  UNIQUE KEY `Id_Personne` (`Id_Personne`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`Id_Compte`, `date_creation`, `etat`, `email`, `motdepasse`, `Id_Personne`) VALUES
(1, '2021-01-22', 1, 'trampauline@gmail.com', '940c0f26fd5a30775bb1cbd1f6840398d39bb813', 1),
(2, '2021-01-24', 0, 'jeandupond@gmail.com', '81fe8bfe87576c3ecb22426f8e57847382917acf', 2),
(3, '2021-01-24', 0, 'albert@gmail.com', 'fb2f85c88567f3c8ce9b799c7c54642d0c7b41f6', 3);

-- --------------------------------------------------------

--
-- Structure de la table `consomme`
--

DROP TABLE IF EXISTS `consomme`;
CREATE TABLE IF NOT EXISTS `consomme` (
  `Id_Appareil` int(11) NOT NULL,
  `Id_Ressources` int(11) NOT NULL,
  `Consommation_par_h` double DEFAULT NULL,
  PRIMARY KEY (`Id_Appareil`,`Id_Ressources`),
  KEY `Id_Ressources` (`Id_Ressources`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `consomme`
--

INSERT INTO `consomme` (`Id_Appareil`, `Id_Ressources`, `Consommation_par_h`) VALUES
(24, 3, 6),
(25, 1, 1),
(21, 3, 1),
(20, 2, 3),
(23, 3, 3),
(22, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `Id_Departement` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Id_Region` int(11) NOT NULL,
  PRIMARY KEY (`Id_Departement`),
  KEY `Id_Region` (`Id_Region`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`Id_Departement`, `Nom`, `Id_Region`) VALUES
(1, 'Indre et Loire', 1),
(2, 'Loiret', 1);

-- --------------------------------------------------------

--
-- Structure de la table `duree_de_conso`
--

DROP TABLE IF EXISTS `duree_de_conso`;
CREATE TABLE IF NOT EXISTS `duree_de_conso` (
  `Id_Appareil` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`Id_Appareil`,`date_debut`,`date_fin`),
  KEY `date_debut` (`date_debut`,`date_fin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `duree_de_conso`
--

INSERT INTO `duree_de_conso` (`Id_Appareil`, `date_debut`, `date_fin`) VALUES
(20, '2021-01-24 18:05:21', '2021-01-24 18:05:29'),
(20, '2021-01-24 18:22:21', '2021-01-24 18:22:26'),
(20, '2021-01-24 18:23:07', '2021-01-24 18:23:10'),
(22, '2021-01-24 18:05:24', '2021-01-24 18:05:27'),
(23, '2021-01-24 18:10:20', '2021-01-24 18:10:25'),
(23, '2021-01-24 18:24:31', '2021-01-24 18:24:43'),
(23, '2021-01-24 18:25:04', '2021-01-24 18:25:15'),
(24, '2021-01-24 18:16:53', '2021-01-24 18:17:04'),
(25, '2021-01-24 18:20:36', '2021-01-24 18:20:42');

-- --------------------------------------------------------

--
-- Structure de la table `emet`
--

DROP TABLE IF EXISTS `emet`;
CREATE TABLE IF NOT EXISTS `emet` (
  `Id_Appareil` int(11) NOT NULL,
  `Id_Substances` int(11) NOT NULL,
  `Emmission_par_h` double DEFAULT NULL,
  PRIMARY KEY (`Id_Appareil`,`Id_Substances`),
  KEY `Id_Substances` (`Id_Substances`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emet`
--

INSERT INTO `emet` (`Id_Appareil`, `Id_Substances`, `Emmission_par_h`) VALUES
(24, 1, NULL),
(25, 1, NULL),
(21, 1, NULL),
(20, 2, 1),
(23, 1, NULL),
(22, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `historique_appareil`
--

DROP TABLE IF EXISTS `historique_appareil`;
CREATE TABLE IF NOT EXISTS `historique_appareil` (
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`date_debut`,`date_fin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historique_location`
--

DROP TABLE IF EXISTS `historique_location`;
CREATE TABLE IF NOT EXISTS `historique_location` (
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`date_debut`,`date_fin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historique_posseder`
--

DROP TABLE IF EXISTS `historique_posseder`;
CREATE TABLE IF NOT EXISTS `historique_posseder` (
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`date_debut`,`date_fin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `maison`
--

DROP TABLE IF EXISTS `maison`;
CREATE TABLE IF NOT EXISTS `maison` (
  `Id_Maison` int(11) NOT NULL AUTO_INCREMENT,
  `degre_isolation` int(11) DEFAULT NULL,
  `eco_immeuble` int(11) DEFAULT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Rue` varchar(50) DEFAULT NULL,
  `Num_rue` int(11) DEFAULT NULL,
  `Id_Personne` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `Id_Ville` int(11) NOT NULL,
  PRIMARY KEY (`Id_Maison`),
  KEY `Id_Personne` (`Id_Personne`),
  KEY `date_debut` (`date_debut`,`date_fin`),
  KEY `Id_Ville` (`Id_Ville`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maison`
--

INSERT INTO `maison` (`Id_Maison`, `degre_isolation`, `eco_immeuble`, `Nom`, `Rue`, `Num_rue`, `Id_Personne`, `date_debut`, `date_fin`, `Id_Ville`) VALUES
(1, 5, 2, 'Immeuble', 'rue Labordere', 3, 1, '2021-01-10', '2021-01-10', 1),
(2, 3, 2, 'Maison famille', 'AllÃ©e des tournesols', 7, 1, '2020-12-29', '2020-12-29', 2);

-- --------------------------------------------------------

--
-- Structure de la table `nb_piece`
--

DROP TABLE IF EXISTS `nb_piece`;
CREATE TABLE IF NOT EXISTS `nb_piece` (
  `Id_type_appart` int(11) NOT NULL,
  `Id_Type_piece` int(11) NOT NULL,
  `nb_piece` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_type_appart`,`Id_Type_piece`),
  KEY `Id_Type_piece` (`Id_Type_piece`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `Id_Personne` int(11) NOT NULL AUTO_INCREMENT,
  `date_naissance` date DEFAULT NULL,
  `nom` varchar(40) DEFAULT NULL,
  `genre` varchar(40) DEFAULT NULL,
  `num_tel` int(11) DEFAULT NULL,
  `prenom` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`Id_Personne`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`Id_Personne`, `date_naissance`, `nom`, `genre`, `num_tel`, `prenom`) VALUES
(1, '2000-05-15', 'Tram', 'Femme', 645129456, 'Pauline'),
(2, '1998-01-13', 'Dupond', 'Homme', 684322457, 'Jean'),
(3, '1982-05-12', 'Poirreau', 'Homme', 756452864, 'Albert');

--
-- Déclencheurs `personne`
--
DROP TRIGGER IF EXISTS `supprimer personne`;
DELIMITER $$
CREATE TRIGGER `supprimer personne` AFTER DELETE ON `personne` FOR EACH ROW IF NOT EXISTS (
         SELECT compte.Id_Personne
        FROM compte LEFT JOIN personne ON compte.Id_Personne=personne.Id_Personne
        WHERE personne.Id_Personne=old.Id_Personne
)
    THEN

        DELETE FROM compte WHERE compte.Id_Personne=old.Id_Personne; 
        UPDATE appartement SET date_fin =CURRENT_DATE WHERE appartement.Id_Personne=old.Id_Personne; 
    END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

DROP TABLE IF EXISTS `piece`;
CREATE TABLE IF NOT EXISTS `piece` (
  `Id_Piece` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  `Id_Type_piece` int(11) NOT NULL,
  `Id_Appartement` int(11) NOT NULL,
  PRIMARY KEY (`Id_Piece`),
  KEY `Id_Type_piece` (`Id_Type_piece`),
  KEY `Id_Appartement` (`Id_Appartement`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `piece`
--

INSERT INTO `piece` (`Id_Piece`, `libelle`, `Id_Type_piece`, `Id_Appartement`) VALUES
(7, 'jaune', 2, 1),
(6, '15m2', 1, 1),
(8, '10m2', 1, 3),
(9, 'bleu', 2, 4),
(10, '8m2', 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `Id_Region` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Region`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`Id_Region`, `Nom`) VALUES
(1, 'Centre');

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

DROP TABLE IF EXISTS `ressources`;
CREATE TABLE IF NOT EXISTS `ressources` (
  `Id_Ressources` int(11) NOT NULL AUTO_INCREMENT,
  `valeur_min_par_j` int(11) DEFAULT NULL,
  `valeur_max_par_j` int(11) DEFAULT NULL,
  `libele` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `valeur_critique_par_j` int(11) DEFAULT NULL,
  `valeur_ideale_par_j` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_Ressources`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ressources`
--

INSERT INTO `ressources` (`Id_Ressources`, `valeur_min_par_j`, `valeur_max_par_j`, `libele`, `description`, `valeur_critique_par_j`, `valeur_ideale_par_j`) VALUES
(1, 1, 1, 'eau', 'L par h', 1, 1),
(2, 1, 1, 'gaz', 'm3 par heure', 1, 1),
(3, 1, 1, 'electricite', 'W par heure', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `substances`
--

DROP TABLE IF EXISTS `substances`;
CREATE TABLE IF NOT EXISTS `substances` (
  `Id_Substances` int(11) NOT NULL AUTO_INCREMENT,
  `valeur_min_par_j` int(11) DEFAULT NULL,
  `valeur_max_par_j` int(11) DEFAULT NULL,
  `libele` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `valeur_critique_par_j` int(11) DEFAULT NULL,
  `valeur_ideale_par_j` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_Substances`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `substances`
--

INSERT INTO `substances` (`Id_Substances`, `valeur_min_par_j`, `valeur_max_par_j`, `libele`, `description`, `valeur_critique_par_j`, `valeur_ideale_par_j`) VALUES
(1, 1, 1, 'Null', 'rien', 1, 1),
(2, 1, 1, 'gaz', 'm3 par heure', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_appareil`
--

DROP TABLE IF EXISTS `type_appareil`;
CREATE TABLE IF NOT EXISTS `type_appareil` (
  `Id_Type_appareil` int(11) NOT NULL AUTO_INCREMENT,
  `nom_appareil` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Type_appareil`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_appareil`
--

INSERT INTO `type_appareil` (`Id_Type_appareil`, `nom_appareil`) VALUES
(4, 'mecanique'),
(1, 'electrique'),
(3, 'au gaz');

-- --------------------------------------------------------

--
-- Structure de la table `type_appart`
--

DROP TABLE IF EXISTS `type_appart`;
CREATE TABLE IF NOT EXISTS `type_appart` (
  `Id_type_appart` int(11) NOT NULL AUTO_INCREMENT,
  `pieces_contenues` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_type_appart`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type_piece`
--

DROP TABLE IF EXISTS `type_piece`;
CREATE TABLE IF NOT EXISTS `type_piece` (
  `Id_Type_piece` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Type_piece`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_piece`
--

INSERT INTO `type_piece` (`Id_Type_piece`, `nom_type`) VALUES
(1, 'cuisine'),
(2, 'chambre'),
(3, 'salle de bain');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `Id_Video` int(11) NOT NULL AUTO_INCREMENT,
  `Lien` varchar(50) DEFAULT NULL,
  `Id_Appareil` int(11) NOT NULL,
  PRIMARY KEY (`Id_Video`),
  KEY `Id_Appareil` (`Id_Appareil`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`Id_Video`, `Lien`, `Id_Appareil`) VALUES
(1, 'hu', 1),
(2, 'k', 2),
(3, 'uig', 3),
(4, 'iugf', 4),
(5, 'poijhug', 5),
(6, 'frgth', 6),
(7, 'kjh', 7),
(8, 'rty', 8),
(9, 'ert', 9),
(10, 'lkijh', 10),
(11, 'luytfd', 11),
(12, 'zer', 12),
(13, 'erfty', 13),
(14, 'dfbn', 14),
(15, 'sdfg', 15),
(16, 'sdfg', 16),
(17, 'qsf', 17),
(18, 'sdcv', 18),
(19, 'sdf', 19),
(20, 'https://www.youtube.com/watch?v=ruVxLrG0noM', 20),
(21, 'https://www.youtube.com/watch?v=0bHlvKDAU_c', 21),
(22, 'https://www.youtube.com/watch?v=5ZzGYvcXwgQ', 22),
(23, 'https://www.youtube.com/watch?v=R16_lQLE96c', 23),
(24, 'https://www.youtube.com/watch?v=OXk05xz7CaM', 24),
(25, 'asdfg', 25);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `Id_Ville` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `Id_Departement` int(11) NOT NULL,
  PRIMARY KEY (`Id_Ville`),
  KEY `Id_Departement` (`Id_Departement`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`Id_Ville`, `Nom`, `CP`, `Id_Departement`) VALUES
(1, 'Tours', 37000, 1),
(2, 'Orleans', 45000, 2);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_appareil`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_appareil`;
CREATE TABLE IF NOT EXISTS `vue_appareil` (
`Id_Appareil` int(11)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_appartement`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_appartement`;
CREATE TABLE IF NOT EXISTS `vue_appartement` (
`Id_Appartement` int(11)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_piece`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_piece`;
CREATE TABLE IF NOT EXISTS `vue_piece` (
`Id_Piece` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_appareil`
--
DROP TABLE IF EXISTS `vue_appareil`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_appareil`  AS  select `appartient_piece`.`Id_Appareil` AS `Id_Appareil` from `appartient_piece` where `appartient_piece`.`Id_Piece` in (select `vue_piece`.`Id_Piece` from `vue_piece`) ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_appartement`
--
DROP TABLE IF EXISTS `vue_appartement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_appartement`  AS  select `appartement`.`Id_Appartement` AS `Id_Appartement` from `appartement` where (`appartement`.`Id_Maison` = '1') ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_piece`
--
DROP TABLE IF EXISTS `vue_piece`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_piece`  AS  select `piece`.`Id_Piece` AS `Id_Piece` from `piece` where `piece`.`Id_Appartement` in (select `vue_appartement`.`Id_Appartement` from `vue_appartement`) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
