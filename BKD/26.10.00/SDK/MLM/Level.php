<?php



function Sep17_StakeTree($Q=null){
if(!$Q){$Q=i['userid']; }
$Tree=[]; $Rewards=[];	
$users=Downline($Q); // get users of only level 1
$Business=0; $DirectStake=0; $DirectDeposit=0;

if($users){
	
	$aa=0;	
	foreach($users as $user){
		
		$user=$user['userid'];  
		
		$aa++;
		$thiss=UserByUserID($user);  
		$ThisStake=$thiss['Sep17_TotalStake']; $DirectStake=$DirectStake+$ThisStake;
		$TeamStake=Sep17_TeamStake($thiss['userid']);
		$TB=$ThisStake + $TeamStake; 
		
		$Tree[$aa]=array( 'TeamStake'=>d2p($TB), 'ThisStake'=>d2p($ThisStake),  'amount'=>d2p($TB), 'id'=>$thiss['ID'], 'userid'=>$user );	

		
		//* 2024-09-11
		
		$ThisDeposit=$thiss['TotalDeposit2024']; $DirectDeposit=$DirectDeposit+$ThisDeposit;
		$TeamDeposit=TeamDeposit2024($thiss['userid']);
		$TD=$ThisDeposit + $TeamDeposit; 

		$Rewards[$aa]=array( 'TeamDeposit'=>d2p($TD), 'ThisDeposit'=>d2p($ThisDeposit),  'amount'=>d2p($TD), 'id'=>$thiss['ID'], 'userid'=>$user );	
  //# 2024-09-11
	
	
	}	
	 
	$TreeActual=$Tree;
	arsort($Tree); 
	
	//* 2024-09-11
	$RewardActual=$Rewards;
	arsort($Rewards); 
	//# 2024-09-11
	
	
	$aa=0;
	foreach($Tree as $Branch){ 
		$aa++;
		if($aa==1){ $Legs[$aa]=$Branch['amount']; $Treee[$aa]=array('id'=>$Branch['id'],'amount'=> $Branch['amount']);}
		else{$Legs[2]=$Legs[2]+$Branch['amount']; $Treee[2] = array( 'id'=>'various', 'amount'=> $Legs[2]);}	
	}
	
	//* 2024-09-11
	$bb=0;
	foreach($Rewards as $Reward){ 
		$bb++;
		if($bb==1){ $DLegs[$bb]=$Reward['amount']; $Rewarddd[$bb]=array('id'=>$Reward['id'],'amount'=> $Reward['amount']);}
		else{$DLegs[2]=$DLegs[2]+$Reward['amount']; $Rewarddd[2] = array( 'id'=>'various', 'amount'=> $DLegs[2]);}	
	}
	//# 2024-09-11
	
	
	
	
	foreach($Legs as $Leg){ $Business=$Business+$Leg; }
	
	$Output=array( 'AllLegs'=>$TreeActual,  'Legs'=>$Treee, 'TeamStake'=>$Business, 'DirectStake'=>d2p($DirectStake), 'DirectDeposit'=>d2p($DirectDeposit), 'Reward'=>$Rewarddd );
}	
return $Output;	
}


























 



