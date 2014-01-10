CREATE TABLE IF NOT EXISTS `cneac_variables` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Activite` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `Variable` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Valeur` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
