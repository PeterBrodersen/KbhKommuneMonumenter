<?php
// Forberedelse:
//
// GeoJSON:
// https://kk.sites.itera.dk/apps/kk_monuments/data_monuments_datakk_geojson.php
// fjern slut- og start-brackets: [ ]
// Gem som 'københavn_monumenter.geojson'
//
// Dan liste over samtlige unikke web_id i properties
//
// Hent og gemt samtlige monument-websites fra Københavns Kommune med id fra ovenstående liste, fx:
// https://kk.sites.itera.dk/apps/kk_monuments/data_monuments_get_detail.php?id=511
// Gem siderne som $id.html - fx 511.html - i mappen "kk_monuments".
// Siderne *SKAL* hentes med cookies. Brug evt. curl-kommando kopieret fra browser.

function getLine($html, $key)
{
    $regex = '_<b>' . preg_quote($key) . '</b>(.*?)</p>_s';
    if (!preg_match($regex, $html, $match)) {
        return '';
    }
    return trim($match[1]);
}

function getLineH2($html, $key)
{
    $regex = '_<h2>' . preg_quote($key) . '</h2>\s*<p>(.*?)</p>_s';
    if (!preg_match($regex, $html, $match)) {
        return '';
    }
    return trim($match[1]);
}

function getDescription($html)
{
    $regex = '_</h1>.*?<p>(.*?)</p>_s';
    if (!preg_match($regex, $html, $match)) {
        return '';
    }
    return trim(strip_tags($match[1]));
}

function parseHTML($html)
{
    $data = [
        'beskrivelse' => getDescription($html),
        'kunstner' => getLineH2($html, 'Kunstner(e)'),
        'datering' => getLineH2($html, 'Datering'),
        'placering' => getLineH2($html, 'Placering'),
        'mål' => getLine($html, 'Mål:'),
        'typer' => getLine($html, 'Typer:'),
        'materialer' => getLine($html, 'Materialer:'),
        'ejer' => getLine($html, 'Ejer:'),
        'giver' => getLine($html, 'Giver:'),
        'litteratur' => getLine($html, 'Litteratur:'),
    ];
    return $data;
}

$file = 'københavn_monumenter.geojson';
$data = json_decode(file_get_contents($file));
foreach ($data->features as $feature) {
    $web_id = $feature->properties->web_id;
    if (!$web_id) {
        continue;
    }
    $filename = 'kk_monuments/' . $web_id . '.html';
    if (!file_exists($filename)) {
        continue;
    }
    $parsed = parseHTML(file_get_contents($filename));
    foreach ($parsed as $key => $value) {
        $feature->properties->$key = $value;
    }
    $feature->properties->web = 'https://kk.sites.itera.dk/apps/kk_monuments/index.php?id=' . $web_id;
}
$json = json_encode($data);
print $json;
