SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `caracteristique` VALUES
('chance'),
('chanceMax'),
('endurance'),
('enduranceMax'),
('habilete'),
('habileteMax');

INSERT INTO `effet` VALUES
('+', 0, 'chance'),
('+', 1, 'chanceMax'),
('+', 0, 'endurance'),
('-', 2, 'habilete'),
('-', 3, 'habilete'),
('-', 4, 'habilete'),
('+', 0, 'habilete');

INSERT INTO `malus` VALUES
(145, '-', 2, 'habilete'),
(151, '-', 2, 'habilete'),
(294, '-', 2, 'habilete'),
(166, '-', 3, 'habilete'),
(91, '-', 4, 'habilete');

INSERT INTO `monstre` VALUES
(1, 'Manticore', 11, 11),
(2, 'Mouche géante', 7, 8),
(3, 'Minotaure', 9, 9),
(4, 'Lutin', 6, 5),
(5, 'Orque', 5, 5),
(6, 'Orque', 6, 4),
(7, 'Gobelin', 5, 4),
(8, 'Gobelin', 5, 5),
(9, 'Lutin', 7, 5),
(10, 'Urtika', 9, 9),
(11, 'Scorpion Géant', 10, 10),
(12, 'Nain', 8, 6),
(13, 'Chien de garde', 7, 7),
(14, 'Chien de garde', 7, 8),
(15, 'Gardien volant', 7, 8),
(16, 'Gardien volant', 8, 8),
(17, 'Bête sanguinaire', 12, 10),
(18, 'Monstre des abîmes', 12, 15),
(19, 'Imitateur', 9, 8),
(20, 'Ver des rocs', 7, 11),
(21, 'Throm', 10, 12),
(22, 'Ninja', 11, 9),
(23, 'Démon du miroir', 10, 10),
(24, 'Squelette guerrier', 8, 6),
(25, 'Troll des cavernes', 10, 11),
(26, 'Homme des cavernes', 7, 7);

INSERT INTO `paragraphe` VALUES
(6),
(39),
(40),
(51),
(91),
(124),
(130),
(139),
(143),
(145),
(148),
(151),
(166),
(172),
(189),
(196),
(203),
(211),
(225),
(236),
(245),
(247),
(254),
(294),
(302),
(312),
(327),
(331),
(349),
(369),
(380),
(387);

INSERT INTO `population` VALUES
(1, 6),
(2, 39),
(3, 40),
(4, 51),
(5, 91),
(6, 91),
(7, 124),
(8, 124),
(4, 130),
(9, 130),
(10, 139),
(11, 143),
(12, 145),
(13, 148),
(14, 148),
(15, 151),
(16, 151),
(15, 166),
(16, 166),
(17, 172),
(5, 189),
(6, 189),
(1, 196),
(18, 203),
(10, 211),
(17, 225),
(19, 236),
(18, 245),
(1, 247),
(20, 254),
(17, 294),
(21, 302),
(22, 312),
(23, 327),
(24, 331),
(18, 349),
(25, 369),
(5, 380),
(6, 380),
(26, 387);

INSERT INTO `possession` VALUES
(1, 'Potion d''Adresse', 'potion'),
(2, 'Potion de Vigueur', 'potion'),
(3, 'Potion de Bonne Fortune', 'potion'),
(4, 'Épée', 'equipement'),
(5, 'Armure de cuir', 'equipement'),
(6, 'Lanterne', 'equipement'),
(7, 'Clef en fer', 'equipement'),
(8, 'Tube en bois', 'equipement'),
(9, 'Cotte de mailles', 'equipement'),
(10, 'Émeraude', 'bijoux'),
(11, 'Grappin', 'equipement'),
(12, 'Sac en cuir', 'equipement'),
(13, 'Ceinture de cuivre', 'equipement'),
(14, 'Corde', 'equipement'),
(15, 'Anneau d''Or magique', 'bijoux'),
(16, 'Poignard incrusté d''Opales', 'equipement'),
(17, 'Bouclier', 'equipement'),
(18, 'Coupe', 'equipement'),
(19, 'Potion de Mimétisme', 'potion'),
(20, 'Collier de dents', 'bijoux'),
(21, 'Grosse perle', 'bijoux'),
(22, 'Saphir', 'bijoux'),
(23, 'Dent de Farfadet', 'bijoux'),
(24, 'Vieil os', 'equipement'),
(25, 'Casque', 'equipement'),
(26, 'Topaze', 'bijoux'),
(27, 'Poignard', 'equipement'),
(28, 'Miroir', 'equipement'),
(29, 'Talisman de singe', 'bijoux'),
(30, 'Rubis', 'bijoux'),
(31, 'Sabre de ninja', 'equipement'),
(32, 'Couteau de ninja', 'equipement'),
(33, 'Anneau en os', 'bijoux'),
(34, 'Maillet en bois', 'equipement'),
(35, 'Clou', 'equipement'),
(36, 'Grenat', 'bijoux'),
(37, 'Diamant', 'bijoux'),
(38, 'Bracelet de cuir', 'bijoux'),
(39, 'Bouteille d''acide', 'potion');

INSERT INTO `possession_effet` VALUES
(1, '+', 0, 'habilete'),
(2, '+', 0, 'endurance'),
(3, '+', 0, 'chance'),
(3, '+', 1, 'chanceMax');

INSERT INTO `type` VALUES
('bijoux'),
('equipement'),
('potion');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
