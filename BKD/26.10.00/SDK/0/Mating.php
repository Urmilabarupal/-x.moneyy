<?php

 
global $Mating;
	$servername = "localhost";
	$username = "HelloX.Live";
	$password = "A@9829011412";
	$dbname = "HelloX.Live";
	$base_url = "https://hellox.live/";
	
	$Mating = new mysqli($servername, $username, $password, $dbname);
	if ($Mating->connect_error) {
		die("Connection failed: " . $Mating->connect_error);
	}
	
  



function DiedUpgradeWalletTotal($Q=null){
	
	$SQL="SELECT SUM(`DiedWalletUpgrade`) FROM `mamber_details`;";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	return $ts[0]['SUM(`DiedWalletUpgrade`)'];

}



function Mating_SlotZero($Q=null){
	

	$SQL="SELECT * FROM `refer_id` WHERE `username` = '".$Q."' LIMIT 1";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts[0];
}






function Mating_SlotZeroNew($Username=null,$SponsorId=null,$Network=null,$Name=null,$Number=null){ 
	
if($Username and $SponsorId and $Network and $Name and $Number){
$no_1 = mt_rand(); $NewUserID = "HX".$no_1;
$SQL="INSERT INTO `refer_id` (`id`, `username`, `sponsor_id`, `payment_status`, `joining_status`, `userid`, `network`, `name`, `phone`) VALUES (NULL, '".$Username."', '".$SponsorId."', '0', '0', '".$NewUserID."', '".$Network."', '".$Name."', '".$Number."');";	  //echo $SQL;
global $Mating; 
$Result = mysqli_query($Mating,$SQL);		
}	 
return $Result;
}












function Mating_AirDrop1($Q=null){
	if($Q){
		$SQL="UPDATE `mamber_details` SET `AirDrop` = '1' WHERE `mamber_details`.`username` = '".$Q."';";
		global $Mating;$aa = 0;
		$results = mysqli_query($Mating, $SQL);
		return $results;		
	}	
}

function Mating_AirDrop2($Q=null){
	if($Q){
		$SQL="UPDATE `mamber_details` SET `AirDrop` = '2' WHERE `mamber_details`.`username` = '".$Q."';";
		global $Mating;$aa = 0;
		$results = mysqli_query($Mating, $SQL);
		return $results;		
	}	
}



function Mating_AirDrop($Q=null){ 
	$U=[];
	if($Q){
		$U = UserByUsername($Q); print_r($Q);
		if($U){
			$QQ=array( 'user'=>$U['ID'], 'name'=>'AirDrop on HelloX SignUP', 'amount'=>200, 'ccc'=>'ccc', 'roi'=>0.10, 'period'=>500, 'type'=>'Day'  ) ;
			if(InsertStake($QQ)){ echo 'done '.$U['ID']; Mating_AirDrop1($Q); }	
			else{ echo 'Not Done '.$U['ID']; Mating_AirDrop2($Q); }	
		}	
	}
}
 


function Mating_PendingAirDrops(){
	

	$SQL="SELECT * FROM `mamber_details` WHERE `AirDrop` = 0 AND `reborn_status` = 0 ORDER BY `Royalty` DESC LIMIT 111";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}




function Mating_AirDrops(){
	

	$Mating_PendingAirDrops = Mating_PendingAirDrops();	
	if($Mating_PendingAirDrops){
		foreach($Mating_PendingAirDrops as $U){			
			Mating_AirDrop($U['username']);		
		}
	}
}






function Mating_TotalDirects(){
	

	$SQL="SELECT COUNT(`id`) FROM `mamber_details` WHERE `sponsor_id` = '".i['userid']."'";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts[0]['COUNT(`id`)'];
}






function Mating_PendingWithdrawsCount(){
	

	$SQL="SELECT COUNT(`wallet`) FROM `mamber_details` WHERE `wallet` >= 2;";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts[0]['COUNT(`wallet`)'];
}



