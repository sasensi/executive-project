<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 22/02/2017
 * Time: 08:37
 */

$db = new PDO('mysql:dbname=crowdfunding;host=127.0.0.1', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('
			SET NAMES utf8;
			SET CHARACTER SET utf8;
		');

$string = "\xC3 tous";

$string = utf8_encode($string);

$statement = $db->prepare('INSERT INTO test (name) VALUES (?)');
$statement->execute([$string]);