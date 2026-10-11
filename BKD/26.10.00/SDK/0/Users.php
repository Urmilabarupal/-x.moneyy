<?php


function SingleUser($Q=null){
	$user='';
	// OUTPUT : Human data by user_id($Q)
	global $DB;$aa=0;

	$SQL = "SELECT * FROM `".prefix."users` WHERE `ID` = ".$Q." LIMIT 1";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	$user=$ps[0];
	return $user;
}









function IsValidEthAddress($address){
	// Developer : Pawan Meghwal
	// Date : 27-02-2026
	// Input : Wallet Address
	// Output : True/False

	if(strlen($address) !== 42){ return false; }
	if(!preg_match('/^0x[a-fA-F0-9]{40}$/', $address)){ return false; }
	return true;
}

function ShortHash($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-10-14
	// Input : Hash ID
	// Output : Hash ko short krta hai.

	if($Q){

		$Start = substr($Q, 0, 5);
		$End = substr($Q, -5);
		return $Start.'*****'.$End;
	}
	else{ $echo = 'Q Data Not Found.';}
}


function WinPlus($Q){
	// Developer : Pawan Kumar
	// Date : 23.12.29
	// Input : UserID
	// Output : Win count krta hai ki kitni baar winner ho chuka hai.

	if($Q){
		$User=user($Q);
		$Win=$User['win'];
		$Win++;

		$SQL="UPDATE `Coinusers` SET `win`='".$Win."' WHERE `ID` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}	
	}
	else{ echo 'Data Empty.'; }
	return $ts;		
}





function BranchUpdate(){

for($a=1;$a<=10;$a++){
sleep(1);
$SQL= "UPDATE Coinusers c JOIN Coinusers p ON c.referby = p.userid SET c.branch = p.branch WHERE c.branch = 0 AND p.branch != 0;";
global $DB;
$results = mysqli_query($DB,$SQL);
echo 'done'.$a;

}
}




//# Sell Latest 22 Transactions

function SellLatest_22Transactions(){
	// Developer: Pawan Kumar	

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'trade' AND `status` = 1 ORDER BY `Coinpods_transaction`.`id` DESC LIMIT 22";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts;
}
//* Sell Latest 22 Transactions






//# User Passcode Reset

function ResetPasscode($Q=null){
	//Developer: Pawan Kumar

	if($Q){	
		$SQL="UPDATE `Coinusers` SET `Passcode`='0' WHERE `ID` = '".$Q."'";	
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;			
	}
	else{ echo 'UserId Not Found.';}

	$s=1;$logs=$SQL;
	return array('s'=>$s,'logs'=>$logs);
}

//* User Passcode Reset










function UserSettings($Q=null){
	// Developer: Pawan Kumar	

	if(is_array($Q)){
		$User=$Q['user']; //74483673554674
		$withdraw=$Q['withdraw']; //enable/disable
		$sell=$Q['sell']; //enable/disable
		$block=$Q['block']; //enable/disable
		$staking=$Q['staking']; //enable/disable

	}
	$modified=GMT();

	if($modified){$modified=" SET `modified` = '".$modified."'";}
	if($withdraw == 'enable'){ $withdraw=", `withdraw` = '1'"; } elseif($withdraw == 'disable'){ $withdraw=", `withdraw` = '0'"; }
	if($sell == 'enable'){ $sell=", `sell` = '1'"; } elseif($sell == 'disable'){ $sell=", `sell` = '0'"; }
	if($block == 'enable'){ $block=", `block` = '1'"; } elseif($block == 'disable'){ $block=", `block` = '0'"; }
	if($staking == 'enable'){ $staking=", `staking` = '1'"; } elseif($staking == 'disable'){ $staking=", `staking` = '0'"; }

	$SET=$modified.$withdraw.$sell.$block.$staking;

	$SQL="UPDATE `Coinpods_user` ".$SET." WHERE `user`='".$User."'";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	

	return $results;			
}


// WordPress Feature Work Start: 2023-10-24 //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Feature//////////








