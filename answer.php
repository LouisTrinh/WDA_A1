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
        
        
        if (isset($_POST['year1'])) {
            $year1 = mysql_real_escape_string($_POST['year1']);
        } else {
        	$year1 = ""; 
        }
        
         if (isset($_POST['year2'])) {
            $year2 = mysql_real_escape_string($_POST['year2']);
        } else {
        	$year2 = ""; 
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
        
        
        if (isset($_POST['cost1'])) {
            $cost1 = mysql_real_escape_string($_POST['cost1']);
        } else {
        	$cost1 = ""; 
        }
        
        if (isset($_POST['cost2'])) {
            $cost2 = mysql_real_escape_string($_POST['cost2']);
        } else {
        	$cost2 = ""; 
        }
        
        
        $query= 'SELECT 
	wine.wine_name,
	GROUP_CONCAT(DISTINCT grape_variety.variety) "grape_varieties",
	wine.year,
	winery.winery_name,
	region.region_name,
	inventory.cost,
	inventory.on_hand,
	SUM(items.qty) "total_stocks_sold",
	SUM(items.qty * items.price) "sale_revenue",
	region.region_id
	
FROM `wine`  
Join winery on winery.winery_id = wine.winery_id
Join region on region.region_id = winery.region_id
Join wine_variety on wine_variety.wine_id = wine.wine_id
Join grape_variety on grape_variety.variety_id= wine_variety.variety_id
Join inventory on inventory.wine_id = wine.wine_id
Join items on items.wine_id = wine.wine_id

__WHERE__

	
GROUP BY 
	wine.wine_name,
	wine.year 
	
__HAVING__
';
		$where = array();
		if ($wine_name != '') {
			$where[] = 'wine.wine_name LIKE "%'.$wine_name.'%"';
		}
		if ($year1 != '' && $year2 != '') {
			$where[] = 'wine.year BETWEEN '.$year1.' and '.$year2;
		}
	
		$whereClause = '';
		if (count($where) > 0) {
			$whereClause = ' WHERE ' . implode(' AND ', $where);
		}
		$query = str_replace('__WHERE__', $whereClause, $query);
	

		$having = array();
		if ($winery_name != ''){
			$having[]= 'winery.winery_name LIKE "%'.$winery_name.'%"';
			}
		if ($region_id != ''){
			$having[]= 'region.region_id = '.$region_id;
		}
		if ($on_hand !=''){
			$having[] ='inventory.on_hand >= '.$on_hand;
		}
		if ($total_stocks_sold !=''){
			$having[] ='total_stocks_sold >= '.$total_stocks_sold;
		}
		if ($cost1 !='' && $cost2 ==''){
			$having[] ='total_stocks_sold >= '.$cost1;
		}
		elseif ($cost1 =='' && $cost2 !=''){
			$having[] ='total_stocks_sold <= '.$cost2;
		}
		else{
			$having[] ='total_stocks_sold BETWEEN '.$cost1.' AND '.$cost2;
		}
		
		$havingClause = '';
		if (count ($having) >0) {
			$havingClause = ' HAVING ' .implode(' AND ', $having);
		}
		$query = str_replace('__HAVING__', $havingClause, $query);
		
		echo $query;
	}
	
	else {
		echo "Couldn't Find Any Wine";
	}
	
?>
