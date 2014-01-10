CREATE TABLE IF NOT EXISTS `cneac_races` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CodeRace` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Race` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
