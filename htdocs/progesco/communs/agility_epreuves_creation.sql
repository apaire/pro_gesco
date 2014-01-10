CREATE TABLE IF NOT EXISTS `agility_epreuves` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Epreuve` tinyint(4) unsigned NOT NULL,
  `Categorie` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Classe` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Handi` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Engages` int(11) NOT NULL,
  `Concourrus` int(11) NOT NULL,
  `CodeJuge` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Juge` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NbObstacles` tinyint(4) unsigned NOT NULL,
  `Longueur` smallint(5) unsigned NOT NULL,
  `Vitesse` decimal(10,2) NOT NULL,
  `TPS` tinyint(3) unsigned NOT NULL,
  `TMP` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
