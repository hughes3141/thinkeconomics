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
  @apply mb-3;
}

  
  ";

if($_SERVER['REQUEST_METHOD']==='POST') {


}




include($path."/header_tailwind.php");





?>



<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Human Development Index Game</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">




      <h2 class="text-xl bg-sky-200 mb-1">Instructions:</h2>
      <p style="display: none;" class="mb-1">Click �Start Game� to begin.</p>
      <p class="mb-1">The two cards below will show the names of two countries and some of their development indicators.</p>
      <p class="mb-1">Guess which country is more developed. This is measured by the United Nations Human Development Index. </span></p>
      <p class="mb-1">You can find the data here: <a class="underline text-sky-700" href="http://hdr.undp.org/en/composite/HDI">http://hdr.undp.org/en/composite/HDI</a>.</p>
      <p class="mb-1">Once you guess the answer is shown. If the card shows&nbsp;<span ><span id="right_sign" class="px-2 rounded">green</span></span>&nbsp;you guessed right;&nbsp;<span ><span id="wrong_sign" class="px-2 rounded">red</span></span>&nbsp;means you guessed wrong. Click either card to play again with two new countries.</p>
      <p class="mb-1">Have a go and see if you can get a high score!</p>
      <p class="mb-1">Difficulty Level: 
      <select name="difficulty" id="difficulty" onchange = "difficulty()">
        <option value="Ridiculous">Ridiculous</option>
        <option value="Hard">Hard</option>
        <option value="Medium" selected="selected">Medium</option>
        <option value="Easy">Easy</option>

      </select></p>

      <p><button id="start" onclick="setup()" style="display: none">Start Game</button></p>


      <div class="float-container noselect rounded text-xs lg:text-base">

        <div class="float-child col1 rounded p-1" id="grid_1" onclick="test(1); myClear()" style="background-color: white;">
          <h1 id="c1" class="country_name text-lg font-mono"></h1>
          <div>
            <p class="mb-1" >Life Expectancy at Birth: <span id= "f1"></span></p>
            <p class="mb-1" >Expected Years of Schooling: <span id= "g1"span></p>
            <p class="mb-1" >Mean Years of Schooling: <span id= "h1"></span></p>
            <p class="mb-1" >Gross national income (GNI) per capita: <span id ="j1"></span></p>
          </div>
          <p  class="mb-1" id="e1" style="display:none;">Human Development Index: <span id="d1">33</span></p>
        </div>
        <div class="float-child col2 rounded p-1" id="grid_2" onclick="test(2); myClear()" style="background-color: white;">
          <h1 id="c2" class="country_name text-lg font-mono"></h1>
          <div>
            <p class="mb-1">Life Expectancy at Birth: <span id= "f2"></span></p>
            <p class="mb-1">Expected Years of Schooling: <span id= "g2"span></p>
            <p class="mb-1">Mean Years of Schooling: <span id= "h2"></span></p>
            <p class="mb-1">Gross national income (GNI) per capita: <span id ="j2"></span></p>
          </div>
          <p class="mb-1" id="e2" style="display:none;">Human Development Index: <span id="d2">12</span></p>
        </div>
      </div>
      <p>Score: <span id="score">0</span>/<span id="roundcount">0</span></p>

      <p><button class="border border-black rounded bg-pink-200 w-full mb-2" id="show_table" onclick="show_table()">Click here to show the values of all countries</button></p>

      <table id="all_table" style="table-layout: auto; width: ; display: none;" class="text-sm lg:text-base">
      <tbody><tr class="sticky top-12 lg:top-20 bg-white">
        <th>Rank</th>
        <th>Country</th>
        <th>Human Development Index (HDI)</th>
        <th class="hidden lg:table-cell">Life expectancy at birth</th>
        <th class="hidden lg:table-cell">Expected years of schooling</th>
        <th class="hidden lg:table-cell">Mean years of schooling</th>
        <th class="hidden lg:table-cell">Gross national income (GNI) per capita</th>
        <th>GNI per capita rank minus HDI rank	HDI rank</th>

        
      </tr>
      </tbody>
      </table>

  </div>
</div>



<script>

 

/* 
Source material taken from: http://hdr.undp.org/en/composite/HDI
downloaded 11 March 2021

Update 31 Jan 2024:
Data accurate from this date
https://hdr.undp.org/sites/default/files/2021-22_HDR/HDR21-22_Statistical_Annex_HDI_Table.xlsx

Used Mr Data Converter to put into array. https://shancarter.github.io/mr-data-converter/
*/