function Mating_PendingWithdrawsTotal(){
	

	$SQL="SELECT SUM(`wallet`) FROM `mamber_details` WHERE `wallet` >= 2;";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts[0]['SUM(`wallet`)'];
}






function Mating_PendingWithdraws(){
	

	$SQL="SELECT * FROM `mamber_details` WHERE `wallet` >= 2 ORDER BY `wallet` DESC LIMIT 44";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}



function Mating_UserByUsername($Q=null){
if($Q){
global $Mating;
$SQL = "SELECT * FROM `mamber_details` WHERE `username` = '".$Q."'";
$Result = mysqli_query($Mating,$SQL);
$Output = mysqli_fetch_assoc($Result);
return $Output;	
}
}



function Mating_UserByUserID($Q=null){
if($Q){
global $Mating;
$SQL = "SELECT * FROM `mamber_details` WHERE `userid` = '".$Q."'";
$Result = mysqli_query($Mating,$SQL);
$Output = mysqli_fetch_assoc($Result);
return $Output;	
}
}




function Mating_PendingHXUsers(){
	

	$SQL="SELECT * FROM `refer_id` WHERE `HX` = 0 ORDER BY `id` DESC LIMIT 1";
	global $Mating;$aa = 0;
	$results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}

function HelloXToHX($HX=null){
$results=0;
if(is_array($HX)){ $Username=$HX['username']; $Ref=$HX['sponsor_id']; $Password=rand(1000000000,9999999999); }

$UserByUserID='';
$UserByUserID=UserByUserID($HX['userid']);

	$sss='User ID : '.$UserByUserID;
	
if(!$UserByUserID['ID']){
	 
	$echo = 'No user found, Create new user';
	
	$sss=$sss.'$Username : '.$Username . ' $Password : '.$Password . ' $Ref : '.$Ref.' user id :'.$HX['userid'] ;
	if($Username and $Password and $Ref and $HX['userid']){
		$echo = 'Running Sign Up Function'; 
		
		
		 
		$SignUp=SignUp(array( 'username'=>$Username, 'userid'=>$HX['userid'], 'password'=>$Password, 'confirm_password'=>$Password, 'ref'=>$Ref ));
		$sss=$sss.'OK '.$SignUp;
		$echo=$SignUp;
		
		
		
		
	unset($UserByUserID);
	$UserByUserID=UserByUserID($HX['userid']);
	
		 
	$sss=$sss.$UserByUserID['ID'];
	
	if($UserByUserID['ID']){ 
		$SQL="UPDATE `refer_id` SET `HX` = '1' WHERE `refer_id`.`id` = '".$HX['id']."';";
		global $Mating; $results = mysqli_query($Mating, $SQL);	
		 $echo = 'Sign Up Success.';
	}
	else{ 
		$SQL="UPDATE `refer_id` SET `HX` = '2' WHERE `refer_id`.`id` = '".$HX['id']."';";
		global $Mating; $results = mysqli_query($Mating, $SQL);	
		 
		$echo = 'Failed Attempt.'.$sss;
	}
		
		
		
	}
	else{ $echo = 'Not enough sources.'; }
	

	
}
else{ 

	$SQL="UPDATE `refer_id` SET `HX` = '1' WHERE `refer_id`.`id` = '".$HX['id']."';";
	global $Mating; $results = mysqli_query($Mating, $SQL);	
	$echo = 'Found Already';
}

	
	return $echo;
}


function HelloXsToHXs(){
$HelloXsToHXs='';
	
$Mating_PendingHXUsers=Mating_PendingHXUsers();
if($Mating_PendingHXUsers){  

	foreach($Mating_PendingHXUsers as $HX){	
		$HelloXsToHXs=$HelloXsToHXs.'<br/><br/>'.HelloXToHX($HX);		//echo $HX['userid'].'<br/>';
	}
}
	return $HelloXsToHXs;
}









