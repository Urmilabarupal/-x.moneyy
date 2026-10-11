<?php
 
function Search($Q=null){
if(is_array($Q)){ $Type=$Q['Type']; $Search=$Q['Search'];  }

if($Type and $Search){
	
	

if($Type=='User'){
	$SQL="SELECT * FROM `Coinusers` WHERE `ID` LIKE '%".$Search."%'  OR `userid` LIKE '%".$Search."%'  OR `user_login` LIKE '%".$Search."%' OR `referby` LIKE '%".$Search."%' OR `fname` LIKE '%".$Search."%' OR `lname` LIKE '%".$Search."%' OR `user_email` LIKE '%".$Search."%' OR `user_registered` LIKE '%".$Search."%' LIMIT 11"; 
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 	}
		
}
 
}
?>