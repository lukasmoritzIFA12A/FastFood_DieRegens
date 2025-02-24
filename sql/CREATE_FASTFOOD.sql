DROP DATABASE IF EXISTS fastfood;
CREATE DATABASE fastfood;
USE fastfood;
CREATE TABLE admin (Login_id INT NOT NULL, PRIMARY KEY(Login_id));
CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, Strassenname VARCHAR(255) NOT NULL, Hausnummer VARCHAR(10) NOT NULL, Zusatz VARCHAR(255) DEFAULT NULL, PLZ VARCHAR(10) NOT NULL, Stadt VARCHAR(255) NOT NULL, Bundesland VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE bestellstatus (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE bestellung (id INT AUTO_INCREMENT NOT NULL, BestellungDatum DATETIME NOT NULL, Kunde_id INT DEFAULT NULL, Zahlungsart_id INT DEFAULT NULL, Bestellstatus_id INT DEFAULT NULL, INDEX IDX_150D4EEC64315AEA (Kunde_id), INDEX IDX_150D4EEC3DFA4654 (Zahlungsart_id), INDEX IDX_150D4EEC74850C22 (Bestellstatus_id), PRIMARY KEY(id));
CREATE TABLE bestellung_menue (bestellung_id INT NOT NULL, menue_id INT NOT NULL, INDEX IDX_625BD595D6F2F2D7 (bestellung_id), INDEX IDX_625BD595617613C7 (menue_id), PRIMARY KEY(bestellung_id, menue_id));
CREATE TABLE bestellung_produkt (bestellung_id INT NOT NULL, produkt_id INT NOT NULL, INDEX IDX_BB0E5AFED6F2F2D7 (bestellung_id), INDEX IDX_BB0E5AFE75F42D9B (produkt_id), PRIMARY KEY(bestellung_id, produkt_id));
CREATE TABLE contest (id INT AUTO_INCREMENT NOT NULL, bild LONGBLOB NOT NULL, freigeschalten TINYINT(1) NOT NULL, Bestellung_id INT DEFAULT NULL, INDEX IDX_1A95CB5658CB922 (Bestellung_id), PRIMARY KEY(id));
CREATE TABLE energiewert (id INT AUTO_INCREMENT NOT NULL, PortionSize VARCHAR(255) DEFAULT NULL, Kalorien NUMERIC(10, 2) DEFAULT NULL, Fett NUMERIC(10, 2) DEFAULT NULL, Kohlenhydrate NUMERIC(10, 2) DEFAULT NULL, Zucker NUMERIC(10, 2) DEFAULT NULL, Eiweiss NUMERIC(10, 2) DEFAULT NULL, Produkt_id INT DEFAULT NULL, INDEX IDX_BF0606283AA92E4B (Produkt_id), PRIMARY KEY(id));
CREATE TABLE icon (id INT AUTO_INCREMENT NOT NULL, BildPfad VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE kunde (id INT AUTO_INCREMENT NOT NULL, Vorname VARCHAR(255) NOT NULL, Nachname VARCHAR(255) NOT NULL, Telefonnummer VARCHAR(255) DEFAULT NULL, Registrierungsdatum DATETIME NOT NULL, Adresse_id INT DEFAULT NULL, Login_id INT DEFAULT NULL, INDEX IDX_A213CB12BADF8C (Adresse_id), INDEX IDX_A213CB1A5C4820B (Login_id), PRIMARY KEY(id));
CREATE TABLE ladesprueche (id INT AUTO_INCREMENT NOT NULL, spruch VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE login (id INT AUTO_INCREMENT NOT NULL, Nutzername VARCHAR(255) NOT NULL, Passwort VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AA08CB101D8345AC (Nutzername), PRIMARY KEY(id));
CREATE TABLE menue (id INT AUTO_INCREMENT NOT NULL, Titel VARCHAR(255) NOT NULL, Beschreibung VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id));
CREATE TABLE menue_produkt (menue_id INT NOT NULL, produkt_id INT NOT NULL, INDEX IDX_F8956002617613C7 (menue_id), INDEX IDX_F895600275F42D9B (produkt_id), PRIMARY KEY(menue_id, produkt_id));
CREATE TABLE produkt (id INT AUTO_INCREMENT NOT NULL, Titel VARCHAR(255) NOT NULL, Beschreibung VARCHAR(255) DEFAULT NULL, Preis NUMERIC(10, 2) NOT NULL, Lagerbestand INT NOT NULL, Rabatt NUMERIC(10, 2) DEFAULT NULL, Icon_id INT DEFAULT NULL, INDEX IDX_1B938EA59B04EEAE (Icon_id), PRIMARY KEY(id));
CREATE TABLE produkt_zutat (produkt_id INT NOT NULL, zutat_id INT NOT NULL, INDEX IDX_236E107B75F42D9B (produkt_id), INDEX IDX_236E107BAF5E977E (zutat_id), PRIMARY KEY(produkt_id, zutat_id));
CREATE TABLE rabatt (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, minderung NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id));
CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, Rating INT NOT NULL, Kunde_id INT DEFAULT NULL, Contest_id INT DEFAULT NULL, INDEX IDX_D889262264315AEA (Kunde_id), INDEX IDX_D8892622538DF30E (Contest_id), PRIMARY KEY(id));
CREATE TABLE rechnung (id INT AUTO_INCREMENT NOT NULL, ZahlungsDatum DATETIME NOT NULL, Bestellung_id INT DEFAULT NULL, Rabatt_id INT DEFAULT NULL, INDEX IDX_D490F3E7658CB922 (Bestellung_id), INDEX IDX_D490F3E786231AE (Rabatt_id), PRIMARY KEY(id));
CREATE TABLE zahlungsart (id INT AUTO_INCREMENT NOT NULL, Art VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE zutat (id INT AUTO_INCREMENT NOT NULL, ZutatName VARCHAR(255) NOT NULL, PRIMARY KEY(id));
ALTER TABLE admin ADD CONSTRAINT FK_880E0D76A5C4820B FOREIGN KEY (Login_id) REFERENCES login (id);
ALTER TABLE bestellung ADD CONSTRAINT FK_150D4EEC64315AEA FOREIGN KEY (Kunde_id) REFERENCES kunde (id);
ALTER TABLE bestellung ADD CONSTRAINT FK_150D4EEC3DFA4654 FOREIGN KEY (Zahlungsart_id) REFERENCES zahlungsart (id);
ALTER TABLE bestellung ADD CONSTRAINT FK_150D4EEC74850C22 FOREIGN KEY (Bestellstatus_id) REFERENCES bestellstatus (id);
ALTER TABLE bestellung_menue ADD CONSTRAINT FK_625BD595D6F2F2D7 FOREIGN KEY (bestellung_id) REFERENCES bestellung (id) ON DELETE CASCADE;
ALTER TABLE bestellung_menue ADD CONSTRAINT FK_625BD595617613C7 FOREIGN KEY (menue_id) REFERENCES menue (id) ON DELETE CASCADE;
ALTER TABLE bestellung_produkt ADD CONSTRAINT FK_BB0E5AFED6F2F2D7 FOREIGN KEY (bestellung_id) REFERENCES bestellung (id) ON DELETE CASCADE;
ALTER TABLE bestellung_produkt ADD CONSTRAINT FK_BB0E5AFE75F42D9B FOREIGN KEY (produkt_id) REFERENCES produkt (id) ON DELETE CASCADE;
ALTER TABLE contest ADD CONSTRAINT FK_1A95CB5658CB922 FOREIGN KEY (Bestellung_id) REFERENCES bestellung (id);
ALTER TABLE energiewert ADD CONSTRAINT FK_BF0606283AA92E4B FOREIGN KEY (Produkt_id) REFERENCES produkt (id);
ALTER TABLE kunde ADD CONSTRAINT FK_A213CB12BADF8C FOREIGN KEY (Adresse_id) REFERENCES adresse (id);
ALTER TABLE kunde ADD CONSTRAINT FK_A213CB1A5C4820B FOREIGN KEY (Login_id) REFERENCES login (id);
ALTER TABLE menue_produkt ADD CONSTRAINT FK_F8956002617613C7 FOREIGN KEY (menue_id) REFERENCES menue (id) ON DELETE CASCADE;
ALTER TABLE menue_produkt ADD CONSTRAINT FK_F895600275F42D9B FOREIGN KEY (produkt_id) REFERENCES produkt (id) ON DELETE CASCADE;
ALTER TABLE produkt ADD CONSTRAINT FK_1B938EA59B04EEAE FOREIGN KEY (Icon_id) REFERENCES icon (id);
ALTER TABLE produkt_zutat ADD CONSTRAINT FK_236E107B75F42D9B FOREIGN KEY (produkt_id) REFERENCES produkt (id) ON DELETE CASCADE;
ALTER TABLE produkt_zutat ADD CONSTRAINT FK_236E107BAF5E977E FOREIGN KEY (zutat_id) REFERENCES zutat (id) ON DELETE CASCADE;
ALTER TABLE rating ADD CONSTRAINT FK_D889262264315AEA FOREIGN KEY (Kunde_id) REFERENCES kunde (id);
ALTER TABLE rating ADD CONSTRAINT FK_D8892622538DF30E FOREIGN KEY (Contest_id) REFERENCES contest (id);
ALTER TABLE rechnung ADD CONSTRAINT FK_D490F3E7658CB922 FOREIGN KEY (Bestellung_id) REFERENCES bestellung (id);
ALTER TABLE rechnung ADD CONSTRAINT FK_D490F3E786231AE FOREIGN KEY (Rabatt_id) REFERENCES rabatt (id);
