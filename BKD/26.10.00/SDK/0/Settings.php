<?php



//# Settings
define('account',1);
define('sign_up',1);
define('sign_up_auto',1);
define('sign_in',1);
define('sign_in_auto',1);

define('invest',1);

define('withdraw',1);



define('refer',1);
define('refer_single_reward',0);
define('refer_invest_reward',1);


$s=array();
$s['trx']='trx'; // trx enabled

$s['app']=''; // ap == settings app mode
$s['single_page']='sp'; // sp == settings single_page
$s['blur']='blur'; // blur == backdrop-filter : blur
$s['img']='img'; // background-image : display / hide



foreach($s as $c){ if($c){$s['all']=$s['all'].' '.$c;} }

define('settings',$s);
define('s',$s); // s == settings
//* Settings

































global $s;
$s=array(
	'Stock'=>10000000,
	'CCC/INR'=>Price(),
	'TOM/INR'=>Price(),
	'TRX/INR'=>4.3672,
	'USD/INR'=>80.80,
	
	'CCC'=>true,
	'TOM'=>true,
	'TRX'=>true,
	'INR'=>true,
	'USD'=>false,

	
	
	
    'A|iens'=>true,
    'DApp'=>true,

    'CCC'=>'HXC',
    'Brand'=>'HXC',

    

    
 



    'Portfolio'=>true,




    'Account'=>true,
	
    'SignUp'=>true,
    'SignUp/Core'=>true,
    'SignUp/Wordpress'=>false,
    'SignUp/Crypto'=>false,
    'SignIn'=>true,
    'SignIn/Core'=>true,
    'SignIn/Wordpress'=>true,
    'SignIn/Crypto'=>false,
    'Forgot'=>true,
    'Forgot/Email'=>true,
    'Forgot/Password'=>true,
    'OTP'=>true,


	
	
	
    'Console'=>true,
	
    'Menubar'=>true,
    'Content'=>true,


    'Community'=>true,
    'Level Income'=>true,

    'Buy'=>true,
    'Bought'=>true,
    'Buy/MinCCC'=>1000,
    'Buy/MinTOM'=>1000,


    'Wallet'=>true,
    'NWI'=>false,


    'Sell'=>true,
    'Sold'=>true,


    'Profile'=>true,
    'Orders'=>true,


    'Launched'=>true,
 
 
    
);


$s['TOM/TRX']=$s['TOM/INR']/$s['TRX/INR'];
$s['TRX/TOM']=$s['TRX/INR']/$s['TOM/INR'];


$s['CCC/TRX']=$s['CCC/INR']/$s['TRX/INR'];
$s['TRX/CCC']=$s['TRX/INR']/$s['CCC/INR'];


$s['CCC/USD']=$s['CCC/INR']/$s['USD/INR'];
$s['USD/CCC']=$s['USD/INR']/$s['CCC/INR'];


define('s',$s);































function Setting_DELETED($Q=null){
	if(!$Q){$Q=1;}

    $SQL = "SELECT * FROM `".prefix."pods_setting` WHERE `user` = '".$Q."'";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $Setting[$aa] = $p; $aa++;}} 
	else{$plans = null;}	
	return $Setting[0];
	
}


function DefaultSetting_DELETED($Q=null){ return Setting(1); }

//$DefaultSetting=DefaultSetting(); 
//define('S',$DefaultSetting);
//define('Setting',$DefaultSetting);
//print_r(Setting);


$DefaultSetting = ['launched'=>1]; define('Setting',$DefaultSetting);



