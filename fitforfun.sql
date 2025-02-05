create database fitforfun;

create table gebruiker (
    Kolomnaam       Datatype    Lengte  Nullable   Opmerking  
    id              int                   no        primary key
    voornaam        VARCHAR(50)   NOT NULL,
    tussenvoegsel   VARCHAR(10)   NULL,
    achternaam      VARCHAR(50)   NOT NULL,
    gebruikersnaam  VARCHAR(100)  NOT NULL UNIQUE,
    wachtwoord      VARCHAR(255)  NOT NULL,
    is_ingelogd     BIT           NOT NULL DEFAULT 0,
    ingelogd        DATETIME      NULL,
    uitgelogd       DATETIME      NULL,
    is_actief       BIT           NOT NULL DEFAULT 1,
    opmerking       VARCHAR(250)  NULL,
    datum_aangemaakt DATETIME(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    datum_gewijzigd DATETIME(6)   NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

CREATE TABLE rol (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id    INT NOT NULL,
    naam            ENUM('Lid', 'Medewerker', 'Administrator', 'Gastgebruiker') NOT NULL,
    is_actief       BIT NOT NULL DEFAULT 1,
    opmerking       VARCHAR(250) NULL,
    datum_aangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    datum_gewijzigd DATETIME(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (gebruiker_id) REFERENCES gebruiker(id) ON DELETE CASCADE
);

CREATE TABLE medewerker (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    voornaam        VARCHAR(50) NOT NULL,
    tussenvoegsel   VARCHAR(10) NULL,
    achternaam      VARCHAR(50) NOT NULL,
    nummer          MEDIUMINT NOT NULL UNIQUE,
    medewerkersoort ENUM('Manager', 'Beheerder', 'Diskmedewerker') NOT NULL,
    is_actief       BIT NOT NULL DEFAULT 1,
    opmerking       VARCHAR(250) NULL,
    datum_aangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    datum_gewijzigd DATETIME(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

CREATE TABLE lid (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    voornaam        VARCHAR(50) NOT NULL,
    tussenvoegsel   VARCHAR(10) NULL,
    achternaam      VARCHAR(50) NOT NULL,
    relatienummer   MEDIUMINT NOT NULL UNIQUE,
    mobiel         VARCHAR(20) NOT NULL,
    email          VARCHAR(100) NOT NULL UNIQUE,
    is_actief       BIT NOT NULL DEFAULT 1,
    opmerking       VARCHAR(250) NULL,
    datum_aangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    datum_gewijzigd DATETIME(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

CREATE TABLE les (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    naam            VARCHAR(50) NOT NULL,
    datum          DATE NOT NULL,
    tijd           TIME NOT NULL,
    min_aantal_personen TINYINT NOT NULL DEFAULT 3,
    max_aantal_personen TINYINT NOT NULL DEFAULT 9,
    beschikbaarheid ENUM('Ingepland', 'Niet gestart', 'Gestart', 'Geannuleerd') NOT NULL,
    is_actief       BIT NOT NULL DEFAULT 1,
    opmerking       VARCHAR(250) NULL,
    datum_aangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    datum_gewijzigd DATETIME(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

CREATE TABLE reservering (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    voornaam        VARCHAR(50) NOT NULL,
    tussenvoegsel   VARCHAR(10) NULL,
    achternaam      VARCHAR(50) NOT NULL,
    nummer          MEDIUMINT NOT NULL,
    datum          DATE NOT NULL,
    tijd           TIME NOT NULL,
    reserveringstatus ENUM('Vrij', 'Bezet', 'Gereserveerd', 'Geannuleerd') NOT NULL,
    is_actief       BIT NOT NULL DEFAULT 1,
    opmerking       VARCHAR(250) NULL,
    datum_aangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    datum_gewijzigd DATETIME(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)

