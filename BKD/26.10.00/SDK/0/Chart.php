<?php
function Charts(){
	
if(i['branch']){ $Branch = " AND `branch` IN(".i['branch'].",0) ";}else{$Branch="";}
	
	$SQL="SELECT * FROM `Coinpods_chart` WHERE `ttype` LIKE 'Hour' ".$Branch." ORDER BY `Coinpods_chart`.`uid` DESC LIMIT 7200";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return array_reverse($ts);
	
}

function CreateChart($Q=null){
	$results = 0;
	if(is_array($Q)){ $Name=$Q['name']; $UID=$Q['uid']; $Type=$Q['type']; $open=$Q['open']; $close=$Q['close']; $lowest=$Q['lowest']; $highest=$Q['highest']; $Branch=$Q['branch'];}
	if( $Name and $UID and $Type and $open and $close and $lowest and $highest ){
		$SQL="INSERT INTO `Coinpods_chart` (`id`, `name`, `created`, `modified`, `uid`, `ttype`, `open`, `close`, `lowest`, `highest`, `branch`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$UID."', '".$Type."', '".$open."', '".$close."', '".$lowest."', '".$highest."', '".$Branch."');";	
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		// echo $SQL.'<br><br><br>';
	}
	return $results;
}





function CreateCharts(){
	$Return = [];
	for($x = 1; $x >= 1; $x--){	
		$Time=TimeMinusHours( array( 'time'=>IST(), 'hours'=>$x ) );	
		$Timing=$Time; $Time=explode(' ',$Time); $Date=$Time[0]; $Time=$Time[1]; $D=explode('-',$Date); $T=explode(':',$Time);	
		$Timing = $D[0].'/'.$D[1].'/'.$D[2].' '.$T[0].':00'.$T[1111];
		$Branches = Branches();
		if(is_array($Branches) and !empty($Branches)){
			foreach($Branches as $Single){
				if(!empty($Single) and !empty($Single['branch'])){
					$Branch = $Single['branch'];
					$echo = 'Branch|'.$Branch;
					$UID = $D[0].$D[1].$D[2].$T[0].':'.$Branch;
					//echo $echo.'<br>';
					$Array=array( 'Year'=>$D[0], 'Month'=>$D[1], 'Date'=>$D[2], 'Hour'=>$T[0] , 'branch'=>$Branch );					
					$Open = OpenPrice($Array); 
					if($Open){
						$Arg = array(
							'name'=>$Timing,
							'uid'=>$UID,
							'type'=>'Hour',
							'open'=>OpenPrice($Array),
							'close'=>ClosePrice($Array),
							'lowest'=>LowestPrice($Array),
							'highest'=>HighestPrice($Array),
							'branch'=>$Branch

						);						
						$CreateChart = CreateChart($Arg);	 unset($Arg); //echo $Branch.'<br>';		
						//echo "['".$Timing."', ".OpenPrice($Array).", ".ClosePrice($Array).", ".LowestPrice($Array).", ".HighestPrice($Array)."], ";
						$Return[$Branch] = $CreateChart;	
					}
					else{$echo = 'Open Price Not Found.';}
				}
				else{ $echo = 'Branch and Price Not Found.';}
			}
		}
		else{$echo = 'Branches Not Found.';}
	}	
	print_r($Return); echo '<br><br><br>';	
}


?>