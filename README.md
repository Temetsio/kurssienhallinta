# KURSSIENHALLINTAJÄRJESTELMÄ

Oppilaitoksen kurssienhallintajärjestelmä, jossa voidaan hallinnoida oppilaita, opettajia, kursseja ja kurssi-ilmoittautumisia.

---

## TIIMI

- Jenni: Tietokantasuunnittelu ja -toteutus , readme.md 
- Vesku: Backend-arkkitehtuuri ja tietokantayhteys, Lomakkeet ja CRUD-toiminnot  
- Meleqe: UI/UX suunnittelu  
- Teemu: Näkymät

---

## TIETOKANTARAKENNE

### TAULUT

#### oppilaat
- `oppilas_id` (PK, INT, AUTO_INCREMENT)  
- `etunimi` (VARCHAR 50)  
- `sukunimi` (VARCHAR 50)  
- `syntymaaika` (DATE)  
- `vuosikurssi` (INT, 1-3)  

#### opettajat
- `opettaja_id` (PK, INT, AUTO_INCREMENT)  
- `etunimi` (VARCHAR 50)  
- `sukunimi` (VARCHAR 50)  
- `aine` (VARCHAR 100)  

#### tilat
- `tila_id` (PK, INT, AUTO_INCREMENT)  
- `tila_nimi` (VARCHAR 50, UNIQUE)  
- `paikkoja` (INT)  

#### kurssit
- `kurssi_id` (PK, INT, AUTO_INCREMENT)  
- `kurssin_tunnus` (VARCHAR 20, UNIQUE)  
- `kurssi_nimi` (VARCHAR 100)  
- `kurssikuvaus` (TEXT)  
- `aloituspaiva` (DATE)  
- `lopetuspaiva` (DATE)  
- `opettaja_id` (FK viittaa `opettajat`)  
- `tila_id` (FK viittaa `tilat`)  

#### ilmoittautuminen
- `ilmoittautuminen_id` (PK, INT, AUTO_INCREMENT)  
- `opiskelija_id` (FK viittaa `oppilaat`)  
- `kurssi_id` (FK viittaa `kurssit`)  
- `ilmoittautumispaiva` (DATETIME)  
- UNIQUE constraint: (`opiskelija_id`, `kurssi_id`)

#### kurssisessiot 
- `sessio_id` (PK, INT, AUTO_INCREMENT)
- `kurssi_id` (FK viittaa `kurssit`)
- `viikonpaiva` (ENUM)
- `alkuaika` (TIME)
- `loppuaika` (TIME)
- `created_at` (TIMESTAMP)
- `tila_id` (FK viittaa `tilat`)

---

### RELAATIOT

- `opettajat` (1) → (n) `kurssit`  
- `tilat` (1) → (n) `kurssit`  
- `oppilaat` (n) ↔ (n) `kurssit` (`ilmoittautuminen`-välitaulu)
- `kurssit` (1) → (n) `kurssisessiot`

---

## NÄKYMÄT (VIEWS)

- `nakyma_kaynnissa_olevat_kurssit` – Käynnissä olevat kurssit ja ilmoittautuneet
- `nakyma_kurssin_aikataulu` - Kurssien aikataulut
- `nakyma_opettajan_aikataulu` - Opettajien aikataulut
- `nakyma_tulevat_kurssit` – Tulevat kurssit ja vapaat paikat
- `nakyma_opiskelijan_aikataulu` - Opiskelijoiden aikataulut
- `nakyma_tilan_aikataulu` - Tilojen aikataulut
- `nakyma_ylibuukatut_kurssit` – Kurssit, joissa ilmoittautuneita enemmän kuin kapasiteetti  
- `nakyma_kurssit_taydellinen` – Kurssien tiedot, opettaja, tila, ilmoittautuneet ja vapaita paikkoja  
- `nakyma_opettajat_kurssit` – Opettajien tiedot ja heidän kurssinsa  
- `nakyma_opiskelijat_kurssit` – Opiskelijan kurssit ja opettajat  
- `nakyma_opiskelijat_aktiivisuus` – Opiskelijan aktiivisuuskurssimäärien perusteella  
- `nakyma_tilat_kaytto` – Tilojen käyttöaste ja status  

