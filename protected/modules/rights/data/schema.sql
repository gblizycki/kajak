DELETE FROM mysql.user WHERE User = 'kajak';
CREATE USER 'kajak'@'localhost' IDENTIFIED BY '6rQAVXYnz7spUqr4';
GRANT ALL PRIVILEGES ON *.* TO 'kajak'@'localhost' WITH GRANT OPTION;
drop database if exists kajak_rights;
create database kajak_rights;
use 'kajak_rights';
CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '4e5fc6aae20128417e660000', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, 'Administrator systemu', NULL, 'N;'),
('Area.*', 1, NULL, NULL, 'N;'),
('Area.Admin', 0, NULL, NULL, 'N;'),
('Area.Create', 0, NULL, NULL, 'N;'),
('Area.Delete', 0, NULL, NULL, 'N;'),
('Area.Update', 0, NULL, NULL, 'N;'),
('Area.View', 0, NULL, NULL, 'N;'),
('Categoryarea.*', 1, NULL, NULL, 'N;'),
('Categoryarea.Admin', 0, NULL, NULL, 'N;'),
('Categoryarea.Create', 0, NULL, NULL, 'N;'),
('Categoryarea.Delete', 0, NULL, NULL, 'N;'),
('Categoryarea.Update', 0, NULL, NULL, 'N;'),
('Categoryarea.View', 0, NULL, NULL, 'N;'),
('Categoryplace.*', 1, NULL, NULL, 'N;'),
('Categoryplace.Admin', 0, NULL, NULL, 'N;'),
('Categoryplace.Create', 0, NULL, NULL, 'N;'),
('Categoryplace.Delete', 0, NULL, NULL, 'N;'),
('Categoryplace.Index', 0, NULL, NULL, 'N;'),
('Categoryplace.Update', 0, NULL, NULL, 'N;'),
('Categoryplace.View', 0, NULL, NULL, 'N;'),
('Categorypoint.*', 1, NULL, NULL, 'N;'),
('Categorypoint.Admin', 0, NULL, NULL, 'N;'),
('Categorypoint.Create', 0, NULL, NULL, 'N;'),
('Categorypoint.Delete', 0, NULL, NULL, 'N;'),
('Categorypoint.Index', 0, NULL, NULL, 'N;'),
('Categorypoint.Update', 0, NULL, NULL, 'N;'),
('Categorypoint.View', 0, NULL, NULL, 'N;'),
('Categoryroute.*', 1, NULL, NULL, 'N;'),
('Categoryroute.Admin', 0, NULL, NULL, 'N;'),
('Categoryroute.Create', 0, NULL, NULL, 'N;'),
('Categoryroute.Delete', 0, NULL, NULL, 'N;'),
('Categoryroute.Index', 0, NULL, NULL, 'N;'),
('Categoryroute.Update', 0, NULL, NULL, 'N;'),
('Categoryroute.View', 0, NULL, NULL, 'N;'),
('Dataexchange.Areapending.*', 1, NULL, NULL, 'N;'),
('Dataexchange.Areapending.Admin', 0, NULL, NULL, 'N;'),
('Dataexchange.Areapending.Create', 0, NULL, NULL, 'N;'),
('Dataexchange.Areapending.Delete', 0, NULL, NULL, 'N;'),
('Dataexchange.Areapending.Update', 0, NULL, NULL, 'N;'),
('Dataexchange.Areapending.View', 0, NULL, NULL, 'N;'),
('Dataexchange.Importer.*', 1, NULL, NULL, 'N;'),
('Dataexchange.Importer.Index', 0, NULL, NULL, 'N;'),
('Dataexchange.Importer.Select', 0, NULL, NULL, 'N;'),
('Dataexchange.Importer.SelectDb', 0, NULL, NULL, 'N;'),
('Dataexchange.Importer.SelectFile', 0, NULL, NULL, 'N;'),
('Dataexchange.Importer.SelectProvider', 0, NULL, NULL, 'N;'),
('Dataexchange.Placepending.*', 1, NULL, NULL, 'N;'),
('Dataexchange.Placepending.Admin', 0, NULL, NULL, 'N;'),
('Dataexchange.Placepending.Create', 0, NULL, NULL, 'N;'),
('Dataexchange.Placepending.Delete', 0, NULL, NULL, 'N;'),
('Dataexchange.Placepending.Update', 0, NULL, NULL, 'N;'),
('Dataexchange.Placepending.View', 0, NULL, NULL, 'N;'),
('Dataexchange.Routepending.*', 1, NULL, NULL, 'N;'),
('Dataexchange.Routepending.Accept', 0, NULL, NULL, 'N;'),
('Dataexchange.Routepending.Admin', 0, NULL, NULL, 'N;'),
('Dataexchange.Routepending.Create', 0, NULL, NULL, 'N;'),
('Dataexchange.Routepending.Delete', 0, NULL, NULL, 'N;'),
('Dataexchange.Routepending.Update', 0, NULL, NULL, 'N;'),
('Dataexchange.Routepending.View', 0, NULL, NULL, 'N;'),
('Datasource.*', 1, NULL, NULL, 'N;'),
('Datasource.Admin', 0, NULL, NULL, 'N;'),
('Datasource.Create', 0, NULL, NULL, 'N;'),
('Datasource.Delete', 0, NULL, NULL, 'N;'),
('Datasource.Index', 0, NULL, NULL, 'N;'),
('Datasource.Update', 0, NULL, NULL, 'N;'),
('Datasource.View', 0, NULL, NULL, 'N;'),
('Js.*', 1, NULL, NULL, 'N;'),
('Js.Data', 0, NULL, NULL, 'N;'),
('Js.Edit', 0, NULL, NULL, 'N;'),
('Js.Filter', 0, NULL, NULL, 'N;'),
('Js.View', 0, NULL, NULL, 'N;'),
('Moderator', 2, 'Moderator sytemowy', NULL, 'N;'),
('Place.*', 1, NULL, NULL, 'N;'),
('Place.Admin', 0, NULL, NULL, 'N;'),
('Place.Create', 0, NULL, NULL, 'N;'),
('Place.Delete', 0, NULL, NULL, 'N;'),
('Place.Update', 0, NULL, NULL, 'N;'),
('Place.View', 0, NULL, NULL, 'N;'),
('Route.*', 1, NULL, NULL, 'N;'),
('Route.Admin', 0, NULL, NULL, 'N;'),
('Route.Create', 0, NULL, NULL, 'N;'),
('Route.Delete', 0, NULL, NULL, 'N;'),
('Route.Update', 0, NULL, NULL, 'N;'),
('Route.View', 0, NULL, NULL, 'N;'),
('Site.*', 1, NULL, NULL, 'N;'),
('Site.Admin', 0, NULL, NULL, 'N;'),
('Site.Error', 0, NULL, NULL, 'N;'),
('Site.Index', 0, NULL, NULL, 'N;'),
('Site.Login', 0, NULL, NULL, 'N;'),
('Site.Logout', 0, NULL, NULL, 'N;'),
('User.*', 1, NULL, NULL, 'N;'),
('User.Admin', 0, NULL, NULL, 'N;'),
('User.Create', 0, NULL, NULL, 'N;'),
('User.Delete', 0, NULL, NULL, 'N;'),
('User.Update', 0, NULL, NULL, 'N;'),
('User.View', 0, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('Moderator', 'Area.*'),
('Area.*', 'Area.Admin'),
('Area.*', 'Area.Create'),
('Area.*', 'Area.Delete'),
('Area.*', 'Area.Update'),
('Area.*', 'Area.View'),
('Moderator', 'Categoryarea.*'),
('Categoryarea.*', 'Categoryarea.Admin'),
('Categoryroute.*', 'Categoryarea.Admin'),
('Categoryarea.*', 'Categoryarea.Create'),
('Categoryroute.*', 'Categoryarea.Create'),
('Categoryarea.*', 'Categoryarea.Delete'),
('Categoryroute.*', 'Categoryarea.Delete'),
('Categoryarea.*', 'Categoryarea.Update'),
('Categoryroute.*', 'Categoryarea.Update'),
('Categoryarea.*', 'Categoryarea.View'),
('Categoryroute.*', 'Categoryarea.View'),
('Moderator', 'Categoryplace.*'),
('Categoryplace.*', 'Categoryplace.Admin'),
('Categoryplace.*', 'Categoryplace.Create'),
('Categoryplace.*', 'Categoryplace.Delete'),
('Categoryplace.*', 'Categoryplace.Update'),
('Categoryplace.*', 'Categoryplace.View'),
('Moderator', 'Categoryroute.*'),
('Moderator', 'Dataexchange.Areapending.*'),
('Dataexchange.Areapending.*', 'Dataexchange.Areapending.Admin'),
('Dataexchange.Areapending.*', 'Dataexchange.Areapending.Create'),
('Dataexchange.Areapending.*', 'Dataexchange.Areapending.Delete'),
('Dataexchange.Areapending.*', 'Dataexchange.Areapending.Update'),
('Dataexchange.Areapending.*', 'Dataexchange.Areapending.View'),
('Dataexchange.Importer.*', 'Dataexchange.Importer.Index'),
('Dataexchange.Importer.*', 'Dataexchange.Importer.Select'),
('Dataexchange.Importer.*', 'Dataexchange.Importer.SelectDb'),
('Dataexchange.Importer.*', 'Dataexchange.Importer.SelectFile'),
('Dataexchange.Importer.*', 'Dataexchange.Importer.SelectProvider'),
('Moderator', 'Dataexchange.Placepending.*'),
('Dataexchange.Placepending.*', 'Dataexchange.Placepending.Admin'),
('Dataexchange.Placepending.*', 'Dataexchange.Placepending.Create'),
('Dataexchange.Placepending.*', 'Dataexchange.Placepending.Delete'),
('Dataexchange.Placepending.*', 'Dataexchange.Placepending.Update'),
('Dataexchange.Placepending.*', 'Dataexchange.Placepending.View'),
('Moderator', 'Dataexchange.Routepending.*'),
('Dataexchange.Routepending.*', 'Dataexchange.Routepending.Accept'),
('Dataexchange.Routepending.*', 'Dataexchange.Routepending.Admin'),
('Dataexchange.Routepending.*', 'Dataexchange.Routepending.Create'),
('Dataexchange.Routepending.*', 'Dataexchange.Routepending.Delete'),
('Dataexchange.Routepending.*', 'Dataexchange.Routepending.Update'),
('Dataexchange.Routepending.*', 'Dataexchange.Routepending.View'),
('Datasource.*', 'Datasource.Admin'),
('Datasource.*', 'Datasource.Create'),
('Datasource.*', 'Datasource.Delete'),
('Datasource.*', 'Datasource.Index'),
('Datasource.*', 'Datasource.Update'),
('Datasource.*', 'Datasource.View'),
('Js.*', 'Js.Data'),
('Js.*', 'Js.Edit'),
('Js.*', 'Js.Filter'),
('Js.*', 'Js.View'),
('Moderator', 'Place.*'),
('Place.*', 'Place.Admin'),
('Place.*', 'Place.Create'),
('Place.*', 'Place.Delete'),
('Place.*', 'Place.Update'),
('Place.*', 'Place.View'),
('Moderator', 'Route.*'),
('Route.*', 'Route.Admin'),
('Route.*', 'Route.Create'),
('Route.*', 'Route.Delete'),
('Route.*', 'Route.Update'),
('Route.*', 'Route.View'),
('Moderator', 'Site.*'),
('Site.*', 'Site.Admin'),
('User.*', 'User.Admin'),
('User.*', 'User.Create'),
('User.*', 'User.Delete'),
('User.*', 'User.Update'),
('User.*', 'User.View');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `authassignment`
--
ALTER TABLE `authassignment`
  ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `rights`
--
ALTER TABLE `rights`
  ADD CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
