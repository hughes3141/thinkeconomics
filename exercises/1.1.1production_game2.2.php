<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

include "../header.php";
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path."/php_header.php");
    include($path."/php_functions.php");

    if (!isset($_SESSION['userid'])) {
  
      header("location: /login.php");
      
    }
    
    else {
      $userInfo = getUserInfo($_SESSION['userid']);
      $userId = $_SESSION['userid'];
      $permissions = $userInfo['permissions'];

      }
      //print_r($userInfo);

		
		
		/*
		
		2.2 Seeks to incorporate adding high score facility upon finishing game.
    Update 6 Feb 2023: Cleaned up to ensure all user input data goes through bound parameterisation.
		
		
		*/


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //print_r($_POST);

      $name = $userInfo['name_first'];
      $score = $_POST['score'];
      $datetime = date("Y-m-d H:i:s");
      $activityid = 1;

      $data = array();

      array_push($data, $name, $score);

      $data = json_encode($data);

      $sql = "INSERT INTO activities_responses 
              (data, datetime, activityid, userid) 
              VALUES (?,?,?,?)";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssii", $data, $datetime, $activityid, $userId);
      $stmt->execute();
      //echo "Record entered successfully";

    }

?>
  
  <html>

	<head>


<style>



table, th, td {
  border: 1px solid black;
 // font-size: 30pt;
   border-collapse: collapse; 

   
}

th {
//font-size: 16pt;
}


table {
	float: left;
	//width: 50%;
	//margin: 0px 10px 0px -40px;
	margin: 10px;
	table-layout: fixed;
	

}

td {
	text-align: center;
}

p, li, button {
//font-size:30pt;
}

#review {
	
	    width: 60%;
    height: 80%;
    border: 20px solid pink;
    background-color: white;
	padding: 20px;
    margin: auto;
    z-index: 10;
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
	
display: none;

	
}


#review3 {
	
	width: 80%;
	height: 100%;
	border: 5px solid black;
	background-color: pink;
	 margin: auto;
	z-index: 10;
	position:fixed;
	
	left: 50%;	transform: translateX(-50%);
	
display: none;

	
}

#review2 {
	
	width: 70%;
	height: 80%;
	border: 5px solid black;
	background-color: white;
	 margin: auto;
	//z-index: 10;
	position:fixed;
	
	left: 50%;	transform: translateX(-50%);
	
	top: 30px;
	padding: 10px;
	


	
	
}

.highScoreTable td, th {
	
	
	padding: 5px;
	
}
	


</style>



	</head>

	<body>
	
	
	<div id="review">
	

		
		<p>Well done, you've played the game and your score was <span id="totalUtil2"></span>.</p>
		<p>Choose what you want to do next:</p>
		<ul>
		<li><button onclick="playAgain()">Play again</button></li>
		<form method="post" action ="" id ="form1">
		<li><input type="submit" value="Submit To Scoreboard"></li>
		</ul>
		<p>
		<label for="f1">Name:</label>
		<input type ="hidden" name ="name" id = "f1" value="<?=$userInfo['name_first']?>"></p>
		<input type ="hidden" name ="score" id = "f2">
		
		</form>
		
		<table class="highScoreTable">
		<tr><th>Name</th><th>Score</th></tr>
		
<?php 



		




$sql = "SELECT * FROM activities_responses WHERE activityid='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();



$allData = array();

if($result->num_rows>0) {
  while($row = $result->fetch_assoc()) {

    $data = $row['data'];
		$data = json_decode($data);
		array_push($data, $row['datetime']);
		//echo "<br>";
		//print_r($data);
		//echo "<br>";
		array_push($allData, $data);

  }
}


	
	//print_r($allData);
	



 usort($allData, function ($a, $b) {
    return $b[1] - $a[1];
});

//print_r($allData);



for ($x=0; $x<=5; $x++) {
	
	echo "<tr><td>";
	
	echo $allData[$x][0];
	echo "</td><td>";
	echo $allData[$x][1];
	echo "</td></tr>";
	
}
		
		?>
		
		
		</table>
		
		
		

	</div>
	
	<?php include "../navbar.php";?>




<h1>The Production Game</h1>	

