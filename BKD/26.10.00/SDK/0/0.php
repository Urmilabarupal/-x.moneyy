<?php

function Easy_DELETED($Q=null){
	
if(
	$Q=='123456'
	or $Q=='1234567'
	or $Q=='12345678'
	or $Q=='123456789'
	or $Q=='1234567890' 
	
	or $Q=='098765'
	or $Q=='0987654'
	or $Q=='09876543'
	or $Q=='098765432' 
	or $Q=='0987654321'
	
	or $Q=='111111'
	or $Q=='1111111'
	or $Q=='11111111'
	or $Q=='111111111'
	or $Q=='1111111111'
	
	or $Q=='222222'
	or $Q=='2222222'
	or $Q=='22222222'
	or $Q=='222222222'
	or $Q=='2222222222'
	
	or $Q=='333333'
	or $Q=='3333333'
	or $Q=='33333333'
	or $Q=='333333333'
	or $Q=='3333333333'
	
	or $Q=='444444'
	or $Q=='4444444'
	or $Q=='44444444'
	or $Q=='444444444'
	or $Q=='4444444444'
	
	or $Q=='555555'
	or $Q=='5555555'
	or $Q=='55555555'
	or $Q=='555555555'
	or $Q=='5555555555'
	
	or $Q=='666666'
	or $Q=='6666666'
	or $Q=='66666666'
	or $Q=='666666666'
	or $Q=='6666666666'
	
	or $Q=='777777'
	or $Q=='7777777'
	or $Q=='77777777'
	or $Q=='777777777'
	or $Q=='7777777777'
	
	or $Q=='888888'
	or $Q=='8888888'
	or $Q=='88888888'
	or $Q=='888888888'
	or $Q=='8888888888'
	
	or $Q=='999999'
	or $Q=='9999999'
	or $Q=='99999999'
	or $Q=='999999999'
	or $Q=='9999999999'
	
	or $Q=='000000'
	or $Q=='0000000'
	or $Q=='0000000'
	or $Q=='00000000'
	or $Q=='000000000'
	
	or $Q=='123123'
	or $Q=='12341234'
	or $Q=='1234512345'
	
	
	or $Q=='112233'
	or $Q=='11223344'
	or $Q=='1122334455'
	
	
		
){ return true; }
else{ return false; }
}



function img_DELETED($Q=null){ }

