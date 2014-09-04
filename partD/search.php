<?php
require_once('../db.php');
try {
$dsn = DB_ENGINE .':host='. DB_HOST .';dbname='. DB_NAME; $db = new PDO($dsn, DB_USER, DB_PW);

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
$result = $pdo->query($queryRegion);
//$regions = array();
while ($row = $result->fetch(PDO::FETCH_OBJ)) {
	//$regions[$row['region_id']] = $row['region_name'];
	$t->setVariable('option_value', $row['region_id']);
	$t->setVariable('option_text', $row['region_name']);
	$t->addBlock('option');
}
$t->setVariable('select_name', 'region_id');
$t->addBlock('select');
$t->addBlock('td');


	
$queryVariety = "SELECT * FROM grape_variety;";
$result = $pdo->query($queryVariety);
$varieties = array();
while ($row = $result->fetch(PDO::FETCH_OBJ)) {
	//$varieties[$row['variety']] = $row['variety'];
	$t->setVariable('option_value', $row['variety']);
	$t->setVariable('option_text', $row['variety']);
	$t->addBlock ('option');
}
$t->setVariable('select_name','variety_id');
$t->addBlock('select');
$t->addBlock('td');	
	
$queryYear = "SELECT DISTINCT * FROM wine GROUP BY year ORDER BY year DESC;";
$result = $pdo->query($queryYear);
$years = array();
while ($result->fetch(PDO::FETCH_OBJ)) {
	$years[$row['year']] = $row['year'];
	$t->setVariable('option_value', $row['year']);
	$t->setVariable('option_text', $row['year']);
	$t->addBlock('option');
}
$t->setVariable('select_name','year1');
$t->addBlock('select');

foreach($years as $year){
	$t->setVariable('option_value', $year);
	$t->setVariable('option_text', $year);
	$t->addBlock('option');
}
$t->setVariable('select_name','year2');
$t->addBlock('select');

$t->addBlock('td');	

$t->setVariable('input_name', 'on_hand');
$t->addBlock('input');
$t->addBlock('td');

$t->setVariable('input_name', 'qty');
$t->addBlock('input');
$t->addBlock('td');

$t->setVariable('input_name', 'cost1');
$t->addBlock('input');
$t->setVariable('input_name', 'cost2');
$t->addBlock('input');
$t->addBlock('td');
	
//var_dump($regions);
//var_dump($varieties);
$t->generateOutput(); 

$db = null; // close the database connection } catch(PDOException $e) {
echo $e­>getMessage(); }
