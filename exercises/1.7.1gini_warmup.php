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


<h1>1.7.1 Inequality: Gini Coefficient Warm-Up</h1>

<h2>Instructions:</h2>
<p>The cards below will show two countries. Click which one you think has a more EQUAL distribution of income, measured by its Gini coefficient. When you click the answer will show. If the card shows <span id="right_sign">green</span> you guessed right; <span id="wrong_sign">red</span> means you guessed wrong. See if you can get a high score!</p>
<p>You can find the data here: <a href="https://data.worldbank.org/indicator/SI.POV.GINI" target="_blank">World Bank Databank: Gini Index</a></p>

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
	<p id="f1" class="country_name"></p>
	
	<p id="e1" style="display:none;">Gini Coefficient: <span id="d1"></span><span id="g1"></span></p>
	</div>
<div class="float-child col2" id = "grid_2" onclick="test(2); myClear()">
	<p id="c2" class="country_name"></p>
	<p id="f2" class="country_name"></p>

	<p id="e2" style="display:none;">Gini Coefficient: <span id="d2"></span><span id="g2"></span></p>
	</div>
</div>
<p>Score: <span id ="score">0</span>/<span id="roundcount">0</span></p>

<p><button id="show_table" onclick ="show_table()">Click here to show Gini Values</button></p>

<table id="all_table" style="table-layout: auto; width: ; display: none;" >
<tr>
	
	<th>Country</th>
	<th>Gini Coefficient</th>
	
</tr>


</table>

<?php include "../footer.php"; ?>

<script>

/* 
Index is from worldbank https://data.worldbank.org/indicator/SI.POV.GINI
However this gives data in a very awkward form: listed by year.

To find most recent use formulae:

Insert columns E and F.
Cell E6 = LOOKUP(2,1/(E6:BO6<>""),E6:BO6)
cell F6 =IF(E6=BO6,BO$5,IF(E6=BN6,BN$5,IF(E6=BM6,BM$5,IF(E6=BL6,BL$5,IF(E6=BK6,BK$5,IF(E6=BJ6,BJ$5,IF(E6=BI6,BI$5,IF(E6=BH6,BH$5,IF(E6=BG6,BG$5,IF(E6=BF6,BF$5,IF(E6=BE6,BE$5,IF(E6=BD6,BD$5))))))))))))
*/

