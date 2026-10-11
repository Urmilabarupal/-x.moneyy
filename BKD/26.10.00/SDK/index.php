<?php
//echo GMT();



if(i['id']){
	
	$SQLL="UPDATE `Coinpods_user` SET `modified` = '".GMT()."' WHERE `Coinpods_user`.`id` = ".i['id'].";";
	global $DB;	$results = mysqli_query($DB, $SQLL);	
	
}




function aabbcc(){ echo 'zazazazzazazazazazazazazazaza'; }
//require __DIR__.'/php/0.php';
//require __DIR__.'/php/MLM.php';
//require __DIR__.'/php/Wallet.php';
require __DIR__.'/Exchange.php';
//require __DIR__.'/php/Octa.php';
//require __DIR__.'/php/Gaming.php';
//require __DIR__.'/php/Blockchain.php';
//echo GMT();
















//# Temporary Solution By A'nilNayak







function Level1StakeTotall($Q=null){ 
// Developer : Pawan Kumar
// Date : 2024-11-30
// Input : UserID
// Output : Total Staking Level 1
	
	if(!$Q){ $Q=i['id']; }
	$B=0; 
	if($Q){	
		
		$Downlines = Subordinates(['user'=>$Q, 'level'=>1, 'LIMIT'=>1111111]);
		if($Downlines){
		$aa=0;
		foreach($Downlines as $Level){
		$aa++;  
		$User=user($Level['subordinate']);
		$SS365Days=PendingSelfDeposit($Level['subordinate']);
		if($SS365Days['amount']){
					
		$Userr=$SS365Days['amount']; 
		$B=$B+$Userr;
		if($B){
			
			$SQL="UPDATE `Coinusers` SET `Level1StakeTotal` = '".$B."' WHERE `Coinusers`.`ID` = '".$Q."';";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);

		}  //ELSE ME 
		}
		}
		}
	}
	if($B){ /*UpdateTeamStake($B);*/ return $B; }
}

if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ 
//	if(i['id']){ Level1StakeTotall(); } 
}


//* Temporary Solution By A'nilNayak
?>
