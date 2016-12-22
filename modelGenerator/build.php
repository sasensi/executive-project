<?php
/**
 * Created by PhpStorm.
 * User: SASENSI
 * Date: 30/06/2016
 * Time: 11:07
 */

require 'ModelBuilderConfig.php';
require 'Modelbuilder.php';

$config             = new ModelBuilderConfig();
$config->renderDir  = '../module/Application/src/Model/';
$config->dbName     = 'crowdfunding';
$config->dbUser     = 'root';
$config->dbPassword = '';

$builder = new Modelbuilder($config);
$builder->build();