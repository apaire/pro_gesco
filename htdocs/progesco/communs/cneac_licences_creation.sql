CREATE TABLE IF NOT EXISTS `cneac_licences` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Licence` int(11) NOT NULL,
  `Rang` tinyint(4) NOT NULL,
  `NomChien` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Affixe` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CodeRace` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `LOF` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Sexe` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Toise` int(11) NOT NULL,
  `Categorie` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Classe` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Tatouage` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Puce` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Titre` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `Nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Handi` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CP` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Ville` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `CodeClub` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `AGI1` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `AGI2` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `FLY` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `FRI` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `OBR` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
