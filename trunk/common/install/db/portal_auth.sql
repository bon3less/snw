DROP DATABASE IF EXISTS `portal_auth`;
CREATE DATABASE `portal_auth`;
USE portal_auth;
CREATE TABLE `Admin_Login` (  `AID` int(10) unsigned NOT NULL auto_increment,  `admin_Name` varchar(16) NOT NULL,  `admin_Password` varchar(32) NOT NULL,  PRIMARY KEY  (`AID`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
INSERT INTO `Admin_Login` (`AID`, `admin_Name`, `admin_Password`) VALUES (1, 'admin', '21232F297A57A5A743894A0E4A801FC3');
CREATE TABLE `Log` (  `Session_ID` int(10) unsigned NOT NULL,  `User_ID` int(10) unsigned NOT NULL,  `anmelde_Zeit` int(10) unsigned NOT NULL,  `abmelde_Zeit` int(10) unsigned NOT NULL, `IP` varchar(15) NOT NULL,  `host_Name` varchar(255) NOT NULL,  `anmelde_Counter` int(10) unsigned NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `Schueler_Login` (  `UserID` int(10) unsigned NOT NULL auto_increment,  `user_Name` varchar(16) NOT NULL,  `password` varchar(32) NOT NULL, `online_Status` tinyint(1) unsigned NOT NULL default '0',  `datum` int(10) unsigned NOT NULL default '0',  PRIMARY KEY  (`UserID`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Der Schueler Login ist in einer seperaten Datenbank, um beim' AUTO_INCREMENT=2 ;
INSERT INTO `Schueler_Login` (`UserID`, `user_Name`, `password`, `online_Status`, `datum`) VALUES (1, 'test', '098F6BCD4621D373CADE4E832627B4F6', 0, 0);