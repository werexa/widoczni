CREATE TABLE IF NOT EXISTS clients(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT not null,
lastname TEXT not null, 
email TEXT not null,
phone NUMERIC
);

CREATE TABLE IF NOT EXISTS package(
id INTEGER  PRIMARY KEY AUTOINCREMENT not null,
name TEXT, --nazwa pakietu
description TEXT, --opis pakietu
packagetime TEXT --czas trwania pakietu
);

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

CREATE TABLE IF NOT EXISTS contacts(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT not null,
lastname TEXT not null, 
email TEXT not null,
phone NUMERIC,
NIP NUMERIC not null
);

CREATE TABLE IF NOT EXISTS contactsteam(
id INTEGER  not null,
id_contact not null,
FOREIGN KEY (id_contact) REFERENCES contacts(id)
);

CREATE TABLE IF NOT EXISTS employees(
id INTEGER PRIMARY KEY AUTOINCREMENT not null,
name TEXT not null,
lastname TEXT not null, 
job TEXT NOT NULL, -- stanowisko pracy
section TEXT not null, 
email TEXT not null,
phone NUMERIC
);