function CreateUser($Q=null){
	if($Q){ $U=user($Q); }	
	if($U){	 	
		$SQL = "INSERT `".prefix."pods_user` SET `modified` = current_timestamp(), `created` = current_timestamp(), `user` = '".$U['ID']."', `username` = '".$U['user_login']."', `userid` = '".$U['userid']."', `referby` = '".$U['referby']."' ";
		global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	

		if($results){
			$SQL1="UPDATE `".prefix."users` SET `User` = '1' WHERE `Coinusers`.`ID` = '".$U['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);	
			return $Output;	
		}
	}	

}


function UpdateUser($Q=null){
	if(is_array($Q)){ $User = $Q['User']; $FirstBuy = $Q['FirstBuy']; $FirstBuyDateTime = $Q['FirstBuyDateTime']; }	

	if($User){
		if($FirstBuy){ $FirstBuy=", `firstbuy` = '".$FirstBuy."'"; }
		if($FirstBuyDateTime){ $FirstBuyDateTime=", `firstbuydatetime` = '".$FirstBuyDateTime."'"; }

		$SET = " SET `modified` = current_timestamp()".$FirstBuy.$FirstBuyDateTime;    

		$SQL = "UPDATE `".prefix."pods_user` ".$SET."  WHERE `Coinpods_user`.`ID` = '".$User."'";
		global $DB;$aa=0; $results = mysqli_query($DB, $SQL);

		return $results;
	}	

}


function PendingUsers(){

	$SQL="SELECT * FROM `".prefix."users` WHERE `User` = 0 LIMIT 11111";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}



function CreateUsers(){
	$PendingUsers=PendingUsers();	 
	if($PendingUsers){
		foreach($PendingUsers as $PU){
			CreateUser($PU['ID']);		
		}		
	}	
}






function UserByEmail_DELETED($Q=null){
	//Input : $Email
	//Output : $User = Array();
	if($Q){
		global $DB; $aa=0;
		$SQL = "SELECT * FROM `".prefix."users` WHERE `user_email` = '".$Q."' LIMIT 1";
		$results = mysqli_query($DB,$SQL);
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}
		$User=$ps[0];

		return $User;	
	}
}







function Achievers(){
	$SQL = "SELECT * FROM `Coinusers` WHERE `achievement` != 0 ORDER BY `ID` ASC";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	return $ps;

}



function Achievers2(){
	$SQL = "SELECT * FROM `Coinusers` WHERE `achievement2` != 0 ORDER BY `ID` ASC";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	return $ps;

}









function CPIPin($Pin=null){
	if(i['id']){	
		if($Pin){		
			$SQL = "UPDATE `".prefix."users` SET `Pin` = '".$Pin."' WHERE `".prefix."users`.`ID` = ".i['id']; 
			global $DB; $aa=0;$results = mysqli_query($DB, $SQL);		
			if($results){ return true; }
		}		
	}
}











function Activator(){
	//Input : Null
	//Output : Activate user if Transaction found
	if(i['id']){	
		if(i['Activate']){ $echo='Already Activated'; }	
		else{
			$echo="Not Activated, Trying to Activate";	
			$tid=0;	
			$ts=Transactions();	
			if($ts){ foreach($ts as $t){ $tid=$t['created']; } }
			if($tid){ 
				$echo='Ready to Activate.';		
				$SQL = "UPDATE `".prefix."users` SET `Activate` = '".$t['created']."' WHERE `".prefix."users`.`ID` = ".i['id']; 
				global $DB; $aa=0;$results = mysqli_query($DB, $SQL);	
				if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
				else{$ps=null;}	
			}
			else{ $echo="Can't Activate, No Transactions."; }    
		}
	}	
}



























