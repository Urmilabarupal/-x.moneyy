<?php





function SubordinateHistoryUpdateNew($Q=null){
	// Developer : JAspal Byavat
	// Date : 24-06-2025
	// Input :NULL
	// Engine : Update and New Subordinate History By UID and Using Interval 
	// Output : SQL For Information 
	
	die;
	import('MLM');
	$Sub_Object = new Subordinate();
	$Date = gmdate('Ymd');
	$Interval = Interval($Date);
	
	$SQL = "SELECT * FROM `Coinpods_user` WHERE `subordinate_history` = 0 LIMIT 100";
	global $DB;$aa = 0;	$ts=[];$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$Users = '';
	$Users = $ts;
	if(!empty($Users)){
		$echo = ' Pending Users Found.';
		foreach($Users as $User){
			if(!empty($User)){
				$echo = 'Each User Found.';
				$Array = ['subordinate'=> $User['user']];
				$Uplines = $Sub_Object->Subordinates($Array);unset($Array); //print_r($Uplines);
				if(!empty($Uplines)){
					$echo = 'Uplines Found.';
					foreach($Uplines as $Upline){
						if($Upline){
							$echo = 'Upline Found.';
							$IntervalProcess=$IntervalSuccess=$IntervalFaild=0;
							if($Interval){
								$echo = 'Interval Data Found.';
								foreach($Interval as $I => $Val){
									
									
									if($I=='day_this' or $I=='week_this' or $I=='month_this' or $I=='year_this' or $I=='all'){
										$echo = 'Interval Is Correct.';
										$IntervalProcess++;
										$IntervalUID = $Val['uid'];	
										$TeamUID = App['id'].':'.$Upline['user'].':'.$IntervalUID.':COUNT:Subordinate:Team:CCC_CCC';
										
										if($Upline['level'] == 1){
											$IntervalProcess+=1;
											$echo = 'Level 1 it Means Process Direct UIDs';
											$DirectUID = App['id'].':'.$Upline['user'].':'.$IntervalUID.':COUNT:Subordinate:Direct:CCC_CCC';
										}
										
										if($DirectUID or $TeamUID){	
											$echo = 'UIDs Found.';
											$DirectSubordinate_History = Subordinate_History($DirectUID)['o'];
											$TeamSubordinate_History = Subordinate_History($TeamUID)['o'];
											
											$echo = '# Team Data Processing.';	
											if($TeamSubordinate_History){
												$echo = 'Team Subordinate History Found.';
												
												$NewValue = $TeamSubordinate_History['value']+1;
												$Array = ['uid'=>$TeamUID , 'value'=>$NewValue];
												$TeamSubordinate_HistoryUpdate = Subordinate_HistoryUpdate($Array)['o'];unset($Array);
												if($TeamSubordinate_HistoryUpdate){$IntervalSuccess++;}else{$IntervalFaild++;}
												unset($TeamSubordinate_HistoryUpdate,$TeamUID,$NewValue);
											}
											else{
												$echo = '# Team Subordinate History Not Found , Create New With Value';
												
												$Array = [ 'uid'=>$TeamUID , 'value'=>1, 'user'=>$Upline['user'] ];
												$TeamSubordinate_HistoryNew = Subordinate_HistoryNew($Array)['s'];unset($Array);
												if($TeamSubordinate_HistoryNew){$IntervalSuccess++;}else{$IntervalFaild++;}
												$echo = '#* Team Subordinate History Not Found , Create New With Value';
												unset($TeamSubordinate_HistoryNew,$TeamUID);
											}
											$echo = '#* Team Data Processing.';	
											
											unset($TeamSubordinate_History);
											
											$echo = '# Direct Data Processing.';	
											if($DirectSubordinate_History){
												$echo = 'Direct Subordinate History Found.';
												
												$NewValue = $DirectSubordinate_History['value']+1;
												$Array = ['uid'=>$DirectUID , 'value'=>$NewValue];
												$DirectSubordinate_HistoryUpdate = Subordinate_HistoryUpdate($Array)['o'];unset($Array);
												if($DirectSubordinate_HistoryUpdate){$IntervalSuccess++;}else{$IntervalFaild++;}
												unset($DirectSubordinate_HistoryUpdate,$NewValue,$DirectUID);
											}
											else{
												$echo = '# Direct Subordinate History Not Found , Create New With Value';
												
												$Array = [ 'uid'=>$DirectUID , 'value'=>1, 'user'=>$Upline['user'] ];
												$DirectSubordinate_HistoryNew = Subordinate_HistoryNew($Array)['s'];unset($Array);
												if($DirectSubordinate_HistoryNew){$IntervalSuccess++;}else{$IntervalFaild++;}
												unset($DirectSubordinate_HistoryNew,$DirectUID);
												$echo = '#* Direct Subordinate History Not Found , Create New With Value';
											}
											$echo = '#* Direct Data Processing.';
											
											unset($DirectSubordinate_History);
											
										}
										else{$echo = 'UIDs Not Found.';}
									}
									else{$echo = 'Incorrect Interval.';}
								}  
								
								if($IntervalProcess == $IntervalSuccess){ $Status = 1; }else{$Status = 2;}
							}
							else{$echo = 'Interval Data Not Found.';}
						}
						else{$echo = 'Upline Not Found.';}
					}
				}
				else{$echo = 'Uplines Not Found.';}
				
				if($Status){
					$echo = 'Status Value Found.';
					$SQLUpdate = "UPDATE `Coinpods_user` SET `subordinate_history` = '".$Status."' WHERE `Coinpods_user`.`id` = '".$User['user']."';";
					$Results = mysqli_query($DB, $SQLUpdate);
					
					echo 'User : '.$User['user'].' == '.$SQLUpdate.'<br>';	
				}
				else{$echo = 'Status Value Not Found.';}

			}
			else{$echo = 'Each User Not Found.';}
		}
	}
	else{$echo = 'No Pending Users.';}
}






