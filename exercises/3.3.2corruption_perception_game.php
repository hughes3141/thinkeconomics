<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  /*
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /index.php");
  }
  */

}

$style_input = "
/*


.container {
	border: 3px solid black;
	position: relative;
    padding: 0px;
	overflow: auto;
	height: 200px;
	width: 90%;
	

}

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
*/

.float-container {
    border: 3px solid black;
    padding: 0px;
	overflow: auto;
	height: 350px;
	//width: 99%;
	margin-left: auto;
  margin-right: auto;
  display: flex;
  flex-wrap: nowrap;
  justify-content: space-between;
  align-items: stretch;
	
	

}

.float-child {
	
    //float: left;
    //padding: 0px;
    border: 2px solid red;
	//width:42%;
	margin: 10px;
	//height: 93%;
	text-align: center;
	overflow: hidden;
  flex-grow: 1;
  width: 30%;
  
	
	
	
	}

  .float-child h1{
    background: inherit;
  }
	
.col_1 {
	float: left;
	width: 48%;
	}

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
	text-align: center;
	}

th {
	padding: 5px;}
	
table {
border-collapse: collapse;
}

p {
  margin-bottom: 1em;
}

  
  ";

if($_SERVER['REQUEST_METHOD']==='POST') {


}




include($path."/header_tailwind.php");





?>



<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Corruption Perceptions Index Game</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
      
      <p>The two cards below will show the names of two countries.</p>
      <p>Guess which one is the <em>less corrupt</em>. This is measured by Transparency International&rsquo;s Corruption Perception Index. A less corrupt country will have a higher score in the index.</p>
      <p>You can find the data here: <a class="underline text-sky-700" target ="_blank" href="https://www.transparency.org/en/cpi/">Corruptions Perception Index (Transparency International)</a> (but don&rsquo;t use this for the game or you&rsquo;ll spoil it!)</p>
      <p>Once you guess the answer is shown, along with the corruption perception index score for each country. If the card shows <span id="right_sign" class="px-2 rounded">green</span> you guessed right; <span id="wrong_sign" class="px-2 rounded">red</span> means you guessed wrong. Click either card to play again with two new countries.</p>
      <p>Have a go and see if you can get a high score!</p>

      


      <p class="mb-1 hidden">Difficulty Level: 
      <select name="difficulty" id="difficulty" onchange = "difficulty()">
        <option value="Ridiculous">Ridiculous</option>
        <option value="Hard">Hard</option>
        <option value="Medium" selected="selected">Medium</option>
        <option value="Easy">Easy</option>

      </select></p>

      <p><button id="start" onclick="setup()" style="display: none">Start Game</button></p>


      <div class="float-container noselect rounded  lg:text-base">

        <div class="float-child col1 rounded p-1" id="grid_1" onclick="test(1); myClear()" style="background-color: white;">
          <p id="c1" class="country_name text-xl"></p>
          <p id="e1" style="display:none;">Corruption Perception Index: <span id="d1"></span>/100</p>
        </div>
        <div class="float-child col2 rounded p-1" id="grid_2" onclick="test(2); myClear()" style="background-color: white;">
          <p id="c2" class="country_name text-xl"></p>
          <p id="e2" style="display:none;">Corruption Perception Index: <span id="d2"></span>/100</p>
        </div>
      </div>
      <p>Score: <span id="score">0</span>/<span id="roundcount">0</span></p>

      <p><button class="border border-black rounded bg-pink-200 w-full mb-2" id="show_table" onclick="show_table()">Click here to show the values of all countries</button></p>

      <table id="all_table" style="display:none" class=" text-sm lg:text-base table-auto w-full lg:w-1/2 mx-auto  ">
      <tbody><tr class="sticky top-12 lg:top-20 bg-white ">
        <th class="">Rank</th>
        <th class="">Country</th>
        <th class="">Corruption Perception Index</th>

        
      </tr>
      </tbody>
      </table>

  </div>
</div>



<script>

 

/* 
10 February 2024:

Data from Transparency international: 

https://www.transparency.org/en/cpi/2023

Go to 'CPI 2023 Global Results Trends"

This downloads xls file: https://images.transparencycdn.org/images/CPI2023_Global_Results__Trends.xlsx

Then take first 5 columns of the table and convert to JSON row arrays.

Used Mr Data Converter to put into array. https://shancarter.github.io/mr-data-converter/
*/

