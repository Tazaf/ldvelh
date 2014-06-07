SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `caracteristique` (
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `combat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `victoire` tinyint(1) NOT NULL,
  `monstre_id` int(10) unsigned NOT NULL,
  `paragraphe_numero` smallint(5) unsigned NOT NULL,
  `personnage_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_combat_monstre1_idx` (`monstre_id`),
  KEY `fk_combat_paragraphe1_idx` (`paragraphe_numero`),
  KEY `fk_combat_personnage1_idx` (`personnage_nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `effet` (
  `modificateur` enum('-','+') NOT NULL,
  `valeur` tinyint(3) unsigned NOT NULL,
  `caracteristique_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`modificateur`,`valeur`,`caracteristique_nom`),
  KEY `fk_effet_caracteristique_idx` (`caracteristique_nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `malus` (
  `paragraphe_numero` smallint(5) unsigned NOT NULL,
  `effet_modificateur` enum('-','+') NOT NULL,
  `effet_valeur` tinyint(3) unsigned NOT NULL,
  `effet_caracteristique_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`paragraphe_numero`),
  KEY `fk_effet_has_paragraphe_paragraphe1_idx` (`paragraphe_numero`),
  KEY `fk_malus_effet1_idx` (`effet_modificateur`,`effet_valeur`,`effet_caracteristique_nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `monstre` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `habilete` tinyint(3) unsigned NOT NULL,
  `endurance` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

CREATE TABLE IF NOT EXISTS `paragraphe` (
  `numero` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `personnage` (
  `nom` varchar(45) NOT NULL,
  `habileteMax` tinyint(3) unsigned DEFAULT '0',
  `habilete` tinyint(3) unsigned DEFAULT '0',
  `enduranceMax` tinyint(3) unsigned DEFAULT '0',
  `endurance` tinyint(3) unsigned DEFAULT '0',
  `chanceMax` tinyint(3) unsigned DEFAULT '0',
  `chance` tinyint(3) unsigned DEFAULT '0',
  `repas` tinyint(3) unsigned DEFAULT '0',
  `bourse` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`nom`),
  UNIQUE KEY `nom_UNIQUE` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `population` (
  `monstre_id` int(10) unsigned NOT NULL,
  `paragraphe_numero` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`monstre_id`,`paragraphe_numero`),
  KEY `fk_monstre_has_paragraphe_paragraphe1_idx` (`paragraphe_numero`),
  KEY `fk_monstre_has_paragraphe_monstre1_idx` (`monstre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `possession` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `type_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_possession_type1_idx` (`type_nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

CREATE TABLE IF NOT EXISTS `possession_effet` (
  `possession_id` int(10) unsigned NOT NULL,
  `effet_modificateur` enum('-','+') NOT NULL,
  `effet_valeur` tinyint(3) unsigned NOT NULL,
  `effet_caracteristique_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`possession_id`,`effet_modificateur`,`effet_valeur`,`effet_caracteristique_nom`),
  KEY `fk_possession_has_effet_effet1_idx` (`effet_modificateur`,`effet_valeur`,`effet_caracteristique_nom`),
  KEY `fk_possession_has_effet_possession1_idx` (`possession_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sac_a_dos` (
  `possession_id` int(10) unsigned NOT NULL,
  `personnage_nom` varchar(45) NOT NULL,
  `quantite` tinyint(3) unsigned DEFAULT '1',
  PRIMARY KEY (`possession_id`,`personnage_nom`),
  KEY `fk_personnage_has_possession_possession1_idx` (`possession_id`),
  KEY `fk_sac_a_dos_personnage1_idx` (`personnage_nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `type` (
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `combat`
  ADD CONSTRAINT `fk_combat_monstre1` FOREIGN KEY (`monstre_id`) REFERENCES `monstre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_combat_paragraphe1` FOREIGN KEY (`paragraphe_numero`) REFERENCES `paragraphe` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_combat_personnage1` FOREIGN KEY (`personnage_nom`) REFERENCES `personnage` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `effet`
  ADD CONSTRAINT `fk_effet_caracteristique` FOREIGN KEY (`caracteristique_nom`) REFERENCES `caracteristique` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `malus`
  ADD CONSTRAINT `fk_effet_has_paragraphe_paragraphe1` FOREIGN KEY (`paragraphe_numero`) REFERENCES `paragraphe` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_malus_effet1` FOREIGN KEY (`effet_modificateur`, `effet_valeur`, `effet_caracteristique_nom`) REFERENCES `effet` (`modificateur`, `valeur`, `caracteristique_nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `population`
  ADD CONSTRAINT `fk_monstre_has_paragraphe_monstre1` FOREIGN KEY (`monstre_id`) REFERENCES `monstre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_monstre_has_paragraphe_paragraphe1` FOREIGN KEY (`paragraphe_numero`) REFERENCES `paragraphe` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `possession`
  ADD CONSTRAINT `fk_possession_type1` FOREIGN KEY (`type_nom`) REFERENCES `type` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `possession_effet`
  ADD CONSTRAINT `fk_possession_has_effet_possession1` FOREIGN KEY (`possession_id`) REFERENCES `possession` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_possession_has_effet_effet1` FOREIGN KEY (`effet_modificateur`, `effet_valeur`, `effet_caracteristique_nom`) REFERENCES `effet` (`modificateur`, `valeur`, `caracteristique_nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `sac_a_dos`
  ADD CONSTRAINT `fk_personnage_has_possession_possession1` FOREIGN KEY (`possession_id`) REFERENCES `possession` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sac_a_dos_personnage1` FOREIGN KEY (`personnage_nom`) REFERENCES `personnage` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
