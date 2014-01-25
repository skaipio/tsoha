CREATE TABLE henkilostoluokka
(
	nimi varchar(45) primary key
);
CREATE TABLE kiireellisyysluokka
(
	nimi varchar(45) primary key
);
CREATE TABLE minimivahvuus
(
	kiireellisyysluokka_nimi varchar(45) references kiireellisyysluokka(nimi) ON DELETE cascade,
	henkilostoluokka_nimi varchar(45) references henkilostoluokka(nimi) ON DELETE cascade,
	minimi integer NOT NULL,
	primary key (kiireellisyysluokka_nimi, henkilostoluokka_nimi)
);
CREATE TABLE tyontekija
(
	id serial primary key,
	kayttajanimi varchar(45) UNIQUE NOT NULL,
	salasana varchar(45) NOT NULL,
	sahkoposti varchar(45) UNIQUE NOT NULL,
	yllapitaja boolean NOT NULL,
	etunimi varchar(45) NOT NULL,
	sukunimi varchar(45) NOT NULL,
	hetu varchar(45) UNIQUE NOT NULL,
	osoite varchar(100) NOT NULL,
	henkilostoluokka_nimi varchar(45) NOT NULL references henkilostoluokka(nimi),
	maxtunnitpaivassa integer NOT NULL,
	maxtunnitviikossa integer NOT NULL
);

CREATE TABLE aukiolotunti
(
	paivamaara date,
	tunti time,
	kiireellisyysluokka_nimi varchar(45) NOT NULL references kiireellisyysluokka(nimi) ON DELETE cascade,
	primary key (paivamaara, tunti)
);

CREATE TABLE tyovuorotunti
(
	aukiolotunti_paivamaara date,
	aukiolotunti_tunti time,
	tyontekija_id integer NOT NULL references tyontekija(id) ON DELETE cascade,
	primary key (aukiolotunti_paivamaara, aukiolotunti_tunti)
);