var index = [
  ["Denmark","DNK","WE/EU",90,1],
  ["Finland","FIN","WE/EU",87,2],
  ["New Zealand","NZL","AP",85,3],
  ["Norway","NOR","WE/EU",84,4],
  ["Singapore","SGP","AP",83,5],
  ["Sweden","SWE","WE/EU",82,6],
  ["Switzerland","CHE","WE/EU",82,6],
  ["Netherlands","NLD","WE/EU",79,8],
  ["Germany","DEU","WE/EU",78,9],
  ["Luxembourg","LUX","WE/EU",78,9],
  ["Ireland","IRL","WE/EU",77,11],
  ["Canada","CAN","AME",76,12],
  ["Estonia","EST","WE/EU",76,12],
  ["Australia","AUS","AP",75,14],
  ["Hong Kong","HKG","AP",75,14],
  ["Belgium","BEL","WE/EU",73,16],
  ["Japan","JPN","AP",73,16],
  ["Uruguay","URY","AME",73,16],
  ["Iceland","ISL","WE/EU",72,19],
  ["Austria","AUT","WE/EU",71,20],
  ["France","FRA","WE/EU",71,20],
  ["Seychelles","SYC","SSA",71,20],
  ["United Kingdom","GBR","WE/EU",71,20],
  ["Barbados","BRB","AME",69,24],
  ["United States","USA","AME",69,24],
  ["Bhutan","BTN","AP",68,26],
  ["United Arab Emirates","ARE","MENA",68,26],
  ["Taiwan","TWN","AP",67,28],
  ["Chile","CHL","AME",66,29],
  ["Bahamas","BHS","AME",64,30],
  ["Cabo Verde","CPV","SSA",64,30],
  ["Korea, South","KOR","AP",63,32],
  ["Israel","ISR","MENA",62,33],
  ["Lithuania","LTU","WE/EU",61,34],
  ["Portugal","PRT","WE/EU",61,34],
  ["Latvia","LVA","WE/EU",60,36],
  ["Saint Vincent and the Grenadines","VCT","AME",60,36],
  ["Spain","ESP","WE/EU",60,36],
  ["Botswana","BWA","SSA",59,39],
  ["Qatar","QAT","MENA",58,40],
  ["Czechia","CZE","WE/EU",57,41],
  ["Dominica","DMA","AME",56,42],
  ["Italy","ITA","WE/EU",56,42],
  ["Slovenia","SVN","WE/EU",56,42],
  ["Costa Rica","CRI","AME",55,45],
  ["Saint Lucia","LCA","AME",55,45],
  ["Poland","POL","WE/EU",54,47],
  ["Slovakia","SVK","WE/EU",54,47],
  ["Cyprus","CYP","WE/EU",53,49],
  ["Georgia","GEO","ECA",53,49],
  ["Grenada","GRD","AME",53,49],
  ["Rwanda","RWA","SSA",53,49],
  ["Fiji","FJI","AP",52,53],
  ["Saudi Arabia","SAU","MENA",52,53],
  ["Malta","MLT","WE/EU",51,55],
  ["Mauritius","MUS","SSA",51,55],
  ["Croatia","HRV","WE/EU",50,57],
  ["Malaysia","MYS","AP",50,57],
  ["Greece","GRC","WE/EU",49,59],
  ["Namibia","NAM","SSA",49,59],
  ["Vanuatu","VUT","AP",48,61],
  ["Armenia","ARM","ECA",47,62],
  ["Jordan","JOR","MENA",46,63],
  ["Kuwait","KWT","MENA",46,63],
  ["Montenegro","MNE","ECA",46,63],
  ["Romania","ROU","WE/EU",46,63],
  ["Bulgaria","BGR","WE/EU",45,67],
  ["Sao Tome and Principe","STP","SSA",45,67],
  ["Jamaica","JAM","AME",44,69],
  ["Benin","BEN","SSA",43,70],
  ["Ghana","GHA","SSA",43,70],
  ["Oman","OMN","MENA",43,70],
  ["Senegal","SEN","SSA",43,70],
  ["Solomon Islands","SLB","AP",43,70],
  ["Timor-Leste","TLS","AP",43,70],
  ["Bahrain","BHR","MENA",42,76],
  ["China","CHN","AP",42,76],
  ["Cuba","CUB","AME",42,76],
  ["Hungary","HUN","WE/EU",42,76],
  ["Moldova","MDA","ECA",42,76],
  ["North Macedonia","MKD","ECA",42,76],
  ["Trinidad and Tobago","TTO","AME",42,76],
  ["Burkina Faso","BFA","SSA",41,83],
  ["Kosovo","KSV","ECA",41,83],
  ["South Africa","ZAF","SSA",41,83],
  ["Vietnam","VNM","AP",41,83],
  ["Colombia","COL","AME",40,87],
  ["Côte d'Ivoire","CIV","SSA",40,87],
  ["Guyana","GUY","AME",40,87],
  ["Suriname","SUR","AME",40,87],
  ["Tanzania","TZA","SSA",40,87],
  ["Tunisia","TUN","MENA",40,87],
  ["India","IND","AP",39,93],
  ["Kazakhstan","KAZ","ECA",39,93],
  ["Lesotho","LSO","SSA",39,93],
  ["Maldives","MDV","AP",39,93],
  ["Morocco","MAR","MENA",38,97],
  ["Albania","ALB","ECA",37,98],
  ["Argentina","ARG","AME",37,98],
  ["Belarus","BLR","ECA",37,98],
  ["Ethiopia","ETH","SSA",37,98],
  ["Gambia","GMB","SSA",37,98],
  ["Zambia","ZMB","SSA",37,98],
  ["Algeria","DZA","MENA",36,104],
  ["Brazil","BRA","AME",36,104],
  ["Serbia","SRB","ECA",36,104],
  ["Ukraine","UKR","ECA",36,104],
  ["Bosnia and Herzegovina","BIH","ECA",35,108],
  ["Dominican Republic","DOM","AME",35,108],
  ["Egypt","EGY","MENA",35,108],
  ["Nepal","NPL","AP",35,108],
  ["Panama","PAN","AME",35,108],
  ["Sierra Leone","SLE","SSA",35,108],
  ["Thailand","THA","AP",35,108],
  ["Ecuador","ECU","AME",34,115],
  ["Indonesia","IDN","AP",34,115],
  ["Malawi","MWI","SSA",34,115],
  ["Philippines","PHL","AP",34,115],
  ["Sri Lanka","LKA","AP",34,115],
  ["Turkey","TUR","ECA",34,115],
  ["Angola","AGO","SSA",33,121],
  ["Mongolia","MNG","AP",33,121],
  ["Peru","PER","AME",33,121],
  ["Uzbekistan","UZB","ECA",33,121],
  ["Niger","NER","SSA",32,125],
  ["El Salvador","SLV","AME",31,126],
  ["Kenya","KEN","SSA",31,126],
  ["Mexico","MEX","AME",31,126],
  ["Togo","TGO","SSA",31,126],
  ["Djibouti","DJI","SSA",30,130],
  ["Eswatini","SWZ","SSA",30,130],
  ["Mauritania","MRT","SSA",30,130],
  ["Bolivia","BOL","AME",29,133],
  ["Pakistan","PAK","AP",29,133],
  ["Papua New Guinea","PNG","AP",29,133],
  ["Gabon","GAB","SSA",28,136],
  ["Laos","LAO","AP",28,136],
  ["Mali","MLI","SSA",28,136],
  ["Paraguay","PRY","AME",28,136],
  ["Cameroon","CMR","SSA",27,140],
  ["Guinea","GIN","SSA",26,141],
  ["Kyrgyzstan","KGZ","ECA",26,141],
  ["Russia","RUS","ECA",26,141],
  ["Uganda","UGA","SSA",26,141],
  ["Liberia","LBR","SSA",25,145],
  ["Madagascar","MDG","SSA",25,145],
  ["Mozambique","MOZ","SSA",25,145],
  ["Nigeria","NGA","SSA",25,145],
  ["Bangladesh","BGD","AP",24,149],
  ["Central African Republic","CAF","SSA",24,149],
  ["Iran","IRN","MENA",24,149],
  ["Lebanon","LBN","MENA",24,149],
  ["Zimbabwe","ZWE","SSA",24,149],
  ["Azerbaijan","AZE","ECA",23,154],
  ["Guatemala","GTM","AME",23,154],
  ["Honduras","HND","AME",23,154],
  ["Iraq","IRQ","MENA",23,154],
  ["Cambodia","KHM","AP",22,158],
  ["Congo","COG","SSA",22,158],
  ["Guinea-Bissau","GNB","SSA",22,158],
  ["Eritrea","ERI","SSA",21,161],
  ["Afghanistan","AFG","AP",20,162],
  ["Burundi","BDI","SSA",20,162],
  ["Chad","TCD","SSA",20,162],
  ["Comoros","COM","SSA",20,162],
  ["Democratic Republic of the Congo","COD","SSA",20,162],
  ["Myanmar","MMR","AP",20,162],
  ["Sudan","SDN","SSA",20,162],
  ["Tajikistan","TJK","ECA",20,162],
  ["Libya","LBY","MENA",18,170],
  ["Turkmenistan","TKM","ECA",18,170],
  ["Equatorial Guinea","GNQ","SSA",17,172],
  ["Haiti","HTI","AME",17,172],
  ["Korea, North","PRK","AP",17,172],
  ["Nicaragua","NIC","AME",17,172],
  ["Yemen","YEM","MENA",16,176],
  ["South Sudan","SSD","SSA",13,177],
  ["Syria","SYR","MENA",13,177],
  ["Venezuela","VEN","AME",13,177],
  ["Somalia","SOM","SSA",11,180]
]





