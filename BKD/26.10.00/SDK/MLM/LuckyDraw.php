<?php



# JAspal Byavat 

define('luckydraw','auto');

function LuckyDrawRadom_25_Users(){
	$ThisWeekPeriod=$LastWeekPeriod=$SecondLastWeekPeriod=$return=0;


	$ThisWeekPeriod = TodayPeriod();
	$LastWeekPeriod = $ThisWeekPeriod-1;
	$SecondLastWeekPeriod = $LastWeekPeriod-1;
	if($ThisWeekPeriod and $LastWeekPeriod and $SecondLastWeekPeriod){
		$echo = 'All Periods Found.';

		$SQL = '';
		$SQL = "WITH `Coinpods_EligibleRandomBets` AS
(
    SELECT
        `Coinpods_bet`.`id`,
        `Coinpods_bet`.`name`,
        `Coinpods_bet`.`created`,
        `Coinpods_bet`.`modified`,
        `Coinpods_bet`.`user`,
        `Coinpods_bet`.`amount`,
        `Coinpods_bet`.`on`,
        `Coinpods_bet`.`ccc`,
        `Coinpods_bet`.`period`,
        `Coinpods_bet`.`status`,
        `Coinpods_bet`.`bid`,
        `Coinpods_bet`.`ttype`,
        `Coinpods_bet`.`StatusBet`,

        ROW_NUMBER() OVER
        (
            PARTITION BY `Coinpods_bet`.`user`
            ORDER BY RAND(), `Coinpods_bet`.`bid`
        ) AS `Coinpods_UserBetRandomRank`

    FROM `Coinpods_bet`

    WHERE `Coinpods_bet`.`period` = '".$ThisWeekPeriod."'

      AND `Coinpods_bet`.`user` IS NOT NULL
      AND `Coinpods_bet`.`user` > 0

      AND `Coinpods_bet`.`bid` IS NOT NULL
      AND `Coinpods_bet`.`bid` > 0

      AND NOT EXISTS
      (
          SELECT 1
          FROM `Coinpods_luckydraw`

          WHERE `Coinpods_luckydraw`.`user`
                    = `Coinpods_bet`.`user`

            AND `Coinpods_luckydraw`.`period`
                    IN ('".$LastWeekPeriod."', '".$SecondLastWeekPeriod."', '".$ThisWeekPeriod."')
      )
)

SELECT
    `Coinpods_EligibleRandomBets`.`id`,
    `Coinpods_EligibleRandomBets`.`name`,
    `Coinpods_EligibleRandomBets`.`created`,
    `Coinpods_EligibleRandomBets`.`modified`,
    `Coinpods_EligibleRandomBets`.`user`,
    `Coinpods_EligibleRandomBets`.`amount`,
    `Coinpods_EligibleRandomBets`.`on`,
    `Coinpods_EligibleRandomBets`.`ccc`,
    `Coinpods_EligibleRandomBets`.`period`,
    `Coinpods_EligibleRandomBets`.`status`,
    `Coinpods_EligibleRandomBets`.`bid`,
    `Coinpods_EligibleRandomBets`.`ttype`,
    `Coinpods_EligibleRandomBets`.`StatusBet`

FROM `Coinpods_EligibleRandomBets`

WHERE `Coinpods_EligibleRandomBets`.`Coinpods_UserBetRandomRank` = 1

ORDER BY RAND()

LIMIT 25;";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;} } 
		else{$ts = null;}	
		$return = $ts;	
	}
	else{ $echo = 'All Periods Is Required.';}

	//echo $SQL;
	return $return;	

}



#* JAspal Byavat 







function LuckyDrawToWinner($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/01/01
	//Input : 
	//Output : Lucky Draw To Winner

	$Ps=PendingLuckyDrawToWinner();

	if($Ps){
		foreach($Ps as $P){

			$Bet=Bet($P['bid']);
			if($Bet){

				$WinnerNew=WinnerNew(array( 'user'=>$Bet['user'], 'ttype'=>$Bet['ttype'], 'bid'=>$P['bid'], 'rank'=>$P['rank'] , 'wid'=>$P['wid'], 'period'=>$P['period'] ));
				if($WinnerNew){

					Status1LuckyDraw($P['period']);

				}
				else{ Status2LuckyDraw($P['period']); }
			}
			else{ echo 'Bet Details Not Found.'; }
		}
	}
	else{ echo 'Pending Lucky Draw Not Found.'; }
}




