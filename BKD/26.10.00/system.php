<?php





///////////////////////////////////////////////////////////////////////////////////////////////////////////

function Plural($Array=[],$NewConditions=[],$SQL=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 17-11-2024 [dd-mm-yy]
// Select Data input Data According  
// Output : New system k according bhi work krega and old system k according bhi work krega 
	

$NewArray=$Filter=[];
	
if(!$NewConditions){
$echo = 'input Data Not According New System Proccssing to old system.';	
foreach($Array as $Key => $Value){
$echo = 'Yha par har array ki keys and values ko new AIO plural function k aacording peramiters create kiye ja rhe hai ';
				if(!empty($Key) and !empty($Value)){
					$echo  = 'Key And Value Found.';

	
if($Key == 'SELECT' or $Key == 'HAVING' or $Key == 'GROUP BY' or $Key == 'method' or $Key == 'methodcolumn' or $Key == 'LIMIT' or $Key == 'OFFSET' or $Key == 'sort' or $Key == 'sort_column'){
	$Filter[$Key]=$Value; 
	$echo = 'store Methods and extra filter in filter array';
}
	elseif($Key == 'created_min'){
		$Date = ['created' => ['oprator'=> 'BETWEEN' , 'value1'=>$Value, 'value2'=>'']]; 
		$echo = 'store BETWEEN First value in conditions array';
	}
	elseif($Key == 'created_max'){
		$Date['created']['value2'] =  $Value;
		$echo = 'store BETWEEN Second value in conditions array';
	}
	else{$NewArray[$Key] = ['oprator'=> '=' , 'value1'=>$Value, 'value2'=>''];
		 $echo = 'Store  All Values and keys in Conditions array';
		}
 }
 else{$echo = 'Key And Value Not Found.';}

}
	}
	else{$echo = 'New System According Data Input';}
	
	
	$Filter['table'] = prefix.'users';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}






function SingleUpdate($Array=[],$NewConditions=[],$SQL=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Select Data input Data According  
// INPUT Data   According This ==>
	
	/*
$Conditions = [
 	'uid' => ['oprator'=> '=' , 'value1'=>'11', 'value2'=>''] ,
  	 'user' => ['oprator'=> '=' , 'value1'=>'1', 'value2'=>''],
 //	'amount' => ['oprator'=> 'LIKE' , 'value1'=>'1000']
];
$Data = ['user'=>'1','status'=>'1','balance'=>'1','oca'=>'2222222'];
	*/
	
	
$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';

$Table=prefix.'users';

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
	
		
	
	if($TableName){return RowUpdate($Array, $Conditions,$TableName,$SQL);}else{$echo = 'Table Name Is Required.';}
	//echo $echo;
}



function SingleStatus($UID=NULL,$Status = NULL,$SQL=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Update Status, input Data According  
// INPUT Data   According This ==>
	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	$Table = prefix.'users';
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	echo $echo;	
}

 

function Single($UID=NULL,$SQL=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Update Status, input Data According  
// INPUT Data   According This ==>
	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	$Table = prefix.'users';
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}