function C_DELETED($C=null){
//Content Type : Dashboard, Page, Profile, Community, Buy, 404	
$U=URL($C);	
	
	if($U[1]=='Home'){ $C='dashboard'; }
	
	
	elseif($U[1]=='profile'){ 
		$C='profile';
		if($U[2]=='edit'){ $CNT=$U[2]; }
		elseif($U[2]=='about'){ $CNT=$U[2]; }
		elseif($U[2]=='settings'){ $CNT=$U[2]; }
		else{ $CNT='about'; }
	}
	
	
	elseif($U[1]=='LuckyDraw'){ $C='LuckyDraw'; $CNT=$U[2]; }
	elseif($U[1]=='trade'){ $C='trade'; $CNT=$U[2]; }
	elseif($U[1]=='buy'){ $C='trade'; $CNT=$U[2]; }
	elseif($U[1]=='sell'){ $C='trade'; $CNT=$U[2]; }
	elseif($U[1]=='depositmanager'){ $C='DepositManager'; $CNT=$U[2]; }
	
	elseif($U[1]=='share'){ $C='share'; $CNT=$U[2]; }
	elseif($U[1]=='Transfer_app'){ $C='soon'; /*$C='Transfer_app';*/ $CNT=$U[2]; }

	
	/*elseif($U[1]=='miningwallet'){ $C='wallets';
	 if($U[2]){ $C='miningwallet'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
	 else{ $C='miningwallets'; $CNT=$U[1]; $CNT = $U[2]; $T='Mining Wallet'; }  }	*/
	
	elseif($U[1]=='funding'){ $C='wallets';
		if($U[2]){ $C='funding'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='fundings'; $CNT=$U[1]; $CNT = $U[2]; $T='Funding Wallet'; } 
	}	
	
	elseif($U[1]=='jackpotincomes'){ $C='jackpotincomes';
		if($U[2]){ $C='jackpotincome'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='jackpotincomes'; $CNT=$U[1]; $CNT = $U[2]; $T='jackpotincomes'; } 
	}
	
	elseif($U[1]=='jackpotrewards'){ $C='jackpotrewards';
		if($U[2]){ $C='jackpotreward'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='jackpotrewards'; $CNT=$U[1]; $CNT = $U[2]; $T='jackpotrewards'; } 
	}
	
	
		
	elseif($U[1]=='main_wallet'){ $C='Main_Wallets';
		if($U[2]){ $C='Main_Wallet'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='Main_Wallets'; $CNT=$U[1]; $CNT = $U[2]; $T='Main Wallets'; } 
	}
	
	
	elseif($U[1]=='jackpotdirectrewards'){ $C='jackpotdirectrewards';
		if($U[2]){ $C='jackpotdirectreward'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='jackpotdirectrewards'; $CNT=$U[1]; $CNT = $U[2]; $T='jackpotdirectrewards'; } 
	}
	
	elseif($U[1]=='wallets'){ $C='wallets';
		if($U[2]){ $C='wallet'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='wallets'; $CNT=$U[1]; $CNT = $U[2]; $T='Wallets'; } 
	}

	elseif($U[1]=='Salaryachivar'){
		$C='Salaryachivar'; $T='New User'; $D='';
		if($U[2]=='history'){ $C='Salaryachivar'; $CNT = $U[2]; $T='Salaryachivar User History'; $Data; if($U[3]){$CNT = $U[3]; }}
		elseif($U[2]){ $C='Salaryachivar'; $CCC=Currency($U[2]);  $CNT = $U[2]; $T='Salaryachivar User'.$CCC['symbol']; $Data=$CCC; } 
	}	

	
	elseif($U[1]=='jackpot_wallet'){ $C='jackpot_wallets';
		if($U[2]){ $C='jackpot_wallet'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
		else{ $C='jackpot_wallets'; $CNT=$U[1]; $CNT = $U[2]; $T='Jackpot Wallet'; } 
	}
	
	
		elseif($U[1]=='Extra_Wallet'){ $C='Extra Wallets'; $T='HXC Wallet';
		if($U[2]){ $C='Extra_Wallet'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]);$T=$Data['name']; } 
		else{ $C='Extra_Wallets'; $CNT=$U[1]; $CNT = $U[2]; $T='Extra Wallets'; } 
	}
	
	
	
	elseif($U[1]=='Jackpot_deposit'){ $C='Jackpot_deposits';
    if($U[2]){ $C='Jackpot_deposit'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
    else{ $C='Jackpot_deposits'; $CNT=$U[1]; $CNT = $U[2]; $T='Jackpot Deposit'; } 
	}	

elseif($U[1]=='jackpotset'){ $C='JackpotSet';
    if($U[2]){ $C='JackpotSetIncome'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
    else{ $C='JackpotSet'; $CNT=$U[1]; $CNT = $U[2]; $T='Jackpot Set'; } 
	}	
		
elseif($U[1]=='jackpotworker'){ $C='JackpotWorker';
    if($U[2]){ $C='JackpotWorkerIncome'; $CNT = $U[2]; $CID=$U[2]; $Data=Currency($U[2]); } 
    else{ $C='JackpotWorker'; $CNT=$U[1]; $CNT = $U[2]; $T='Jackpot Worker'; } 
	}	
		

	elseif($U[1]=='jackpot'){ $C='jackpot'; $CNT=$U[2]; }
	
	
	elseif($U[1]=='deposit'){ $C='deposit'; $CNT=$U[2]; }
	elseif($U[1]=='jackpot'){ $C='jackpot'; $CNT=$U[2]; }
	
	
	
	elseif($U[1]=='jackpotdirectreward'){ $C='JackpotDirectReward'; $CNT=$U[2]; }
	elseif($U[1]=='jackpotreward'){ $C='JackpotReward'; $CNT=$U[2]; }
	elseif($U[1]=='withdraw'){ $C='withdraw'; $CNT=$U[2]; }
	elseif($U[1]=='convert'){ $C='Convert'; $CNT=$U[2]; }
	elseif($U[1]=='cccconvert'){ $C='Convert_ccc'; $CNT=$U[2];  $T='XAH Convert';  }
	elseif($U[1]=='staking_plan'){ $C='staking_plan'; $CNT=$U[2]; }
	elseif($U[1]=='Transfer'){ $C='Transfer'; $CNT=$U[2]; }
	elseif($U[1]=='wintransfer'){  $C='soon'; /*$C='WinToTransfer';*/ $CNT=$U[2];  $T='Transfer To Hellox Win';}
	
	
	elseif($U[1]=='pay'){ $C='pay'; $CNT=$U[2]; }
	elseif($U[1]=='send'){ $C='send'; $CNT=$U[2]; }
	elseif($U[1]=='receive'){ $C='receive'; $CNT=$U[2]; }
	elseif($U[1]=='slot'){ $C='slot'; $CNT=$U[2]; }
	
 
	
	
	
	elseif($U[1]=='trip'){ $C='trip'; $CNT=$U[2]; }	
	elseif($U[1]=='Earning'){ $C='Earning'; $CNT=$U[2]; }	
	elseif($U[1]=='rewards'){ $C='dashboard'; $CNT=$U[2]; }	
	elseif($U[1]=='Stake'){ $C='Stake'; $CNT=$U[2]; $Data= Staking_Plans(['id'=>$U[2], 'status'=>1]); $T=''; }	
	elseif($U[1]=='TeamStake'){ $C='Staking_Income-Team'; $CNT=$U[2]; $Data= Staking_Plans(['id'=>$U[2], 'status'=>1]); $T=''; }	
	//elseif($U[1]=='Dhalving'){ $C='Dhalving'; $CNT=$U[2]; }	
	elseif($U[1]=='C_halving'){ $C='C_halving'; $CNT=$U[2]; }	
	//elseif($U[1]=='mining'){ $C='mining'; $CNT=$U[2]; }	
	//elseif($U[1]=='unstaking'){ $C='unstaking'; $CNT=$U[2]; }	
	elseif($U[1]=='winner'){ $C='winners'; $CNT=$U[2]; }	
	elseif($U[1]=='portfolio_list'){ $C='portfolio_list'; $CNT=$U[2]; }	
	elseif($U[1]=='connect'){ $C='connect'; $CNT=$U[2]; }	
	
	
	
		
	
	
 
	
	
	
	
	
elseif($U[1]=='bet'){
		$C='bets'; $T='Bets';  $CNT = 'all'; $D=''; 		
		if($U[2]){ $C='bett'; $CCC=Bet($U[2]);  $CNT = $U[2]; $T='bet'.$CCC['symbol']; $Data=$CCC; }	
	
	}
	
	
	elseif($U[1]=='tx' and $U[2]){ $C='transaction'; $CNT='transaction'; $CNTID=$U[2]; $Data=Transaction($U[2]);  $T=$Data['ttype'].' Transaction';  }

	
	
	elseif($U[1]=='community'){ $C='community'; $CNT=$U[2]; $CNTID=$U[3]; }	
	elseif($U[1]=='user' and $U[2]){
		$C='user'; 
		if($U[3]){
			if($U[4]){ $CNT='wallet'; $CNTT=$U[4]; }
			else{ $CNT=$U[3]; }
		}
		else{ $CNT = 'all'; }
		
		if($U[3]=='community'){
			
			
		if($U[4]){ $CNTT=$U[4]; }
		else{ $CNTT='all'; }
		
		}
		$CNTID=$U[2]; $Data=user($U[2]);  $T=$Data['name']; 
	
	}

  	
	
	
	elseif($U[1]=='about'){ $C='page'; $CNT=$U[1]; $T='About'; }
	elseif($U[1]=='contact'){ $C='page'; $CNT=$U[1]; $T='Contact'; }
	elseif($U[1]=='help'){ $C='page'; $CNT=$U[1]; $T='Help'; }
	elseif($U[1]=='terms'){ $C='page'; $CNT=$U[1]; $T='Terms & Conditions'; }
	elseif($U[1]=='faqs'){ $C='page'; $CNT=$U[1]; $T='FAQs'; }
	elseif($U[1]=='legal'){ $C='page'; $CNT=$U[1]; $T='Cancellation and Refund Policy'; }
	elseif($U[1]=='locations'){ $C='page'; $CNT=$U[1]; $T='Locations'; }
	elseif($U[1]=='policy'){ $C='page'; $CNT=$U[1]; $T='Privacy Policy'; }
	elseif($U[1]=='sales'){ $C='page'; $CNT=$U[1]; $T='Sales Policy'; }
	
	
	
	elseif($U[1]=='HelloX'){ $C='HelloX'; $CNT=$U[1]; $T='HelloX'; }

	
	
	
	 
	elseif($U[1]=='404'){ $C='404'; }
	else{ $C='404'; }	
	
	
$Output=array( 'C'=>$C, 'c'=>$C, 'Content'=>$C, 'content'=>$C, 'cnt'=>$CNT, 'CNT'=>$CNT, 'CNTT'=>$CNTT, 'CNTID'=>$CNTID, 'CID'=>$U[2], 'T'=>$T, 't'=>$T, 'title'=>$T, 'Data'=>$Data, 'd'=>$Data, 'D'=>$Data );
return $Output;	
}
 

function B_DELETED($c,$d=2){global $h; return number_format(d2p(balance($c,i['id'])),$d); }
function IN_DELETED($c,$d=2){global $h; return number_format(d2p(total_invest($c,i['id'])),$d); }
function OUT_DELETED($c,$d=2){global $h; return number_format(d2p(total_withdraw($c,i['id'])),$d); }
function WA_DELETED($c,$d=2){global $h; return number_format(d2p(total_wa($c,i['id'])),$d); }
function RR_DELETED($c,$d=2){global $h; return number_format(d2p(total_refer($c,i['id'])),$d); }
function RT_DELETED($c,$d=2){ return number_format(d2p(total_roi($c)),$d); }
function CCS_DELETED($c){ return coin_c($c); }
 


?>