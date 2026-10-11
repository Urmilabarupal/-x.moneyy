<?php //v.23.01.05
$username=$_SESSION['username'];
define('username',$username);
 
global $d;
function d_DELETED($l=null){ global $d; if($l){$d=$d.'<l>'.$l.'</l>';} return $d; }

function Percent_DELETED($Amount=null,$Percent=null){
if($Amount and $Percent){
	$Amount=$Amount*$Percent/100;
	return $Amount;	
}
}



function URL_DELETED($U=null){
	if(!$U){ $U=$_SERVER['REQUEST_URI']; }
	$Full=$U;
	
	if(strpos($U,'https://') !== false){ $U=str_replace('https://','',$U);}
	if(strpos($U,'http://') !== false){ $U=str_replace('http://','',$U);}	
	if(strpos($U,'?') !== false){$U=explode('?',$U);$U=$U[0];}
	
	$URL=explode('/',$U);$URL['full']=$Full;	
	return $URL;
}
global $URL; $URL=URL(); define('URL',$URL);



function TimeNow_DELETED(){   $now = DateTime::createFromFormat('U.u', microtime(true)); $Time = $now->format("Y-m-d H:i:s.u"); return $Time;  }

function No_DELETED($Q=null){ echo '<no><img class="No" src="/0/No'.$Q.'.png"> <t><h4>No '.$Q.'</h4></t></no>'; }
function IST_DELETED(){ return time_plus_minutes(array( 'time'=>GMT(), 'minutes'=>330 )); }
function GMT_DELETED(){ return gmdate("Y-m-d H:i:s");}
function Today_DELETED(){$datetime = DateTime::createFromFormat('YmdHi', gmdate("YmdHi"));  return $datetime->format('D');}
function Holiday_DELETED(){$T=Today();if($T=='Sun' or $T=='Sat'){return 1;}else{return 0;}}
function Age_DELETED($t=null){
	
	$ageS = diff_in_seconds(array( 'start' => $t, 'end' => GMT() ));

    $age = $ageS/minute; $AF=' minutes';
    if($ageS>hour){ $age=$ageS/hour; $AF=' hours';}
    if($ageS>day){ $age=$ageS/day; $AF=' days';}
    if($ageS>month){ $age=$ageS/month; $AF=' months'; }
		
	return number_format($age,0).$AF;
}

function n_DELETED($Q){return str_replace(',','',$Q);} 
function svg_DELETED($Q=null){global $S;if($Q){ $svg = app['dir'].'/0/'.$Q.'.svg';}	else{$svg = app['dir'].'/0/0.svg';} require $svg;}
function uvg_DELETED($Q=null){ echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><use href="#SVG'.$Q.'"></use></svg>'; }
function rvg_DELETED($Q=null){ global $S;if($Q){ $svg = app['dir'].'/0/'.$Q.'.svg';}	else{$svg = app['dir'].'/0/0.svg';}
ob_start(); require $svg; $svg = ob_get_clean(); return $svg; }
function id2di_DELETED($Q){ return 'OT'.$Q; }
function di2id_DELETED($Q){ return str_replace(s['Brand'],"",$Q); }
function soon_DELETED(){ echo ''; }

function random_DELETED($length=10){
// OUTPUT : Random string
// INPUT : string length
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}




function NS_DELETED($number, $precision = 2, $divisors = null) {
// OUTPUT : Number system 'K,M,B'
// INPUT : Number
    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );    
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}


function ref_DELETED($ref=null){
	
if(!$ref){$ref=$_REQUEST["ref"];}
	
if(strpos($ref,'OT') !== false){ $ref=di2id($ref); }
else{$ref=0;}

if($ref>=541400){ 
	$user=user($ref);	
	if($user){return true;}else{return false;}	
}
}


function c2s_DELETED($c){ // capital to small
if($c=='TRX'){$c='trx';}
elseif($c=='ETH'){$c='eth';}
elseif($c=='BTC'){$c='btc';}	
return $c;	
}
 
