<?php






function plan($Q=null){
// OUTPUT : Array('plan_id',roi_by_amount,plan_days) 
// INPUT : amount, ccc(currency)
// find plan by invest VALUE
	
$amount = $Q['amount'];$c = strtolower($Q['ccc']);$min = $c.'_min';$max = $c.'_max';

global $DB;$aa = 0;
	// get roi plans from DB
	$SQL = "SELECT * FROM `plans`";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}
	
	foreach($plans as $plan){
		// matching invest value
		if($amount >= $plan[$min] and $plan[$max] >= $amount){
			$p = $plan; 
		}
	}
	if($p){ 
		$args = array( 
			'amount' => $Q['amount'], 
			'min_amount' => $p[$min],
			'max_amount' => $p[$max], 
			'min_roi' => $p['roimin'],
			'max_roi' => $p['roimax'],
		);
		$roi = number_format(roi_for_amount($args),2);
		$p['roi']=$roi;
	}
	else{ $p = 'Out of Plans'; }
	return $p;
}


function plans($Q=null){
// OUTPUT : get Investment Plans data from DB
global $DB;$aa = 0;
	$SQL = "SELECT * FROM `plans`";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $plans[$aa] = $p; $aa++;}} 
	else{$plans = null;}	
	return $plans;
}














?>