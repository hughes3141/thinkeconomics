<html>
<html>

<head>

<?php include "../header.php"; ?>

<style>

table {

	border-collapse: collapse;

}


th, td {

	border: 1pt solid black;
	padding: 5px;
	text-align: center;

}

canvas {

	border: 1pt solid black;
	//width: 100%;
	
	
	
	
	

	}
	
.compAdvHighlight_1 {
	background-color: #99ff99;
	}

.compAdvHighlight_2 {
	background-color: #ffcc99;
	}
	
.absAdvHighlight_1 {
	background-color: #ff99ff;
	}

.absAdvHighlight_2 {
	background-color: #66ccff;
	}
	
	
.oppCostSpan {
	padding: 5px;
	}
	
	
.oppCostClass {

	display: none;
	}
	
.summaryClass {
	display: none;
	}

</style>



</head>

<body onload="randomInitialValues(), populate(), drawCanvas()">

<?php include "../navbar.php"; ?>

<h1>Comparative and Absolute Advantage</h1>
<p>The aim of this resource is to allow you to see how comparative and absolute advantage are calculated by playing around with different numbers.</p>

<p>

<button onclick="explainHide()" class="explainHideButton" id="explainHideButton1">Click to hide explanations</button>

</p>

<h2 class="explanation">The Data</h2>
<p class="explanation">Suppose you have two countries: Country 1 and Country 2. Each country can produce two products, Good A and Good B.</p>





<p class="explanation">You can change the names of the countries and products by clicking here:</p>
<p>
<button id="b0" onclick="toggleHide(0)">Click to change names</button>
</p>
<div style="display:none" id="d0">

<table>
<tr>
<td>Country 1</td>
<td><input id="country1Input" type="text"></td>
</tr>
<tr>
<td>Country 2</td><td><input id="country2Input" type="text"></td>
</tr>
<tr>
<td>Good A</td><td><input id="goodAInput" type="text"></td>
</tr>
<tr>
<td>Good B</td><td><input id="goodBInput" type="text"></td>
</tr>

</table>

<p>
<button  onclick="rename(), populate(), resetButtons(), drawCanvas()">Change Names</button>
</p>
</div>


<p class="explanation">One worker in each country can produce as follows:</p>

<table id="inputTable"></table>


<p class="explanation">These values are generated at random. You can change them on the table above, or generate new random values by pressing here:</p>
<p>
<button onclick="randomInitialValues(), inputTable(), /*oppCostTable(),*/ drawCanvas(), setOnchange(), compDetermine(), absDetermine(), oppCostTableFill(), summaryTableFill()">Random Initial Values</button>
</p>
<p>

<canvas id="myCanvas" //width="500" height="500" ></canvas>
</p>

<div class="explanation">
<p>The Production Possibility Frontier (PPF) for each of these countries is shown above. We draw straight lines because we assume perfect factor substitutability.</p>
<p>The information above will allow us to determine which country has comparative and absolute advantage for the production of each good.</p>
<h2>Comparative vs Absolute Advantage</h2>
<p><strong>Absolute Advantage</strong> describes a situation in which a country can produce a product at a lower unit cost. In other words, the nation can produce more of that product with its scarce resources.</p>
<p>We can find which country has absolute advantage by in each good by:</p>
<ul>
<li>Looking at the table to see which country can produce more of the good (per worker) or</li>
<li>Seeing which country has a higher axis intercept for the good on the PPF</li>
</ul>
<p><strong>Comparative Advantage</strong> describes a situation in which a country can produce a product at a lower opportunity cost than another country.</p>
<p>To find comparative advantage, we must first calculate opportunity costs.</p>
<h2>Opportunity Cost</h2>
<p>The textbook definition of <strong>opportunity cost</strong> is the benefit of the next best alternative foregone.</p>
<p>In the context of international trade, we can think of opportunity cost as a calculation of how many units of one good we must give up to produce one unit of the other good.</p>
<p>For example, the opportunity cost of Good A in Country 1 is the number of units of Good B that this country has to give up to produce one more unit of Good A.</p>
<p>A helpful way to do this is to consider how many units of Good B a country must sacrifice to produce only Good A. In the example above, Country 1 can choose to produce 10 units of Good B if they produce 0 units Good A. Alternatively, the country could produce 5 units of Good A if they produce 0 units of Good B. So, in deciding to produce 5 units of Good A, they must give up 10 units of Good B. In other words, producing 1 unit of Good A costs this county 10/5 = 2 units of Good B. Hence, we can say the <strong>opportunity cost</strong> for producing Good A in Country 1 is 2 units of Good B.</p>
<p>We can simplify this using the following formula:</p>
<code>Opportunity Cost of Good A = Max Production of Good B / Max Production of Good A</code>
<p>Using this formula, you should be able to calculate the opportunity costs for producing the goods in the two countries above. You can summarise them in a table below:</p>

