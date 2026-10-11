<?php



	function WalletAddressUpdate($Array=[],$NewConditions=[],$Table='walletaddress',$SQL=false){
		// Developer : JAspal Byavat
		// Work : In Progress
		// Date : 02-01-2025 [dd-mm-yy]
		// Select Data input Data According  
		// INPUT Data   According This ==>

		/*
$Conditions = [
    'uid' => ['oprator'=> '=' , 'value1'=>'11', 'value2'=>''] ,
     'user' => ['oprator'=> '=' , 'value1'=>'1', 'value2'=>''],
 // 'amount' => ['oprator'=> 'LIKE' , 'value1'=>'1000']
];
$Data = ['user'=>'1','status'=>'1','balance'=>'1','oca'=>'2222222'];
    */


		$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';

		if($Table){$TableName=$Table;}else{$TableName='Write Table Name ';} 

		$Conditions = [];
		if(empty($NewConditions)){

			if(!empty($Array['uid'])){
				$Conditions['uid'] = ['oprator'=> '=' , 'value1'=>$Array['uid'], 'value2'=>''];
				$echo = 'kis Value k according set krna h vo yha pr setup kiya hai';

				unset($Array['uid']);
				$echo = ' Original array se uid remove karna';
			}
			else{$echo = 'kis value k according data update kre please pass value , like uid ya id';}


			if(!empty($Array['id'])){
				$Conditions['id'] = ['oprator'=> '=' , 'value1'=>$Array['id'], 'value2'=>''];
				$echo = 'kis Value k according set krna h vo yha pr setup kiya hai';

				unset($Array['id']);
				$echo = ' Original array se id remove karna';
			}
			else{$echo = 'kis value k according data update kre please pass value , like uid ya id';}
		}
		else{$Conditions = $NewConditions;$echo = 'Input Data Is New Conditions According';}



		if($TableName){
			return RowUpdate($Array, $Conditions,$TableName,$SQL);
		}
		else{$echo = 'Table Name Is Required.';}
		//echo $echo;
	}















	
function AddressToID($Q=null){
if($Q){	
	$SQL="SELECT * FROM `Coinpods_walletaddress` WHERE `trc20` = '".$Q."' OR  `erc20` = '".$Q."' OR  `bep20` = '".$Q."'"; 
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0]['user'];	
	
}	
}

function WalletAddresses($Q=null){
if($Q){ $SQL="SELECT * FROM `Coinpods_walletaddress` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_walletaddress` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];		
	
	
}
	



function CreateWalletAddress($Q=null){
$Output='';
	if($Q){
		$User=user($Q); print_r($User);
		if($User){
		$Wallets=WalletAddresses($Q);
		if(!$Wallets){
			$SQL="INSERT INTO `Coinpods_walletaddress` (`id`, `name`, `created`, `modified`, `erc20`, `user`, `bep20`, `trc20`) VALUES (NULL, '".$User['user_login']."', current_timestamp(), current_timestamp(), '', '".$User['ID']."', '".$User['user_login']."', '');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	 
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `WalletAddress` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);				
				
			}
			
		}
		else{ 
			//print_r($Wallets);
			$SQL1="UPDATE `Coinusers` SET `WalletAddress` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
}




function CreateWalletAddresses(){
	$PendingWallets=PendingWalletAddresses();	 
	if($PendingWallets){
		foreach($PendingWallets as $PW){
			CreateWalletAddress($PW['ID']);		
		}		
	}	
}


function PendingWalletAddresses(){

	$SQL="SELECT * FROM `Coinusers` WHERE `WalletAddress` = 0";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}





?>