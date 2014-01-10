CREATE TABLE IF NOT EXISTS `cneac_juges` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CodeJuge` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Titre` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `Nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Agi` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Fly` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Fri` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Obr` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Cca` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `Att` char(1) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