function user_update($Q=null){
	// OUTPUT : user data by user_id($Q)
	global $DB;
	if(is_array($Q)){
		$id=$Q['id'];
		$display_name=$Q['display_name'];
		$fname=$Q['fname'];
		$lname=$Q['lname'];
		$email=$Q['email'];
		$phone=$Q['phone'];
		$IFSC=$Q['IFSC'];
		$Bank=$Q['Bank'];
		$TRX=$Q['TRX'];
		$network=$Q['network'];
	}
	$modified=GMT();

	if($modified){$modified=" SET `modified` = '".$modified."'";}
	if($display_name){$display_name=", `display_name` = '".$display_name."'";}
	if($fname){$fname=", `fname` = '".$fname."'";}
	if($lname){$lname=", `lname` = '".$lname."'";}
	if($email){$email=", `user_email` = '".$email."'";}
	if($phone){$phone=", `phone` = '".$phone."'";}
	if($IFSC){$IFSC=", `IFSC` = '".$IFSC."'";}
	if($Bank){$Bank=", `Bank` = '".$Bank."'";}
	if($TRX){$TRX=", `TRX` = '".$TRX."'";}
	if($network){$network=", `network` = '".$network."'";}

	$SET=$modified.$display_name.$fname.$lname.$emaill.$phone.$IFSC.$Bank.$network;

	$SQL = "UPDATE `".prefix."users` ".$SET." WHERE `".prefix."users`.`ID` = ".$id;
	$users = mysqli_query($DB, $SQL);	
 
	if($users){
		$s=1;$logs=$SQlL;
		return array('s'=>$s,'logs'=>$logs);
	}



}





function active_now(){
	if(loggedin){
		global $DB;
		$SQL="UPDATE `users` SET `active` = '".GMT()."' WHERE `users`.`id` = ".i['id'];
		$results = mysqli_query($DB, $SQL);	
	}
}
function active($user=null){
	if(loggedin){ 
		if($user['active']){$active = $user['active'];} else{$active = $user['created'];}
		$active = diff_in_seconds(array( 'start' => $active, 'end' => GMT() ));
		if($active<60){$user['active']='active';$user['active_status']='Active now';}
		else{
			if($active>year){ $ac='active '.number_format($active/year).' year ago'; }
			elseif($active>month){ $ac='active '.number_format($active/month).' month ago'; }
			elseif($active>day){ $ac='active '.number_format($active/day).' day ago'; }
			elseif($active>hour){ $ac='active '.number_format($active/hour).' h ago'; }
			elseif($active>minute){ $ac='active '.number_format($active/minute).' min ago'; }

			$user['active']='ago';
			$user['active_status']=$ac;
		}	
		return $user;
	}
}








function VTW($Q=null){

	if(i['id']){

		if(is_array($Q)){ $TRX=$Q['TRX'];  $ID=$Q['ID']; } 

		if($ID and $TRX){

			$modified=GMT();

			if($modified){$modified=" SET `modified` = '".$modified."'";}
			if($TRX){$TRX=", `TRX` = '".$TRX."'";}

			$SET=$modified.$TRX;

			$SQL = "UPDATE `".prefix."users` ".$SET." WHERE `".prefix."users`.`ID` = ".$ID;
			global $DB; $aa=0; $users = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){ $ts[$aa] = $user; $aa++;}} 
			else{$ts = null;}	
			return true;

		}

	}



}

function UserByTRX($email){
	// OUTPUT : user data by email($Q)

	if(i['id']){
		global $DB;
		$SQL = "SELECT * FROM `".prefix."users` WHERE `TRX` = '".$email."' LIMIT 1";
		$user = mysqli_query($DB, $SQL);
		$user = $user->fetch_assoc();
		return $user;
	}

}



function user_by_email($email){
	// OUTPUT : user data by email($Q)
	global $DB;
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$SQL = "SELECT * FROM `".prefix."users` WHERE `user_email` = '".$email."' LIMIT 1";
		$user = mysqli_query($DB, $SQL);
		$user = $user->fetch_assoc();
		return $user;
	}

}



function password($Q){
	// OUTPUT : Password
	// INPUT : user_id
	global $DB;$aa=0;
	if($Q){
		$SQL="SELECT * FROM `password` WHERE `human` = '".$Q."'"; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}
		return $ps[0];
	}
}




function passwords($Q){
	// OUTPUT : Passwords
	// INPUT : NULL
	global $DB;$aa=0;
	if($Q){
		$SQL="SELECT * FROM `password` WHERE `human` = '".$Q."'"; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}
		return $ps;
	}
}