function SingleNew($Array=[],$SQL=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Update Status, input Data According  
// INPUT Data   According This ==>
	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	$Table = prefix.'users';
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Rows($Filter = [], $Conditions = [],$SQLData=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-12-2024 [dd-mm-yy]
// Select Data input Data According  
// INPUT Data   According This ==>
	
	
 /*
 $Filter = ['method'=>'', 'methodcolumn'=>'','table'=>'users','LIMIT'=>'','OFFSET'=>'',  'sort'=>'DESC', 'sort_column'=>'ID'];
 $Conditions = [
		'ID' => ['oprator'=> '>' , 'value1'=>'2', 'value2'=>''] ,
	//	'Role' => ['oprator'=> '=' , 'value1'=>'Manager', 'value2'=>''],
	//	 'user_registered' => ['oprator'=> 'BETWEEN' , 'value1'=>'0000-00-00%', 'value2'=>'sssssssssssssssssss']
 ];

// $Filter['SELECT'] = 'user';	 $Filter['method'] = 'count';$Filter['methodcolumn'] = 'amount';	 //✔️
	//$Filter['GROUP BY'] = 'user';
	
	$Filter['HAVING'] = [
		'method' => 'count',
		'methodcolumn' => 'amount',
		'oprator' => '>',
		'value1' => 100,
		'value2' => 0
	];
 */ 
 $S=0;
 //$Table = prefix.$Filter['table']; 
 $Table = $Filter['table']; 
 
	if($Table){
	$echo = 'Database Table Name Found.';
		
		if($Filter['method'] and $Filter['methodcolumn']){
			
			$Method=strtoupper($Filter['method']).'(`'.$Filter['methodcolumn'].'`)';
			$echo = 'Method and Method Column Found Now Setup According Method And Method Column';
		}
		else{$Method = "*"; $echo = 'Without Method and Method Column According Default * Setup Done';}
 
		if($Filter['SELECT']){
			$echo = 'Limited Column Found Now Setup According Limited Column';
			
			$SELECTs = explode(',',$Filter['SELECT']);
			if(is_array($SELECTs)){  
			$echo = 'limited Columns Exploded';
				
			$SELECTs = implode('`,`',$SELECTs); 
			if($SELECTs){
			$echo = ' Limited columns Select';
				
				if($Method != '*' and $Method){$SELECTs = ',`'.$SELECTs.'`';}
				else{$SELECT = '`'.$SELECTs.'`';$Method='';}
			//print_r($LCSelect);
			}
			else{$SELECT = '';$echo = 'No Limited columns Select';}
 			}
			else{$echo = 'limited Columns Not Exploded';}
			
		}
		
		if($Filter['GROUP BY']){
			$echo = 'Limited Column Found Now Setup According Limited Column';
			
			$GroupBys = explode(',',$Filter['GROUP BY']);
			if(is_array($GroupBys)){  
			$echo = 'limited Columns Exploded';
				
			$GroupBys = implode('`,`',$GroupBys); 
			if($GroupBys){
			$echo = ' Limited columns Select';
			$GroupBy = ' GROUP BY `'.$GroupBys.'` ';	
 			 //print_r($GroupBy);
			}
			else{$GroupBy='';$echo = 'No Limited columns Select';}
 			}
			else{$echo = 'limited Columns Not Exploded';}
			
		}
		
		if($Filter['HAVING']){
			$echo = 'Limited Column Found Now Setup According Limited Column';
			
 			if(is_array($Filter['HAVING'])){  
			$echo = 'having array found.';
				
			$Having =  ' HAVING '.strtoupper($Filter['HAVING']['method']).'(`'.$Filter['HAVING']['methodcolumn'].'`) '.$Filter['HAVING']['oprator'].' '.$Filter['HAVING']['value1'].' '; 
				
			if($Filter['HAVING']['value2']){
			$echo = ' Value2 found.';
				
			$Having .= 'AND  '.$Filter['HAVING']['value2'];	
 			//print_r($Having);
			}
			else{$echo = 'Value2 Not Found.';}
 			}
			else{$Having='';$echo = 'Having array Not Found';}
			
		}else{$Having='';$echo = 'Having Input Not Found';}
		
 		
		
		$SQL = "SELECT ".$Method." ".$SELECT." FROM `".$Table."`"; 
		$echo = 'Base SQL Query Setup.';
		
		if(!empty($Conditions) or 1){
			$echo = 'Condintions Found.';
            $WhereClauses = [];
			
			$TotalConditions =  count($Conditions);
			$echo = 'Total Conditions Found.';
			
			$aa=0;
            foreach($Conditions as $index => $column){ 
			$aa++;	
			$echo = ' Foreach Conditions';	 
					
				if($aa>=1 and $TotalConditions-$aa != 0){
					$AND = ' AND ';$echo = 'Not Last Condition [AND] Added';
				}
				else{ $AND=''; $echo = 'Last Condition [AND] Removed'; } 
				

				
				if(strtolower($column['value1']) == 'disable'){
				$Value1 = '0'; 
				$echo = 'Value1 0 setup done';
				}
				elseif($column['value1']){
				$Value1 = $column['value1'];
				$echo = 'Value according input value setup done';
				}
				else{$echo = 'Value1 Not Found';}
				
				
				
				
				if(strtolower($column['value2']) == 'disable'){
				$Value2 = '0';
				$echo = 'Value2 0 setup done';
				}
				elseif($column['value2']){
				$Value2 = "'".$column['value2']."'"; //echo $Value2;
				$echo = 'Value2 according input value2 setup done';
				}
				else{$echo = 'Value2 Not Found'; $Value2 ='';}
				
				
				
				
				if($column['oprator'] == 'BETWEEN' or $column['oprator'] == 'NOT BETWEEN' and $Value2 or strtolower($column['value2']) == 'disable'){
				$Value2 = ' AND '.$Value2;
				$echo = 'According Beetween and Not Beetween Value2 SQL Setup Done.';
				}
				else{$Value2='';$echo = 'Value2 SQL Empty Setup Done.';}
				
				
				
				$Where = '`'.$index.'`'; 
				$echo = 'Column NAme Setup Done ';
				
				$Where .= "   ".$column['oprator']."   "; 
				$echo = 'Opretor Setup Done ';
				
				if($Value1 == 0 or $Value1){$Where .= "'".$Value1."'".$AND.$Value2; 
							$echo = 'Column Value Setup Done ';}
				

				
                $WhereClauses[] = $Where;
            }
			
$echo = 'Extra Data setup Start ';			
if($Filter['LIMIT']){ $LIMIT = $Filter['LIMIT'];}else{$LIMIT = 11;}
if($Filter['OFFSET']){ $OFFSET = $Filter['OFFSET'];}else{$OFFSET = 0;}
if($Filter['sort']){ $SORT = $Filter['sort'];}else{$SORT = "DESC";}
if($Filter['sort_column']){ $SORTColumn = "`".$Filter['sort_column']."`";}else{$SORTColumn = "`id`";}
$echo = 'Extra Data setup Done ';
			
			$echo  = 'Proccesing Setup SQL Query.';
			
			if($aa){$FirstEnd='AND';}else{$FirstEnd='';}
			
			$SQL .= ' WHERE 1=1   '.$FirstEnd . implode(' ', $WhereClauses) . ' '.$GroupBy.' '.$Having.'ORDER BY '. $SORTColumn.' '.$SORT.' LIMIT '.$LIMIT.' OFFSET '.$OFFSET;
			global $DB; 
			$ts = [];
			if($DB){
				$results = mysqli_query($DB, $SQL);
				if($results && mysqli_num_rows($results) > 0) {while ($t = mysqli_fetch_assoc($results)) {$ts[] = $t;}}else{$ts = null;}
			}else{
				$ts = null;
			}
			
			if($Filter['method']){$S=1;
			$Output = $ts[0][$Filter['method'].'(`'.$Filter['methodcolumn'].'`)'];
			}
			elseif($ts){$S=1;
			$Output = $ts;
			}
			else{$echo = 'Results Not Found';}
			
		}
		else{$echo = 'Condition and input data is Required.';}
	}
	else{$echo = 'Database Table name is Required.';}
	    if(!$SQLData){$SQL=false;}
		$ReturnArray = ['c'=>$echo,'t'=>'','s'=>$S,'o'=>$Output,'SQL'=>$SQL];
		return $ReturnArray;
	
}


function RowUpdate($Data=[], $Conditions=[],$Table=null,$SQLData=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Select Data input Data According  
// INPUT Data   According This ==>
	
	
/*  
	
$Conditions = [
 	'uid' => ['oprator'=> '=' , 'value1'=>'11', 'value2'=>''] ,
  	 'user' => ['oprator'=> '=' , 'value1'=>'1', 'value2'=>''],
 //	'amount' => ['oprator'=> 'LIKE' , 'value1'=>'1000']
];
$Data = ['user'=>'1','status'=>'1','balance'=>'1','oca'=>'2222222'];
*/
$S=0;	
//$Table = prefix.$Table;	
$Table = $Table;	


if(!$Data['modified']){ $Data['modified'] = GMT();}	
	
	if($Table){
	$echo = 'This Update Attempt of DB Table : '.$Table;
		
		foreach($Data as $Column => $Value){
			if(!empty($Column) and !empty($Value)){
				$echo = 'Key And Value Found';
			if($Value=='disable'){$V=0;}else{$V=$Value;}
			$SetClauses[] = "`$Column` = '$V'";
			}
			else{$echo = 'Key And Value Not Found';}
		}
		
		
		
		$SQL = "UPDATE `".$Table."` SET " . implode(', ', $SetClauses);	
		$echo = 'Base SQL Query Setup.';
		
		if(!empty($Conditions)){
			$echo = 'Condintions Found.';
            $WhereClauses = [];
			
			$TotalConditions =  count($Conditions);
			$echo = 'Total Conditions Found.';
			
			$aa=0;
            foreach ($Conditions as $index => $column) { 
			$aa++;	
			$echo = ' Foreach Conditions';	 
					
				if($aa>=1 and $TotalConditions-$aa != 0){
					$AND = ' AND ';$echo = 'Condition [AND] Added';
				}
				else{$AND=''; $echo = 'Last Condition [AND] Removed';}
				

				
				if(strtolower($column['value1']) == 'disable'){
				$Value1 = '0'; 
				$echo = 'Value1 0 setup done';
				}
				elseif($column['value1']){
				$Value1 = $column['value1'];
				$echo = 'Value according input value setup done';
				}
				else{$echo = 'Value1 Not Found';}
				
				
				
				
				if(strtolower($column['value2']) == 'disable'){
				$Value2 = '0';
				$echo = 'Value2 0 setup done';
				}
				elseif($column['value2']){
				$Value2 = "'".$column['value2']."'"; //echo $Value2;
				$echo = 'Value2 according input value2 setup done';
				}
				else{$echo = 'Value2 Not Found'; $Value2 ='';}
				
				
				
				
				if($column['oprator'] == 'BETWEEN' or $column['oprator'] == 'NOT BETWEEN' and $Value2 or strtolower($column['value2']) == 'disable'){
				$Value2 = ' AND '.$Value2;
				$echo = 'According Beetween and Not Beetween Value2 SQL Setup Done.';
				}
				else{$Value2='';$echo = 'Value2 SQL Empty Setup Done.';}
				
				
				
				$Where = '`'.$index.'`'; 
				$echo = 'Column NAme Setup Done ';
				
				$Where .= "   ".$column['oprator']."   "; 
				$echo = 'Opretor Setup Done ';
				
				if($Value1){$Where .= "'".$Value1."'".$AND.$Value2; 
							$echo = 'Column Value Setup Done ';}
				
				$WhereClauses[] = $Where;
            }
			
			$echo  = 'Proccesing Setup SQL Query.';
			
			$SQL .= ' WHERE ' . implode(' ', $WhereClauses);
			global $DB; $results = mysqli_query($DB, $SQL); $ts = [];
			
			if($results){$S=1; $Output=true;$echo = 'Update Success.';}
			else{$Output = false; $echo = 'Update Faild.';}
			
		}
		else{$echo = 'What Why Reason You will Attapt Update Data without Database table';}
	}
	else{$echo = 'Table Name Is Required.';}
	        
	        if(!$SQLData){$SQL=false;}
			$ReturnArray = ['c'=>$echo,'t'=>'','s'=>$S,'o'=>$Output,'SQL'=>$SQL];
			return $ReturnArray;
	
}


 





function RowStatus($UID=NULL,$Status = NULL,$Table = NULL,$SQLData=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Select Data input Data According  
// INPUT Data   According This ==>
$S=0;
//$Table = prefix.$Table;
$Table = $Table;
	if($Table){
	$echo = 'Database Table Name Found.';
	if($Status){
	$echo = 'Status Found.';
	if($UID){
	$echo = 'UID Found.';
		
if(strtolower($Status) == 'disable'){$SV= "`status`= '0'";}
else{if(is_numeric($Status)){ $SV= "`status`= '".$Status."'";}else{$SV='';} }		
		
		
		$SQL = "UPDATE `".$Table."` SET ".$SV." WHERE `uid` =  '".$UID."'";
		global $DB; $results = mysqli_query($DB, $SQL);
		
		if($results){$S=1;$Output = true;$echo = 'Update Success';}
		else{$Output=false;$echo = 'Update Faild';}
		if(!$SQLData){$SQL=false;}
		$ReturnArray = ['c'=>$echo,'t'=>$Table,'s'=>$S,'o'=>$Output,'SQL'=>$SQL];
	}
	else{$echo = 'UID is Required.';}
	}
	else{$echo = 'Status is Required.';}
	}
	else{$echo = 'Database Table name is Required.';}
	return $ReturnArray;
}




function Row($UID=NULL,$Table = NULL,$SQLData=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]
// Select Data input Data According  
// INPUT Data   According This ==>
$S=0;
//$Table = prefix.$Table;
$Table = $Table;
	if($Table){
	$echo = 'Database Table Name Found.';
		
		$SQL = "SELECT * FROM `".$Table."` WHERE `uid` =  '".$UID."'";
		global $DB; 
		$ts = [];
		if($DB){
			$results = mysqli_query($DB, $SQL);
			if($results && mysqli_num_rows($results) > 0) {while ($t = mysqli_fetch_assoc($results)) {$ts[] = $t;}}else{$ts = null;}
		}else{
			$ts = null;
		}
		
		if($ts){$S=1;$Output = $ts[0];$echo = 'Results Found';}
		else{$Output=false;$echo = 'Results Not Found';}
		if(!$SQLData){$SQL=false;}
		$ReturnArray = ['c'=>$echo,'t'=>'','s'=>$S,'o'=>$Output,'SQL'=>$SQL];
	}
	else{$echo = 'Database Table name is Required.';}
	return $ReturnArray;
}





