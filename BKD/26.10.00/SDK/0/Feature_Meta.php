<?php Access(); ?>
<?php

$PHP['Feature_Meta']['modified'] = '2025/06/06';
$PHP['Feature_Meta']['by'] = '';

$PHP['Feature_Meta']['function'][1] = 'TeamStaking_Meta($UID=null)';
$PHP['Feature_Meta']['function'][2] = 'TeamStaking_Metas($Q=null)';
$PHP['Feature_Meta']['function'][3] = 'TeamStaking_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][4] = 'TeamStaking_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][5] = 'TeamStaking_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][6] = 'Staking_Convert_Meta($UID=null)';
$PHP['Feature_Meta']['function'][7] = 'Staking_Convert_Metas($Q=null)';
$PHP['Feature_Meta']['function'][8] = 'Staking_Convert_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][9] = 'Staking_Convert_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][10] = 'Staking_Convert_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][11] = 'Staking_Meta($UID=null)';
$PHP['Feature_Meta']['function'][12] = 'Staking_Metas($Q=null)';
$PHP['Feature_Meta']['function'][13] = 'Staking_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][14] = 'Staking_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][15] = 'Staking_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][16] = 'Lottery_Win_Meta($UID=null)';
$PHP['Feature_Meta']['function'][17] = 'Lottery_Win_Metas($Q=null)';
$PHP['Feature_Meta']['function'][18] = 'Lottery_Win_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][19] = 'Lottery_Win_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][20] = 'Lottery_Win_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][21] = 'Lottery_Ticket_Meta($UID=null)';
$PHP['Feature_Meta']['function'][22] = 'Lottery_Ticket_Metas($Q=null)';
$PHP['Feature_Meta']['function'][23] = 'Lottery_Ticket_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][24] = 'Lottery_Ticket_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][25] = 'Lottery_Ticket_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][26] = 'Deposit_Meta($UID=null)';
$PHP['Feature_Meta']['function'][27] = 'Deposit_Metas($Q=null)';
$PHP['Feature_Meta']['function'][28] = 'Deposit_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][29] = 'Deposit_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][30] = 'Deposit_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][31] = 'Withdraw_Meta($UID=null)';
$PHP['Feature_Meta']['function'][32] = 'Withdraw_Metas($Q=null)';
$PHP['Feature_Meta']['function'][33] = 'Withdraw_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][34] = 'Withdraw_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][35] = 'Withdraw_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][36] = 'Level_Meta($UID=null)';
$PHP['Feature_Meta']['function'][37] = 'Level_Metas($Q=null)';
$PHP['Feature_Meta']['function'][38] = 'Level_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][39] = 'Level_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][40] = 'Level_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][41] = 'TeamStaking_Income_Meta($UID=null)';
$PHP['Feature_Meta']['function'][42] = 'TeamStaking_Income_Metas($Q=null)';
$PHP['Feature_Meta']['function'][43] = 'TeamStaking_Income_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][44] = 'TeamStaking_Income_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][45] = 'TeamStaking_Income_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][46] = 'Income_RewardMonthly_Meta($UID=null)';
$PHP['Feature_Meta']['function'][47] = 'Income_RewardMonthly_Metas($Q=null)';
$PHP['Feature_Meta']['function'][48] = 'Income_RewardMonthly_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][49] = 'Income_RewardMonthly_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][50] = 'Income_RewardMonthly_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][51] = 'Spot_Trade_Meta($UID=null)';
$PHP['Feature_Meta']['function'][52] = 'Spot_Trade_Metas($Q=null)';
$PHP['Feature_Meta']['function'][53] = 'Spot_Trade_MetaUpdate($Q=null)';
$PHP['Feature_Meta']['function'][54] = 'Spot_Trade_MetaNew($Q=null)';
$PHP['Feature_Meta']['function'][55] = 'Spot_Trade_MetaStatus($Q=null)';
$PHP['Feature_Meta']['function'][56] = 'LiveData___Feature_Meta($Array=[])';






