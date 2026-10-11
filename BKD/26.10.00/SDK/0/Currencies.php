<?php

 
 

function Currency($Q=null){
	// OUTPUT : Currency
 	$Branch = $Currency = null; $SingleUser = SingleUser($_SESSION['LoginToken']['id']);
	if($Q){
		$SQL = "SELECT * FROM `Coinpods_currency` WHERE `CCC` = '".$Q."'";
		global $DB;$aa = 0;
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){
			while($t = mysqli_fetch_assoc($results)){

				if($SingleUser['branch'] and strtolower($Q) == 'ccc'){
					$Price_Branch=null;$Branch = $SingleUser['branch']; 
					$Currency=json_decode($t['price_branch'],true);
					if($Branch){$Price_Branch = $Currency[$Branch];}
					$t['price'] = $Price_Branch; 
				}
				$ts[$aa] = $t; $aa++;
			}
		} 
		else{$ts = null;}	
		return $ts[0]; 
	}
}

$CCC=Currency('CCC');
define('CCC',$CCC);
 
function Currencies($Q=null){
// OUTPUT : Currencies
 
	$SQL = "SELECT * FROM `Coinpods_currency` WHERE `enable` = 1";
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts; 

}



function CurrencyPriceUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-19
// Input : CCC, Price
// Output : Price Update
	
	if(is_array($Q)){ $CCC = strtoupper($Q['ccc']); $Price = $Q['price']; }
	if($CCC and $Price){
		
		$SQL="UPDATE `Coinpods_currency` SET `price`='".$Price."' WHERE `ccc` = '".$CCC."'";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
		return $results;
	
	}
}





?>