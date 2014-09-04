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



$queryRegion = "SELECT * FROM region;";
$result = mysql_query($queryRegion, $dbconn);
$regions = array();
while ($row = mysql_fetch_assoc($result)) {
	$regions[$row['region_id']] = $row['region_name'];
	}
	
$queryVariety = "SELECT * FROM grape_variety;";
$result = mysql_query($queryVariety, $dbconn);
$varieties = array();
while ($row = mysql_fetch_assoc($result)) {
	$varieties[$row['variety']] = $row['variety'];
	}
	
	
$queryYear = "SELECT DISTINCT * FROM wine GROUP BY year ORDER BY year DESC;";
$result = mysql_query($queryYear, $dbconn);
$years = array();
while ($row = mysql_fetch_assoc($result)) {
	$years[$row['year']] = $row['year'];
	}


	
//var_dump($regions);
//var_dump($varieties);

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Winestore</title>
	<link rel="stylesheet" type="text/css" href="myCss.css"/>
</head>
<body>

				PRODUCT
<table border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#D0D0D0">Search by Wine Name </td>
    <td bgcolor="#D0D0D0">Search by Winery Name</td>
    <td bgcolor="#D0D0D0">Choose the region</td>
    <td bgcolor="#D0D0D0">Choose the grape variety</td>
    <td bgcolor="#D0D0D0">Choose the year range</td>
    <td bgcolor="#D0D0D0">Choose the number of wines in stock</td>
    <td bgcolor="#D0D0D0">Choose the number of ordered wines</td>
    <td bgcolor="#D0D0D0">Choose the cost range </td>
    
    <td bgcolor="#D0D0D0">Submit</td>
  </tr>
  
<form method="post" action="answer.php">
 <tr>
    <td align="center" bgcolor="#F0F0F0"><input type="text"  value="" name="wine_name"/></td>
    <td align="right"><input type="text"  value="" name="winery_id"/></br></td>
    <td align="right"><select name="region_id" >
					<?php
						foreach ($regions as $region_id => $region):
					?>
						<option value="<?php echo $region_id;?>"> <?php echo $region;?> </option>
					<?php
						endforeach;
					?>
					</select>
					</td>
    <td align="right"><select name="variety_id" >
 					<?php
						foreach ($varieties as $variety_id => $grape_variety):
					?>
						<option value="<?php echo $variety_id;?>"> <?php echo $grape_variety;?> </option>
					<?php
						endforeach;
					?>
					</select>
					</td>
    <td align="right"><select name="year1" >
					<?php
						foreach ($years as $year):
					?>
						<option value="<?php echo $year;?>"> <?php echo $year;?> </option>
					<?php
						endforeach;
					?>
					</select>
					
					<select name="year2" >
					<?php
						foreach ($years as $year):
					?>
						<option value="<?php echo $year;?>"> <?php echo $year;?> </option>
					<?php
						endforeach;
					?>
					</select>
					</td>
    <td align="right"><input type="text"  value="" name="on_hand"/></td>
    <td align="right"><input type="text"  value="" name="qty"/></br></td>
    <td align="right"><input type="text"  value="" name="cost1"/><input type="text"  value="" name="cost2"/></td>
  
    
    <td align="right"><input type="submit" value="Submit" name="submit" /></td>
   
  </tr>				
</form>

	</body>
</html>