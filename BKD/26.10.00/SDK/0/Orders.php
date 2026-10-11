<?php
 

function OrderAprove($Q=null){ 
// Get Orders by customer ID
if($Q){
	if(i['id']){
	
  
	$SQL = "UPDATE `".prefix."wc_order_stats` SET `status` = 'wc-processing' WHERE `".prefix."wc_order_stats`.`order_id` = ".$Q;
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	return $results;
   
}
}
}


function Order($Q=null){ 
// Get Orders by customer ID
if($Q){
	if(i['id']){
	
  
	$SQL = "SELECT * FROM `".prefix."wc_order_stats` WHERE `order_id` = ".$Q;
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}


    return $ps[0];
   
}
}
}


function orders($Q=null){ 
// Get Orders by customer ID
if(is_array($Q)){ $LIMIT = $Q['LIMIT']; $OFFSET = $Q['OFFSET']; $Q=$Q['user']; }
	
if(!$Q){$Q=i['id'];}
if(!$LIMIT){$LIMIT=5;}	
if(!$OFFSET){$OFFSET=0;}	

	
	
	
$Q=CustomerID($Q);
	
if($Q){
if(iam['admin']){$SQL="SELECT * FROM `".prefix."wc_order_stats` ORDER BY `".prefix."wc_order_stats`.`order_id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
else{ $SQL = "SELECT * FROM `".prefix."wc_order_stats` WHERE `customer_id` = ".$Q." ORDER BY `".prefix."wc_order_stats`.`order_id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++; }} 
	else{$ps=null;}
 

    return $ps;
    }
}

 






function OrderDeliverd($Q=null){
if(is_array($Q)){ $TID=$Q['TID']; $OrderID=$Q['OrderID'];}

if(i['id']){

    if($TID and $OrderID){
        $SQL = "UPDATE `".prefix."wc_order_stats` SET `TID` = '".$TID."', `status` = 'wc-completed' WHERE `".prefix."wc_order_stats`.`order_id` = ".$OrderID; 
         global $DB; $results = mysqli_query($DB, $SQL);	
        if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
        else{$ps=null;}
    }
    
        
}
 
}


function OrdersToTransactions(){
 
    if(i['id']){
        $PendingOrders=PendingOrders();
        //$LatestOrder=LatestOrder();

        if($PendingOrders){ 
        foreach($PendingOrders as $Order){ 

            $T='';$T=TransactionByOrderID($Order['order_id']);
            if($T){
                // Transaction found, just update order with Transaction ID
                OrderDeliverd(array( 'OrderID'=>$Order['order_id'], 'TID'=>$T['id'] ));
                 }
            else{ 
                // No transaction found, create new one
               

                $Invest = invest(array( 'OrderID'=>$Order['order_id'], 'from'=>UserID($Order['customer_id']), 'amount'=>$Order['num_items_sold'], 'ccc'=>'trx', 'OCA'=>$Order['net_total'], 'OCC'=>'INR' ));

                $T='';$T=TransactionByOrderID($Order['order_id']);
                if($T){
                    OrderDeliverd(array( 'OrderID'=>$Order['order_id'], 'TID'=>$T['id'] ));
                    $S=1; // Success
                }
             }
        }
        } 
    }
    if($S){ return true; }
    else{ return false;}
}


function PendingOrders($Q=null){
	//# Pending order of logged in user
	
	
	
 
    if(i['id']){
		$CI=CustomerID(i['id']);
		
    $SQL = "SELECT * FROM `".prefix."wc_order_stats` WHERE `status` LIKE 'wc-processing' AND `customer_id` = '".$CI."' ORDER BY `order_id` DESC"; 
	global $DB; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}

    return $ps;
    }
}






function IsTalktime($ProductID=null){
	if(i['id']){
	
		 
	if($ProductID){
		
	$SQL="SELECT * FROM `Coinwc_order_product_lookup` WHERE `order_id` = '".$ProductID."'";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}

    $p=$ps[0]; 
		
$PID=0;		
if($p['product_id']==908){ $PID=10; }
elseif($p['product_id']==909){ $PID=15; }
elseif($p['product_id']==910){ $PID=20; }
elseif($p['product_id']==911){ $PID=25; }
elseif($p['product_id']==912){ $PID=30; }
elseif($p['product_id']==913){ $PID=35; }
elseif($p['product_id']==914){ $PID=40; }
elseif($p['product_id']==915){ $PID=45; }
elseif($p['product_id']==916){ $PID=50; }
elseif($p['product_id']==917){ $PID=55; }
elseif($p['product_id']==918){ $PID=60; }
		
		if($PID){ return $PID; }
		else{ return false; }

		
	}
	}
	
}




?>