<?php
require_once('../db.php');
if(!$dbconn = mysql_connect(DB_HOST, DB_USER, DB_PW)) {
	echo 'Could not connect to mysql on ' . DB_HOST . '\n';
	exit; 
}

if(!mysql_select_db(DB_NAME, $dbconn)) {
	echo 'Could not user database ' . DB_NAME . '\n'; echo mysql_error() . '\n';
	exit;
}

require_once 'MiniTemplator.class.php';
$t = new MiniTemplator; 
$t->readTemplateFromFile ("searchC.html"); 

$t->setVariable('input_name', 'wine_name');
$t->addBlock('input');
$t->addBlock('td');

$t->setVariable('input_name', 'winery_id');
$t->addBlock('input');
$t->addBlock('td');

$queryRegion = "SELECT * FROM region;";
$result = mysql_query($queryRegion, $dbconn);
//$regions = array();
while ($row = mysql_fetch_assoc($result)) {
	//$regions[$row['region_id']] = $row['region_name'];
	$t->setVariable('option_value', $row['region_id']);
	$t->setVariable('option_text', $row['region_name']);
	$t->addBlock('option');
}
$t->setVariable('select_name', 'region_id');
$t->addBlock('select');
$t->addBlock('td');


	
$queryVariety = "SELECT * FROM grape_variety;";
$result = mysql_query($queryVariety, $dbconn);
$varieties = array();
while ($row = mysql_fetch_assoc($result)) {
	//$varieties[$row['variety']] = $row['variety'];
	$t->setVariable('option_value', $row['variety']);
	$t->setVariable('option_text', $row['variety']);
	$t->addBlock ('option');
}
$t->setVariable('select_name','variety_id');
$t->addBlock('select');
$t->addBlock('td');	
	
$queryYear = "SELECT DISTINCT * FROM wine GROUP BY year ORDER BY year DESC;";
$result = mysql_query($queryYear, $dbconn);
$years = array();
while ($row = mysql_fetch_assoc($result)) {
	$years[$row['year']] = $row['year'];
	$t->setVariable('option_value', $row['year']);
	$t->setVariable('option_text', $row['year']);
	$t->addBlock('option');
}
$t->setVariable('select_name','year1');
$t->addBlock('select');

foreach($years as $year){
	$row['year'] = row['year'];
	$t->setVariable('option_value', $row['year']);
	$t->setVariable('option_text', $row['year']);
	$t->addBlock('option');
}
$t->setVariable('select_name','year2');
$t->addBlock('select');

$t->addBlock('td');	


$queryCost = "SELECT DISTINCT * FROM inventory GROUP BY cost ORDER BY cost DESC;";
$result = mysql_query($queryCost, $dbconn);
$costs = array();
while ($row = mysql_fetch_assoc($result)) {
	$costs[$row['inventory_id']] = $row['cost'];
	}
	
$queryStock = "SELECT * FROM items GROUP BY wine_id ;";
$result = mysql_query($queryStock, $dbconn);

	
//var_dump($regions);
//var_dump($varieties);
$t->generateOutput(); 
