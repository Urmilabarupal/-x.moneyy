<?php



function Price_Branch($Q=null){
	$SQL=$ts=$t=$Currency=$results=null;
	$SQL = "SELECT `price_branch` FROM `Coinpods_currency` WHERE `CCC` = 'CCC'";
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$Currency=json_decode($ts[0]['price_branch'],true);
	if($Q){$Currency = $Currency[$Q];}
	return $Currency;
}


function Price_BranchUpdateData($Array=[]){
// ess function me agr ['1007'=>444.99999999999] krengy to ye only esi branch ka price update krke ek array me vo array return krega , otherwise ye old price_branch hee return kr dega  
		$Price_Branch = $FinalPrice_Branch = null;
		$FinalPrice_Branch = $Price_Branch = Price_Branch();
	
	if(is_array($Array) and !empty($Array)){
		$Branch = array_key_first($Array);
		$Price = $Array[$Branch];
		if(!empty($Branch) and !empty($Price)){
			$echo = 'Input Branch and Price Found.';
			if(is_array($Price_Branch) and !empty($Price_Branch)){
				$echo = 'Branch Data Found.';
				foreach($Price_Branch as $Key => $Value){
					if($Key==$Branch){
						$echo = 'Branch match Success , input branch |'.$Branch.'| and old branch |'.$Key.'| match success, input Price |'.$Price.'| old price |'.$Value;
						$FinalPrice_Branch[$Branch] = $Price;
					}
					else{
						$FinalPrice_Branch[$Key] = $Value;
						$echo = 'Branch match Faild , input branch |'.$Branch.'| and old branch |'.$Key.'| match success, input Price |'.$Price.'| old price |'.$Value;
					}
				}
			}
			else{$echo = 'Array Data is Required';}			
		}
		else{$echo = 'Array Data is Required';}
	}
	else{$echo = 'Array Data is Required';}
	return $FinalPrice_Branch;
}






function Branches($Q=null){
	$SQL=$ts=$t=$Currency=$results=null;
	$SQL = "SELECT `ID` , `branch`  FROM `Coinusers`  WHERE `branch` BETWEEN 1001 AND 9999 GROUP BY `branch` ORDER BY `ID` ASC ";
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){$Currency = $ts;}
	return $Currency;
}


################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################
################################################################################################################################################################

function PriceUpdate($Type=null,$Amount=null){
$Price=0;
if(i['id']){
	if($Type and $Amount){
		$Change=$Amount/100000;		
		if($Type=='Buy'){$Price=Price()+$Change;}
		elseif($Type=='Sell'){$Price=Price()-$Change;}	
		
			echo 'ABABAB'.$Type.$Price;

		if($Price){Pricer($Price);}		
	}
} 
}


function Pricer($Price=null){

if(i['id']){
	if($Price){
		
    $SQL = "UPDATE `".prefix."postmeta` SET `meta_value` = '".$Price."'  WHERE `Coinpostmeta`.`meta_id` = 111 OR `Coinpostmeta`.`meta_id` = 127;";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}
	 
		return $Price;
		
	}
}
 
}







function PriceINR(){

 

    $SQL = "SELECT * FROM `".prefix."postmeta` WHERE `post_id` = 918 AND `meta_key` LIKE '_price'";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}

 
if($plans){return $plans[0]['meta_value'];}
else{return false;}
}








function OpenPrice($Q=null){

	if(is_array($Q)){ $Year=$Q['Year']; $Month=$Q['Month']; $Date=$Q['Date']; $Hour=$Q['Hour']; $Minute=$Q['Minute']; $Second=$Q['Second']; $Branch=$Q['branch']; }

	if($Year){ $Year=" AND `year` = ".$Year; }
	if($Month){ $Month=" AND `month` = ".$Month; }
	if($Date){ $Date=" AND `date` = ".$Date; }
	if($Hour){ $Hour=" AND `hour` = ".$Hour; }
	if($Minute){ $Minute=" AND `minute` = ".$Minute; }
	if($Second){ $Second=" AND `second` = ".$Second; }

	$WHERE=$Year.$Month.$Date.$Hour.$Minute.$Second;


	//$SQL="SELECT `price` FROM `Coinpods_price` WHERE `price` > 0 ".$WHERE." ORDER BY `Coinpods_price`.`id` ASC LIMIT 1";
	$SQL = "SELECT CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) AS `price` FROM `Coinpods_price` WHERE CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) > 0 ".$WHERE." ORDER BY `id` ASC LIMIT 1;";
	//echo $SQL.'<br><br>';

	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}	 


	return number_format($plans[0]['price'],5);
}



