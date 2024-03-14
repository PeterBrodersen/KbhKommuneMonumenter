# Berigelse af GeoJSON-fil for monumenter i Københavns Kommune

## Formål
PHP-scriptet beriger GeoJSON-filen med monumenter fra Københavns Kommune med oplysninger om:
* beskrivelse
* kunstner
* datering
* placering
* mål
* typer (kategori af monument)
* materialer
* ejer
* giver
* litteratur
* link til værket

Ovennævnte data stammer fra de individuelle monumenters undersider.

Ikke alle monumenter fra Københavns Kommune er med i GeoJSON-filen i første omgang. I skrivende stund (marts 2024) har bl.a. værket [Zygote](https://kk.sites.itera.dk/apps/kk_monuments/index.php?id=543) (2023) ingen koordinater og er dermed ikke inkluderet i filen.

## Statisk kopi
Hent GeoJSON-filen [københavn_monumenter_beriget.geojson](københavn_monumenter_beriget.geojson) og indlæs den i dit favorit-GIS-program.

Filen bliver ikke opdateret regelmæssigt.

## Dan dit eget datasæt
Du kan lave et opdateret datasæt med beriget indhold. Det kræver en række trin og en PHP-fortolker:

1. Hent GeoJSON
2. Hent alle undersider
3. Afvikl kode

### Hent GeoJSON
Hent [GeoJSON-fil for monumenter](https://kk.sites.itera.dk/apps/kk_monuments/data_monuments_datakk_geojson.php) fra Københavns Kommune.

Bemærk, at GeoJSON-filen er indkapslet i et array med [ ]-tegn. Fjern første og sidste tegn i filen for at danne en gyldig GeoJSON-fil.

Gem filen som `københavn_monumenter.geojson`.

### Hent alle undersider
Dan en liste over samtlige unikke web_id i properties.

Hent og gem samtlige monument-websites fra Københavns Kommune med id fra ovenstående liste i følgende URL-format:

`https://kk.sites.itera.dk/apps/kk_monuments/data_monuments_get_detail.php?id=$WEBID`

Gem siderne med navnet `$webid.html` - fx 511.html - i mappen `kk_monuments/`.

### Afvikl kode
Kør PHP-scriptet [monument_berigelse.php](monument_berigelse.php) og send outputtet til en relevant fil, fx:

`php monument_berigelse.php > københavn_monumenter_beriget.geojson`

# TODO
Automatisér hentning og justering af GeoJSON-fil samt alle undersider med cookie-håndtering.

# Links
Københavns Kommune:
* [Monumenter i København](https://kk.sites.itera.dk/apps/kk_monuments/)
* [Monumenter i København, liste](https://kk.sites.itera.dk/apps/kk_monuments/index_liste.php)
* [GeoJSON-fil for monumenter](https://kk.sites.itera.dk/apps/kk_monuments/data_monuments_datakk_geojson.php)
Bemærk, at GeoJSON-filen er indkapslet i et array med [ ]-tegn. Fjern første og sidste tegn i filen for at danne en gyldig GeoJSON-fil
