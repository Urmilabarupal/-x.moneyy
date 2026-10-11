<?php

function TotalAirDrop(){
	
	if(i['id']){
		global $DB; $aa = 0;
 		$SQL = "SELECT SUM(AirDrop) FROM `".prefix."users`";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(AirDrop)'];}
 	}
	else{ return 0; }

}


?>