//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function Ff2(){
//Developer : Pawan Kumar
//Date : 2024/01/07
//Input : 
//Output : Inserts a transaction into a table name BUSD in the helocs of all users whose usdt is >0.
	
	$F2=F2();
	if($F2){
		foreach($F2 as $F){
			//print_r($F['user']); echo '<br>';
			
			$user=user($F['user']);
			if($user){
				
				$SlotWallets=SlotWallets($user['ID']);
				$Amountt=d2p($SlotWallets['usdt']); $Amount=$Amountt-$Amountt;
				//print_r($user['ID'].$Amount);
				
				$SWU=SWU(array('usdt'=>d2p($Amount), 'user'=>$user['ID']));
				if($SWU){
					
					$Time = gmdate("YmdHmi");
					$amount=$Amountt*1000000000000000000;
					$args=array(
						'hash'=>"HX:".clean(GMT()),
						'amount'=>$amount,
						'from'=>$user['user_login'],
						'to'=>BUSD,
						'timestamp'=>$Time,
						'token'=>'BSC-USD',
						'invest'=>$invest,
						'upgrade_wallet'=>$upgrade_wallet
					);
					//print_r($args); echo '<br><br>';
					
					$Mating_UserByUsername=Mating_UserByUsername($args['from']); 
					if($Mating_UserByUsername['username']){ $args['invest']=1; $args['upgrade_wallet']=1; }
					
					//print_r($args);
					
					create_trx($args);

				}
			}
		}
	}
}






















function Ff1(){
//Developer : Pawan Kumar
//Date : 2024/01/07
//Input : 
//Output : Activates the user who is not active and inserts the transaction in the table named BUSD in HelloX.
	
	$F1=F1();
	if($F1){
		foreach($F1 as $F){
			//print_r(d2p($F['usdt']));
			
			$user=user($F['user']);
			if($user){ $UserID=$user['ID'];
				
				$SlotWallets=SlotWallets($UserID);
				$Amountt=$SlotWallets['usdt']; $Amount=$Amountt-27000000000;
				
				$SWU=SWU(array('usdt'=>d2p($Amount), 'user'=>$UserID));
				if($SWU){
					
					$Time = gmdate("YmdHmi");
					$amount=30*1000000000000000000;
					$args=array(
						'hash'=>"HX:".clean(GMT()),
						'amount'=>$amount,
						'from'=>$user['user_login'],
						'to'=>BUSD,
						'timestamp'=>$Time,
						'token'=>'BSC-USD',
						'invest'=>$invest,
						'upgrade_wallet'=>$upgrade_wallet
					);
					
					$Mating_UserByUsername=Mating_UserByUsername($args['from']);
					if($Mating_UserByUsername['username']){ $args['invest']=1; $args['upgrade_wallet']=1; }

					create_trx($args);
					sleep(1);
					
					$URL='https://hellox.live/Aliens/Coin/23.08.04/cron/run_active_join.php?address='.$user['user_login'];
					$Activatee=file_get_contents($URL); //$b=GMT();

					
				}
				else{ $echo = 'Slot wallet not response.'; }
			}
			else{ $echo = 'User Details Not Found.'; }
		}
	}
}