function StakeTree($Q=null){

if(!$Q){ $Q=i['userid']; }
$Tree=[]; 	
$levels=Downlines($Q);   
$users=$levels['users'][1];	// get users of only level 1
$Business=0; $DirectStake=0;
$TotalDirectJackpot = 0;
if($users){
	
	
	
	$aa=0;	 
	foreach($users as $user){
		
		$echo = 'Processing ALL Legs.';
		
		$aa++;
		$thiss=UserByUserID($user); $echo = 'Getting This user data.';
		
		$ThisStake=TotalStake15Jan($thiss['ID']); $DirectStake=$DirectStake+$ThisStake;
		$TeamStake15Jan=TeamStake15Jan($user);
		
		$TeamStake=$TeamStake15Jan['TotalTeamStake'];
		
		if($thiss['jackpotactive']!=0){ $TotalDirectJackpot++; $echo = 'Total Direct Active Jackpot.'; }
		
		$TotalTeamJackpot=0;
		
		$TotalTeamJackpot=$TeamStake15Jan['TotalTeamJackpot']; $echo = 'Total Team Jackpot of each leg.';
		
		$TB=$ThisStake + $TeamStake; 
		
		$Tree[$aa]=array( 'TeamStake'=>d2p($TB), 'ThisStake'=>d2p($ThisStake),  'amount'=>d2p($TB), 'id'=>$thiss['ID'], 'userid'=>$user, 'TotalTeamJackpot'=>$TotalTeamJackpot, 'ThisJackpot'=>$thiss['jackpotactive'] );	
		
	$Tree2[$aa]=array( 'TotalTeamJackpot'=>$TotalTeamJackpot, 'id'=>$thiss['ID'], 'userid'=>$user, 'ThisJackpot'=>$thiss['jackpotactive'] );	
	}	
	

	
	//# Jackpot
	arsort($Tree2); 
	
	$bb=0; 
	foreach($Tree2 as $Ps){ 
		$bb++;
		if($bb==1){ $L[$bb]=$Ps['TotalTeamJackpot']; }
		else{ $L[2]=$L[2]+$Ps['TotalTeamJackpot']; }
	}
	
	$JackpotReward = $L;
	//echo 'UserID : '.$Q.'<br>MasterLeg : '.$L[1].'<br>AnotherLeg : '.$L[2].'<br>TotalDirectJackpot : '.$TotalDirectJackpot; 
	UpdateLegUsers(array('userid'=>$Q, 'Direct'=>$TotalDirectJackpot, 'MasterLeg'=>$L[1], 'AnotherLeg'=>$L[2]));	 
	//* Jackpot
	
	
	
	
	$TreeActual=$Tree;
	arsort($Tree); 
	
	$aa=0;
	foreach($Tree as $Branch){ 
		$aa++;
		if($aa==1){ $Legs[$aa]=$Branch['amount']; $Treee[$aa]=array('id'=>$Branch['id'],'amount'=> $Branch['amount']);}
		else{$Legs[2]=$Legs[2]+$Branch['amount']; $Treee[2] = array( 'id'=>'various', 'amount'=> $Legs[2]);}	
	}
	
 
	
	
	foreach($Legs as $Leg){ $Business=$Business+$Leg; } 
	$Output=array( 'AllLegs'=>$TreeActual,  'Legs'=>$Treee, 'TeamStake'=>$Business, 'DirectStake'=>d2p($DirectStake), 'JackpotReward'=>$JackpotReward, 'JackpotActiveDirect'=>$TotalDirectJackpot, 'JackpotTree'=>$Tree22 ); 
}	
return $Output;	
}







function Tree(){
$Tree=[]; 	
$levels=levels();
$users=$levels['users'][1];	


if($users){
	$aa=0;
	foreach($users as $user){
		$thiss=user($user);
		$aa++;
		$levels=levels($user);	$TB=d2p($thiss['Wallet']) + TeamBusiness($levels); $Ratio=$TB*40/100;
		$Tree[$aa]=array( 'amount'=>$TB, 'id'=>$user, 'Ratio'=>$Ratio );	
	}	
	arsort($Tree);
	$aa=0;
	foreach($Tree as $Branch){ 
		$aa++;
		if($aa==1 or $aa==2){ $Legs[$aa]=$Branch['amount']*40/100;$Treee[$aa]=array('id'=>$Branch['id'],'amount'=> $Branch['amount']*40/100);}
		else{$Legs[3]=$Branch['amount']+$Branch['amount']*20/100; $Treee[3] = array( 'id'=>'various', 'amount'=> $Branch['amount']+$Branch['amount']*20/100 );}	
	}
	foreach($Legs as $Leg){ $Business=$Business+$Leg; }
	$Output=array( 'Tree'=>$Treee, 'Business'=>$Business );
}	
return $Output;	
}




function enable_level($Human=null,$l=null){
if($Human and $l){
global $DB;$aa = 0;	
$SQL="UPDATE `users` SET `level` = '".$l."' WHERE `users`.`id` = ".$Human;	
$results = mysqli_query($DB, $SQL);
if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
else{$ts = null;}
return true;
}
else{ return false;	}
}





function ReferCredit($TID=null){
	if(i['id']){ // If logged in?
		if($TID){ // If Transaction ID
		$T=refer($TID);
		if($T){ // If Transaction Found
			if(!$T['Balance']){// If Balance not Credited

				$ii=i();$Wallet=$ii['Refer']; $Wallet=$Wallet+$T['amount'];

				$SQL="UPDATE `".prefix."users` SET `Refer` = '".$Wallet."', `ReferUpdated` = '".GMT()."' WHERE `".prefix."users`.`ID` = ".$T['user'];	
				global $DB; $results = mysqli_query($DB, $SQL); // Wallet Balance Updated

				$SQL="UPDATE `refers` SET `Balance` = '1' WHERE `refers`.`id` = ".$T['id'];	
				global $DB; $results = mysqli_query($DB, $SQL); // Transaction status updated

			}
		}
		}
	}
}





