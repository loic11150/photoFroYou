-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 26 Septembre 2019 à 13:44
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `photoforyou`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AjoutStatistiquePhotographe` ()  BEGIN
	declare moyenne float(5,2) ;
    declare champs varchar(50) ;
    declare date datetime ;
    
    set champs = "Moyenne_Credits_Photographe" ;
    set date = localtime() ;
    
    select avg(credits) into moyenne 
    from users 
    where type = "photographe";
    insert into statistique values (date,champs,moyenne) ; 
END$$

--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `ClientSansCredits` (`typeR` VARCHAR(12)) RETURNS INT(11) BEGIN
-- typeR est le type rentrée avec la fonction, typeC est le type comparé dans la requête
	declare nbrClient int ;
	declare typeC varchar(12);
    set typeC = typeR;
    select count(*) into nbrClient
    from users
    where credits = 0 
	and type = typeC ;
    return nbrClient ;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `InitCap` (`chaine` VARCHAR(50)) RETURNS VARCHAR(50) CHARSET latin1 begin
-- declare le return
	declare chainer varchar(50) ;
-- affecte une Maj à la première lettre et met le reste en minuscule
	set chainer = concat(upper(substr(chaine from  1 for 1 )),lower(substr(chaine from 2)));
 return chainer;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `nbrphoto` (`idr` TINYINT) RETURNS INT(11) BEGIN
-- Déclaration des variables
	declare nbPhoto int ;
	declare idc int ;
  -- declare idClient int ;
-- affecte la valeur rentrée avec la fonction a idr     
    set idc = idr ;
    
	select count(*) into nbPhoto 
	from photo
	where id_user = idc ;
    
	RETURN nbPhoto;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(11) NOT NULL,
  `nom_photo` varchar(50) DEFAULT NULL,
  `taille_pixels_x` int(11) DEFAULT NULL,
  `taille_pixels_y` int(11) DEFAULT NULL,
  `poids` int(11) DEFAULT NULL,
  `url_photo` varchar(100) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `nom_photo`, `taille_pixels_x`, `taille_pixels_y`, `poids`, `url_photo`, `id_user`) VALUES
(1, 'photo_superbe', 2356, 1571, 3700, '/img/img7.png', 1),
(2, 'portrait', 2356, 1571, 3700, '/img/img8.png', 1),
(3, 'photoreportage', 2356, 1571, 3700, '/img/img9.png', 3),
(4, 'kenya', 2356, 1571, 3700, '/img/img10.png', 5);

-- --------------------------------------------------------

--
-- Structure de la table `statistique`
--

CREATE TABLE `statistique` (
  `date` datetime NOT NULL,
  `champs` varchar(50) DEFAULT NULL,
  `valeur` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `statistique`
--

INSERT INTO `statistique` (`date`, `champs`, `valeur`) VALUES
('2019-09-24 15:12:26', 'Moyenne_Credits_Photographe', 20);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `type` varchar(12) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `motDePasse` varchar(50) DEFAULT NULL,
  `credits` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `email`, `type`, `prenom`, `nom`, `pseudo`, `motDePasse`, `credits`) VALUES
(1, 'lolo@gmail.com', 'client', 'loic', 'raulin', 'pseudoStyle', 'motDePasseComplique', 82),
(2, 'zlatan@gmail.com', 'client', 'iBraHimoVic', 'ZlAtaN', 'ZlatanBetterThanU', 'NoNeedMDP', 54),
(3, 'messi@gmail.com', 'photographe', 'lIoNel', 'MeSSi', 'LaPulga', 'JeSuisNulEnSelection', 0),
(4, 'CR7@gmail.com', 'photographe', 'ChRistIanO', 'RoNaLdO', 'CR7', 'MessiEstLeMeilleur', 41),
(5, 'kyky@gmail.com', 'client', 'KYllIAN', 'm\'bappé', 'KM7', 'JeVaisEtreMeilleurQuePele', 99),
(6, 'grizi@gmail.com', 'photographe', 'ANTOINE', 'GRiezmann', 'griezmann', 'JaimeMessi', 78);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `fk1` (`id_user`);

--
-- Index pour la table `statistique`
--
ALTER TABLE `statistique`
  ADD PRIMARY KEY (`date`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