---


## ASENNUS

### TIETOKANNAN TUONTI (XAMPP)
1. Käynnistä XAMPP (Apache + MySQL)  
2. Avaa phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)  
3. Luo uusi tietokanta: `kurssienhallinta`  
4. Valitse tietokanta  
5. Klikkaa **Import**  
6. Valitse tiedosto: `kurssienhallinta.sql`  
7. Klikkaa **Go**  

---

### TIETOKANTAYHTEYDEN KONFIGUROINTI

Luo tiedosto `config/db_connect.php`:

```php
<?php
$host = 'localhost';
$db   = 'kurssienhallinta';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Tietokantayhteys epäonnistui: " . $e->getMessage());
}
?>
```


### TOIMINNALLISUUDET

### KÄYTTÄJÄN NÄKYMÄT

```
Kurssinäkymä: Näyttää kurssin tiedot, opettajan, tilan ja ilmoittautuneet opiskelijat
Opiskelijanäkymä: Näyttää opiskelijan tiedot ja kurssit joille hän on ilmoittautunut
Opettajanäkymä: Näyttää opettajan tiedot ja kurssit joita hän opettaa
Tilanäkymä: Näyttää tilan tiedot ja kurssit jotka pidetään tilassa (+ kapasiteettivaroitus)
```


### CRUD-TOIMINNOT

```
Lisää/muokkaa/poista opettajia
Lisää/muokkaa/poista oppilaita
Lisää/muokkaa/poista kursseja
Lisää/muokkaa/poista tiloja
Lisää/poista kurssi-ilmoittautumisia
```

### TESTIDATA

```
Tietokannassa on valmiina:
- 20 opettajaa
- 15 tilaa (kapasiteetit: 20-50 oppilasta)
- 33 kurssia (eri aineita)
- 58 oppilasta (vuosikurssit 1-3)
- 108 kurssi-ilmoittautumista
```


### TEKNOLOGIAT

```
Tietokanta: MySQL / MariaDB
Backend: PHP 8.x
Frontend: HTML5, CSS3, JavaScript
Palvelin: Apache (XAMPP)
```

PROJEKTIRAKENNE
`````
kurssienhallinta/
├── screenshots/
│   ├── 1_taulut.png
│   ├── 2_er_diagram.png
│   └── 3_testidata.png
├──kurssienhallinta
│   ├── add_edit_kurssi.php/
│   ├── add_edit_opettaja.php/
│   ├── add_edit_oppilas.php/
│   ├── add_edit_sessio.php/
│   ├── add_edit_tila.php/
│   ├── admin.php/
│   ├── config.php/
│   ├── db.php/
│   ├── delete_kurssi.php/
│   ├── delete_opettaja.php/
│   ├── delete_oppilas.php/
│   ├── delete_sessio.php/
│   ├── delete_tila.php/
│   ├── ilmoittaudu.php/
│   ├── index.php/
│   ├── kurssi.php/
│   ├── opettaja.php/
│   ├── opettajat.php/
│   ├── opiskelijat.php/
│   ├── oppilaat.php/
│   ├── poista_ilmo.php/
│   ├── styles.css/
│   ├── tila.php/
│   ├── tilat.php/
├── er-kaavio
├── README.md
├── kurssienhallinta.sql
`````


### KÄYNNISTYS
```
1. Kopioi projektikansio: C:\xampp\htdocs\kurssienhallinta\
2. Tuo tietokanta (ks. Asennus)
3. Avaa selaimessa: http://localhost/kurssienhallinta/
```

### KEHITYSIDEOITA

```
Käyttäjien kirjautuminen (admin/opiskelija)

Arvosanojen hallinta

Läsnäolojen seuranta

Kurssien hakutoiminto

Ilmoittautumisen vahvistusviestit

Raporttien vienti PDF:ksi

```

### YHTEYSTIEDOT

Projekti tehty osana Juhannuskukkulan tietokantakurssia.

Tiimi: Meleqe, Teemu, Vesku ja Jenni

Päivämäärä: Lokakuu 2025


LISENSSI

Tämä projekti on tehty opetuskäyttöön.
