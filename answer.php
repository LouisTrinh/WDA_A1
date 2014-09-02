<?php
    if (isset($_POST['submit'])) {
    
        if (isset($_POST['wine_name'])) {
            $wine_name = mysql_real_escape_string($_POST['wine_name']);
        } else {
        	$wine_name = ""; 
        }
        
        
        if (isset($_POST['winery_id'])) {
            $winery_id = mysql_real_escape_string($_POST['winery_id']);
        } else {
        	$winery_id = ""; 
        }
        	
        	
        if (isset($_POST['region_id'])) {
            $region_id = mysql_real_escape_string($_POST['region_id']);
        } else {
        	$region_id = ""; 
        }
        
        
        if (isset($_POST['variety_id'])) {
            $variety_id = mysql_real_escape_string($_POST['variety_id']);
        } else {
        	$variety_id = ""; 
        }
        
        
        if (isset($_POST['year'])) {
            $year = mysql_real_escape_string($_POST['year']);
        } else {
        	$year = ""; 
        }
        
        
        if (isset($_POST['on_hand'])) {
            $on_hand = mysql_real_escape_string($_POST['on_hand']);
        } else {
        	$on_hand = ""; 
        }
        
        
        if (isset($_POST['qty'])) {
            $qty = mysql_real_escape_string($_POST['qty']);
        } else {
        	$qty = ""; 
        }
}
	else {
		echo "Couldn't Find Any Wine";
	}
?>
