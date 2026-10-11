<?php
 
function CreateRewardsssss($Q=null){
	$SQL1='';$results='';

if(is_array($Q)){ $Amount=$Q['amount']; $StakeID=$Q['stake']; $User=$Q['user'];  }

	
if($Amount and $User and $StakeID){
$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`) VALUES (NULL, 'Reward:".$StakeID."', current_timestamp(), current_timestamp(), 'Reward:".$StakeID."', '".$User."', '', '', '0', 'Reward', '".$Amount."', 'CCC', '1', '', '');";	
	
	
//global $DB; $results = mysqli_query($DB, $SQL1);
}
	
	
}







function OneReward(){
if(i['id']==1){
	
	
$SQL="SELECT * FROM `Coinpods_stake` WHERE `ist` BETWEEN '2023/01/01 00:00:01' AND '2023/01/03 23:59:59'  AND `amount`> 1700000000000;";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}
	
	//return $plans;
	
	
	
	
}
}








//$OneReward = OneReward();

if($OneReward){
	
foreach($OneReward as $OR){
	
	$amount=0;
	$amount=$OR['amount']*10/100;
	
//CreateRewardsssss(array( 'user'=>$OR['user'], 'stake'=>$OR['id'], 'amount'=>$amount ));	
 	
	
	
}	
}


?>