var diff = index.length;

var part = 0;

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
/*

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function difficulty() {


	var difficultLevel = [ [index.length, 0.2],[20, 0],[10,0],[4,0]  ]
	
	var a = document.getElementById("difficulty").value;
	
	if (a == "Easy") {
		diff = difficultLevel[0][0];
		minpart = difficultLevel[0][1];
		}
	else if (a == "Medium") {
		diff = difficultLevel[1][0];
		minpart = difficultLevel[1][1];
		}
	else if (a == "Hard") {
		diff = difficultLevel[2][0];
		minpart = difficultLevel[2][1];
		}
	else {
		diff = difficultLevel[3][0];
		minpart = difficultLevel[3][1];
		}
		
  console.log(diff+" "+minpart);
	setup();
	count=0;
}
*/

function populate() {

	var table = document.getElementById("all_table");
	
	var i;
	for(i=0; i<index.length; i++) {
		var row = table.insertRow(i+1);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
    /*
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		var cell6 = row.insertCell(5);
		var cell7 = row.insertCell(6);
		var cell8 = row.insertCell(7);
    */

    /*

    cell4.classList.add("hidden");
    cell4.classList.add('lg:table-cell');
    cell5.classList.add("hidden");
    cell5.classList.add('lg:table-cell');
    cell6.classList.add("hidden");
    cell6.classList.add('lg:table-cell');
    cell7.classList.add("hidden");
    cell7.classList.add('lg:table-cell');

    */
    
		cell1.innerHTML = index[i][4];
		cell2.innerHTML = index[i][0];
		cell3.innerHTML = index[i][3];

    /*
		cell4.innerHTML = index[i][3];
		cell5.innerHTML = index[i][4];
		cell6.innerHTML = index[i][5];
		cell7.innerHTML = "$"+numberWithCommas(parseInt(index[i][6]*1000));
		cell8.innerHTML = index[i][7];
    if(index[i][7] >= 20) {
      row.classList.add("bg-sky-200");
    } else if(index[i][7] >= 10) {
      row.classList.add("bg-sky-100");
    }
    if(index[i][7] <= -30) {
      row.classList.add("bg-pink-300");
    } else if(index[i][7] <= -20) {
      row.classList.add("bg-pink-200");
    } else if(index[i][7] <= -10) {
      row.classList.add("bg-pink-100");
    }
    */
    
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

//var a = document.getElementById("difficulty");


num1= Math.floor(Math.random()*index.length);



	do {
		var a= Math.floor((Math.random()-0.5)*diff);
		num2 = num1 + a;
		console.log("a: "+a);
	}
	
	while ((num2 < 0)||(num2 > (index.length-1))||(num2==num1)||(Math.abs(index[num2][3]-index[num1][3])<part));
/*
var count1= index[num1][1];
document.getElementById("c1").innerHTML = count1;

var hdi1= index[num1][0];
document.getElementById("d1").innerHTML = hdi1;
key_1.style.display = "none";

var count2= index[num2][1];
document.getElementById("c2").innerHTML = count2;

var hdi2= index[num2][2];
document.getElementById("d2").innerHTML = hdi2;
key_2.style.display = "none";

document.getElementById("f1").innerHTML = index[num1][3];
document.getElementById("g1").innerHTML = index[num1][4];
document.getElementById("h1").innerHTML = index[num1][5];
document.getElementById("j1").innerHTML = "$"+numberWithCommas(parseInt(index[num1][6]*1000));

document.getElementById("f2").innerHTML = index[num2][3];
document.getElementById("g2").innerHTML = index[num2][4];
document.getElementById("h2").innerHTML = index[num2][5];
document.getElementById("j2").innerHTML = "$"+numberWithCommas(parseInt(index[num2][6]*1000));

*/

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

populate();
setup();



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






<?php   include($path."/footer_tailwind.php");?>
