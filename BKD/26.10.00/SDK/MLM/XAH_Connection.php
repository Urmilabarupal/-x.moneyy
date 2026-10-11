<?php


global $XAH;
	$servername = "localhost";
	$username = "xah.ai";
	$password = "db@xah.ai";
	$dbname = "xah.ai";
 	
//	$XAH = new mysqli($servername, $username, $password, $dbname);
//	if ($XAH->connect_error) { die("Connection failed: " . $XAH->connect_error); }

// $link=$XAH;

////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////




function Meting_App_TransferNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-14
// Input : Array
// Output : INSERT
	
	$echo = 'App_Transfer New Start.';
	if(is_array($Q)){ $Name =$Q['name']; $Created=$Q['created']; $Modified=$Q['modified']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Show=$Q['show']; $Balance=$Q['balance']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $Wallet=$Q['wallet']; $Tid=$Q['tid']; $Appfrom=$Q['app-from']; $Appto=$Q['app-to']; $Userfrom=$Q['user-from']; $User_to=$Q['user_to']; $Wallet_from=$Q['wallet_from']; $Wallet_to=$Q['wallet_to']; }
	$echo='is array data found.';

	if($User){
	$echo='All Data Found.';
		
		if(!$Created or !$Modified){ $Created=GMT(); $Modified=GMT(); }

		$SQL="INSERT INTO `Coinpods_app_transfer`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `privacy`, `app`, `show`, `balance`, `amount`, `ccc`, `wallet`, `tid`, `app-from`, `app-to`, `user-from`, `user_to`, `wallet_from`, `wallet_to`) VALUES (NULL, '".$Name."', '".$Created."', '".$Modified."', '', '".$User."', '1', '".$Privacy."', '".$App."', '".$Show."', '".$Balance."', '".p2d($Amount)."', '".$CCC."', '".$Wallet."', '".$Tid."', '".$Appfrom."', '".$Appto."', '".$Userfrom."', '".$User_to."', '".$Wallet_from."', '".$Wallet_to."')";
		$echo = 'SQL Found.';
		global $XAH; $aa = 0; $results = mysqli_query($XAH, $SQL);
		$IID=mysqli_insert_id($XAH);
		if($IID){
		$echo = 'Insert Id Found.';
			
			$SQL1="UPDATE `".prefix."pods_app_transfer` SET `uid`='".$IID."' WHERE `id` = '".$IID."';";
			global $XAH; $aa = 0; $results = mysqli_query($XAH, $SQL1);
		
		}
		else{ $echo = 'Insert Id Not Found.'; }
	}
	else{ $echo = 'Userid not found.'; }
	return $results;

}



function Meting_User($Q=null){
if($Q){
global $XAH; $aa=0;
$SQL = "SELECT * FROM `".prefix."users` WHERE `ID` = '".$Q."'";
$results = mysqli_query($XAH,$SQL);
if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
else{$ps=null;}
$user=$ps[0];
	
return $user;	
}
}





?>