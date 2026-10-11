<?php






function MobileRechargeUpdate($Q=null){
if($Q){
if(i['id']){
	$MobileRecharge=MobileRecharge($Q);
	
	 $SQL="UPDATE `Coinusers` SET `Wallet` =  `Wallet` - ".p2d($MobileRecharge['ccc'])." WHERE `Coinusers`.`ID` = '".$MobileRecharge['user']."'";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
 		
	if($results){
    $SQLL="UPDATE `Coinpods_mobile_recharge` SET `status` = '1' WHERE `Coinpods_mobile_recharge`.`name` = '".$Q."'";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQLL);	
		return $results;
	}
} 
}
}




function MobileRecharge($Q=null){
if($Q){
if(i['id']){
 		
    $SQL="SELECT * FROM `Coinpods_mobile_recharge` WHERE `name` = '".$Q."'";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}
	 
		return $plans[0];
} 
}
}



function MobileRechargeCreate($Q=null){

if(is_array($Q)){$Name=$Q['Name'];$Number=$Q['Number'];$Amount=$Q['Amount'];$State=$Q['State'];$Provider=$Q['Provider'];$CCC=$Q['CCC'];}
if(i['id']){
	if($Name and $Number and $Amount and $State and $Provider and $CCC){
		
    $SQL="INSERT INTO `Coinpods_mobile_recharge` (`id`, `name`, `created`, `modified`, `number`, `user`, `amount`, `provider`, `state`, `status`, `ccc`) VALUES (NULL, '".$Name."', '".GMT()."', '".GMT()."', '".$Number."', '".i['id']."', '".$Amount."', '".$Provider."', '".$State."', '0', '".$CCC."');";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
		return $results;
		
	}
}
 
}





?>