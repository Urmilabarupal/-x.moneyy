<?php
define('Trrafic',clean(GMT().$_SERVER['REMOTE_ADDR']));








function i_DELETED($Q=null){


// OUTPUT : Loged user's data in Array()	
// OUTPUT : username	
	
if($_SESSION['username'] or username){
    
global $DB;$aa=0;

if(is_array($Q)){$do = $Q['do'];}
else{$do = 'SELECT';}

	
if($do == 'SELECT'){
	if($_SESSION['username']){ $username=$_SESSION['username']; }
	else{$username = username;}
	if(PP){$username=$_REQUEST['at'];}

	$SQL = "SELECT * FROM `".prefix."users` WHERE `user_login` = '".$username."' LIMIT 1"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $user = $p; }} 
	else{$user = null;}
	if($user){
		
		$SQL1 = "SELECT * FROM `".prefix."pods_user` WHERE `user` = '".$user['ID']."' LIMIT 1";
		$results = mysqli_query($DB, $SQL1);	
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $userr = $p; }}
		else{$userr = null;}
		
        
		if(!$user['Role']){$user['Role']='User';}
		$user['user']=$userr;
		$user['am']=$user['Role'];

        $user['username']=$user['user_login'];
        $user['id']=$user['ID'];
		if($user['Role']=='Manager'){ $user['am']='Manager'; $user['DIR']=$user['Role'].'/'.app['theme']; }
		else{$user['DIR']=$user['Role'].'/'.app['theme'];}

        
 
        
		
		$user['in']=1;
		
		//# generating full name
		if($user['fname'] or $user['lname']){
		$user['name']=$user['fname'].' '.$user['lname'];
		}
		
		
		//else{$user['name']=$user['username'];}
		//* generating full name
		//# active
		
		//$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];	
		
		//* active
		$user['ReferID']=$user['ID'];
		$user['referlink']=app['url'].'/?ref='.$user['ID'];
		$user['referlink']=app['url'].'/?ref='.$user['userid'];
		$user['ref']=app['url'].'/?ref='.$user['userid'];

	}
	
	$return=$user;
}
elseif($do == 'UPDATE'){
	$SQL = "UPDATE `users` SET ".$Q['SET']." WHERE `users`.`id` = ".$Q['id'];
	$user = mysqli_query($DB, $SQL);
	$user = $user->fetch_assoc();
	$return=$user;
}
}
	else{
		$user['DIR']='User'.'/'.s['CCC'];
		$return=$user;
		
	}
 	
return $return;
}




//$i=i();

//define('i',$i);



//if(i['Role']=='Admin'){$iam=array('admin'=>1);}
//else{$iam=array('admin'=>0);}
//define('iam',$iam);

//$loggedin=0;
//if(i['in'] or $_SESSION['username']){ $loggedin=1;}
//else{$loggedin=0;}
//define('loggedin',$loggedin);






function l_DELETED($Q=null){
if(i['id']==1 or i['id'] == 744872452621){
if(is_array($Q)){}
else{$text=$Q;}
	
if(i['id']){$i=i['id'];}
global $Start; global $End; global $Wait;
	
$name="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
$SQL="INSERT INTO `Coinpods_log` (`id`, `name`, `created`, `modified`, `ip`, `ttype`, `code`, `referer`, `agent`, `size`, `source`, `open`, `close`, `wait`, `trrafic`, `user`, `text`, `version`) VALUES (NULL, '".$name."', current_timestamp(), current_timestamp(), '".$_SERVER['REMOTE_ADDR']."', 'Function', '0', '', '', '0', '', '".clean($Start)."', '".clean($End)."', '".$Wait."', '".Trrafic."', '".$i."', '".$text."', '".app['version']."');";	
global $DB; $Results = mysqli_query($DB, $SQL);
$Output=mysqli_insert_id($DB);
	
}	
}

?>