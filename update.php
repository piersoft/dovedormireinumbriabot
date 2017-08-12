<?php

// Use a PSR-4 autoloader for the `proj4php` root namespace.
include("db/proj4php/vendor/autoload.php");

use proj4php\Proj4php;
use proj4php\Proj;
use proj4php\Point;

// Initialise Proj4
$proj4 = new Proj4php();

$proj4->addDef("EPSG:3004",'+proj=tmerc +lat_0=0 +lon_0=15 +k=0.9996 +x_0=2520000 +y_0=0 +ellps=intl +units=m +no_defs');

// Create two different projections.
$projL93    = new Proj('EPSG:3004', $proj4);
$projWGS84  = new Proj('EPSG:4326', $proj4);

// uso GDRIVE per deterimare dal portale CKAN Regionale l'ultimo CSV aggiornato e lo salvo in locale sul server ogni mezzanotte
$indirizzo ="https://docs.google.com/spreadsheets/d/1dLuMMNzRun92AlpXl0mHAGLyBYTi3yG3jsKC3gtXYP0/pub?gid=7603821&single=true&output=csv";
$homepage2 = file_get_contents($indirizzo);

$inizio=1;
$homepage ="";
//  echo $url;
//$csv1 = array_map('str_getcsv', file($indirizzo));
//	$url =$csv1[0][0];

  $homepage1 = file_get_contents($homepage2);
  $csv1 = array_map('str_getcsv', file($homepage2));
  //$csv1 = array_map('str_getcsv', file('http://dati.umbria.it/datastore/dump/062d7bd6-f9c6-424e-9003-0b7cb3744cab'));

  $count=0;
  foreach($csv1 as $csv11=>$data1){
    $count1 = $count1+1;


    if ($count1 >1){
      // Create a point.
  $pointSrc = new Point((float)$data1[17],(float)$data1[18], $projL93);
//  echo "Source: " . $pointSrc->toShortString() . " in L93 <br>";
//var_dump($pointSrc);
  // Transform the point between datums.
  $pointDest = $proj4->transform($projWGS84, $pointSrc);
  $pieces = explode(" ", $pointDest->toShortString());

//  echo "Conversion: " . $pointDest->toShortString() . " in WGS84<br><br>";
    $features[] = array(
            'type' => 'Feature',
            'geometry' => array('type' => 'Point', 'coordinates' => array((float)$pieces[0],(float)$pieces[1])),
            'properties' => array('nome_comune' => $data1[4],'denominazione_struttura' => $data1[5], 'indirizzo' => $data1[8],'prov' => $data1[11],'classificazione' => $data1[7],'categoria' => $data1[6],'camere' => $data1[19],'web' => $data1[15],'tel' => $data1[12],'email' => $data1[16])
            );
  }
}
  $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
  $geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);

//	$homepage1=str_replace(",",".",$homepage1); //le lat e lon hanno la , e quindi metto il .
//  $homepage1=str_replace(";",",",$homepage1); // converto il CSV da separatore ; a ,

  echo $geostring;
  $file = '/usr/www/piersoft/dovedormireinumbriabot/db/ricettive.json';

// scrivo il contenuto sul file locale.
  file_put_contents($file, $geostring);
//echo "finito";
?>
