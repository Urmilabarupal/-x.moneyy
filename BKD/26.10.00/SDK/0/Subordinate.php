<?php

  
$PHP['Subordinate']['modified'] = '2024/07/10';
$PHP['Subordinate']['by'] = 'Jaspal Byavat';

$PHP['Subordinate']['function'][1] = 'SubordinatesSort($Q=null)';
$PHP['Subordinate']['function'][2] = 'PendingSubordinate($Q=null)';
$PHP['Subordinate']['function'][3] = 'SubordinateNews($Q=null)';
$PHP['Subordinate']['function'][4] = 'CreateSubordinate($Q=null)';
$PHP['Subordinate']['function'][5] = 'Subordinate1($Q=null)'; 
$PHP['Subordinate']['function'][6] = 'Subordinate2($Q=null)'; 
$PHP['Subordinate']['function'][7] = 'SubordinateNew($Q=null)'; 
$PHP['Subordinate']['function'][8] = 'Subordinate($Q=null)'; 
$PHP['Subordinate']['function'][9] = 'Subordinates($Q=null)'; 
$PHP['Subordinate']['function'][10] = 'SubordinateUpdate($Q=null)'; 
$PHP['Subordinate']['function'][11] = 'SubordinateStatus($Q=null)'; 
 







function SubordinatesSort($Date=null, $Level=null ){
 	

if($Date){
	if($Level){ $Subordinates = Subordinates( array( 'user'=>i['id'], 'level'=>$Level, 'LIMIT'=>119829011412) ); }
	else{ $Subordinates = Subordinates( array( 'user'=>i['id'], 'maxlevel'=>6, 'LIMIT'=>119829011412) ); }
	
	
$SBS=[];


if($Subordinates){
	foreach($Subordinates as $SB){
		$Histories = Histories( array( 'user'=>$SB['subordinate'], 'date'=>$Date) );
		$Bet=0;
		foreach($Histories as $History){ 
			$SB[strtolower($History['ttype'])]=$History['value'];
			if($History['ttype'] == 'Bet'){ $Bet=$History['value']; }
		}
		$SB = ['bet' => $Bet] + $SB;		
		$SBS[]=$SB;
	}	
}
arsort($SBS);	
	
return $SBS;	
}	
}




/////////////////////////////////////////////////////////
///////////////////////////////////////////////






function PendingSubordinate($Q=null){
// Developer : Sahiram Nayak
// Date : 2024.06.30
// Input : null
// Output : jis user ka Subordinate 0 hai us select karta hai .
	
	//$SQL="SELECT * FROM `Coinusers` WHERE `Subordinate` = 0 ORDER BY `Coinusers`.`ID` ASC";
	$SQL="SELECT * FROM `Coinusers` WHERE `Subordinate` = 0 ORDER BY `Coinusers`.`ID` ASC LIMIT 400;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts; 
}



function SubordinateNews($Q=null){
// Developer: Sahiram Nayak
// Date : 2420.06.30
// Input: null
// Output:  Array se data send karta hai
	
	$PS=PendingSubordinate();
	$echo ="Pending Subordinate found.";
	if($PS){
	$echo ="Pending Subordinate Users found.";	
		foreach($PS as $P){
			if($P){ 
				$echo ="Pending Subordinate User found.";
				if($P){ CreateSubordinate(['ID'=>$P['ID'],'userid'=>$P['userid'],]); }
				else{ $echo = "Created Subordinate not found."; }
			}
			else{ $echo ="Pending Subordinate User not found."; }
		}
	}
	else{ $echo ="Pending Subordinate Users not found."; }
}