function LiveData___Feature_Meta___Direct_Team($Array=[]){
	#Developer: JAspal Byavat
	#Date [dd-mm-yy]: 11-06-2025
	#Engine: 
	# 1. Create UIDs Of according Feature_meta 
	# 2. Fetch old Data According UID
	# 3. Set Veriables and then Update Self Data in Feture_Meta table 
	# Input: $Input = ['feature'=>'Level','amount'=>'1000','pair'=>'USDT_USDT','user'=>1];
	# Output: Massage With Logs 
	
	import('MLM','Subordinate');	
	$Subordinate_Object = new Subordinate();
	//print_r($Subordinate_Object);
	
	if(is_array($Array) and !empty($Array)){
		$echo = 'Array Not Empty Continue...';
		
		$FeatureName  = $Array['feature'];
		$Amount  = $Array['amount'];
		$Pair  = strtoupper($Array['pair']);
		$User  = $Array['user'];
		
		$FunctionSelect = $Array['feature'].'_Meta';
		$FunctionUpdate = $Array['feature'].'_MetaUpdate';
		
		
		
		$SubArray = [ 'subordinate'=>$User ];
		$Uplines = $Subordinate_Object->Subordinates($SubArray);	
		
		
		if($Uplines){
			$echo = 'Uplines Found';
			
			$Return = [];
			foreach($Uplines as $Upline){
				$echo = 'Foreach Every upline';
				
				$User = $Upline['user'];
				
				
				if($FeatureName and $Amount and $Pair and $User){
					$echo = 'feature name , pair , user and amount is available.';
					
					$echo = '#Try To Create COUNT UID';
					$UID_COUNT_Day = App['id'].':'.$User.':Day:COUNT:'.$FeatureName.':Team:'.$Pair;
					$UID_COUNT_Week = App['id'].':'.$User.':Week:COUNT:'.$FeatureName.':Team:'.$Pair;
					$UID_COUNT_Month = App['id'].':'.$User.':Month:COUNT:'.$FeatureName.':Team:'.$Pair;
					$UID_COUNT_Year = App['id'].':'.$User.':Year:COUNT:'.$FeatureName.':Team:'.$Pair;
					$UID_COUNT_All = App['id'].':'.$User.':All:COUNT:'.$FeatureName.':Team:'.$Pair;
					$echo = '#*Try To Create COUNT UID';
					
					$echo = '#Try To Create SUM UID';
					$UID_SUM_Day = App['id'].':'.$User.':Day:SUM:'.$FeatureName.':Team:'.$Pair;
					$UID_SUM_Week = App['id'].':'.$User.':Week:SUM:'.$FeatureName.':Team:'.$Pair;
					$UID_SUM_Month = App['id'].':'.$User.':Month:SUM:'.$FeatureName.':Team:'.$Pair;
					$UID_SUM_Year = App['id'].':'.$User.':Year:SUM:'.$FeatureName.':Team:'.$Pair;
					$UID_SUM_All = App['id'].':'.$User.':All:SUM:'.$FeatureName.':Team:'.$Pair;
					$echo = '#*Try To Create SUM UID';
					
					
					
					$echo = '#Try To Fetch Every SUM UID Data';
					$SUM_DayData = $FunctionSelect($UID_SUM_Day)['o']; // ,'level_meta',true
					$SUM_WeekData = $FunctionSelect($UID_SUM_Week)['o'];
					$SUM_MonthData = $FunctionSelect($UID_SUM_Month)['o'];
					$SUM_YearData = $FunctionSelect($UID_SUM_Year)['o'];
					$SUM_AllData = $FunctionSelect($UID_SUM_All)['o'];
					$echo = '#*Try To Fetch Every SUM UID Data';
					
					
					
					$echo = '#Try To Fetch Every COUNT UID Data';
					$COUNT_DayData = $FunctionSelect($UID_COUNT_Day)['o']; // ,'level_meta',true
					$COUNT_WeekData = $FunctionSelect($UID_COUNT_Week)['o'];
					$COUNT_MonthData = $FunctionSelect($UID_COUNT_Month)['o'];
					$COUNT_YearData = $FunctionSelect($UID_COUNT_Year)['o'];
					$COUNT_AllData = $FunctionSelect($UID_COUNT_All)['o'];
					$echo = '#*Try To Fetch Every COUNT UID Data';
					
					$echo = '#Try To Update Every SUM UID Data';		
					
					$NewValue = $SUM_DayData['value']+$Amount;
					$Array = ['uid'=>$UID_SUM_Day,'value'=>$NewValue];		
					$SUM_Day_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($SUM_Day_Update){ $Return[$User]['Team']['DaySum']='Succuss';}else{$Return[$User]['Team']['DaySum']='Faild';}
					
					$NewValue = $SUM_WeekData['value']+$Amount;
					$Array = ['uid'=>$UID_SUM_Week,'value'=>$NewValue];		
					$SUM_Week_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($SUM_Week_Update){ $Return[$User]['Team']['WeekSum']='Succuss';}else{$Return[$User]['Team']['WeekSum']='Faild';}	
					
					$NewValue = $SUM_MonthData['value']+$Amount;
					$Array = ['uid'=>$UID_SUM_Month,'value'=>$NewValue];		
					$SUM_Month_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($SUM_Month_Update){ $Return[$User]['Team']['MonthSum']='Succuss';}else{$Return[$User]['Team']['MonthSum']='Faild';}	
					
					$NewValue = $SUM_YearData['value']+$Amount;
					$Array = ['uid'=>$UID_SUM_Year,'value'=>$NewValue];		
					$SUM_Year_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($SUM_Year_Update){ $Return[$User]['Team']['YearSum']='Succuss';}else{$Return[$User]['Team']['YearSum']='Faild';}	
					
					$NewValue = $SUM_AllData['value']+$Amount;
					$Array = ['uid'=>$UID_SUM_All,'value'=>$NewValue];		
					$SUM_All_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($SUM_All_Update){ $Return[$User]['Team']['AllSum']='Succuss';}else{$Return[$User]['Team']['AllSum']='Faild';}	
					$echo = '#*Try To Update Every SUM UID Data';	
					
					
					$echo = '#Try To Update Every COUNT UID Data';		
					
					$NewValue = $COUNT_DayData['value']+1;
					$Array = ['uid'=>$UID_COUNT_Day,'value'=>$NewValue];		
					$COUNT_Day_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($COUNT_Day_Update){ $Return[$User]['Team']['DayCOUNT']='Succuss';}else{$Return[$User]['Team']['DayCOUNT']='Faild';}
					
					$NewValue = $COUNT_WeekData['value']+1;
					$Array = ['uid'=>$UID_COUNT_Week,'value'=>$NewValue];		
					$COUNT_Week_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($COUNT_Week_Update){ $Return[$User]['Team']['WeekCOUNT']='Succuss';}else{$Return[$User]['Team']['WeekCOUNT']='Faild';}	
					
					$NewValue = $COUNT_MonthData['value']+1;
					$Array = ['uid'=>$UID_COUNT_Month,'value'=>$NewValue];		
					$COUNT_Month_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($COUNT_Month_Update){ $Return[$User]['Team']['MonthCOUNT']='Succuss';}else{$Return[$User]['Team']['MonthCOUNT']='Faild';}	
					
					
					$NewValue = $COUNT_YearData['value']+1;
					$Array = ['uid'=>$UID_COUNT_Year,'value'=>$NewValue];		
					$COUNT_Year_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($COUNT_Year_Update){ $Return[$User]['Team']['YearCOUNT']='Succuss';}else{$Return[$User]['Team']['YearCOUNT']='Faild';}	
					
					$NewValue = $COUNT_AllData['value']+1;
					$Array = ['uid'=>$UID_COUNT_All,'value'=>$NewValue];		
					$COUNT_All_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
					if($COUNT_All_Update){ $Return[$User]['Team']['AllCOUNT']='Succuss';}else{$Return[$User]['Team']['AllCOUNT']='Faild';}
					
					$echo = '#*Try To Update Every COUNT UID Data';	
					
						$echo = '#Unset All Veriables Value [free memory] ';
						unset($SUM_DayData,$SUM_WeekData,$SUM_MonthData,$SUM_YearData,$SUM_AllData,$COUNT_DayData,$COUNT_WeekData,
							  $COUNT_MonthData,$COUNT_YearData,$COUNT_AllData,$UID_COUNT_Day,$UID_COUNT_Week,$UID_COUNT_Month,$UID_COUNT_Year,
							  $UID_COUNT_All,$SUM_AllData,$UID_SUM_Day,$UID_SUM_Week,$UID_SUM_Month,$UID_SUM_Year,$UID_SUM_All);
						$echo = '#*Unset All Veriables Value [free memory] ';	
					
				}
				else{$echo = 'feature name , pair ,user and amount is required.';}
				
				
				
				
				
				$echo = '# Direct Data Update.';
				
				if($Upline['level'] == 1){
					$echo = 'Upline Level found';
					
					if($FeatureName and $Amount and $Pair and $User){
						$echo = 'feature name , pair , user and amount is available.';
						
						$echo = '#Try To Create COUNT UID';
						$UID_COUNT_Day = App['id'].':'.$User.':Day:COUNT:'.$FeatureName.':Direct:'.$Pair;
						$UID_COUNT_Week = App['id'].':'.$User.':Week:COUNT:'.$FeatureName.':Direct:'.$Pair;
						$UID_COUNT_Month = App['id'].':'.$User.':Month:COUNT:'.$FeatureName.':Direct:'.$Pair;
						$UID_COUNT_Year = App['id'].':'.$User.':Year:COUNT:'.$FeatureName.':Direct:'.$Pair;
						$UID_COUNT_All = App['id'].':'.$User.':All:COUNT:'.$FeatureName.':Direct:'.$Pair;
						$echo = '#*Try To Create COUNT UID';
						
						$echo = '#Try To Create SUM UID';
						$UID_SUM_Day = App['id'].':'.$User.':Day:SUM:'.$FeatureName.':Direct:'.$Pair;
						$UID_SUM_Week = App['id'].':'.$User.':Week:SUM:'.$FeatureName.':Direct:'.$Pair;
						$UID_SUM_Month = App['id'].':'.$User.':Month:SUM:'.$FeatureName.':Direct:'.$Pair;
						$UID_SUM_Year = App['id'].':'.$User.':Year:SUM:'.$FeatureName.':Direct:'.$Pair;
						$UID_SUM_All = App['id'].':'.$User.':All:SUM:'.$FeatureName.':Direct:'.$Pair;
						$echo = '#*Try To Create SUM UID';
						
						
						
						$echo = '#Try To Fetch Every SUM UID Data';
						$SUM_DayData = $FunctionSelect($UID_SUM_Day)['o']; // ,'level_meta',true
						$SUM_WeekData = $FunctionSelect($UID_SUM_Week)['o'];
						$SUM_MonthData = $FunctionSelect($UID_SUM_Month)['o'];
						$SUM_YearData = $FunctionSelect($UID_SUM_Year)['o'];
						$SUM_AllData = $FunctionSelect($UID_SUM_All)['o'];
						$echo = '#*Try To Fetch Every SUM UID Data';
						
						
						
						$echo = '#Try To Fetch Every COUNT UID Data';
						$COUNT_DayData = $FunctionSelect($UID_COUNT_Day)['o']; // ,'level_meta',true
						$COUNT_WeekData = $FunctionSelect($UID_COUNT_Week)['o'];
						$COUNT_MonthData = $FunctionSelect($UID_COUNT_Month)['o'];
						$COUNT_YearData = $FunctionSelect($UID_COUNT_Year)['o'];
						$COUNT_AllData = $FunctionSelect($UID_COUNT_All)['o'];
						$echo = '#*Try To Fetch Every COUNT UID Data';
						
						$echo = '#Try To Update Every SUM UID Data';		
						
						$NewValue = $SUM_DayData['value']+$Amount;
						$Array = ['uid'=>$UID_SUM_Day,'value'=>$NewValue];		
						$SUM_Day_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($SUM_Day_Update){ $Return[$User.':Direct']['DaySum']='Succuss';}else{$Return[$User.':Direct']['DaySum']='Faild';}	
						
						$NewValue = $SUM_WeekData['value']+$Amount;
						$Array = ['uid'=>$UID_SUM_Week,'value'=>$NewValue];		
						$SUM_Week_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($SUM_Week_Update){ $Return[$User.':Direct']['WeekSum']='Succuss';}else{$Return[$User.':Direct']['WeekSum']='Faild';}
						
						$NewValue = $SUM_MonthData['value']+$Amount;
						$Array = ['uid'=>$UID_SUM_Month,'value'=>$NewValue];		
						$SUM_Month_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($SUM_Month_Update){ $Return[$User.':Direct']['MonthSum']='Succuss';}else{$Return[$User.':Direct']['MonthSum']='Faild';}
						
						
						$NewValue = $SUM_YearData['value']+$Amount;
						$Array = ['uid'=>$UID_SUM_Year,'value'=>$NewValue];		
						$SUM_Year_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($SUM_Year_Update){ $Return[$User.':Direct']['YearSum']='Succuss';}else{$Return[$User.':Direct']['YearSum']='Faild';}
						
						$NewValue = $SUM_AllData['value']+$Amount;
						$Array = ['uid'=>$UID_SUM_All,'value'=>$NewValue];		
						$SUM_All_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($SUM_All_Update){ $Return[$User.':Direct']['AllSum']='Succuss';}else{$Return[$User.':Direct']['AllSum']='Faild';}	
						
						$echo = '#*Try To Update Every SUM UID Data';	
						
						
						$echo = '#Try To Update Every COUNT UID Data';		
						
						$NewValue = $COUNT_DayData['value']+1;
						$Array = ['uid'=>$UID_COUNT_Day,'value'=>$NewValue];		
						$COUNT_Day_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($COUNT_Day_Update){ $Return[$User.':Direct']['DayCOUNT']='Succuss';}else{$Return[$User.':Direct']['DayCOUNT']='Faild';}
						
						$NewValue = $COUNT_WeekData['value']+1;
						$Array = ['uid'=>$UID_COUNT_Week,'value'=>$NewValue];		
						$COUNT_Week_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($COUNT_Week_Update){ $Return[$User.':Direct']['WeekCOUNT']='Succuss';}else{$Return[$User.':Direct']['WeekCOUNT']='Faild';}
						
						$NewValue = $COUNT_MonthData['value']+1;
						$Array = ['uid'=>$UID_COUNT_Month,'value'=>$NewValue];		
						$COUNT_Month_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($COUNT_Month_Update){ $Return[$User.':Direct']['MonthCOUNT']='Succuss';}else{$Return[$User.':Direct']['MonthCOUNT']='Faild';}
						
						
						$NewValue = $COUNT_YearData['value']+1;
						$Array = ['uid'=>$UID_COUNT_Year,'value'=>$NewValue];		
						$COUNT_Year_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($COUNT_Year_Update){ $Return[$User.':Direct']['YearCOUNT']='Succuss';}else{$Return[$User.':Direct']['YearCOUNT']='Faild';}	
						
						$NewValue = $COUNT_AllData['value']+1;
						$Array = ['uid'=>$UID_COUNT_All,'value'=>$NewValue];		
						$COUNT_All_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
						if($COUNT_All_Update){ $Return[$User.':Direct']['AllCOUNT']='Succuss';}else{$Return[$User.':Direct']['AllCOUNT']='Faild';}
						
						$echo = '#*Try To Update Every COUNT UID Data';	
						
						$echo = '#Unset All Veriables Value [free memory] ';
						unset($SUM_DayData,$SUM_WeekData,$SUM_MonthData,$SUM_YearData,$SUM_AllData,$COUNT_DayData,$COUNT_WeekData,
							  $COUNT_MonthData,$COUNT_YearData,$COUNT_AllData,$UID_COUNT_Day,$UID_COUNT_Week,$UID_COUNT_Month,$UID_COUNT_Year,
							  $UID_COUNT_All,$SUM_AllData,$UID_SUM_Day,$UID_SUM_Week,$UID_SUM_Month,$UID_SUM_Year,$UID_SUM_All);
						$echo = '#*Unset All Veriables Value [free memory] ';	
						
					}
					else{$echo = 'feature name , pair ,user and amount is required.';}
				}
				else{ $echo = 'Upline Not Level 1';}
				
				$echo = ' #* Direct Data Update.';
			}
		}
		else{$echo = 'Uplines Not Found.';}
	}
	else{$echo = 'Array Not Found.';}
	
	$Return['logs'] = $echo;	
	//echo $echo;
	return $Return; 
}


