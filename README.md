# Executive Project

> Crowdfunding site for a student project

## Getting Started
After cloning this repository, open a command promt in root directory and execute the following commands.

### Server dependencies
require composer
```bash
composer install
```

### Client dependencies
require bower
```bash
bower install
```

### Local server
set a virtual host pointing to `public` directory


### Database
require mysql
```bash
mysql -u root
mysql> CREATE USER 'crowdfunding'@'localhost' IDENTIFIED BY 'password';
mysql> CREATE DATABASE IF NOT EXISTS crowdfunding;
mysql> USE crowdfunding;
mysql> SOURCE tools/dbDump/dump.sql;
mysql> exit;
```

## Contributing

### Dev dependencies
```bash
npm install
grunt build
```
don't close prompt so file watcher can live update production files