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


	class Team{
		private $initials;
		private $names;
        private $nameWithMascots;
        private $teamsWonAgainst;
        private $teamsLostAgainst;
		private $wins; 
		private $losses;
		private $totalGames;
		private $initialWeight;
		private $finalWeight;

		//starts each team out with 0 wins and 0 losses
		function __construct(){
			$this->wins=0;
			$this->losses=0;
			$this->initialWeight=1;
			$this->finalWeight=1;
            $this->initials="";
		    $this->names="";
            $this->nameWithMascots="";
            $this->teamsWonAgainst=[];
            $this->teamsLostAgainst=[];
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
            $this->teamsWonAgainst=[];
            $this->teamsLostAgainst=[];
		}
		
		//outputs names with data for testing
		function outputResults(){
			echo "Team: ", $this->names, "   ", $this->initials, "    ", 
				 $this->wins, "    ",$this->losses, "    ", 
				 $this->initialWeight, "   ", $this->finalWeight, "<br>";
		}
		function writeResultsToFile($year, $mode){
			$file = fopen("weightedWinsData$year.txt", "$mode");
			
			fwrite($file, "Team: ");
			fwrite($file, $this->names);
			fwrite($file, "   ");
			fwrite($file, $this->initials);
			fwrite($file, "    ");
			fwrite($file, $this->wins);
			fwrite($file, "    ");
			fwrite($file, $this->losses); 
			fwrite($file,"    ");
			fwrite($file, $this->initialWeight);
			fwrite($file,"   ");
			fwrite($file, $this->finalWeight);
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

		//adjusts the final weights for a win for all teams
		function adjustFinalWeightForWin($opponentWins, $opponentLosses){
			if($opponentWins > $opponentLosses){
				$addition = ($opponentWins-$opponentLosses) * 0.01;
				$this->finalWeight += $addition;
			}
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
        function linearTeamSearch($teamName){
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
		global $year;
		#$file = file("scoreData$year.txt");
		$winLossData = fopen("scoreData$year.txt", "r") or die("failed to open");
        $gameIndex=0;

		$teamIndex=0;

        $newTeamString = "Team: ";

		
		while(!feof($winLossData)){
			$opponentName=trim(fgets($winLossData));


			
			if(str_contains($opponentName, $newTeamString)){
                $newTeam = str_replace($newTeamString, "", $opponentName);
				$newTeam = trim($newTeam);

                $teamIndex=linearTeamSearch($newTeam);
				if($teamIndex==-1){
					echo cleanStr($newTeam) . "hi <br>";
					die("$newTeam not found in $opponentName");
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
		//$gameCountFile = fopen("gamecount.txt", "r") or die;
		//$gameCount = fgets($gameCountFile);
		$i=0;
		
		//fclose($gameCountFile);
		
		while(!feof($teamNames)){
			$teams[$i] = new Team();
			$teams[$i]->readInNames(fgets($teamNames), fgets($teamNames));
            $teams[$i]->readInNamesWithMascots(fgets($teamNamesWithMascots));
			//$teams[$i]->readInGameCount($gameCount);
			$i++;		
		}
		fclose($teamNames);
        fclose($teamNamesWithMascots);
	}

	//calculates the initial and final weights of the teams
	function calculateWeights(){
		global $teams;



		for($i=0;$i<count($teams);$i++){
			$teams[$i]->calculateInitialWeight();
		}

		for($i=0;$i<count($teams)-1;$i++){
			$teamsLostAgainst = $teams[$i]->getTeamsLostAgainst();
			$teamsWonAgainst = $teams[$i]->getTeamsWonAgainst();

			//adjusts weights for losses
			for($j=0;$j<count($teamsLostAgainst)-1;$j++){
				for($teamNames=0;$teamNames<count($teams)-1;$teamNames++)
					if($teams[$teamNames]->getName() == $teamsLostAgainst[$j]){
						$teams[$i]->adjustFinalWeightForLoss($teams[$teamNames]->getWins(), $teams[$teamNames]->getLosses());
						break;
					}
			}

			//adjust weights for wins
			for($j=0;$j<count($teamsWonAgainst)-1;$j++){
				for($teamNames=0;$teamNames<count($teams);$teamNames++)
					if($teams[$teamNames]->getName() == $teamsWonAgainst[$j]){
						$teams[$i]->adjustFinalWeightForWin($teams[$teamNames]->getWins(), $teams[$teamNames]->getLosses());
						
					}
			}
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

