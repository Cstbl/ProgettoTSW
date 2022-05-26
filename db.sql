

drop table if exists preferenzaFilm;
drop table if exists commentoFilm;
drop table if exists preferenzaSerie;
drop table if exists commentoSerie;
drop table if exists utente;
drop table if exists film;
drop table if exists serie;


create table utente(
	username varchar(30) primary key,
	email varchar(30) not null unique,
	passwd varchar(255) not null,
	nascita date not null,
	tipologia varchar(1) not null,
	data_fine date not null,
    constraint controlla_scadenza check (data_fine > current_date)
);
	
create table film(
	codice varchar(30) primary key,
	uscita date not null unique,
	rating varchar(30),
	trama varchar(255)not null,
	tipologia varchar(30) not null,
	titolo varchar(30) not null,
	durata varchar(30) not null,
	href varchar(255) not null,
	regista varchar(30) not null,
	attori varchar(255) not null);
	
create table serie(
	codice varchar(30) primary key,
	uscita date not null,
	rating varchar(30),
	trama varchar(255)not null,
	tipologia varchar(30) not null,
	titolo varchar(30) not null,
	durata_episodi varchar(30) not null,
	numero_episodi integer not null);
	
create table preferenzaSerie(
	utente varchar(30) references utente(username) on delete cascade on update cascade,
	serie varchar(30) references serie(codice) on delete cascade on update cascade,
	constraint pk_pref_serie Primary Key (utente,serie));

create table preferenzaFilm(
	utente varchar(30) references utente(username) on delete cascade on update cascade,
	film varchar(30) references film(codice) on delete cascade on update cascade,
	constraint pk_pref_film Primary Key (utente,film));

create table commentoSerie(
	utente varchar(30) references utente(username) on delete cascade on update cascade,
	serie varchar(30) references serie(codice) on delete cascade on update cascade,
	testo varchar(255) not null,
	constraint pk_commento_serie Primary Key (utente,serie));

create table commentoFilm(
	utente varchar(30) references utente(username) on delete cascade on update cascade,
	film varchar(30) references film(codice) on delete cascade on update cascade,
	testo varchar(255) not null,
	constraint pk_commento_film Primary Key (utente,film));
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

CREATE EVENT IF NOT EXISTS Aggiornamento
ON SCHEDULE
    EVERY 1 DAY
COMMENT 'Aggiornamento_expireData'
DO
    BEGIN
    
    UPDATE SET tipologia='0' FROM Utente WHERE DateCol < current_date();
    
    END