<?php


function APICall($Q=null){
if($Q){
if(iam['admin']){ 
 
$url = 'https://api.servetel.in/v1/call/records?limit=1&call_id='.$Q;
$myvars = '';

$ch = curl_init( $url );
//curl_setopt( $ch, CURLOPT_POST, 0);
//curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, false);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
    'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjg3MDA4LCJpc3MiOiJodHRwczpcL1wvY3VzdG9tZXIuc2VydmV0ZWwuaW5cL3Rva2VuXC9nZW5lcmF0ZSIsImlhdCI6MTY1MTQ5MTk1NSwiZXhwIjoxOTUxNDkxOTU1LCJuYmYiOjE2NTE0OTE5NTUsImp0aSI6IldFY05DdTh0VDFtdGlQSkgifQ.BtOMrrxr_YzMHU6x9m6OUFgn2_cWu9rqH6BUB6H99cs'
));
$response = curl_exec( $ch );
		 
$response = json_decode($response, TRUE);
return $response['results'][0];
	
}	
}	
}



function APILiveCall($Q=null){
if($Q){
if(iam['admin']){ 
 
$url = 'https://api.servetel.in/v1/live_calls?call_id='.$Q;
$myvars = '';

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 0);
//curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, false);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
    'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjg3MDA4LCJpc3MiOiJodHRwczpcL1wvY3VzdG9tZXIuc2VydmV0ZWwuaW5cL3Rva2VuXC9nZW5lcmF0ZSIsImlhdCI6MTY1MTQ5MTk1NSwiZXhwIjoxOTUxNDkxOTU1LCJuYmYiOjE2NTE0OTE5NTUsImp0aSI6IldFY05DdTh0VDFtdGlQSkgifQ.BtOMrrxr_YzMHU6x9m6OUFgn2_cWu9rqH6BUB6H99cs'
));
$response = curl_exec( $ch );
		 
$response = json_decode($response, TRUE); return $response[0];	
}	
}	
}










function CallsPendingCounts($Q=null){
// OUTPUT : ALL transactions's data from DB by status($Q)
if(i['id']){
global $DB;$aa = 0;
		if(i['am']=='Lawyer'){ $SQL = "SELECT COUNT(id) FROM `Coinpods_call` WHERE `lawyer` = '".i['id']."' AND `status` = '1'"; }
		else{$SQL = "SELECT COUNT(id) FROM `Coinpods_call` WHERE `status` = '1'";}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){return $ts[0]['COUNT(id)'];}
}
else{return false;}
} 

 
function CallsSuccessCounts($Q=null){
// OUTPUT : ALL transactions's data from DB by status($Q)
if(i['id']){
global $DB;$aa = 0;
		if(i['am']=='Lawyer'){ $SQL = "SELECT COUNT(id) FROM `Coinpods_call` WHERE `lawyer` = '".i['id']."' AND `status` = '4'"; }
		else{$SQL = "SELECT COUNT(id) FROM `Coinpods_call` WHERE `status` = '4'";}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){return $ts[0]['COUNT(id)'];}
}
else{return false;}
} 

function CallsFailedCounts($Q=null){
// OUTPUT : ALL transactions's data from DB by status($Q)
if(i['id']){
global $DB;$aa = 0;
		if(i['am']=='Lawyer'){ $SQL = "SELECT COUNT(id) FROM `Coinpods_call` WHERE `lawyer` = '".i['id']."' AND `status` = '3'"; }
		else{$SQL = "SELECT COUNT(id) FROM `Coinpods_call` WHERE `status` = '3'";}
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){return $ts[0]['COUNT(id)'];}
}
else{return false;}
} 


?>