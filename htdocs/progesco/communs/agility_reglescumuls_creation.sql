CREATE TABLE IF NOT EXISTS `agility_reglescumuls` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Epreuve` int(11) NOT NULL,
  `NomCumul` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Epreuves` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;