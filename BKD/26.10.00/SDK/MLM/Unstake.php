<?php



function UnstakingToWallet($Q=null){
// Developer : Pawan kumar
// Date : 2024/03/10
// Input :
// Output : Unstaking ki transaction ko wallet meleke jata hai.

//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingUnstakingTransactions($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToUnstakeWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
		$Output++;
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}



function PendingUnstakingTransactions($Q=null){
//Developer : Pawan kumar
//Date : 2024/03/10
//Input : 
//Output : Pending Transaction [ balance = 0, ttype = Unstaking ]
	
if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Unstaking'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Unstaking' LIMIT 11"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}










function UnstakeIncome($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : UserID
//Output : Jo user aata hai uss user ki unstake me staked amount ko sum krta hai.
	
$Q=i['id'];
// OUTPUT :  
if($Q){	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_unstake` WHERE `user` = '".$Q."';"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
}
}








function UnstakingToTransaction($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : Array
//Output : Jo data array me aata uss data ki transaction create kr dega.
	
	if($Q){
		
//if(AddToWallet(array( 'user'=>$Q['user'], 'ccc'=>strtolower($Q['ccc']), 'amount'=>$Q['amount'] )));
		
if($Q['staking']){	
		 
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`) VALUES (NULL, 'Unstaking : ".$Q['id']." : ".GMT()."', current_timestamp(), current_timestamp(), 'Unstaking".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '', '', '0', 'Unstaking', '".$Q['staking']."', '".strtolower($Q['ccc'])."', '1');";
		
global $DB;	$Output = mysqli_query($DB, $SQL);	
	
	if($Output){ 
		$SQL2="UPDATE `Coinpods_unstake` SET `staked` = `staked` + `staking`, `staking` = 0 WHERE `Coinpods_unstake`.`id` = '".$Q['id']."';";	
		global $DB;	$Output = mysqli_query($DB, $SQL2);	
		return $Output;
	}
	}		
} 	
}



function UnstakingToTransactions(){
//Developer : Pawan Kumar
//Date : 2024/03/10
//input : 
//Output : Unstaking ko transaction me leke jata hai jo new generate hoti hai. daily

	$SQL="SELECT * FROM `Coinpods_unstake` WHERE `status` = 1 AND `staking` > 0 ORDER BY `Coinpods_unstake`.`updated` ASC LIMIT 11";	
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	
	if($ts){
		foreach($ts as $t){
			UnstakingToTransaction($t);
			
		}	
	}	
}









function UnstakeToUnstaking(){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : 
//Output : Unstaking generate
	
$ab=0;$StakesToStaking=[];
	$Stakes=Unstakes();	
	if($Stakes){
		foreach($Stakes as $Stake){				
			if(Unstaking($Stake)){ $ab++; }			
		}	
	}
	return $ab;	
}




function Unstakes($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : UserID
//Output : Jo User aata hai uski all transaction in unstake table
 
	if($Q){ $SQL="SELECT * FROM `Coinpods_unstake` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `Coinpods_unstake` ORDER BY `Coinpods_unstake`.`id` DESC"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 
}


function Unstaking($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : Transaction ID
//Output : Unstaking generate
	
// Need Complete data of a single Stake
	if($Q and is_array($Q)){
		if($Q['status']==1){
			$Staking=$Q['amount']*$Q['roi']/100;
			
			$SQL="UPDATE `Coinpods_unstake` SET `staking` = `staking` + ".$Staking.", `updated` = current_timestamp()  WHERE `Coinpods_unstake`.`id` = '".$Q['id']."';";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
			
			return true;
		}
	}
}





function UnstakeTotal($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : UserID
//Output : Total amount unstake ki by login user
	
if(i['id']){	

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_unstake` WHERE `user` = '".$Q."';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_unstake`;"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_unstake` WHERE `user` = '".$Q."';";  }
} 
	
if($SQL){		
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(`amount`)']; }
}
else{ $echo='Not enough sources.'; }
}
else{ $echo='Login first.'; }
}



 

function TotalUnstake($Q=null){ return UnstakeTotal($Q); }


	










function Unstake($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : Transaction Id in Coinpods_unstake ki
//Output : Jo transaction Id aati hai uska all deta.
	
if($Q){ 
  $SQL="SELECT * FROM `Coinpods_unstake` WHERE `id` = '".$Q."' LIMIT 1";  
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];		
}
}