function CreateSubordinate($Q=null){
// Developer: Sahiram Nayak
// Date : 2024.06.30
// Input: Array
// Output: Insert karta hai 
	
	if(is_array($Q)){ $User=$Q['ID'];  $UserID=$Q['userid']; }
	
	$ThisUser = User($User); 
	
	if($User && $UserID){
		$echo ="User and UserID found.";
		$Uplines=Uplines($UserID);
		if($Uplines){
			$echo ="Uplines users found.";
			$ab=0;
			foreach($Uplines as $Upline){ 
				$ab++;
				if($ab<=10000){
					$echo = "10 Level found.";
					if($Upline){
					$echo ="Upline user found.";
						$UserByUserID=UserByUserID($Upline);
						
						if($ThisUser['left']==1){ $Position = 'L'; }
						elseif($ThisUser['right']==1){ $Position = 'R'; }
						
						 
						//print_r('<br><br>L'.$UserByUserID['left'].'<br><br>R'.$UserByUserID['right']);
						if($UserByUserID){
							$echo ="User By UserID found.";
							$Array = [
								'name'=>$ThisUser['fname'].' '.$ThisUser['lname'],
								'user'=>$UserByUserID['ID'],
								'userid'=>$UserByUserID['userid'],
								'UserUpline'=>$UserByUserID['ID'].':'.$User,
								'subordinate'=>$ThisUser['ID'],
								'position'=>$Position,
								'level'=>$ab,
							];
							if($Array){ 
								$echo = "Array found.";
								 if($Array){ SubordinateNew($Array); Subordinate1($User); }
								else{ $echo = "Insert not found."; } 
							}
							else{ $echo = "Array not found."; }
						}
						else{ $echo ="User By UserID not found."; }
					}
					else{ $echo ="Upline user not found.";  }
				}
				else{ $echo ="10 Level Se Out hai."; }
				 ///echo $echo.':'.$ThisUser['ID'].':Referby:'.$Upline.'<br>';
			}
		}
		else{ $echo ="Uplines users not found."; /*Subordinate2($User);*/ }
	}
	else{ $echo ="User and UserID not found."; /*Subordinate2($User);*/ }
	 
}
 

function Subordinate1($Q=null){
// Developer: Sahiram Nayak
// Date : 2024.06.30
// Input: ID
// Output: Update  Subordinate == 1
	
	if($Q){
		$echo="Q found.";
		
		$SQL= "UPDATE `Coinusers` SET `Subordinate` = '1' WHERE `Coinusers`.`ID` = '".$Q."';";
		global $DB;$aa = 0;$Results = mysqli_query($DB, $SQL);
	}
	else{ $echo="Q not found."; }
	return $Results;
}

function Subordinate2($Q=null){
// Developer: Sahiram Nayak
// Date : 2024.06.30
// Input: ID
// Output: Update Subordinate == 2
	
	if($Q){
		$echo="Q found.";
		
		$SQL= "UPDATE `Coinusers` SET `Subordinate` = '2' WHERE `Coinusers`.`ID` = '".$Q."';";
		global $DB;$aa = 0;$Results = mysqli_query($DB, $SQL);
	}
	else{ $echo="Q not found."; }
	return $Results;
}

function SubordinateNew($Q=null){
// Developer: Sahiram Nayak
// Date : 2024.06.30
// Input: Array
// Output: insert hota hai 

	
    if(is_array($Q)){
		$echo = 'Q Array Data Found';
		$Name=$Q['name']; $User=$Q['user']; $UserID=$Q['userid']; $UserUpline=$Q['UserUpline'];
		$Subordinate=$Q['subordinate']; $Level=$Q['level']; $Position=$Q['position'];  
	}
	if($User && $UserUpline && $UserID && $Subordinate && $Level){
		$echo = 'All Data Found';
		
$SQL="INSERT INTO `".prefix."pods_subordinate`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `privacy`, `app`, `userid`, `subordinate`, `level`, `position`) VALUES (NULL,'".$Name."', current_timestamp(), current_timestamp(),'".$UserUpline."','".$User."','1','Public','1','".$UserID."','".$Subordinate."','".$Level."','".$Position."')";
		global $DB; $results = mysqli_query($DB, $SQL);
		
		 
	}
		else { $echo = 'All Data Not Found.'; }
 
	  //echo $echo;
	return $results;
}
 