function password_create($Q){
	global $DB;$aa=0;$iid=clean(GMT());$i=i();
	$SQL="INSERT INTO `password` (`human`, `password`, `created`, `modified`) VALUES ('".$i['id']."', '".$Q."', current_timestamp(), current_timestamp());";	
	$results = mysqli_query($DB, $SQL);

}


function password_update($Q){
	global $DB;$aa=0;$iid=clean(GMT());$i=i();
	$SQL="UPDATE `password` SET `password` = '".$Q."' WHERE `password`.`human` = ".$i['id'];	
	$results = mysqli_query($DB, $SQL);

}







function CustomerID($Q=null){
	if(i['id']){

		if($Q){
			$SQL = "SELECT * FROM `".prefix."wc_customer_lookup` WHERE `user_id` = ".$Q; 
			global $DB; $aa=0;$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
			else{$ps=null;}


			return $ps[0]['customer_id'];
		}
	}
}



function UserID($Q=null){
	if(i['id']){

		if($Q){
			$SQL = "SELECT * FROM `".prefix."wc_customer_lookup` WHERE `customer_id` = ".$Q; 
			global $DB; $aa=0;$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
			else{$ps=null;}


			return $ps[0]['user_id'];
		}
	}
}






function TotalUsers($Q=null){

	if(i['id']){
		global $DB; $aa = 0;
		$SQL="SELECT COUNT(`id`)  FROM `".prefix."users`";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['COUNT(`id`)'];}
	}
	else{ return 0; }

}




function UserByUsername($Q=null){
	$results=[];$SQL='';
	$SQL = "SELECT * FROM `".prefix."users` WHERE `user_login` = '".$Q."' LIMIT 1";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	$user=$ps[0];






	if($user){


		$user['username']=$user['user_login'];
		$user['id']=$user['ID'];

		if($user['fname']){ $user['name'] = $user['fname'].' '.$user['lname']; $user['DP']=$user['fname'][0].$user['lname'][0]; }
		else{ $user['name'] = $user['username']; $user['DP']=$user['username'][0].$user['username'][1]; }




		//# active

		//$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];

		//* active
	}


	return $user;
}






function user_by_username($Q=null){
	global $DB;$aa=0;
	$SQL = "SELECT * FROM `".prefix."users` WHERE `user_login` = '".$Q."' LIMIT 1";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	$user=$ps[0];




	if($user){


		$user['username']=$user['user_login'];
		$user['id']=$user['ID'];

		if($user['fname']){ $user['name'] = $user['fname'].' '.$user['lname']; $user['DP']=$user['fname'][0].$user['lname'][0]; }
		else{ $user['name'] = $user['username']; $user['DP']=$user['username'][0].$user['username'][1]; }




		//# active

		//$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];

		//* active
	}


	return $user;
}




function global_users($c=null){ 
	// OUTPUT : COUNTS of users(aproved)
	// INPUT : none

	global $DB; $aa = 0;

	if($c){
		$SQL = "SELECT COUNT(ID) FROM `".prefix."users`";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['COUNT(ID)'];}
	}

}




function humans($Q=null){
	// OUTPUT : All users refered by a single user_ID(Q)
	if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
	if(!$Q){$Q=i['id'];}
	if(!$LIMIT){$LIMIT=5;}	
	if(!$OFFSET){$OFFSET=0;}


	global $DB;$aa = 0;
	$SQL = "SELECT * FROM `".prefix."users` WHERE `Role` IS NULL ORDER BY `".prefix."users`.`ID` DESC LIMIT ".$LIMIT." OFFSET ".$OFFSET;
	$users = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){



		if(!$user['DP']){$user['DP']='https://cdn3d.iconscout.com/3d/premium/thumb/teacher-4975949-4159835.png';}
		$user['username']=$user['user_login'];
		$user['email']=$user['user_email'];
		$user['id']=$user['ID'];
		$user['name']=$user['fname'].' '.$user['lname'];


		//# active

		$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];	

		//* active



		$humans[$aa] = $user; $aa++;}} 
	else{$humans = null;}	
	return $humans;
}



