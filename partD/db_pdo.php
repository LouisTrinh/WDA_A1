<?php
/**
 * MySQL connection check
 *
 */

define('DB_NAME',   'winestore');
define('DB_USER',   'webadmin');
define('DB_PW',     'webadmin');
$databaseName=DB_NAME;
$hostName='localhost';
$dsn = "mysql:dbname=$databaseName;host=$hostName;port=52247";
?>
