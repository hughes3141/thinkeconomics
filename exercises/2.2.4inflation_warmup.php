<html>

<head>

<?php include "../header.php";?>

<!--

This resource is designed to be used in a classroom on a smart board or projector as a way of introducing calculation of inflation.

-->

<style>

table {
border-collapse: collapse;
}

th, td {
border: solid 1px black;
padding: 5px;

}

td {

    text-align: center; 
    vertical-align: middle;
	
	


}

tr {
  height: 30px;
}

.step_51 {

	display: none;
}

.step_2, .step_3, .step_4, .step_5, .step_6, .step_7, .step_8, .step_9, .step_10 {

display: none;
}

</style>



<body onload="populate()">

<?php include "../navbar.php";?>

<div class="pagetitle">Inflation Calculation: Warm-Up</div>

<div class="step_1">
<input type="text" id="item_01" class="step_1" placeholder="Enter name of item">
<input type ="button" onclick="addRow();" value ="Add another item" class="step_1">
<input type ="button" onclick="step_2();" value ="Step 2: Add Prices" class="step_1">
<input type ="button" onclick ="undo_addRow()" value ="Undo Last Emement" class="step_1">

</div>
<br id="hidden_break" style="display:none;">
<br>
<table id="table_01" style="min-width: 60%">
<tr>
<th>Item</th>
<th>Weight</th>
<th>Price Year 1</th>
<th> Price Year 2</th>
<th class="step_51">Year 1 Price Index<br>Base Year</th>
<th class="step_51">Year 2 Price Index</th>
<th class="step_51">Year 2 Weighted Index<br>CPI</th>
</tr>
</table>
<div class = "step_1">
<h1>Step 1: Select Some Items</h1>
<p>Think of a few items you purchase regularly.</p>
<p>Enter these into the table using the input bar.</p>

</div>
<div class="step_2" >
<h1>Step 2: Assign prices for each of the items on your list.</h1><p>How much does each cost?</p>
<input type ="button" onclick = "step_3()" class="step_2" value="Next: Add Weights">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(2)" class="goback">Back</button>

</div>
<div class="step_3" >
<h1>Step 3: Assign weights.</h1><p>What percentage of spending do you devote to this item? Note that the weights should add up to a number that is easy to work with, such as 1.0, 10, 100 or 1000.</p>
<input type ="button" onclick = "step_4()" value="Next: Change Prices Between Years">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(3)" class="goback" style="display:none">Back</button></div>
<div class="step_4" >
<h1>Step 4: Price Changes</h1>
<p>In year 2 the prices of the goods have changed by some random value.</p>
<input type = "button" onclick="yearTwo()" value ="Click here to generate new random price changes">
<p>You now have all the information you need to calculate a single figure that can be used to represent the average price change of all of these goods.</p>
<p>Challenge: See if you can find a method to come up with this number.</p>
<input type = "button" onclick="step_5()" value ="Click for hints">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(4)"class="goback" style="display:none;">Back</button>
</div>
<div class="step_5" >
<h1>Step 5: Year 1 Price Index</h1>
<p>The first step is to create a price index for Year 1. This will be your base year.</p>
<p>Because it is the base year, it makes sense to set all values equal to 100. This will make it easy to compare against prices in future years.</p>
<input type = "button" onclick="step_6()" value ="Click here to add the price index for Year 1 and next step.">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(5)" class="goback">Back</button>
</div>
<div class = "step_6" >
<h1>Step 6: Year 2 Price Index</h1>
<p>The next step is to create a price index for Year 2.</p>
<p>Numbers in this column will be in the same proportion to 100 (our base year) as the price of our item in Year 2 to its price in Year 1.</p>
<p>Formula: Year 2 Price Index = (Price Year 2 / Price Year 1) x 100</p>
<input type="button" onclick="step_7()" value ="Click here to add the price index for Year 2 and next step.">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(6)" class="goback">Back</button></div>

<div class = "step_7">
<h1>Step 7: Year 2 Weighted Index (CPI)</h1>
<p>We now want to create a Year 2 Weighted Index. This is a Consumer Price Index.</p>
<p>Formula: Year 2 Weighted Index = Weight x Year 2 Price Index</p>
<p>This figure weights the price changes relative to how much of your income gets spent on each item.</p>
<p>Items with a greater weight have a greater value because you spend more of your money on the item.</p>
<input type="button" onclick ="step_8()" value ="Click here to add Weighted Index and Next Step">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(7)" class="goback">Back</button></div>

<div class = "step_8">
<h1>Step 8: Sum of Weighted Values</h1>
<p>Each item in the Weighted Index shows how much that item&rsquo;s price change will change the price of our basket of goods.</p>
<p>To find out the total price change in the basket of goods we can add these figures together.</p>
<input type="button" onclick ="step_9()" value ="Click to find Sum of Weighted Index Figures and Next Step">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(8)" class="goback">Back</button></div>

