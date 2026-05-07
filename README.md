# Weighted Wins Hoops

A data-driven college basketball ranking website focused on ranking teams using the weighted wins algorithm.

## Website

http://www.weightedwins.com/hoops/

## Overview

The basic premise of "Weighted Wins" is one the average fan would readily accept. All wins are not equal. Defeating a highly successful team, one with a winning record, is more difficult than defeating an unsuccessful team, one with a losing record. Therefore, the system assigns a weight to each opponent. This weight is determined in a fair, unbiased, and systematic manner by considering a team's record and the records of its opponents. After the weights are assigned, teams accumulate weighted wins and weighted losses.


## Features

- Custom weighted wins ranking system  
- NCAA men’s college basketball team rankings  
- Team performance comparisons  
- Season-by-season data tracking  
- Simple, easy-to-use web interface  

## How It Works

### INITIAL WEIGHT

In sports, teams with a .500 winning percentage are considered average teams. Therefore, assigning a weight of 1.00 to a .500 team was the starting point for establishing the Initial Weight.

The Initial Weight (IW) is a reflection of a team's own record against all Division 1-A opponents. The Initial Weight (IW) can be computed at any time during the season; it is an indication of its current record. The IW takes into consideration all games played against Division 1-A teams. During the season, the Initial Weight for any team with the same number of wins and losses would be IW = 1.00. (ie. records of 1-1, 2-2, 3-3, 4-4, or 5-5 ) A team's IW changes each week as it accumulate wins and losses. At the end of a season, a team with a 6-6 record would have an Initial Weight of 1.00.

A team's IW increases by .01 for each win more than the number of losses, and deceases by .01 for each loss more than the number of wins. For example, a team with a 9-3 record would have an IW of 1.06 (six more wins than losses), while a team with a 3-8 record would have an IW of .95 (five more losses than wins). During the season, a team may have a 4-3 record and have an Initial Weight of 1.01, if this team won the following week, its record would be 5-3 with an IW = 1.02. At any time during the season, the Initial Weight is determined by the games it has played up to that point.
```text
Adjustments to the IW are:

	1.08 (IW or initial weight of team with a 10-2 record) 
	+.10 (for win over 11-1 team, 10 more wins than losses)
	+.02 (for win over 7-5 team, 2 more wins than losses)
	+.06 (for win over 9-3 team, 6 more wins than losses)
	+.04 (for win over 8-4 team, 4 more wins than losses)
	1.30 (Final Weight for this team)
```

Since defeating a losing team and losing to a winning team does not affect the Final Weight, the only adjustments to the Initial Weight for the team in this example are illustrated above.

Another example may better illustrate how the Initial Weight of a team decreases by losing to a losing team. A team with a 5-6 record loses to three winning teams, a team with a 4-7 record, a team with a 3-8 record, and a Non-Division 1-A team for a total of six losses. Four of the wins were over losing teams and one over a team with a 6-5 record. 
```text
Adjustments to the IW are:

	 .99 (IW of team with a 5-6 record)
	-.03 (for loss to 4-7 team, 3 more losses than wins)
	-.05 (for loss to 3-8 team, 5 more losses than wins)
       	-.10 (all losses to Non-Division 1-A teams are -.10)
	+.01 (for win over 6-5 team, 1 more win than losses)
	 .82 (Final Weight for this team)
```
There are no adjustments for the wins over the losing teams or losses to the winning teams. (See criteria)

