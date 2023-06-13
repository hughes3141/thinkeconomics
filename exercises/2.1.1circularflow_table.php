<!DOCTYPE html>

<html>


<head>

<?php include "../header.php"; ?>

<style>

table {

  border-collapse: collapse;

}


th, td {
  border: 1px solid black;
  padding: 5px;

}

#injectionHolder, #mpcHolder, #mpcHolder {

	padding: 1px 2px;
	border-width: 2px;
	//border-style: inset;
	-webkit-writing-mode: horizontal-tb !important;
	border-color: -internal-light-dark(rgb(118, 118, 118), rgb(133, 133, 133));
	
 
	}


#controlDiv {

position: -webkit-sticky;
position: sticky;
top: 20px;

margin-bottom: 10px;
background-color: white;
padding: 5px;
border: 1px solid black;

}

#mpc_p {
	display: none;
}

div.style {
	
	
	overflow: visible;
	
}
</style>



</head>

<body>

<?php include "../navbar.php"; ?>

<h1>Circular Flow of Income Investigation</h1>
<h2>Instructions</h2>
<p>The circular flow of income can be modelled like this:</p>
<p><img src="files/2.1.1_02.JPG" alt="The Circular Flow of Income"></p>
<p>Households earn wages, which are spent on consumer expenditure, which is exchanged for products, which requires labour, for which households earn wages. And so the cycle continues.</p>
<p>Assume that this is a model where the only withdrawal from the circular flow is savings. We can describe the savings rate as the &ldquo;<strong>Marginal Propensity to Save</strong>.&rdquo; This is the percentage of any additional income that a household will take out of the circular flow and put back into savings.</p>
<p>Say we inject &pound;10 into the circular flow of income. In Round 1, the first time it goes around, it will create &pound;10 worth of income.</p>
<p>Once it gets to the households, some of it will be saved.</p>
<p>Say the Marginal Propensity to Save is 10%, or 0.1.</p>
<p>This means that when the &pound;10 of income gets to the household, 10% of it, or &pound;1, will be saved. That means that households only put back &pound;9 back into the circular flow of income. So in Round 2, it will generate &pound;9 of income.</p>
<p>And when this &pound;9 of income gets to the household, they will save 10% of it, leaving less to go around in the next cycle.</p>
<p>The total effect of the initial is what happens after it goes around until it is saved down to nothing.</p>
<p>The <strong>multiplier</strong> is how many times we multiply the initial injection to get the total effect on the economy. If an injection of &pound;10 creates &pound;100 total effect in the economy, then the multiplier is &pound;100 &divide; &pound;10 = <strong>10</strong>.</p>
<h2>Task:</h2>
<p>You will be investigating the effect of savings rate, or MPS, on the total effect of an initial injection of money into the circular flow of income. Using the controls below, you can set:</p>
<ul>
<li>The initial injection amount</li>
<li>The Marginal Propensity to Save (MPS)</li>
</ul>
<p>Each time you click &ldquo;Add Row&rdquo; you will see the effect of the injection going around the circular flow. The table will record:</p>
<ul>
<li><strong>Income (this round): </strong>The amount of income in the circular flow in that cycle.</li>
<li><strong>Total Income (all rounds): </strong>The cumulative effect of this and all previous cycles on the overall economy.</li>
</ul>
<p>Play around with the controls. Try to see if you can explain what the effect on total income is with low, medium, and high levels of savings. Then answer the following questions:</p>
<ol>
<li>What is the multiplier when MPS = 0.1?</li>
<li>What is the multiplier when MPS = 0.5?</li>
<li>What is the multiplier when MPS = 0.8?</li>
<li>Fill in the following statement: The lower the savings rate, the __________ the multiplier.</li>
<li>Extension: Can you work out an equation that relates the multiplier to the MPS?</li>
</ol>

<div id="controlDiv">
<p>
<label for="injectionAmount">Initial Injection:</label>
<input id="injectionAmount" type="number" min="0" max="10" name="injectionAmount" value="10" pattern="\d*">
<span id="injectionHolder"></span>
</p>
<p id= "mpc_p">
<label for="mpc">Marginal Propensity to Consume:</label>
<input id="mpc" type="number" min="0" max="1" step="0.1" name="mpc" pattern="\d*">
<span id="mpcHolder"></span>
</p>
</p>
<label for="mps">Marginal Propensity to Save:</label>
<!--
<input id="mps" type="number" min="0" max="1" step="0.1" name="mpc" value="0.1" pattern="\d*">
-->
<select name="mps" id="mps">
  <option value="0.1" selected>0.1</option>
  <option value="0.2">0.2</option>
  <option value="0.3">0.3</option>
  <option value="0.4">0.4</option>
  <option value="0.5">0.5</option>
  <option value="0.6">0.6</option>
  <option value="0.7">0.7</option>
  <option value="0.8">0.8</option>
  <option value="0.9">0.9</option>
  
