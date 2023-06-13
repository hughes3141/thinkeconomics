<html>

<head>

<?php include "../header.php"; ?>

<style>

/*

.container {
	border: 3px solid black;
	position: relative;
    padding: 0px;
	overflow: auto;
	height: 200px;
	width: 90%;
	

}
*/

.floater {
	border: 3px solid red;
	position: absolute;
	padding: 0px;

	height: 50px;
	width: 50px;

}

.n1 {

	left: 10;
	top: 10;
}

.n2 {

	left: 140;
	top: 10;
}

.float-container {
    border: 3px solid black;
    padding: 0px;
	overflow: auto;
	height: 200px;
	//width: 90%;

}

.float-child {
	
    float: left;
    padding: 0px;
    border: 2px solid red;
	width:42%;
	margin: 10px;
	height: 85%;
	text-align: center;
	
	}
	
.col_1 {
	float: left;
	width: 48%;}

.col_2 {
	float: right;
	width: 48%;}
	
	
.country_name {


}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}

tr, th, td {

	border: 1px solid black;
	
	}

th, td {
	padding: 5px;
	min-width: 200px;}
	
table {
border-collapse: collapse;
}

</style>


</head>


<body onload="populate(), setup()">

<?php include "../navbar.php"; ?>


<h1>1.2.4 PED Warm-Up</h1>

<h2>Instructions:</h2>
<p>The cards below will show two products. Click which one you think is more INELASTIC (i.e. less responsive to price). When you click the answer will show. If the card shows <span id="right_sign">green</span> you guessed right; <span id="wrong_sign">red</span> means you guessed wrong. See if you can get a high score!</p>
<p>You can find the data here: <a href="https://scholar.harvard.edu/files/alada/files/price_elasticity_of_demand_handout.pdf" target="_blank">Price Elasticity of Demand Handout</a></p>

<!--
<p style="display: none;">Click &ldquo;Start Game&rdquo; to begin.</p>
<p>The two cards below will show the names of two countries.</p>
<p>Guess which one is the <em>less corrupt</em>. This is measured by Transparency International&rsquo;s Corruption Perception Index. A less corrupt country will have a higher score in the index.</p>
<p>You can find the data here: <a href="https://www.transparency.org/en/cpi/2020/index/">https://www.transparency.org/en/cpi/2020/index/</a> (but don&rsquo;t use this for the game or you&rsquo;ll spoil it!)</p>
<p>Once you guess the answer is shown, along with the corruption perception index score for each country. If the card shows <span id="right_sign">green</span> you guessed right; <span id="wrong_sign">red</span> means you guessed wrong. Click either card to play again with two new countries.</p>
<p>Have a go and see if you can get a high score!</p>
-->

<p><button id="start" onclick="setup()" style="display: none">Start Game</button></p>


<div class="float-container noselect">

<div class="float-child col1" id = "grid_1" onclick="test(1); myClear()">
	<p id="c1" class="country_name"></p>
	<p id="e1" style="display:none;">PED: <span id="d1"></span></p>
	</div>
<div class="float-child col2" id = "grid_2" onclick="test(2); myClear()">
	<p id="c2" class="country_name"></p>
	<p id="e2" style="display:none;">PED: <span id="d2"></span></p>
	</div>
</div>
<p>Score: <span id ="score">0</span>/<span id="roundcount">0</span></p>

<p><button id="show_table" onclick ="show_table()">Click here to show PED values</button></p>

<table id="all_table" style="table-layout: auto; width: ; display: none;" >
<tr>
	
	<th>Product</th>
	<th>PED</th>
	
</tr>


</table>

<?php include "../footer.php"; ?>

<script>

/* 
Source material taken from: https://www.transparency.org/en/cpi/2020/index/nzl 
Used Mr Data Converter to put into array. https://shancarter.github.io/mr-data-converter/
*/

