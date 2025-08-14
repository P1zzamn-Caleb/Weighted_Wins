<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Weighted Wins NCAA Basketball</title>
  <link rel="icon" type="image/x-icon" href="http://www.weightedwins.com/football.gif">
  
  <style>
  body
  {
	text-align:center;
  }
  h1
  {
	font-family: Arial, sans-serif;
  }
  
  a:link, a:visited
  {
	color: rgb(0,0,255);
	text-decoration: none;
  }  
  a:hover, a:active
  {
	color: rgb(0, 0, 139);
	text-decoration: underline;
  }  
  #buttons:link, #buttons:visited
  {
	background-color: rgb(0,0,145);
	color: white;
	padding: 15px 25px;
	text-decoration: none;
	display: in-line block;
  }
  #buttons:hover, #buttons:active
  {
	background-color: rgb(0,0,255);
	color: white;
	padding: 15px 25px;
	text-decoration: none;
	display: in-line block;
  }
  
  
  </style>
</head>
<body>

  <h1>
  <img src="https://pics.clipartpng.com/Under_Construction_Warning_Sign_PNG_Clipart-839.png" style="float:left; width:200px;height200px;">
  <img src="https://static.vecteezy.com/system/resources/previews/045/809/909/non_2x/a-yellow-hard-hat-on-a-transparent-background-free-png.png" 
  style="float:right; width:200px;height200px;">
  This website is currently under construction!
  </h1>
  
  <p>The current <a href="http://www.weightedwins.com" target="_blank">website</a> for NCAA D1 football rankings.<br></p>
  
  
  <p><a href="http://www.weightedwins.com"target="_blank" id="buttons">A button for funsies</a></p>
  

  <?php
	const ABBRV_LENGTH= 3;
	const TOTAL_TEAMS=365;
	const NON_D1_TEAM_STRING = "Non-D1 Team";


	class Team{
		private $initials;
		private $names;
        private $nameWithMascots;
        private $teamsWonAgainst;
        private $teamsLostAgainst;
		private $opponentsWonAgainstWeightedWins;
		private $wins; 
		private $losses;
		private $actualGames;
		private $totalGames;
		private $initialWeight;
		private $finalWeight;
		private $weightedWins;

		//starts each team out with 0 wins and 0 losses
		function __construct(){
			$this->wins=0;
			$this->losses=0;
			$this->initialWeight=1;
			$this->finalWeight=1;
			$this->weightedWins=0;
			$this->actualGames=0;
            $this->initials="";
		    $this->names="";
            $this->nameWithMascots="";
            $this->teamsWonAgainst=[];
            $this->teamsLostAgainst=[];
			$this->opponentsWonAgainstWeightedWins=[];
		}
		
		//reads in the names and abbreviations of each team for that year
		function readInNames($name, $initial){
			$this->initials= trim($initial);
			$this->names= trim($name);
		}

        function readInNamesWithMascots($namesWithMascots){
            $this->nameWithMascots= trim($namesWithMascots);
		}

		//tells each team how many games were played that season
		function readInGameCount($gameCount){
			$this->totalGames= $gameCount;
		}

		//resets the values to their origional values, almost like a construct but it allows me to reuse the same teams
		function resetValues(){
			$this->wins=0;
			$this->losses=0;
			$this->initialWeight=1;
			$this->finalWeight=1;
			$this->weightedWins=0;
			$this->actualGames=0;
            $this->teamsWonAgainst=[];
            $this->teamsLostAgainst=[];
			$this->opponentsWonAgainstWeightedWins=[];
		}
		
		//outputs names with data for testing
		function outputResults(){
			echo "Team: ", $this->names, "   ", $this->initials, "    ", 
				 "Actual:$this->actualGames <br>",$this->totalGames, "   ", $this->wins, "    ",$this->losses, "    ", 
				 $this->initialWeight, "   ", $this->finalWeight, 
				 " ", $this->weightedWins, "<br>";
			print_r($this->opponentsWonAgainstWeightedWins);
			echo "<br>";
			print_r($this->teamsWonAgainst);
			echo "<br>";
			print_r($this->teamsLostAgainst);

		}
		function writeResultsToFile($year, $mode){
			$file = fopen("weightedWinsData$year.txt", "$mode");
			
			fwrite($file, "Team: ");
			fwrite($file, $this->names);
			fwrite($file, "\n");
			fwrite($file, $this->initials);
			fwrite($file, "\n");
			fwrite($file, $this->totalGames);
			fwrite($file, "\n");
			fwrite($file, $this->wins);
			fwrite($file, "\n");
			fwrite($file, $this->losses); 
			fwrite($file,"\n");
			fwrite($file, $this->initialWeight);
			fwrite($file,"\n");
			fwrite($file, $this->finalWeight);
			fwrite($file,"\n");
			fwrite($file, $this->weightedWins);
			fwrite($file, "\n");

		}
		
		function getInitials(){
			return $this->initials;
		}

		//return team name with mascot
        function getName(){
            return $this->names;
        }

		//returns team name with mascots
		function getNamesWithMascots(){
			return $this->nameWithMascots;
		}
		
		//adds a win
		function addWin(){
			$this->wins++;
		}

		//adds a loss
		function addLoss(){
			$this->losses++;
		}

		//saves the teams that the team wins and loses against
        function addTeamWonOrLostAgainst($opponentName, $resultLetter){
            if($resultLetter=="W"){
                $this->teamsWonAgainst[]=$opponentName;
				
            }else{
                $this->teamsLostAgainst[]=$opponentName;
            }
			$this->actualGames++;

        }

		//returns a teams win total
		function getWins(){
			return $this->wins;
		}

		//returns a teams loss total
		function getLosses(){
			return $this->losses;
		}

		//gets the teams that the team has lost against
		function getTeamsLostAgainst(){
			return $this->teamsLostAgainst;
		}

		//gets the teams that the team has won against
		function getTeamsWonAgainst(){
			return $this->teamsWonAgainst;
		}

		//returns the initial weight of a team
		function returnInitialWeight(){
			return $this->initialWeight;
		}

		//returns final weight of a team
		function returnFinalWeight(){
			return $this->finalWeight;
		}


		//calculates the initial weights for all teams
		function calculateInitialWeight(){
			$this->initialWeight = 1 + (($this->wins - $this->losses) *.01);
			$this->finalWeight = 1 + (($this->wins - $this->losses) *.01);
		}

		//adjusts the final weights for a loss for all teams
		function adjustFinalWeightForLoss($opponentWins, $opponentLosses){
			
			if($opponentWins < $opponentLosses){
				$deduction = ($opponentWins-$opponentLosses) * 0.01;
				$this->finalWeight += $deduction;
			}
			
		}

		function adjustFinalWeightForLossAgainstNonD1(){
			$this->finalWeight -= 0.10;
		}

		

		//adds up the weightedWins
		function addWeightedWins($opponentWeight, $result){
			$winValue = "win";
			$lossValue = "loss";

			if($opponentWeight == -1 and $result == $lossValue){
				//$this->weightedWins -= LOSS_AGAINST_NON_D1_TEAM_WW_ADJUSTMENT;
				return;
			}else{
				if($opponentWeight == -1 and $result == $winValue){
					$this->opponentsWonAgainstWeightedWins[] = -.01;
					return;
				}
			}

			if($result == $winValue){
				$this->weightedWins += $opponentWeight;
				$this->opponentsWonAgainstWeightedWins[] = $opponentWeight;
			}else{
				$this->weightedWins += ($opponentWeight - $this->initialWeight);
			}
		}

		//adjusts the final weights for a win for all teams
		function adjustFinalWeightForWin($opponentWins, $opponentLosses){
			$addition=0;

			
			if($opponentWins > $opponentLosses){
				$addition = ($opponentWins-$opponentLosses) * 0.01;
				$this->finalWeight += $addition;
			}
			

			
		}

		//sorts opponentWeightedWins in ascending order
		function sortOpponentsWeightedWins() {
			$indexes = array_keys($this->opponentsWonAgainstWeightedWins);
			usort($this->opponentsWonAgainstWeightedWins, function($a, $b) {
				return (float)$this->opponentsWonAgainstWeightedWins[(int)$a] <=> (float)$this->opponentsWonAgainstWeightedWins[(int)$b];
			});
			$this->opponentsWonAgainstWeightedWins = array_replace(array_flip($indexes), $this->opponentsWonAgainstWeightedWins);
    	}

		//sets the order of opponentNames equal to the order of opponent weighted wins
		function sortOpponentsNames() {
			array_multisort($this->opponentsWonAgainstWeightedWins, SORT_ASC, $this->teamsWonAgainst);
		}
		

		function removeExtraWins(){
			$this->teamsWonAgainst = array_slice($this->teamsWonAgainst,0,$this->actualGames-$this->totalGames);
			$this->opponentsWonAgainstWeightedWins = array_slice($this->opponentsWonAgainstWeightedWins,0,$this->actualGames-$this->totalGames);


		}
		
		
	}


	$teams = array();
	$currYear = 2025;
	$earliestYear=2003;
	
	for($i=0;$i<count($teams);$i++){
		$teams[$i]->outputResults();
	}
	
	
	//searches for the matching abbreviation using a binary search algorithm
		function linearTeamAbbrvSearch($teamAbbrv){
			global $teams;
			$i=0;

			$tempInitials=trim($teams[$i]->getInitials());

			while($i<count($teams)){
				if($tempInitials == $teamAbbrv){
					return $i;
				}else{
					$i++;
					if($i<140){$tempInitials=trim($teams[$i]->getInitials());}
				}
			}

            
			
		}
		//cleans the string
		function cleanStr($str) {
			//converts encoding to UTF-8
			$str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');
			// Replace bad characters
			$str = str_replace(["�", "?"], "é", $str);
			// Trim whitespace
			$str = trim($str);

			
			return $str;
		}


        //searches for teams based off of their name
        function linearTeamWithMascotsSearch($teamName){
			global $teams;
			$i=0;

			while($i<count($teams)){
				$tempTeamName=trim($teams[$i]->getNamesWithMascots());

				if(cleanStr($tempTeamName) == cleanStr($teamName)){
					return $i;
				}else{
					$i++;
				}
			}

			//returns -1 if not found
			return -1;
        }   
		
		function linearTeamSearch($teamName){
			global $teams;
			$i=0;

			while($i<count($teams)){
				$tempTeamName=trim($teams[$i]->getName());

				if(cleanStr($tempTeamName) == cleanStr($teamName)){
					return $i;
				}else{
					$i++;
				}
			}

			//returns -1 if not found
			return -1;
        }  
	//adds wins and losses to all teams
	function addWinsAndLossesToAllTeams($year){
		global $teams;
		#$file = file("scoreData$year.txt");
		$winLossData = fopen("scoreData$year.txt", "r") or die("failed to open");
        $gameIndex=0;

		$teamIndex=0;

		//changes the game count for covid year
		if($year==2021 or $year==2022){
			$gameCountFile = fopen("gameCount2021.txt", "r") or die;
			$gameCount = fgets($gameCountFile);
			for($i=0;$i<count($teams);$i++){
				$teams[$i]->readInGameCount($gameCount);
			}
		}else{
			$gameCountFile = fopen("gamesCountedEveryYearButCOVIDYear.txt", "r") or die;
			$gameCount = fgets($gameCountFile);
			for($i=0;$i<count($teams);$i++){
				$teams[$i]->readInGameCount($gameCount);
			}
		}

        $newTeamString = "Team: ";

		
		while(!feof($winLossData)){
			$opponentName=trim(fgets($winLossData));


			
			if(str_contains($opponentName, $newTeamString)){
                $newTeam = str_replace($newTeamString, "", $opponentName);
				$newTeam = trim($newTeam);

                $teamIndex=linearTeamWithMascotsSearch($newTeam);
				if($teamIndex==-1){
					$resultLetter=trim(fgets($winLossData));
                	$teams[$teamIndex]->addTeamWonOrLostAgainst(NON_D1_TEAM_STRING, $resultLetter);
				}
            }else{
                $resultLetter=trim(fgets($winLossData));
                $teams[$teamIndex]->addTeamWonOrLostAgainst($opponentName, $resultLetter);
                if($resultLetter=="W"){
					$teams[$teamIndex]->addWin();
				}
                else{
					$teams[$teamIndex]->addLoss();
				}
            }
		} 

		fclose($winLossData);
	}
	
	

	//reads in the names, abbreviation, and amount of games counted for each of the teams.
	function getData(){
		global $teams;
		$teamNames = fopen("newData.txt", "r") or die;
        $teamNamesWithMascots = fopen("teamNames.txt", "r") or die;
		$i=0;
		
		while(!feof($teamNames)){
			$teams[$i] = new Team();
			$teams[$i]->readInNames(fgets($teamNames), fgets($teamNames));
            $teams[$i]->readInNamesWithMascots(fgets($teamNamesWithMascots));
			$i++;		
		}
		fclose($teamNames);
        fclose($teamNamesWithMascots);
	}

	//calculates the initial and final weights of the teams
	function calculateWeights(){
		global $teams;

		//will be used to add up weighted wins
		$lossValue = "lost";
		$winValue = "win";
		$teamFound=False;


		foreach ($teams as $team){
			$team->calculateInitialWeight();
		}

		for($i=0;$i<count($teams);$i++){
			$teamsLostAgainst = $teams[$i]->getTeamsLostAgainst();
			$teamsWonAgainst = $teams[$i]->getTeamsWonAgainst();
			

			//adjusts weights for losses
			for($j=0;$j<count($teamsLostAgainst);$j++){

				$opponentsIndex = linearTeamSearch($teamsLostAgainst[$j]);
				
				if ($opponentsIndex != -1){
					$teams[$i]->adjustFinalWeightForLoss($teams[$opponentsIndex]->getWins(), $teams[$opponentsIndex]->getLosses());
					$teams[$i]->addWeightedWins($teams[$opponentsIndex]->returnFinalWeight(), $lossValue);
					$teamFound=True;
				}else{
					//adjust weights if the team is non-d1
					$teams[$i]->adjustFinalWeightForLossAgainstNonD1();
					$teams[$i]->addWeightedWins(-1, $lossValue);
				}
			}

			//adjust weights for wins
			for($j=0;$j<count($teamsWonAgainst);$j++){

				$opponentsIndex = linearTeamSearch($teamsWonAgainst[$j]);

				if( $opponentsIndex != -1){
					$teams[$i]->adjustFinalWeightForWin($teams[$opponentsIndex]->getWins(), $teams[$opponentsIndex]->getLosses(), $teams[$opponentsIndex]->getName());
					$teams[$i]->addWeightedWins($teams[$opponentsIndex]->returnFinalWeight(), $winValue);
				}else{
					$teams[$i]->addWeightedWins(-1, $winValue);
				
				}
			}
		}

		//removes extra wins
		for($i=0;$i<count($teams);$i++){
			$teams[$i]->sortOpponentsWeightedWins();
			$teams[$i]->sortOpponentsNames();
			$teams[$i]->removeExtraWins();
		}	


		
	}

	function printandWriteData($year){
		global $teams;
		$mode = "w";

		for($i=0;$i<count($teams);$i++){
			$teams[$i]->outputResults();
			$teams[$i]->writeResultsToFile($year, $mode);
			$mode = "a";
		}
	}

	function callResetValues(){
		global $teams;

		for($i=0;$i<count($teams);$i++){
			$teams[$i]->resetValues();
		}
	}

	getData();


	for($year=$currYear;$year>=$earliestYear;$year--){
		addWinsAndLossesToAllTeams($year);
		calculateWeights();
		echo "$year <br>";
		printandWriteData($year);

		callResetValues();
	}

  ?>
</body>
</html>

