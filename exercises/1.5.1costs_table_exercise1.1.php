<html>

<head>

<?php include "../header.php" ?>

<style>
table {

	border-collapse: collapse;

}


th, td {

	border: 1pt solid black;
	padding: 5px;
	text-align: center;

}

input[type='number']{
    width: 50px;
} 

.totals, .averages, .revenues, .profit  {

display: none; 

}

#answer {

background-color: pink;
margin-top: 10px;
display: none;
padding:10px;


}

#inputTableDiv {
display: none;
}


#table02 {
 table-layout: fixed;
 // width: 400px;  
}
</style>


</head>

<body>
<?php include "../navbar.php" ?>

<h1>Where is Profit Maximised?</h1>

<p>Look at the data below. Can you figure out the output level that will maximise profits?</p>
<p>Selling Price: &pound;<span id="price_paragraph_span"</span></p>
<p>Fixed Cost: &pound;<span id="fc_paragraph_span"</span></p>



<table id="table01"></table>
<br>
<button onclick="showColumns()" id= "showColumnsButton"></button>
<br>



<p>What is the relationship between MC, MR, and Profit?</p>
<button onclick="showAnswer()" id="showAnswerButton">Click to Show Answer</button>
<div id="answer">
<p>Profit rises whenever MR is greater than MC. This is because the revenue gained from producing one extra unit (MR) is higher than the costs incurred of producing one extra unit (MC).</p>
<p>Profit falls whenever MR is less than MC. This is because producing extra units incurs a greater cost (MC) than the firm gains in revenue (MR).</p>
<p>In the graph above, we maximised profit at the last quantity where MR was greater than MC: output = <span id="quantityAnswerExplanation"></span>.</p>
<p>In general, we can conclude that profit is maximised when MR = MC. This rule will hold true for all graphs.</p>
<p>Note that we are not necessarily making a <em>loss</em> (negative profit) when MC is higher than MR. We are simply producing at a quantity that doesn&rsquo;t <em>maximise</em> profit; our profit levels are falling as we produce more. MC higher than MR implies a negative Marginal Profit, so we would increase our profit by producing less.</p>
</div>

<?php 

if ($_GET['inputtable'] == "true") {
	
echo '
<br>
<br>
<button onclick ="showInputTable()" id="showInputTableButton">Click to Show Input Table</button>

';
}
?>
<div id="inputTableDiv">
<br>



<table id="table02"></table>


<!--
<button onclick="dataChange()" id = "dataChangeButton">Click to change table data</button>
<br>
-->
</div>


<?php include "../footer.php";

;?>

<script>

/*
Created 28.09.2021 as excercise.

Can use get variables to change page:

?random=false ==> gives static values (same time every time page is opened)
?inputtalbe=true ==>gives user input table to change values

*/


var table01 = document.getElementById("table01");
var table02 = document.getElementById("table02");


function round2(num)  {

	return Math.round((num + Number.EPSILON) * 100) / 100
}

function randomGen(min, max, step) {

	return Math.round(
	(
	Math.floor(Math.random()*((max-min)/step +1))*step+min
	)
	*1000)/1000;

}

/*
Independent (Construction) Variables:
var MCmin is where MC curve minimises
var MCslope is the slope of the MC curve, both positive and negative
var MCstart is the y-value starting point of MC, where MC=1
var MCadjust is a scale that is applied to MC at all quantities

var FC is the fixed cost value
var quantityAnswer is the correct answer quanityt where profit is maximised.

Dependent Variables:
(Output)
MC
TVC
TFC
TC
AVC
AFC
ATC
AR
MR
Revenue
Profit

*/

var outputNumber = 10;


var MCmin = 3;
var MCslope = 2;
var MCstart = 5;
var MCadjust = 1;

var FC = 10;
var quantityAnswer = 7;

var Price = 10;


/*
Var priceLead determines which variable sets the other:
-When priceLead = 0, quantityAnswer determines Price (default position, when page loads)
-WHen priceLead = 1, quantityAnswer is ignored and Price is determined independently (e.g. after changing from input table)
*/

var priceLead = 0;


<?php 

if ($_GET['random'] != "false") {

echo "
quantityAnswer = randomGen(5,8,1);

	if(quantityAnswer ==5) {
		FC = randomGen(5,8,1)}
	else if(quantityAnswer ==6) {
		FC = randomGen(7,10,1)}
	else if(quantityAnswer ==7) {
		FC = randomGen(15,20,1);
		MCstart = randomGen(5,6,1)
	}
	else if(quantityAnswer ==8) {
		FC = randomGen(20,25,1);
		MCstart = randomGen(5,6,1)
	}
	";
}
?>

//console.log(quantityAnswer);

var Output = [];
var MC =[];
var TVC =[];
var TFC =[];
var TC =[];
var AVC =[];
var AFC =[];
var ATC =[];
var AR =[];
var MR =[];
var Revenue =[];
var Profit =[];