</div>

<table id = "oppCostTable"></table>



<p class="explanation">When finished you can check your work by clicking here:
</p>
<p><button onclick="oppCostTableShow()" id="oppCostShowButton">Click to show Opportunity Costs</button></p>

<div class="explanation">
<h2>Summary</h2>
<p>You now have all the information you need to fill in the summary table below:</p>
</div>
<table id= "summaryTable"></table>


<p class="explanation">These are the methods to find each type of advantage:</p>
<ul class="explanation">
<li>Comparative advantage: for each good, state which country has the lower opportunity cost.</li>
<li>Absolute advantage: for each good, state which country can produce more of the good (per worker).</li>
</ul>

<p class="explanation">You can click here to highlight the data above for the corresponding sections of the summary table:</p>
<p><button onclick="highlightToggle()" id="highlightButton">Click to highlight data</button></p>

<p class="explanation">You can click here to fill in the summary table: </p>
<p><button onclick="summaryTableShow() /*advSummary(); advHighlight()*/" id="summaryShowButton">Click to show summary</button></p>

<h2>Summary Questions:</h2>
<button onclick="explainHide()" class="explainHideButton" id="explainHideButton1">Click to hide explanations</button>
<p>Play around with the data by changing the figures in the original table. Try different situations by having new random initial values. Then answer these questions:</p>
<ol>
<li>Is it possible for a country to have comparative advantage in both goods? Explain.</li>
<li>Is it possible for a country to have absolute advantage in both goods? Explain what the PPFs would need to look like for this to happen.</li>
<li>If a country has absolute advantage in a good, will that country automatically have comparative advantage in that good? Explain.</li>
<li>As the opportunity cost for Good A in Country 1 decreases, what happens to the opportunity cost for Good B in Country 1?</li>
<li>Describe the conditions that will lead to neither country having absolute advantage in the production of a good. Change the data to show this on the PPF.</li>
<li>Describe the conditions that will lead to neither country having comparative advantage in the production of a good. Change the data to show this on the PPF.</li>
</ol>






	








<?php include "../footer.php"; ?>



<script>


/*
var canvas2 = document.getElementById('myCanvas');
var heightRatio = 1.5;
canvas2.height = canvas2.width * heightRatio;
*/

var initialValues = [[],[]];
var productionIntercepts = [[],[]];
var oppCosts = [[],[]];
var oppCostsText = [[],[]];

var countries = ["Country 1", "Country 2"];
var goods = ["Good A", "Good B"]


// advSum summarises the relative advantages in text (for use in a table): [[Comparative Advantage Good A, Comparative Advantage Good B], [Absolute Advantage Good A, Absolute Advantage Good B]
var advSum = [["Neither Country", "Neither Country"], ["Neither Country", "Neither Country"]]


// absAdvSum summarises absolute advantage in binary (for use in highlighting tables): [[Country 1 Good A, Counry 1 Good B], [Country 2 Good A, Counry 2 Good B]]

var absAdvSum = [[0,0], [0,0]];

// compAdvSum summarises comparative advantage in binary (for use in highlighting tables): [[Country 1 Good A, Counry 1 Good B], [Country 2 Good A, Counry 2 Good B]]

var compAdvSum = [[0,0], [0,0]];

function round2(num)  {

return Math.round((num + Number.EPSILON) * 1000) / 1000
}

//The following functions tX() and tY() transform X and Y values to be used in drawing on canvas
function tX(x) {

return x +50;
}

function tY(y) {

return 450 - y;
}

var max = 20;
var scale = 20;

