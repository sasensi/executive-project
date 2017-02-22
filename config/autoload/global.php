<?php

return [
	'db' => [
		'driver'         => 'Pdo',
		'dsn'            => 'mysql:dbname=crowdfunding;host=localhost',
		'username'       => 'crowdfunding',
		'password'       => 'password',
		'driver_options' => [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		],
	],

	'service_manager' => [
		'factories' => [
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
		],
	],
];
