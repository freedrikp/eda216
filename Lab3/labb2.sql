-- Delete the tables if they exist. Set foreign_key_checks = 0 to
-- disable foreign key checks, so the tables may be dropped in
-- arbitrary order.
set foreign_key_checks = 0;
drop table if exists Users;
drop table if exists Theaters;
drop table if exists Movies;
drop table if exists Shows;
drop table if exists Reservations;
set foreign_key_checks = 1;

-- Create the tables.
create table Users (
	uName	varchar(20),
	address	varchar(30),
	phNbr	varchar(20) not null,
	primary key (uName)
);
create table Theaters (
	tName		varchar(20),
	capacity	integer not null,
	primary key (tName)
);
create table Movies (
	mName	varchar(40),
	primary key (mName)
);
create table Shows (
	sDate	date,
	mName	varchar(40),
	tName	varchar(20),
	nbrBooked integer,
	primary key (sDate,mName),
	foreign key (mName) references Movies(mName),
	foreign key (tName) references Theaters(tName)
);
create table Reservations (
	rNbr	integer auto_increment,
	uName	varchar(20),
	sDate	date,
	mName	varchar(40),
	primary key (rNbr),
	foreign key (uName) references Users(uName),
	foreign key (sDate,mName) references Shows(sDate,mName)
);

-- Insert data into the tables.
insert into Users values('Nisse','hemmavägen 1','12345-123');
insert into Users values('Taylor','nyc äpple','070-xoxoxoxo');
insert into Theaters values('Röda Kvarn',200);
insert into Theaters values('Fredriks hemmabio',20);
insert into Movies values('Star Wars - The Force Awakens');
insert into Movies values('James Bond - Spectre');
insert into Movies values('Spaceballs');
insert into Movies values('Alien');
insert into Movies values('Taken');
insert into Shows values('2015-02-02','Star Wars - The Force Awakens','Fredriks hemmabio',1);
insert into Shows values('2015-12-03','Star Wars - The Force Awakens','Röda Kvarn',0);
insert into Shows values('2015-03-02','James Bond - Spectre','Fredriks hemmabio',1);
insert into Shows values('2015-05-02','James Bond - Spectre','Röda Kvarn',0);
insert into Shows values('2015-07-02','Spaceballs','Röda Kvarn',0);
insert into Shows values('2015-05-08','Alien','Fredriks hemmabio',0);
insert into Shows values('2015-05-16','Taken','Röda Kvarn',0);
insert into Reservations(uName,sDate,mName) values('Nisse','2015-02-02','Star Wars - The Force Awakens');
insert into Reservations(uName,sDate,mName) values('Taylor','2015-03-02','James Bond - Spectre');
