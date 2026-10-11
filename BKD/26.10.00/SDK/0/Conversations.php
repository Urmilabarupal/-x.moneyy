<?php





function Conversation($Q=null){
// OUTPUT : ALL Conversations's data from DB by user ID($Q)
//if(!$Q){$Q=i['id'];}
global $DB;$aa = 0;$LIMIT=111;
	$SQL = "SELECT * FROM `Coinpods_conversations` WHERE `id` = '".$Q."' LIMIT 1"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){
		
		$lawyer=explode(',',$t['users']);
		$lawyer=$lawyer[1];
		
		$lawyer=str_replace(',','',$lawyer);
		$lawyer=str_replace('[','',$lawyer);
		$lawyer=str_replace(']','',$lawyer);
		$t['lawyer']=$lawyer;
		
		
		
	$user=str_replace('['.i['id'].']','',$t['users']);
	$user=str_replace(',','',$user);
	$user=str_replace('[','',$user);
	$user=str_replace(']','',$user);
		$t['user']=$user;
		
		$ts[$aa] = $t;
		$aa++;
	}} 
	else{$ts = null;}	
	return $ts[0];
}
 

function EditConversation($Q=null){
// OUTPUT : ALL Conversations's data from DB by user ID($Q)
//if(!$Q){$Q=i['id'];}
	
if(is_array($Q)){ $Lawyer=$Q['Lawyer']; $id=$Q['id']; }
	
	

	
if($Lawyer and $id){
$Conversation=Conversation($id);
$users=explode(',',$Conversation['users']);
$users=$users[0].',['.$Lawyer.']';
	
	
	
global $DB;$aa = 0; 
	 $SQL = "UPDATE `Coinpods_conversations` SET `users` = '".$users."' WHERE `Coinpods_conversations`.`id` = '".$id."';"; 
	$results = mysqli_query($DB, $SQL);	 	
	return $results;
}
}






function EditCall($Q=null){
// ID == Call ID
if(is_array($Q)){ $Lawyer=$Q['Lawyer']; $ID=$Q['id']; }	
if($Lawyer and $ID){

global $DB;$aa = 0; 
	 $SQL = "UPDATE `Coinpods_call` SET `lawyer` = '".$Lawyer."' WHERE `Coinpods_call`.`id` = '".$ID."'"; 
	$results = mysqli_query($DB, $SQL);	 	
	return $results;
}
}







function Call($Q=null){

	
 
if($Q){ 
if(i['id']){
global $DB;$aa = 0; 
	
  	 $SQL = "SELECT * FROM `Coinpods_call` WHERE `id` = '".$Q."'";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
 	}
}
}






