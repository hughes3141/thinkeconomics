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

th {
	padding: 5px;}
	
table {
border-collapse: collapse;
}

</style>


</head>


<body onload="populate(), setup()">

<?php include "../navbar.php"; ?>


<h1>3.3.2 Corruption Perceptions Index Game</h1>

<h2>Instructions:</h2>
<p style="display: none;">Click &ldquo;Start Game&rdquo; to begin.</p>
<p>The two cards below will show the names of two countries.</p>
<p>Guess which one is the <em>less corrupt</em>. This is measured by Transparency International&rsquo;s Corruption Perception Index. A less corrupt country will have a higher score in the index.</p>
<p>You can find the data here: <a href="https://www.transparency.org/en/cpi/2020/index/">https://www.transparency.org/en/cpi/2020/index/</a> (but don&rsquo;t use this for the game or you&rsquo;ll spoil it!)</p>
<p>Once you guess the answer is shown, along with the corruption perception index score for each country. If the card shows <span id="right_sign">green</span> you guessed right; <span id="wrong_sign">red</span> means you guessed wrong. Click either card to play again with two new countries.</p>
<p>Have a go and see if you can get a high score!</p>

<p><button id="start" onclick="setup()" style="display: none">Start Game</button></p>


<div class="float-container noselect">

<div class="float-child col1" id = "grid_1" onclick="test(1); myClear()">
	<p id="c1" class="country_name"></p>
	<p id="e1" style="display:none;">Corruption Perception Index: <span id="d1"></span>/100</p>
	</div>
<div class="float-child col2" id = "grid_2" onclick="test(2); myClear()">
	<p id="c2" class="country_name"></p>
	<p id="e2" style="display:none;">Corruption Perception Index: <span id="d2"></span>/100</p>
	</div>
</div>
<p>Score: <span id ="score">0</span>/<span id="roundcount">0</span></p>

<p><button id="show_table" onclick ="show_table()">Click here to show the values of all countries</button></p>

<table id="all_table" style="table-layout: auto; width: ; display: none;" >
<tr>
	<th>Rank</th>
	<th>Country</th>
	<th>Corruption Perception Index <br>/100</th>
	
</tr>


</table>

<?php include "../footer.php"; ?>

<script>

/* 
Source material taken from: https://www.transparency.org/en/cpi/2020/index/nzl 
Used Mr Data Converter to put into array. https://shancarter.github.io/mr-data-converter/
*/