function maxScale() {

max = Math.max(...productionIntercepts[0], ...productionIntercepts[1]);
max = (Math.floor((max-1)/5)+1)*5
scale = 400/max

//console.log(max);

}

//The following function s(x) is used to scale canvas drawings from intercept values to the canvas.



function s(x) {

return scale*x;

}

var buttonLabels = ["Click to change names"]

function toggleHide(i) {

//This function is used for buttons that hide/show sections.

var div = document.getElementById("d"+i);

var button = document.getElementById("b"+i);

if (button.innerHTML == "Click to Hide") {

div.style.display = "none";

button.innerHTML= buttonLabels[i];

}

else {
div.style.display = "inline";

button.innerHTML= "Click to Hide";

}
}

function populate() {

//This function sets up the the input table, oppCostTable, and Summary table.

inputTable();
tabulate();
oppCostTable();
setOnchange();


compDetermine();
absDetermine();





/*
oppCostTableFill();
drawCanvas();


*/

//Summary Table:


var table3 = document.getElementById("summaryTable");

table3.innerHTML="";
	
	var row = [table3.insertRow(0), table3.insertRow(1), table3.insertRow(2)];
	
	var cell = [
				[row[0].insertCell(0), row[0].insertCell(1), row[0].insertCell(2)],
				[row[1].insertCell(0), row[1].insertCell(1), row[1].insertCell(2)],
				[row[2].insertCell(0), row[2].insertCell(1), row[2].insertCell(2)],
				]
	
	cell[0][1].innerHTML = goods[0];
	cell[0][2].innerHTML = goods[1];
	
	cell[1][0].innerHTML = "Comparative Advantage";
	cell[2][0].innerHTML = "Absolute Advantage";
	
	
	for(var i=1; i<3; i++) {
	
		for(var j=1; j<3; j++)	{
		
			var cellInstance = cell[i][j];
			cellInstance.setAttribute("id", "summaryTableCell"+i+"_"+j)
			
			if (i==1) {
				cellInstance.setAttribute("class", "compAdvHighlight_"+j)}
				
			if (i==2) {
				cellInstance.setAttribute("class", "absAdvHighlight_"+j)}
			
			
			
			var p = document.createElement("p");
			p.setAttribute("id", "summaryTableP"+i+"_"+j);
			p.setAttribute("class", "summaryClass");
			p.innerHTML = ""
			
	
			cellInstance.appendChild(p);
				
		}
	}

summaryTableFill();
}



function rename() {

//This function is used to rename country names and good names from user input. This function only changes the countires[] and inputs[] arrays.

	var inputs = [document.getElementById("country1Input").value, document.getElementById("country2Input").value, document.getElementById("goodAInput").value, document.getElementById("goodBInput").value]
	
	
	
	for(var i=0; i<2; i++) {
	
		if(inputs[i]!=="") {countries[i]=inputs[i]}
		
			else {
				
				if (i==0) {countries[i]="Country 1"}
				if (i==1) {countries[i]="Country 2"}
				
				}
	
	}
	
	for(var i=2; i<4; i++) {
	
		if(inputs[i]!=="") {goods[(i-2)]=inputs[i]}
		
		else {
				
				if (i==2) {goods[i-2]="Good A"}
				if (i==3) {goods[i-2]="Good B"}
				
				}
	
	}


//console.log(inputs);
//console.log(countries);
//console.log(goods);


}

function resetButtons() {

//This function renames toggle buttons, for example when repopulating website following a name change.

var buttons = ["oppCostShowButton", "summaryShowButton", "highlightButton"]

var reset = ["Click to show Opportunity Costs", "Click to show summary","Click to highlight data"]

for(var i=0; i<buttons.length; i++) {
	
	document.getElementById(buttons[i]).innerHTML = reset[i];
	
	}

}

function randomInitialValues() {

//This function generates the random intial values that are entered into the input table.

	for(var i=0; i<2; i++) {
	
		for(var j=0; j<2; j++) {
		
			initialValues[i][j] = 1+ Math.floor(Math.random() * 20)
		
		}
	
	
	}

//console.log(initialValues);
}

