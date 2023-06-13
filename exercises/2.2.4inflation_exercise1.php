<html>


<head>



<?php include "../header.php";?>

<style>

table {
border-collapse: collapse;
}

td, th {
border: solid 1px black;
padding: 5px;


}

td {
text-align: center;

}

.column_5, .column_6, .column_7, .column_8, .column_9, .column_10, .sum_answer, .avg_answer, .infl_answer {

display: none;
}

#step_2, #step_3, #step_4, #step_5, #step_6, #step_7 {
display: none;
}

</style>


</head>


<body onload = "populate()">

<?php include "../navbar.php";?>


<div class="pagetitle">Inflation Exercise 1: Demo</div>

<table id="table_01">
<tr>
<th>Item</th>
<th>Weight</th>
<th>Price Year 1</th>
<th>Price Year 2</th>
<th>Price Year 3</th>
<th>Year 1 Price Index<br>(Base Year)</th>
<th>Year 1 Weighted Index</th>
<th>Year 2 Price Index</th>
<th>Year 2 Weighted Index<br>CPI</th>
<th>Year 3 Price Index</th>
<th>Year 3 Weighted Index<br>CPI</th>

</tr>
</table>
<p>Inflation in Year 2: <span class="infl_answer">(<span class = "yearWeightSum_21"></span>-<span class = "yearWeightSum_11"></span>) /  <span class = "yearWeightSum_11"></span> = <span class="inflation_2"></span>&#37</span></p>
<p>Inflation in Year 3: <span class="infl_answer">(<span class = "yearWeightSum_31"></span>-<span class = "yearWeightSum_21"></span>) /  <span class = "yearWeightSum_21"></span> = <span class="inflation_3"></span>&#37</span></p>
<div style="display:none">
<label for="basketSize">Choose a number of items for your basket:</label>

<select name="basketSize" id="basketSize">
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10+">10+</option>
  
</select>

<br>
<button onclick ="weightsSum()">Add weights</button>
<br>
<button onclick="priceGenerate()">Generate Prices</button>
<br>
<button onclick="calculate()">Calculate</button>
<br>
</div>
<div id="instructions">
<div id="step_1">
<h2>Step 1: Assign Weights</h2>
<button onclick="nextStep(1)">Next</button>
<p>Weight the items in your basket according to how much you purchase them. Remember to have the weights add up to a multiple of 10.</p>
<button onclick="weightsSum()">Click to add weights</button>
<p>The prices have been generated randomly. If you want to you can create a new set of prce changes by clicking below:</p>
<button onclick="priceGenerate()">Change Prices</button>


</div>
<div id = "step_2">
<h2>Step 2: Create Base Year Index</h2>
<button onclick=" prevStep(2)">Back</button>
<button onclick="showStep(1); nextStep(2)">Next</button>
<p>Assign a value of 100 for the price index of each item in Year 1 (the base year). Why do we do this?</p>