var index = [
  ["New Zealand","NZL","AP",88,1],
  ["Finland","FIN","WE/EU",85,3],
  ["Singapore","SGP","AP",85,3],
  ["Sweden","SWE","WE/EU",85,3],
  ["Switzerland","CHE","WE/EU",85,3],
  ["Norway","NOR","WE/EU",84,7],
  ["Netherlands","NLD","WE/EU",82,8],
  ["Germany","DEU","WE/EU",80,9],
  ["Luxembourg","LUX","WE/EU",80,9],
  ["Australia","AUS","AP",77,11],
  ["Canada","CAN","AME",77,11],
  ["Hong Kong","HKG","AP",77,11],
  ["United Kingdom","GBR","WE/EU",77,11],
  ["Austria","AUT","WE/EU",76,15],
  ["Belgium","BEL","WE/EU",76,15],
  ["Estonia","EST","WE/EU",75,17],
  ["Iceland","ISL","WE/EU",75,17],
  ["Japan","JPN","AP",74,19],
  ["Ireland","IRL","WE/EU",72,20],
  ["United Arab Emirates","ARE","MENA",71,21],
  ["Uruguay","URY","AME",71,21],
  ["France","FRA","WE/EU",69,23],
  ["Bhutan","BTN","AP",68,24],
  ["Chile","CHL","AME",67,25],
  ["United States of America","USA","AME",67,25],
  ["Seychelles","SYC","SSA",66,27],
  ["Taiwan","TWN","AP",65,28],
  ["Barbados","BRB","AME",64,29],
  ["Bahamas","BHS","AME",63,30],
  ["Qatar","QAT","MENA",63,30],
  ["Spain","ESP","WE/EU",62,32],
  ["Korea, South","KOR","AP",61,33],
  ["Portugal","PRT","WE/EU",61,33],
  ["Botswana","BWA","SSA",60,35],
  ["Brunei Darussalam","BRN","AP",60,35],
  ["Israel","ISR","MENA",60,35],
  ["Lithuania","LTU","WE/EU",60,35],
  ["Slovenia","SVN","WE/EU",60,35],
  ["Saint Vincent and the Grenadines","VCT","AME",59,40],
  ["Cabo Verde","CPV","SSA",58,41],
  ["Costa Rica","CRI","AME",57,42],
  ["Cyprus","CYP","WE/EU",57,42],
  ["Latvia","LVA","WE/EU",57,42],
  ["Georgia","GEO","ECA",56,45],
  ["Poland","POL","WE/EU",56,45],
  ["Saint Lucia","LCA","AME",56,45],
  ["Dominica","DMA","AME",55,48],
  ["Czechia","CZE","WE/EU",54,49],
  ["Oman","OMN","MENA",54,49],
  ["Rwanda","RWA","SSA",54,49],
  ["Grenada","GRD","AME",53,52],
  ["Italy","ITA","WE/EU",53,52],
  ["Malta","MLT","WE/EU",53,52],
  ["Mauritius","MUS","SSA",53,52],
  ["Saudi Arabia","SAU","MENA",53,52],
  ["Malaysia","MYS","AP",51,57],
  ["Namibia","NAM","SSA",51,57],
  ["Greece","GRC","WE/EU",50,59],
  ["Armenia","ARM","ECA",49,60],
  ["Jordan","JOR","MENA",49,60],
  ["Slovakia","SVK","WE/EU",49,60],
  ["Belarus","BLR","ECA",47,63],
  ["Croatia","HRV","WE/EU",47,63],
  ["Cuba","CUB","AME",47,63],
  ["Sao Tome and Principe","STP","SSA",47,63],
  ["Montenegro","MNE","ECA",45,67],
  ["Senegal","SEN","SSA",45,67],
  ["Bulgaria","BGR","WE/EU",44,69],
  ["Hungary","HUN","WE/EU",44,69],
  ["Jamaica","JAM","AME",44,69],
  ["Romania","ROU","WE/EU",44,69],
  ["South Africa","ZAF","SSA",44,69],
  ["Tunisia","TUN","MENA",44,69],
  ["Ghana","GHA","SSA",43,75],
  ["Maldives","MDV","AP",43,75],
  ["Vanuatu","VUT","AP",43,75],
  ["Argentina","ARG","AME",42,78],
  ["Bahrain","BHR","MENA",42,78],
  ["China","CHN","AP",42,78],
  ["Kuwait","KWT","MENA",42,78],
  ["Solomon Islands","SLB","AP",42,78],
  ["Benin","BEN","SSA",41,83],
  ["Guyana","GUY","AME",41,83],
  ["Lesotho","LSO","SSA",41,83],
  ["Burkina Faso","BFA","SSA",40,86],
  ["India","IND","AP",40,86],
  ["Morocco","MAR","MENA",40,86],
  ["Timor-Leste","TLS","AP",40,86],
  ["Trinidad and Tobago","TTO","AME",40,86],
  ["Turkey","TUR","ECA",40,86],
  ["Colombia","COL","AME",39,92],
  ["Ecuador","ECU","AME",39,92],
  ["Brazil","BRA","AME",38,94],
  ["Ethiopia","ETH","SSA",38,94],
  ["Kazakhstan","KAZ","ECA",38,94],
  ["Peru","PER","AME",38,94],
  ["Serbia","SRB","ECA",38,94],
  ["Sri Lanka","LKA","AP",38,94],
  ["Suriname","SUR","AME",38,94],
  ["Tanzania","TZA","SSA",38,94],
  ["Gambia","GMB","SSA",37,102],
  ["Indonesia","IDN","AP",37,102],
  ["Albania","ALB","ECA",36,104],
  ["Algeria","DZA","MENA",36,104],
  ["Cote d'Ivoire","CIV","SSA",36,104],
  ["El Salvador","SLV","AME",36,104],
  ["Kosovo","KSV","ECA",36,104],
  ["Thailand","THA","AP",36,104],
  ["Vietnam","VNM","AP",36,104],
  ["Bosnia and Herzegovina","BIH","ECA",35,111],
  ["Mongolia","MNG","AP",35,111],
  ["North Macedonia","MKD","ECA",35,111],
  ["Panama","PAN","AME",35,111],
  ["Moldova","MDA","ECA",34,115],
  ["Philippines","PHL","AP",34,115],
  ["Egypt","EGY","MENA",33,117],
  ["Eswatini","SWZ","SSA",33,117],
  ["Nepal","NPL","AP",33,117],
  ["Sierra Leone","SLE","SSA",33,117],
  ["Ukraine","UKR","ECA",33,117],
  ["Zambia","ZMB","SSA",33,117],
  ["Niger","NER","SSA",32,123],
  ["Bolivia","BOL","AME",31,124],
  ["Kenya","KEN","SSA",31,124],
  ["Kyrgyzstan","KGZ","ECA",31,124],
  ["Mexico","MEX","AME",31,124],
  ["Pakistan","PAK","AP",31,124],
  ["Azerbaijan","AZE","ECA",30,129],
  ["Gabon","GAB","SSA",30,129],
  ["Malawi","MWI","SSA",30,129],
  ["Mali","MLI","SSA",30,129],
  ["Russia","RUS","ECA",30,129],
  ["Laos","LAO","AP",29,134],
  ["Mauritania","MRT","SSA",29,134],
  ["Togo","TGO","SSA",29,134],
  ["Dominican Republic","DOM","AME",28,137],
  ["Guinea","GIN","SSA",28,137],
  ["Liberia","LBR","SSA",28,137],
  ["Myanmar","MMR","AP",28,137],
  ["Paraguay","PRY","AME",28,137],
  ["Angola","AGO","SSA",27,142],
  ["Djibouti","DJI","SSA",27,142],
  ["Papua New Guinea","PNG","AP",27,142],
  ["Uganda","UGA","SSA",27,142],
  ["Bangladesh","BGD","AP",26,146],
  ["Central African Republic","CAF","SSA",26,146],
  ["Uzbekistan","UZB","ECA",26,146],
  ["Cameroon","CMR","SSA",25,149],
  ["Guatemala","GTM","AME",25,149],
  ["Iran","IRN","MENA",25,149],
  ["Lebanon","LBN","MENA",25,149],
  ["Madagascar","MDG","SSA",25,149],
  ["Mozambique","MOZ","SSA",25,149],
  ["Nigeria","NGA","SSA",25,149],
  ["Tajikistan","TJK","ECA",25,149],
  ["Honduras","HND","AME",24,157],
  ["Zimbabwe","ZWE","SSA",24,157],
  ["Nicaragua","NIC","AME",22,159],
  ["Cambodia","KHM","AP",21,160],
  ["Chad","TCD","SSA",21,160],
  ["Comoros","COM","SSA",21,160],
  ["Eritrea","ERI","SSA",21,160],
  ["Iraq","IRQ","MENA",21,160],
  ["Afghanistan","AFG","AP",19,165],
  ["Burundi","BDI","SSA",19,165],
  ["Congo","COG","SSA",19,165],
  ["Guinea Bissau","GNB","SSA",19,165],
  ["Turkmenistan","TKM","ECA",19,165],
  ["Democratic Republic of the Congo","COD","SSA",18,170],
  ["Haiti","HTI","AME",18,170],
  ["Korea, North","PRK","AP",18,170],
  ["Libya","LBY","MENA",17,173],
  ["Equatorial Guinea","GNQ","SSA",16,174],
  ["Sudan","SDN","SSA",16,174],
  ["Venezuela","VEN","AME",15,176],
  ["Yemen","YEM","MENA",15,176],
  ["Syria","SYR","MENA",14,178],
  ["Somalia","SOM","SSA",12,179],
  ["South Sudan","SSD","SSA",12,179]
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
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		cell1.innerHTML = index[i][4];
		cell2.innerHTML = index[i][0];
		cell3.innerHTML = index[i][3];
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
		document.getElementById("show_table").innerHTML = "Click here to show the values of all countries";
		
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
var cpi1= index[num1][3];
document.getElementById("d1").innerHTML = cpi1;
key_1.style.display = "none";
var count2= index[num2][0];
document.getElementById("c2").innerHTML = count2;
var cpi2= index[num2][3];
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
	if (index[num2][3]<index[num1][3]) {
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
	if (index[num2][3]>index[num1][3]) {
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