function ClosePrice($Q=null){


	if(is_array($Q)){ $Year=$Q['Year']; $Month=$Q['Month']; $Date=$Q['Date']; $Hour=$Q['Hour']; $Minute=$Q['Minute']; $Second=$Q['Second']; $Branch=$Q['branch'];}

	if($Year){ $Year=" AND `year` = ".$Year; }
	if($Month){ $Month=" AND `month` = ".$Month; }
	if($Date){ $Date=" AND `date` = ".$Date; }
	if($Hour){ $Hour=" AND `hour` = ".$Hour; }
	if($Minute){ $Minute=" AND `minute` = ".$Minute; }
	if($Second){ $Second=" AND `second` = ".$Second; }

	$WHERE=$Year.$Month.$Date.$Hour.$Minute.$Second;



	//$SQL="SELECT `price` FROM `Coinpods_price` WHERE `price` > 0 ".$WHERE." ORDER BY `Coinpods_price`.`id` DESC LIMIT 1";
	$SQL = "SELECT CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) AS `price` FROM `Coinpods_price` WHERE CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) > 0 ".$WHERE." ORDER BY `id` DESC LIMIT 1;";
	//echo $SQL.'<br><br>';


	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}	
	return number_format($plans[0]['price'],5);
}


function HighestPriceForConvert($Q=null){	
	
if(is_array($Q)){ $Year=$Q['Year']; $Month=$Q['Month']; $Date=$Q['Date']; $Hour=$Q['Hour']; $Minute=$Q['Minute']; $Second=$Q['Second']; }
 
if($Year){ $Year=" AND `year` = ".$Year; }
if($Month){ $Month=" AND `month` = ".$Month; }
if($Date){ $Date=" AND `date` = ".$Date; }
if($Hour){ $Hour=" AND `hour` = ".$Hour; }
if($Minute){ $Minute=" AND `minute` = ".$Minute; }
if($Second){ $Second=" AND `second` = ".$Second; }
	
$WHERE=$Year.$Month.$Date.$Hour.$Minute.$Second;

 	

$SQL="SELECT `price` FROM `Coinpods_price` WHERE `price` > 0 ".$WHERE." ORDER BY `Coinpods_price`.`price` DESC LIMIT 1";
	$DBC = DBC('price'); $aa=0; $results = mysqli_query($DBC['c'], $SQL);
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;} 
	DBD($DBC); 
	
	if(i['branch']){$plans[0]['price'] = Price_Branch(i['branch']);}
	return number_format($plans[0]['price'],5); 
}




function HighestPrice($Q=null){	

	if(is_array($Q)){ $Year=$Q['Year']; $Month=$Q['Month']; $Date=$Q['Date']; $Hour=$Q['Hour']; $Minute=$Q['Minute']; $Second=$Q['Second'];$Branch=$Q['branch']; }

	if($Year){ $Year=" AND `year` = ".$Year; }
	if($Month){ $Month=" AND `month` = ".$Month; }
	if($Date){ $Date=" AND `date` = ".$Date; }
	if($Hour){ $Hour=" AND `hour` = ".$Hour; }
	if($Minute){ $Minute=" AND `minute` = ".$Minute; }
	if($Second){ $Second=" AND `second` = ".$Second; }

	$WHERE=$Year.$Month.$Date.$Hour.$Minute.$Second;



	//$SQL="SELECT `price` FROM `Coinpods_price` WHERE `price` > 0 ".$WHERE." ORDER BY `Coinpods_price`.`price` DESC LIMIT 1";
	$SQL = "SELECT CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) AS `price` FROM `Coinpods_price` WHERE CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) > 0 ".$WHERE." ORDER BY CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) DESC LIMIT 1;";
	//echo $SQL.'<br><br>';
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;} 

	return number_format($plans[0]['price'],5); 
}