#####################################################################################################################################################


function LiveData___Feature_Meta($Array=[]){
	#Developer: JAspal Byavat
	#Date [dd-mm-yy]: 11-06-2025
	#Engine: 
	    # 1. Create UIDs Of according Feature_meta 
	    # 2. Fetch old Data According UID
	    # 3. Set Veriables and then Update Self Data in Feture_Meta table 
	# Input: $Input = ['feature'=>'Level','amount'=>'1000','pair'=>'USDT_USDT','user'=>1];
	# Output: Massage With Logs 
	
	
if(is_array($Array) and !empty($Array)){
	$echo = 'Array Not Empty Continue...';
	
	$FeatureName  = $Array['feature'];
	$Amount  = $Array['amount'];
	$Pair  = strtoupper($Array['pair']);
	$User  = $Array['user'];
	
	$FunctionSelect = $Array['feature'].'_Meta';
	$FunctionUpdate = $Array['feature'].'_MetaUpdate';
	
	
	$Return = [];
	if($FeatureName and $Amount and $Pair and $User){
		$echo = 'feature name , pair , user and amount is available.';
		
		$echo = '#Try To Create COUNT UID';
		$UID_COUNT_Day = App['id'].':'.$User.':Day:COUNT:'.$FeatureName.':Self:'.$Pair;
		$UID_COUNT_Week = App['id'].':'.$User.':Week:COUNT:'.$FeatureName.':Self:'.$Pair;
		$UID_COUNT_Month = App['id'].':'.$User.':Month:COUNT:'.$FeatureName.':Self:'.$Pair;
		$UID_COUNT_Year = App['id'].':'.$User.':Year:COUNT:'.$FeatureName.':Self:'.$Pair;
		$UID_COUNT_All = App['id'].':'.$User.':All:COUNT:'.$FeatureName.':Self:'.$Pair;
		$echo = '#*Try To Create COUNT UID';
		
		$echo = '#Try To Create SUM UID';
		$UID_SUM_Day = App['id'].':'.$User.':Day:SUM:'.$FeatureName.':Self:'.$Pair;
		$UID_SUM_Week = App['id'].':'.$User.':Week:SUM:'.$FeatureName.':Self:'.$Pair;
		$UID_SUM_Month = App['id'].':'.$User.':Month:SUM:'.$FeatureName.':Self:'.$Pair;
		$UID_SUM_Year = App['id'].':'.$User.':Year:SUM:'.$FeatureName.':Self:'.$Pair;
		$UID_SUM_All = App['id'].':'.$User.':All:SUM:'.$FeatureName.':Self:'.$Pair;
		$echo = '#*Try To Create SUM UID';
		
		
		
		$echo = '#Try To Fetch Every SUM UID Data';
		$SUM_DayData = $FunctionSelect($UID_SUM_Day)['o']; // ,'level_meta',true
		$SUM_WeekData = $FunctionSelect($UID_SUM_Week)['o'];
		$SUM_MonthData = $FunctionSelect($UID_SUM_Month)['o'];
		$SUM_YearData = $FunctionSelect($UID_SUM_Year)['o'];
		$SUM_AllData = $FunctionSelect($UID_SUM_All)['o'];

		$echo = '#*Try To Fetch Every SUM UID Data';
		
		
		
		$echo = '#Try To Fetch Every COUNT UID Data';
		$COUNT_DayData = $FunctionSelect($UID_COUNT_Day)['o']; // ,'level_meta',true
		$COUNT_WeekData = $FunctionSelect($UID_COUNT_Week)['o'];
		$COUNT_MonthData = $FunctionSelect($UID_COUNT_Month)['o'];
		$COUNT_YearData = $FunctionSelect($UID_COUNT_Year)['o'];
		$COUNT_AllData = $FunctionSelect($UID_COUNT_All)['o'];

		$echo = '#*Try To Fetch Every COUNT UID Data';
		

$echo = '#Try To Update Every SUM UID Data';		
		
$NewValue = $SUM_DayData['value']+$Amount;
$Array = ['uid'=>$UID_SUM_Day,'value'=>$NewValue];		
$SUM_Day_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($SUM_Day_Update){ $Return['DaySum']='Succuss';}else{$Return['DaySum']='Faild';}	

$NewValue = $SUM_WeekData['value']+$Amount;
$Array = ['uid'=>$UID_SUM_Week,'value'=>$NewValue];		
$SUM_Week_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($SUM_Week_Update){ $Return['WeekSum']='Succuss';}else{$Return['WeekSum']='Faild';}	

$NewValue = $SUM_MonthData['value']+$Amount;
$Array = ['uid'=>$UID_SUM_Month,'value'=>$NewValue];		
$SUM_Month_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($SUM_Month_Update){ $Return['MonthSum']='Succuss';}else{$Return['MonthSum']='Faild';}	

		
$NewValue = $SUM_YearData['value']+$Amount;
$Array = ['uid'=>$UID_SUM_Year,'value'=>$NewValue];		
$SUM_Year_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($SUM_Year_Update){ $Return['YearSum']='Succuss';}else{$Return['YearSum']='Faild';}	

$NewValue = $SUM_AllData['value']+$Amount;
$Array = ['uid'=>$UID_SUM_All,'value'=>$NewValue];		
$SUM_All_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($SUM_All_Update){ $Return['AllSum']='Succuss';}else{$Return['AllSum']='Faild';}	

$echo = '#*Try To Update Every SUM UID Data';	
		
		

$echo = '#Try To Update Every COUNT UID Data';		
		
$NewValue = $COUNT_DayData['value']+1;
$Array = ['uid'=>$UID_COUNT_Day,'value'=>$NewValue];		
$COUNT_Day_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($COUNT_Day_Update){ $Return['DayCOUNT']='Succuss';}else{$Return['DayCOUNT']='Faild';}	

$NewValue = $COUNT_WeekData['value']+1;
$Array = ['uid'=>$UID_COUNT_Week,'value'=>$NewValue];		
$COUNT_Week_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($COUNT_Week_Update){ $Return['WeekCOUNT']='Succuss';}else{$Return['WeekCOUNT']='Faild';}	

$NewValue = $COUNT_MonthData['value']+1;
$Array = ['uid'=>$UID_COUNT_Month,'value'=>$NewValue];		
$COUNT_Month_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($COUNT_Month_Update){ $Return['MonthCOUNT']='Succuss';}else{$Return['MonthCOUNT']='Faild';}	

		
$NewValue = $COUNT_YearData['value']+1;
$Array = ['uid'=>$UID_COUNT_Year,'value'=>$NewValue];		
$COUNT_Year_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($COUNT_Year_Update){ $Return['YearCOUNT']='Succuss';}else{$Return['YearCOUNT']='Faild';}	

$NewValue = $COUNT_AllData['value']+1;
$Array = ['uid'=>$UID_COUNT_All,'value'=>$NewValue];		
$COUNT_All_Update = $FunctionUpdate($Array)['o'];unset($NewValue,$Array);		
if($COUNT_All_Update){ $Return['AllCOUNT']='Succuss';}else{$Return['AllCOUNT']='Faild';}	

$echo = '#*Try To Update Every COUNT UID Data';	
	}
	else{$echo = 'feature name , pair ,user and amount is required.';}
}
else{$echo = 'Array Not Found.';}

	
$echo = '#Unset All Veriables Value [free memory] ';
unset($SUM_DayData,$SUM_WeekData,$SUM_MonthData,$SUM_YearData,$SUM_AllData,$COUNT_DayData,$COUNT_WeekData,$COUNT_MonthData,$COUNT_YearData,
	  $COUNT_AllData,$UID_COUNT_Day,$UID_COUNT_Week,$UID_COUNT_Month,$UID_COUNT_Year,$UID_COUNT_All,$SUM_AllData,
	  $UID_SUM_Day,$UID_SUM_Week,$UID_SUM_Month,$UID_SUM_Year,$UID_SUM_All);	
$echo = '#*Unset All Veriables Value [free memory] ';	

$Return['logs'] = $echo;	
//echo $echo;
	return $Return; 
}




