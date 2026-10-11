<?php
/*
global $DBUsers; $s = "localhost"; $u = "HX.Money.Users"; $p = "A@9829011412"; $db = "HX.Money.Users";
$DBUsers = new mysqli($s, $u, $p, $db);
if ($DBUsers->connect_error) { die("Connection failed: " . $DBUsers->connect_error); }

*/





function Structure($UID=null){
	// Developer : JAspal Byavat
	// Work : In Progress
	// Date : 15-03-2025 [dd-mm-yy]
	// Output : Return Database Table Structure
	
	if($UID){
		$echo = 'UID Found';
		
		$SQL = "DESCRIBE ".$UID; 
		global $DB;$aa = 0;$results = mysqli_query($DB, $SQL);	//print_r($results);
		if($results){ 
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
			else{$ts = null;}
		}

		$Structure = $ts;
		
	}
	else{$echo = 'UID is Required.';}
	
	return  $Structure;
}

 
?>