function RowNew($Data=[], $Table=null,$SQLData=false){
// Developer : JAspal Byavat
// Work : In Progress
// Date : 12-11-2024 [dd-mm-yy]

	
// INPUT Data  1. According This ==> $Data = ['user'=>'1','status'=>'1','balance'=>'1','oca'=>'2222222']; 
#	           2. table Name is Required Like Coinpods_transaction
	
$S=0; 	
//if(!$Data['created']){ $Data['created'] = GMT();$Data['modified'] = GMT();}
	
//$Table = prefix.$Table;	
$Table = $Table;	
	
	if($Table){
	$echo = 'This Update Attempt of DB Table : '.$Table;
		
		$echo = 'This Is New Row Insert Attempt.';
		
		$ColumnsList = implode('`,`',array_keys($Data));
		$ValuesList = implode("','",array_values($Data));
		
		$echo = 'Create SQL Query.';
		$SQL = "INSERT INTO `".$Table."` (`".$ColumnsList."`) VALUES ('".$ValuesList."');";
		global $DB; $results = mysqli_query($DB, $SQL);
		if($results){
		$S=1;
		$Output = mysqli_insert_id($DB);
		$echo = 'Row Inserted.';
			if(!$Data['uid']){
			$UIDSQL="UPDATE `".$Table."` SET `uid` = `id` WHERE `uid` IS NULL ";
			global $DB;$Output = mysqli_query($DB, $UIDSQL);
			}
		}
		else{$Output = false; $echo = 'Row Not Insert.';}
		if(!$SQLData){$SQL=false;}
		$ReturnArray = ['c'=>$echo,'t'=>'','s'=>$S,'o'=>$Output,'SQL'=>$SQL];
		return $ReturnArray;
	}
	else{$echo = 'What Why Reason You will Attapt Update Data without Database table';}
}


























?>