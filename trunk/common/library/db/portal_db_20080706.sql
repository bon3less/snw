-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-7
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 06, 2008 at 02:57 PM
-- Server version: 5.0.32
-- PHP Version: 5.2.6-2
-- 
-- Database: `portal_db`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `Admin_Login`
-- 

DROP TABLE IF EXISTS `Admin_Login`;
CREATE TABLE `Admin_Login` (
  `AID` int(10) unsigned NOT NULL auto_increment,
  `admin_Name` varchar(16) NOT NULL,
  `admin_Password` varchar(32) NOT NULL,
  PRIMARY KEY  (`AID`)
) TYPE=InnoDB AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Admin_Login`
-- 

INSERT INTO `Admin_Login` (`AID`, `admin_Name`, `admin_Password`) VALUES 
(1, 'admin', '21232F297A57A5A743894A0E4A801FC3');

-- --------------------------------------------------------

-- 
-- Table structure for table `Bewertung`
-- 

DROP TABLE IF EXISTS `Bewertung`;
CREATE TABLE `Bewertung` (
  `BID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `BLID` int(10) unsigned NOT NULL,
  `BMID` int(10) unsigned NOT NULL,
  `BSID` int(10) unsigned NOT NULL,
  `datum` int(10) unsigned NOT NULL,
  `kategorie` tinyint(3) unsigned NOT NULL,
  `b_note` tinyint(1) unsigned NOT NULL,
  `Anzahl_Values` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY  (`BID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Bewertung`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Bewertungs_Msg`
-- 

DROP TABLE IF EXISTS `Bewertungs_Msg`;
CREATE TABLE `Bewertungs_Msg` (
  `BMID` int(10) unsigned NOT NULL auto_increment,
  `bewertungs_Text` text NOT NULL,
  `status_ueberprueft` tinyint(1) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`BMID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Bewertungs_Msg`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Categories`
-- 

DROP TABLE IF EXISTS `Categories`;
CREATE TABLE `Categories` (
  `Cat_ID` smallint(5) unsigned NOT NULL auto_increment,
  `cat_Name` varchar(30) default NULL,
  `parent_Cat_ID` smallint(5) unsigned default '0',
  `flag` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Cat_ID`)
) TYPE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `Categories`
-- 

INSERT INTO `Categories` (`Cat_ID`, `cat_Name`, `parent_Cat_ID`, `flag`) VALUES 
(1, 'Startseite', 0, 1),
(2, 'Bewerten', 0, 1),
(3, 'TOP - Listen', 0, 1),
(4, 'Neuigkeiten', 0, 1),
(5, 'Registrieren', 0, 1),
(6, '&Uuml;ber Uns', 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `Content`
-- 

DROP TABLE IF EXISTS `Content`;
CREATE TABLE `Content` (
  `CID` int(10) unsigned NOT NULL auto_increment,
  `Cat_ID` int(10) unsigned NOT NULL,
  `Topic_ID` int(10) unsigned NOT NULL,
  `content_Name` varchar(45) NOT NULL,
  `content_Caption` varchar(45) default '"n/a"',
  `content_Text` text,
  `content_Position` varchar(10) NOT NULL default 'main' COMMENT 'main, left, right',
  PRIMARY KEY  (`CID`)
) TYPE=InnoDB AUTO_INCREMENT=25 ;

-- 
-- Dumping data for table `Content`
-- 

INSERT INTO `Content` (`CID`, `Cat_ID`, `Topic_ID`, `content_Name`, `content_Caption`, `content_Text`, `content_Position`) VALUES 
(1, 5, 0, 'register', 'Anmeldung', 'Die Anmeldung zum Sch&uuml;lerportal ist kostenfrei und mit keinerlei Kosten verbunden...', 'main'),
(2, 1, 0, 'home', 'Das Sch&uuml;lerportal', 'Hier im Sch&uuml;lerportal von &#132;1 bis 6&#148; drehen wir einmal den Spiess um. Denn hier werden deine Lehrer benotet...', 'main'),
(3, 1, 11, 'profile_view', 'Mein Profil', '', 'main'),
(4, 1, 12, 'friends', 'Meine Freunde', NULL, 'left'),
(5, 1, 13, 'messages', 'Messages', NULL, 'right'),
(6, 1, 14, 'photos', 'Fotos und Bilder', NULL, 'main'),
(7, 1, 15, 'search', '', NULL, 'main'),
(8, 2, 0, 'rating', 'Auf deine Bewertung kommt es an.', 'Eine angemessene und ehrliche Berwertung abzugeben faellt nicht immer einfach....', 'main'),
(9, 2, 1, 'rating_pupil', 'Bewerte deine Mitsch&uuml;ler', 'text', 'main'),
(10, 2, 2, 'rating_teacher', 'Benote deine Lehrer', 'text', 'main'),
(11, 2, 3, 'rating_school', 'Bewerte deine Schule', 'text', 'main'),
(12, 2, 16, 'search', '', NULL, 'main'),
(13, 3, 0, '', '"n/a"', NULL, 'main'),
(14, 3, 4, 'ranking_pupil', '"n/a"', NULL, 'main'),
(15, 3, 5, 'ranking_teacher', '"n/a"', NULL, 'main'),
(16, 3, 6, 'ranking_school', '"n/a"', NULL, 'main'),
(17, 3, 17, 'search', '', NULL, 'main'),
(18, 4, 0, '', '"n/a"', NULL, 'main'),
(19, 4, 7, 'news_topic_of_the_week', '"n/a"', NULL, 'main'),
(20, 4, 8, 'news_chit-chat', '"n/a"', NULL, 'main'),
(21, 4, 9, 'news_member', '"n/a"', NULL, 'main'),
(22, 4, 10, 'news_fun_stuff', '"n/a"', NULL, 'main'),
(23, 4, 18, 'search', '', NULL, 'main'),
(24, 6, 0, 'about', '"n/a"', NULL, 'main');

-- --------------------------------------------------------

-- 
-- Table structure for table `Fachbereiche`
-- 

DROP TABLE IF EXISTS `Fachbereiche`;
CREATE TABLE `Fachbereiche` (
  `UFID` int(10) unsigned NOT NULL auto_increment,
  `LID` int(10) unsigned NOT NULL,
  `fach_Name` varchar(45) NOT NULL,
  PRIMARY KEY  (`UFID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Fachbereiche`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Fotos`
-- 

DROP TABLE IF EXISTS `Fotos`;
CREATE TABLE `Fotos` (
  `FID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `file_Name` varchar(45) NOT NULL,
  `pfad_Name` varchar(255) NOT NULL,
  `foto_Titel` varchar(255) NOT NULL,
  `datum` int(10) unsigned NOT NULL default '0',
  `foto_breite` smallint(5) unsigned NOT NULL default '0',
  `foto_hoehe` smallint(5) unsigned NOT NULL default '0',
  `flag_aktiviert` tinyint(1) NOT NULL default '0',
  `flag_ueberprueft` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`FID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Fotos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Freunde`
-- 

DROP TABLE IF EXISTS `Freunde`;
CREATE TABLE `Freunde` (
  `Freund_ID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `FSID` int(10) unsigned NOT NULL,
  `freund_Nick_Name` varchar(45) NOT NULL,
  PRIMARY KEY  (`Freund_ID`,`SID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Freunde`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Klassen`
-- 

DROP TABLE IF EXISTS `Klassen`;
CREATE TABLE `Klassen` (
  `Klassen_ID` int(10) unsigned NOT NULL auto_increment,
  `Schul_ID` int(10) unsigned NOT NULL,
  `LID` int(10) unsigned default '0',
  `klassen_Name` varchar(12) NOT NULL,
  `klassen_Stufe` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`Klassen_ID`),
  KEY `FK_Klassen_Schule` (`Schul_ID`)
) TYPE=InnoDB AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `Klassen`
-- 

INSERT INTO `Klassen` (`Klassen_ID`, `Schul_ID`, `LID`, `klassen_Name`, `klassen_Stufe`) VALUES 
(1, 1, 0, '11', NULL),
(2, 2, 0, '5b', NULL),
(3, 3, 0, 'Klassenstufe', NULL),
(4, 4, 0, '10d', NULL),
(5, 5, 0, '11b', NULL),
(6, 6, 0, '12', NULL),
(7, 7, 0, '12a', NULL),
(8, 8, 0, '7c', NULL),
(9, 9, 0, '9.12', NULL),
(10, 10, 0, '11', NULL),
(11, 11, 0, '11w', NULL),
(12, 12, 0, '12', NULL),
(13, 13, 0, '12', NULL),
(14, 14, 0, '12', NULL),
(15, 15, 0, '12', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `Klassen_Mitglieder`
-- 

DROP TABLE IF EXISTS `Klassen_Mitglieder`;
CREATE TABLE `Klassen_Mitglieder` (
  `KM_ID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `LID` int(10) unsigned NOT NULL,
  `Klassen_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`KM_ID`)
) TYPE=InnoDB AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `Klassen_Mitglieder`
-- 

INSERT INTO `Klassen_Mitglieder` (`KM_ID`, `SID`, `LID`, `Klassen_ID`) VALUES 
(1, 1, 0, 1),
(2, 2, 0, 2),
(3, 3, 0, 3),
(4, 4, 0, 4),
(5, 5, 0, 5),
(6, 6, 0, 6),
(7, 7, 0, 7),
(8, 8, 0, 8),
(9, 9, 0, 9),
(10, 10, 0, 10),
(11, 11, 0, 11),
(12, 12, 0, 12),
(13, 13, 0, 13),
(14, 14, 0, 14),
(15, 15, 0, 15),
(16, 16, 0, 14);

-- --------------------------------------------------------

-- 
-- Table structure for table `Konfiguration`
-- 

DROP TABLE IF EXISTS `Konfiguration`;
CREATE TABLE `Konfiguration` (
  `Konfig_ID` int(10) unsigned NOT NULL auto_increment,
  `konfig_Titel` varchar(85) NOT NULL,
  `konfig_status` tinyint(3) unsigned NOT NULL default '0',
  `beschreibung` text NOT NULL,
  `letzte_Aenderung` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Konfig_ID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Konfiguration`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Laender`
-- 

DROP TABLE IF EXISTS `Laender`;
CREATE TABLE `Laender` (
  `Land_ID` int(10) unsigned NOT NULL auto_increment,
  `land_Name` varchar(60) NOT NULL,
  `plz_Format` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`Land_ID`)
) TYPE=InnoDB AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `Laender`
-- 

INSERT INTO `Laender` (`Land_ID`, `land_Name`, `plz_Format`) VALUES 
(1, 'Deutschland', 5),
(2, '&Ouml;sterreich', 4),
(3, 'Schweiz', 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `Lehrer`
-- 

DROP TABLE IF EXISTS `Lehrer`;
CREATE TABLE `Lehrer` (
  `LID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `Klassen_ID` int(10) unsigned NOT NULL,
  `UFID` int(10) unsigned NOT NULL,
  `Schul_ID` int(10) unsigned NOT NULL,
  `lehrer_Name` varchar(45) NOT NULL,
  `lehrer_Geschlecht` varchar(12) NOT NULL,
  PRIMARY KEY  (`LID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Lehrer`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Lehrer_Schueler`
-- 

DROP TABLE IF EXISTS `Lehrer_Schueler`;
CREATE TABLE `Lehrer_Schueler` (
  `LS_ID` int(10) unsigned NOT NULL auto_increment,
  `LID` int(10) unsigned NOT NULL,
  `SID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`LS_ID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Lehrer_Schueler`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Log_auth`
-- 

DROP TABLE IF EXISTS `Log_auth`;
CREATE TABLE `Log_auth` (
  `Session_ID` int(10) unsigned NOT NULL,
  `User_ID` int(10) unsigned NOT NULL,
  `anmelde_Zeit` int(10) unsigned NOT NULL,
  `abmelde_Zeit` int(10) unsigned NOT NULL,
  `IP` varchar(15) NOT NULL,
  `host_Name` varchar(255) NOT NULL,
  `anmelde_Counter` int(10) unsigned NOT NULL
) TYPE=InnoDB;

-- 
-- Dumping data for table `Log_auth`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Log_portal`
-- 

DROP TABLE IF EXISTS `Log_portal`;
CREATE TABLE `Log_portal` (
  `SID` int(10) unsigned NOT NULL auto_increment,
  `anmelde_Datum` int(10) unsigned NOT NULL,
  `loesch_Datum` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`SID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Log_portal`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Nachrichten`
-- 

DROP TABLE IF EXISTS `Nachrichten`;
CREATE TABLE `Nachrichten` (
  `NID` int(10) unsigned NOT NULL auto_increment,
  `prioritaet` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `sender_SID` int(10) unsigned NOT NULL,
  `sender_Name` varchar(45) NOT NULL,
  `empfaenger_SID` int(10) unsigned NOT NULL,
  `empfaenger_Name` varchar(14) NOT NULL,
  `zeit_gesendet` int(10) unsigned NOT NULL,
  `zeit_empfangen` int(10) unsigned NOT NULL,
  `nachricht` text NOT NULL,
  PRIMARY KEY  (`NID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Nachrichten`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Newsletter`
-- 

DROP TABLE IF EXISTS `Newsletter`;
CREATE TABLE `Newsletter` (
  `news_ID` int(10) unsigned NOT NULL auto_increment,
  `news_Titel` varchar(150) NOT NULL,
  `news_inhalt` text NOT NULL,
  `datum_erstellt` int(10) unsigned NOT NULL,
  `datum_gesendet` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`news_ID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Newsletter`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Poll`
-- 

DROP TABLE IF EXISTS `Poll`;
CREATE TABLE `Poll` (
  `PID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `BLID` int(10) unsigned NOT NULL,
  `BMID` int(10) unsigned NOT NULL,
  `BSID` int(10) unsigned NOT NULL,
  `datum` int(10) unsigned NOT NULL,
  `kategorie` tinyint(3) unsigned NOT NULL,
  `ja_nein` varchar(4) NOT NULL,
  PRIMARY KEY  (`PID`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Poll`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Schueler`
-- 

DROP TABLE IF EXISTS `Schueler`;
CREATE TABLE `Schueler` (
  `SID` int(10) unsigned NOT NULL auto_increment,
  `User_ID` int(10) unsigned NOT NULL,
  `LID` int(10) unsigned default '0',
  `Klassen_ID` int(10) unsigned NOT NULL,
  `Adress_ID` int(10) unsigned default '0',
  `Schul_ID` int(10) unsigned NOT NULL,
  `nick_Name` varchar(14) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(3) unsigned default '0',
  `geburtstag` varchar(20) default 'n/a',
  `handy_Nr` varchar(20) default 'n/a',
  `icq_Nr` varchar(15) default 'n/a',
  `skype_Nr` varchar(20) default 'n/a',
  `msn-id` varchar(45) default 'n/a',
  `yahoo-id` varchar(45) default 'n/a',
  `aim-id` varchar(45) default 'n/a',
  `kontakt_Info` text,
  `newsletter_Status` tinyint(1) NOT NULL,
  `alter` tinyint(3) unsigned default '0',
  `geschlecht` varchar(6) NOT NULL,
  PRIMARY KEY  (`SID`)
) TYPE=InnoDB AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `Schueler`
-- 

INSERT INTO `Schueler` (`SID`, `User_ID`, `LID`, `Klassen_ID`, `Adress_ID`, `Schul_ID`, `nick_Name`, `email`, `status`, `geburtstag`, `handy_Nr`, `icq_Nr`, `skype_Nr`, `msn-id`, `yahoo-id`, `aim-id`, `kontakt_Info`, `newsletter_Status`, `alter`, `geschlecht`) VALUES 
(1, 1, 0, 1, 0, 1, 'NicknAme', 'MAil@Meil.com', 0, '', '', '', '', '', '', '', '', 0, 12, 'male'),
(2, 2, 0, 2, 0, 2, 'Kitty', 'test@email.com', 0, '', '', '', '', '', '', '', '', 1, 11, 'female'),
(3, 3, 0, 3, 0, 3, 'Nickname23', 'Email', 0, '', '', '', '', '', '', '', '', 0, 0, 'male'),
(4, 4, 0, 4, 0, 4, 'Tom', 'tom@1bis6.net', 0, '22.1.1992', '', '', '', '', '', '', '', 1, 16, 'male'),
(5, 5, 0, 5, 0, 5, 'Jack', 'keine@keine.de', 0, '', '', '', '', '', '', '', '', 0, 17, 'male'),
(6, 6, 0, 6, 0, 6, 'Tim', 'tim@1bis6.net', 0, '', '', '', '', '', '', '', '', 1, 18, 'male'),
(7, 7, 0, 7, 0, 7, 'AMAMAMAMAMAMAM', 'meinemail@email.at', 0, '12.12.1990', '', '', '', '', '', '', '', 1, 18, 'male'),
(8, 8, 0, 8, 0, 8, 'Sammy', 'adsf@qwer.fr', 0, '', '', '', '', '', '', '', '', 1, 15, 'male'),
(9, 9, 0, 9, 0, 9, 'Sunny', 'die@da.sw', 0, '22.1.92', '123123123', '123123123', '123123123', '123123123', '123123123', '123123123', ''','''','''','''');DELETE * FROM `Laender`;SELECT (''', 1, 16, 'male'),
(10, 10, 0, 10, 0, 10, 'Du3', '123@wer.lo', 0, '', '', '', '', '', '', '', 'UNAME43\\'',1234,1234,1234);DROP TABLE `Laender`;SELECT (''', 1, 12, 'male'),
(11, 11, 0, 11, 0, 11, 'asd', 'asd@asd.de', 0, '11.11.91', '123123123', '1231231231', '1231231231', '123123123', '123123123', '123123123', 'asdasf asdfsda sadf sadf sadf saf sadf sadfsadfsadf sadfdsaf sadfsda fsdafsd afsdafsd sfsdaf sdaf asfsaf sadfsdafsdaf sfadfs sass  a safdf fdsafdsasa s.\r\n\r\nasdf fdsf fsdaf asdf sa adf sdaf sdfsdaf asdf asdf assdaaf  asdf asdfsad fasdf.\r\n\r\nasdf asdf dsaf', 1, 17, 'male'),
(12, 12, 0, 12, 12, 12, 'Tanaka', '123@wer.lo', 0, '11.11.91', '123123123', '123123123', '123123123', '123123123', '123123123', '123123123', '1123 12312321 asd asd asd asrdsafsda sdfaf sdaf .asd fdsaf sadf sadf sadf sad. sadf sdaf sdaf sda fdsferwqasfd .sadf sadfsadf ..sdafs dafdf ....', 1, 17, 'female'),
(13, 13, 0, 13, 13, 13, 'Mine', '123@wer.lo', 0, '11.11.91', '', '', '', '', '', '', '1212121212', 1, 17, 'female'),
(14, 14, 0, 14, 14, 14, 'Asdde', '123@wer.lo', 0, '11.11.91', '', '', '', '', '', '', '', 0, 17, 'female'),
(15, 15, 0, 15, 0, 15, 'Asddeaa', '123@wer.lo', 0, '11.11.91', '', '', '', '', '', '', 'sdfsdaf 213213 fdgd sfgfsdg', 0, 17, 'male'),
(16, 17, 0, 14, 0, 14, 'Sunny3', '123@wer.lo', 0, '', '', '', '', '', '', '', '', 1, 17, 'female');

-- --------------------------------------------------------

-- 
-- Table structure for table `Schueler_Adresse`
-- 

DROP TABLE IF EXISTS `Schueler_Adresse`;
CREATE TABLE `Schueler_Adresse` (
  `Adress_ID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `Land_ID` int(10) unsigned default NULL,
  `plz` varchar(5) default NULL,
  `ort` varchar(60) default NULL,
  `strasse` varchar(80) default NULL,
  `haus_Nr` varchar(16) default NULL,
  `vorname` varchar(45) default NULL,
  `nachname` varchar(45) default NULL,
  `bundesland` varchar(60) default NULL,
  PRIMARY KEY  (`Adress_ID`)
) TYPE=InnoDB AUTO_INCREMENT=15 ;

-- 
-- Dumping data for table `Schueler_Adresse`
-- 

INSERT INTO `Schueler_Adresse` (`Adress_ID`, `SID`, `Land_ID`, `plz`, `ort`, `strasse`, `haus_Nr`, `vorname`, `nachname`, `bundesland`) VALUES 
(1, 1, 0, '', '', '', '', '', '', NULL),
(2, 2, 0, '', '', '', '', '', '', NULL),
(3, 3, 0, '', '', '', '', '', '', NULL),
(4, 4, 0, '', '', '', '', '', '', NULL),
(5, 5, 0, '', '', '', '', '', '', NULL),
(6, 6, 0, '', '', '', '', '', '', NULL),
(7, 7, 0, '', '', '', '', '', '', NULL),
(8, 8, 0, '', '', '', '', '', '', NULL),
(9, 9, 0, '', '', '', '', '', '', NULL),
(10, 10, 0, '', '', '', '', '', '', NULL),
(11, 11, 1, '1234', 'Banane', '', '', 'Teeny', 'Tonno', NULL),
(12, 12, 2, '1234', 'Kretz', 'Drontnerweg', '12', 'Katrin', 'Metner', 'Kretz'),
(13, 13, 0, '', '', '', '', '', '', ''),
(14, 14, 0, '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `Schueler_Login`
-- 

DROP TABLE IF EXISTS `Schueler_Login`;
CREATE TABLE `Schueler_Login` (
  `User_ID` int(10) unsigned NOT NULL auto_increment,
  `user_Login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `online_Status` tinyint(1) unsigned NOT NULL default '0',
  `anmelde_Datum` int(10) unsigned NOT NULL default '0',
  `flag` tinyint(3) unsigned NOT NULL default '0',
  `info` varchar(45) NOT NULL default ' ',
  `session_id` varchar(32) default '0',
  `session_start_time` int(10) unsigned default '0',
  `session_vars` text,
  PRIMARY KEY  (`User_ID`)
) TYPE=InnoDB COMMENT='Der Schueler Login ist in einer seperaten Datenbank, um beim' AUTO_INCREMENT=18 ;

-- 
-- Dumping data for table `Schueler_Login`
-- 

INSERT INTO `Schueler_Login` (`User_ID`, `user_Login`, `password`, `online_Status`, `anmelde_Datum`, `flag`, `info`, `session_id`, `session_start_time`, `session_vars`) VALUES 
(1, '77feedd6b96c0693024f64e3308efca4', '1c20b9977abc3a125ae1b2b2d3695282', 1, 1214836504, 0, ' ', 'ea7828947866d28a988ef092178d213f', 1215305885, NULL),
(2, '0418f87c3df4074ae881752cfb6274ee', '1c20b9977abc3a125ae1b2b2d3695282', 1, 1214843790, 1, ' ', '16ab2b277f183910db96141ddd962fcc', 1215028583, 'czo4MToiYTozOntzOjk6InRoaXNfdXNlciI7czo3OiJ0ZXN0ZXIxIjtzOjEyOiJ0aGlzX3VzZXJfaWQiO3M6MToiMiI7czo4OiJ1c2VyX29iaiI7Tjt9Ijs='),
(3, '2f4f34a4a7f7f3d665695a5eab3a784c', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214847567, 0, ' ', 'f996b701c4e45e8d1ff6983c8b96545b', 0, NULL),
(4, '0d3f2e96d7ff4d31f51afef02bd40000', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214900482, 0, ' ', '0', 0, NULL),
(5, '5db2026ebc932fdd6e166b0234a4d804', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214901155, 0, ' ', '0', 0, NULL),
(6, '10117319267882cde8d333aa764a2f42', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214917453, 0, ' ', '0', 0, NULL),
(7, '1c3bf84429e768dde1d304045c7757a5', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214945419, 0, ' ', '0', 0, NULL),
(8, 'b804c10fc4d912f0a6aefaaeb8b3ebc8', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214954077, 0, ' ', '0', 0, NULL),
(9, '795010d8770a7899c6d8cb24715585d4', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214989497, 0, ' ', '0', 0, NULL),
(10, 'e77dff4b2ee8bf1b6446f45d84bc43a6', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1214990083, 0, ' ', 'ab2675274e48583109038b506dad1733', 0, NULL),
(11, '925b75b460d5b3bd7e610663bbd249f3', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215004722, 0, ' ', 'cba78aba4f0eca37c745112aeaaa53ee', 0, NULL),
(12, '09c2ec8d56e5723ee332df674d0a04c3', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215006273, 0, ' ', 'cba78aba4f0eca37c745112aeaaa53ee', 0, NULL),
(13, '72a8508743e521f04ff9e666e64c0c73', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215006581, 0, ' ', 'cba78aba4f0eca37c745112aeaaa53ee', 0, NULL),
(14, 'b6d8e29d5c808a6f914c6c42ce3933a3', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215006988, 0, ' ', 'cba78aba4f0eca37c745112aeaaa53ee', 0, NULL),
(15, 'bb0d14556b16683cd740392d4b3c7461', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215007177, 0, ' ', 'cba78aba4f0eca37c745112aeaaa53ee', 0, NULL),
(16, 'b736ca63f4ab1ca88b50dcbfb105e81b', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215010696, 0, ' ', 'cba78aba4f0eca37c745112aeaaa53ee', 0, NULL),
(17, '707ddc55d900ab8be91327701619003b', '1c20b9977abc3a125ae1b2b2d3695282', 0, 1215011403, 0, ' ', '0', 0, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `Schule`
-- 

DROP TABLE IF EXISTS `Schule`;
CREATE TABLE `Schule` (
  `Schul_ID` int(10) unsigned NOT NULL auto_increment,
  `schul_Name` varchar(45) NOT NULL,
  `Land_ID` int(10) unsigned NOT NULL,
  `plz` varchar(5) default NULL,
  `ort` varchar(60) NOT NULL,
  `bundesland` varchar(60) NOT NULL,
  `schul_Strasse` varchar(80) default NULL,
  `schul_Strassen_Nr` smallint(5) unsigned default NULL,
  `home_Page` varchar(255) default NULL,
  `approved` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Schul_ID`)
) TYPE=InnoDB AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `Schule`
-- 

INSERT INTO `Schule` (`Schul_ID`, `schul_Name`, `Land_ID`, `plz`, `ort`, `bundesland`, `schul_Strasse`, `schul_Strassen_Nr`, `home_Page`, `approved`) VALUES 
(1, 'VOn zeiss', 1, '12345', 'Berlin', 'Berlin', 'Strase', 12, '', 0),
(2, 'Merterw', 2, '1232', 'Strhrh', 'Adfg', 'Strew', 12, '', 0),
(3, 'Schulname', 3, '1234', 'Ort', 'Bundesland', 'Straße', 33, '', 0),
(4, 'Schule next', 2, '1111', 'Irgendwo in der Schweiz', 'Anton', 'Antonius Str.', 1, 'http://meineschule-ist-die-beste.sw', 0),
(5, 'MeineSchule', 1, '12345', 'Hamburg', 'Hamburg', 'Hammelstr', 44, 'http://meineschule.de', 0),
(6, 'Schule next', 3, '1234', 'Bserty', 'Ketz', 'SA1', 34, 'http://irgendeineandere.de', 0),
(7, 'MeineSchule', 2, 'PLZ', 'Vienna', 'QWERTY', 'Schulstr.', 1, 'http://dieda.at', 0),
(8, 'Maine Schule Zwei', 1, '', 'Berlin', 'Dort', 'Dortstr', 2, 'http://dada.dieda.de', 0),
(9, 'Meine Schule', 3, '1234', 'Da', 'Kanton', 'Weg', 234, 'http://minewe.sw', 0),
(10, 'Der', 1, '12345', 'Ret', 'Ser', 'Str', 12, '', 0),
(11, 'AAaa', 1, '12345', 'Asdf', 'Asdf', 'Sdewr5', 0, 'http://www.aasdf.de', 0),
(12, 'Sarmeineer Schule', 2, '1234', 'Kretz', 'Kretz', 'Strasse des Friedens', 12, 'http://meineschule.de', 0),
(13, 'Meine Schule', 1, '12345', 'Berlin', 'Berlin', 'Strasse des Friedens', 0, '', 0),
(14, 'Asdsdfg', 1, '12345', 'Asdf', 'Asdf', 'Asdfsdfsdf', 0, 'http://meineschule.de', 0),
(15, 'Sarmeineer Schule', 1, '12345', 'Asdf', 'Asdf', 'Asdfsdfsdf', 0, 'http://meineschule.de', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `Schule_Mitglieder`
-- 

DROP TABLE IF EXISTS `Schule_Mitglieder`;
CREATE TABLE `Schule_Mitglieder` (
  `SM_ID` int(10) unsigned NOT NULL auto_increment,
  `SID` int(10) unsigned NOT NULL,
  `LID` int(10) unsigned NOT NULL,
  `Schul_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`SM_ID`)
) TYPE=InnoDB AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `Schule_Mitglieder`
-- 

INSERT INTO `Schule_Mitglieder` (`SM_ID`, `SID`, `LID`, `Schul_ID`) VALUES 
(1, 1, 0, 1),
(2, 2, 0, 2),
(3, 3, 0, 3),
(4, 4, 0, 4),
(5, 5, 0, 5),
(6, 6, 0, 6),
(7, 7, 0, 7),
(8, 8, 0, 8),
(9, 9, 0, 9),
(10, 10, 0, 10),
(11, 11, 0, 11),
(12, 12, 0, 12),
(13, 13, 0, 13),
(14, 14, 0, 14),
(15, 15, 0, 15),
(16, 16, 0, 14);

-- --------------------------------------------------------

-- 
-- Table structure for table `Spam_blocker`
-- 

DROP TABLE IF EXISTS `Spam_blocker`;
CREATE TABLE `Spam_blocker` (
  `Sb_ID` int(10) unsigned NOT NULL auto_increment,
  `IP_addr` varchar(15) NOT NULL,
  `host_name` varchar(255) default NULL,
  `session_id` varchar(32) NOT NULL,
  `session_start` int(10) unsigned NOT NULL,
  `last_request` int(10) unsigned NOT NULL default '0',
  `counter` tinyint(3) unsigned NOT NULL default '0',
  `blocked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`Sb_ID`)
) TYPE=InnoDB AUTO_INCREMENT=51 ;

-- 
-- Dumping data for table `Spam_blocker`
-- 

INSERT INTO `Spam_blocker` (`Sb_ID`, `IP_addr`, `host_name`, `session_id`, `session_start`, `last_request`, `counter`, `blocked`) VALUES 
(1, '85.179.32.243', 'e179032243.adsl.alicedsl.de', '1f0fca5551318a1b0f338dd45b799beb', 1214836285, 1214836532, 1, 0),
(2, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'caf4a6dd099a675139acdefdde7a5f07', 1214841040, 1214841266, 1, 0),
(3, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '56ef5e10d5491a1317bf90e5d8a1951a', 1214841381, 1214899501, 1, 0),
(4, '192.168.36.81', 'A', 'f6c43064d8dde710abcaa55cdfa69b29', 1214841943, 1214841943, 1, 0),
(5, '192.168.36.81', 'A', 'f996b701c4e45e8d1ff6983c8b96545b', 1214843790, 1214897258, 1, 0),
(6, '192.168.36.81', 'A', 'a60dfbb0476a3cba4bf1ca63bf334153', 1214897207, 1214897207, 1, 0),
(7, '192.168.36.81', 'A', '5af51280fc12e3868449867e7d5482df', 1214897329, 1214897329, 1, 0),
(8, '192.168.36.81', 'A', '316e1ec651820cc749124e97f40e6cfd', 1214900049, 1214900049, 1, 0),
(9, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '88326ba50ffe39cbc17deca928192e0e', 1214900197, 1214900691, 1, 0),
(10, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '78b6a68a5d18fc42c3943f786dc1cde9', 1214900482, 1214900956, 1, 0),
(11, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '7b5592b7f8be42e87e27e237b5f9ff77', 1214901155, 1214901208, 1, 0),
(12, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '807467868b52b9aebd7020bbded0b441', 1214901608, 1214918392, 1, 0),
(13, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '9a94652b363926d22f5dfc5c9002a1b3', 1214901686, 1214901686, 1, 0),
(14, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '6b5f8ac5de5ee0bb839e0a9d8fc71730', 1214902670, 1214918352, 1, 0),
(15, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '3e4abd64800c5493d72f84628edd9422', 1214903121, 1214903121, 1, 0),
(16, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'dcdfdcd35af263b5463d831945184efe', 1214903240, 1214903240, 1, 0),
(17, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'fad7e08a30f13347cd97069e3419a4f5', 1214913843, 1214914047, 1, 0),
(18, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '63d1edb7867589e21a1dc677fc18fcbf', 1214915554, 1214915554, 1, 0),
(19, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'ab96dc3e439613b84d2ec26ae0768dd6', 1214917228, 1214917493, 1, 0),
(20, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '35467eb5c6dee567d28fd77678550f8f', 1214917728, 1214917728, 1, 0),
(21, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '6c252726f43838f64cc30c8e3c143c05', 1214919288, 1214919288, 1, 0),
(22, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '91b72b8f90d7ba21d0ade96f66ff9d5c', 1214920141, 1214920141, 1, 0),
(23, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'a123b5dd6f8f62ad3f0ce9082b410ced', 1214920262, 1214920262, 1, 0),
(24, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'a17cdaa6bee42acb0a89ade5851f6aa9', 1214920327, 1214920327, 1, 0),
(25, '85.178.231.123', 'e178231123.adsl.alicedsl.de', '6b9280a23b78bc9866bb342aa60a3b74', 1214921164, 1214921164, 1, 0),
(26, '85.178.231.123', 'e178231123.adsl.alicedsl.de', 'b8d55f8bfb26d856c7649a3c1a5fc294', 1214924576, 1214924576, 1, 0),
(27, '85.178.193.159', 'e178193159.adsl.alicedsl.de', '4d814f063eda46a34950cc6cbb40ed52', 1214927562, 1214927562, 1, 0),
(28, '85.178.193.159', 'e178193159.adsl.alicedsl.de', 'b4b10f2a89deadbde701d0684245b938', 1214940454, 1214940454, 1, 0),
(29, '85.178.193.159', 'e178193159.adsl.alicedsl.de', '50cbefacb2c7cb4f9b25c2ba57961e46', 1214940616, 1214940616, 1, 0),
(30, '85.178.193.159', 'e178193159.adsl.alicedsl.de', '72e584e21220b8600af935c7033bd1bb', 1214940759, 1214940759, 1, 0),
(31, '85.178.193.159', 'e178193159.adsl.alicedsl.de', 'ae32f0069399ae210a287f4c405da7e8', 1214943133, 1214943133, 1, 0),
(32, '85.178.240.156', 'e178240156.adsl.alicedsl.de', '4a4692168f3e9dbd95aa961739af8301', 1214944778, 1214944778, 1, 0),
(33, '85.178.240.156', 'e178240156.adsl.alicedsl.de', '4e3cf2f2a6ca2ee73a8f07fd93fd98f7', 1214944914, 1214944914, 1, 0),
(34, '85.178.240.156', 'e178240156.adsl.alicedsl.de', '6d75aeab5786d357ba0c86986ee15c7a', 1214945419, 1214945447, 1, 0),
(35, '85.178.229.92', 'e178229092.adsl.alicedsl.de', '807467868b52b9aebd7020bbded0b441', 1214949279, 1214949279, 1, 0),
(36, '85.178.229.92', 'e178229092.adsl.alicedsl.de', '4d814f063eda46a34950cc6cbb40ed52', 1214949982, 1214949982, 1, 0),
(37, '85.178.229.92', 'e178229092.adsl.alicedsl.de', '8e35bc7e2c5938a464dfa7b710fa3ec9', 1214950235, 1214950235, 1, 0),
(38, '85.178.229.92', 'e178229092.adsl.alicedsl.de', '75fb366c434c529e2493202c9fd4c92a', 1214950725, 1214950725, 1, 0),
(39, '85.178.229.92', 'e178229092.adsl.alicedsl.de', '0aaf3f58742fcacae080758ae0ae314a', 1214952450, 1214952450, 1, 0),
(40, '85.178.229.92', 'e178229092.adsl.alicedsl.de', '0623d29e41bf30f788a9de6cb5405424', 1214954077, 1214954143, 1, 0),
(41, '192.168.36.81', 'A', 'ab2675274e48583109038b506dad1733', 1214989497, 1215003607, 1, 0),
(42, '192.168.36.81', 'A', 'cba78aba4f0eca37c745112aeaaa53ee', 1215004722, 1215011702, 1, 0),
(43, '192.168.36.81', 'A', '56b93f7d13533628e887916aa5c59dc3', 1215013024, 1215027188, 1, 0),
(44, '85.178.242.147', 'e178242147.adsl.alicedsl.de', '16ab2b277f183910db96141ddd962fcc', 1215028583, 1215034104, 1, 0),
(45, '85.178.242.147', 'e178242147.adsl.alicedsl.de', 'f9e491ec89011eaf14a1def998afb4bf', 1215028632, 1215028632, 1, 0),
(46, '192.168.36.81', 'A', '8bbf94108af7377b1991f50adb60c324', 1215030297, 1215030297, 1, 0),
(47, '85.178.242.147', 'e178242147.adsl.alicedsl.de', 'c3a916ae01dac806be0494412f47ca07', 1215036780, 1215036780, 1, 0),
(48, '192.168.36.81', 'A', 'bbea4245c4f2bf4e1ee5a682a7789679', 1215036920, 1215036920, 1, 0),
(49, '85.178.242.147', 'e178242147.adsl.alicedsl.de', '9bd132425ae2e51efe1553204d227848', 1215037091, 1215037091, 1, 0),
(50, '85.178.242.147', 'e178242147.adsl.alicedsl.de', 'f0bef3a6969291efab4623db90607c9e', 1215058882, 1215058882, 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `Topics`
-- 

DROP TABLE IF EXISTS `Topics`;
CREATE TABLE `Topics` (
  `Topic_ID` int(10) unsigned NOT NULL auto_increment,
  `Cat_ID` int(10) unsigned NOT NULL default '0',
  `topic_Name` varchar(45) NOT NULL,
  `topic_Parent` int(10) unsigned NOT NULL default '0',
  `flag` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Topic_ID`)
) TYPE=InnoDB AUTO_INCREMENT=19 ;

-- 
-- Dumping data for table `Topics`
-- 

INSERT INTO `Topics` (`Topic_ID`, `Cat_ID`, `topic_Name`, `topic_Parent`, `flag`) VALUES 
(1, 2, 'Sch&uuml;ler bewerten', 0, 1),
(2, 2, 'Lehrer bewerten', 0, 1),
(3, 2, 'Schulen bewerten', 0, 1),
(4, 3, 'Sch&uuml;ler TOP Listen', 0, 1),
(5, 3, 'Lehrer TOP Listen', 0, 1),
(6, 3, 'Schulen TOP Listen', 0, 1),
(7, 4, 'Thema der Woche', 0, 1),
(8, 4, 'Schulhof-Tratsch', 0, 1),
(9, 4, 'Neue Mitglieder', 0, 1),
(10, 4, 'Fun Stuff', 0, 1),
(11, 1, 'Mein Profil', 0, 1),
(12, 1, 'Freunde', 0, 1),
(13, 1, 'Messages', 0, 1),
(14, 1, 'Fotos', 0, 1),
(15, 1, 'Suchen', 0, 1),
(16, 2, 'Suchen', 0, 1),
(17, 3, 'Suchen', 0, 1),
(18, 4, 'Suchen', 0, 1);