<div class = "step_9">
<h1>Step 9: Divide by Sum of Weights</h1>
<p>Our final step is to come up with a price index which is comparable to the price index in our base year.</p>
<p>The sum of the weighted index is a good place to start. But it has been inflated due to the value of the weights.</p>
<p>To adjust for this, divide the sum of the weighted index by the sum of the weights.</p>
<p>This will give us a price index against which we can compare our base year price index, giving us a single inflation figure.</p>
<input type="button" onclick="step_10()" value ="Click here for final step.">
<br class="goback">
<br class="goback">
<button onclick ="stepBack(9)" class="goback">Back</button></div>

<div class = "step_10">
<h1>Step 10: Compare against Year 1 Price Index</h1>
<p>Congratulations! You have successfully calculated inflation between two years using a Consumer Price Index (CPI).</p>
<p>Our CPI in Year 1 is 100. This is because this is our base year.</p>
<p>Our CPI in Year 2 is <span id="c1" style="color:green"></span> / <span id="c2" style="color:blue"></span> = <span id="c3" style="font-size: larger"></span>.</p>
<p>The percentage change between these two figures is <span id="c4" style="font-size: larger"></span>%.</p>
<p>This percentage change is the inflation figure.</p>
<p>You could use this method to find the inflation rate between any two years (not just the base year).</p>
<br class="goback">
<br class="goback">
<button onclick ="stepBack(10)" class="goback">Back</button></div>


</div>
</div>

<?php include "../footer.php";?>
<script>

var change_step = 0.02;
var range = 10;
var centre = 4;


var index = [ [], [], [], [], [], [] ];

var cpi;
var cpi_weight;
var weight_sum;
var inflation;

/* 
index[0] = Prices year 1
index[1] = Price year 2
index[2] = Weights
index[3] = Price index year 2
index[4] = Price index Year 2 (float and rounded to 2dp, as appears in table)
index[5] = Weighted Index

*/

function populate(){

		
	
	
	}


