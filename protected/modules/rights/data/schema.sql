DELETE FROM mysql.user WHERE User = 'kajak';
CREATE USER 'kajak'@'localhost' IDENTIFIED BY '6rQAVXYnz7spUqr4';
GRANT ALL PRIVILEGES ON *.* TO 'kajak'@'localhost' WITH GRANT OPTION;
drop database if exists kajak_rights;
create database kajak_rights;
use 'kajak_rights';
drop table if exists authitem;
drop table if exists authitemChild;
drop table if exists authassignment;
drop table if exists rights;

create table authitem
(
   name varchar(64) not null,
   type integer not null,
   description text,
   bizrule text,
   data text,
   primary key (name)
);

create table authitemchild
(
   parent varchar(64) not null,
   child varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references authitem (name) on delete cascade on update cascade,
   foreign key (child) references authitem (name) on delete cascade on update cascade
);

create table authassignment
(
   itemname varchar(64) not null,
   userid varchar(64) not null,
   bizrule text,
   data text,
   primary key (itemname,userid),
   foreign key (itemname) references authitem (name) on delete cascade on update cascade
);

create table rights
(
	itemname varchar(64) not null,
	type integer not null,
	weight integer not null,
	primary key (itemname),
	foreign key (itemname) references authitem (name) on delete cascade on update cascade
);

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '4e5fc6aae20128417e660000', NULL, 'N;'),
('Moderator', '4e5fc6aae20128417e660000', NULL, 'N;');

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, 'Administrator systemu', NULL, 'N;'),
('Moderator', 2, 'Moderator sytemowy', NULL, 'N;');
