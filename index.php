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

<form method="post" target = "_blank">
    <select name="year" onchange="this.form.submit()">
  <option value="2025">2024-2025</option>
  <option value="2024">2023-2024</option>
  <option value="2023">2022-2023</option>
  <option value="2022">2021-2022</option>
  <option value="2021">2020-2021</option>
  <option value="2020">2019-2020</option>
  <option value="2019">2018-2019</option>
  <option value="2018">2017-2018</option>
  <option value="2017">2016-2017</option>
  <option value="2016">2015-2016</option>
  <option value="2015">2014-2015</option>
  <option value="2014">2013-2014</option>
  <option value="2013">2012-2013</option>
  <option value="2012">2011-2012</option>
  <option value="2011">2010-2011</option>
  <option value="2010">2009-2010</option>
  <option value="2009">2008-2009</option>
  <option value="2008">2007-2008</option>
  <option value="2007">2006-2007</option>
  <option value="2006">2005-2006</option>
  <option value="2005">2004-2005</option>
  <option value="2004">2003-2004</option>
  <option value="2003">2002-2003</option>
</select>
</form>
<?php
	getData();

	foreach($teams as $index => $team){
		$teamNameIndexMap[cleanStr($team->getName())] = $index;
	}
?>  

<?php
	if (isset($_POST['year'])) {
    $selectedYear = $_POST['year'];
    	runProgram($selectedYear);
	}
?>
</body>
</html>