var index = [
  [1,"Switzerland",0.962,84.0,16.5,13.9,66.933,5,3],
  [2,"Norway",0.961,83.2,18.2,13.0,64.660,6,1],
  [3,"Iceland",0.959,82.7,19.2,13.8,55.782,11,2],
  [4,"Hong Kong, China (SAR)",0.952,85.5,17.3,12.2,62.607,6,4],
  [5,"Australia",0.951,84.5,21.1,12.7,49.238,18,5],
  [6,"Denmark",0.948,81.4,18.7,13.0,60.365,6,5],
  [7,"Sweden",0.947,83.0,19.4,12.6,54.489,9,9],
  [8,"Ireland",0.945,82.0,18.9,11.6,76.169,-3,8],
  [9,"Germany",0.942,80.6,17.0,14.1,54.534,6,7],
  [10,"Netherlands",0.941,81.7,18.7,12.6,55.979,3,10],
  [11,"Finland",0.940,82.0,19.1,12.9,49.452,11,12],
  [12,"Singapore",0.939,82.8,16.5,11.9,90.919,-10,10],
  [13,"Belgium",0.937,81.9,19.6,12.4,52.293,7,16],
  [13,"New Zealand",0.937,82.5,20.3,12.9,44.057,16,13],
  [15,"Canada",0.936,82.7,16.4,13.8,46.808,9,15],
  [16,"Liechtenstein",0.935,83.3,15.2,12.5,146.830,-15,14],
  [17,"Luxembourg",0.930,82.6,14.4,13.0,84.649,-13,17],
  [18,"United Kingdom",0.929,80.7,17.3,13.4,45.225,9,17],
  [19,"Japan",0.925,84.8,15.2,13.4,42.274,12,19],
  [19,"Korea (Republic of)",0.925,83.7,16.5,12.5,44.501,9,20],
  [21,"United States",0.921,77.2,16.3,13.7,64.765,-14,21],
  [22,"Israel",0.919,82.3,16.1,13.3,41.524,10,22],
  [23,"Malta",0.918,83.8,16.8,12.2,38.884,12,26],
  [23,"Slovenia",0.918,80.7,17.7,12.8,39.746,10,23],
  [25,"Austria",0.916,81.6,16.0,12.3,53.619,-8,23],
  [26,"United Arab Emirates",0.911,78.7,15.7,12.7,62.574,-15,25],
  [27,"Spain",0.905,83.0,17.9,10.6,38.354,10,27],
  [28,"France",0.903,82.5,15.8,11.6,45.937,-2,28],
  [29,"Cyprus",0.896,81.2,15.6,12.4,38.188,9,29],
  [30,"Italy",0.895,82.9,16.2,10.7,42.840,0,32],
  [31,"Estonia",0.890,77.1,15.9,13.5,38.048,8,30],
  [32,"Czechia",0.889,77.7,16.2,12.9,38.745,4,30],
  [33,"Greece",0.887,80.1,20.0,11.4,29.002,17,33],
  [34,"Poland",0.876,76.5,16.0,13.2,33.034,8,36],
  [35,"Bahrain",0.875,78.8,16.3,11.0,39.497,-1,35],
  [35,"Lithuania",0.875,73.7,16.3,13.5,37.931,5,34],
  [35,"Saudi Arabia",0.875,76.9,16.1,11.3,46.112,-10,38],
  [38,"Portugal",0.866,81.0,16.9,9.6,33.155,3,39],
  [39,"Latvia",0.863,73.6,16.2,13.3,32.803,4,37],
  [40,"Andorra",0.858,80.4,13.3,10.6,51.167,-19,45],
  [40,"Croatia",0.858,77.6,15.1,12.2,30.132,8,41],
  [42,"Chile",0.855,78.9,16.7,10.9,24.563,14,43],
  [42,"Qatar",0.855,79.3,12.6,10.0,87.134,-39,42],
  [44,"San Marino",0.853,80.9,12.3,10.8,52.654,-25,46],
  [45,"Slovakia",0.848,74.9,14.5,12.9,30.690,1,40],
  [46,"Hungary",0.846,74.5,15.0,12.2,32.789,-2,44],
  [47,"Argentina",0.842,75.4,17.9,11.1,20.925,17,47],
  [48,"Türkiye",0.838,76.0,18.3,8.6,31.033,-3,48],
  [49,"Montenegro",0.832,76.3,15.1,12.2,20.839,16,52],
  [50,"Kuwait",0.831,78.7,15.3,7.3,52.920,-32,54],
  [51,"Brunei Darussalam",0.829,74.6,14.0,9.2,64.490,-42,49],
  [52,"Russian Federation",0.822,69.4,15.8,12.8,27.166,-1,49],
  [53,"Romania",0.821,74.2,14.2,11.3,30.027,-4,53],
  [54,"Oman",0.816,72.5,14.6,11.7,27.054,-2,51],
  [55,"Bahamas",0.812,71.6,12.9,12.6,30.486,-8,58],
  [56,"Kazakhstan",0.811,69.4,15.8,12.3,23.943,1,59],
  [57,"Trinidad and Tobago",0.810,73.0,14.5,11.6,23.392,1,56],
  [58,"Costa Rica",0.809,77.0,16.5,8.8,19.974,8,57],
  [58,"Uruguay",0.809,75.4,16.8,9.0,21.269,5,55],
  [60,"Belarus",0.808,72.4,15.2,12.1,18.849,8,60],
  [61,"Panama",0.805,76.2,13.1,10.5,26.957,-8,67],
  [62,"Malaysia",0.803,74.9,13.3,10.6,26.658,-8,61],
  [63,"Georgia",0.802,71.7,15.6,12.8,14.664,17,64],
  [63,"Mauritius",0.802,73.6,15.2,10.4,22.025,-1,62],
  [63,"Serbia",0.802,74.2,14.4,11.4,19.123,4,62],
  [66,"Thailand",0.800,78.7,15.9,8.7,17.030,6,64],
  [67,"Albania",0.796,76.5,14.4,11.3,14.131,17,68],
  [68,"Bulgaria",0.795,71.8,13.9,11.4,23.079,-8,64],
  [68,"Grenada",0.795,74.9,18.7,9.0,13.484,18,70],
  [70,"Barbados",0.790,77.6,15.7,9.9,12.306,26,71],
  [71,"Antigua and Barbuda",0.788,78.5,14.2,9.3,16.792,2,71],
  [72,"Seychelles",0.785,71.3,13.9,10.3,25.831,-17,69],
  [73,"Sri Lanka",0.782,76.4,14.1,10.8,12.578,21,75],
  [74,"Bosnia and Herzegovina",0.780,75.3,13.8,10.5,15.242,4,73],
  [75,"Saint Kitts and Nevis",0.777,71.7,15.4,8.7,23.358,-16,76],
  [76,"Iran (Islamic Republic of)",0.774,73.9,14.6,10.6,13.001,15,77],
  [77,"Ukraine",0.773,71.6,15.0,11.1,13.256,11,78],
  [78,"North Macedonia",0.770,73.8,13.6,10.2,15.918,-3,79],
  [79,"China",0.768,78.2,14.2,7.6,17.504,-8,82],
  [80,"Dominican Republic",0.767,72.6,14.5,9.3,17.990,-11,82],
  [80,"Moldova (Republic of)",0.767,68.8,14.4,11.8,14.875,-1,81],
  [80,"Palau",0.767,66.0,15.8,12.5,13.819,5,80],
  [83,"Cuba",0.764,73.7,14.4,12.5,7.879,37,73],
  [84,"Peru",0.762,72.4,15.4,9.9,12.246,13,85],
  [85,"Armenia",0.759,72.0,13.1,11.3,13.158,4,87],
  [86,"Mexico",0.758,70.2,14.9,9.2,17.896,-16,88],
  [87,"Brazil",0.754,72.8,15.6,8.1,14.370,-5,86],
  [88,"Colombia",0.752,72.8,14.4,8.9,14.384,-7,88],
  [89,"Saint Vincent and the Grenadines",0.751,69.6,14.7,10.8,11.961,11,82],
  [90,"Maldives",0.747,79.9,12.6,7.3,15.448,-14,97],
  [91,"Algeria",0.745,76.4,14.6,8.1,10.800,13,96],
  [91,"Azerbaijan",0.745,69.4,13.5,10.5,14.257,-8,100],
  [91,"Tonga",0.745,71.0,16.0,11.4,6.822,34,90],
  [91,"Turkmenistan",0.745,69.3,13.2,11.3,13.021,-1,93],
  [95,"Ecuador",0.740,73.7,14.6,8.8,10.312,11,99],
  [96,"Mongolia",0.739,71.0,15.0,9.4,10.588,9,90],
  [97,"Egypt",0.731,70.2,13.8,9.6,11.732,4,97],
  [97,"Tunisia",0.731,73.8,15.4,7.4,10.258,10,94],
  [99,"Fiji",0.730,67.1,14.7,10.9,9.980,9,94],
  [99,"Suriname",0.730,70.3,13.0,9.8,12.672,-6,92],
  [101,"Uzbekistan",0.727,70.9,12.5,11.9,7.917,18,107],
  [102,"Dominica",0.720,72.8,13.3,8.1,11.488,0,106],
  [102,"Jordan",0.720,74.3,10.6,10.4,9.924,8,104],
  [104,"Libya",0.718,71.9,12.9,7.6,15.336,-27,117],
  [105,"Paraguay",0.717,70.3,13.0,8.9,12.349,-10,100],
  [106,"Palestine, State of",0.715,73.5,13.4,9.9,6.583,21,109],
  [106,"Saint Lucia",0.715,71.1,12.9,8.5,12.048,-7,104],
  [108,"Guyana",0.714,65.7,12.5,8.6,22.465,-47,107],
  [109,"South Africa",0.713,62.3,13.6,11.4,12.948,-17,102],
  [110,"Jamaica",0.709,70.5,13.4,9.2,8.834,4,110],
  [111,"Samoa",0.707,72.8,12.4,11.4,5.308,24,112],
  [112,"Gabon",0.706,65.8,13.0,9.4,13.367,-25,113],
  [112,"Lebanon",0.706,75.0,11.3,8.7,9.526,-1,103],
  [114,"Indonesia",0.705,67.6,13.7,8.6,11.466,-11,116],
  [115,"Viet Nam",0.703,73.6,13.0,8.4,7.867,6,113],
  [116,"Philippines",0.699,69.3,13.1,9.0,8.920,-3,113],
  [117,"Botswana",0.693,61.1,12.3,10.3,16.198,-43,110],
  [118,"Bolivia (Plurinational State of)",0.692,63.6,14.9,9.8,8.111,0,119],
  [118,"Kyrgyzstan",0.692,70.0,13.2,11.4,4.566,26,121],
  [120,"Venezuela (Bolivarian Republic of)",0.691,70.6,12.8,11.1,4.811,20,118],
  [121,"Iraq",0.686,70.4,12.1,7.9,9.977,-12,122],
  [122,"Tajikistan",0.685,71.6,11.7,11.3,4.548,23,126],
  [123,"Belize",0.683,70.5,13.0,8.8,6.309,6,120],
  [123,"Morocco",0.683,74.0,14.2,5.9,7.303,1,122],
  [125,"El Salvador",0.675,70.7,12.7,7.2,8.296,-8,124],
  [126,"Nicaragua",0.667,73.8,12.6,7.1,5.625,6,129],
  [127,"Bhutan",0.666,71.8,13.2,5.2,9.438,-15,125],
  [128,"Cabo Verde",0.662,74.1,12.6,6.3,6.230,2,127],
  [129,"Bangladesh",0.661,72.4,12.4,7.4,5.472,4,128],
  [130,"Tuvalu",0.641,64.5,9.4,10.6,6.351,-2,131],
  [131,"Marshall Islands",0.639,65.3,10.2,10.9,4.620,12,131],
  [132,"India",0.633,67.2,11.9,6.7,6.590,-6,130],
  [133,"Ghana",0.632,63.8,12.0,8.3,5.745,-2,135],
  [134,"Micronesia (Federated States of)",0.628,70.7,11.5,7.8,3.696,22,136],
  [135,"Guatemala",0.627,69.2,10.6,5.7,8.723,-20,133],
  [136,"Kiribati",0.624,67.4,11.8,8.0,4.063,14,137],
  [137,"Honduras",0.621,70.1,10.1,7.1,5.298,-1,138],
  [138,"Sao Tome and Principe",0.618,67.6,13.4,6.2,4.021,13,139],
  [139,"Namibia",0.615,59.3,11.9,7.2,8.634,-23,134],
  [140,"Lao People's Democratic Republic",0.607,68.1,10.1,5.4,7.700,-18,142],
  [140,"Timor-Leste",0.607,67.7,12.6,5.4,4.461,7,140],
  [140,"Vanuatu",0.607,70.4,11.5,7.1,3.085,23,142],
  [143,"Nepal",0.602,68.4,12.9,5.1,3.877,10,144],
  [144,"Eswatini (Kingdom of)",0.597,57.1,13.7,5.6,7.679,-21,141],
  [145,"Equatorial Guinea",0.596,60.6,9.7,5.9,12.074,-47,147],
  [146,"Cambodia",0.593,69.6,11.5,5.1,4.079,3,148],
  [146,"Zimbabwe",0.593,59.3,12.1,8.7,3.810,9,145],
  [148,"Angola",0.586,61.6,12.2,5.4,5.466,-14,149],
  [149,"Myanmar",0.585,65.7,10.9,6.4,3.851,5,145],
  [150,"Syrian Arab Republic",0.577,72.1,9.2,5.1,4.192,-2,152],
  [151,"Cameroon",0.576,60.3,13.1,6.2,3.621,6,150],
  [152,"Kenya",0.575,61.4,10.7,6.7,4.474,-6,150],
  [153,"Congo",0.571,63.5,12.3,6.2,2.889,11,153],
  [154,"Zambia",0.565,61.2,10.9,7.2,3.218,7,154],
  [155,"Solomon Islands",0.564,70.3,10.3,5.7,2.482,13,155],
  [156,"Comoros",0.558,63.4,11.9,5.1,3.142,6,156],
  [156,"Papua New Guinea",0.558,65.4,10.4,4.7,4.009,-4,157],
  [158,"Mauritania",0.556,64.4,9.4,4.9,5.075,-20,158],
  [159,"Côte d'Ivoire",0.550,58.6,10.7,5.2,5.217,-22,159],
  [160,"Tanzania (United Republic of)",0.549,66.2,9.2,6.4,2.664,7,160],
  [161,"Pakistan",0.544,66.1,8.7,4.5,4.624,-19,161],
  [162,"Togo",0.539,61.6,13.0,5.0,2.167,12,163],
  [163,"Haiti",0.535,63.2,9.7,5.6,2.848,2,162],
  [163,"Nigeria",0.535,52.7,10.1,7.2,4.790,-22,163],
  [165,"Rwanda",0.534,66.1,11.2,4.4,2.210,6,165],
  [166,"Benin",0.525,59.8,10.8,4.3,3.409,-7,166],
  [166,"Uganda",0.525,62.7,10.1,5.7,2.181,6,166],
  [168,"Lesotho",0.514,53.1,12.0,6.0,2.700,-2,168],
  [169,"Malawi",0.512,62.9,12.7,4.5,1.466,13,169],
  [170,"Senegal",0.511,67.1,9.0,2.9,3.344,-10,170],
  [171,"Djibouti",0.509,62.3,7.4,4.1,5.025,-32,171],
  [172,"Sudan",0.508,65.3,7.9,3.8,3.575,-14,171],
  [173,"Madagascar",0.501,64.5,10.1,5.1,1.484,8,173],
  [174,"Gambia",0.500,62.1,9.4,4.6,2.172,-1,173],
  [175,"Ethiopia",0.498,65.0,9.7,3.2,2.361,-5,175],
  [176,"Eritrea",0.492,66.5,8.1,4.9,1.729,3,176],
  [177,"Guinea-Bissau",0.483,59.7,10.6,3.6,1.908,0,177],
  [178,"Liberia",0.481,60.7,10.4,5.1,1.289,7,179],
  [179,"Congo (Democratic Republic of the)",0.479,59.2,9.8,7.0,1.076,9,180],
  [180,"Afghanistan",0.478,62.0,10.3,3.0,1.824,-2,177],
  [181,"Sierra Leone",0.477,60.1,9.6,4.6,1.622,-1,181],
  [182,"Guinea",0.465,58.9,9.8,2.2,2.481,-13,182],
  [183,"Yemen",0.455,63.8,9.1,3.2,1.314,1,183],
  [184,"Burkina Faso",0.449,59.3,9.1,2.1,2.118,-8,185],
  [185,"Mozambique",0.446,59.3,10.2,3.2,1.198,2,184],
  [186,"Mali",0.428,58.9,7.4,2.3,2.133,-11,186],
  [187,"Burundi",0.426,61.7,10.7,3.1,0.732,4,187],
  [188,"Central African Republic",0.404,53.9,8.0,4.3,0.966,1,188],
  [189,"Niger",0.400,61.6,7.0,2.1,1.240,-3,189],
  [190,"Chad",0.394,52.5,8.0,2.6,1.364,-7,190],
  [191,"South Sudan",0.385,55.0,5.5,5.7,0.768,-1,191]
]