</div>
<div id="step_3">
<h2>Step 3: Create Price Index for Years 2 and 3</h2>
<button onclick="hideStep(1); prevStep(3)">Back</button>
<button onclick="showStep(2); showStep(3); nextStep(3);">Next</button><p>Remember the formula will be: Year 2 Index = (Price Year 2 / Price Year 1) x 100</p>
</div>
<div id="step_4">
<h2>Step 4: Create a Weighted Index for Years 2 and 3.</h2>
<button onclick="hideStep(2), hideStep(3); prevStep(4)">Back</button>
<button onclick="showStep(4); showStep(5); showStep(6); nextStep(4);">Next</button>
<p>Formula: Weighted Index = Price Index x Weight</p>
<p>Optional: create a weighted price index for Year 1. Why is this not necessary?</p>
</div>
<div id="step_5">
<h2>Step 5: Add up the total of the Weighted Index for Years 2 and 3</h2>
<button onclick="hideStep(4); hideStep(5); hideStep(6); prevStep(5)">Back</button>
<button onclick="showStep(7); nextStep(5);">Next</button>
</div>
<div id="step_6">
<h2>Step 6: Divide the total of each Weighted Index by the total of the weighted values.</h2>
<button onclick="hideStep(7); prevStep(6)">Back</button>
<button onclick="showStep(8); nextStep(6);">Next</button>
</div>
<div id="step_7">
<button onclick="hideStep(8); hideStep(9); prevStep(7)">Back</button>
<h2>Step 7: Compare the difference of the average Weighted Index compared to the year before.</h2><p>Express as a percentage. This is the inflation rate; this is your answer.</p>
<button onclick="showStep(9);">Click for Answer</button>
<p>Helpful tip: the percentage change between Year 1 and Year 2 will be easy. You need to be careful with the change from Year 2 to Year 3. Using our example from above:</p>
<table>
<tbody>
<tr>
<td>
<p>Year 1 Weighted Index</p>
</td>
<td>
<p>Year 2 Weighted Index</p>
</td>
<td>
<p>Year 3 Price Index</p>
</td>
</tr>
<tr>
<td>
<p><span class = "yearWeightSum_11"></span></p>
</td>
<td>
<p><span class = "yearWeightSum_21"></span></p>
</td>
<td>
<p><span class = "yearWeightSum_31"></span></p>
</td>
</tr>
</tbody>
</table>
<p>Inflation in Year 2 is <span class="inflation_2"></span>&#37. This is because (<span class = "yearWeightSum_21"></span>-<span class = "yearWeightSum_11"></span>) /  <span class = "yearWeightSum_11"></span> = <span class="inflation_2"></span>&#37</p>
<p>Inflation in Year 3 is <span class="inflation_3"></span>&#37. This is because (<span class = "yearWeightSum_31"></span>-<span class = "yearWeightSum_21"></span>) /  <span class = "yearWeightSum_21"></span> = <span class="inflation_3"></span>&#37</p>
<p>The trick is to remember that the year you are comparing against has changed as well.</p>
</div>
</div>

</div>


<?php include "../footer.php";?>
<script>

/*
This exercise is based on inflation1.1.html.
Some ideas for future development:
-Create input so that user can choose how many items in the 'basket'. This will affect variable 'length'
-Create input so that user can choose how close original price is rounded to. This will affect variable 'rounder' and function 'priceRound()'
-Create index of standard price changes (currently random assignments) to compare across students or to have shared types of changes
-Separate random list generation from function 'populate()' so that user can change basket of goods without refreshing.
*/

