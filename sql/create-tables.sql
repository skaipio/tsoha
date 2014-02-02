CREATE TABLE personnelcategory
(
	id serial primary key,
	name varchar(45) UNIQUE NOT NULL
);
CREATE TABLE urgencycategory
(
	id serial primary key,
	name varchar(45) UNIQUE NOT NULL
);
CREATE TABLE minimumpersonnel
(
	id serial primary key,
	urgencycategory_id integer NOT NULL  references urgencycategory(id) ON DELETE cascade,
	personnelcategory_id integer NOT NULL  references personnelcategory(id) ON DELETE cascade,
	minimum integer NOT NULL
);
CREATE TABLE employee
(
	id serial primary key,
	password varchar(45) NOT NULL,
	email varchar(45) UNIQUE NOT NULL,
	admin boolean NOT NULL,
	firstname varchar(45) NOT NULL,
	lastname varchar(45) NOT NULL,
	socialsecuritynumber varchar(45) UNIQUE,
	address varchar(100) NOT NULL,
	phonenumber varchar(10) NOT NULL,
	personnelcategory_id integer NOT NULL references personnelcategory(id),
	maxhoursperday integer NOT NULL,
	maxhoursperweek integer NOT NULL
);

CREATE TABLE openhour
(
	id serial primary key,
	opendate date,
	hour time,
	urgencycategory_id integer NOT NULL references urgencycategory(id) ON DELETE cascade
);

CREATE TABLE workshifthour
(
	id serial primary key,
	openhour_id integer references openhour(id) ON DELETE cascade,
	employee_id integer references employee(id) ON DELETE cascade
);