var index21 = [
  [1,"Norway",0.957,82.4,18.1,12.9,66.494,7,1],
  [2,"Ireland",0.955,82.3,18.7,12.7,68.371,4,3],
  [2,"Switzerland",0.955,83.8,16.3,13.4,69.394,3,2],
  [4,"Hong Kong, China (SAR)",0.949,84.9,16.9,12.3,62.985,7,4],
  [4,"Iceland",0.949,83.0,19.1,12.8,54.682,14,4],
  [6,"Germany",0.947,81.3,17.0,14.2,55.314,11,4],
  [7,"Sweden",0.945,82.8,19.5,12.5,54.508,12,7],
  [8,"Australia",0.944,83.4,22.0,12.7,48.085,15,7],
  [8,"Netherlands",0.944,82.3,18.5,12.4,57.707,6,9],
  [10,"Denmark",0.940,80.9,18.9,12.6,58.662,2,10],
  [11,"Finland",0.938,81.9,19.4,12.8,48.511,11,11],
  [11,"Singapore",0.938,83.6,16.4,11.6,88.155,-8,12],
  [13,"United Kingdom",0.932,81.3,17.5,13.2,46.071,13,14],
  [14,"Belgium",0.931,81.6,19.8,12.1,52.085,6,13],
  [14,"New Zealand",0.931,82.3,18.8,12.8,40.799,18,14],
  [16,"Canada",0.929,82.4,16.2,13.4,48.527,5,14],
  [17,"United States",0.926,78.9,16.3,13.4,63.826,-7,17],
  [18,"Austria",0.922,81.5,16.1,12.5,56.197,-3,18],
  [19,"Israel",0.919,83.0,16.2,13.0,40.187,14,21],
  [19,"Japan",0.919,84.6,15.2,12.9,42.932,9,20],
  [19,"Liechtenstein",0.919,80.7,14.9,12.5,131.032,-18,19],
  [22,"Slovenia",0.917,81.3,17.6,12.7,38.080,15,24],
  [23,"Korea (Republic of)",0.916,83.0,16.5,12.2,43.044,4,22],
  [23,"Luxembourg",0.916,82.3,14.3,12.3,72.712,-19,23],
  [25,"Spain",0.904,83.6,17.6,10.3,40.975,6,25],
  [26,"France",0.901,82.7,15.6,11.5,47.173,-1,26],
  [27,"Czechia",0.900,79.4,16.8,12.7,38.109,9,26],
  [28,"Malta",0.895,82.5,16.1,11.3,39.555,6,28],
  [29,"Estonia",0.892,78.8,16.0,13.1,36.019,9,30],
  [29,"Italy",0.892,83.5,16.1,10.4,42.776,0,29],
  [31,"United Arab Emirates",0.890,78.0,14.3,12.1,67.462,-24,30],
  [32,"Greece",0.888,82.2,17.9,10.6,30.155,14,33],
  [33,"Cyprus",0.887,81.0,15.2,12.2,38.207,2,32],
  [34,"Lithuania",0.882,75.9,16.6,13.1,35.799,5,35],
  [35,"Poland",0.880,78.7,16.3,12.5,31.623,8,34],
  [36,"Andorra",0.868,81.9,13.3,10.5,56.000,-20,36],
  [37,"Latvia",0.866,75.3,16.2,13.0,30.282,8,37],
  [38,"Portugal",0.864,82.1,16.5,9.3,33.967,2,38],
  [39,"Slovakia",0.860,77.5,14.5,12.7,32.113,3,39],
  [40,"Hungary",0.854,76.9,15.2,12.0,31.329,4,42],
  [40,"Saudi Arabia",0.854,75.1,16.1,10.2,47.495,-16,40],
  [42,"Bahrain",0.852,77.3,16.3,9.5,42.522,-12,41],
  [43,"Chile",0.851,80.2,16.4,10.6,23.261,16,43],
  [43,"Croatia",0.851,78.5,15.2,11.4,28.070,6,44],
  [45,"Qatar",0.848,80.2,12.0,9.7,92.418,-43,45],
  [46,"Argentina",0.845,76.7,17.7,10.9,21.190,16,46],
  [47,"Brunei Darussalam",0.838,75.9,14.3,9.1,63.965,-38,47],
  [48,"Montenegro",0.829,76.9,15.0,11.6,21.399,13,48],
  [49,"Romania",0.828,76.1,14.3,11.1,29.497,-1,49],
  [50,"Palau",0.826,73.9,15.8,12.5,19.317,15,52],
  [51,"Kazakhstan",0.825,73.6,15.6,11.9,22.857,9,53],
  [52,"Russian Federation",0.824,72.6,15.0,12.2,26.157,2,49],
  [53,"Belarus",0.823,74.8,15.4,12.3,18.546,14,49],
  [54,"Turkey",0.820,77.7,16.6,8.1,27.701,-4,54],
  [55,"Uruguay",0.817,77.9,16.8,8.9,20.064,9,56],
  [56,"Bulgaria",0.816,75.1,14.4,11.4,23.325,2,55],
  [57,"Panama",0.815,78.5,12.9,10.2,29.558,-10,58],
  [58,"Bahamas",0.814,73.9,12.9,11.4,33.747,-17,58],
  [58,"Barbados",0.814,79.2,15.4,10.6,14.936,20,60],
  [60,"Oman",0.813,77.9,14.2,9.7,25.944,-5,56],
  [61,"Georgia",0.812,73.8,15.3,13.1,14.429,22,63],
  [62,"Costa Rica",0.810,80.3,15.7,8.7,18.486,6,61],
  [62,"Malaysia",0.810,76.2,13.7,10.4,27.534,-11,63],
  [64,"Kuwait",0.806,75.5,14.2,7.3,58.590,-51,62],
  [64,"Serbia",0.806,76.0,14.7,11.2,17.192,8,65],
  [66,"Mauritius",0.804,75.0,15.1,9.5,25.266,-10,66],
  [67,"Seychelles",0.796,73.4,14.1,10.0,26.903,-15,69],
  [67,"Trinidad and Tobago",0.796,73.5,13.0,11.0,26.231,-14,67],
  [69,"Albania",0.795,78.6,14.7,10.1,13.998,18,68],
  [70,"Cuba",0.783,78.8,14.3,11.8,8.621,45,71],
  [70,"Iran (Islamic Republic of)",0.783,76.7,14.8,10.3,12.447,26,70],
  [72,"Sri Lanka",0.782,77.0,14.1,10.6,12.707,23,73],
  [73,"Bosnia and Herzegovina",0.780,77.4,13.8,9.8,14.872,7,76],
  [74,"Grenada",0.779,72.4,16.9,9.0,15.641,3,74],
  [74,"Mexico",0.779,75.1,14.8,8.8,19.160,-8,76],
  [74,"Saint Kitts and Nevis",0.779,74.8,13.8,8.7,25.038,-17,75],
  [74,"Ukraine",0.779,72.1,15.1,11.4,13.216,19,78],
  [78,"Antigua and Barbuda",0.778,77.0,12.8,9.3,20.895,-15,80],
  [79,"Peru",0.777,76.7,15.0,9.7,12.252,19,78],
  [79,"Thailand",0.777,77.2,15.0,7.9,17.781,-10,80],
  [81,"Armenia",0.776,75.1,13.1,11.3,13.894,9,72],
  [82,"North Macedonia",0.774,75.8,13.6,9.8,15.865,-7,82],
  [83,"Colombia",0.767,77.3,14.4,8.5,14.257,3,83],
  [84,"Brazil",0.765,75.9,15.4,8.0,14.263,1,84],
  [85,"China",0.761,76.9,14.0,8.1,16.057,-11,87],
  [86,"Ecuador",0.759,77.0,14.6,8.9,11.044,19,84],
  [86,"Saint Lucia",0.759,76.2,14.0,8.5,14.616,-4,86],
  [88,"Azerbaijan",0.756,73.0,12.9,10.6,13.784,3,88],
  [88,"Dominican Republic",0.756,74.1,14.2,8.1,17.591,-18,89],
  [90,"Moldova (Republic of)",0.750,71.9,11.5,11.7,13.664,2,91],
  [91,"Algeria",0.748,76.9,14.6,8.0,11.174,13,91],
  [92,"Lebanon",0.744,78.9,11.3,8.7,14.655,-11,90],
  [93,"Fiji",0.743,67.4,14.4,10.9,13.009,1,93],
  [94,"Dominica",0.742,78.2,13.0,8.1,11.884,7,94],
  [95,"Maldives",0.740,78.9,12.2,7.0,17.417,-24,98],
  [95,"Tunisia",0.740,76.7,15.1,7.2,10.414,14,94],
  [97,"Saint Vincent and the Grenadines",0.738,72.5,14.1,8.8,12.378,0,96],
  [97,"Suriname",0.738,71.7,13.2,9.3,14.324,-13,98],
  [99,"Mongolia",0.737,69.9,14.2,10.3,10.839,7,97],
  [100,"Botswana",0.735,69.6,12.8,9.6,16.437,-27,102],
  [101,"Jamaica",0.734,74.5,13.1,9.7,9.319,13,98],
  [102,"Jordan",0.729,74.5,11.4,10.5,9.858,8,103],
  [103,"Paraguay",0.728,74.3,12.7,8.5,12.224,-4,104],
  [104,"Tonga",0.725,70.9,14.4,11.2,6.365,25,105],
  [105,"Libya",0.724,72.9,12.9,7.6,15.688,-29,106],
  [106,"Uzbekistan",0.720,71.7,12.1,11.8,7.142,17,107],
  [107,"Bolivia (Plurinational State of)",0.718,71.5,14.2,9.0,8.554,9,108],
  [107,"Indonesia",0.718,71.7,13.6,8.2,11.459,-4,110],
  [107,"Philippines",0.718,71.2,13.1,9.4,9.778,4,111],
  [110,"Belize",0.716,74.6,13.1,9.9,6.382,18,108],
  [111,"Samoa",0.715,73.3,12.7,10.8,6.309,19,113],
  [111,"Turkmenistan",0.715,68.2,11.2,10.3,14.909,-32,112],
  [113,"Venezuela (Bolivarian Republic of)",0.711,72.1,12.8,10.3,7.045,11,101],
  [114,"South Africa",0.709,64.1,13.8,10.2,12.129,-14,115],
  [115,"Palestine, State of",0.708,74.1,13.4,9.2,6.417,12,114],
  [116,"Egypt",0.707,72.0,13.3,7.4,11.466,-14,117],
  [117,"Marshall Islands",0.704,74.1,12.4,10.9,5.039,21,116],
  [117,"Viet Nam",0.704,75.4,12.7,8.3,7.433,3,118],
  [119,"Gabon",0.703,66.5,13.0,8.7,13.930,-30,119],
  [120,"Kyrgyzstan",0.697,71.5,13.0,11.1,4.864,23,120],
  [121,"Morocco",0.686,76.7,13.7,5.6,7.368,1,121],
  [122,"Guyana",0.682,69.9,11.4,8.5,9.455,-10,121],
  [123,"Iraq",0.674,70.6,11.3,7.3,10.801,-16,123],
  [124,"El Salvador",0.673,73.3,11.7,6.9,8.359,-6,124],
  [125,"Tajikistan",0.668,71.1,11.7,10.7,3.954,25,126],
  [126,"Cabo Verde",0.665,73.0,12.7,6.3,7.019,-1,125],
  [127,"Guatemala",0.663,74.3,10.8,6.6,8.494,-10,128],
  [128,"Nicaragua",0.660,74.5,12.3,6.9,5.284,6,127],
  [129,"Bhutan",0.654,71.8,13.0,4.1,10.746,-21,131],
  [130,"Namibia",0.646,63.7,12.6,7.0,9.357,-17,129],
  [131,"India",0.645,69.7,12.2,6.5,6.681,-5,130],
  [132,"Honduras",0.634,75.3,10.1,6.6,5.308,1,132],
  [133,"Bangladesh",0.632,72.6,11.6,6.2,4.976,7,134],
  [134,"Kiribati",0.630,68.4,11.8,8.0,4.260,12,133],
  [135,"Sao Tome and Principe",0.625,70.4,12.7,6.4,3.952,16,135],
  [136,"Micronesia (Federated States of)",0.620,67.9,11.5,7.8,3.983,13,136],
  [137,"Lao People's Democratic Republic",0.613,67.9,11.0,5.3,7.413,-16,137],
  [138,"Eswatini (Kingdom of)",0.611,60.2,11.8,6.9,7.919,-19,139],
  [138,"Ghana",0.611,64.1,11.5,7.3,5.269,-3,138],
  [140,"Vanuatu",0.609,70.5,11.7,7.1,3.105,20,140],
  [141,"Timor-Leste",0.606,69.5,12.6,4.8,4.440,3,141],
  [142,"Nepal",0.602,70.8,12.8,5.0,3.457,13,143],
  [143,"Kenya",0.601,66.7,11.3,6.6,4.244,5,141],
  [144,"Cambodia",0.594,69.8,11.5,5.0,4.246,3,144],
  [145,"Equatorial Guinea",0.592,58.7,9.7,5.9,13.944,-57,145],
  [146,"Zambia",0.584,63.9,11.5,7.2,3.326,10,145],
  [147,"Myanmar",0.583,67.1,10.7,5.0,4.961,-6,148],
  [148,"Angola",0.581,61.2,11.8,5.2,6.104,-17,145],
  [149,"Congo",0.574,64.6,11.7,6.5,2.879,13,149],
  [150,"Zimbabwe",0.571,61.5,11.0,8.5,2.666,14,150],
  [151,"Solomon Islands",0.567,73.0,10.2,5.7,2.253,17,151],
  [151,"Syrian Arab Republic",0.567,72.7,8.9,5.1,3.613,2,152],
  [153,"Cameroon",0.563,59.3,12.1,6.3,3.581,1,153],
  [154,"Pakistan",0.557,67.3,8.3,5.2,5.005,-15,154],
  [155,"Papua New Guinea",0.555,64.5,10.2,4.7,4.301,-10,156],
  [156,"Comoros",0.554,64.3,11.2,5.1,3.099,5,154],
  [157,"Mauritania",0.546,64.9,8.6,4.7,5.135,-21,157],
  [158,"Benin",0.545,61.8,12.6,3.8,3.254,0,158],
  [159,"Uganda",0.544,63.4,11.4,6.2,2.123,15,160],
  [160,"Rwanda",0.543,69.0,11.2,4.4,2.155,12,159],
  [161,"Nigeria",0.539,54.7,10.0,6.7,4.910,-19,161],
  [162,"Cote d'Ivoire",0.538,57.8,10.0,5.3,5.069,-25,161],
  [163,"Tanzania (United Republic of)",0.529,65.5,8.1,6.1,2.600,2,164],
  [164,"Madagascar",0.528,67.0,10.2,6.1,1.596,16,163],
  [165,"Lesotho",0.527,54.3,11.3,6.5,3.151,-6,165],
  [166,"Djibouti",0.524,67.1,6.8,4.1,5.689,-34,166],
  [167,"Togo",0.515,61.0,12.7,4.9,1.602,12,168],
  [168,"Senegal",0.512,67.9,8.6,3.2,3.309,-11,167],
  [169,"Afghanistan",0.511,64.8,10.2,3.9,2.229,0,169],
  [170,"Haiti",0.510,64.0,9.7,5.6,1.709,7,170],
  [170,"Sudan",0.510,65.3,7.9,3.8,3.829,-18,171],
  [172,"Gambia",0.496,62.1,9.9,3.9,2.168,-1,172],
  [173,"Ethiopia",0.485,66.6,8.8,2.9,2.207,-3,174],
  [174,"Malawi",0.483,64.3,11.2,4.7,1.035,13,174],
  [175,"Congo (Democratic Republic of the)",0.480,60.7,9.7,6.8,1.063,11,174],
  [175,"Guinea-Bissau",0.480,58.3,10.6,3.6,1.996,1,178],
  [175,"Liberia",0.480,64.1,9.6,4.8,1.258,8,173],
  [178,"Guinea",0.477,61.6,9.4,2.8,2.405,-12,177],
  [179,"Yemen",0.470,66.1,8.8,3.2,1.594,2,179],
  [180,"Eritrea",0.459,66.3,5.0,3.9,2.793,-17,180],
  [181,"Mozambique",0.456,60.9,10.0,3.5,1.250,3,181],
  [182,"Burkina Faso",0.452,61.6,9.3,1.6,2.133,-9,183],
  [182,"Sierra Leone",0.452,54.7,10.2,3.7,1.668,-4,182],
  [184,"Mali",0.434,59.3,7.5,2.4,2.269,-17,184],
  [185,"Burundi",0.433,61.6,11.1,3.3,.754,4,184],
  [185,"South Sudan",0.433,57.9,5.3,4.8,2.003,-10,186],
  [187,"Chad",0.398,54.2,7.3,2.5,1.555,-5,187],
  [188,"Central African Republic",0.397,53.3,7.6,4.3,.993,0,188],
  [189,"Niger",0.394,62.4,6.5,2.1,1.201,-4,189]
]