var index = [
  ["Salt",-0.1],
  ["Petrol (short run)",-0.2],
  ["Petrol (long run)",-0.7],
  ["Airline travel (short run)",-0.1],
  ["Tobacco products (short run)",-0.45],
  ["Legal services, short-run ",-0.4],
  ["Taxi, (short-run) ",-0.6],
  ["Cars (long-run) ",-0.2],
  ["Car tyres (short run)",-0.9],
  ["Private education",-1.1],
  ["Car tyres (long run)",-1.2],
  ["Restaurant meals ",-2.3],
  ["Foreign travel, long-run ",-4],
  ["Airline travel, long-run ",-2.4],
  ["Fresh green peas ",-2.8],
  ["Cars (short-run) ",-1.3],
  ["Chevrolet automobiles ",-4],
  ["Fresh tomatoes ",-4.6]
]

var diff = index.length;
var part = 20;

var num1;
var num2;

var score = 0;
var roundcount=0;

var grid_1 = document.getElementById("grid_1");
var grid_2 = document.getElementById("grid_2");


var key_1 = document.getElementById("e1");
var key_2 = document.getElementById("e2");

var colour_right = "#9fff8a";
var colour_wrong = "#ff8a8a";


function populate() {

	var table = document.getElementById("all_table");
	
	var i;
	for(i=0; i<index.length; i++) {
		var row = table.insertRow(i+1);
		//var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(0);
		var cell3 = row.insertCell(1);
		//cell1.innerHTML = index[i][4];
		cell2.innerHTML = index[i][0];
		cell3.innerHTML = index[i][1];
	}
	
	document.getElementById("right_sign").style.backgroundColor = colour_right;

	document.getElementById("wrong_sign").style.backgroundColor = colour_wrong;
	

}

function show_table() {
	
	var table = document.getElementById("all_table");
	if (table.style.display =="none") {
		table.style.display = "block";
		document.getElementById("show_table").innerHTML = "Click here to hide table";
		}
		
		else {
		table.style.display = "none";
		document.getElementById("show_table").innerHTML = "Click here to show PED values";
		
		}
	
	console.log(table.style.display);
	

}

function setup() {

num1= Math.floor(Math.random()*index.length);



	do {
		var a= Math.floor((Math.random()-0.5)*diff);
		num2 = num1 + a;
	}
	
	while ((num2 < 0)||(num2 > (index.length-1))||(num2==num1)||(Math.abs(index[num2][3]-index[num1][3])<part));

var count1= index[num1][0];
document.getElementById("c1").innerHTML = count1;
var cpi1= index[num1][1];
document.getElementById("d1").innerHTML = cpi1;
key_1.style.display = "none";
var count2= index[num2][0];
document.getElementById("c2").innerHTML = count2;
var cpi2= index[num2][1];
document.getElementById("d2").innerHTML = cpi2;
key_2.style.display = "none";


grid_2.style.backgroundColor="white";
grid_1.style.backgroundColor="white";

console.log(num1);
console.log(num2);



}




var clickcount = 0;

function test(i) {



if (i==2) {
	if (index[num2][1]<index[num1][1]) {
		grid_2.style.backgroundColor=colour_wrong;
		clickcount ++;
		}
	else {
		grid_2.style.backgroundColor=colour_right;
		clickcount ++;
		if (clickcount ==1) 
			{score++};
		}
	}

if (i==1) {
	if (index[num2][1]>index[num1][1]) {
		grid_1.style.backgroundColor=colour_wrong;
		clickcount ++;
		}
	else {
		grid_1.style.backgroundColor=colour_right;
		clickcount ++;
		if (clickcount ==1) 
			{score++};
		}
	}
	
if (clickcount ==1) 
		{roundcount++;
		key_1.style.display = "inline";
		key_2.style.display = "inline";
		}

console.clear();
console.log(clickcount);
document.getElementById("score").innerHTML=score;
document.getElementById("roundcount").innerHTML=roundcount;
console.log("score: "+score);




}


var count = 0;

function myClear() {


count = count+1;


if (count>1) {
	setup();

	count = 0;
	clickcount=0;

	
	
	}



}



</script>



</body>



</html>