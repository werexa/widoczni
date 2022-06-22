CREATE TABLE IF NOT EXISTS clients(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT not null,
lastname TEXT not null, 
email TEXT not null, --uninqw
phone NUMERIC
);

INSERT INTO clients(name,lastname,email)
values 
('Ame', 'Smith','AmeSmith@gmail.com'),
('Tom', 'Smith','TomSmith@gmail.com'), 
('Emma', 'Smith','EmmaSmith@gmail.com'), 
('Peter', 'Smith','PeterSmith@gmail.com'), 
('Kate', 'Smith','KateSmith@gmail.com'), 
('MEM', 'Smith','MEMSmith@gmail.com'), 
('Alex', 'Smith','AlexSmith@gmail.com') 



CREATE TABLE IF NOT EXISTS package(
id INTEGER  PRIMARY KEY AUTOINCREMENT not null,
name TEXT, --nazwa pakietu
description TEXT, --opis pakietu
packagetime TEXT --czas trwania pakietu
);

INSERT INTO package(name,description,packagetime)
values 
('50+', 'descriptiondescriptiondescriptiondescription','5 month'),
('50+', 'descriptiondescriptiondescriptiondescription','70 month'),
('9s0+', 'descriptiondescriptiondescriptiondescription','8 week'),
('80dd+', 'descriptiondescriptiondescriptiondescription','10 month'),
('70xx+', 'descriptiondescriptiondescriptiondescription','7 day'),




CREATE TABLE IF NOT EXISTS contacts(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT not null,
lastname TEXT not null, 
email TEXT not null,
phone NUMERIC,
NIP NUMERIC not null
);

INSERT INTO contacts(name,lastname,email, phone, NIP)
values 
('contacts1', 'Smith','contacts1@gmail.com',159159159,99999999999),
('contacts2', 'Smith','contacts2@gmail.com',159159159,99999999999),
('contacts3', 'Smith','contacts3@gmail.com',159159159,99999999999),
('contacts4', 'Smith','contacts4@gmail.com',159159159,99999999999),
('contacts5', 'Smith','contacts5@gmail.com',159159159,99999999999),
('contacts6', 'Smith','contacts6@gmail.com',159159159,99999999999),
('contacts7', 'Smith','contacts7@gmail.com',159159159,99999999999),



CREATE TABLE IF NOT EXISTS team(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT,
);

CREATE TABLE IF NOT EXISTS contactsteam(
id_team integer not null,
id_contact INTEGER not null,
FOREIGN KEY (id_contact) REFERENCES contacts(id),
FOREIGN KEY (id_team) REFERENCES team(id),
);

INSERT INTO contactsteam(id_team,id_contact)
values 
(1,1),(1,2),(1,3)

CREATE TABLE IF NOT EXISTS employees(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT not null,
lastname TEXT not null, 
job TEXT NOT NULL, -- stanowisko pracy
section TEXT not null, 
email TEXT not null,
phone NUMERIC
);



INSERT INTO employees(name,lastname,job, section, email)
values 
('employe1', 'Smith','webdeveloper','poznanXXX','employe1@gmail.com',159159159),
('employe2', 'Smith','webdeveloper','poznanXXX','employ2@gmail.com',159159159),
('employe3', 'Smith','webdeveloper','poznanXXX','employe3@gmail.com',159159159),
('employe4', 'Smith','webdeveloper','poznanXXX', 'employe4@gmail.com',159159159),
('employe5', 'Smith','webdeveloper','poznanXXX','employe5@gmail.com',159159159),
('employe6', 'Smith','webdeveloper','poznanXXX','employe6@gmail.com',159159159),

DROP TABLE IF EXISTS transactions;
CREATE TABLE IF NOT EXISTS transactions(
id INTEGER PRIMARY KEY,
id_client INTEGER not null,
id_package INTEGER NOT NULL,
id_contactsteam INTEGER not null,
id_employee INTEGER not null,
date_paid TEXT NOT NULL, --DATA zakupienia pakietu
date_start TEXT not null, -- data rozpoczęcia pakietu
date_end TEXT not null, --data zakończenia pakietu
FOREIGN KEY (id_client) REFERENCES clients(id),
FOREIGN KEY (id_employee) REFERENCES employees(id),
FOREIGN KEY (id_package) REFERENCES package(id)
);

INSERT INTO transactions(id_client,id_package,id_contactsteam,id_employee,date_paid,date_start,date_end)
values 
(1,1,1,1,'2022-06-22', '2022-06-22', '2022-11-22'),
(2,1,1,1,'2022-06-22', '2022-06-22', '2022-11-22'),
(3,1,1,1,'2022-06-22', '2022-06-22', '2022-11-22'),
(4,1,1,1,'2022-06-22', '2022-06-22', '2022-11-22'),

