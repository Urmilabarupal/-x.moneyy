<?php


function NI(){
//array = status,total,roi,withdrawed,withdrawable,left,days,button
$nwi=nwi();

	

	if($nwi['status']==7){
	$NI['status']='Active';
		if(d2p($nwi['withdrawable'])>=100){$NI['status']="Active Withdrawable";}
	}
	else{
		$NI['status']='Pending';
	}
	
	$NI['total']=number_format(d2p($nwi['total']),0);
	$NI['roi']=$nwi['roi'];
	$NI['withdrawed']=number_format(d2p($nwi['withdrawed']),2);
	$NI['withdrawable']=number_format(d2p($nwi['withdrawable']),11);
	
	
	$left = diff_in_seconds(array( 'start' => $nwi['aproved'], 'end' => GMT() ));
	$total = $nwi['days']*day; 
	$left = $total-$left; $left = $left/day;
	if($left<0){$left=0;}
	$NI['left']=number_format($left,10);
	$NI['days']=$nwi['days'];
	if(d2p($nwi['withdrawable'])>99){ $NI['button']='withdraw_nwi';} else{ $NI['button']='withdraw_nwi_disabled';} 
	return $NI;

}


function nwi_optimize($Q=null){
// OUTPUT : Optimize a nwi by user_id
global $DB;$aa = 0;
	
$levels=levels(i['id']);
$level=$levels['level'];
$users=$levels['users'][1];

if($level[1]>1){
//# entry possible IF more than 2 directs
$need2=array();	
foreach($users as $user){
	$trs=transactions($user);
	foreach($trs as $tr){
		if($tr['status']==7 and clean($tr['aproved'])){ $need2[$user]=1;}
		else{ $echo = $tr['id'].' invest not aproved'; }
	
	}

}
$need2=count($need2);
if($need2>1){
//# entry possible IF more than 2 directs have more than 2 investments

$nwi=nwi();	
	

if($nwi['id']){
//# NWI already created, so we are optimizing	
$t = $nwi;
if($t['status'] == 7 and $t['aproved']){	 
//#	NWI aproved, so we can optimize
	
//# END of Invest
$end = time_plus_days(array( 'time' => $t['aproved'], 'days' => $t['days'] )); 
if($end){$end = " ,`end` = '".$end."'";} else{ $end = null;}
//* END of Invest			
			
//# ROI	
if($t['roi_updated']){$ru = $t['roi_updated'];} else{$ru = $t['aproved'];}
$DF = diff_in_seconds(array( 'start' => $ru, 'end' => GMT() ));
$diff = diff_in_seconds(array( 'start' => $t['aproved'], 'end' => GMT() ));
		
$period = $t['days'];
$period = $period*day; 

if($period > $diff){
$amount = 100; $amount = $amount/100;

$ROI = $t['roi']; $ROI = $ROI/day;
$withdrawable = $ROI*$DF;$wable = $withdrawable;
$withdrawable = $withdrawable*base;
$withdrawable = $withdrawable*$amount;$w_free=$withdrawable;
$withdrawable = $withdrawable + $t['withdrawable'];
$SET = "`withdrawable` = ".$withdrawable." ,`roi_updated` = '".GMT()."' ,`modified` = '".GMT()."'".$end;
			
$SQL = "UPDATE `nwi` SET ".$SET." WHERE `nwi`.`user` = ".$t['user'];

$results = mysqli_query($DB, $SQL);
$SET=null;	
return 'NWI updated with withdrawable : '.number_format(d2p($withdrawable),2).'(+'.number_format(d2p($w_free),7).')';

}	
else{
return 'ROI Total period expired';
}
//* ROI
	
//* NWI aproved, so we can optimize
}
else{ 
//#	NWI not aproved, may be php function problem in Optimize_NWI()
return 'NWI not aproved now till.';
//*	NWI not aproved, may be php function problem in Optimize_NWI()
}
	
//* NWI already created, so we are optimizing	
}
else{
//# NWI not created for current user, so we are creating first	
$user=i['id'];
if($user){
$SQL="INSERT INTO `nwi` (`id`, `user`, `days`, `roi`, `amount`, `c`, `status`, `roi_updated`, `withdrawable`, `withdrawed`, `withdraw_ok`, `created`, `modified`, `end`, `aproved`) VALUES (NULL, '".$user."', '365', '5', '100', 'TRX', '7', NULL, '0', '0', NULL, current_timestamp(), current_timestamp(), NULL, current_timestamp());";
$results = mysqli_query($DB, $SQL);
	return 'created new';
}	
else{ return 'login first'; }
//* NWI not created for current user, so we are creating first
}
//# entry possible IF more than 2 directs have more than 2 investments
}
else{return 'Your 2 directs have not mane any investments';}

//* entry possible IF more than 2 directs
}
else{return 'You have not 2 directs to active your NWI';}
}
 
?>