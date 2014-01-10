CREATE TABLE `cneac_regionales` (
  `Id` int(11) NOT NULL auto_increment,
  `Regionale` char(30) collate utf8_unicode_ci NOT NULL,
  `CodeRegionale` char(3) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