function Status1LuckyDraw($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/01/01
	//Input : Period ( Date )
	//Output : Jiss user ka lucky draw To winner me success ho jane par status 1 krta hai.

	$SQL="UPDATE `Coinpods_luckydraw` SET `status`='1' WHERE `period` = '".$Q."';";
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);

	return $Output;
}




function Status2LuckyDraw($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/01/01
	//Input : Period ( Date )
	//Output : Jiss user ka lucky draw To winner me success nhi hota hai to status 2 krta hai. ( Faild )

	$SQL="UPDATE `Coinpods_luckydraw` SET `status`='2' WHERE `period` = '".$Q."';";
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);

	return $Output;
}









function PendingLuckyDrawToWinner($Q=null){
	//Developer: Pawan Kumar
	//Date: 2023/12/25
	//Input : 
	//Output : Aaj ki tarik me jo winner hone wale hai vo user aate hai.

	$QQ=TodayPeriod();
	$SQL="SELECT * FROM `Coinpods_luckydraw` WHERE `status` = '0'";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;} } 
	else{$ts = null;}	
	$return = $ts;	

	return $return;	
}








function ManagerluckyDraws($Q=null){
	//Developer: Pawan Kumar
	//Date: 2023/12/25
	//Input: Rank, bid(Lottery Number) , Date
	//Output : Insert Lucky Draw Transaction 
	$Retrun = [];$QQ=TodayPeriod();
	if(i['Role']=='Manager'){

		if(is_array($Q)){ $Rank=$Q['rank']; $Bid=$Q['bid']; $Date=$Q['date']; }
		if($Rank and $Bid and $Date){

			$Wid=gmdate("Ymd");//OrderId

			$QQ=TodayPeriod();

			$SQL="INSERT INTO `Coinpods_luckydraw`(`id`, `name`, `created`, `modified`, `period`, `number`, `color`, `rank`, `bid`, `wid`, `status`) VALUES (NULL,'".$Bid."','".$Date."','".$Date."','".$QQ."','','','".$Rank."','".$Bid."','".$Wid."W".$Rank."', '0')";
			global $DB; $results = mysqli_query($DB, $SQL);


		}
		else{ $echo = 'Data Empty.'; }
	}
	elseif(luckydraw == 'auto'){
		# JAspal Byavat
		$Q=null;
		$LuckyDrawRadom_25_Users = LuckyDrawRadom_25_Users();
		$aa=0;
		if(isset($LuckyDrawRadom_25_Users) and is_array($LuckyDrawRadom_25_Users)){
			$Processing=$Faild=$Success=0;
			foreach($LuckyDrawRadom_25_Users as $Q){
				$aa++;
				if($aa<=5){$Rank=$aa;}
				elseif($aa>=6 and $aa<=15){$Rank=6;}
				elseif($aa>=16 and $aa<=25){$Rank=7;}
				else{$Rank=0;}

				if(is_array($Q)){ 
					$Bid=$Q['bid']; $Date=GMT(); $period=$Q['period'];$User=$Q['user'];
					if($Rank and $Bid and $Date){
						$Processing++;

						$Wid=gmdate("W");

						$OrderId = "W:".$Wid.":R:".$Rank.':N:'.$aa;


						$SQL = '';
						$SQL="INSERT INTO `Coinpods_luckydraw`(`id`, `name`, `created`, `modified`, `period`, `number`, `color`, `rank`, `bid`, `wid`, `status`,`user`, `site`) VALUES (NULL,'Bet ID ".$Bid."','".$Date."','".$Date."','".$period."','".$aa."','','".$Rank."','".$Bid."','".$OrderId."', '0', '".$User."', '3')";
						global $DB; $results = 0; $results = mysqli_query($DB, $SQL);
						if($results==1){
							$Success++;
							$echo = 'insert success with insert_id : '.mysqli_insert_id($DB);
						}
						else{$Faild++;$echo = 'insert Faild';}

						$Retrun[$OrderId]['sql']=$SQL;
						$Retrun[$OrderId]['log']=$echo;
					}
					else{ $echo = 'Single Data Empty.'; }
				}
				else{ $echo = 'Data Empty.'; }
			}
		}
		else{$echo = 'No Users Found.';}
		#* JAspal Byavat
	}
	else{ $echo = 'Only Manager.'; }

	if($Processing==$Success){
		$PeriodUpdateSQL = "UPDATE `Coinpods_period` SET `period` = `period`+1 WHERE `id`=1";
		global $DB; $PeriodUpdateresults = 0;  $PeriodUpdateresults = mysqli_query($DB, $PeriodUpdateSQL);
	}
	else{ $echo = 'All Winners Not Done , Do Not Update Period';}


	$Retrun[$QQ]['processing']=$Processing;
	$Retrun[$QQ]['success']=$Success;
	$Retrun[$QQ]['faild']=$Faild;
	$Retrun[$QQ]['period_update']=$PeriodUpdateresults;

	//echo $echo;
	return $Retrun;
}