var items = [
  ["Heinz Baked Beanz",0.7],
  ["Chopped Tomatoes",1],
  ["Digestive Bisquits 400g",1.3],
  ["PG Tips: 240 Tea Bags",3.5],
  ["Sainsburys Fusili Pasta 400g",1],
  ["344kg Sainsbury's Broccoli Loose",0.55],
  ["Sainsbury's Braeburn Apples x6",1.6],
  ["Tropicana Smooth Orange Juice 950ml",1.5],
  ["KTC Chopped Tomatoes 400g",1.8],
  ["Quorn Vegetarian Cocktail Sausages 180g ",1.75],
  ["Warburtons Crumpets x9 ",1.25],
  ["Sainsbury's Passata 500g ",0.4],
  ["Sainsbury's Iceberg Lettuce ",0.43],
  ["Mission Deli Wrap Plain x6 ",1.2],
  ["Sainsbury's Caledonian Sparkling Water 4x2L ",1.6],
  ["Napolina Tomato Passata 500g ",1.2],
  ["Sainsbury's Thin & Crispy Pepperoni Pizza 305g ",1],
  ["Sainsbury's Thin & Crispy Four Cheese Pizza 354g ",1.5],
  ["7up Free Cherry 6x330ml ",5],
  ["Cravendale Purefilter Semi Skimmed Milk 2L ",4.8],
  ["Sainsbury's Fairtrade Bananas x5 ",1.38],
  ["Quorn Vegetarian Chicken Style Chipotle Goujons 180g ",2.5],
  ["Yeo Valley Organic Greek Style Natural Yogurt 450g ",1.7],
  ["Yeo Valley Organic Blueberry & Lime Yogurt 450g ",1],
  ["Sainsbury's Woodland Free Range Large Eggs x12 ",2.05],
  ["Sainsbury's Blueberries 300g ",2.5],
  ["Sainsbury's Large Onions x3 ",0.95],
  ["Sainsbury's Beef Mince 5% Fat 500g ",2.59],
  ["Cauldron Falafels 200g ",2],
  ["Sainsbury's Cheese & Garlic Flatbread 224g ",1.2],
  ["Sainsbury's Large Red Onions x3 ",0.85],
  ["Quorn Vegetarian Mince 350g ",3.25],
  ["Sainsbury's Carrots 1kg ",0.41],
  ["Birds Eye Garden Peas 800g ",2],
  ["Fruit Bowl Raspberry Peelers 5x16g ",2.25],
  ["Sainsbury's Emmental Cheese Slices 250g ",1.7],
  ["Quorn Meat Free Chicken Pieces 350g ",3.25],
  ["Lindahls Kvarg Raspberry 150g ",0.95],
  ["Sainsbury's Closed Cup White Mushrooms 300g ",0.75],
  ["Sainsbury's Home Napkins White 33cm x50 ",3],
  ["Tyrrells Veg Balsamic Vinegar & Sea Salt Sharing Crisps 125g ",3],
  ["Plenty White Kitchen Towel x4 Rolls ",6],
  ["Green Giant Salt Free Sweet Corn 4x198g ",2.65],
  ["Lavazza Cafe Decaffeinated Ground Coffee 250g ",4.1],
  ["Cheerios Multigrain Cereal 300g ",2],
  ["Cravendale Purefilter Whole Milk 1L ",1.15],
  ["Sainsbury's Turkey Breast Mince 2% Fat 500g ",3.8],
  ["WaterWipes Sensitive Biodegradable Newborn Baby Wipes x60 ",4.4],
  ["Sainsbury's Soft Medium Sliced White Bread 800g ",0.55],
  ["Sainsbury's British Fresh Medium Whole Chicken 1.6kg ",3.3],
  ["Kiddylicious Blueberry Wafers Snack 20g 6 Month+ ",1.3],
  ["Quorn Vegetarian Peppered Steaks 196g ",3],
  ["Spontex 40 Handy Latex Disposable Gloves ",5.5],
  ["Sainsbury's Brioche Burger Buns x4 ",0.95],
  ["Sainsbury's Conference Pears x4 ",1.5],
  ["Pip & Nut Ultimate Deep Roast Peanut Butter Extra Crunchy 400g ",2.75],
  ["Organix Raspberry & Banana Muesli 200g ",2.75],
  ["Sainsbury's Black Seedless Grapes 500g ",1.75]
]



