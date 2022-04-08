drop database if exists repulosdb;

create database repulosdb
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
    
use repulosdb;

/* Táblák elkészítése */
create table utas(
	id int primary key auto_increment,
	nev nvarchar(45),
	email nvarchar(45),
	telefon nvarchar(45),
	szemelyigazolvanyszam nvarchar(10)
);

create table jarat(
	id int primary key auto_increment,
	honnan nvarchar(45),
	hova nvarchar(45),
    maxkapacitas int,
    tipus nvarchar(45),
	ar int
);

create table jegy(
	id int primary key auto_increment,
	utasid int not null,
	jaratid int not null,
	vasardatum date,
	
	foreign key (utasid) references utas(id),
	foreign key (jaratid) references jarat(id)
);
/* Táblák feltöltése */

insert into utas(nev, email, telefon) values ('Kovacs Tamas', 'kovacs.tamas@aait.bme.hu', '12345678','42A253');
insert into utas(nev, email, telefon) values ('Nagy Julia', 'nagy.julia@aait.bme.hu', '23456781','65RAB9');
insert into utas(nev, email, telefon) values ('Sujbert Laszlo', 'sujbert.laszlo@notmit.bme.hu', '34567812','77R89C');

insert into jarat(honnan, hova, maxkapacitas, tipus, ar) values ('Budapest', 'London', '5','Boeing-42', 50000);
insert into jarat(honnan, hova, maxkapacitas, tipus, ar) values ('Budapest', 'Parizs', '5','Boeing-42', 45000);
insert into jarat(honnan, hova, maxkapacitas, tipus, ar) values ('Debrecen', 'London', '2','Dodo', 70000);
insert into jarat(honnan, hova, maxkapacitas, tipus, ar) values ('Debrecen', 'London', '5','Boeing-42', 70000);
insert into jarat(honnan, hova, maxkapacitas, tipus, ar) values ('Debrecen', 'London', '3','Ripazha', 70000);

insert into jegy(utasid, jaratid, vasardatum) values(1, 1, '2020-04-12');
insert into jegy(utasid, jaratid, vasardatum) values(2, 1, '2020-04-10');
insert into jegy(utasid, jaratid, vasardatum) values(3, 3, '2020-04-15');