function convert(value){
    return "&pound"+((Number(value)||0).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}

function addRow() {

	
	var table = document.getElementById("table_01");
	var count = table.rows.length - 1;

	var row = table.insertRow(count+1);
	
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var cell6 = row.insertCell(5);
	var cell7 = row.insertCell(6);
	
	cell5.setAttribute("class", "step_51");
	cell6.setAttribute("class", "step_51");
	cell7.setAttribute("class", "step_51");
	
	cell5.setAttribute("id", "cell_5_"+count);
	cell6.setAttribute("id", "cell_6_"+count);
	cell7.setAttribute("id", "cell_7_"+count);
	
	var input2 = document.createElement("input");
	input2.setAttribute("type", "number");
	input2.setAttribute("id", "input_2_"+count);
	input2.setAttribute("min", "0");
	/*input2.setAttribute("max", "1");*/
	input2.setAttribute("step", "1");
	input2.setAttribute("class", "step_3");
	input2.setAttribute("style", "display:none; width: 50px ;");
	
	
	cell2.setAttribute("class", "weight_input");
	cell2.setAttribute("id", "cell_2_"+count);
	
	
	var input3 = document.createElement("input");
	input3.setAttribute("type", "number");
	input3.setAttribute("id", "input_"+count+"_3");
	input3.setAttribute("min", "0");
	/*input3.setAttribute("max", "10");*/
	input3.setAttribute("step", "1");
	input3.setAttribute("class", "step_2");
	input3.setAttribute("style", "display:none; width: 100px  ;");

	
	cell3.setAttribute("class", "price_input");
	cell3.setAttribute("id", "cell_3_"+count);
	
	cell4.setAttribute("class", "price_new");
	cell4.setAttribute("id", "cell_4_"+count);
	

	
	cell1.innerHTML = document.getElementById("item_01").value;
	cell2.appendChild(input2);
	/*cell3.innerHTML = "&pound";*/
	cell3.appendChild(input3);
	
	
	document.getElementById("item_01").value ="";
	
	
	
	
	}

function undo_addRow() {

	
	
	var table = document.getElementById("table_01");
	if (table.rows.length > 1 ) {
		table.deleteRow(table.rows.length-1);
		}
	}

function stepChange(val) {
	var a = document.getElementsByClassName("step_"+val);
	for (var i= 0; i<a.length; i++) {
		a[i].style.display="inline";
		}
	
	var b = document.getElementsByClassName("step_"+(val-1));
	for (var i= 0; i<b.length; i++) {
		b[i].style.display="none";
		}

}

function stepBack(val) {

var a = document.getElementsByClassName("step_"+val);
	for (var i= 0; i<a.length; i++) {
		a[i].style.display="none";
		}
	
	var b = document.getElementsByClassName("step_"+(val-1));
	for (var i= 0; i<b.length; i++) {
		b[i].style.display="inline";
		}


}

function step_2() {

	stepChange(2);
	/*
	var s2 = document.getElementsByClassName("step_2");
	for (var i= 0; i<s2.length; i++) {
		s2[i].style.display="inline";
		}
	
	var s1 = document.getElementsByClassName("step_1");
	for (var i= 0; i<s1.length; i++) {
		s1[i].style.display="none";
		}
	
	*/
		
	document.getElementById("hidden_break").style.display = "inline";
	
	}
	


function step_3() {

	var table = document.getElementById("table_01");

	
	
	for(var i=0; i<table.rows.length-1; i++) {
		index[0][i]=parseFloat(document.getElementById("input_"+i+"_3").value);
		document.getElementById("cell_3_"+i).innerHTML = convert(index[0][i]);
		}
	
	stepChange(3);
	
	/*

	var s2 = document.getElementsByClassName("step_2");
	for (var i= 0; i<s2.length; i++) {
		s2[i].style.display="none";
		}
		
	var s3 = document.getElementsByClassName("step_3");
	for (var i= 0; i<s3.length; i++) {
		s3[i].style.display="inline";
		}
	
	*/
}

function step_4() {
	
	var table = document.getElementById("table_01");

	
	for(var i=0; i<table.rows.length-1; i++) {
		index[2][i]=document.getElementById("input_2_"+i).value;
		}
	
	function add(accumulator, a) {
		return accumulator + a;
		}
	
	function getSum(total, num) {
		return total + parseFloat(num);
		}
	
	weight_sum = index[2].reduce(getSum, 0);
		

	
	
		
	
		
		for(var i=0; i<table.rows.length-1; i++) {
		
			document.getElementById("cell_2_"+i).innerHTML = index[2][i];
						
			}
		
		
		yearTwo();
		
		var row = table.insertRow(table.rows.length)
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		cell1.setAttribute("style", "border-left: none; border-bottom: none;");
		
		cell2.innerHTML = weight_sum;
		cell2.style.color = "blue";
		
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		var cell6 = row.insertCell(5);
		var cell7 = row.insertCell(6);
		
		cell3.setAttribute("style", "border-bottom: none; border-right:none;");
		cell4.setAttribute("style", "border-left: none; border-bottom: none; border-right:none;");
		cell5.setAttribute("style", "border-left: none; border-bottom: none; border-right:none;");
		cell6.setAttribute("style", "border-left: none; border-bottom: none; border-right:none;");
		
		cell5.setAttribute("class", "step_51");
		cell6.setAttribute("class", "step_51");
		cell7.setAttribute("class", "step_51");
		
		cell7.setAttribute("id", "cell_7_last");
		
		stepChange(4);
		
		/*
		
		var s3 = document.getElementsByClassName("step_3");
		for (var i= 0; i<s3.length; i++) {
			s3[i].style.display="none";
			}
			
		var s4 = document.getElementsByClassName("step_4");
		for (var i= 0; i<s4.length; i++) {
			s4[i].style.display="inline";
			}
		*/
		
	
}

function yearTwo() {

		var table = document.getElementById("table_01");

		for(var i=0; i<index[0].length; i++) {

			var random_change = (Math.floor(Math.random()*(range+1)-(range/2)+centre)/(1/change_step)).toFixed(2);
			
			var year1 = parseFloat(index[0][i]);
			/*random_change = -0.25;*/
				if (random_change < 0) {
					var change = year1*random_change-0.000001
					}
				else
					{var change = year1*random_change+0.000001}
			
			var year2 = year1+change;
			
			index[1][i] = year2;
			
			document.getElementById("cell_4_"+i).innerHTML = convert(year2);
			
			console.log(random_change);
		}

}

function step_5() {

	stepChange(5);
	/*

	var s5 = document.getElementsByClassName("step_5");
		for (var i= 0; i<s5.length; i++) {
			s5[i].style.display="inline";
			}
	*/	
	var s51 = document.getElementsByClassName("step_51");
		for (var i= 0; i<s51.length; i++) {
			s51[i].style.display="table-cell";
			}

}

function step_6() {

	for(var i=0; i<index[0].length; i++) {
		
		document.getElementById("cell_5_"+i).innerHTML = 100;
		}
		
	stepChange(6);

}

function step_7() {

	for(var i=0; i<index[0].length; i++) {
	
		index[3][i]= ((index[1][i]/index[0][i])*100);
		
		index[4][i] = parseFloat(index[3][i].toFixed(2));
		
		document.getElementById("cell_6_"+i).innerHTML = index[4][i];
		
	}
	
	stepChange(7);
}

function step_8() {

	for (var i=0; i<index[0].length; i++) {
	
		index[5][i] = index[2][i]*index[4][i];
		document.getElementById("cell_7_"+i).innerHTML = parseFloat(index[5][i].toFixed(2));
		
	
	}
	
	stepChange(8);

}

function step_9() {

	function getSum(total, num) {
		return total + parseFloat(num);
		}
	
	cpi_weight = index[5].reduce(getSum, 0);
	
	document.getElementById("cell_7_last").innerHTML = parseFloat(cpi_weight.toFixed(2));
	document.getElementById("cell_7_last").style.color = "green";
	
	stepChange(9);

}

function step_10() {


	stepChange(10);
	document.getElementById("c1").innerHTML = cpi_weight;
	document.getElementById("c2").innerHTML = weight_sum;
	
	cpi = parseFloat(cpi_weight/weight_sum.toFixed(2));
	document.getElementById("c3").innerHTML = cpi.toFixed(2);
	
	inflation = (cpi-100).toFixed(2);
	document.getElementById("c4").innerHTML = inflation;


}

</script>

</body>


</html>