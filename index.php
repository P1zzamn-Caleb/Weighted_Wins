<?php require "weightedWinsCalculator.php"?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Weighted Wins NCAA Basketball</title>
  <link rel="icon" type="image/x-icon" href="basketball_Logo.png">
  
  <style>
  body
  {
	text-align:center;
	background-color: #d3d3d3ff;
  }
  h1
  {
	font-family: Arial, sans-serif;
	font-size: 3.5em;
  }
  p {
	font-family: 'Courier New', Courier, monospace;
	color: white;
	line-height: 2.5;
	font-size: 1.1em;
  }
  
  a:link, a:visited
  {
	color: rgba(255, 255, 255, 1);
	text-decoration: none;
  }  
  a:hover, a:active
  {
	color: rgba(200, 200, 200, 1);
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

  #headerTable {
	align-items: center;
	border-collapse: collapse;
	background-color: #7d7d7dff;
  }

  #headerTh {
	
	background-color: #aaababff;
  }

  .container{
	display: flex;
	height: 100vh;
  }

  #headerTable, #sideBarandInfo {
	width: 80%;
	max-width:1200px;
  }

  #sideBarandInfo {
	margin: 0 auto;
	border-collapse: collapse;
	height: 15vh;
  }
  #sideBarandInfo tr:nth-child(even),
  #sideBarandInfo tr:nth-child(odd){
	background-color: transparent !important;
  }

  #sideBarTR {
	background-color: #b0dbffff;
  }
  #sideBarTH {
	background-color: #003c5fff;
	text-align: left;
  }
  #sideBarH1 {
	font-weight: 900;
	font-size: 1.4em;
	font-family: 'Courier New', Courier, monospace;
	color: white;
  }

  iframe {
	margin: 0 auto;
	background: transparent;
	border: none;
	vertical-align: top;
	width:100%;
	height:100%;
  }
  
  img {
	width: 10%;
	height: 25%;
  }

  .center-container {
	width: 80vw;
	margin: 0 auto;
	flex-direction: column;
	align-items: center;
  }

	table {
		border-collapse: collapse;
		height: 100%;
	}

	th, td {
		border: 1px solid #dbfbffff;
		padding: 8px;
		text-align: left;
	}

	ul{
		text-decoration: underline;
		font-family: 'Courier New', Courier, monospace;
		color: white;
		line-height: 1;
		font-size: 1.1em;
	}

	th {
		background-color: #9ac7ffff;
	}

	tr:nth-child(even) {
		background-color: #cfe6ffff;
	}

	tr:nth-child(odd) {
		background-color: #afd6ffff;
	}
	#infoTD {
		
		border: none;
		background-color: white;
		width: 100vw;
		vertical-align: top;
		text-align: center;
	}
  
  
  </style>
</head>
<body>

  

  

  <?php
	$iframeSRC = "";


   if(!isset($_POST['year']) && !isset($_POST['team'])){
		if(isset($_GET['choice'])){
			switch($_GET['choice']){
				case 'home':
					$iframeSRC = 'home.html?v='. time();
					break;
				case 'weightsDetermined':
					$iframeSRC = "weightedWinsDetermined.html";
					break;
				case 'standingsDetermined':
					$iframeSRC = "standingsDetermined.html";
					break;
				case 'criteria':
					$iframeSRC = "criteria.html";
					break;
				case 'discussion':
					$iframeSRC = "discussion.html";
					break;
				case 'about':
					$iframeSRC = "about.html";
					break;
				case 'wwStandings':
					$iframeSRC = "weightedWinsProgramOutput.php";
					break;
				case "":
					$iframeSRC = "home.html";
					break;
			}
		}

		echo "<div class= 'center-container'>
				<table>
					<tr>
						<th id='headerTh' colspan='2'>
							<div style='display:flex;'>
							<img src='basketball_Logo-removebg-preview.png' style='float:left'>
								<div style= 'text-align:left;'>
									<h1>Weighted Wins <br></h1>
										<i style='font-size: 1.5em;'>NCAA Division I Basketball Standings</i>
								</div>
							</div>
						</th>
					</tr>
				";
	//make new HTML files to output the random data and attatch it to these
			echo "
					<tr id='sideBarTR'>
						<th id='sideBarTH'> 
							<b id='sideBarH1'>Menu <br></b>
							
							<ul>
							<a href= '?choice=home'>WW Home</a><br><br>
							</ul>
							<ul>
							<a href = '?choice=weightsDetermined'>How Weights are Determined</a><br><br>
							</ul>
							<ul>
							<a href = '?choice=standingsDetermined'>How Standingss are Determined</a><br><br>
							</ul>
							<ul>
							<a href= '?choice=criteria'>WW Criteria</a><br><br>
							</ul>
							<ul>
							<a href='?choice=wwStandings'>WW Standings</a><br><br>
							</ul>
							<ul>
							<a href='?choice=discussion'>Discussion</a><br><br>
							</ul>
							<ul>
							<a href='?choice=about'>About WW</a><br><br>
							</ul>
							<ul>
							Administration<br><br>
							</ul>
						</th>
						<td id='infoTD' rowspan='2'>
							<iframe name='contentOutput' src='$iframeSRC'></iframe>
						</td>
					</tr>
					<tr>
					<th id='sideBarTH'><b id='sideBarH1'>
						Other Links
					</b>
						<p>
						</p>
						</th>
						
					</tr>
				</table>
				</div>";
	}
?>


</body>
</html>