function LowestPrice($Q=null){	



	if(is_array($Q)){ $Year=$Q['Year']; $Month=$Q['Month']; $Date=$Q['Date']; $Hour=$Q['Hour']; $Minute=$Q['Minute']; $Second=$Q['Second'];$Branch=$Q['branch']; }

	if($Year){ $Year=" AND `year` = ".$Year; }
	if($Month){ $Month=" AND `month` = ".$Month; }
	if($Date){ $Date=" AND `date` = ".$Date; }
	if($Hour){ $Hour=" AND `hour` = ".$Hour; }
	if($Minute){ $Minute=" AND `minute` = ".$Minute; }
	if($Second){ $Second=" AND `second` = ".$Second; }

	$WHERE=$Year.$Month.$Date.$Hour.$Minute.$Second;




	//$SQL="SELECT `price` FROM `Coinpods_price` WHERE `price` > 0 ".$WHERE." ORDER BY `Coinpods_price`.`price` ASC LIMIT 1";
	$SQL = "SELECT CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) AS `price` FROM `Coinpods_price` WHERE CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) > 0 ".$WHERE." ORDER BY CAST( JSON_UNQUOTE(JSON_EXTRACT(`price_branch`, '$.".$Branch."')) AS DECIMAL(20,8) ) ASC LIMIT 1;";
	//echo $SQL.'<br><br>';
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}	
	return number_format($plans[0]['price'],5);
}







function Prices($Q=null){
	
	$Time=clean(IST())-10000;

 
    $SQL = "SELECT `price` FROM `Coinpods_price` WHERE `time` >= ".$Time." AND `name` = 'CronJob' ORDER BY `id` DESC";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}
	
	return $plans;

 
}



 

function ChangePrice($Q=null){
$Amount=$Q; $Price=Price('CCC:BUSD');
	if($Amount and $Price){
		$Ratio = 0.0000000024; 
		
		$Change=$Ratio*$Amount;
		$Price=$Price+$Change;
		
		return $Price;	
	}	
}


function UpdatePrice($Q=null){
if(is_array($Q)){ $Name=$Q['Name']; $Price=$Q['Price']; $CCC=$Q['CCC']; $DDD=$Q['DDD']; $Price_Branch=$Q['price_branch']; }

	
$IST=explode(' ',IST()); $Date = $IST[0]; $Time = $IST[1];
$Date=explode('-',$Date); $Time=explode(':',$Time);

	
if($Name and $Price and $CCC and $DDD){	
	
$SQL="INSERT INTO `Coinpods_price` (`id`, `name`, `created`, `modified`, `price`,`price_branch`, `ccc`, `ddd`, `time`, `year`, `month`, `date`, `hour`, `minute`, `second`, `millisecond`, `user`) VALUES (NULL, '".$Name."', '".GMT()."', '".GMT()."', '".$Price."','".$Price_Branch."', '".$CCC."', '".$DDD."', '".clean(IST())."', '".$Date[0]."', '".$Date[1]."', '".$Date[2]."', '".$Time[0]."', '".$Time[1]."', '".$Time[2]."', '".$Time[3]."', '".i['id']."');";	
global $DB;$aa = 0;		
$results = mysqli_query($DB, $SQL);
	
	if($results){
		
		$SQL2="UPDATE `Coinpods_currency` SET `price` = '".$Price."', `price_branch` = '".$Price_Branch."'  WHERE `Coinpods_currency`.`ccc` = 'CCC';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL2);	
		return $results;
	}
	else{ return false; }
	
}
else{ return false; }
	
	
}




function Price($Q=null,$Array=[]){	


	$SQL = "SELECT * FROM `Coinpods_currency` WHERE `CCC` = 'CCC'";
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$Currency=$ts[0]; 



	$Price=$Currency['price'];
	$Branch = null; 
	if(isset($Array['branch'])){ $Branch=$Array['branch'];}
	elseif(i['branch']){ $Branch = i['branch'];}
	
	if($Branch){ $Price=Price_Branch($Branch);}

	if($Q){
		if($Q=='CCC:INR'){$Price=1;}
		elseif($Q=='CCC:BTC'){$Price=1;}	
		elseif($Q=='CCC:ETH'){$Price=1;}	
		elseif($Q=='CCC:TRX'){$Price=1;}	
		elseif($Q=='CCC:BNB'){$Price=1;}	
		elseif($Q=='CCC:USDT'){$Price=1;}	
		elseif($Q=='CCC:BUSD'){
			$Price=$Currency['price'];
			if($Branch){ $Price=Price_Branch($Branch);}
		}	

		elseif($Q=='INR:CCC'){$Price=1;}	
		else{$Price=1;}	
	}
	return $Price;	
}



?>