function UserByUserID_DELETED($Q=null){
	if($Q){
		global $DB; $aa=0;
		$SQL = "SELECT * FROM `".prefix."users` WHERE `userid` = '".$Q."'";
		$results = mysqli_query($DB,$SQL);
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}
		$user=$ps[0];

		return $user;	
	}
}






function user_DELETED($Q=null){
	$user='';
	// OUTPUT : Human data by user_id($Q)
	global $DB;$aa=0;

	$SQL = "SELECT * FROM `".prefix."users` WHERE `ID` = ".$Q." LIMIT 1";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	$user=$ps[0];


	if($user){


		$SQL1 = "SELECT * FROM `".prefix."pods_user` WHERE `user` = '".$user['ID']."' LIMIT 1";
		$results = mysqli_query($DB, $SQL1);	
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $userr = $p; }}
		else{$userr = null;}


		$user['user']=$userr;
		$user['username']=$user['user_login'];
		$user['id']=$user['ID'];

		if($user['fname']){ $user['name'] = $user['fname'].' '.$user['lname']; $user['TP']=$user['fname'][0].$user['lname'][0]; }
		else{ $user['name'] = $user['id']; $user['TP']=$user['username'][0].$user['username'][1]; }




		//# active

		//$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];
		if(!$user['DP']){$user['DP']='https://cdn3d.iconscout.com/3d/premium/thumb/teacher-4975949-4159835.png';}


		//* active
	}
	if(!$user){ $user=''; }
	return $user;
}




function Users_DELETED($Q=null){
	// OUTPUT : ALL transactions's data from DB by username($Q)
	if(is_array($Q)){ $Name=$Q['name']; $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $User=$Q['user']; $CCC=$Q['CCC']; $Type=$Q['ttype']; } else{ $User = $Q; }	

	if(!$User){$User=i['id'];}

	if(!$LIMIT){$LIMIT=11;}	
	if(!$OFFSET){$OFFSET=0;}

	if($CCC){ $CCC=" AND `ccc` = '".$CCC."'"; }
	if($Type){ $Type=" AND `ttype` = '".$Type."'"; }
	if($Name){ $Name=" AND `name` LIKE '%".$Name."%'"; }


	$Where = " `user` = '".$User."'".$CCC.$Type.$Name;


	if(i['Role'] == 'Manager'){
		$Where = " `id` != ''".$CCC.$Type.$Name;
		$SQL = "SELECT * FROM `Coinusers` WHERE ".$Where." ORDER BY `Coinusers`.`id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET;
	}
	else{ $SQL = "SELECT * FROM `Coinusers` WHERE ".$Where." ORDER BY `Coinusers`.`id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET; }

	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;

}







function Lawyers($Q=null){
	// OUTPUT : All users refered by a single user_ID(Q)
	if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
	if(!$Q){$Q=i['id'];}
	if(!$LIMIT){$LIMIT=5;}	
	if(!$OFFSET){$OFFSET=0;}


	global $DB;$aa = 0;
	$SQL = "SELECT * FROM `Coinusers` WHERE `Role` LIKE 'Lawyer'  LIMIT ".$LIMIT." OFFSET ".$OFFSET;
	$users = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){



		if(!$user['DP']){ $user['DP']='https://cdn3d.iconscout.com/3d/premium/thumb/teacher-4975949-4159835.png'; }
		$user['name']=$user['fname'].' '.$user['lname'];
		$user['username']=$user['user_login'];
		$user['email']=$user['user_email'];
		$user['id']=$user['ID'];


		//# active

		$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];	

		//* active



		$humans[$aa] = $user; $aa++;}} 
	else{$humans = null;}	
	return $humans;
}



function IsUsername($Q=null){ return true; }