function Subordinate($Q=null){ 
// Developer : Sahiram Nayak
// Date : 2024.06.30
// Input : Id 
// Output :jo id aati hai oska data select karta hai .
	if($Q){
		$echo = 'uid Found'; 
		
		$SQL="SELECT * FROM `".prefix."pods_subordinate` WHERE `uid`='".$Q."' ORDER BY `".prefix."pods_subordinate`.`uid` DESC"; 
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		return $ts[0]; 
	}
	else{ $echo ='UID Not Found.'; }
}


function Subordinates($Q=null){
//Developer : Sahiram Nayak	
// Date : 2024.06.30
//Input : Array
//Output : Jo array Me Aata hai US ko Select katta hai .
// Chenges : CreatedMax, CreatedMin and Method Column , Method Add kiya hai.
	
 	
	 if(is_array($Q)){
		$echo = 'Q Array Data Found.';
		$Activate=$Q['activate']; $GroupBy = strtolower($Q['groupby']);  
		
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
        $Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
        $Created=isset($Q['created'])?" AND `created` LIKE '%".strtolower($Q['created'])."%'" : '';
        $Modified=isset($Q['modified'])?" AND `modified` LIKE '%".strtolower($Q['modified'])."%'" : '';
		$UID=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Status=isset($Q['status'])?" AND `status` = '".$Q['status']."'" : '';
        $Privacy=isset($Q['privacy'])?" AND `privacy` LIKE '%".strtolower($Q['privacy'])."%'" : '';
 	    $App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : ''; 
 	    $UserID=isset($Q['userid'])?" AND `userid` = '".$Q['userid']."'" : ''; 
 	    $Position=isset($Q['position'])?" AND `position` = '".$Q['position']."'" : ''; 
        $Subordinate=isset($Q['subordinate'])?" AND `subordinate` LIKE '".$Q['subordinate']."'" : '';
        $Upline=isset($Q['upline'])?" AND `subordinate` LIKE '".$Q['upline']."'" : '';
        $Downline=isset($Q['downline'])?" AND `downline` LIKE '".$Q['downline']."'" : '';
        $Downlines=isset($Q['downlines'])?" AND `downlines` LIKE '".$Q['downlines']."'" : '';
        $Dwdsd1=isset($Q['dwdsd1'])?" AND `dwdsd1` LIKE '".$Q['dwdsd1']."'" : '';
        $Deposit=isset($Q['deposit'])?" AND `deposit` LIKE '".$Q['deposit']."'" : '';
 	    $Maxlevel = $Q['maxlevel'];  
		$Minlevel = $Q['minlevel']; 
		$MinDeposit = $Q['mindeposit']; 
		$Level = $Q['level'];  $Downline=$Q['downline'];  $Downlines=$Q['downlines'];  
		
		if($MinDeposit){ $MinDeposit=isset($MinDeposit)?" AND `deposit` >= '".$MinDeposit."'" : ''; }
		
		if($Minlevel){ $Minlevel=isset($Minlevel)?" AND `level` >= '".$Minlevel."'" : ''; }
		if($Maxlevel){ $Maxlevel=isset($Maxlevel)?" AND `level` <= '".$Maxlevel."'" : ''; }
		if($Level){ $Level=isset($Level)?" AND `level` = '".$Level."'" : ''; }
		
		if($Activate== 'ISNOTNULL'){
			$Activatee = " AND `activate` IS NOT NULL";
		}
		else{
			if($Activate){
				$Activatee = " AND `activate` LIKE '".$Activate."'";
			}
		}
	
		if($Downline){ $Downline = " AND `downline` = '".$Downline."'"; }
		if($Downlines){ $Downlines = " AND `downlines` = '".$Downlines."'"; } 
		 
		
		$CreatedMax = $Q['createdmax'];
		$CreatedMin = $Q['createdmin'];
		
		if($CreatedMin){ $CreatedMin=isset($CreatedMin)?" AND `created` >= '".$CreatedMin."'" : ''; }
		if($CreatedMax){ $CreatedMax=isset($CreatedMax)?" AND `created` <= '".$CreatedMax."'" : ''; }
	
	}
	else{ $User = $Q; } 
	
	
	if($GroupBy){ $GroupByvalue =   " GROUP BY `".$GroupBy."` "; }else{$GroupByvalue = '';}
 
	$WHERE=$ID.$Name.$Created.$Modified.$UID.$User.$Status.$Privacy.$App.$UserID.$Position.$Subordinate.$Downline.$Downlines.$Dwdsd1.$Activatee.$Deposit.$Minlevel.$Maxlevel.$MinDeposit.$Level.$Upline.$CreatedMax.$CreatedMin; 
	
	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 11; }
 	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0; 
	
	
	
	if($Q['sort'] == 'id'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'name'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'modified'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'modified'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'uid'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'user'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'status'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'privacy'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'app'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'userid'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'subordinate'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'level'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'deposit'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'downline'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'downlines'){$Sort = $Q['sort'];}
 	else{$Sort = 'id';}
	$echo = 'Sort Data Found.';
	
	if($Q['ASC'] == 'ASC'){$ASC = 'ASC';}else{$ASC = 'DESC';}
    $echo = 'ASC Or DESC  Data Found.';
	
	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }
	
	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;
	
	

	
	$SQL = "SELECT ".$MM." FROM `".prefix."pods_subordinate` WHERE `id` != 0 ".$WHERE." ".$GroupByvalue." ORDER BY `".$Sort."` ".$ASC." LIMIT ".$Limit." OFFSET ".$Offset;    //echo $SQL; echo '<br><br>';
     global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	 if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 
	if($MC){ $return=$ts[0][$Method.''.$MC]; }else{ $return=$ts;}
	
	return $return; 
 
}