function TotalLevelIncome($Q=null){
	
if(i['id']){	
if($Q){ $SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Level' AND `balance` = '1' AND `user` = '".$Q."';";  }
else{
	if(i['Role']=='Manager'){ $SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Level' AND `balance` = '1';";  }
	else{ $Q=i['id'];$SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Level' AND `balance` = '1' AND `user` = '".$Q."';"; }
} 
	
	if($SQL){		
		
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`amount`)']; }
 	}
	else{ return 0; }

}
}





function Downline($Q=null){
// OUTPUT : All users refered by a single user_ID(Q)
if($Q){	
	//$SQL="SELECT `userid` FROM `".prefix."users` WHERE `referby` = '".$Q."'  ORDER BY `".prefix."users`.`ID` DESC";
	$SQL="SELECT `userid` FROM `".prefix."users` WHERE `referby` = '".$Q."'";
	global $DB; $aa = 0; $users = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){ $level[$aa] = $user; $aa++;}} 
	else{$level = null;}	
	return $level;
}	
}

function Downlines($Q=null){
// OUTPUT : Levels[counts,total,user_id] of single user(Q)
// INPUT : Q(user_ID)
// ENGINE : All users refered by single user_ID(Q); than all users refered by every refered user

if(!$Q){

if(i['id']){ $username=i['userid'];}
	else{$username = i['userid'];}
	$Q=$username;
	$Q=i['userid'];
}
  
	
global $DB;
$levels[1]=$levels[2]=$levels[3]=$levels[4]=$levels[5]=$levels[6]=$levels[7]=$levels[8]=$levels[9]=$levels[10]=$levels[11]=$levels[12]=$levels[13]=$levels[14]=$levels[15]=$levels[16]=$levels[17]=$levels[18]=$levels[19]=$levels[20]=$levels[21]=$levels[22]=$levels[23]=$levels[24]=$levels[25]=$levels[26]=$levels[27]=$levels[28]=$levels[29]=$levels[30]=0;
$aa[1]=$aa[2]=$aa[3]=$aa[4]=$aa[5]=$aa[6]=$aa[7]=$aa[8]=$aa[9]=$aa[10]=$aa[11]=$aa[12]=$aa[13]=$aa[14]=$aa[15]=$aa[16]=$aa[17]=$aa[18]=$aa[18]=$aa[20]=$aa[21]=$aa[22]=$aa[23]=$aa[24]=$aa[25]=$aa[26]=$aa[27]=$aa[28]=$aa[29]=$aa[30]=1;
	


	$level=Downline($Q); 
	if($level){
		if($level){ $levels[1]=count($level); }
		
	foreach($level as $user){
		$users[1][$aa[1]]=$user['userid'];
		
		
		$aa[1]++;  $level=Downline($user['userid']);
		if($level){ $levels[2]=$levels[2]+count($level); }
		
		if($level){
		foreach($level as $user){
			$users[2][$aa[2]]=$user['userid'];
			
			 
			$aa[2]++; $level=Downline($user['userid']);			
			if($level){$levels[3]=$levels[3]+count($level);}
			if($level){
			foreach($level as $user){
				$users[3][$aa[3]]=$user['userid'];
				
				
				$aa[3]++;  $level=Downline($user['userid']);
				if($level){$levels[4]=$levels[4]+count($level);}
				if($level){
				foreach($level as $user){
					$users[4][$aa[4]]=$user['userid'];
					
					

					$aa[4]++;  $level=Downline($user['userid']);
					if($level){$levels[5]=$levels[5]+count($level);}
					if($level){
					foreach($level as $user){
						$users[5][$aa[5]]=$user['userid'];
						



						$aa[5]++; $level = Downline($user['userid']); 
						if($level){$levels[6]=$levels[6]+count($level);}
						if($level){
						foreach($level as $user){
							$users[6][$aa[6]]=$user['userid'];


							$aa[6]++; $level=Downline($user['userid']);
							if($level){$levels[7]=$levels[7]+count($level);}
							if($level){
							foreach($level as $user){
								$users[7][$aa[7]]=$user['userid'];
								

								$aa[7]++; $level=Downline($user['userid']);
								if($level){$levels[8]=$levels[8]+count($level);}
								if($level){
								foreach($level as $user){
									$users[8][$aa[8]]=$user['userid'];
									
									
									$aa[8]++; $level=Downline($user['userid']);
									if($level){$levels[9]=$levels[9]+count($level);}
									if($level){
									foreach($level as $user){
										$users[9][$aa[9]]=$user['userid'];
										

										$aa[9]++; $level=Downline($user['userid']); 
										if($level){$levels[10]=$levels[10]+count($level);}
										if($level){
										foreach($level as $user){
											$users[10][$aa[10]]=$user['userid'];
											

											$aa[10]++; $level=Downline($user['userid']); 
											if($level){$levels[11]=$levels[11]+count($level);}
											if($level){
											foreach($level as $user){											
												$users[11][$aa[11]]=$user['userid'];
												

												$aa[11]++;$level=Downline($user['userid']);
												if($level){$levels[12]=$levels[12]+count($level);}	
												if($level){
												foreach($level as $user){
													$users[12][$aa[12]]=$user['userid'];
													

													$aa[12]++; $level=Downline($user['userid']);
													if($level){$levels[13]=$levels[13]+count($level);}
													if($level){
													foreach($level as $user){
														$users[13][$aa[13]]=$user['userid'];
														

														$aa[13]++; $level=Downline($user['userid']);
														if($level){$levels[14]=$levels[14]+count($level);}
														if($level){
														foreach($level as $user){
															$users[14][$aa[14]]=$user['userid'];
															

															$aa[14]++; $level=Downline($user['userid']);
															if($level){$levels[15]=$levels[15]+count($level);}	
															if($level){
															foreach($level as $user){
																$users[15][$aa[15]]=$user['userid'];
																

																$aa[15]++; $level=Downline($user['userid']); 
																if($level){$levels[16]=$levels[16]+count($level);}
																if($level){
																foreach($level as $user){
																	$users[16][$aa[16]]=$user['userid'];
																	

																	$aa[16]++; $level=Downline($user['userid']); 
																	if($level){$levels[17]=$levels[17]+count($level);} 
																	if($level){
																	foreach($level as $user){
																		$users[17][$aa[17]]=$user['userid'];
																		

																		$aa[17]++;$level=Downline($user['userid']); 
																		if($level){$levels[18]=$levels[18]+count($level); }
																		if($level){
																		foreach($level as $user){
																			$users[18][$aa[18]]=$user['userid'];
																			

																			$aa[18]++; $level=Downline($user['userid']); 
																			if($level){$levels[19]=$levels[19]+count($level); }
																			if($level){
																			foreach($level as $user){
																				$users[19][$aa[19]]=$user['userid'];
																				

																				$aa[19]++; $level=Downline($user['userid']);
																				if($level){$levels[20]=$levels[20]+count($level);}
																				if($level){
																				foreach($level as $user){
																					$users[20][$aa[20]]=$user['userid'];
																					

																					$aa[20]++; $level=Downline($user['userid']); 
																					if($level){$levels[21]=$levels[21]+count($level); }
																					if($level){
																					foreach($level as $user){
																						$users[21][$aa[21]]=$user['userid'];
																						
																						
																						$aa[21]++;$level=Downline($user['userid']);
																						if($level){$levels[22]=$levels[22]+count($level); }
																						if($level){
																						foreach($level as $user){
																							$users[22][$aa[22]]=$user['userid'];
																						
																						
																							$aa[22]++;$level=Downline($user['userid']);
																							if($level){$levels[23]=$levels[23]+count($level); }
																							if($level){
																							foreach($level as $user){
																								$users[23][$aa[23]]=$user['userid'];
																						
																						
																								$aa[23]++;$level=Downline($user['userid']);
																								if($level){$levels[24]=$levels[24]+count($level); }
																								if($level){
																								foreach($level as $user){
																									$users[24][$aa[24]]=$user['userid'];
																						
																						
																									$aa[24]++;$level=Downline($user['userid']);
																									if($level){$levels[25]=$levels[25]+count($level); }
																								}
																								}
																							}
																							}
																						}
																						}
																					}
																					}
																				}
																				}
																			}
																			}
																		}
																		}
																	}
																	}
																}
																}
															}
															}
														}
														}
													}
													}
												}
												}
											}
											}
										}
										}
									}		
									}
								}		
								}
							}	
							}
						}	
						}
					}		
					}
				}		
				}
			}	
			}
		}	
		}	
	}
}
	foreach($levels as $level){ $total = $total+$level;}
	return array('s'=>$s,'status'=>$s,'total'=>$total,'level'=>$levels,'users'=>$users);
}