function PendingCalls($Q=null){

	
if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
if(!$Q){$Q=i['id'];}
if(!$LIMIT){$LIMIT=5;}	
if(!$OFFSET){$OFFSET=0;}
	
	$user=$Q;
	
if(!$user){ $user=i['id'];}	
 
if(i['id']){
global $DB;$aa = 0; 
	
if(i['am']=='Admin'){ $SQL = "SELECT * FROM `Coinpods_call` WHERE `status` = '1' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	elseif(i['am']=='Lawyer'){ $SQL = "SELECT * FROM `Coinpods_call` WHERE `status` = '1' AND `lawyer` = '".i['id']."' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	else{$SQL = "SELECT * FROM `Coinpods_call` WHERE `status` = '1' AND `user` = '".$user."' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET;}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
 	}
 
}





function LiveCalls($Q=null){

	
if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
if(!$Q){$Q=i['id'];}
if(!$LIMIT){$LIMIT=5;}	
if(!$OFFSET){$OFFSET=0;}
	
	$user=$Q;
	
if(!$user){ $user=i['id'];}	
 
if(i['id']){
global $DB;$aa = 0; 
	
if(i['am']=='Admin'){ $SQL = "SELECT * FROM `Coinpods_call` WHERE `status` = '4' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	elseif(i['am']=='Lawyer'){ $SQL = "SELECT * FROM `Coinpods_call` WHERE `status` = '4' AND `lawyer` = '".i['id']."' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	else{$SQL = "SELECT * FROM `Coinpods_call` WHERE `status` = '4' AND `user` = '".$user."' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET;}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
 	}
 
}


function Calls($Q=null){

	
if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
if(!$Q){$Q=i['id'];}
if(!$LIMIT){$LIMIT=5;}	
if(!$OFFSET){$OFFSET=0;}
	
	$user=$Q;
	
if(!$user){ $user=i['id'];}	
 
if(i['id']){
global $DB;$aa = 0; 
	
  	if(i['am']=='Admin'){$SQL = "SELECT * FROM `Coinpods_call` ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	elseif(i['am']=='Lawyer'){$SQL = "SELECT * FROM `Coinpods_call` WHERE `lawyer` = '".i['id']."' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET;}
	else{$SQL = "SELECT * FROM `Coinpods_call` WHERE `user` = '".$user."' ORDER BY `Coinpods_call`.`id` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET;}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
 	}
 
}







function Call_Create($Q=null){
// OUTPUT : ALL Messages's data from DB by User ID($Q)
if(is_array($Q)){ $name=$Q['name']; $user=$Q['user']; $status=$Q['status']; $case=$Q['case']; $category_id=$Q['category_id']; $language=$Q['language']; $Schedule=$Q['Schedule']; $CaseID=$Q['CaseID']; }
	if(!$status){$status=1;}

if(i['id']){
global $DB;$aa = 0;$LIMIT=111;
	
	if($name and $user and $category_id and $language and $Schedule and $CaseID){
 	 $SQL = "INSERT INTO `Coinpods_call` (`id`, `name`, `created`, `modified`, `lawyer`, `user`, `status`, `duration`, `case`, `category_id`, `language`, `time`) VALUES (NULL, '".$Schedule."', '".GMT()."', '".GMT()."', '".$lawyer."', '".$user."', '".$status."', '".$duration."', '".$CaseID."', '".$category_id."', '".$language."', '".$Schedule."');";  
	$results = mysqli_query($DB, $SQL);
		$IID=mysqli_insert_id($DB);
	 if($results){
		 
		 //# update balance
		$UB = "UPDATE `Coinusers` SET `Wallet` = `Wallet`- 10 WHERE `Coinusers`.`ID` = ".i['ID'];
		$UPB = mysqli_query($DB, $UB);
		//# update balance
		 
		 if($UPB){return $IID;}
	 }
	}
	}
}




 





function ConversationCreate($Q=null,$U=null){
	
	if(!$U){ $U=i['id']; }
	
	if(i['id']){
// OUTPUT : ALL Conversations's data from DB by user ID($Q)
//if(!$Q){$Q=i['id'];}
global $DB;$aa = 0;$LIMIT=111;
		
		$users='['.$U.'],[2]';
	if($Q and $users){
	if(iam['admin'] and !PP){$SQL = "SELECT * FROM `Coinpods_conversations` ORDER BY `Coinpods_conversations`.`modified` DESC LIMIT ".$LIMIT; }
	else{$SQL = "INSERT INTO `".prefix."pods_conversations` (`id`, `name`, `created`, `modified`, `users`) VALUES (NULL, '".$Q."', '".GMT()."', '".GMT()."', '".$users."');"; }
	$results = mysqli_query($DB, $SQL);	
	$IID=mysqli_insert_id($DB);
	}
	}
	else{$results=0;}
 	return $IID;
}

function ConversationByUser($Q=null){
// OUTPUT : ALL Conversations's data from DB by user ID($Q)
//if(!$Q){$Q=i['id'];}
global $DB;$aa = 0;$LIMIT=111;
	if(iam['admin'] and !PP){$SQL = "SELECT * FROM `Coinpods_conversations` ORDER BY `Coinpods_conversations`.`modified` DESC LIMIT ".$LIMIT; }
	else{$SQL = "SELECT * FROM `Coinpods_conversations` WHERE `users` LIKE '%[".i['id']."]%' AND `users` LIKE '%[".$Q."]%'"; }
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){
		
	$user=str_replace('['.i['id'].']','',$t['users']);
	$user=str_replace(',','',$user);
	$user=str_replace('[','',$user);
	$user=str_replace(']','',$user);
		$t['user']=$user;
		
		$ts[$aa] = $t;
		$aa++;
	}} 
	else{$ts = null;}	
	return $ts;
}


function Conversations($Q=null){
// OUTPUT : ALL Conversations's data from DB by user ID($Q)
if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
if(!$Q){$Q=i['id'];}
if(!$LIMIT){$LIMIT=5;}	
if(!$OFFSET){$OFFSET=0;}
	
	
if(!$Q){$Q=i['id'];}
global $DB;$aa = 0; 
	
	if(iam['admin'] and !PP){$SQL = "SELECT * FROM `Coinpods_conversations` ORDER BY `Coinpods_conversations`.`modified` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET;}
	else{$SQL="SELECT * FROM `Coinpods_conversations` WHERE `users` LIKE '%[".$Q."]%' ORDER BY `Coinpods_conversations`.`modified` DESC   LIMIT ".$LIMIT." OFFSET ".$OFFSET;}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){
		
	$user=str_replace('['.i['id'].']','',$t['users']);
	$user=str_replace(',','',$user);
	$user=str_replace('[','',$user);
	$user=str_replace(']','',$user);
		$t['user']=$user;
		
		$ts[$aa] = $t;
		$aa++;
	}} 
	else{$ts = null;}	
	return $ts;
}




function MessageSend($Q=null){
// OUTPUT : ALL Messages's data from DB by User ID($Q)
if(is_array($Q)){

	
	
	
	$Conversation=$Q['Conversation'];
	$Amount=$Q['Amount'];
	$From=i['ID'];
	$To=$Q['To'];
	$Notes=$Q['Notes'];
}
	
	
	if($Conversation){ $Status=1; $Wallet=1;  }
			else{ $Status=0; $Wallet=0;  }
	
	
	
	if($Conversation and $Amount and $From and $To){
		 
global $DB;$aa = 0;$LIMIT=111;
		
		if($Status){
		//# update balance
		//$UB = "UPDATE `Coinusers` SET `Wallet` = `Wallet`- ".p2d($Amount)." WHERE `Coinusers`.`ID` = ".i['ID'];
		//$UPB = mysqli_query($DB, $UB);
		//# update balance
			
		}

		
		
		
		if(iam['admin'] and !PP){$SQL = "SELECT * FROM `Coinpods_messages` ORDER BY `Coinpods_messages`.`modified` DESC LIMIT ".$LIMIT; }
	else{$SQL = "INSERT INTO `Coinpods_messages` (`id`, `name`, `created`, `modified`, `to`, `from`, `amount`, `conversation`, `status`, `wallet`) VALUES (NULL, '".$Amount."', '".GMT()."', '".GMT()."', '".$To."', '".$From."', '".$Amountt."', '".$Conversation."', '".$Status."', '".$Wallet."');"; }
	$results = mysqli_query($DB, $SQL);	
	 
	 if($results and $Status){ 
	 	//# Credit Balance
		//$CB = "UPDATE `Coinusers` SET `Wallet` = `Wallet`+ ".p2d($Amount)." WHERE `Coinusers`.`ID` = ".$To;
		//$CBT = mysqli_query($DB, $CB);
		//# Credit Balance
		 if($CBT){return 1;} else{ return 1;}

	 }
		 
	}
	else{ return 0; }
	
}





function MessageCreate($Q=null){
// OUTPUT : ALL Messages's data from DB by User ID($Q)
if(is_array($Q)){

	
	
	
	$Conversation=$Q['Conversation'];
	$Amount=$Q['Amount'];
	$From=i['ID'];
	$To=$Q['To'];
	$Notes=$Q['Notes'];
}
	
	
	if($Amount <= d2p(WalletBalance())){ $Status=1; $Wallet=1;  }
			else{ $Status=0; $Wallet=0;  }
	
	
	
	if($Conversation and $Amount and $From and $To){
		 
global $DB;$aa = 0;$LIMIT=111;
		
		if($Status){
		//# update balance
		$UB = "UPDATE `Coinusers` SET `Wallet` = `Wallet`- ".p2d($Amount)." WHERE `Coinusers`.`ID` = ".i['ID'];
		$UPB = mysqli_query($DB, $UB);
		//# update balance
			
		}

		
		
		
		if(iam['admin'] and !PP){$SQL = "SELECT * FROM `Coinpods_messages` ORDER BY `Coinpods_messages`.`modified` DESC LIMIT ".$LIMIT; }
	else{$SQL = "INSERT INTO `Coinpods_messages` (`id`, `name`, `created`, `modified`, `to`, `from`, `amount`, `conversation`, `status`, `wallet`) VALUES (NULL, '".$Notes."', '".GMT()."', '".GMT()."', '".$To."', '".$From."', '".$Amount."', '".$Conversation."', '".$Status."', '".$Wallet."');"; }
	$results = mysqli_query($DB, $SQL);	
	 
	 if($results and $Status){ 
	 	//# Credit Balance
		$CB = "UPDATE `Coinusers` SET `Wallet` = `Wallet`+ ".p2d($Amount)." WHERE `Coinusers`.`ID` = ".$To;
		$CBT = mysqli_query($DB, $CB);
		//# Credit Balance
		 if($CBT){return 1;} 

	 }
		 
	}
	else{ return 0; }
	
}



function Messages($Q=null){
// OUTPUT : ALL Messages's data from DB by User ID($Q)
if(is_array($Q)){ $Conversation=$Q['Conversation']; $From=$Q['From']; $To=$Q['To']; }	

	if($Conversation){
global $DB;$aa = 0;$LIMIT=111;
	$SQL = "SELECT * FROM `Coinpods_messages` WHERE `conversation` = '".$Conversation."' ORDER BY `Coinpods_messages`.`created` ASC"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
	}
}

function LastMessages($Q=null){
// OUTPUT : ALL Messages's data from DB by User ID($Q)
if(!$Q){$Q=i['id'];}
	
global $DB;$aa = 0; 
	$SQL = "SELECT * FROM `Coinpods_messages` WHERE `conversation` = '".$Q."' ORDER BY `Coinpods_messages`.`created` DESC LIMIT 1"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0]['name'];
}



?>