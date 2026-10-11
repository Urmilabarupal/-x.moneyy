<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////

function Spot_Wallets($Array=[],$NewConditions=[],$SQL=false){
// Developer : Aditya Nayak
// Work : In Progress
// Date : 07-10-2026 [dd-mm-yy]
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
	
	
	$Filter['table'] = prefix.'spot_wallet';
	 
	if(isset($Date) && $Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}






function Spot_WalletUpdate($Array=[],$NewConditions=[],$SQL=false){
// Developer : Aditya Nayak
// Work : In Progress
// Date : 07-10-2026 [dd-mm-yy]
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

$Table=prefix.'spot_wallet';

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



function Spot_WalletStatus($UID=NULL,$Status = NULL,$SQL=false){
// Developer : Aditya Nayak
// Work : In Progress
// Date : 07-10-2026 [dd-mm-yy]
// Update Status, input Data According  
// INPUT Data   According This ==>
	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	$Table = prefix.'spot_wallet';
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	echo $echo;	
}

 

function Spot_Wallet($UID=NULL,$SQL=false){
// Developer : Aditya Nayak
// Work : In Progress
// Date : 07-10-2026 [dd-mm-yy]
// Update Status, input Data According  
// INPUT Data   According This ==>
	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	$Table = prefix.'spot_wallet';
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}


function Spot_WalletNew($Array=[],$SQL=false){
// Developer : Aditya Nayak
// Work : In Progress
// Date : 07-10-2026 [dd-mm-yy]
// Update Status, input Data According  
// INPUT Data   According This ==>
	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	$Table = prefix.'spot_wallet';
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}
?>