function inputTable() {

//This funciton generates the input table.

//Input Table:

	var table = document.getElementById("inputTable");
	table.innerHTML = "";
	
	var row = [table.insertRow(0), table.insertRow(1), table.insertRow(2)];
	
	var cell = [
				[row[0].insertCell(0), row[0].insertCell(1), row[0].insertCell(2)],
				[row[1].insertCell(0), row[1].insertCell(1), row[1].insertCell(2)],
				[row[2].insertCell(0), row[2].insertCell(1), row[2].insertCell(2)],
				]
	
	cell[0][1].innerHTML = goods[0];
	cell[0][2].innerHTML = goods[1];
	
	cell[1][0].innerHTML = countries[0];
	cell[2][0].innerHTML = countries[1];
	
	
	for(var i=1; i<3; i++) {
	
		for(var j=1; j<3; j++)	{
		
			var cellInstance = cell[i][j];
			cellInstance.setAttribute("id", "inputCell"+i+"_"+j);
			cellInstance.setAttribute("class", "inputCell");
			var input = document.createElement("select");
			input.setAttribute("id", "input"+i+"_"+j);
			//input.setAtrribute("onchange", drawCanvas());
			
			//var m = 1+ Math.floor(Math.random() * 20)
			var m = initialValues[(i-1)][(j-1)];
			
			for(var k=1; k<21; k++) {
			
				var option = document.createElement("option");
				option.text = k;
				
				//Use following to make default value 1:
				//if (k==1) {option.setAttribute("selected", "selected")}
				
				
				//Use following to make defaut vaulue a random number between 1 and 20
				if (k == m) {option.setAttribute("selected", "selected")}
				
				input.add(option);
			
			}
						
			cellInstance.appendChild(input);
				
		}
	}



}

function setOnchange() {

//This function specifies the functions that are to be called when values in the input table are changed.

for(var i=1; i<3; i++) {

	for(var j=1; j<3; j++) {
	
		var input = document.getElementById("input"+i+"_"+j);
		input.setAttribute("onchange", "drawCanvas(), compDetermine(), absDetermine(), oppCostTableFill(), summaryTableFill(), highlightOnchange()");
	
	
	}


}


}

function oppCostTable() {


// This function creates the opportunity cost table

//Opportunity Cost Table:

var table2 = document.getElementById("oppCostTable");
table2.innerHTML = "";
	
	var row = [table2.insertRow(0), table2.insertRow(1), table2.insertRow(2)];
	
	var cell = [
				[row[0].insertCell(0), row[0].insertCell(1), row[0].insertCell(2)],
				[row[1].insertCell(0), row[1].insertCell(1), row[1].insertCell(2)],
				[row[2].insertCell(0), row[2].insertCell(1), row[2].insertCell(2)],
				]
	
	cell[0][1].innerHTML = "Opportunity Cost of Producing:<br>"+goods[0];
	cell[0][2].innerHTML = "Opportunity Cost of Producing:<br>"+goods[1];
	
	cell[1][0].innerHTML = countries[0];
	cell[2][0].innerHTML = countries[1];
	
	
	for(var i=1; i<3; i++) {
	
		for(var j=1; j<3; j++)	{
		
			var cellInstance = cell[i][j];
			cellInstance.setAttribute("id", "oppCostCell"+i+"_"+j)
			var input = document.createElement("p");
			input.setAttribute("id", "oppCost"+i+"_"+j);			
			
			input.innerHTML = ""
					
			cellInstance.appendChild(input);
				
		}
	}

oppCostTableFill();

}

function oppCostTableFill() {

//This function fills the Opportuity Cost Table with opportunity cost information from the array oppCostsText[]


	for(var i=0; i<2; i++) {
		
			for(var j=0; j<2; j++)	{
				
				var p = document.getElementById("oppCost"+(i+1)+"_"+(j+1));
				p.innerHTML = oppCostsText[i][j];
				p.setAttribute("class","oppCostClass");
				//p.style.display = "none";
			
			
			}
		
		
		
		}

}