<p>You are in charge of a fictional economy. The scarce factors of production in this economy are <strong>capital</strong> and <strong>labour</strong>.</p>
<p>You decide what to produce in this economy between the following types of goods:</p>
<ul>
<li>Consumer goods. These goods make your citizens happy (they provide utility).</li>
<li>Capital goods. These goods do not make your citizens happy, but they are used to produce machines that can make more goods the following year.</li>
</ul>
<p>Producing each type of good requires the following factors of production</p>
<ul>
<li>1 Consumer Good = 2 Workers</li>
<li>1 Consumer Good = 1 Machine</li>
<li>1 Capital Good = 4 Workers</li>
<li>1 Capital Good = 2 Workers + 1 Machine</li>
<li>1 Capital Good = 2 Machines</li>
</ul>
<p>You could also think about your constraints in terms of &ldquo;production units&rdquo;:</p>
<ul>
<li>1 Worker <em>provides</em> 1 Production Unit</li>
<li>1 Machine <em>provides</em> 2 Production Units</li>
<li>1 Consumer Good <em>requires</em> 2 Production Units</li>
<li>1 Capital good <em>requires</em> 4 Production Units</li>
</ul>

<div id="game" style="display: block; border:solid; float:none; position:relative; padding: 10px; margin: 5px; background:cream;">
	<p>Year: <span id="year">1</span></p>
	<p>Number of workers: <span id="workerCount">4</span></p>
	<p>Number of machines: <span id="machineCount">4</span></p>
	<p style="display:;">Use of Production Capacity: <span id="productionPlan">0</span>/<span id="prodUnits">12</span></p>
	<p style="display:none">(Value of productive capacity: &#163;<span id="prodMoney">120</span>)</p>
	<p>Consumer Goods<span style="display:none"> (each costs &#163;20)</span>: 
	
	<select  id="conGoods" onchange="capMax(), productionUpdate()" style="/*width:60px; height: 60px;*/" >
	
	</select>
	
	</p>
	<p>Capital Goods<span style="display:none"> (each costs &#163;40)</span>: 
	<select id="capGoods" onchange="conMax(), productionUpdate()" style="/*width:60px; height: 60px;*/">
	
	</select></p>
	
	<button id="button" style="/*width:100*/">Produce Goods for This Year</button>
	

	
	<p>Utility this year: <span id="util"></span></p>
	<p>Total Utility (All Years): <span id="totalUtil">0</span></p>
	
	</div>
	
<div style="display:none">
<p>The factors of production are Land, Labour (workers), Capital (machines), and Enterprise. These factors are combined to make the goods and services that citizens of the economy wish to consume.</p>
<p>Below are the details for a fictional economy. For simplicity, assume that we have as much Land and Enterprise as is necessary. Capital and Labour, however, are limited.</p>
<p>You are the planner for this economy. Your aim is to make your people as happy as possible over a ten-year period.</p>
<p>Your economy can make two types of products:</p>
<ul>
	<li>Consumer goods (e.g. clothing, phones, eating out). These make your citizens happy. <b>Each consumer good costs &#163;20 to make.</b></li>
	<li>Capital goods (e.g. machines and robots). These do not make your citizens happy but help you to make more consumer goods in the future. <b>Each capial good costs &#163;40 to make.</b></li>
</ul>
<p>You have workers (labour) and machines (capital) that can produce these goods.</p>
<ul>
	<li><b>Each worker can produce &#163;10 worth of goods</b></li>
	<li><b>Each machine can produce &#163;20 worth of goods</b></li>
	</ul>
<p>Using this information, you can work out how many consumer goods and capital goods you can produce given a number of workers and machines. e.g.:</p>
<ul>
	<li>2 workers (2 x &#163;10 = &#163;20) can produce 1 consumer good (&#163;20)</li>
	<li>1 machine (&#163;20) can produce 1 consumer good (&#163;20)</li>
	<li>4 workers (4 x &#163;10 = &#163;40) can produce 1 capital good (&#163;40)</li>
	<li>2 workers and 1 machine (2 x &#163;10 + &#163;20 = &#163;40) can produce 1 capital good (&#163;40)</li>
	<li>2 machines (2 x &#163;20 = &#163;40) can produce 1 capital good (&#163;40) </li>
	
</ul>
</div>

<table>
  <tr>
    <th>Consumer goods produced this year</th>
    <th>Happiness (also known as utility)</th>
<tr><td>0</td><td>0</td></tr>
<tr><td>1</td><td>20</td></tr>
<tr><td>2</td><td>39</td></tr>
<tr><td>3</td><td>57</td></tr>
<tr><td>4</td><td>74</td></tr>
<tr><td>5</td><td>90</td></tr>
<tr><td>6</td><td>105</td></tr>
<tr><td>7</td><td>119</td></tr>
<tr><td>8</td><td>132</td></tr>
<tr><td>9</td><td>144</td></tr>
<tr><td>10</td><td>155</td></tr>
<tr><td>11</td><td>165</td></tr>
<tr><td>12</td><td>174</td></tr>
<tr><td>13</td><td>182</td></tr>
<tr><td>14</td><td>189</td></tr>
<tr><td>15</td><td>195</td></tr>
<tr><td>16</td><td>200</td></tr>
<tr><td>17</td><td>204</td></tr>
<tr><td>18</td><td>207</td></tr>
<tr><td>19</td><td>209</td></tr>
<tr><td>20</td><td>210</td></tr>

</table>

<p>To start (in year 0) your economy has 4 workers and 4 machines</p>
<p>Each year, your worker populaiton will grow by 1 (population inrease)</p>
<p>Each year, the number of machines will decrease by 1 (depreciation)</p>
<p>The Happiness (Utility) Table shows how happy your citizens will be from having a certain number of <b>consumer goods</b> produced in a year. Only consumer goods make your citizens happy.</p>
<p>Any capital goods you produce in a year will be added to the number of machines you have the next year.</p>
<p>Your task: Decide on the mix of consumer goods and capital goods that will give your citizens the most happiness (utility).</p>
<p>The winning team is the team with the highest total utility over the 10 year period.</p>
<p>You can compare your score against the all-time leader board below:</p>
		<table class="highScoreTable">
		<tr><th>Name</th><th>Score</th></tr>
		
<?php 
		


for ($x=0; $x<=5; $x++) {
	echo "<tr><td>";
	echo $allData[$x][0];
	echo "</td><td>";
	echo $allData[$x][1];
	echo "</td></tr>";
	
}
		
		?>
		
		
		</table>


<?php include "../footer.php";?>

<script type="text/javascript">
		
		var workers = 4;
		var machines = 4;
		var year = 1; 
		var totalUtil=0;
		
		var conGoods = document.getElementById("conGoods").value;
		var capGoods = document.getElementById("capGoods").value;
		var util, prodMoney, consMoney;
		
		var money, moneyLeft, prodMoney, consMoney;
		var maxCapitalProduction;
		var maxConsumerProduction;
		
		var prodUnits = workers + machines*2;
		
		prodMoney = (workers*10)+(machines*20);
		//consMoney = conGoods*20 + capGoods*40;
		
		capMax();
		conMax();
		
		function removeOptions(selectElement) {
			var i, L = selectElement.options.length - 1;
			for(i = L; i >= 0; i--) {
				selectElement.remove(i);
			}
		}

		function displayReview() {
			
			
			document.getElementById("review").style.display="block";
			//document.getElementById("review2").style.display="block";
			document.getElementById("totalUtil2").innerHTML = totalUtil;
		}
		
		
		function resetInput() {
			
	
			
			document.getElementById('conGoods').value = 0;
			document.getElementById('capGoods').value = 0;
			document.getElementById("productionPlan").innerHTML = "0";
			
		}
		
		function capMax() {
		
			calculate();
		
			//var maxCapitalProduction = money/40;
			console.log("Max capital:"+maxCapitalProduction);
			var capSelect = document.getElementById("capGoods");
			
			var holdingValue = capSelect.value;
			
			if (money > 0) {
			
					removeOptions(capSelect);
					
					for(var i=0; i<=maxCapitalProduction; i++) {
					
						var option = document.createElement("option");
						option.value = i;
						option.innerHTML = i;
						
						if (i == holdingValue) {
							option.selected = true;
						}
						
						capSelect.appendChild(option)
					}
			}
		
		}
		
		
		function conMax() {
		
			calculate();
			
		
			//var maxConsumerProduction = money/20;
			console.log("Max consumer:"+maxConsumerProduction);
			var conSelect = document.getElementById("conGoods");
			
			var holdingValue = conSelect.value;
			
			if (money > 0) {
			
					removeOptions(conSelect);
					
					for(var i=0; i<=maxConsumerProduction; i++) {
					
						var option = document.createElement("option");
						option.value = i;
						option.innerHTML = i;
						
						if (i == holdingValue) {
							option.selected = true;
						}
						
						conSelect.appendChild(option)
					}
			}
					
		}
			
		
		function calculate() {
		
			money = (workers*10)+(machines*20);
			maxCapitalProduction = money/40;
			maxConsumerProduction = money/20;
			
			var capSelect = document.getElementById("capGoods");
			var conSelect = document.getElementById("conGoods");
			conGoods = conSelect.value;
			capGoods = capSelect.value;
			
			//moneyLeft = money - (conGoods*20 + capGoods*40);
			//maxCapitalProduction = Math.floor(money/40);
			//maxConsumerProduction = money/20;
			
			maxCapitalProduction = (money-conGoods*20)/40;
			maxConsumerProduction = (money-capGoods*40)/20;
			//console.log("Money: "+money);

		
		
		}
		
		
		function productionUpdate() {
		
		var span = document.getElementById("productionPlan");
		span.innerHTML = parseInt(conGoods)*2 + parseInt(capGoods)*4;
		
		
		
		}
		
		
		function playAgain() {
			
			document.getElementById("review").style.display="none";
			 workers = 4;
		 machines = 4;
		 year = 1; 
		 totalUtil=0;
		 util = 0;
		 
		 
		 document.getElementById("year").innerHTML = year;
			document.getElementById("workerCount").innerHTML = workers;
			document.getElementById("machineCount").innerHTML = machines;
			document.getElementById("prodMoney").innerHTML = prodMoney;
			document.getElementById("prodUnits").innerHTML = prodUnits;
			document.getElementById("util").innerHTML = util;
			document.getElementById("totalUtil").innerHTML = totalUtil;
			
			
			
		}
		
		
		
		
		
		
		
		
		
		
		document.getElementById("button").onclick = function () {
		
		
		
		
		
		
		
		if (year == 10)
		
			
			{	displayReview();
				//alert("Well done, you've played the game and your score was "+totalUtil+". Press the broser refresh button to have another go")
				}
			
			
		else {	
		
		
		
		if ((conGoods*2 + capGoods*4) > workers + machines*2) {
		
			alert("Oops! You've produced more than you're able to! You have productive capacity of £"+prodMoney+" ("+workers+"x£10 + "+machines+"x£20), but you're trying to produce goods which require £"+consMoney+" ("+conGoods+"x£20 + "+capGoods+"x£40). Please lower your production levels and try again.")}

		else {		
		
		if (capGoods < 0) 
		
		
			{alert("The value of your capital goods and consumer goods must each be greater than 0.") }
		


		
		else {
		
			workers ++;
			if (machines <= 0) {machines = 0} else {machines += (capGoods-1)};
			year++;
			prodMoney = (workers*10)+(machines*20);
			prodUnits = workers + machines*2;
			
			
			
			//resetInput();

			if (conGoods == 0) {util =0}
			else if (conGoods == 1) {util =20}
			else if (conGoods == 2) {util =39}
			else if (conGoods == 3) {util =57}
			else if (conGoods == 4) {util =74}
			else if (conGoods == 5) {util =90}
			else if (conGoods == 6) {util =105}
			else if (conGoods == 7) {util =119}
			else if (conGoods == 8) {util =132}
			else if (conGoods == 9) {util =144}
			else if (conGoods == 10) {util =155}
			else if (conGoods == 11) {util =165}
			else if (conGoods == 12) {util =174}
			else if (conGoods == 13) {util =182}
			else if (conGoods == 14) {util =189}
			else if (conGoods == 15) {util =195}
			else if (conGoods == 16) {util =200}
			else if (conGoods == 17) {util =204}
			else if (conGoods == 18) {util =207}
			else if (conGoods == 19) {util =209}
			else if (conGoods >= 20) {util =210}
			else {util = 0};
		
			totalUtil += util;
			
			resetInput();
			
			document.getElementById("year").innerHTML = year;
			document.getElementById("workerCount").innerHTML = workers;
			document.getElementById("machineCount").innerHTML = machines;
			document.getElementById("prodMoney").innerHTML = prodMoney;
			document.getElementById("prodUnits").innerHTML = prodUnits;
			document.getElementById("util").innerHTML = util;
			document.getElementById("totalUtil").innerHTML = totalUtil;
			
			document.getElementById("f2").value = totalUtil;
			
			capMax();
			conMax();
		};
		};
		};
		};
		

		

			
			
		</script>





</div>




	</body>



	</html>