determineValues();


document.getElementById("price_paragraph_span").innerHTML = Price;
document.getElementById("fc_paragraph_span").innerHTML = FC;
document.getElementById("quantityAnswerExplanation").innerHTML = quantityAnswer;


function determineValues() {

Output.length=0;
MC.length =0;
TVC.length=0
TFC.length = 0;
TC.length=0;
AVC.length = 0;
AFC.length =0;
ATC.length = 0;
AR.length=0;
MR.length =0;
Revenue.length = 0;
Profit.length = 0;



	for(var i=0; i<(outputNumber+1); i++) {

	//Determine MC values:
		
		if(i==0) {MC[i] = "-"} else
		if(i==1) {MC[i] = MCstart} else
		if(i<=MCmin) {MC[i]=MC[(i-1)]-MCslope} else 
		{MC[i] = MC[(i-1)]+MCslope}
		
	}
	
	if (priceLead == 0) {
		Price = ((MC[quantityAnswer]+MC[(quantityAnswer+1)])/2);
		}
	
	for(var i=0; i<(outputNumber+1); i++) {
		
	//Determine all other values based on MC:

		Output[i]=i;
		TFC[i] = FC;
		
		
		AR[i] = Price;
		
		Revenue[i] = AR[i]*i;
		

		if(i==0) {
			TVC[i]=0;
			TC[i] = TVC[i]+TFC[i];
			
			AVC[i]="-";
			AFC[i]="-";
			ATC[i]="-";
			
			MR[i] = "-";
			
			Profit [i] = Revenue[i]-TC[i];
			}
		else {
		
			TVC[i] = MC[i]+TVC[(i-1)];
			TC[i] = TVC[i]+TFC[i];

			AVC[i]=round2(TVC[i]/i)
			AFC[i]=round2(TFC[i]/i)
			ATC[i]=round2(TC[i]/i)
			
			MR[i] = Revenue[i]-Revenue[(i-1)]; 
			
			Profit [i] = Revenue[i]-TC[i];
		}
		
		
	}
	

}


/*
function priceUpdate() {

	//console.log(quantityAnswer);
	//console.log((MC[quantityAnswer]+MC[(quantityAnswer+1)])/2);
	Price = ((MC[quantityAnswer]+MC[(quantityAnswer+1)])/2);
	//console.log(Price);
	
	//document.getElementById("Price"+"_input").value = Price;
}
*/

//Tables

createTable();

function createTable() {
	table01.innerHTML= "";
	var row = [];
	var cell = [];

	var headings = ["Output","MC","TVC","TFC","TC","AVC","AFC","ATC","Revenue","AR","MR","Profit"];

	for(var i=0; i<(outputNumber+2); i++) {
		
			row.push(table01.insertRow(i))
			
			var cellInstance = [];
			
			for (var j=0; j<headings.length; j++) {
			
				cellInstance.push(row[i].insertCell(j));
				
				 
			}
			
			cell.push(cellInstance);
		
		}
		
		//console.log(cell);
		
		
	for(var i=0; i<headings.length; i++) {	
		
		cell[0][i].innerHTML = headings[i];	


	}


	for(var i=0; i<(outputNumber+1); i++) {
		var rowFigures = [Output[i], MC[i], TVC[i], TFC[i], TC[i], AVC[i], AFC[i], ATC[i], Revenue[i], AR[i], MR[i],  Profit[i]];
		
		var span;
		
		
		for(var j=0; j<rowFigures.length; j++) {
		
			span = document.createElement("span");
			span.innerHTML = rowFigures[j];
			
			if (j>=2 && j<=4) {
				span.classList.add("totals")
				}
				
			if (j>=5 && j<=7) {
				span.classList.add("averages")
				}
				
			if (j>=8 && j<=10) {
				span.classList.add("revenues")
				}
				
			if (j==11) {
				span.classList.add("profit")
				}
			
			cell[(i+1)][j].appendChild(span);
			
			
			
			
		
		}
	
		
	}

//Hide AVC, AFC, ATC, and AR columns:

for (var i=0; i<(outputNumber+2); i++) {
	
	
	
	cell[i][5].style.display="none";
	cell[i][6].style.display="none";
	cell[i][7].style.display="none";
	cell[i][9].style.display="none";

}


}


document.getElementById("showColumnsButton").innerHTML = "Show Totals";
var clickCount = 0;