function oppCostTableShow() {

//This function toggles between showing the calculated opportunity costs in the oppCostTable.

var y = document.getElementById("oppCostShowButton");
var x = document.getElementsByClassName("oppCostClass");

if (y.innerHTML == "Click to show Opportunity Costs" ) {

	
	
	for(var i=0; i<x.length; i++) {
		
		x[i].style.display = "inline"
		
		}
		

	y.innerHTML = "Click to hide Opportunity Costs"

	}
	
	else {
	
	for(var i=0; i<x.length; i++) {
		
		x[i].style.display = "none"
		
		}
	
	y.innerHTML = "Click to show Opportunity Costs"
	
	}


}

function summaryTableFill() {

//This function fills information for the Summary Table using information from advSum[]

var cells = [document.getElementById("summaryTableP1_1"), document.getElementById("summaryTableP1_2"), document.getElementById("summaryTableP2_1"), document.getElementById("summaryTableP2_2")];

cells[0].innerHTML =  advSum[0][0];
cells[1].innerHTML = advSum[0][1];

cells[2].innerHTML = advSum[1][0];
cells[3].innerHTML = advSum[1][1];


}

function summaryTableShow() {

//This function toggles between showing the summaries in summary table.

var y = document.getElementById("summaryShowButton");
var x = document.getElementsByClassName("summaryClass");

if (y.innerHTML == "Click to show summary" ) {

	
	
	for(var i=0; i<x.length; i++) {
		
		x[i].style.display = "inline"
		
		}
		

	y.innerHTML = "Click to hide summary"

	}
	
	else {
	
	for(var i=0; i<x.length; i++) {
		
		x[i].style.display = "none"
		
		}
	
	y.innerHTML = "Click to show summary"
	
	}




}

function tabulate() {

/*
This function:
-Retrieves data from input table
-Creates text input for opportunity cost table, stored in oppCostsText[]
-Calculates opportuity costs based on input table values, stored in oppCosts[]


*/

//Retrieve data from input table:

	for(var i=1; i<3; i++) {
	
		for(var j=1; j<3; j++)	{
		
			var inputValue = document.getElementById("input"+i+"_"+j);
			productionIntercepts[i-1][j-1] = parseInt(inputValue.value);
			initialValues[i-1][j-1] = parseInt(inputValue.value);
			
				
		}
		
	}
	
	
//Calculate Opportunity Costs:

	


	for(var i=0; i<2; i++) {
	
		//Set text for Opportunty Cost Table, stored in oppCostsText[]
	
		var span1 = "<span id='oppCostSpan"+(i+1)+"_1' class='oppCostSpan'>";
		var span2 = "<span id='oppCostSpan"+(i+1)+"_2' class='oppCostSpan'>";
		var endspan = "</span>";
		
			
		oppCostsText[i][0] = productionIntercepts[i][1]+" &divide; "+productionIntercepts[i][0]+" = "+span1+round2(productionIntercepts[i][1]/productionIntercepts[i][0])+endspan+"";
		oppCostsText[i][1] = productionIntercepts[i][0]+" &divide; "+productionIntercepts[i][1]+" = "+span2+round2(productionIntercepts[i][0]/productionIntercepts[i][1])+endspan+"";
		
		
		//Calculate opportunity costs, stored in oppCosts[]
		
		oppCosts[i][0] = productionIntercepts[i][1]/productionIntercepts[i][0];
		oppCosts[i][1] = productionIntercepts[i][0]/productionIntercepts[i][1];
	}
	
	
	
console.log(productionIntercepts);	
console.log(oppCosts);


}



function compDetermine() {

//This function determines comparative advantage, stored as text values in compAdvSum[]

tabulate();

if (oppCosts[0][0] < oppCosts[1][0]) {advSum[0][0] = countries[0]; compAdvSum[0][0]=1; compAdvSum[1][0]=0}
else if(oppCosts[0][0] > oppCosts[1][0]) {advSum[0][0] = countries[1]; compAdvSum[1][0]=1; compAdvSum[0][0]=0}
else if(oppCosts[0][0] == oppCosts[1][0]) {advSum[0][0] = "Neither country"; compAdvSum[0][0]=0; compAdvSum[1][0]=0}


if (oppCosts[0][1] < oppCosts[1][1]) {advSum[0][1] = countries[0]; compAdvSum[0][1]=1; compAdvSum[1][1]=0}
else if(oppCosts[0][1] > oppCosts[1][1]) {advSum[0][1] = countries[1]; compAdvSum[1][1]=1; compAdvSum[0][1]=0}
else if(oppCosts[0][1] == oppCosts[1][1]) {advSum[0][1] = "Neither country"; compAdvSum[0][1]=0; compAdvSum[1][1]=0}

//advSummary();

//oppCostTable();

//console.log(advSum);
//console.log(compAdvSum);
//console.log(absAdvSum);

}

