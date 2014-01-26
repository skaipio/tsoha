INSERT INTO henkilostoluokka (nimi) VALUES ('Lääkäri');
INSERT INTO henkilostoluokka (nimi) VALUES ('Sairaanhoitaja');
INSERT INTO henkilostoluokka (nimi) VALUES ('Perushoitaja');

INSERT INTO kiireellisyysluokka (nimi) VALUES ('L3');
INSERT INTO kiireellisyysluokka (nimi) VALUES ('L2');

INSERT INTO minimivahvuus (kiireellisyysluokka_nimi, henkilostoluokka_nimi, minimi)
	VALUES ('L2', 'Lääkäri', 1);
INSERT INTO minimivahvuus (kiireellisyysluokka_nimi, henkilostoluokka_nimi, minimi)
	VALUES ('L2', 'Sairaanhoitaja', 1);
INSERT INTO minimivahvuus (kiireellisyysluokka_nimi, henkilostoluokka_nimi, minimi)
	VALUES ('L2', 'Perushoitaja', 1);

INSERT INTO aukiolotunti (paivamaara, tunti, kiireellisyysluokka_nimi)
	VALUES ('2014-03-01', '08:00', 'L2');
INSERT INTO aukiolotunti (paivamaara, tunti, kiireellisyysluokka_nimi)
	VALUES ('2014-03-01', '09:00', 'L2');	
INSERT INTO aukiolotunti (paivamaara, tunti, kiireellisyysluokka_nimi)
	VALUES ('2014-03-01', '10:00', 'L2');	

INSERT INTO tyontekija (kayttajanimi, salasana, sahkoposti,
	yllapitaja, etunimi, sukunimi, hetu, osoite, gsmnumero,
	henkilostoluokka_nimi, maxtunnitpaivassa, maxtunnitviikossa)
	VALUES ('vvemmel', 'whatsupdoc','vemmels@lasema.fi', true,
		'Väiski', 'Vemmelsääri', '111111-1234', 'Acmekatu 2, Jollywood',
		'1234567890','Lääkäri', 12, 38);

INSERT INTO tyontekija (kayttajanimi, salasana, sahkoposti,
	yllapitaja, etunimi, sukunimi, hetu, osoite, gsmnumero,
	henkilostoluokka_nimi, maxtunnitpaivassa, maxtunnitviikossa)
	VALUES ('mpiggy', 'somethingcatchy','mpiggy@lasema.fi', false,
		'Miss', 'Piggy', '111111-1235', 'Muppetstreet 4, Muppet Town',
		'1234567890','Sairaanhoitaja', 10, 38);

INSERT INTO tyontekija (kayttajanimi, salasana, sahkoposti,
	yllapitaja, etunimi, sukunimi, hetu, osoite, gsmnumero,
	henkilostoluokka_nimi, maxtunnitpaivassa, maxtunnitviikossa)
	VALUES ('pepe', 'penelope','pepe@lasema.fi', false,
		'Pepe', 'Le Pew', '111111-1236', 'Near the Eiffel Tower, Paris',
		'1234567890','Perushoitaja', 10, 38);

INSERT INTO tyovuorotunti (aukiolotunti_paivamaara, aukiolotunti_tunti, tyontekija_id)
	VALUES ('2014-03-01', '08:00', 1);
INSERT INTO tyovuorotunti (aukiolotunti_paivamaara, aukiolotunti_tunti, tyontekija_id)
	VALUES ('2014-03-01', '08:00', 2);
INSERT INTO tyovuorotunti (aukiolotunti_paivamaara, aukiolotunti_tunti, tyontekija_id)
	VALUES ('2014-03-01', '08:00', 3);
INSERT INTO tyovuorotunti (aukiolotunti_paivamaara, aukiolotunti_tunti, tyontekija_id)
	VALUES ('2014-03-01', '09:00', 1);
INSERT INTO tyovuorotunti (aukiolotunti_paivamaara, aukiolotunti_tunti, tyontekija_id)
	VALUES ('2014-03-01', '09:00', 2);
INSERT INTO tyovuorotunti (aukiolotunti_paivamaara, aukiolotunti_tunti, tyontekija_id)
	VALUES ('2014-03-01', '09:00', 3);