// Function  Ye OLD hai 
/*
function Subordinates($Q=null){
//Developer : Sahiram Nayak	
// Date : 2420.06.30
//Input : Array
//Output : Jo array Me Aata hai US ko Select katta hai .
	
	if(is_array($Q)){
		$echo = 'Q Array Data Found.';
		
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
        $Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
        $Created=isset($Q['created'])?" AND `created` LIKE '%".strtolower($Q['created'])."%'" : '';
        $Modified=isset($Q['modified'])?" AND `modified` LIKE '%".strtolower($Q['modified'])."%'" : '';
		$UID=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Status=isset($Q['status'])?" AND `status` = '".$Q['status']."'" : '';
        $Privacy=isset($Q['privacy'])?" AND `privacy` LIKE '%".strtolower($Q['privacy'])."%'" : '';
 	    $App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : ''; 
 	    $UserID=isset($Q['userid'])?" AND `userid` = '".$Q['userid']."'" : ''; 
        $Subordinate=isset($Q['subordinate'])?" AND `subordinate` LIKE '%".strtolower($Q['subordinate'])."%'" : '';
 	    $Maxlevel = $Q['maxlevel'];  
		$Minlevel = $Q['minlevel']; 
		$Level = $Q['level']; 
		
		if($Minlevel){ $Minlevel=isset($Minlevel)?" AND `level` >= '".$Minlevel."'" : ''; }
		if($Maxlevel){ $Maxlevel=isset($Maxlevel)?" AND `level` <= '".$Maxlevel."'" : ''; }
		if($Level){ $Level=isset($Level)?" AND `level` = '".$Level."'" : ''; }
		
		
 

	}
	else{ $User = $Q; } 
	
 
	$WHERE="1".$ID.$Name.$Created.$Modified.$UID.$User.$Status.$Privacy.$App.$UserID.$Subordinate.$Minlevel.$Maxlevel.$Level; 
	
	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 11; }
 	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0; 
	
	if($Q['sort'] == 'id'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'name'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'modified'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'modified'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'uid'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'user'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'status'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'privacy'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'app'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'userid'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'subordinate'){$Sort = $Q['sort'];}
	elseif($Q['sort'] == 'level'){$Sort = $Q['sort'];}
 	else{$Sort = 'id';}
	$echo = 'Sort Data Found.';
	
	if($Q['ASC'] == 'ASC'){$ASC = 'ASC';}else{$ASC = 'DESC';}
    $echo = 'ASC Or DESC  Data Found.';
	

	
	$SQL = "SELECT * FROM `".prefix."pods_subordinate` WHERE ".$WHERE." ORDER BY `".$Sort."` ".$ASC." LIMIT ".$Limit." OFFSET ".$Offset;   
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	 if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 
	return $ts;   
}
 */
  