function showColumns() {

	if (clickCount ==0) {
		var columns = document.getElementsByClassName("totals");
		for (var i=0; i<columns.length; i++) {
			columns[i].style.display = "inline";
		}
		document.getElementById("showColumnsButton").innerHTML = "Show Revenue"; //Change back to Show Averages if including averages again
		clickCount =2 //change back to clickCount ++ if including averages again.
		return;

	}
	
	//Removed Averages columns for this exercise
	
	if (clickCount ==1) {
		var columns = document.getElementsByClassName("averages");
		for (var i=0; i<columns.length; i++) {
			columns[i].style.display = "inline";
		}
		document.getElementById("showColumnsButton").innerHTML = "Show Revenue";
		clickCount ++;
		return;

	}
	
	if (clickCount ==2) {
		var columns = document.getElementsByClassName("revenues");
		for (var i=0; i<columns.length; i++) {
			columns[i].style.display = "inline";
		}
		document.getElementById("showColumnsButton").innerHTML = "Show Profit";
		clickCount ++;
		return;

	}

	if (clickCount ==3) {
		var columns = document.getElementsByClassName("profit");
		for (var i=0; i<columns.length; i++) {
			columns[i].style.display = "inline";
		}
		document.getElementById("showColumnsButton").innerHTML = "Hide Figures";
		clickCount ++
		return;

	}
	
	if (clickCount ==4) {
	
		var classTypes = ["totals", "averages", "revenues", "profit"];
		
		for(var j=0; j<classTypes.length; j++) {
		
			var columns = document.getElementsByClassName(classTypes[j]);
			for (var i=0; i<columns.length; i++) {
				columns[i].style.display = "none";
			}
		}
		document.getElementById("showColumnsButton").innerHTML = "Show Totals";
		clickCount =0;
		return;

	}


}

// Create table to control inputs:

//document.getElementById("dataChangeButton").style.display = "none";



var inputs =  ["Output Level", "x-Value where MC Minimises", "Slope of MC Curve (both postiive and negative)", "MC Curve y-Adjustment", "Fixed Costs", "quantityAnswer", "Price"];

var inputsVars =  [outputNumber, MCmin, MCslope, MCstart, FC, quantityAnswer, Price];

var row = [];
var cell = [];

for(var i=0; i<(inputs.length); i++) {
	
		row.push(table02.insertRow(i))
		
		var cellInstance = [];
		
		for (var j=0; j<2; j++) {
		
			cellInstance.push(row[i].insertCell(j));
			
			 
		}
		
		cell.push(cellInstance);
	
	}

for(var i=0; i<inputs.length; i++) {

	cell[i][0].innerHTML = inputs[i];
	cell[i][0].style.width = "150px";
	
	var input = document.createElement("input");
	input.setAttribute("type", "number");
	input.setAttribute("id", inputs[i]+"_input");
	input.setAttribute("onchange", "dataChange()");

	input.value = inputsVars[i];
	
	cell[i][1].appendChild(input);
	

}

//console.log(row);

//Hide input rows:

//Price: 
//row[6].style.display = "none";

//quantityAnswer
row[5].style.display = "none";



function dataChange() {



priceLead = 1;

	for(var i=0; i<inputs.length; i++) {
	
		var inputValue = document.getElementById(inputs[i]+"_input").value;
		inputsVars[i] = parseInt(inputValue);
		//console.log(inputValue);
	
	}
	//console.log(inputsVars);
	outputNumber = inputsVars[0];
	MCmin = inputsVars[1];
	MCslope = inputsVars[2];
	MCstart = inputsVars[3];

	FC = inputsVars[4];
	quantityAnswer = inputsVars[5];
	
	
	
	Price = inputsVars[6];

	determineValues();
	
	createTable();

	//console.log(outputNumber, MCmin, MCslope, MCstart, MCadjust, FC, quantityAnswer, Price);
	
document.getElementById("price_paragraph_span").innerHTML = Price;
document.getElementById("fc_paragraph_span").innerHTML = FC;
document.getElementById("quantityAnswerExplanation").innerHTML = quantityAnswer;





	
		var classTypes = ["totals", "averages", "revenues", "profit"];
		
		for(var j=0; j<classTypes.length; j++) {
		
			var columns = document.getElementsByClassName(classTypes[j]);
			for (var i=0; i<columns.length; i++) {
				columns[i].style.display = "inline";
			}
		}
		document.getElementById("showColumnsButton").innerHTML = "Hide Figures";
		clickCount =4;

}



function showAnswer() {
var button = document.getElementById("showAnswerButton");
var answer = document.getElementById("answer");

if (button.innerHTML == "Click to Show Answer") {
	
	

	answer.style.display = "block";
	button.innerHTML = "Click to Hide Answer"
	}
	
	else {
	
	answer.style.display = "none";
	button.innerHTML = "Click to Show Answer"
	
	
	}
}
	
	
function showInputTable() {
var button = document.getElementById("showInputTableButton");
var answer = document.getElementById("inputTableDiv");

if (button.innerHTML == "Click to Show Input Table") {
	
	

	answer.style.display = "block";
	button.innerHTML = "Click to Hide Input Table"
	}
	
	else {
	
	answer.style.display = "none";
	button.innerHTML = "Click to Show Input Table"
	
	
	}
}


</script>

</body>


</html>