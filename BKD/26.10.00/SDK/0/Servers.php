<?php





function ServerDownlines($Q=null){
//Developer : A'nilNayak
//Date : 2023/12/08
//Input : UserID
//Output : Downlines

	$Output=[];
	
	if($Q){
		
		$UserByUserID=UserByUserID($Q);
		
		$URL = 'https://api.aeldo.com/?ajax=1&key=sdghcusdfvunebfgetuheugteyfg&userid='.$Q;
		$JSON = file_get_contents($URL);
		
		$Array = json_decode($JSON,true);
		
		$s = $Array['s'];
		$c = $Array['c'];
		$d = $Array['d'];
		$Downlines=$d; 
		
		if($s){
			
			if($d){
		
		$Team=Team($Q);	
		if(!$Team){
			$echo='Team not found in database';
			
			$SQLL="UPDATE `Coinusers` SET `TeamProcessing` = '1' WHERE `Coinusers`.`ID` = '".$UserByUserID['ID']."';";
			global $DB;	$Process = mysqli_query($DB, $SQLL);
			
 			$Output=$d;

	
$SQL="INSERT INTO `Coinpods_team` (`id`, `name`, `created`, `modified`, `userid`, `user`, `members`, `business`, `stake`, `ccc`, `json`) VALUES ('".$UserByUserID['ID']."', '".$UserByUserID['userid']."', current_timestamp(), current_timestamp(), '".$UserByUserID['userid']."', '".$UserByUserID['ID']."', '".$Downlines['total']."', '0', '0', '0', '".json_encode($Downlines)."');";
global $DB;	$results = mysqli_query($DB, $SQL);	
			
			if($results){
				$SQLL="UPDATE `Coinusers` SET `TeamProcessing` = '0' WHERE `Coinusers`.`ID` = '".$UserByUserID['ID']."';";
				global $DB;	$Process = mysqli_query($DB, $SQLL);
			}
		}
		else{
			$echo='Team already found in database';
			
			$SQLL="UPDATE `Coinpods_team` SET `members` = '".$Downlines['total']."', `json` = '".json_encode($Downlines)."' WHERE `Coinpods_team`.`userid` = '".$Q."';";
			global $DB;	$Process = mysqli_query($DB, $SQLL);
			
			$Output = $Downlines;
			
			
			
			//$Output=json_decode($Team['json'],true);
		}
		
		 
		}		
		else{ $echo = $c; }
		
		
		
		
	 
		}
		
		else{ $echo = $c; }
		
		
	 		
		
	}
return $Output;	
}




?>