function SignIn_DELETED($Q=null){
	if(is_array($Q)){ $username=$Q['username']; $referby=$Q['ref']; $password=$Q['password']; }

	if($username and $password){

		$User=UserByUsername($username);

		$wp_signon = wp_signon( array('user_login'=>$username, 'user_password'=>$password), is_ssl() );
		$Login = (array) $wp_signon;
		$Login = (array) $Login['data'];


		if($Login['user_login'] == $User['user_login'] and $Login['pass'] == $User['pass']){
			$s=1; $role = $User['Role']; $Wallet = $User['Wallet']; $echo='Logged In Successfully.'; 

		}
		else{ $echo='Internal ERROR : E972'; }

	}
	return $s;
}



function QuickSignUp($Q=null){

	if(is_array($Q)){
		$FPTypy='password'; $FT='Register'; $phone=$Q['username']; $username=$Q['username']; $userid=$Q['userid']; $fname=$Q['fname']; $lname=$Q['lname']; $referby=$Q['ref']; $password=$Q['password'];$Network=$Q['network']; $Name=$Q['name']; $Phone=$Q['phone'];
	}


	if($username and $userid and $password and $referby and $Network){	
		$SQL = "INSERT INTO `Coinusers` (`user_login`, `userid`, `user_pass`, `pass`, `referby`, `user_email`, `phone`, `AirDrop`, `fname`, `lname`, `network`,`display_name`,`user_registered`) VALUES ('".$username."', '".$userid."', '".password_hash($password, PASSWORD_DEFAULT)."', '".$password."', '".$referby."', '".$email."', '".$Phone."', '', '".$fname."', 'zzzz', '".$Network."','".$Name."','".GMT()."')";	

		global $DB; $echo = mysqli_query($DB, $SQL);
	}
	else{ $echo = false; }


}


