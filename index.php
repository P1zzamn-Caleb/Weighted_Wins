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
	width: 100%;
	border-collapse: collapse;
	background-color: #7d7d7dff;
  }

  #headerTh {
	background-color: #aaababff;
  }

  #sideBar {
	width: 20%;
	border-collapse: collapse;
	height: 15vh;
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
  

	table {
		width: 100%;
		border-collapse: collapse;
	}

	th, td {
		border: 1px solid #dbfbffff;
		padding: 8px;
		text-align: left;
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
  
  
  </style>
</head>
<body>

  

  

  <?php
   if(!isset($_POST['year']) && !isset($_POST['team'])){
	echo "<table id='headerTable'>
			<tr>
				<th id='headerTh'><h1>Weighted Wins <br></h1><i>NCAA Division I Basketball Standings</i></th>
			</tr>
  		  </table>";

	echo "<table id='sideBar'>
			<tr id='sideBarTR'>
				<th id='sideBarTH'> 
					<b id='sideBarH1'>Menu <br></b>
					<p>
					WW Home<br>
					How Weights are Determined<br>
					WW Criteria<br>
					<a href='weightedWinsProgramOutput.php' target='contentFrame'>WW Standings</a><br>
					About WW<br>
					Administration<br>
					</p>
				</th>
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

		   echo "<iframe name='contentFrame' width='80%' height='600px' style='border:none;'></iframe>";
   }
?>


</body>
</html>

