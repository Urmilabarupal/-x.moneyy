<?php

function User_MetaNew____By_User_Open(){
	// ye function jin jin users ne 2025-04-15 00:00:00 ke baad system ko open kiya h and user_meta = 0  h unki entry user_meta me krega 
  $OB =  import('User');

$SQL = "SELECT * FROM `Coinpods_user` WHERE `modified` > '2025-04-15 00:00:00' AND `user_meta` = 0 ORDER BY `ID` ASC LIMIT 11;";
global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
else{$ts = null;}	
 
if($ts){ 
	//echo count($ts);
	$t='';
	foreach($ts as $t){
		  echo ':'.$t['user'].'<br>';
		$Array = [];
		$Array = ['user'=>$t['user']];
		$Users = $OB->Users___User_Meta($Array);unset($Array);
		//print_r($Users);
	}
}
else{ $echo = "Data Not Found."; }

}






?>