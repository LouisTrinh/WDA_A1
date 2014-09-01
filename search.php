<?php
require_once('db.php');
if(!$dbconn = mysql_connect(DB_HOST, DB_USER, DB_PW)) {
	echo 'Could not connect to mysql on ' . DB_HOST . '\n';
	exit; 
}

if(!mysql_select_db(DB_NAME, $dbconn)) {
	echo 'Could not user database ' . DB_NAME . '\n'; echo mysql_error() . '\n';
	exit;
}

$queryRegion = "SELECT * FROM region;";
$result = mysql_query($queryRegion, $dbconn);
$regions = array();
while ($row = mysql_fetch_assoc($result)) {
	$regions[$row['region_id']] = $row['region_name'];
	}
	
$queryVariety = "SELECT variety FROM grape_variety;";
$result1 = mysql_query($queryVariety, $dbconn);
$varieties = array();
while ($row = mysql_fetch_assoc($result1)) {
	$variety[$row['variety_id']] = $row['variety'];
	}
	
	
$queryYear = "SELECT * FROM wine GROUP BY year ORDER BY year DESC;";
$result = mysql_query($queryYear, $dbconn);
$years = array();
while ($row = mysql_fetch_assoc($result)) {
	$years[$row['wine_id']] = $row['year'];
	}
	
	
//var_dump($regions);
//var_dump($years);

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Winestore</title>
	<link rel="stylesheet" type="text/css" href="myCss.css"/>
</head>
<body>

				PRODUCT
			
				<form method="post" action="answer.php">
					Search by Wine Name 
					<input type="text"  value="" name="wine_name"/></br>
					
					Search by Winery Name
					<input type="text"  value="" name="winery_id"/></br>
					
					
					
					Choose the region
					<select name="region_id" >
					<?php
						foreach ($regions as $region_id => $region):
					?>
						<option value="<?php echo $region_id;?>"> <?php echo $region;?> </option>
					<?php
						endforeach;
					?>
					</select></br>
					
					
					
					Choose the grape variety
					<select name="variety_id" >
 					<?php
						foreach ($varieties as $variety_id => $grape_variety):
					?>
						<option value="<?php echo $variety_id;?>"> <?php echo $grape_variety;?> </option>
					<?php
						endforeach;
					?>
					</select></br>
					
					
						Choose the year
					<select name="year" >
					<?php
						foreach ($years as $wine_id => $wine):
					?>
						<option value="<?php echo $year;?>"> <?php echo $wine;?> </option>
					<?php
						endforeach;
					?>
					</select></br>
					
					
					
					Choose the number of wines in stock
					<input type="text"  value="" name="on_hand"/></br>
					
					Choose the number of ordered wines
					<input type="text"  value="" name="qty"/></br>
					
					<input type="submit" value="Submit" />
				</form>

	</body>
</html>