function absDetermine() {

//This function determines absolute advantage, stored as text values in absAdvSum[]

tabulate();


if (productionIntercepts[0][0] > productionIntercepts[1][0]) {advSum[1][0] = countries[0]; absAdvSum[0][0]=1; absAdvSum[1][0]=0}
else if(productionIntercepts[0][0] < productionIntercepts[1][0]) {advSum[1][0] = countries[1]; absAdvSum[1][0]=1; absAdvSum[0][0]=0}
else if(productionIntercepts[0][0] == productionIntercepts[1][0]) {advSum[1][0] = "Neither country"; absAdvSum[0][0]=0; absAdvSum[1][0]=0}


if (productionIntercepts[0][1] > productionIntercepts[1][1]) {advSum[1][1] = countries[0]; absAdvSum[0][1]=1; absAdvSum[1][1]=0}
else if(productionIntercepts[0][1] < productionIntercepts[1][1]) {advSum[1][1] = countries[1]; absAdvSum[1][1]=1; absAdvSum[0][1]=0}
else if(productionIntercepts[0][1] == productionIntercepts[1][1]) {advSum[1][1] = "Neither country"; absAdvSum[1][1]=0; absAdvSum[0][1]=0}





//advSummary();

}


function advSummary() {

//This function summarises comparative and absolute advantages by callng cells in the summaryTable.

var cells = [document.getElementById("summaryTableP1_1"), document.getElementById("summaryTableP1_2"), document.getElementById("summaryTableP2_1"), document.getElementById("summaryTableP2_2")];

cells[0].innerHTML =  advSum[0][0];
cells[1].innerHTML = advSum[0][1];

cells[2].innerHTML = advSum[1][0];
cells[3].innerHTML = advSum[1][1];

}

function  highlightToggle() {

//This function highlights cell values in input table and oppCostTable to show those values that determine comparative and absolute advantages.

var x = document.getElementById("highlightButton");
if (x.innerHTML == "Click to highlight data") 	{

	advHighlight();
		
	x.innerHTML = "Click to remove highlights"
	
	}
	
	
	else if (x.innerHTML == "Click to remove highlights") {
	
	
	var y = document.getElementsByClassName("oppCostSpan");
	for(var i=0; i<y.length; i++) {
		y[i].classList.remove("compAdvHighlight_1");
		y[i].classList.remove("compAdvHighlight_2");
		
		}
		
	var y = document.getElementsByClassName("inputCell");
	for(var i=0; i<y.length; i++) {
		y[i].classList.remove("absAdvHighlight_1");
		y[i].classList.remove("absAdvHighlight_2");
		
		}
	
	/*
	var highlights = ["absAdvHighlight_1", "absAdvHighlight_2", "compAdvHighlight_1", "compAdvHighlight_2"]
	
	
	
	
	
	for(var i=0; i<highlights.length; i++) {
	
		var a = document.getElementsByClassName(highlights[i]);
		
		
		for(var j=0; j<a.length; j++) {
			
			//a[j].style.fontSize = "x-large";
			a[j].classList.remove(highlights[i])
			
			}
	
	}
	*/

	var z = document.getElementsByClassName("oppCostSpan");
	x.innerHTML = "Click to highlight data"
	
	}


}


function advHighlight() {





{



		for (var i=1; i<3; i++) {

			

			for (var j=1; j<3; j++) {
			
				var span = document.getElementById("oppCostSpan"+i+"_"+j);
				
				if(compAdvSum[(i-1)][(j-1)]==1) {

					span.classList.add("compAdvHighlight_"+j)
					}
					
				if(compAdvSum[(i-1)][(j-1)]==0) {
					span.classList.remove("compAdvHighlight_"+j)
					}
				
				
				
				var cell = document.getElementById("inputCell"+i+"_"+j);
				
				if(absAdvSum[(i-1)][(j-1)]==1) {
				
					cell.classList.add("absAdvHighlight_"+j)
				}
				
				if(absAdvSum[(i-1)][(j-1)]==0) {
				
					cell.classList.remove("absAdvHighlight_"+j)
				}
				
				
			
			}


		}
		
	}




}

