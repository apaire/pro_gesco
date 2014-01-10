CREATE TABLE IF NOT EXISTS `agility_penalants` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdLicence` int(11) NOT NULL,
  `Date` date NOT NULL,
  `CodeJuge` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Juge` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Penalites` float(10,2) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
