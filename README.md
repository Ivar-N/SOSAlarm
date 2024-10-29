```markdown
# SOS Alarm Data Integration

Dit project biedt een oplossing om gegevens van SOS-alarmapparaten te ontvangen en op te slaan in een MySQL-database via een PHP-server. De configuratie van het apparaat kan worden beheerd via de bijgevoegde configuratie-app.

## Inhoudsopgave
- [Overzicht](#overzicht)
- [Installatie](#installatie)
- [Vereisten](#vereisten)
- [Configuratie](#configuratie)
- [Gebruik](#gebruik)
- [Structuur van Berichten](#structuur-van-berichten)
- [Database Schema](#database-schema)
- [Opmerkingen](#opmerkingen)

---

## Overzicht
Dit project implementeert een TCP-server in PHP om gegevens van het SOS-alarmapparaat te ontvangen. Gegevens worden ontvangen in hexadecimale berichten, geparsed volgens een specifiek protocol en opgeslagen in een MySQL-database. Voor de configuratie van het SOS-alarmapparaat is een mobiele app beschikbaar.

## Installatie

### 1. Clone het project
Clone deze repository naar je lokale machine:

git clone https://github.com/jouw-gebruikersnaam/sos-alarm-project.git
cd sos-alarm-project


### 2. Database Configuratie
Maak een nieuwe MySQL-database en tabel:

CREATE DATABASE sos_database;

USE sos_database;

CREATE TABLE sos_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    header VARCHAR(10),
    properties VARCHAR(10),
    length INT,
    sequence_id INT,
    message_body TEXT
);


### 3. PHP Server Configuratie
Pas de database-instellingen aan in het PHP-script:
- Open `server.php` in de root directory.
- Stel je MySQL-gebruikersnaam en wachtwoord in in de `storeInDatabase` functie.

### 4. Start de PHP Server
Start de server op de gewenste poort:

php server.php


## Vereisten
- PHP 7.x of hoger
- MySQL-server
- SOS-alarmapparaat dat TCP-berichten verstuurt
- Configuratie-app (meegeleverd in de repository)

## Configuratie
De SOS-apparaatconfiguratie kan worden beheerd met behulp van de meegeleverde app. Hiermee kun je instellingen configureren, zoals het IP-adres en de poort voor de PHP-server.

**Stappen:**
1. Open de configuratie-app.
2. Stel de IP-adres- en poortwaarden in voor het apparaat.
3. Configureer andere parameters zoals nodig.

## Gebruik
1. Start de PHP-server met `php server.php`.
2. Zorg ervoor dat het SOS-apparaat is geconfigureerd met het IP-adres en de poort van je PHP-server.
3. Zodra het apparaat gegevens verzendt, worden de berichten automatisch opgeslagen in de MySQL-database.

## Structuur van Berichten
De SOS-alarmberichten hebben de volgende structuur:
- **Header**: 1 byte (0xAB)
- **Properties**: 1 byte (bevat encryptie en ACK-flags)
- **Length**: 2 bytes (totale lengte van de boodschap)
- **Checksum**: 2 bytes (CRC16-checksum van de boodschap)
- **Sequence ID**: 2 bytes (uniek ID voor berichtvolgorde)
- **Message Body**: bevat de eigenlijke gegevens van het apparaat

Meer details over de structuur zijn te vinden in de documentatie.

## Database Schema
De data van het SOS-alarm wordt opgeslagen in de `sos_data` tabel met de volgende structuur:

| Kolom         | Type         | Beschrijving                       |
|---------------|--------------|------------------------------------|
| id            | INT          | Unieke ID van het bericht         |
| header        | VARCHAR(10)  | Header van het bericht            |
| properties    | VARCHAR(10)  | Eigenschappen van het bericht     |
| length        | INT          | Lengte van de boodschap           |
| sequence_id   | INT          | Unieke volgorde ID                |
| message_body  | TEXT         | De eigenlijke berichtinhoud       |

## Opmerkingen
- **Firewall**: Zorg ervoor dat de serverpoort is beveiligd en alleen toegankelijk is voor vertrouwde apparaten.
- **Checksum**: Het PHP-script controleert de integriteit van elk bericht met een checksum.
- **Logging**: Voor productie-implementaties wordt aanbevolen om foutlogboeken en back-ups in te stellen.

## Licentie
Dit project is gelicentieerd onder de MIT-licentie. Zie het [LICENSE-bestand](LICENSE) voor details.


### Belangrijk:
Zorg ervoor dat het projectbestand en de configuratie-instructies overeenkomen met jouw specifieke setup.
```