### Final Weight
After the IW has been established, adjustments are made to develop the Final Weight (FW). As with the Initial Weight, the Final Weight can be determined at any time during the season and only considers the games played up to that point. This enables rankings to be computed after games each week. The adjustments are made only for wins against winning teams and losses to losing teams (See Criteria). Defeating a winning team is considered a sign of strength, and losing to a losing team is considered a sign of weakness. For example, a team with a 10-2 record has defeated teams with records of 11-1, 7-5, 9-3, 8-4, and six losing teams. The losses were both to winning teams. 
```text
Adjustments to the IW are:

	1.08 (IW or initial weight of team with a 10-2 record) 
	+.10 (for win over 11-1 team, 10 more wins than losses)
	+.02 (for win over 7-5 team, 2 more wins than losses)
	+.06 (for win over 9-3 team, 6 more wins than losses)
	+.04 (for win over 8-4 team, 4 more wins than losses)
	1.30 (Final Weight for this team)
```
Since defeating a losing team and losing to a winning team does not affect the Final Weight, the only adjustments to the Initial Weight for the team in this example are illustrated above.

Another example may better illustrate how the Initial Weight of a team decreases by losing to a losing team. A team with a 5-6 record loses to three winning teams, a team with a 4-7 record, a team with a 3-8 record, and a Non-Division 1-A team for a total of six losses. Four of the wins were over losing teams and one over a team with a 6-5 record. 
```text
Adjustments to the IW are:

	 .99 (IW of team with a 5-6 record)
	-.03 (for loss to 4-7 team, 3 more losses than wins)
	-.05 (for loss to 3-8 team, 5 more losses than wins)
       	-.10 (all losses to Non-Division 1-A teams are -.10)
	+.01 (for win over 6-5 team, 1 more win than losses)
	 .82 (Final Weight for this team)
```

There are no adjustments for the wins over the losing teams or losses to the winning teams. (See criteria)

## Criteria


The criteria for Weighted Wins are built on wins and the quality of those wins. Defeating a winning team adds to your weight, while losing to a losing team reduces your weight. The following criteria incorporate the logic of the system:

The Initial Weight (IW) of a team reflects its own record. (All games against Division I-A teams and losses to Non-Division I-A teams are counted in determining IW.)
The Final Weight (FW) of a team reflects the strength of schedule of that team based on the given conditions:
Defeating a winning team increases the winning team's Final Weight.
Defeating a losing team does not increase the winning team's Final Weight.
Losing to a winning team does not reduce the losing team's Final Weight.
Losing to a losing team reduces the losing team's Final Weight.
Losing to a Non-Division 1-A team reduces the losing team's Final Weight.
In the computing process, losses are counted first.
Games against Non-Division 1-A teams do not count if a victory occurs, however, losses to Non-Division 1-A teams are penalized.
Because all teams do not play the same number of games, only ten games are counted towards the Weighted Wins (WW) in a regular eleven game season. Although most teams play more than ten games, the effectiveness of the system is not diminished by omitting games against one weaker team. This allows some crossover between Division 1-A and other divisions. In the event of an expanded schedule, if all top ten teams have played twelve games, then eleven games could be calculated.
All games played throughout the season are treated equally. A quality team that defeats another quality team early in the season receives as much credit as a quality team that defeats another quality team late in the season. The season ending record is what ultimately counts.
During the season, standings are determined by calculating the Initial Weights and Final Weights based on the games played up to that point.


## Data Processing

Game data is collected and processed using custom scripts from the ESPN website at the end of each season. 
The data is then used to compute rankings and update the site at the end of the season.

## Project Structure

```text
Assets/
└── Weighted_Wins_Poster.jpg
Scraping/
├── originalScraper.py 
├── teamNameandInitialGetter.py
└── updatedScraper.py 
Website/
├── data/ 
├── Comparisons/
├──── ncaaComparisons.php
├── images/
├── about.html
├── criteria.html
├── discussion.html
├── home.html
├── index.html
├── index.php
├── standingsDetermined.html
├── weightedWinsCalculator.php
├── weightedWinsDetermined.html
└── weightedWinsProgramOutput.php
.gitignore
README.md

```


## Disclaimer

This is an independent project and is not affiliated with the NCAA, ESPN, or any official sports organization.

## Author
```md
Created by Caleb Ellis
Based off of a football version of weighted wins by Dr. Mark Terwilliger
Formula by Dr. Ray Theis
```