function LuckyDraw(){
	//Developer: Pawan Kumar
	//Date: 2023/12/25

	$LuckyDraws=LuckyDraws();
	if($LuckyDraws){ $Return=0;
					foreach($LuckyDraws as $LD){
						// print_r($LD); //echo '<br><br>';
						$Branch = SingleUser($LD['user'])['branch'];
						$Price = Price('CCC:BUSD', [ 'branch'=>$Branch ] );

						$Amount = $LD['amount'];
						$OCA = $Amount/$Price;
						$OCC = 'CCC';
						$Walletss = Fundings($LD['user']);
						$AfterBalance=$Walletss[strtolower($LD['ccc'])]+$Amount;
						if($Amount>0){


							$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`,`afterbalance`, `price`, `buyuser`, `filled`,`walletname`,`selltid`) VALUES (NULL, 'Win:".$LD['user']."', current_timestamp(), current_timestamp(), '".$LD['wid']."', '".$LD['user']."', '".$OCA."', '".$OCC."', '0', 'Win', '".$Amount."', '".$LD['ccc']."', '1', '".$Walletss[strtolower($LD['ccc'])]."', '".$AfterBalance."', '".$Price."', '".$LD['user']."', '".$LD['rank']."', 'Funding', '".$LD['id']."');";

							global $DB; $results = 0;$results = mysqli_query($DB, $SQL1); //echo $SQL1;

							if($results){
								$Return++;

								$SQL1="UPDATE `Coinpods_winner` SET `status`='1' WHERE `user` = '".$LD['user']."';";
								global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);


							}
							else{ echo 'Results not found.'; }

						}
						else{ echo 'Amount not found.'; }
					}
				   }
	else{echo 'Pendings not found.';}
	return $Return;
}






function LuckyDraws(){
	//Developer: Pawan Kumar
	//Date: 2023/12/25

	$SQL="SELECT * FROM `Coinpods_winner` WHERE `status` = '0' LIMIT 111";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	

	return $return;	
}






function TodayLuckyDraws(){
	//Developer: Pawan Kumar
	//Date: 2023/12/25

	$SQL="SELECT * FROM `Coinpods_luckydraw` WHERE `period` = '".TodayPeriod()."' LIMIT 111";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	

	return $return;	
}




function TodayWinner(){
	//Developer: Pawan Kumar
	//Date: 2023/12/25

	$QQ=TodayPeriod();
	$SQL="SELECT * FROM `Coinpods_winner` WHERE `wid` LIKE '%".$QQ."%' LIMIT 10";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	

	return $return;	
}


function YesterdayWinner(){
	//Developer: Pawan Kumar
	//Date: 2023/12/25

	$QQ=TodayPeriod()-1;
	$SQL="SELECT * FROM `Coinpods_winner` WHERE `wid` LIKE '%".$QQ."%' LIMIT 10";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	

	return $return;	
}


function Winner1111(){
	//Developer: Pawan Kumar
	//Date: 2023/12/25

	$QQ=TodayPeriod()-1;
	$SQL="SELECT * FROM `Coinpods_winner` WHERE `period` = '".$QQ."' LIMIT 25 OFFSET 0";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	

	return $return;	
}



function UserBYWinner($Q=null){
	//Developer: Pawan Kumar
	//Date: 2023/12/25
	if($Q){
		$QQ=TodayPeriod()-1;
		$SQL="SELECT * FROM `Coinpods_winner` WHERE `period` = '".$QQ."' and  `user`= '".$Q."' LIMIT 1 OFFSET 0";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		$return = $ts[0];	

	}

	return $return;	
}




?>