var index = [
  ["Albania",33.2,2017],
  ["Algeria",27.6,2011],
  ["Angola",51.3,2018],
  ["Argentina",42.9,2019],
  ["Armenia",29.9,2019],
  ["Australia",34.4,2014],
  ["Austria",30.8,2018],
  ["Azerbaijan",26.6,2005],
  ["Bangladesh",32.4,2016],
  ["Belarus",25.3,2019],
  ["Belgium",27.2,2018],
  ["Belize",53.3,1999],
  ["Benin",47.8,2015],
  ["Bhutan",37.4,2017],
  ["Bolivia",41.6,2019],
  ["Bosnia and Herzegovina",33,2011],
  ["Botswana",53.3,2015],
  ["Brazil",53.4,2019],
  ["Bulgaria",41.3,2018],
  ["Burkina Faso",35.3,2014],
  ["Burundi",38.6,2013],
  ["Cabo Verde",42.4,2015],
  ["Cameroon",46.6,2014],
  ["Canada",33.3,2017],
  ["Central African Republic",56.2,2008],
  ["Chad",43.3,2011],
  ["Chile",44.4,2017],
  ["China",38.5,2016],
  ["Colombia",51.3,2019],
  ["Comoros",45.3,2014],
  ["Congo, Dem. Rep.",42.1,2012],
  ["Congo, Rep.",48.9,2011],
  ["Costa Rica",48.2,2019],
  ["Cote d'Ivoire",41.5,2015],
  ["Croatia",29.7,2018],
  ["Cyprus",32.7,2018],
  ["Czech Republic",25,2018],
  ["Denmark",28.2,2018],
  ["Djibouti",41.6,2017],
  ["Dominican Republic",41.9,2019],
  ["Ecuador",45.7,2019],
  ["Egypt, Arab Rep.",31.5,2017],
  ["El Salvador",38.8,2019],
  ["Estonia",30.3,2018],
  ["Eswatini",54.6,2016],
  ["Ethiopia",35,2015],
  ["Fiji",36.7,2013],
  ["Finland",27.3,2018],
  ["France",32.4,2018],
  ["Gabon",38,2017],
  ["Gambia, The",35.9,2015],
  ["Georgia",35.9,2019],
  ["Germany",31.9,2016],
  ["Ghana",43.5,2016],
  ["Greece",32.9,2018],
  ["Guatemala",48.3,2014],
  ["Guinea",33.7,2012],
  ["Guinea-Bissau",50.7,2010],
  ["Guyana",45.1,1998],
  ["Haiti",41.1,2012],
  ["Honduras",48.2,2019],
  ["Hungary",29.6,2018],
  ["Iceland",26.1,2017],
  ["India",35.7,2011],
  ["Indonesia",38.2,2019],
  ["Iran, Islamic Rep.",42,2018],
  ["Iraq",29.5,2012],
  ["Ireland",31.4,2017],
  ["Israel",39,2016],
  ["Italy",35.9,2017],
  ["Jamaica",45.5,2004],
  ["Japan",32.9,2013],
  ["Jordan",33.7,2010],
  ["Kazakhstan",27.8,2018],
  ["Kenya",40.8,2015],
  ["Kiribati",37,2006],
  ["Korea, Rep.",31.4,2016],
  ["Kosovo",29,2017],
  ["Kyrgyz Republic",29.7,2019],
  ["Lao PDR",38.8,2018],
  ["Latvia",35.1,2018],
  ["Lebanon",31.8,2011],
  ["Lesotho",44.9,2017],
  ["Liberia",35.3,2016],
  ["Lithuania",35.7,2018],
  ["Luxembourg",35.4,2018],
  ["Madagascar",42.6,2012],
  ["Malawi",44.7,2016],
  ["Malaysia",41.1,2015],
  ["Maldives",31.3,2016],
  ["Mali",33,2009],
  ["Malta",28.7,2018],
  ["Mauritania",32.6,2014],
  ["Mauritius",36.8,2017],
  ["Mexico",45.4,2018],
  ["Micronesia, Fed. Sts.",40.1,2013],
  ["Moldova",25.7,2018],
  ["Mongolia",32.7,2018],
  ["Montenegro",38.5,2016],
  ["Morocco",39.5,2013],
  ["Mozambique",54,2014],
  ["Myanmar",30.7,2017],
  ["Namibia",59.1,2015],
  ["Nauru",34.8,2012],
  ["Nepal",32.8,2010],
  ["Netherlands",28.1,2018],
  ["Nicaragua",46.2,2014],
  ["Niger",34.3,2014],
  ["Nigeria",35.1,2018],
  ["North Macedonia",33,2018],
  ["Norway",27.6,2018],
  ["Pakistan",31.6,2018],
  ["Panama",49.8,2019],
  ["Papua New Guinea",41.9,2009],
  ["Paraguay",45.7,2019],
  ["Peru",41.5,2019],
  ["Philippines",42.3,2018],
  ["Poland",30.2,2018],
  ["Portugal",33.5,2018],
  ["Romania",35.8,2018],
  ["Russian Federation",37.5,2018],
  ["Rwanda",43.7,2016],
  ["Samoa",38.7,2013],
  ["Sao Tome and Principe",56.3,2017],
  ["Senegal",40.3,2011],
  ["Serbia",36.2,2017],
  ["Seychelles",32.1,2018],
  ["Sierra Leone",35.7,2018],
  ["Slovak Republic",25,2018],
  ["Slovenia",24.6,2018],
  ["Solomon Islands",37.1,2012],
  ["Somalia",36.8,2017],
  ["South Africa",63,2014],
  ["South Sudan",44.1,2016],
  ["Spain",34.7,2018],
  ["Sri Lanka",39.3,2016],
  ["St. Lucia",51.2,2016],
  ["Sudan",34.2,2014],
  ["Suriname",57.9,1999],
  ["Sweden",30,2018],
  ["Switzerland",33.1,2018],
  ["Syrian Arab Republic",37.5,2003],
  ["Tajikistan",34,2015],
  ["Tanzania",40.5,2017],
  ["Thailand",34.9,2019],
  ["Timor-Leste",28.7,2014],
  ["Togo",43.1,2015],
  ["Tonga",37.6,2015],
  ["Trinidad and Tobago",40.3,1992],
  ["Tunisia",32.8,2015],
  ["Turkey",41.9,2019],
  ["Turkmenistan",40.8,1998],
  ["Tuvalu",39.1,2010],
  ["Uganda",42.8,2016],
  ["Ukraine",26.6,2019],
  ["United Arab Emirates",26,2018],
  ["United Kingdom",35.1,2017],
  ["United States",41.4,2018],
  ["Uruguay",39.7,2019],
  ["Uzbekistan",35.3,2003],
  ["Vanuatu",37.6,2010],
  ["Venezuela, RB",44.8,2006],
  ["Vietnam",35.7,2018],
  ["West Bank and Gaza",33.7,2016],
  ["Yemen, Rep.",36.7,2014],
  ["Zambia",57.1,2015],
  ["Zimbabwe",50.3,2019]
]

