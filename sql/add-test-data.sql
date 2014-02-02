INSERT INTO personnelcategory (name) VALUES ('Lääkäri');
INSERT INTO personnelcategory (name) VALUES ('Sairaanhoitaja');
INSERT INTO personnelcategory (name) VALUES ('Perushoitaja');

INSERT INTO urgencycategory (name) VALUES ('L3');
INSERT INTO urgencycategory (name) VALUES ('L2');

INSERT INTO minimumpersonnel (urgencycategory_id, personnelcategory_id, minimum)
	VALUES (2, 1, 1);
INSERT INTO minimumpersonnel (urgencycategory_id, personnelcategory_id, minimum)
	VALUES (2, 2, 1);
INSERT INTO minimumpersonnel (urgencycategory_id, personnelcategory_id, minimum)
	VALUES (2, 3, 1);

INSERT INTO openhour (opendate, hour, urgencycategory_id)
	VALUES ('2014-03-01', '08:00', 2);
INSERT INTO openhour (opendate, hour, urgencycategory_id)
	VALUES ('2014-03-01', '09:00', 2);	
INSERT INTO openhour (opendate, hour, urgencycategory_id)
	VALUES ('2014-03-01', '10:00', 2);	

INSERT INTO employee (password, email, admin, firstname, lastname, socialsecuritynumber,
	address, phonenumber, personnelcategory_id, maxhoursperday, maxhoursperweek)
	VALUES ('whatsupdoc','vemmels@lasema.fi', true,
		'Väiski', 'Vemmelsääri', '111111-1234', 'Acmekatu 2, Jollywood',
		'1234567890',1, 12, 38);

INSERT INTO employee (password, email, admin, firstname, lastname, socialsecuritynumber,
	address, phonenumber, personnelcategory_id, maxhoursperday, maxhoursperweek)
	VALUES ('somethingcatchy','mpiggy@lasema.fi', false,
		'Miss', 'Piggy', '111111-1235', 'Muppetstreet 4, Muppet Town',
		'1234567890',2, 10, 38);

INSERT INTO employee (password, email, admin, firstname, lastname, socialsecuritynumber,
	address, phonenumber, personnelcategory_id, maxhoursperday, maxhoursperweek)
	VALUES ('penelope','pepe@lasema.fi', false,
		'Pepe', 'Le Pew', '111111-1236', 'Near the Eiffel Tower, Paris',
		'1234567890',3, 10, 38);

INSERT INTO workshifthour (openhour_id, employee_id)
	VALUES (1, 1);
INSERT INTO workshifthour (openhour_id, employee_id)
	VALUES (1, 2);
INSERT INTO workshifthour (openhour_id, employee_id)
	VALUES (1, 3);
INSERT INTO workshifthour (openhour_id, employee_id)
	VALUES (2, 1);
INSERT INTO workshifthour (openhour_id, employee_id)
	VALUES (2, 2);
INSERT INTO workshifthour (openhour_id, employee_id)
	VALUES (2, 3);