function CreateUnstakes(){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : 
//Output : Unstake Create krta hai.
	
	$PTs=PendingUnstake();
	if($PTs){
		
		foreach($PTs as $P){
			if($P){
				
				$CreateUnstake=CreateUnstake($P);
				
				if($CreateUnstake){ UnstakeOne($P['id']); }
				else{ UnstakeTwo($P['id']); }
				
			}
		}
	}
}






function CreateUnstake($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : Amount, CCC, User
//Output : Unstake ki transaction And Coinpods_unstake me transaction insert krta hai.
	
$InsertID=0;
if(is_array($Q)){ $Amount=d2p($Q['amount']); $CCC=strtolower($Q['ccc']); $UserID=$Q['user']; }
	
	$Name='Unstake';
	
	$ROI=0;
	
	if($Amount>=1000 and $Amount<10000){$ROI=0.15;}
	elseif($Amount>=10000){$ROI=0.15;}
	else{$ROI=0.15;}


$Period=365;
$Type='Day';
$Status=1;
	
	if($UserID and $Amount and $CCC){
		
		$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `level`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), 'Unstake:".$UserID.':'.$ID.':'.Clean(GMT())."', '".$UserID."', '', '', '1', 'Unstake', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '0');";
		
		global $DB;$aa = 0;
		$Staked = mysqli_query($DB, $SQL);
		
		if($Staked){ $InsertID=mysqli_insert_id($DB); }
		
		if($Staked){
			
			$SQL2="INSERT INTO `Coinpods_unstake`(`id`, `name`, `created`, `modified`, `user`, `amount`, `ccc`, `roi`, `period`, `ttype`, `status`, `updated`, `staking`, `staked`, `ist`, `price`, `usdt`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$UserID."', '".p2d($Amount)."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', '', '', '', '', '".Price()."', '".p2d($Amount*Price())."')";
			
			global $DB;$aa = 0;
			$Output = mysqli_query($DB, $SQL2);
		
		}
	}
	else{ $echo = 'Not enough sources.'; }
	return $InsertID;
}









function PendingUnstake($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : 
//Output : Pending Unstake ko select krta hai jiska stutas = Seven ho and unstake = Zero
	
	$SQL="SELECT * FROM `Coinpods_stake` WHERE `status` = '7' AND `unstake` = '0'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}



function UnstakeOne($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : Transaction ID
//Output : Coinpods_stake table me unskate column ko one krta hai.[ Success hone pr]

	if($Q){
		$SQL="UPDATE `Coinpods_stake` SET `unstake` = '1' WHERE `id` = '".$Q."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	}
	return $results;
}



function UnstakeTwo($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/10
//Input : Transaction ID
//Output : Coinpods_stake table me unskate column ko two krta hai.[ failed hone pr]
	
	if($Q){
		$SQL="UPDATE `Coinpods_stake` SET `unstake` = '2' WHERE `id` = '".$Q."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	}
	return $results;
}







/////////////////////////////////////////////////////////|| UnStake ||/////////////////////////////////////////////////////////




function Unstake_Status($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/09
//Input : 
//Output : Coinpods_stake me jiss user ki stake ko 365 days se jyada hai ya brabr hai uss user ki transaction ka status seven kr deta hai.
	
	$TotalStakes=TotalStakes();
	if($TotalStakes){
		
		foreach($TotalStakes as $Stake){
			
			$createdDate = new DateTime($Stake['created']);
			$updatedDate = new DateTime($Stake['updated']);
			
			$interval = $createdDate->diff($updatedDate);
			$daysDifference = $interval->days;
			
			if($daysDifference >= 365){
				
				UpdateStakeStatus($Stake['id']);
			
			}
			else{ $echo = "The difference is less than 365 days.".$Stake['user']; }
		}
	}
}


function TotalStakes($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/09
//Input : 
//Output : Transaction select krta hai coinpods_stake me se jiss user ka status one hai.
	
	if($Q){ $SQL="SELECT * FROM `Coinpods_stake` WHERE `status` = '1' AND `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `Coinpods_stake` WHERE `status` = '1' ORDER BY `Coinpods_stake`.`id` ASC LIMIT 1;"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}



function UpdateStakeStatus($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/09
//Input : UserID
//Output : Coinpods_stake me status ko update krta hai.
	
	if($Q){
		$SQL="UPDATE `Coinpods_stake` SET `status` = '7' WHERE `id` = '".$Q."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	}
	return $results;
}


?>