function convert(value){
    return "&pound;"+((Number(value)||0).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}

function roundTwo(i) {
	return Number(i.toFixed(2))

}

var prices = [ [], [], [], [], [], [],[],[],[],[]	]
var inflation = [[],[]]
var weightCount = 0;
var weight_sum;

var length = 4;
var color = ["blue", "green"]



function populate() {

var table = document.getElementById("table_01");

for (var i = 0; i<length; i++) {
	
	var row = table.insertRow(i+1);
	var cell = [];
	var div = [];
	
	for(var j=0; j<11; j++) {
		cell[j] = row.insertCell(j);
		div[j] = document.createElement("div");
		div[j].setAttribute("class", "column_"+j);
		div[j].setAttribute("id", "div__col"+j+"_row"+i);
		cell[j].appendChild(div[j]);
		}
	
	
	
	var input2 = document.createElement("input");
	input2.setAttribute("type", "number");
	input2.setAttribute("id", "input_2_"+i);
	input2.setAttribute("min", "0");
	input2.setAttribute("step", "1");
	input2.setAttribute("value", prices[3][i]);
	input2.setAttribute("onchange", "weightsSum()");
	input2.style.width="50px";
	input2.style.textAlign="center";
	
	

	var random_item = Math.floor(Math.random()*items.length);
	prices[0][i]= priceRound(items[random_item][1]);
	
		
	div[0].innerHTML = items[random_item][0];
	div[1].appendChild(input2);
	div[2].innerHTML = convert(prices[0][i]);
	
	cell[2].setAttribute("id", "cell2_"+i);
	cell[3].setAttribute("id", "cell3_"+i);
	cell[4].setAttribute("id", "cell4_"+i);
		
	items.splice(random_item, 1);
	

	}
	

weightsInput();
priceGenerate();



}

var rounder = 2;

function priceRound(i) {
	if (rounder ==1) {
		return i
	}
	else if (rounder ==2) {
		return Number(i.toFixed(1))
	}
	else if (rounder ==3) {
		return Math.round(i);
	}

}

function priceGenerate() {

var change_step = 0.02;
var range = 8;
var centre = 2;


var table = document.getElementById("table_01");
for (var i = 0; i<length; i++) {
	
	var random_change;
	
	do {
		random_change= (Math.floor(Math.random()*(range+1)-(range/2)+centre)/(1/change_step)).toFixed(2);
		}
	while (random_change ==0);
	
	var random_change2;

	var year1 = prices[0][i]
	/*random_change = -0.25;*/
	if (random_change < 0) {
		var change = year1*random_change-0.000001;
			do {
				random_change2 = (Math.floor(Math.random()*(range+1)-(range/2)+centre)/(1/change_step)).toFixed(2)
				}
			while (random_change2 > 0||(random_change2==random_change)||(random_change2 ==0))	
		}
		else {
		var change = year1*random_change+0.000001;
			do {
				random_change2 = (Math.floor(Math.random()*(range+1)-(range/2)+centre)/(1/change_step)).toFixed(2)
				}
			while ((random_change2 < 0)||(random_change2==random_change)||(random_change2 ==0))	
		}

	console.log(random_change+" "+random_change2);

	
	prices[0][i]= year1;
	prices[1][i]= year1+change;
	
	var year2 = (year1+change);
	
	if (random_change2 < 0) {
		var change2 = year2*random_change2-0.000001;
		}
	else {
		var change2 = year2*random_change2+0.000001;
		}
	
	prices[2][i]= year2+change2;
	
	var div = [0, 0, document.getElementById("div__col2_row"+i), document.getElementById("div__col3_row"+i), document.getElementById("div__col4_row"+i)];
	

	
	div[2].innerHTML = convert(prices[0][i]);
	div[3].innerHTML = convert(prices[1][i]);	
	div[4].innerHTML = convert(prices[2][i]);	



	}
	calculate();

}

function weightsSum() {

	var table = document.getElementById("table_01");

	for(var i=0; i<prices[0].length; i++) {
		prices[3][i]=document.getElementById("input_2_"+i).value;
		}
	
	function add(accumulator, a) {
		return accumulator + a;
		}
	
	function getSum(total, num) {
		return total + parseFloat(num);
		}
	
	weight_sum = prices[3].reduce(getSum, 0);
	
	document.getElementById("weightSum").innerHTML = weight_sum;

	calculate();
}

function weightsInput() {


	
for(var j = 0; j<2; j++) {

	var table = document.getElementById("table_01");
	var row = table.insertRow(table.rows.length);
	var cell=[];
	
	for(var i=0; i<11-2; i++) {
	
		cell[i] = row.insertCell(i);
		
		}
		
		
		
		/*Note: All the [7-2] stuff below is to accomodate a colspan at cell[2] which was a formatting decision. If colspan is removed then:
			-Set them back to values
			-Remove var label
			-Take off commetns around cell[4] and cell[5]
			*/
		
		var label = ["Sum:", "Average:"]
	
		cell[0].setAttribute("style", "border-bottom: none; border-left:none; border-top: none; border-right:none;");
		;
		
		if (j ==1) {cell[1].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");}
		
		cell[1].setAttribute("id", "weightSum");
		cell[1].style.color = color[j];
		
		cell[2].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");
				
		cell[2].innerHTML = label[j];
		cell[2].style.color = color[j]
		cell[2].setAttribute("colspan", "3");
		cell[2].style.textAlign = "right";
		
		cell[3].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");
		
		/*
		cell[4].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");
		cell[5].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");	
		*/
		
		
		cell[7-2].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");
		
		cell[9-2].setAttribute("style", "border-left: none; border-bottom: none; border-right:none; border-top: none;");
		
		var div = [];
		for(var i=0; i<3; i++) {
			
			div[i] = document.createElement("div");
			
				if (j==0) {
					div[i].setAttribute("class", "sum_answer");
					}
				else {
					div[i].setAttribute("class", "avg_answer");
					}
		
			}
		div[0].classList.add("yearWeightSum_1"+j);
		div[0].style.color = color[j];
		
		
		div[1].classList.add("yearWeightSum_2"+j);
		div[1].style.color = color[j];
		
		
		div[2].classList.add("class", "yearWeightSum_3"+j);
		div[2].style.color = color[j];
		
		
		

		
		cell[6-2].appendChild(div[0]);
		cell[8-2].appendChild(div[1]);
		cell[10-2].appendChild(div[2]);
		
		/*
		
		cell[6-2].setAttribute("id", "yearWeightSum_1"+j);
		cell[6-2].style.color = color[j];
		cell[6-2].setAttribute("class", "column_6");
		
		cell[8-2].setAttribute("id", "yearWeightSum_2"+j);
		cell[8-2].style.color = color[j];
		cell[8-2].setAttribute("class", "column_8");
		
		cell[10-2].setAttribute("id", "yearWeightSum_3"+j);
		cell[10-2].style.color = color[j];
		cell[10-2].setAttribute("class", "column_10");
		*/

	
	}
	

	

	


}

function calculate() {


	for(var i=0; i<prices[0].length; i++) {
		prices[4][i] = 100;
		}
		
	for(var i=0; i<prices[0].length; i++) {
		prices[5][i] = prices[3][i]*prices[4][i];
	}
		
	for(var i=0; i<prices[0].length; i++) {
		prices[6][i] = Number(((Number(prices[1][i].toFixed(2))/Number(prices[0][i].toFixed(2)))*100).toFixed(2))
	}

	for(var i=0; i<prices[0].length; i++) {
		prices[7][i] = roundTwo(prices[6][i]*prices[3][i])
	}		
	
	for(var i=0; i<prices[0].length; i++) {
		prices[8][i] = Number(((Number(prices[2][i].toFixed(2))/Number(prices[0][i].toFixed(2)))*100).toFixed(2))

	}

	for(var i=0; i<prices[0].length; i++) {
		prices[9][i] = roundTwo(prices[8][i]*prices[3][i])
	}


	var column = document.getElementsByClassName("column_5");
	for(var i = 0; i<column.length; i++) {
		column[i].innerHTML = prices[4][i];
		}

	var column = document.getElementsByClassName("column_6");
	for(var i = 0; i<column.length; i++) {
		column[i].innerHTML = prices[5][i];
		}
	

	
	var column = document.getElementsByClassName("column_7");
	for(var i = 0; i<column.length; i++) {
		column[i].innerHTML = prices[6][i];
		}
	
	var column = document.getElementsByClassName("column_8");
	for(var i = 0; i<column.length; i++) {
		column[i].innerHTML = prices[7][i];
		}
		
	var column = document.getElementsByClassName("column_9");
	for(var i = 0; i<column.length; i++) {
		column[i].innerHTML = prices[8][i];
		}
		
	var column = document.getElementsByClassName("column_10");
	for(var i = 0; i<column.length; i++) {
		column[i].innerHTML = prices[9][i];
		}
		
	
	function getSum(total, num) {
		return total + parseFloat(num);
		}
	
	var yearSum = [[],[],[]]
	
	yearSum[0][0] = roundTwo(prices[5].reduce(getSum, 0));
	yearSum[1][0] = roundTwo(prices[7].reduce(getSum, 0));
	yearSum[2][0] = roundTwo(prices[9].reduce(getSum, 0));
	
	yearSum[0][1] = roundTwo(yearSum[0][0]/weight_sum);
	yearSum[1][1] = roundTwo(yearSum[1][0]/weight_sum);
	yearSum[2][1] = roundTwo(yearSum[2][0]/weight_sum);
	
	
	var yearSumElements = [
							["yearWeightSum_10", yearSum[0][0], color[0]],
							["yearWeightSum_20", yearSum[1][0], color[0]],
							["yearWeightSum_30", yearSum[2][0], color[0]],
							["yearWeightSum_11", yearSum[0][1], color[1]],
							["yearWeightSum_21", yearSum[1][1], color[1]],
							["yearWeightSum_31", yearSum[2][1], color[1]],
							]
	
	for(var i=0; i<yearSumElements.length ; i++) {
		
		var sum = document.getElementsByClassName(yearSumElements[i][0]);
		for(var j=0; j<sum.length; j++) {
			
			sum[j].innerHTML = yearSumElements[i][1];
			sum[j].style.color = yearSumElements[i][2];
			
			}
		
		}
	
	
	/*
	document.getElementById("yearWeightSum_10").innerHTML = yearSum[0][0];
	document.getElementById("yearWeightSum_20").innerHTML = yearSum[1][0];
	document.getElementById("yearWeightSum_30").innerHTML = yearSum[2][0];
	
	document.getElementById("yearWeightSum_11").innerHTML = yearSum[0][1];
	document.getElementById("yearWeightSum_21").innerHTML = yearSum[1][1];
	document.getElementById("yearWeightSum_31").innerHTML = yearSum[2][1];
	*/
	
	inflation[0] = roundTwo(((yearSum[1][1]-yearSum[0][1])/yearSum[0][1])*100);
	inflation[1] = roundTwo(((yearSum[2][1]-yearSum[1][1])/yearSum[1][1])*100);
	
	for(var i=0; i<2; i++) {
	
		var infl = document.getElementsByClassName("inflation_"+(i+2));
		for(var j=0; j<infl.length; j++) {
			infl[j].innerHTML = inflation[i];
			}
	
		}
	
	/*
	
	document.getElementById("inflation_2").innerHTML = inflation[0];
	document.getElementById("inflation_3").innerHTML = inflation[1];
	*/
	console.log(yearSum);
	console.log(inflation);
	

}


function nextStep(i) {

	if (isNaN(weight_sum)) {
	
		alert("You must enter weights for the basket of goods");
	}
	
	else {

	var index = [];
	
	document.getElementById("step_"+i).style.display="none";
	document.getElementById("step_"+(i+1)).style.display="block";
	
	}
	
}

function showStep(i) {

	index =[0,"column_5","column_7","column_9", "column_6", "column_8", "column_10", "sum_answer", "avg_answer", "infl_answer"];
	
	var step = document.getElementsByClassName(index[i]);
	for(var j=0; j<step.length; j++) {
		step[j].style.display = "inline-block";
		
		}

}

function prevStep(i) {

	var index = [];
	
	document.getElementById("step_"+i).style.display="none";
	document.getElementById("step_"+(i-1)).style.display="block";
	
	
	
}

function hideStep(i) {

	index =[0,"column_5","column_7","column_9", "column_6", "column_8", "column_10", "sum_answer", "avg_answer", "infl_answer"];
	
	var step = document.getElementsByClassName(index[i]);
	for(var j=0; j<step.length; j++) {
		step[j].style.display = "none";
		
		}

}

</script>
</body>

</html>