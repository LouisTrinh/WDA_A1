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

    if (isset($_POST['submit'])) {
    
        if (isset($_POST['wine_name'])) {
            $wine_name = ($_POST['wine_name']);
        } else {
        	$wine_name = ""; 
        }
        
        
        if (isset($_POST['winery_id'])) {
            $winery_id = ($_POST['winery_id']);
        } else {
        	$winery_id = ""; 
        }
        	
        	
        if (isset($_POST['region_id'])) {
            $region_id = ($_POST['region_id']);
        } else {
        	$region_id = ""; 
        }
        
        
        if (isset($_POST['variety_id'])) {
            $variety_id = ($_POST['variety_id']);
        } else {
        	$variety_id = ""; 
        }
        
        
        if (isset($_POST['year1'])) {
            $year1 = ($_POST['year1']);
        } else {
        	$year1 = ""; 
        }
        
         if (isset($_POST['year2'])) {
            $year2 = ($_POST['year2']);
        } else {
        	$year2 = ""; 
        }
        
        if (isset($_POST['on_hand'])) {
            $on_hand = ($_POST['on_hand']);
        } else {
        	$on_hand = ""; 
        }
        
        
        if (isset($_POST['qty'])) {
            $qty = ($_POST['qty']);
        } else {
        	$qty = ""; 
        }
        
        
        if (isset($_POST['cost1'])) {
            $cost1 = ($_POST['cost1']);
        } else {
        	$cost1 = ""; 
        }
        
        if (isset($_POST['cost2'])) {
            $cost2 = ($_POST['cost2']);
        } else {
        	$cost2 = ""; 
        }
        if ($cost1 > $cost2){
        	echo " MinCost must be less than MaxCost";
        	exit;
        }        
        require_once('db_pdo.php');

	try {
  		$pdo = new PDO($dsn, DB_USER, DB_PW);
  		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  		
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
		if ($winery_id != ''){
			$having[]= 'winery.winery_name LIKE "%'.$winery_id.'%"';
		}
		if ($region_id != '' && $region_id != 1 ){
			$having[]= 'region.region_id = '.$region_id;
		}
		if ($variety_id != ''){
			$having[]= 'grape_varieties LIKE "%'.$variety_id.'%"';
		}
		if ($on_hand !=''){
			$having[] ='inventory.on_hand >= '.$on_hand;
		}
		if ($total_stocks_sold !=''){
			$having[] ='total_stocks_sold >= '.$total_stocks_sold;
		}
		if ($cost1 !='' && $cost2 ==''){
			$having[] ='inventory.cost >= '.$cost1;
		}
		elseif ($cost1 =='' && $cost2 !=''){
			$having[] ='inventory.cost <= '.$cost2;
		}
		elseif ($cost1 !='' && $cost2 !=''){
			$having[] ='inventory.cost BETWEEN '.$cost1.' AND '.$cost2;
		}
		
		$havingClause = '';
		if (count ($having) >0) {
			$havingClause = ' HAVING ' .implode(' AND ', $having);
		}
		$query = str_replace('__HAVING__', $havingClause, $query);
		
		$result = mysql_query($query, $dbconn);
		$wines = array();
		while ($row = mysql_fetch_assoc($result)) {
			$wines []= $row;
		}
		require_once 'MiniTemplator.class.php';
		$t = new MiniTemplator; 
		$t->readTemplateFromFile ("answer.html");	
		
		if (count ($wines) == 0){
			$t->addBlock('noresult');
		}
		else {
			foreach ($wines as $wine){
				$t->setVariable('wine_name', $wine['wine_name']);
				$t->setVariable('winery_name', $wine['winery_name']);
				$t->setVariable('region_name', $wine['region_name']);
				$t->setVariable('grape_varieties', $wine['grape_varieties']);
				$t->setVariable('year', $wine['year']);
				$t->setVariable('on_hand', $wine['on_hand']);
				$t->setVariable('total_stocks_sold', $wine['total_stocks_sold']);
				$t->setVariable('cost', $wine['cost']);
				$t->setVariable('sale_revenue', $wine['sale_revenue']);
				$t->addBlock('tr');
			} 
			$t->addBlock('table');
		}
		$t->generateOutput(); 
	} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}
} 
	else {
		header('Location: search.php');
		exit();
	}
	