function Uplines($Q=null){
//Input : UserID
$aa=1;
if($Q){$Users[$aa]=UserByUserID($Q);}
else{$Users[$aa]=i;}
	
	
	$Uplines[$aa]=$Users[1]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;
	$Users[$aa]=UserByUserID($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['referby']; $aa++;

	return $Uplines;	
}
//print_r(Uplines());
//print_r(Downlines());






function TeamBusiness($Q=null){
	
$Downlines = Downlines($Q);
	
$B=0;
$Users=$Downlines['users'];	 
 	
	
if($Users){	
	foreach($Users as $Level){		
		if($Level){
			foreach($Level as $UserID){			 
				$User=TotalDeposit($UserID); 	
				$B=$B+$User;				
			}						
		}
	}
}	
	if($B){return d2p($B);}
}



function Team($Q=null){
 
if(!$Q){ $Q=i['userid']; }
if($Q){

	$SQL="SELECT * FROM `Coinpods_team` WHERE `userid` = '".$Q."' LIMIT 1";  
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 
	return $ts[0];
	
}
	 
}



function CreateTeam($Q=null){
//Input : userid == HX001
//Output : Downlines
	
$Output=[];
	
if(!$Q){ $Q=i['userid']; }

$User=UserByUserID($Q);
 
if($User){
	$echo='User found with userid';
	
	if(!$User['TeamProcessing']){
		$echo='Team is not under processing';
		
		//$Team=Team($Q);	
		if(!$Team){  
			$echo='Team not found in database';
			
			$SQLL="UPDATE `Coinusers` SET `TeamProcessing` = '1' WHERE `Coinusers`.`ID` = '".i['id']."';";
			global $DB;	$Process = mysqli_query($DB, $SQLL);
			
			$Downlines=Downlines($Q); $Output=$Downlines;
			 
	
$SQL="INSERT INTO `Coinpods_team` (`id`, `name`, `created`, `modified`, `userid`, `user`, `members`, `business`, `stake`, `ccc`, `json`) VALUES ('".$User['ID']."', '".$User['userid']."', current_timestamp(), current_timestamp(), '".$User['userid']."', '".$User['ID']."', '".$Downlines['total']."', '0', '0', '0', '".json_encode($Downlines)."');";
//global $DB;	$results = mysqli_query($DB, $SQL);	
			
			if($results or 1){
				$SQLL="UPDATE `Coinusers` SET `TeamProcessing` = '0' WHERE `Coinusers`.`ID` = '".i['id']."';";
				global $DB;	$Process = mysqli_query($DB, $SQLL);
			}
		}
		else{ 
			
			$echo='Team already found in database';
			
			$SQLL="UPDATE `Coinusers` SET `TeamProcessing` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."';";
			global $DB;	$Process = mysqli_query($DB, $SQLL);
			
			$Downlines=Downlines($Q); $Output=$Downlines;
			
			
			
			$SQLL="UPDATE `Coinpods_team` SET `members` = '".$Downlines['total']."', `json` = '".json_encode($Downlines)."' WHERE `Coinpods_team`.`userid` = '".$Q."';";
			global $DB;	$results = mysqli_query($DB, $SQLL);
			
			
			if($results){
				$SQLL="UPDATE `Coinusers` SET `TeamProcessing` = '0' WHERE `Coinusers`.`ID` = '".$User['ID']."';";
				global $DB;	$Process = mysqli_query($DB, $SQLL);
				$echo = 'Team Creation Done';
			}
			
			
			
			
		}
	}
	else{ $echo='Team is under processing'; }
	
}
else{ $echo = 'No User found with this user ID';  }
	

return $Output;	
}




function UpdateTeamStake($Q=null){
	
if(i['id']){
if($Q){	

	$SQL="UPDATE `Coinpods_team` SET `stake` = '".$Q."' WHERE `Coinpods_team`.`user` = '".i['id']."';";
	global $DB;	$results = mysqli_query($DB, $SQL);	

}
}
}



?>