</select>
<span id="mpsHolder"></span>
</p>

<button onclick="addRow()">Add Row</button>
<button onclick="addRowMultiple(5)">Add 5 Rows</button>
<button onclick="addRowMultiple(10)">Add 10 Rows</button>
<button onclick="clearTable()">Clear</button>
</div>

<table id="summaryTable">

<tr>
  <th>Round</th>
  <th>Income (this round)</th>
  <th>Total Income (all rounds)</th>
</tr>


</table>

<?php include "../footer.php"; ?>


<script>

var round = 0;
var incomes=[];
var totalIncomes = [];

function rounder(i) {
	return Math.round(i * 100) / 100
}


function roundTo(i,j) {
	return Math.round(i * (10**j)) / (10**j)

}

function addRow () {

	

	var table = document.getElementById("summaryTable");
	var rowCount = table.rows.length;

/*
	var row = table.insertRow(rowCount);
	
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
*/

	

	var mps = parseFloat(document.getElementById("mps").value);
	//var mpc = parseFloat(document.getElementById("mpc").value);
	var mpc = roundTo((1-mps),4);
	//console.log(mpc);
	
	
	
	if (round == 0) {
		incomes.push(parseFloat(document.getElementById("injectionAmount").value));
		totalIncomes.push(parseFloat(document.getElementById("injectionAmount").value));
		
		document.getElementById("injectionHolder").style.display = "inline-block";
		document.getElementById("mpcHolder").style.display = "inline-block";
		document.getElementById("mpsHolder").style.display = "inline-block";
		
		document.getElementById("injectionHolder").innerHTML = document.getElementById("injectionAmount").value;
		document.getElementById("mpcHolder").innerHTML = mpc;
		document.getElementById("mpsHolder").innerHTML = mps;
		
		document.getElementById("injectionAmount").style.display = "none";
		document.getElementById("mpc").style.display = "none";
		document.getElementById("mps").style.display = "none";
		
		var row = table.insertRow(rowCount);
	
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
	}
		else {
		
		if(/*moneyFormat(incomes[(round-1)])!="0.0000"*/ rounder(totalIncomes[round-1])!=(rounder((1/(1-mpc))*document.getElementById("injectionAmount").value)) ) {
			
			//console.log((1/(1-mpc))*document.getElementById("injectionAmount").value)
			//console.log(rounder(totalIncomes[round-1]))
			incomes.push((incomes[(round-1)]*mpc));
			totalIncomes.push((incomes[(round-1)]*mpc)+totalIncomes[(round-1)]);
			
			var row = table.insertRow(rowCount);
	
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);
		}
	}
	
	cell1.innerHTML = "Round "+(round+1);
	cell2.innerHTML = "&pound;"+ moneyFormat(incomes[round]);
	cell3.innerHTML = "&pound;"+ moneyFormat(totalIncomes[round]);
	
	//console.log(round);
	console.log(incomes)
	console.log(totalIncomes);
	round ++;
	


}

function addRowMultiple(j) {

for(var i=0; i<j; i++) {
	addRow();
	}

}

function clearTable() {

	round = 0;
	incomes=[];
	totalIncomes = [];

	var table = document.getElementById("summaryTable");
	
	table.innerHTML= "<tr>  <th>Round</th>  <th>Income (this round)</th>  <th>Total Income (all rounds)</th></tr>";
	
	document.getElementById("injectionAmount").style.display = "inline-block";
	document.getElementById("mpc").style.display = "inline-block";
	document.getElementById("mps").style.display = "inline-block";
	
	document.getElementById("injectionHolder").style.display = "none";
	document.getElementById("mpcHolder").style.display = "none";
	document.getElementById("mpsHolder").style.display = "none";

}

function isInt(n) {
   return n % 1 === 0;
}

function moneyFormat(i) {

	if(isInt(i)) {
	
		return i;
	
	}
	else {
	
	
		if (i.toFixed(2)=="0.00") {
		
			if (i.toFixed(4)=="0.0000") {
			
					return i.toFixed(6);
			} else {
		
				return i.toFixed(4);
			}
		}
		else {
			return i.toFixed(2)
		}
	}


}

</script>

</body>



</html>