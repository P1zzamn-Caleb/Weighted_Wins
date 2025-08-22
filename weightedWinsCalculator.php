<?php
  
	const ABBRV_LENGTH= 3;
	const TOTAL_TEAMS=365;
	const LOSS_AGAINST_NON_D1_TEAM_WW_ADJUSTMENT = -0.950;
	const NON_D1_TEAM_STRING = "Non-D1 Team";


	class Team{
		private $initials;
		private $names;
        private $nameWithMascots;
        private $teamsWonAgainst;
        private $teamsLostAgainst;
		private $opponentsWonAgainstWeightedWins;
		private $oppFW;
		private $opponentResults;
		private $opponentNames;
		private $teamsPlayedAgainst;
		private $opponentsWonAgainstIndexes;
		private $FWadj;
		private $wwAdj;
		private $opponentWins;
		private $opponentLosses;
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
			$this->teamsPlayedAgainst = [];
			$this->opponentsWonAgainstWeightedWins=[];
			$this->opponentResults = [];
			$this->opponentNames = [];
			$this->FWadj = [];
			$this->wwAdj = [];
			$this->oppFW = [];
			$this->opponentWins = [];
			$this->opponentLosses= [];
			$this->opponentsWonAgainstIndexes = [];
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
			$this->teamsPlayedAgainst = [];
			$this->opponentsWonAgainstWeightedWins=[];
			$this->opponentResults = [];
			$this->opponentNames = [];
			$this->FWadj = [];
			$this->wwAdj = [];
			$this->oppFW = [];
			$this->opponentWins = [];
			$this->opponentLosses= [];
			$this->opponentsWonAgainstIndexes = [];
		}
		
		//outputs names with data for testing
		function outputResults(){
			echo "Team: ", $this->names, "   ", $this->initials, "    ", 
				 $this->totalGames, "   ", $this->wins, "    ",$this->losses, "    ", 
				 $this->initialWeight, "   ", $this->finalWeight, 
				 " ", $this->weightedWins, "<br>";

		}

		function makeWeightsNull(){
			$this->initialWeight = 0;
			$this->finalWeight = 0;
			$this->weightedWins=0;
		}
		
		//returns initials of a team
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

		//returns the counted wins
		function getCountedWins(){
			$countedWins = $this->wins - ($this->actualGames - $this->totalGames);
			//echo"$countedWins<br>";
			return $countedWins;
		}

		function returnWeightedWins(){
			return $this->weightedWins;
		}
		
		//adds a win
		function addWin(){
			$this->wins++;
		}

		//adds a loss
		function addLoss(){
			$this->losses++;
		}

		function addExtraData($data, $arrayName){
			$this->{$arrayName}[] = $data;
		}

		//saves the teams that the team wins and loses against
        function addTeamWonOrLostAgainst($opponentName, $resultLetter){
            if($resultLetter=="W"){
                $this->teamsWonAgainst[]=$opponentName;
				$this->teamsPlayedAgainst[]=$opponentName;
            }else{
                $this->teamsLostAgainst[]=$opponentName;
				$this->teamsPlayedAgainst[] = $opponentName;
            }
			$this->actualGames++;

			$this->addExtraData($opponentName, "opponentNames");
			$this->addExtraData($resultLetter, "opponentResults");
        }

		function addWinsAndLossesToArray($oppWins, $oppLosses){
			$this->opponentWins[] = $oppWins;
			$this->opponentLosses[] = $oppLosses;
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

		//gets all teams played against
		function getTeamsPlayedAgainst(){
			return $this->teamsPlayedAgainst;
		}

		function getOpponentResults(){
			return $this->opponentResults;
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
			$this->initialWeight = 3 + (($this->wins - ($this->actualGames - $this->totalGames) - $this->losses) *.01);
			$this->finalWeight = 3 + (($this->wins - ($this->actualGames - $this->totalGames) - $this->losses) *.01);
		}

		//adjusts the final weights for a loss for all teams
		function adjustFinalWeightForLoss($opponentWins, $opponentLosses, $opponentTotalWins){
			$deduction = 0;

			$this->addWinsAndLossesToArray($opponentTotalWins, $opponentLosses);
			
			if($opponentWins < $opponentLosses){
				$deduction = ($opponentWins-$opponentLosses) * 0.01;
				$this->finalWeight += $deduction;
			}
			
			$this->addExtraData($deduction, "FWadj");
			
		}

		//adjust Final weight for loss against non d1 team
		function adjustFinalWeightForLossAgainstNonD1($nonD1wins, $nonD1Losses){
			$this->finalWeight -= 0.10;
			$this->addExtraData(-0.10, "FWadj");
			$this->addWinsAndLossesToArray($nonD1wins, $nonD1Losses);
		}

		

		//adds up the weightedWins
		function addWeightedWins($opponentWeight, $result){
			$winValue = "W";
			$lossValue = "L";

			$this->oppFW[] = $opponentWeight;

			if($this->names == NON_D1_TEAM_STRING){
				$this->wwAdj[] = 0;
				return;
			}


			if($opponentWeight == -1 and $result == $lossValue){
				$this->weightedWins -= LOSS_AGAINST_NON_D1_TEAM_WW_ADJUSTMENT;
				$this->wwAdj[] = LOSS_AGAINST_NON_D1_TEAM_WW_ADJUSTMENT;
			}else{
				if($opponentWeight == -1 and $result == $winValue){
					$this->opponentsWonAgainstWeightedWins[] = 0;
					$this->opponentsWonAgainstIndexes[] = count($this->wwAdj);
					$this->wwAdj[] = 0;
				}else{ 
					if($result == $winValue){
						$this->weightedWins += $opponentWeight;
						$this->opponentsWonAgainstIndexes[] = count($this->wwAdj);
						$this->opponentsWonAgainstWeightedWins[] = $opponentWeight;
						$this->wwAdj[] = $opponentWeight;
					}else{
						$this->weightedWins += ($opponentWeight - $this->initialWeight);
						$this->wwAdj[] = ($opponentWeight - $this->initialWeight);
					}
				}
			}



			
		}

		//adjusts the final weights for a win for all teams
		function adjustFinalWeightForWin($opponentWins, $opponentLosses, $opponentName, $opponentTotalWins){
			$addition=0;

			if($this->names == NON_D1_TEAM_STRING){
				$this->addExtraData($addition, "FWadj");
				return;
			}

			$this->addWinsAndLossesToArray($opponentTotalWins, $opponentLosses);

			if($opponentName != NON_D1_TEAM_STRING){
				if($opponentWins > $opponentLosses){
					$addition = ($opponentWins-$opponentLosses) * 0.01;
					$this->finalWeight += $addition;
				}
			}
			//echo "$addition <br>";
			$this->addExtraData($addition, "FWadj");
			

			
		}

		//sorts opponentWeightedWins in ascending order
		function sortOpponentsWeightedWins() {
			$combined = [];
			for ($i = 0; $i < count($this->opponentsWonAgainstWeightedWins); $i++) {
				$combined[] = [
					'win' => $this->opponentsWonAgainstWeightedWins[$i],
					'team' => $this->teamsWonAgainst[$i],
					'indexes' => $this->opponentsWonAgainstIndexes[$i]
				];
			}

			// Sort by weighted win
			uasort($combined, function($a, $b) {
				return $a['win'] <=> $b['win']; // ascending
			});
		

			// Split back into separate arrays
			$this->opponentsWonAgainstWeightedWins = array_column($combined, 'win');
			$this->teamsWonAgainst = array_column($combined, 'team');
			$this->opponentsWonAgainstIndexes = array_column($combined, 'indexes');
			
    	}

		//sets the order of opponentNames equal to the order of opponent weighted wins
		function sortOpponentsNames() {

			array_multisort(
	   $this->opponentsWonAgainstWeightedWins, SORT_ASC, SORT_NUMERIC,
    	  $this->teamsWonAgainst, SORT_ASC,
    			$this->opponentsWonAgainstIndexes, SORT_ASC
			) ;
		}
		
		//removes extra wins
		function removeExtraWins(){
			$lengthArraySlice = $this->actualGames-$this->totalGames;

			if($lengthArraySlice > 0){
				$this->teamsWonAgainst = array_slice($this->teamsWonAgainst,0,$this->actualGames-$this->totalGames);
				$this->opponentsWonAgainstWeightedWins = array_slice($this->opponentsWonAgainstWeightedWins,0,$lengthArraySlice);

				for($i= 0;$i<($lengthArraySlice);$i++){
					if (isset($this->opponentsWonAgainstIndexes[$i])) {
						$this->weightedWins -= $this->wwAdj[$this->opponentsWonAgainstIndexes[$i]];
						$this->wwAdj[$this->opponentsWonAgainstIndexes[$i]] = "Drop";
					}
				}
				$this->opponentsWonAgainstIndexes = array_slice($this->opponentsWonAgainstIndexes,0,$lengthArraySlice);
			}else{
				//ask Dr.Terwilliger what to do here
			}
		}

		
		
	}


	$teams = array();
	$currYear = 2025;
	$earliestYear=2003;
	$teamNameIndexMap = [];
	
	for($i=0;$i<count($teams);$i++){
		$teams[$i]->outputResults();
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
		
	//adds wins and losses to all teams
	function addWinsAndLossesToAllTeams($year){
		global $teams;
		global $teamNameIndexMap;
		$winLossData = fopen("scoreData$year.txt", "r") or die("failed to open");

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

		//get win and loss data
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
					if(!isset($teamNameIndexMap[$opponentName])){
						$teams[TOTAL_TEAMS]->addLoss();
					}
				}
                else{
					$teams[$teamIndex]->addLoss();
					if(!isset($teamNameIndexMap[$opponentName])){
						$teams[TOTAL_TEAMS]->addWin();
					}
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

		

	
		//reads in teamNames, teamNamesWithMascots, and teamAbbrv
		while(!feof($teamNames)){
			$teams[$i] = new Team();
			$teams[$i]->readInNames(fgets($teamNames), fgets($teamNames));
            $teams[$i]->readInNamesWithMascots(fgets($teamNamesWithMascots));
			$i++;		
		}
		$teams[TOTAL_TEAMS] = new Team();
		$teams[TOTAL_TEAMS]->readInNames(NON_D1_TEAM_STRING, "ND1");
        $teams[TOTAL_TEAMS]->readInNamesWithMascots(NON_D1_TEAM_STRING);
		fclose($teamNames);
        fclose($teamNamesWithMascots);
	}

	//calculates the initial and final weights of the teams
	function calculateWeights(){
		global $teams;
		global $teamNameIndexMap;

		//will be used to add up weighted wins
		$lossValue = "L";
		$winValue = "W";

		//calculates initial weights for each team
		foreach ($teams as $team){
			$team->calculateInitialWeight();
		}

		$teams[TOTAL_TEAMS]->makeWeightsNull();

		//adjust finalWeights
		for($i=0;$i<count($teams);$i++){
			$teamsPlayedAgainst = $teams[$i]->getTeamsPlayedAgainst();
			$opponentResults = $teams[$i]->getOpponentResults();
			

			//adjusts weights for losses
			for($j=0;$j<count($teamsPlayedAgainst);$j++){
				if($opponentResults[$j] == "W"){
					if (isset($teamNameIndexMap[$teamsPlayedAgainst[$j]])){
						$opponentsIndex = $teamNameIndexMap[$teamsPlayedAgainst[$j]];

						//echo "$opponentsIndex<br>";
						$teams[$i]->adjustFinalWeightForWin($teams[$opponentsIndex]->getCountedWins(), $teams[$opponentsIndex]->getLosses(), $teamsPlayedAgainst[$j], $teams[$opponentsIndex]->getWins());
					}else{
						$teams[$i]->adjustFinalWeightForWin(0, $teams[TOTAL_TEAMS]->getLosses(), NON_D1_TEAM_STRING, $teams[TOTAL_TEAMS]->getWins());
					}
				}else{
					if (isset($teamNameIndexMap[$teamsPlayedAgainst[$j]])){
						$opponentsIndex = $teamNameIndexMap[$teamsPlayedAgainst[$j]];

						//echo "$opponentsIndex<br>";
						$teams[$i]->adjustFinalWeightForLoss($teams[$opponentsIndex]->getCountedWins(), $teams[$opponentsIndex]->getLosses(), $teams[$opponentsIndex]->getWins());
					}else{
						$teams[$i]->adjustFinalWeightForLossAgainstNonD1($teams[TOTAL_TEAMS]->getWins(), $teams[TOTAL_TEAMS]->getLosses());
					}
				}
			}
		}

		//calculates weightedWins
		for($i=0;$i<count($teams);$i++){
				$teamsPlayedAgainst = $teams[$i]->getTeamsPlayedAgainst();
				$opponentResults = $teams[$i]->getOpponentResults();

				//adjusts WeightedWins
				for($j=0;$j<count($teamsPlayedAgainst);$j++){
					if($opponentResults[$j] == "W"){
						if (isset($teamNameIndexMap[$teamsPlayedAgainst[$j]])){
							$opponentsIndex = $teamNameIndexMap[$teamsPlayedAgainst[$j]];

							//echo "$opponentsIndex<br>";
							$teams[$i]->addWeightedWins($teams[$opponentsIndex]->returnFinalWeight(), $winValue);
						}else{
							$teams[$i]->addWeightedWins(-1, $winValue);
						}
					}else{
						if (isset($teamNameIndexMap[$teamsPlayedAgainst[$j]])){
							$opponentsIndex = $teamNameIndexMap[$teamsPlayedAgainst[$j]];

							//echo "$opponentsIndex<br>";
							$teams[$i]->addWeightedWins($teams[$opponentsIndex]->returnFinalWeight(), $lossValue);
						}else{
							$teams[$i]->addWeightedWins(-1, $lossValue);
						}
					}
				}
			}
		

			//removes extra wins
			for($k=0;$k<count($teams);$k++){
				$teams[$k]->sortOpponentsWeightedWins();
				$teams[$k]->sortOpponentsNames();
				$teams[$k]->removeExtraWins();
			}	

		$teams[TOTAL_TEAMS]->makeWeightsNull();



		
	}

	//sorts teams by weighted wins
	 function sortTeams(){
            global $teams;

            usort($teams, function($a, $b) {
                return $b->returnWeightedWins() <=> $a->returnWeightedWins();
            });
        }

	function printData($year){
		global $teams;

		echo "$year<br>";

		for($i=0;$i<count($teams);$i++){
			$teams[$i]->outputResults();
		}
	}

	function callResetValues(){
		global $teams;

		for($i=0;$i<= TOTAL_TEAMS;$i++){
			$teams[$i]->resetValues();
		}
	}

	
function runProgram($year){
	callResetValues();
	addWinsAndLossesToAllTeams($year);
	calculateWeights();
	sortTeams();
	printData($year);
}
	

?>