function Subordinate_History($UID=NULL,$Table = 'subordinate_history',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Subordinate_Histories($Array=[],$NewConditions=[],$SQL=false){
	

$NewArray=$Filter=[];
	
$Date = [];	
	
if(!$NewConditions){
$echo = 'input Data Not According New System Proccssing to old system.';	
foreach($Array as $Key => $Value){
$echo = 'Yha par har array ki keys and values ko new Rows plural function k aacording peramiters create kiye ja rhe hai ';
				if(!empty($Key) and !empty($Value)){
					$echo  = 'Key And Value Found.';

	
if($Key == 'SELECT' or $Key == 'HAVING' or $Key == 'GROUP BY' or $Key == 'method' or $Key == 'methodcolumn' or $Key == 'LIMIT' or $Key == 'OFFSET' or $Key == 'sort' or $Key == 'sort_column'){
	$Filter[$Key]=$Value; 
	$echo = 'store Methods and extra filter in filter array';
}
	elseif($Key == 'created_min'){
		$Date = ['created' => ['oprator'=> 'BETWEEN' , 'value1'=>$Value, 'value2'=>'']]; 
		$echo = 'store BETWEEN First value in conditions array';
	}
	elseif($Key == 'created_max'){
		$Date['created']['value2'] =  $Value;
		$echo = 'store BETWEEN Second value in conditions array';
	}
	else{$NewArray[$Key] = ['oprator'=> '=' , 'value1'=>$Value, 'value2'=>''];
		 $echo = 'Store  All Values and keys in Conditions array';
		}
 }
 else{$echo = 'Key And Value Not Found.';}

}
	}
	else{$echo = 'New System According Data Input';}
	
	
	$Filter['table'] = 'subordinate_history';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Subordinate_HistoryUpdate($Array=[],$NewConditions=[],$Table='subordinate_history', $SQLData=false){

	
$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';

	 if($Table){$TableName=$Table;}else{$TableName='Write Table Name ';} 
	
	$Conditions = [];
	if(empty($NewConditions)){
		
	if(!empty($Array['uid'])){
		$Conditions['uid'] = ['oprator'=> '=' , 'value1'=>$Array['uid'], 'value2'=>''];
		$echo = 'kis Value k according set krna h vo yha pr setup kiya hai';
		
		unset($Array['uid']);
		$echo = ' Original array se uid remove karna';
	}
	else{$echo = 'kis value k according data update kre please pass value , like uid ya id';}
	
	
	if(!empty($Array['id'])){
		$Conditions['id'] = ['oprator'=> '=' , 'value1'=>$Array['id'], 'value2'=>''];
		$echo = 'kis Value k according set krna h vo yha pr setup kiya hai';
		
		unset($Array['id']);
		$echo = ' Original array se id remove karna';
	}
	else{$echo = 'kis value k according data update kre please pass value , like uid ya id';}
	}
	else{$Conditions = $NewConditions;$echo = 'Input Data Is New Conditions According';}
	
		
	
	if($TableName){return RowUpdate($Array, $Conditions,$TableName, $SQLData);}else{$echo = 'Table Name Is Required.';}
	//echo $echo;
}	
	
	
	
	
	
function Subordinate_HistoryStatus($UID=NULL,$Status = NULL,$Table = 'subordinate_history',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Subordinate_HistoryNew($Array=[],$Table = 'subordinate_history',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}
 





###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################
###############################################################################################################################################








function HistoryUpdateNew($Q=null){
	
	// Developer : Sahiram Nayak
	// Date : 18-06-2025
	// Input :$Array=['feature'=>'Deposit','pair'=>'CCC_CCC','user'=>'2','amount'=>'100',];
	// Output : UIds ke according Update and insert karega 
	
	
    if('2025-07-07'>=gmdate('Y-m-d')){ 
	
	$DB_Object = import('DB');
	$results=0; $Function=$Self=[]; $Return=[];
	if(is_array($Q)){ $Feature=$Q['feature']; $User=$Q['user']; $Pair=$Q['pair']; $Amount=$Q['amount']; }
	
	if($Feature && $User && $Pair && $Amount){
		$echo = 'Required Data Found';
		
		$FeatureName = strtolower($Feature).'_history';
		$DBData = [];$DBName = '';
		
		$DBName=strtolower(App['name'].'.'.$FeatureName);
		$DBData = DB($DBName)['o'];
		
		if($DBData){
			$echo = 'Feature Found in system.';
			
			if($DBData['status'] == 1){
				$echo = 'Feature Enable in system.';
				
				
				$Array=['feature'=>$Feature,'user'=>$User,'pair'=>$Pair,'amount'=>$Amount,'featurename'=>$FeatureName,'type'=>'Self'];
				$HistoryUpdateNew___UIDs=HistoryUpdateNew___UIDs($Array);
				if($HistoryUpdateNew___UIDs['S']){ $Self['Self']=$HistoryUpdateNew___UIDs['echo']; }
				
				if(0){
				
				$Array['type']='Direct';
				$HistoryUpdateNew___Direct=HistoryUpdateNew___UIDs($Array);
				if($HistoryUpdateNew___Direct['S']){ $Self['Direct']=$HistoryUpdateNew___Direct['echo']; }

				
				$Array['type']='Team';
				$HistoryUpdateNew___Team=HistoryUpdateNew___UIDs($Array);
				if($HistoryUpdateNew___Direct['S']){ $Self['Team']=$HistoryUpdateNew___Team['echo']; }
					
				}
			}
			else{$echo = 'Feature Not Enable in system.';}
		}
		else{$echo = 'Feature Not Found in system.';}
	}
	else{ $echo = 'Required Data Not Found'; }
	
	
	}
	$Return = ['logs'=>$echo , 'function'=>$Self];
	return $Return;
	//echo $echo;
}



function HistoryUpdateNew___UIDs($Q=null){
		
	// Developer : Sahiram Nayak
	// Date : 18-06-2025
	// Input :$Array=['feature'=>'Deposit','pair'=>'CCC_CCC','user'=>'2','amount'=>'100','type'=>'Self'];
	// Output : UIds ke according Update and insert karega 
	
	$echo ='';
	$Return=$Function=[];
	$S=0;
	if(is_array($Q)){
		$Feature=$Q['feature']; $FeatureName=$Q['featurename']; $User=$Q['user']; $Pair=$Q['pair']; $Amount=$Q['amount']; $Type=$Q['type'];
	}
	
	if($Feature && $User && $Pair && $Amount && $Type){
		
		$echo ="All data required found.";
		
		$UIDs=UIDs_Theme($Feature,$User,$Pair)[$Type];
		$echo ="Generate all UIDs of  ".$Type.".";
		
		
		if($UIDs){
			$echo ="UIDs   ".$Type." found.";
			
			foreach($UIDs as $Self_UID){
				
				if($Self_UID){
					$echo = $Type." UID found.";
					
					$Date = gmdate('Ymd');
					$UID = $Self_UID;
					
				
					$Row = Row($UID,$FeatureName,0)['o'];
					$echo ="Fetch data from   ".$Feature."  history using UID.";
					
					
					if(is_array($Row)){
						$echo = 'this uid history Found In System.';
						$Value=0;
						$EX=explode(':',$Self_UID);
					 	if($EX[4]=='COUNT'){ $Value=$Row['value']+1; }
					 	else{ $Value=$Row['value']+$Amount; }
						 
						$Array1 = array( 'value'=>$Value,'amount'=>$Value);	
						$Array2 = array('uid'=>[ 'oprator'=>'=',  'value1'=>$UID,'value2'=>'' ]);
						
						$RowUpdate = RowUpdate($Array1,$Array2,$FeatureName,true); unset($Array1,$Array2);
						$Function[]=$RowUpdate;
					
						if($RowUpdate['o']){
							$S=1;
							 $echo = $Type." ".$Feature." History Update Success.";
						}
						else{ $S=0; $echo = 'Not Update.'; }
					}
					else{
						$echo = $Type." ".$Feature." history not found in the system. Try to create a new one.";
						$EX=explode(':',$Self_UID);
						
						$Array=['feature'=>$Feature,'uid'=>$Self_UID,'amount'=>$Amount,'user'=>$EX[1],'pair'=>$EX[7],];
						 
						$HistoryNew = HistoryNew($Array);
						$Function[]=$HistoryNew;
 						
						if($HistoryNew['function']){
							$S=1;
 							
							$echo = $Type."  ".$Feature."  History Insert Success.";
						}
						else{ $S=0; $echo = 'Not Insert.'; }
						
						
						$echo = $Type." ".$Feature." history not found in the system. Try to create a new one.";
					}
				}
				else{ $echo = $Type."  UID not found."; }
			}
		}
		else{ $echo ="UIDs   ".$Type."  not found."; }
	}
	else{ $echo ="All data required not found."; }
	$Return = ['echo'=>$echo,'S'=>$S,'O'=>$Function,];
	return $Return;
}


function HistoryNew($Q=null){
	
	// Developer : Sahiram Nayak
	// Date : 18-06-2025
	// Input :$Array=['feature'=>'Deposit','pair'=>'CCC_CCC','user'=>'2','amount'=>'100','uid'=>'uid','pair'=>'CCC_CCC'];
	// Output : UIds ke according insert karega 
	
	$DB_Object = import('DB');	
	$results=0;
	if(is_array($Q)){
		$echo = 'Feature name found';
	 
		if($Q['feature'] and $Q['uid'] and $Q['amount'] and $Q['user'] and $Q['pair']){
			$echo = 'Required Data Found';
			 
			$FeatureName = strtolower($Q['feature']).'_history';
			$DBData = [];$DBName = '';
			
			$DBName=strtolower(App['name'].'.'.$FeatureName);
			$DBData = DB($DBName)['o'];
			
			if($DBData){
				$echo = 'Feature Found in system.';
				
				
				
				if($DBData['status'] == 1){
					$echo = 'Feature Enable in system.';
					
					$Created = GMT();
					$echo ="Created date.";
					$Date = gmdate('Ymd');
					$Year=gmdate("Y"); $Month=gmdate("m"); $Daily=gmdate("d"); 
					$Time=gmdate("H:i:s"); $Second=gmdate("s"); $Millisecond=microtime(true)*1000;
					$Millisecond=round($Millisecond,0); $Hour=gmdate("H"); $Minute=gmdate("i");
					
					$Q['uid'] = $Q['uid'];
					$EX=explode(':',$Q['uid']);
					
					if($EX[4]=='COUNT'){ $Value=$Row['value']+1; }
					else{ $Value=$Row['value']+$Q['amount']; }
					$Aap=App['id'];
					
				  
					
					$Array = array(
						'user'=>$Q['user'], 'uid'=>$Q['uid'], 'ttype'=>$Q['feature'], 'value'=>$Value,
						'amount'=>$Value, 'created'=>$Created,'ccc'=>$Q['pair'],'date'=>$Date,'time'=>$Time, 
						'year'=>$Year, 'month'=>$Month,'datee'=>$Daily,'hour'=>$Hour,'minute'=>$Minute,'app'=>$Aap,
						'second'=>$Second, 'milliseconds'=>$Millisecond,'period'=>explode(':',$Q['uid'])[2],'status'=>1
					);
					$RowNew = RowNew($Array,$FeatureName,true)['s'];
					
					if($RowNew['s']){ $echo = 'Inserted Success.'; }
					else{$echo = 'Not Insert.';}
				}
				else{$echo = 'Feature Not Enable in system.';}
			}
			else{$echo = 'Feature Not Found in system.';}
		}
		else{ $echo = 'Required Data Not Found'; }
	}
	else{$echo = 'feature name is required.';}
	$Return=[];
	$Return = ['logs'=>$echo , 'function'=>$RowNew];
	return $Return;
	//echo $echo;
}



 
 


function UIDs_Theme($Feature=null,$User=null,$Pair=null){
	// Developer : Sahiram Nayak
	// Date : 18-06-2025
	// Input : $Feature=null,$User=null,$Pair=null
	// Output : Uids generate Hogi Self, Direct, Team 	
	$echo = '';
	$Return=[];
	
	if($Feature && $User && $Pair){
		$echo = "Feature and user found.";
		
		$Args = ['feature' => $Feature,'pair'=>$Pair, 'LIMIT' => 100];
		$History_Settings = History_Settings($Args)['o'];
		
		if($History_Settings){
			$echo = 'All History Settings Found.';
			
			$Self_All=$Direct_All=$Team_All=[];
			
			foreach($History_Settings as $HS){
				$echo = "Single History found.";
				
				$Pair = $HS['pair'];
				$AppID = App['id'];
				$Types=['COUNT', 'SUM'];
				
				$Interval=Interval();
				$All=$Interval['all']['uid'];
				$Day=$Interval['day_this']['uid'];
				$Week=$Interval['week_this']['uid'];
				$Month=$Interval['month_this']['uid'];
				$Year=$Interval['year_this']['uid'];
				
				$Periods=[$All, $Day, $Week, $Month, $Year];
				
				foreach($Types as $Type){
					foreach($Periods as $Period){
						$Self_All[] = "$AppID:$User:$Period:$Type:$Feature:Self:$Pair";
                    }
                }

                $Filter=['table'=>'subordinate','LIMIT'=>'11111','sort' =>'ASC','sort_column'=>'id'];
                $Conditions=['subordinate'=>['oprator'=>'=','value1'=>$User,'value2'=>'']];
				
				$Subordinates = Rows($Filter, $Conditions, 0)['o'];

                if($Subordinates){
					$echo = "Subordinates found.";
					
					foreach($Subordinates as $SB){
						$SB_User = $SB['user'];
						
						if($SB['level']==1){
							
							foreach($Types as $Type){
								
                                foreach($Periods as $Period){
									$Direct_All[] = "$AppID:$SB_User:$Period:$Type:$Feature:Direct:$Pair";
								}
							}
                        }

                        foreach($Types as $Type){
							
							foreach ($Periods as $Period){
								
								$Team_All[] = "$AppID:$SB_User:$Period:$Type:$Feature:Team:$Pair";
							}
                        }
                    }
				} 
				else { $echo = "Subordinates not found."; }
            }
			
			$Return = ['Self'=>$Self_All,'Direct'=>$Direct_All,'Team'=>$Team_All];
        }
		else{ $echo = 'All History Settings Not Found.'; }
    }
	else{ $echo = "Feature and user not found."; }

    return $Return;
}













function History_Settings($Array=[],$NewConditions=[],$SQL=false){
	
	$NewArray=$Filter=[];
	
	if(!$NewConditions){
		$echo = 'input Data Not According New System Proccssing to old system.';	
		foreach($Array as $Key => $Value){
			$echo = 'Yha par har array ki keys and values ko new AIO plural function k aacording peramiters create kiye ja rhe hai ';
			if(!empty($Key) and !empty($Value)){
				$echo  = 'Key And Value Found.';
				
				if($Key == 'SELECT' or $Key == 'HAVING' or $Key == 'GROUP BY' or $Key == 'method' or $Key == 'methodcolumn' or $Key == 'LIMIT' or $Key == 'OFFSET' or $Key == 'sort' or $Key == 'sort_column'){
					$Filter[$Key]=$Value; 
					$echo = 'store Methods and extra filter in filter array';
				}
				elseif($Key == 'created_min'){
					$Date = ['created' => ['oprator'=> 'BETWEEN' , 'value1'=>$Value, 'value2'=>'']]; 
					$echo = 'store BETWEEN First value in conditions array';
				}
				elseif($Key == 'created_max'){
					$Date['created']['value2'] =  $Value;
					$echo = 'store BETWEEN Second value in conditions array';
				}
				else{$NewArray[$Key] = ['oprator'=> '=' , 'value1'=>$Value, 'value2'=>''];
					 $echo = 'Store  All Values and keys in Conditions array';
					}
			}
			else{$echo = 'Key And Value Not Found.';}
		}
	}
	else{$echo = 'New System According Data Input';}
	
	
	$Filter['table'] = 'history_setting';
	
	if($Date){ $Conditions = array_merge($NewArray,$Date); } else{ $Conditions = $NewArray; } 
	
	if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
	return  Rows($Filter, $Conditions, $SQL);
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 ?>