var index2 = 
[
  
 // [" Afghanistan",0,0,"Southern Asia","Asia"],
  [" Albania",33.2,2017,"Southern Europe","Europe"],
  [" Algeria",27.6,2011,"Northern Africa","Africa"],
  [" Angola",51.3,2018,"Middle Africa","Africa"],
  [" Argentina",41.4,2018,"South America","Americas"],
  [" Armenia",34.4,2018,"Western Asia","Asia"],
  [" Australia",34.4,2014,"Australia, New Zealand","Oceania"],
  [" Austria",29.7,2017,"Western Europe","Europe"],
  [" Azerbaijan",26.6,2005,"Western Asia","Asia"],
 // [" Bahrain",0,0,"Western Asia","Asia"],
  [" Bangladesh",32.4,2016,"Southern Asia","Asia"],
  [" Belarus",25.2,2018,"Eastern Europe","Europe"],
  [" Belgium",27.4,2017,"Western Europe","Europe"],
  [" Belize",53.3,1999,"Central America","Americas"],
  [" Benin",47.8,2015,"Western Africa","Africa"],
  [" Bhutan",37.4,2017,"Southern Asia","Asia"],
  [" Bolivia",42.2,2018,"South America","Americas"],
  [" Bosnia and Herzegovina",33,2011,"Southern Europe","Europe"],
  [" Botswana",53.3,2015,"Southern Africa","Africa"],
  [" Brazil",53.9,2018,"South America","Americas"],
  [" Bulgaria",40.4,2017,"Eastern Europe","Europe"],
  [" Burkina Faso",35.3,2014,"Western Africa","Africa"],
  [" Burundi",38.6,2013,"Eastern Africa","Africa"],
  //[" Cambodia",0,0,"South-eastern Asia","Asia"],
  [" Cameroon",46.6,2014,"Middle Africa","Africa"],
  [" Canada",33.8,2013,"Northern America","Americas"],
  [" Cape Verde",47.2,2007,"Western Africa","Africa"],
  [" Central African Republic",56.2,2008,"Middle Africa","Africa"],
  [" Chad",43.3,2011,"Middle Africa","Africa"],
  [" Chile",44.4,2017,"South America","Americas"],
  [" China",38.5,2016,"Eastern Asia","Asia"],
  [" Colombia",50.4,2018,"South America","Americas"],
  [" Comoros",45.3,2014,"Eastern Africa","Africa"],
  [" DR Congo",42.1,2012,"Middle Africa","Africa"],
  [" Congo",48.9,2011,"Middle Africa","Africa"],
  [" Costa Rica",48,2018,"Central America","Americas"],
  [" Ivory Coast",41.5,2015,"Western Africa","Africa"],
  [" Croatia",30.4,2017,"Southern Europe","Europe"],
 // [" Cuba",0,0,"Caribbean","Americas"],
  [" Cyprus",31.4,2017,"Western Asia","Asia"],
  [" Czech Republic",24.9,2017,"Eastern Europe","Europe"],
  [" Denmark",28.7,2017,"Northern Europe","Europe"],
  [" Djibouti",44.6,2017,"Eastern Africa","Africa"],
  [" Dominican Republic",43.7,2018,"Caribbean","Americas"],
  [" Ecuador",45.4,2018,"South America","Americas"],
  [" Egypt",31.5,2017,"Northern Africa","Africa"],
  [" El Salvador",38.6,2018,"Central America","Americas"],
  //[" Equatorial Guinea",0,0,"Middle Africa","Africa"],
  [" Estonia",30.4,2017,"Northern Europe","Europe"],
  [" Eswatini",54.6,2016,"Southern Africa","Africa"],
  [" Ethiopia",35,2015,"Eastern Africa","Africa"],
  //[" EU",0,0,"Europe",""],
  [" Fiji",36.7,2013,"Melanesia","Oceania"],
  [" Finland",27.4,2017,"Northern Europe","Europe"],
  [" France",31.6,2017,"Western Europe","Europe"],
  [" Gabon",38,2017,"Middle Africa","Africa"],
  [" Gambia",35.9,2015,"Western Africa","Africa"],
  [" Georgia",36.4,2018,"Western Asia","Asia"],
  [" Germany",31.9,2016,"Western Europe","Europe"],
  [" Ghana",43.5,2016,"Western Africa","Africa"],
  [" Greece",34.4,2017,"Southern Europe","Europe"],
  [" Guatemala",48.3,2014,"Central America","Americas"],
  [" Guinea",33.7,2012,"Western Africa","Africa"],
  [" Guinea-Bissau",50.7,2010,"Western Africa","Africa"],
  [" Guyana",44.6,1998,"South America","Americas"],
  [" Haiti",41.1,2012,"Caribbean","Americas"],
  [" Honduras",52.1,2018,"Central America","Americas"],
  //[" Hong Kong",0,0,"Eastern Asia","Asia"],
  [" Hungary",30.6,2017,"Eastern Europe","Europe"],
  [" Iceland",26.8,2015,"Northern Europe","Europe"],
  [" India",37.8,2011,"Southern Asia","Asia"],
  [" Indonesia",39,2018,"South-eastern Asia","Asia"],
  [" Iran",40.8,2017,"Southern Asia","Asia"],
  [" Iraq",29.5,2012,"Western Asia","Asia"],
  [" Ireland",32.8,2016,"Northern Europe","Europe"],
  [" Israel",39,2016,"Western Asia","Asia"],
  [" Italy",35.9,2017,"Southern Europe","Europe"],
  [" Jamaica",45.5,2004,"Caribbean","Americas"],
  [" Japan",32.9,2013,"Eastern Asia","Asia"],
  [" Jordan",33.7,2010,"Western Asia","Asia"],
  [" Kazakhstan",27.5,2017,"Central Asia","Asia"],
  [" Kenya",40.8,2015,"Eastern Africa","Africa"],
  //[" North Korea",0,0,"Eastern Asia","Asia"],
  [" South Korea",31.6,2012,"Eastern Asia","Asia"],
  [" Kosovo",29,2017,"Eastern Europe","Europe[a]"],
  //[" Kuwait",0,0,"Western Asia","Asia"],
  [" Kyrgyzstan",27.7,2018,"Central Asia","Asia"],
  [" Laos",36.4,2012,"South-eastern Asia","Asia"],
  [" Latvia",35.6,2017,"Northern Europe","Europe"],
  [" Lebanon",31.8,2011,"Western Asia","Asia"],
  [" Lesotho",44.9,2017,"Southern Africa","Africa"],
  [" Liberia",35.3,2016,"Western Africa","Africa"],
  //[" Libya",0,0,"Northern Africa","Africa"],
  [" Lithuania",37.3,2017,"Northern Europe","Europe"],
  [" Luxembourg",34.9,2017,"Western Europe","Europe"],
  //[" Macau",0,0,"Eastern Asia","Asia"],
  [" North Macedonia",34.2,2017,"Southern Europe","Europe"],
  [" Madagascar",42.6,2012,"Eastern Africa","Africa"],
  [" Malawi",44.7,2016,"Eastern Africa","Africa"],
  [" Malaysia",41,2015,"South-eastern Asia","Asia"],
  [" Maldives",31.3,2016,"Southern Asia","Asia"],
  [" Mali",33,2009,"Western Africa","Africa"],
  [" Malta",29.2,2017,"Southern Europe","Europe"],
  [" Mauritania",32.6,2014,"Western Africa","Africa"],
  [" Mauritius",36.8,2017,"Eastern Africa","Africa"],
  [" Mexico",45.4,2018,"Central America","Americas"],
  [" Micronesia",40.1,2013,"Micronesia","Oceania"],
  [" Moldova",25.7,2018,"Eastern Europe","Europe"],
  [" Mongolia",32.7,2018,"Eastern Asia","Asia"],
  [" Montenegro",39,2015,"Southern Europe","Europe"],
  [" Morocco",39.5,2013,"Northern Africa","Africa"],
  [" Mozambique",54,2014,"Eastern Africa","Africa"],
  [" Myanmar",30.7,2017,"South-eastern Asia","Asia"],
  [" Namibia",59.1,2015,"Southern Africa","Africa"],
  [" Nepal",32.8,2010,"Southern Asia","Asia"],
  [" Netherlands",28.5,2017,"Western Europe","Europe"],
  //[" New Zealand",0,0,"Australia, New Zealand","Oceania"],
  [" Nicaragua",46.2,2014,"Central America","Americas"],
  [" Niger",34.3,2014,"Western Africa","Africa"],
  [" Nigeria",35.1,2020,"Western Africa","Africa"],
  [" Norway",27,2017,"Northern Europe","Europe"],
  //[" Oman",0,0,"Western Asia","Asia"],
  [" Pakistan",33.5,2015,"Southern Asia","Asia"],
  [" Panama",49.2,2018,"Central America","Americas"],
  [" Papua New Guinea",41.9,2009,"Melanesia","Oceania"],
  [" Paraguay",46.2,2018,"South America","Americas"],
  [" Peru",42.8,2018,"South America","Americas"],
  [" Philippines",44.4,2015,"South-eastern Asia","Asia"],
  [" Poland",29.7,2017,"Eastern Europe","Europe"],
  [" Portugal",33.8,2017,"Southern Europe","Europe"],
  //[" Qatar",0,0,"Western Asia","Asia"],
  [" Romania",36,2017,"Eastern Europe","Europe"],
  [" Russia",37.5,2018,"Eastern Europe","Europe"],
  [" Rwanda",43.7,2016,"Eastern Africa","Africa"],
  [" São Tomé and Príncipe",56.3,2017,"Middle Africa","Africa"],
 // [" Saudi Arabia",0,0,"Western Asia","Asia"],
  //[" Senegal",40.3,2011,"Western Africa","Africa"],
  [" Serbia",36.2,2017,"Southern Europe","Europe"],
  [" Seychelles",46.8,2013,"Eastern Africa","Africa"],
  [" Sierra Leone",35.7,2018,"Western Africa","Africa"],
  //[" Singapore",0,0,"South-eastern Asia","Asia"],
  [" Slovakia",25.2,2016,"Eastern Europe","Europe"],
  [" Slovenia",24.2,2017,"Southern Europe","Europe"],
  //[" Somalia",0,0,"Eastern Africa","Africa"],
  [" South Africa",63,2014,"Southern Africa","Africa"],
  [" South Sudan",46.3,2009,"Eastern Africa","Africa"],
  [" Spain",34.7,2017,"Southern Europe","Europe"],
  [" Sri Lanka",39.8,2016,"Southern Asia","Asia"],
  [" Saint Lucia",51.2,2016,"Caribbean","Americas"],
  [" Sudan",35.4,2009,"Northern Africa","Africa"],
  [" Suriname",57.6,1999,"South America","Americas"],
  [" Sweden",28.8,2017,"Northern Europe","Europe"],
  [" Switzerland",32.7,2017,"Western Europe","Europe"],
  [" Syria",35.8,2004,"Western Asia","Asia"],
  //[" Taiwan",0,0,"Eastern Asia","Asia"],
  [" Tajikistan",34,2015,"Central Asia","Asia"],
  [" Tanzania",40.5,2017,"Eastern Africa","Africa"],
  [" Thailand",36.4,2018,"South-eastern Asia","Asia"],
  [" East Timor",28.7,2014,"South-eastern Asia","Asia"],
  [" Togo",43.1,2015,"Western Africa","Africa"],
  [" Trinidad and Tobago",40.3,1992,"Caribbean","Americas"],
  [" Tunisia",32.8,2015,"Northern Africa","Africa"],
  [" Turkey",41.9,2018,"Western Asia","Asia"],
  [" Turkmenistan",40.8,1999,"Central Asia","Asia"],
  [" Uganda",42.8,2016,"Eastern Africa","Africa"],
  [" Ukraine",26.1,2018,"Eastern Europe","Europe"],
  [" United Arab Emirates",32.5,2014,"Western Asia","Asia"],
  [" United Kingdom",34.8,2016,"Northern Europe","Europe"],
  [" United States",41.4,2016,"Northern America","Americas"],
  [" Uruguay",39.7,2018,"South America","Americas"],
  [" Uzbekistan",35.3,2003,"Central Asia","Asia"],
  [" Venezuela",46.9,2006,"South America","Americas"],
  [" Vietnam",35.7,2018,"South-eastern Asia","Asia"],
  [" Palestine",33.7,2016,"Western Asia","Asia"],
  [" Yemen",36.7,2014,"Western Asia","Asia"],
  [" Zambia",57.1,2015,"Eastern Africa","Africa"],
  [" Zimbabwe",44.3,2017,"Eastern Africa","Africa"]

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
		cell3.innerHTML = index[i][1]+" ("+index[i][2]+")";
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
		document.getElementById("show_table").innerHTML = "Click here to show Gini values";
		
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


//New for Inequality:

//document.getElementById("f1").innerHTML = "Region: "+index[num1][3];
//document.getElementById("f2").innerHTML = "Region: "+index[num2][3];
document.getElementById("g1").innerHTML = " ("+index[num1][2]+")";
document.getElementById("g2").innerHTML = " ("+index[num2][2]+")";

grid_2.style.backgroundColor="white";
grid_1.style.backgroundColor="white";

console.log(num1);
console.log(num2);



}




var clickcount = 0;

function test(i) {



if (i==2) {
	if (index[num2][1]>index[num1][1]) {
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
	if (index[num2][1]<index[num1][1]) {
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