################################################################################################################################################
#-------------------------------------------------------------------------------------------------------------------------------------------
#|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
#-------------------------------------------------------------------------------------------------------------------------------------------
################################################################################################################################################



 

function Staking_Income_Meta($UID=NULL,$Table = 'staking_income_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Staking_Income_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'staking_income_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Staking_Income_MetaUpdate($Array=[],$NewConditions=[],$Table='staking_income_meta', $SQLData=false){

	
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
	
	
	
	
	
function Staking_Income_MetaStatus($UID=NULL,$Status = NULL,$Table = 'staking_income_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Staking_Income_MetaNew($Array=[],$Table = 'staking_income_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}
 




//////////////
 

function Staking_ConvertIncome_Meta($UID=NULL,$Table = 'staking_convertincome_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Staking_ConvertIncome_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'staking_convertincome_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Staking_ConvertIncome_MetaUpdate($Array=[],$NewConditions=[],$Table='staking_convertincome_meta', $SQLData=false){

	
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
	
	
	
	
	
function Staking_ConvertIncome_MetaStatus($UID=NULL,$Status = NULL,$Table = 'staking_convertincome_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Staking_ConvertIncome_MetaNew($Array=[],$Table = 'staking_convertincome_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}
 



//////////////

function TeamStaking_Meta($UID=NULL,$Table = 'teamstaking_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function TeamStaking_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'teamstaking_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function TeamStaking_MetaUpdate($Array=[],$NewConditions=[],$Table='teamstaking_meta', $SQLData=false){

	
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
	
	
	
	
	
function TeamStaking_MetaStatus($UID=NULL,$Status = NULL,$Table = 'teamstaking_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function TeamStaking_MetaNew($Array=[],$Table = 'teamstaking_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}
 



//////////////////



function Staking_Convert_Meta($UID=NULL,$Table = 'staking_convert_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Staking_Convert_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'staking_convert_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Staking_Convert_MetaUpdate($Array=[],$NewConditions=[],$Table='staking_convert_meta', $SQLData=false){

	
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
	
	
	
	
	
function Staking_Convert_MetaStatus($UID=NULL,$Status = NULL,$Table = 'staking_convert_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Staking_Convert_MetaNew($Array=[],$Table = 'staking_convert_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

	
	
 

function Staking_Meta($UID=NULL,$Table = 'staking_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Staking_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'staking_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Staking_MetaUpdate($Array=[],$NewConditions=[],$Table='staking_meta', $SQLData=false){

	
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
	
	
	
	
	
function Staking_MetaStatus($UID=NULL,$Status = NULL,$Table = 'staking_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Staking_MetaNew($Array=[],$Table = 'staking_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

 

 

function Lottery_Win_Meta($UID=NULL,$Table = 'lottery_win_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Lottery_Win_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'lottery_win_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Lottery_Win_MetaUpdate($Array=[],$NewConditions=[],$Table='lottery_win_meta', $SQLData=false){

	
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
	
	
	
	
	
function Lottery_Win_MetaStatus($UID=NULL,$Status = NULL,$Table = 'lottery_win_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Lottery_Win_MetaNew($Array=[],$Table = 'lottery_win_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

 

function Lottery_Ticket_Meta($UID=NULL,$Table = 'lottery_ticket_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Lottery_Ticket_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'lottery_ticket_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Lottery_Ticket_MetaUpdate($Array=[],$NewConditions=[],$Table='lottery_ticket_meta', $SQLData=false){

	
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
	
	
	
	
	
function Lottery_Ticket_MetaStatus($UID=NULL,$Status = NULL,$Table = 'lottery_ticket_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Lottery_Ticket_MetaNew($Array=[],$Table = 'lottery_ticket_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

 



 

function Deposit_Meta($UID=NULL,$Table = 'deposit_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Deposit_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'deposit_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Deposit_MetaUpdate($Array=[],$NewConditions=[],$Table='deposit_meta', $SQLData=false){

	
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
	
	
	
	
	
function Deposit_MetaStatus($UID=NULL,$Status = NULL,$Table = 'deposit_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Deposit_MetaNew($Array=[],$Table = 'deposit_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

	
 

function Withdraw_Meta($UID=NULL,$Table = 'withdraw_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Withdraw_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'withdraw_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Withdraw_MetaUpdate($Array=[],$NewConditions=[],$Table='withdraw_meta', $SQLData=false){

	
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
	
	
	
	
	
function Withdraw_MetaStatus($UID=NULL,$Status = NULL,$Table = 'withdraw_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Withdraw_MetaNew($Array=[],$Table = 'withdraw_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}
 


 


function Level_Meta($UID=NULL,$Table = 'level_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Level_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'level_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Level_MetaUpdate($Array=[],$NewConditions=[],$Table='level_meta', $SQLData=false){

	
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
	
	
	
	
	
function Level_MetaStatus($UID=NULL,$Status = NULL,$Table = 'level_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Level_MetaNew($Array=[],$Table = 'level_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

	
 
 

function TeamStaking_Income_Meta($UID=NULL,$Table = 'teamstaking_income_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function TeamStaking_Income_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'teamstaking_income_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function TeamStaking_Income_MetaUpdate($Array=[],$NewConditions=[],$Table='teamstaking_income_meta', $SQLData=false){

	
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
	
	
	
	
	
function TeamStaking_Income_MetaStatus($UID=NULL,$Status = NULL,$Table = 'teamstaking_income_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function TeamStaking_Income_MetaNew($Array=[],$Table = 'teamstaking_income_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

 



function Income_RewardMonthly_Meta($UID=NULL,$Table = 'income_rewardmonthly_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Income_RewardMonthly_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'income_rewardmonthly_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Income_RewardMonthly_MetaUpdate($Array=[],$NewConditions=[],$Table='income_rewardmonthly_meta', $SQLData=false){

	
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
	
	
	
	
	
function Income_RewardMonthly_MetaStatus($UID=NULL,$Status = NULL,$Table = 'income_rewardmonthly_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Income_RewardMonthly_MetaNew($Array=[],$Table = 'income_rewardmonthly_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

	
 
 

 

function Spot_Trade_Meta($UID=NULL,$Table = 'spot_trade_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if($TableName and $UID){return Row($UID,$TableName,$SQL);}else{$echo = 'uid ,table name is required. ';}
	//echo $echo;
}
	
	
function Spot_Trade_Metas($Array=[],$NewConditions=[],$SQL=false){
	

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
	
	
	$Filter['table'] = 'spot_trade_meta';
	 
	if($Date){$Conditions = array_merge($NewArray,$Date);}else{$Conditions = $NewArray;}
	
if($NewConditions){$Conditions=$NewConditions; $Filter=$Array;$echo = 'if New System According Data input';}
	
 return  Rows($Filter, $Conditions,$SQL);
}
	

	


		
	
	
	
function Spot_Trade_MetaUpdate($Array=[],$NewConditions=[],$Table='spot_trade_meta', $SQLData=false){

	
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
	
	
	
	
	
function Spot_Trade_MetaStatus($UID=NULL,$Status = NULL,$Table = 'spot_trade_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	if($TableName and $UID and $Status){return RowStatus($UID,$Status,$TableName,$SQL);}else{$echo = 'uid , status  , table name is required. ';}	
	//echo $echo;	
}	
	
	
function Spot_Trade_MetaNew($Array=[],$Table = 'spot_trade_meta',$SQL=false){

	
	$echo = ' Niche appne sirf Table name dalna hai only or Data pass krna h jese phle krte the';
	
	if($Table){$TableName=$Table;}else{$TableName='';} 
	
	if(!empty($Array) and $TableName){return RowNew($Array,$TableName,$SQL);}else{$echo = 'Input array and table name is required. ';}
	//echo $echo;
}

	
	
  
?>