var diff = 20;

var minpart = 0;

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

function populate() {

	var table = document.getElementById("all_table");
	
	var i;
	for(i=0; i<index.length; i++) {
		var row = table.insertRow(i+1);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		var cell6 = row.insertCell(5);
		var cell7 = row.insertCell(6);
		var cell8 = row.insertCell(7);

    cell4.classList.add("hidden");
    cell4.classList.add('lg:table-cell');
    cell5.classList.add("hidden");
    cell5.classList.add('lg:table-cell');
    cell6.classList.add("hidden");
    cell6.classList.add('lg:table-cell');
    cell7.classList.add("hidden");
    cell7.classList.add('lg:table-cell');
    
		cell1.innerHTML = index[i][0];
		cell2.innerHTML = index[i][1];
		cell3.innerHTML = index[i][2];
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

var a = document.getElementById("difficulty");


num1= Math.floor(Math.random()*index.length);



	do {
		var a= Math.floor((Math.random()*2-1)*diff);
		num2 = num1 + a;
		console.log("a: "+a);
	}
	
	while ((num2 < 0)||(num2 > (index.length-1))||(num2==num1)||(Math.abs(index[num2][2]-index[num1][2])<minpart)||(index[num1][0]==index[num2][0]));

var count1= index[num1][1];
document.getElementById("c1").innerHTML = count1;

var hdi1= index[num1][2];
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

grid_2.style.backgroundColor="white";
grid_1.style.backgroundColor="white";

console.log(num1);
console.log(num2);



}



populate();
setup();

var clickcount = 0;

function test(i) {



if (i==2) {
	if (index[num2][2]<index[num1][2]) {
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
	if (index[num2][2]>index[num1][2]) {
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
