<?php require "weightedWinsCalculator.php"?>
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
	background-color: #d3d3d3ff;
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

  <h1>
  <img src="https://pics.clipartpng.com/Under_Construction_Warning_Sign_PNG_Clipart-839.png" style="float:left; width:200px;height200px;">
  <img src="https://static.vecteezy.com/system/resources/previews/045/809/909/non_2x/a-yellow-hard-hat-on-a-transparent-background-free-png.png" 
  style="float:right; width:200px;height200px;">
  This website is currently under construction!
  </h1>
  
  <p>The current <a href="http://www.weightedwins.com" target="_blank">website</a> for NCAA D1 football rankings.<br></p>
  
  
  <p><a href="http://www.weightedwins.com"target="_blank" id="buttons">A button for funsies</a></p>

  

  <?php
   if(!isset($_POST['year']) && !isset($_POST['team'])){
	echo "<form method='post' target = '_blank'>
    <select name='year' onchange='this.form.submit()'>
		<option value=''>Select an option</option>
		<option value='2025'>2024-2025</option>
		<option value='2024'>2023-2024</option>
		<option value='2023'>2022-2023</option>
		<option value='2022'>2021-2022</option>
		<option value='2021'>2020-2021</option>
		<option value='2020'>2019-2020</option>
		<option value='2019'>2018-2019</option>
		<option value='2018'>2017-2018</option>
		<option value='2017'>2016-2017</option>
		<option value='2016'>2015-2016</option>
		<option value='2015'>2014-2015</option>
		<option value='2014'>2013-2014</option>
		<option value='2013'>2012-2013</option>
		<option value='2012'>2011-2012</option>
		<option value='2011'>2010-2011</option>
		<option value='2010'>2009-2010</option>
		<option value='2009'>2008-2009</option>
		<option value='2008'>2007-2008</option>
		<option value='2007'>2006-2007</option>
		<option value='2006'>2005-2006</option>
		<option value='2005'>2004-2005</option>
		<option value='2004'>2003-2004</option>
		<option value='2003'>2002-2003</option>
</select>
</form>";
   }
?>

<?php
	getData();

	foreach($teams as $index => $team){
		$teamNameIndexMap[cleanStr($team->getName())] = $index;
	}
?>  
<table>
    
	<?php
		session_start();

		if (isset($_POST['year'])) {
			$_SESSION['year'] = $_POST['year'];
			$selectedYear = $_POST['year'];

		echo "<h1>$selectedYear Results</h1><br>";
		echo "<thead>
				<tr>
					<th>Team</th>
					<th>Initials</th>
					<th>Counted Games</th>
					<th>Wins</th>
					<th>Losses</th>
					<th>IW</th>
					<th>FW</th>
					<th>WW</th>
				</tr>
			</thead>";
	
		runProgram($selectedYear);
		printData();

		

		}
	?>
	</tbody>
</table>

<table>
    
	<?php
		if (isset($_POST['team'])) {
		$selectedTeam = $_POST['team'];
		$selectedYear = $_SESSION['year'];

		echo "<h1>$selectedTeam Results</h1><br>";
		echo "<thead>
				<tr>
					<th>Opponent</th>
					<th>Counted Games</th>
					<th>Result</th>
					<th>Opponent FW</th>
					<th>FW Adj</th>
					<th>Value Added</th>
				</tr>
			</thead>";
	
		runProgram($selectedYear);
		callPrintDetailedData($selectedTeam);

		

		}
	?>
	</tbody>
</table>
</body>
</html>