function create_trx($Q=null){
// OUTPUT : multiple withdraw data from DB by user_ID($Q)
global $Mating;$aa = 0;
$SQL = "INSERT INTO `BUSD` (`id`, `hash`, `from`, `to`, `amount`, `type`, `status`, `token`, `created`, `modified`, `aproved`, `timestamp`, `invest`, `upgrade_wallet`) VALUES (NULL, '".$Q['hash']."', '".$Q['from']."', '".$Q['to']."', '".$Q['amount']."', NULL, '0', '".$Q['token']."', current_timestamp(), current_timestamp(), NULL, '".$Q['timestamp']."', '".$Q['invest']."', '".$Q['upgrade_wallet']."');";
	$results = mysqli_query($Mating, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
	//return $SQL;
}




function SWU($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/07
//Input : Amount, UserID
//Output : Updates the amount of the user whose amount has come.
	
	if(is_array($Q)){ $Amount=$Q['usdt']; $User=$Q['user']; }
	if($User){
		
		$SQL="UPDATE `Coinpods_slotwallet` SET `usdt`='".p2d($Amount)."' WHERE `user` = '".$User."';";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}










function F1($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/07
//Input : 
//Output : Selects all users whose usdt >=30 and those who are not active. 
	
	$SQL="SELECT * FROM `Coinpods_slotwallet` WHERE `usdt` >= 27000000000 AND `activate` IS NULL ORDER BY `activate` ASC LIMIT 1";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}







function F2($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/07
//Input : 
//Output : Selects all the users whose usdt >0 and only the active users will be included in it.
	
	//$SQL="SELECT * FROM `Coinpods_slotwallet` WHERE `user` = '744872452623' AND `usdt` > 0 AND `activate` IS NOT NULL ORDER BY `usdt` DESC LIMIT 1;";
	
	$SQL="SELECT * FROM `Coinpods_slotwallet` WHERE `usdt` > 0 AND `activate` IS NOT NULL ORDER BY `usdt` DESC LIMIT 1;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}










//# All Users Ke Liye

function SlotActivations(){
//Developer : Pawan Kumar
//Date : 2024/01/06
//Input : 
//Output : HelloX se user get karke hx.money ke coinusers table me SlotActivation ko update krta hai ( current_timestamp ).
	
	$Output=0;
	$GetHelloxUser=GetHelloxUser();
	if($GetHelloxUser){
		foreach($GetHelloxUser as $User){
			//print_r($User['userid']);
			
			$SlotActivation=SlotActivation($User['userid']);
			if($SlotActivation){ $SlotWalletActivate = SlotWalletActivate($User['userid']); } 
			
			if($SlotWalletActivate){
				
				SAStatusOne($User['userid']); 
				
				$Output++;
			
			}
			else{ SAStatusTwo($User['userid']); }
		}
	}
	return $Output;
}



function SlotWalletActivate($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/06
//Input : UserID
//Output : Hx.Money Ke Slot Wallet Me Activate Ko Update Krta Hai.
	
	if($Q){
		
		$User=UserByUserID($Q);
		$Activate = gmdate('Y-m-d');
		
		$SQL="UPDATE `Coinpods_slotwallet` SET `activate`='".$Activate."' WHERE `user` = '".$User['ID']."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}





function SlotActivation($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/06
//Input : UserID
//Output : Hx.Money Ke Coinusers Me SlotActivation Ko Update Krta Hai.
	
	if($Q){
		
		$SQL="UPDATE `Coinusers` SET `SlotActivation` = current_timestamp() WHERE `userid` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}








function GetHelloxUser(){
//Developer : Pawan Kumar
//Date : 2024/01/06
//Input : 
//Output : HelloX Se Jo Actieve Users Hai Unko Select Krta Hai.
	
	$SQL="SELECT * FROM `mamber_details` WHERE `reborn_status` = '0' AND `SA` = '0' LIMIT 10000";
	global $Mating;$aa = 0; $results = mysqli_query($Mating, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;
}




function SAStatusOne($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/06
//Input : UserID
//Output : SoltActievetion = 1
	
	if($Q){
		
		$SQL="UPDATE `mamber_details` SET `SA` = '1' WHERE `userid` = '".$Q."';";
		global $Mating;$aa = 0; $results = mysqli_query($Mating, $SQL);
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}





function SAStatusTwo($Q=null){
//Developer : Pawan Kumar
//Date : 2024/01/06
//Input : UserID
//Output : SoltActievetion = 2

	
	if($Q){
		
		$SQL="UPDATE `mamber_details` SET `SA` = '2' WHERE `userid` = '".$Q."';";
		global $Mating;$aa = 0; $results = mysqli_query($Mating, $SQL);
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



//* All Users Ke Liye












