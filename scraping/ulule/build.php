<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

require_once __DIR__.'/vendor/autoload.php';

$iterations = 10;

echo '<pre>';

$ulule = new \Ulule\Ulule($iterations);
$ulule->build();

echo '</pre>';

echo 'SUCCESS';