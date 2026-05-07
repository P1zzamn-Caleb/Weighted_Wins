<?php require "weightedWinsCalculator.php" ?>

<?php
    const LATEST_YEAR=2025;
    const EARLIEST_YEAR=2003;

    class wikepediaTeams
    {
        private $teamName = "";
        private $berthType = "";

        public function setBerthType($berth)
        {
            $this->berthType = $berth;
        }

        public function setTeamName($name)
        {
            $this->teamName = $name;
        }

        public function getName()
        {
            return $this->teamName;
        }
            
        public function getBerth()
        {
            return $this->berthType;
        }





    }
    getData();
    foreach($teams as $index => $team){
		$teamNameIndexMap[cleanStr($team->getName())] = $index;
	}
    main();
   
    function main()
    {
        global $teams;
        global $teamNameIndexMap;
        
        
        for($year=LATEST_YEAR;$year>EARLIEST_YEAR;$year--)
        {
            $teams = [];
            getData();
            echo "$year <br>";
            $wikepediaTeam = [];
            runProgram($year);
            /*foreach($teams as $te)
            {
                echo "Team: " .  $te->getName() . "<br>";
            }*/
            returnTeamandBerth($year, $wikepediaTeam);
            $teamsNotinWW = compareResults($wikepediaTeam);
            for($i=0;$i<sizeof($teamsNotinWW);$i++)
            {
                echo "not in ". $teamsNotinWW[$i] . " " . $teamNameIndexMap[$teamsNotinWW[$i]] . "<br>";
            }
            
            



        }
        
    }


    function returnTeamandBerth($year, &$wikepeidaTeam)
    {
        global $teams;
        global $teamNameIndexMap;
        $file= fopen("wikepediaData$year.txt", "r") or die;
        
        $autoText = "Auto";
        $atLargeText = "At-Large";
        $fileLineIndex=0;

        while($line = fgets($file))
        {
            $wikepeidaTeam[$fileLineIndex] = new wikepediaTeams();
            $biggestTeamSize=0;
            for($i=0;$i<sizeof($teams);$i++)
            {
                if(str_contains($line, $teams[$i]->getName()))
                {
                    if(strlen($teams[$i]->getName()) > $biggestTeamSize)
                    {
                        $biggestTeamSize = strlen($teams[$i]->getName());
                        
                        $wikepeidaTeam[$fileLineIndex]->setTeamName(cleanStr($teams[$i]->getName()));
                        if(str_contains($line, $autoText))
                        {
                            $wikepeidaTeam[$fileLineIndex]->setBerthType("Automatic");
                        }
                        else
                        {
                            $wikepeidaTeam[$fileLineIndex]->setBerthType("At-Large");
                        }
                    }
                }
            }

            $fileLineIndex++;
        }

        fclose($file);
    }

    function createHashMap(&$wikepediaTeams)
    {
        $wikiMap=[];

        foreach($wikepediaTeams as $index => $tea){
			$wikiMap[$tea->getName()] = $index;
		}

        return $wikiMap;
    }

    #was working on this
    function compareResults(&$wikepediaTeams)
    {
        global $teams;
        $automaticText = "Automatic";
        $atLargeText= "At-large";

        
        $wikiTeams = [];
        $allBerths = [];
        foreach ($wikepediaTeams as $team) {
            
            if(cleanStr($team->getName()) != ""){
                $allBerths[] = $team->getBerth();
                $wikiTeams[] = cleanStr($team->getName());
            }
            
        }
        
        $wikiMap = createHashMap($wikepediaTeams);
        $arrayCount=array_count_values($allBerths);
        $automaticCount=$arrayCount[$automaticText] ?? 0;
        $teamsInWW = [];
        $teamsNotInWW = [];
        $totalTeamsCounted=0;


        for($i=0;$i<sizeof($wikepediaTeams);$i++)
        {
            if($totalTeamsCounted > (sizeof($wikepediaTeams)-$automaticCount)){
                echo "Moin <br>";
                break;
            }
            
            if(in_array(cleanStr($teams[$i]->getName()), $wikiTeams))
            {
                
                
                if($wikepediaTeams[$wikiMap[$teams[$i]->getName()]]->getBerth() == $automaticText)
                {
                    continue;
                }
            }
            $teamsInWW[] = $teams[$i]->getName();
            $totalTeamsCounted++;
        }

        for($j=0;$j<sizeof($allBerths);$j++)
        {
            if(!str_contains($allBerths[$j], $automaticText))
            {
                if(!(in_array($wikiTeams[$j], $teamsInWW)))
                {
                    
                    $teamsNotInWW[] = $wikiTeams[$j];
                }
            }
        }

        return $teamsNotInWW;

    }


?>