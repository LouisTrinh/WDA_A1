<?php
/**
 * MySQL connection check
 *
 */

define('DB_NAME',   'winestore');
define('DB_USER',   'winestore');
define('DB_PW',     'secret');
$databaseName=DB_NAME;
$hostName='goanna.cs.rmit.edu.au';
$dsn = "mysql:dbname=$databaseName;host=$hostName;port=52247";
?>
