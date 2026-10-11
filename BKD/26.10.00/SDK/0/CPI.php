<?php


if(i['id']){
	global $Username;
	global $text;
	$Username=i['username']; 
	$text="cpi://pay?pa=".i['username']."@apgt&pn=0&mc=0000&mode=02&purpose=00"; 
		
		//require 'QR/Code/0.php';
}

function QR(){
	if(i['id']){	
		
		//return '/QR/Code/'.i['username'].'.png';
	}


}


?>