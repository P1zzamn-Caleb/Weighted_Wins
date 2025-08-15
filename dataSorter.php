<!DOCTYPE html>
<html>
<body>

    <?php

        class Team{
            private $initials;
            private $names;
            private $nameWithMascots;
            private $totalGames;
            private $wins; 
            private $losses;
            private $initialWeight;
            private $finalWeight;
            private $weightedWins;

            //starts each team out with 0 wins and 0 losses
            function __construct(){
                $this->totalGames= 0;
                $this->wins=0;
                $this->losses=0;
                $this->initialWeight=1;
                $this->finalWeight=1;
                $this->weightedWins=0;
                $this->initials="";
                $this->names="";
                $this->nameWithMascots="";
            }

            function resetData(){
                $this->totalGames= 0;
                $this->wins=0;
                $this->losses=0;
                $this->initialWeight=1;
                $this->finalWeight=1;
                $this->weightedWins=0;
                $this->initials="";
                $this->names="";
                $this->nameWithMascots="";
            }

            //reads in names and initials of the teams
            function readInNames($name, $initial){
                $this->names= trim($name);
                $this->initials= trim($initial);
            }
            //reads in all game results for the team
            function readInGameResults($totalGame, $totalWins, $totalLosses){
                $this->totalGames = $totalGame;
                $this->wins = $totalWins;
                $this->losses = $totalLosses;
            }
            //reads in all weights of the team
            function readInWeights($initialWeights, $finalWeights, $weightedWin){
                $this->initialWeight = $initialWeights;
                $this->finalWeight = $finalWeights;
                $this->weightedWins = $weightedWin;
            }

            //returns the weighted wins of a team
            function returnWeightedWins(){
                return $this->weightedWins;
            }

            //returns initial weight
            function returninitialWeight(){
                return $this->initialWeight;
            }

            //returns final weight
            function returnFinalWeight(){
                return $this->finalWeight;
            }

            //returns name without the mascots
            function returnNameWithoutMascot(){
                return $this->names;
            }

            //returns the name with the mascots
            function returnNameWithMascots(){
                return $this->nameWithMascots;
            }

            //returns total wins
            function returnTotalWins(){
                return $this->wins;
            }

            //returns total losses
            function returnTotalLosses(){
                return $this->losses;
            }
            

        }

        $teams = [];

        function getData($year){
            global $teams;
            $teamNames = fopen("newData.txt", "r") or die;
            $teamNamesWithMascots = fopen("teamNames.txt", "r") or die;
            $weightedWinsFile = fopen("weightedWinsData$year.txt", "r") or die;
            $namesWithoutMascots = [];
            $namesWithMascots = [];
            $i=0;

        
            
            while(!feof($teamNames)){
                $namesWithoutMascots[$i] = fgets($teamNames);
                $namesWithMascots[$i] = fgets($teamNamesWithMascots);
                $i++;		
            }

            fclose($teamNames);
            fclose($teamNamesWithMascots);

            while(!feof($weightedWinsFile)){
                $teams[$i] = new Team();
                $teams[$i]->readInNames(fgets($weightedWinsFile), fgets($weightedWinsFile));
                $teams[$i]->readInGameResults(fgets($weightedWinsFile), fgets($weightedWinsFile), fgets($weightedWinsFile));
                $teams[$i]->readInWeights(fgets($weightedWinsFile), fgets($weightedWinsFile), fgets($weightedWinsFile));

                $i++;
            }
        }

        function sortTeams(){
            global $teams;

            usort($teams, function($a, $b) {
                return $b->returnWeightedWins() <=> $a->returnWeightedWins();
            });
        }

        function printData(){
            global $teams;

            $rank =0;
            

            foreach($teams as $index => $team){
                $rank = $index+1;
                $teamName = $team->returnNameWithoutMascot();
                $teamWins = $team->returnTotalWins();
                $teamLosses = $team->returnTotalLosses();
                $teamInitialWeight = $team->returnInitialWeight();
                $teamFinalWeight = $team->returnFinalWeight();
                $teamWeightedWins = $team->returnWeightedWins();

                
                echo "Rank          Team           Wins            Losses                   IW                        FW                        WW        <br>";
                echo "$rank       $teamName      $teamWins       $teamLosses         $teamInitialWeight         $teamFinalWeight        $teamWeightedWins <br>";
            }
        }

        getData(2025);
        sortTeams();
        printData();



    ?>


</body>
</html>