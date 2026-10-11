<?php




function otp_verify($Q){
// OUTPUT : Human
// INPUT : OTP
global $DB;$aa=0;
	if($Q){
	$SQL="SELECT * FROM `users` WHERE `otp` = '".$Q."'"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
		return $ps[0];
	}
}


function otp_remove(){
// OUTPUT : OTP=''*
// INPUT : Human(loggedin)
	global $DB;$aa=0;
	$SQL="UPDATE `users` SET `otp` = NULL WHERE `users`.`id` = ".i['id'];
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
}




function otp_create($Q){
global $DB;$s=0;
if(is_array($Q)){
	if($Q['id']){$id=$Q['id'];}else{$id=0;}
	if($Q['user']){$user_id=$Q['user'];}else{$user_id=0;}
	if($Q['referby']){$referby=$Q['referby'];}else{$referby=0;}
	if($Q['username']){$username=$Q['username'];}else{$username=0;}
	if($Q['fname']){$fname=$Q['fname'];}else{$fname=0;}
	if($Q['lname']){$lname=$Q['lname'];}else{$lname=0;}
//	if($Q['password']){$password=$Q['password'];}else{$password=0;}
	if($Q['phone']){$phone=$Q['phone'];}else{$phone=0;}
	if($Q['email']){$email=$Q['email'];}else{$email=0;}
	if($Q['trx']){$trx=$Q['trx'];}else{$trx=0;}
	if($Q['eth']){$eth=$Q['eth'];}else{$eth=0;}
	if($Q['btc']){$btc=$Q['btc'];}else{$btc=0;}
	if($Q['country']){$country=$Q['country'];}else{$country=0;}
	$created=GMT();
	$modified=GMT();
	$iid=clean(GMT());
	$otp=random(44);
	if($otp){ $otp='OT'.$user_id.$otp;}
}
if($iid and $email and $otp and $user_id){
$SQL="INSERT INTO `otp` (`id`, `iid`, `user`, `referby`, `username`, `fname`, `lname`, `password`, `phone`, `email`, `cc`, `trx`, `eth`, `btc`, `country`, `created`, `modified`, `aproved`, `status`) VALUES (NULL, '".$iid."','".$user_id."', '".$referby."', '".$username."', '".$fname."', '".$lname."', '".$otp."', '".$phone."', '".$email."', '".$cc."', '".$trx."', '".$eth."', '".$btc."', '".$country."', current_timestamp(), current_timestamp(), NULL, '1');";

	
	$results = mysqli_query($DB, $SQL);	$SQL='';
	$SQL="UPDATE `users` SET `otp` = '".$otp."' WHERE `users`.`id` = ".$user_id;
	$results = mysqli_query($DB, $SQL);	
	
	
	
	$SQL="SELECT * FROM `otp` WHERE `iid` = ".$iid;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	if($ps){$s=1;}

}
	return $s;
}

function otps(){
// OUTPUT : Humans 
// INPUT : NULL
global $DB;$aa=0;
	$SQL="SELECT * FROM `users` WHERE `otp` IS NOT NULL"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
		return $ps;
}



function SendOTP($Q){
$OTP=random_int(100000, 999999);
if($Q and $OTP){
	
	if(OTP($Q)){$SQL="UPDATE `Coinpods_otp` SET `otp` = '".$OTP."' WHERE `Coinpods_otp`.`phone` = '".$Q."'";}
	else{$SQL="INSERT INTO `Coinpods_otp` (`id`, `name`, `created`, `modified`, `otp`, `phone`) VALUES (NULL, '".$Q."', '".GMT()."', '".GMT()."', '".$OTP."', '".$Q."');";}
	global $DB;$aa=0;
	$results = mysqli_query($DB, $SQL);
	
}
if($results){ return $OTP; }
}




function OTP($Q){
	
if($Q){
	$SQL="SELECT * FROM `Coinpods_otp` WHERE `phone` = '".$Q."'";
	global $DB;$aa=0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $OTP = $p; }} 
	else{$user = null;}
	
}
if($OTP){return $OTP['otp'];}
	
}







?>