function highlightOnchange() {

//This function is to set highlights when input variables change, only used in the onchange function.

var x = document.getElementById("highlightButton");
if (x.innerHTML == "Click to remove highlights") {

advHighlight()
}


}

function explainHide() {

//This function toggles hiding of explanations

var x = document.getElementsByClassName("explanation");
var y = document.getElementsByClassName("explainHideButton");
var z = document.getElementById("explainHideButton1");

if (z.innerHTML == "Click to hide explanations") {

	for(var i=0; i<x.length; i++) {
		x[i].style.display = "none";
		}
		
	for(var i =0; i<y.length; i++)	{
		y[i].innerHTML = "Click to show explanations"
		}	
	}
	
else {
	
	for(var i=0; i<x.length; i++) {
		x[i].style.display = "block";
		}
		
	for(var i =0; i<y.length; i++)	{
		y[i].innerHTML = "Click to hide explanations"
		}
	
	
	
	}

}

//This set of functions control the canvas.

function drawAxes() {


var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.strokeStyle = "black";
ctx.beginPath();
ctx.moveTo(tX(0), tY(0));
ctx.lineTo(tX(0), tY(400));
//ctx.stroke();

ctx.moveTo(tX(0), tY(0));
ctx.lineTo(tX(400), tY(0));
ctx.stroke();


for(var i=1; i<(max+1); i++) {

	yHash(s(i));
	xHash(s(i));

}

}


function labelAxes() {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");

ctx.font ="12px Courier";
ctx.fillText(goods[1], tX(s(max)), tY(-30));


ctx.save();
ctx.translate(tX(-30), tY(s(max)));
ctx.rotate(-Math.PI/2);
ctx.textAlign = "center";
ctx.fillText(goods[0], 0, 0);
ctx.restore();

}




//These functions set hashes on the x and y axes. Use hashMark variable to determine how long hash line is.

var hashMark = 3

function yHash(i) {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");

ctx.beginPath();
ctx.moveTo(tX(-hashMark), tY(i));
ctx.lineTo(tX(hashMark), tY(i));
ctx.stroke();

ctx.font = "11px Courier";
ctx.textAlign = "right";

ctx.fillText(Math.round(i/scale), tX(-8), tY(i)+3)


}

function xHash(i) {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");

ctx.beginPath();
ctx.moveTo(tX(i), tY(-hashMark));
ctx.lineTo(tX(i), tY(hashMark));
ctx.stroke();


ctx.font = "11px Courier";
ctx.textAlign = "center";


ctx.fillText(Math.round(i/scale), tX(i), tY(-15))



}


function drawPPFs(i) {

//alert(i);

/*
var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.moveTo(tX(400), tY(0));
ctx.lineTo(tX(0), tY(400));
ctx.stroke();

*/


var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");



ctx.beginPath();


ctx.font ="11px Courier";
ctx.textAlign = "left";

if(i==0) {

	ctx.strokeStyle = "red";
	ctx.fillStyle = "red";
	
	ctx.fillText(countries[0], tX(10), tY(0+s(productionIntercepts[i][0])));
	}
if(i==1) {
	ctx.strokeStyle = "blue";
	ctx.fillStyle = "blue";
	ctx.fillText(countries[1], tX(0+s(productionIntercepts[i][1])), tY(10));
	}

ctx.moveTo(tX(s(productionIntercepts[i][1])), tY(0));
ctx.lineTo(tX(0), tY(s(productionIntercepts[i][0])));

ctx.stroke();

ctx.strokeStyle="black";
ctx.fillStyle="black";
ctx.textAlign = "right";

}

function clearCanvas() {

var canvas = document.getElementById("myCanvas");
var context = canvas.getContext("2d");
context.clearRect(0, 0, canvas.width, canvas.height); //clear html5 canvas

}

function drawCanvas() {

tabulate();
maxScale();

clearCanvas();


drawAxes();
labelAxes();
drawPPFs(0);
drawPPFs(1);





}

</script>

</body>


</html>