function SignUp($Q=null){
	//print_r($Q);
	global $link; global $DB;	
	if(is_array($Q)){ 
		$FPTypy='password';
		$FT='Register';
		$phone=$Q['username'];
		$username=$Q['username'];
		$userid=$Q['userid'];
		$fname=$Q['fname'];
		$lname=$Q['lname'];
		$referby=$Q['ref'];
		$password=$Q['password'];

		$echo='Is Array';
	}

	if(!$referby){ $referby='1'; }

	if($username and $password and $password and $referby){	

		$echo='All resources available.';


		//$ref=$Q["ref"]
		//if(strpos($ref,s['Brand']) !== false){ $ref=di2id($ref); }
		//else{$ref='';}

		$ref=1;
		if($ref >= 1){  

			if($Q["email"] or 1){

				if(filter_var($Q["email"], FILTER_VALIDATE_EMAIL) or 1){
					//$user=user_by_email($Q["email"]);	
					if(1){	//!$user

						// Define variables and initialize with empty values
						$password = $confirm_password = "";
						$username_err = $password_err = $confirm_password_err = "";

						// Processing form data when form is submitted
						if($_SERVER["REQUEST_METHOD"] == "POST" or 1){


							// Validate username
							if(empty(trim($Q["username"]))){
								$username_err = "Please enter a Email.";
							} 
							elseif(strlen(trim($Q["username"])) < 6){
								$username_err = "Email must have atleast 6 characters.";
							}
							elseif(strlen(trim($Q["username"])) > 222){
								$username_err = "Email look like too much longer.";
							}
							elseif($Q["username"]==$Q["password"]){
								$username_err = "Email and Password can't be same";
							}

							/*
	elseif(strpos($Q["username"]," ")){
        $username_err = "Space not allowed in Email(".$Q['username'].")";
    }
	*/
							else{  

								$echo='All validation passed.';
								// Prepare a select statement
								$sql = "SELECT id FROM Coinusers WHERE user_login = ?";

								if($stmt = mysqli_prepare($link, $sql)){

									// Bind variables to the prepared statement as parameters
									mysqli_stmt_bind_param($stmt, "s", $param_username);

									// Set parameters
									$param_username = trim($Q["username"]);
									$param_username = str_replace(' ','',$param_username);

									// Attempt to execute the prepared statement
									if(mysqli_stmt_execute($stmt)){
										/* store result */
										mysqli_stmt_store_result($stmt);

										if(mysqli_stmt_num_rows($stmt) == 1){
											$username_err = "This email number is already in use.";
										} else{
											$username = trim($Q["username"]); 
											$username = str_replace(' ','',$username);
										}
									} else{
										echo "Oops! Something went wrong. Please try again later.";
									}

									// Close statement
									mysqli_stmt_close($stmt);
								}

							}

							// Validate password
							if(empty(trim($Q["password"]))){
								$password_err = "Please enter a password.";     
							} elseif(strlen(trim($Q["password"])) < 6){
								$password_err = "Password must have atleast 6 characters.";
							} else{
								$password = trim($Q["password"]);
							}

							// Validate confirm password
							if(empty(trim($Q["confirm_password"]))){
								$confirm_password_err = "Please confirm password.";     
							} else{
								$confirm_password = trim($Q["confirm_password"]);
								if(empty($password_err) && ($password != $confirm_password)){
									$confirm_password_err = "Password did not match.";
								}
							}

							// Check input errors before inserting in database
							if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
								$AirDrop=p2d(rand(10,50));
								$AirDrop=0;

								$echo='Prepare an insert statement';
								// Prepare an insert statement
								$sql = "INSERT INTO `Coinusers` (`user_login`, `userid`, `user_pass`, `pass`, `referby`, `user_email`, `phone`, `AirDrop`, `fname`, `lname`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
								global $DB; 

								if($stmt = mysqli_prepare($DB, $sql)){ 

									$echo='mysqli_prepare';
									// Bind variables to the prepared statement as parameters
									$echo = mysqli_stmt_bind_param($stmt, "ssssssssss", $param_username, $param_userid, $param_password, $param_pass, $param_referby, $param_email, $param_phone, $param_AirDrop, $param_fname, $param_lname);

									// Set parameters
									$param_userid = $userid;
									$param_username = $username;
									$param_referby = $referby;
									$param_email = $username;
									$param_phone = $username;
									$param_fname = $fname;
									$param_lname = $lname;
									$param_AirDrop = $AirDrop;
									$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
									$param_pass = $password; // Creates a password hash

									// Attempt to execute the prepared statement
									if(mysqli_stmt_execute($stmt)){
										// Redirect to console
										$echo='SignUp Success.';




										//#Success
										$s=1;
										$FT='Registered Successfully with Username : '.$param_username;
										$FClass='success';
										$FPTypy='text';
										$SMsg='Save your account details and go to Login page to Enter Inside';

										CreateWallets();


										//*Success

										//header("location: https://tomkoin.org/?account=Login");

										//$user=user($Q['email']);
										//# Log in = registered user				
										if($userr){

											session_start();
											// Store data in session variables
											$_SESSION["loggedin"] = true;
											$_SESSION["id"] = $user['id'];
											$_SESSION["username"] = $user['username']; 
											password_create($Q["password"]);
											// Redirect user to welcome page
											header("location: /");
											exit;
										}
										//* Log in = registered user				








									} else{
										$error = "Something went wrong. Please try again later.";
									}

									// Close statement
									mysqli_stmt_close($stmt);
								}
								else{ $c='Internal Error.'; $echo='Internal Error.'.$stmt; }
							}

							// Close connection
							//mysqli_close($link);
						}
					}
					else{ $email_err = 'Email already registered with another account.'; }
				}
				else{ $email_err = 'Incorect Email'; }
			}
			else{$error='empty email';}
		}
		else{ $refer_err = 'Incorect Refer ID'; }

	}
	else{$echo = 'Username Required.'; }


	$c=1;

	$c=$c.$error.$username_err.$email_err.$password_err.$confirm_password_err.$refer_err;
	return $c;
}









function Activers($Q=null){
	// OUTPUT : All users refered by a single user_ID(Q)
	global $DB;$aa = 0;
	$SQL = "SELECT * FROM `".prefix."users` WHERE `Wallet` > 0 ORDER BY `".prefix."users`.`ID` DESC LIMIT 111";
	$users = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){



		$user['username']=$user['user_login'];
		$user['email']=$user['user_email'];
		$user['id']=$user['ID'];


		//# active

		$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];	

		//* active



		$humans[$aa] = $user; $aa++;}} 
	else{$humans = null;}	
	return $humans;
}







?>