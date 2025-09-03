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
	margin: 0 auto;
	width: 50%;
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

  #sideBarandInfo {
	margin: auto;
	width: 50%;
	border-collapse: collapse;
	height: 15vh;
  }
  #sideBarandInfo tr:nth-child(even),
  #sideBarandInfo tr:nth-child(odd){
	margin: 0 auto;
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
	background: transparent;
	border: none;
	vertical-align: top;
  }
  

	table {
		
		width: 100%;
		border-collapse: collapse;
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
		background-color: transparent;
		width: 80vw;
		vertical-align: top;
		text-align: center;
	}
  
  
  </style>
</head>
<body>

  

  

  <?php
   if(!isset($_POST['year']) && !isset($_POST['team'])){
	echo "<table id='headerTable'>
			<tr>
				<th id='headerTh'>
					<div style='display:flex;'>
					<img src='basketball_Logo.png' style='width:10vw; height:20vh; item-align:left;'>
						<div style= 'text-align:left;'>
							<h1>Weighted Wins <br></h1>
								<i style='font-size: 1.5em;'>NCAA Division I Basketball Standings</i>
						</div>
					</div>
				</th>
			</tr>
  		  </table>";
//make new HTML files to output the random data and attatch it to these
	echo "<table id='sideBarandInfo'>
			<tr id='sideBarTR'>
				<th id='sideBarTH'> 
					<b id='sideBarH1'>Menu <br></b>
					
					<ul>
					WW Home<br><br>
					</ul>
					<ul>
					How Weights are Determined<br><br>
					</ul>
					<ul>
					WW Criteria<br><br>
					</ul>
					<ul>
					<a href='weightedWinsProgramOutput.php'; target='weightedWinsStandings';>WW Standings</a><br><br>
					</ul>
					<ul>
					About WW<br><br>
					</ul>
					<ul>
					Administration<br><br>
					</ul>
				</th>
				<td id='infoTD'>
					<iframe name='weightedWinsStandings'></iframe>
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
		  </table>";
   }
?>


</body>
</html>

