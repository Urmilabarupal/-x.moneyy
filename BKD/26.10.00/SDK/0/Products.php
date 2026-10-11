<?php




function ProductByOrderID($OrderID=null){
	//ProductIdByOrderID
	
	if(i['id']){
	
		 
	if($OrderID){
		
	$SQL="SELECT * FROM `Coinwc_order_product_lookup` WHERE `order_id` = '".$OrderID."'";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}

      return get_post($ps[0]['product_id']);

		
	}
	}
	
}



function ProductIdByOrderID($OrderID=null){
	//ProductIdByOrderID
	
	if(i['id']){
	
		 
	if($OrderID){
		
	$SQL="SELECT * FROM `Coinwc_order_product_lookup` WHERE `order_id` = '".$OrderID."'";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}

      return $ps[0]['product_id'];

		
	}
	}
	
}




function Product($Q=null){
	if($Q){
	
	$SQL="SELECT * FROM `Coinpods_product` WHERE `id` = '".$Q."' LIMIT 1";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts[0];
	}
	
	
}



function Products(){
	
	$SQL="SELECT * FROM `Coinposts` WHERE `post_type` LIKE 'product' AND `post_status` LIKE 'publish' AND `TalkTime` IS NULL";
	global $DB; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts;
	
	
}




?>