function SubordinateUpdate($Q=null){
// Developer : Sahiram Nayak
// Date : 2024.06.30
// Input : Array  
// Output :array me jo id aata hai os data ko update  karta hai 
$Output=0;	
	
	
	
	global $DB;
	if(is_array($Q)){ 
		$echo = 'Q Array Data Found.';
		$Name=$Q['name']; $User=$Q['user']; $Status=$Q['status']; $Privacy=$Q['privacy'];
		$App=$Q['app']; $UserID=$Q['userid']; $UID=$Q['uid']; $Subordinate=$Q['subordinate']; 
		$Level=$Q['level']; $Position=$Q['position'];  $Downline=$Q['downline'];  $Downlines=$Q['downlines'];  
	}
	
	
	if($UID){
		$echo = 'UID Data Found.';
		
		$Modified=" SET `modified` = current_timestamp()";
		if($Name){$Name=", `name` = '".$Name."'";}
		if($User){$User=", `user` = '".$User."'";}
		if($Status){$Status=", `status` = '".$Status."'";}
		if($Privacy){$Privacy=", `privacy` = '".$Privacy."'";}
		if($App){$App=", `app` = '".$App."'";}
		if($UserID){$UserID=", `userid` = '".$UserID."'";}
		if($Subordinate){$Subordinate=", `subordinate` = '".$Subordinate."'";}
		if($Level){$Level=", `level` = '".$Level."'";}
		if($Position){$Position=", `position` = '".$Position."'";}
		if($Downline){$Downline=", `downline` = '".$Downline."'";}
		if($Downlines){$Downlines=", `downlines` = '".$Downlines."'";}
		  
		$SET=$Modified.$Name.$User.$Status.$Privacy.$App.$UserID.$Subordinate.$Level.$Position.$Downline.$Downlines;
		
		$SQL="UPDATE `".prefix."pods_subordinate` ".$SET." WHERE `".prefix."pods_subordinate`.`uid`=".$UID;
		$Result = mysqli_query($DB, $SQL); 
		if($Result){$Output = true; $echo ='Update Success.';}else{$Output = false; $echo =' Not Update.';} 
	}
	else{ $echo ='UID Or User Not Found.';}
	 // echo $echo;
	 
	return $Output; 
}




 
function SubordinateStatus($UID=null,$Status=null){
// Developer : Sahiram Nayak
// Date : 2024.06.30
// Input : Id and Enable ye Diable  
// Output :jo enable aata hai to status 1 karta hai or nhi disable aata hai to 0 karta hai
	
	
	$Output = 0;
	if($UID and $Status){ 
		$echo ='UID Or Status Found.';
		if(Subordinate($UID)){
		$echo ='Activity UID Found.';
		
		if($Status >= 1 and $Status <=9){
		$echo ='Status found.';
			
		$SQL= "UPDATE `".prefix."pods_subordinate` SET `status`='".$Status."', `modified` = current_timestamp() WHERE `uid`='".$UID."';";
		global $DB;$aa = 0;$Results = mysqli_query($DB, $SQL);
			
		if($Results){$Output =  true;  $echo ='Update Success.';}else{ $Output =  false; $echo ='Update Failed.';}
		
		}
		else{ $echo ='Status not found.'; }
		}
		else{$echo = 'This UID Subordinate Not Found.';}
	}
	else{$echo = 'Please Enter UID and Status .';}
	//echo $echo;
	return $Output;
}





?>