function p2d_DELETED($Q=null){ if($Q){return $Q*1000000000;} }
function d2p_DELETED($Q=null){ if($Q){return $Q/1000000000;} }

 
function diff_in_seconds_DELETED($Q=null){
// OUTPUT : diffrance between two date_time in seconds 
// INPUT : start(date_time)  end(date_time)
if(is_array($Q)){$start = $Q['start'];$end = $Q['end'];}
if($start and $end){	
$start_date = new DateTime($start);
$DF = $start_date->diff(new DateTime($end));
			
// $DF->days.' days total<br>';
$years = $DF->y*year;
$months = $DF->m*month;
$days = $DF->d*day;
$hours = $DF->h*hour;
$minutes = $DF->i*minute;
$seconds = $DF->s*second;

$DF = $years+$months+$days+$hours+$minutes+$seconds; 
}
return $DF;
}






function TimeMinusDays_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['days'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' - '.$Days.' days'));}

}



function TimeMinusHours_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['hours'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' - '.$Days.' hours'));}

}


function TimePlusHours_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['hours'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' + '.$Days.' hours'));}

}


function TimePlusMinutes_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['minutes'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' + '.$Days.' minutes'));}

}



function TimeToSeconds_DELETED($Q){
$Output=0;
if($Q){	$Q=explode(':',$Q);	$Hours=$Q[0]*hour;	$Minutes=$Q[1]*minute;	$Seconds=$Q[2];	$Output=$Hours+$Minutes+$Seconds;}	return $Output;
}

function time_plus_days_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['days'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' + '.$Days.' days'));}

}

function time_plus_hours_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['hours'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' + '.$Days.' days'));}

}


function time_plus_minutes_DELETED($Q=null){

if(is_array($Q)){$Time = $Q['time'];$Days = $Q['minutes'];}
if($Time and $Days){return date('Y-m-d H:i:s', strtotime($Time. ' + '.$Days.' minutes'));}

}

function GMTToIST_DELETED($Q=null){ if($Q){ return TimePlusMinutes(array( 'minutes'=>'330', 'time'=>$Q )); } }


 
function AI_DELETED($T=null,$Human=null,$IN=null){
// AI == Artificial Intelligence
// $T=Type['invest'], $W=Wallet Address	, $IN = Invest[]
if($IN['c']=='trx'){	
global $DB;$s=0;$W=$Human['trx'];$cyrpto='';
if($T=='Invest'){
if($IN){
// Detecting : Has the Human['user'] really paid.
//# AI['invest']
// : means done
	
//:1* trx['invest'] should be null 
//:2* trx['from'] AND "trx wallet address of invest user " should be equal 
//:3* trx['amount'] AND invest['amount'] should be equal
	
//:4* trx['address'] should not be used in other investments
//5* trx['created'] must be less than invest 
			
// when aprove a investment : 
// update investment with trx tr addrss
// update trx tr with  investment id
	
//* AI['invest']
$from=$W;$amount=$IN['amount'];$created=$IN['created'];
if($from and $amount and $created){
$WHERE="`from` LIKE '".$from."' AND `amount` = ".$amount." AND `invest` = 0";
$trxs=trx_where($WHERE);	
	if(count($trxs)==1){$trx=$trxs[0];}
	elseif(count($trxs)>1){$trx=$trxs[0];}
	else{$trx='';}
if($trx){
	
$invest_w="`cyrpto` LIKE '".$trx['hash']."'";
$invest=invest_where($invest_w);	
if(count($invest)){$echo='No Idea';}
else{$s=1;$cyrpto=$trx['hash'];$echo='99% chances';}
	
}
else{$echo='0% chances, no cyrpto TR found';}
}
else{$echo='not enough sources';}
$AI=array('s'=>$s,'cyrpto'=>$cyrpto,'echo'=>$echo);
}

}
else{ $echo='define type first';}
}	
return $AI;	
}

 
function FindKeyInNestedArray($array, $searchValue) {
    foreach ($array as $key => $value) {
        if ($key === $searchValue) {
            return $key=$value; // Key associated with the value found
        } elseif (is_array($value)) {
            $result = FindKeyInNestedArray($value, $searchValue);
            if ($result !== false) {
                return $key=$result; // Key found in nested array
            }
        }
    }
    return false; // Value not found in the array
}




?>