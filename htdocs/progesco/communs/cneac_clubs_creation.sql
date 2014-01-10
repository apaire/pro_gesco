CREATE TABLE IF NOT EXISTS `cneac_clubs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Club` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NomComplet` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `CodeClub` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `CodeRegionale` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse1` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse2` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `CP` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Ville` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Telephone` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `Equipe` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
