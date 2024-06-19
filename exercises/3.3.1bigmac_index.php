<html>



<head>
<?php include "../header.php";?>

</head>


<body onload="select(), fill()">


<?php include '../navbar.php'; ?>


<div class="pagetitle">3.3.1 Big Mac Index and Purchasing Power Parity</div>
<h1>Purchasing Power Parity</h1>
<p>Purchasing Power Parity (PPP) is a concept in economics that states that exchange rates between two countries should be a point where the price of a basket of goods, once adjusted for the exchange rate, is identical between the two countries.</p>
<p>The Purchasing Power Parity exchange rate is the exchange rate that makes a basket of goods the same price between two countries. In this exercise we will investigate whether this is the case, or whether countries have currencies which are overvalued or undervalued against each other.</p>
<p>To illustrate this concept we will use the Big Mac Index from <em>The Economist</em>. This index was set up as a bit of a joke, but it has since become a bit serious. <em>The Economist</em> tracks the price of Big Macs (a good sold around the world) along with the exchange rate for different currencies. You can find an explanation (and the data) here: <a href="https://www.economist.com/big-mac-index">https://www.economist.com/big-mac-index</a>.</p>
<p><u>Task</u>: Select some countries that you think would be interesting. Look at the figures. See if you can work out whether the country&rsquo;s currency is overvalued or undervalued against the pound.</p>
<p>Country: <select id="selectCountry">
</select>
<p><button id="button" onclick="fill()">Click to Select</button></p>

<div style="border: 1pt solid black; padding: 1pt;">
<h2>Country Facts:</h1>
<p>Name of Country: <strong><span class="country"></span></strong></p>
<p>Price of Big Mac in UK: <strong><span class="uk_bigmac_price"></span> GBP</strong></p>
<p>Price of Big Mac in <span class="country"></span>: <strong><span class="local_bigmac_price"></span> <span class="currency_name"></span></strong></p>
<p>Nominal Exchange Rate: <strong><span class="gbp_x"></span></strong><strong> </strong><strong><span class="currency_name"></span></strong><strong> per GBP</strong></p>
<p><em>Source: Big Mac Index, <span id="year"></span></em></p>

</div>

<p><strong>What is the price of Big Macs in <span class="country"></span> in pounds?</strong></p>

<button onclick="show(10)">Click for answer</button>

<div id = "10" style="display:none;">
<p>1 Big Mac in  <span class="country"></span> costs <span class="local_bigmac_price"></span> <span class="currency_name"></span>.<p>
<p>Exchange Rate: 1 GBP= <span class="gbp_x"></span> <span class="currency_name"></span></p>
<p><span class="local_bigmac_price"></span> <span class="currency_name"></span> &divide; (<span class="gbp_x"></span> <span class="currency_name"></span> per GBP) = <strong>&pound;<span class="local_price_gbp"></span></strong></p>

</div>

<p><strong>How many big macs could I buy in <span class="country"></span> if I got off the plane with the money I would expect to pay for a big mac in the UK?</strong></p>
<p><a href="#" style="display: none">Click for hint</a></p>
<div id="01" ></div>
<button onclick="show02()">Click for answer</button>

<div id ="02" style="display: none">
<p>1 Big Mac in the UK will purchase (<span class="uk_bigmac_price"></span> x <span class="gbp_x"></span>) / <span class="local_bigmac_price"></span> = <span id="gbp_real_x"></span> Big Macs in <span class="country"></span></p>
</div>


<p><strong>What should the Purchasing Power Parity exchange rate be for this country?</strong></p>
<p><a href="#" style="display: none">Click for hint</a></p>
<button onclick="show04()">Click for answer</button>

<div id ="04" style="display: none">
<p>PPP = <span class="local_bigmac_price"></span>/<span class="uk_bigmac_price"></span> = <span id="gbp_ppp"></span> <span class="currency_name"></span> per GBP</p>
</div>
<p><strong>How does this PPP exchange rate compare to the actual (nominal) exchange rate?</strong></p>
<button onclick="show06()">Click for answer</button>

<div id ="06" style="display: none">
<p>The Purchasing Power Parity is <span id="high_low"></span> than the nominal exchange rate.</p>
</div>
<p><strong>Is this currency overvalued or undervalued? </strong><em>Extension: what percentage of the exchange rate is the PPP over-valued or under-valued by?</em></p>
<p><a href="#" style="display: none">Click for hint</a></p>
<button onclick="show08()">Click for answer</button>

<div id ="08" style="display: none">
<p>This currency is <span class="valuation"></span> against GDP.</p>
<p>The currency is <span class="valuation"></span> by <span id ="gbp_valuation"></span>%.</p>

</div>
<?php include '../footer.php'; ?>


<script>


var usd_gbp = 0.83108;
var uk_bigmac_price = 3.69;

var countries = [];

var year ="June 2022";
var index = [
  ["United Arab Emirates","ARE","AED",18,3.67305,4.900559481,3.495145631,45059.73559,-4.844,2.843,10.373,73.235,37.774,4.837,0.64,11.686,81.952,21.563],
  ["Argentina","ARG","ARS",590,129.115,4.569569763,114.5631068,8847.066934,-11.27,-4.103,2.918,61.534,28.469,15.334,10.717,22.869,100.17,33.735],
  ["Australia","AUS","AUD",6.7,1.448435689,4.62568,1.300970874,64955.51876,-10.181,-2.925,4.182,63.518,30.046,-8.689,-12.345,-2.724,58.476,5.879],
  ["Azerbaijan","AZE","AZN",4.7,1.69825,2.767554836,0.912621359,10055.07696,-46.261,-41.92,-37.668,-2.167,-22.193,-30.565,-33.344,-26.028,20.51,-19.487],
  ["Bahrain","BHR","BHD",1.6,0.377,4.24403183,0.310679612,31630.82363,-17.592,-10.935,-4.414,50.027,19.317,-3.769,-7.622,2.518,67.015,11.584],
  ["Brazil","BRA","BRL",22.9,5.39175,4.247229564,4.446601942,9180.888358,-17.53,-10.868,-4.342,50.14,19.406,7.021,2.736,14.013,85.742,24.095],
  ["Canada","CAN","CAD",6.77,1.28915,5.251522321,1.314563107,49674.33413,1.971,10.209,18.277,85.641,47.641,10.205,5.793,17.404,91.268,27.787],
  ["Switzerland","CHE","CHF",6.5,0.96845,6.711755899,1.262135922,67857.66294,30.325,40.853,51.165,137.261,88.694,31.013,25.768,39.572,127.382,51.915],
  ["Chile","CHL","CLP",3400,928.435,3.662076505,660.1941748,18476.46641,-28.892,-23.148,-17.521,29.454,2.955,-11.789,-15.32,-6.026,53.097,2.285],
  ["China","CHN","CNY",24,6.74735,3.556951989,4.660194175,17102.47385,-30.933,-25.354,-19.889,25.738,0,-13.759,-17.212,-8.125,49.677,0],
  ["Colombia","COL","COP",14950,4295.1,3.480710577,2902.912621,7940.328475,-32.413,-26.954,-21.606,23.043,-2.143,-11.751,-15.284,-5.986,53.162,2.329],
  ["Costa Rica","CRI","CRC",2650,678.105,3.907949359,514.5631068,14971.37158,-24.117,-17.988,-11.983,38.146,9.868,-4.276,-8.108,1.978,66.136,10.996],
  ["Czech Republic","CZE","CZK",95,23.92,3.971571906,18.44660194,31037.38877,-22.882,-16.653,-10.55,40.395,11.657,-9.708,-13.323,-3.809,56.708,4.698],
  ["Egypt","EGY","EGP",46,18.945,2.428081288,8.932038835,6918.453014,-52.853,-49.044,-45.314,-14.167,-31.737,-38.124,-40.601,-34.081,7.391,-28.252],
  ["Euro area","EUZ","EUR",4.65,0.97585,4.7650766,0.902912621,39969.13521,-7.474,0,7.321,68.445,33.965,4.17,0,10.976,80.795,20.79],
  ["Britain","GBR","GBP",3.69,0.83108,4.440005776,0.716504854,47886.75302,-13.786,-6.822,0,56.954,24.826,-6.133,-9.89,0,62.914,8.844],
  ["Guatemala","GTM","GTQ",26,7.7279,3.36443277,5.048543689,7161.025481,-34.671,-29.394,-24.225,18.933,-5.412,-14.366,-17.795,-8.772,48.623,-0.704],
  ["Hong Kong","HKG","HKD",21,7.84995,2.675176275,4.077669903,94795.18554,-48.055,-43.859,-39.748,-5.433,-24.79,-52.676,-54.571,-49.585,-17.866,-45.126],
  ["Honduras","HND","HNL",89,24.615,3.615681495,17.2815534,3937.948715,-29.793,-24.121,-18.566,27.814,1.651,-6.462,-10.206,-0.351,62.342,8.462],
  ["Croatia","HRV","HRK",27,7.32845,3.684271572,5.242718447,20402.17858,-28.461,-22.682,-17.021,30.239,3.579,-12.057,-15.577,-6.311,52.632,1.974],
  ["Hungary","HUN","HUF",1030,389.04615,2.647500817,200,28284.4948,-48.592,-44.439,-40.372,-6.411,-25.568,-39.06,-41.5,-35.079,5.766,-29.337],
  ["Indonesia","IDN","IDR",35000,14977.5,2.336838591,6796.116505,9172.246719,-54.624,-50.959,-47.369,-17.393,-34.302,-41.114,-43.472,-37.267,2.2,-31.719],
  ["India","IND","INR",191,79.9513,2.388954276,37.08737864,4579.833524,-53.613,-49.865,-46.195,-15.55,-32.837,-38.399,-40.865,-34.374,6.914,-28.57],
  ["Israel","ISR","ILS",17,3.43745,4.94552648,3.300970874,50313.6669,-3.97,3.787,11.386,74.824,39.038,3.51,-0.634,10.272,79.649,20.025],
  ["Jordan","JOR","JOD",2.3,0.71015,3.238752376,0.446601942,7011.581696,-37.112,-32.031,-27.055,14.49,-8.946,-17.503,-20.806,-12.114,43.179,-4.342],
  ["Japan","JPN","JPY",390,137.865,2.828854314,75.72815534,57016.00844,-45.071,-40.634,-36.287,0,-20.47,-42.382,-44.689,-38.618,0,-33.189],
  ["South Korea","KOR","KRW",4600,1313.45,3.50222696,893.2038835,44570.74238,-31.996,-26.502,-21.121,23.804,-1.539,-24.923,-27.929,-20.018,30.302,-12.945],
  ["Kuwait","KWT","KWD",1.3,0.3074,4.229017567,0.252427184,34372.32808,-17.883,-11.25,-4.752,49.496,18.894,-5.268,-9.061,0.921,64.414,9.846],
  ["Lebanon","LBN","LBP",130000,25600,5.078125,25242.71845,0,-1.396,6.57,14.372,79.512,42.766,0,0,0,0,0],
  ["Sri Lanka","LKA","LKR",1340,360,3.722222222,260.1941748,2859.060372,-27.724,-21.885,-16.166,31.581,4.646,-3.174,-7.05,3.152,68.049,12.274],
  ["Moldova","MDA","MDL",60,19.298,3.10913048,11.65048544,8024.776007,-39.629,-34.752,-29.975,9.908,-12.59,-21.205,-24.36,-16.057,36.754,-8.634],
  ["Mexico","MEX","MXN",70,20.4125,3.42927128,13.59223301,14973.72682,-33.412,-28.033,-22.764,21.225,-3.59,-16.002,-19.365,-10.514,45.784,-2.601],
  ["Malaysia","MYS","MYR",10.9,4.45,2.449438202,2.116504854,22311.91906,-52.438,-48.596,-44.833,-13.412,-31.137,-42.052,-44.372,-38.266,0.574,-32.806],
  ["Nicaragua","NIC","NIO",139,35.89,3.87294511,26.99029126,2839.947641,-24.797,-18.722,-12.772,36.909,8.884,0.757,-3.277,7.339,74.871,16.832],
  ["Norway","NOR","NOK",62,9.89765,6.264113199,12.03883495,63567.8547,21.633,31.459,41.083,121.436,76.109,24.323,19.346,32.445,115.772,44.158],
  ["New Zealand","NZL","NZD",7.1,1.603720632,4.427205,1.378640777,49644.00673,-14.035,-7.091,-0.288,56.502,24.466,-7.082,-10.802,-1.012,61.265,7.742],
  ["Oman","OMN","OMR",1.42,0.385,3.688311688,0.275728155,25517.3687,-28.382,-22.597,-16.93,30.382,3.693,-14.025,-17.467,-8.408,49.215,-0.308],
  ["Pakistan","PAK","PKR",700,221.75,3.156708005,135.9223301,1834.014182,-38.705,-33.753,-28.903,11.59,-11.252,-17.452,-20.756,-12.059,43.269,-4.281],
  ["Peru","PER","PEN",13.9,3.89285,3.570648753,2.699029126,9550.191493,-30.667,-25.066,-19.58,26.222,0.385,-10.192,-13.787,-4.325,55.868,4.136],
  ["Philippines","PHL","PHP",155,56.265,2.754820937,30.09708738,5845.332898,-46.508,-42.187,-37.955,-2.617,-22.551,-29.418,-32.243,-24.806,22.501,-18.156],
  ["Poland","POL","PLN",16.68,4.64845,3.588292872,3.238834951,21239.88256,-30.324,-24.696,-19.183,26.846,0.881,-14.683,-18.099,-9.109,48.074,-1.071],
  ["Qatar","QAT","QAR",13,3.64175,3.569712364,2.524271845,98893.85905,-30.685,-25.086,-19.601,26.189,0.359,-37.74,-40.233,-33.672,8.057,-27.807],
  ["Romania","ROU","RON",11,4.82175,2.281329393,2.13592233,28569.01777,-55.702,-52.124,-48.619,-19.355,-35.863,-47.556,-49.656,-44.13,-8.98,-39.189],
  ["Saudi Arabia","SAU","SAR",17,3.755,4.527296937,3.300970874,26704.95632,-12.091,-4.99,1.966,60.04,27.28,4.96,0.758,11.817,82.165,21.706],
  ["Singapore","SGP","SGD",5.9,1.3914,4.240333477,1.145631068,85366.6994,-17.663,-11.012,-4.497,49.896,19.213,-22.444,-25.549,-17.377,34.604,-10.07],
  ["Sweden","SWE","SEK",57,10.19785,5.589413455,11.06796117,46516.13737,8.532,17.3,25.888,97.586,57.141,18.845,14.087,26.609,106.264,37.806],
  ["Thailand","THA","THB",128,36.6125,3.496073745,24.85436893,9306.323554,-32.115,-26.631,-21.26,23.586,-1.712,-11.961,-15.486,-6.21,52.797,2.085],
  ["Turkey","TUR","TRY",47,17.565,2.67577569,9.126213592,9256.997784,-48.043,-43.846,-39.735,-5.411,-24.773,-32.602,-35.3,-28.199,16.974,-21.849],
  ["Taiwan","TWN","TWD",75,29.9075,2.507732174,14.5631068,64992.89975,-51.306,-47.373,-43.52,-11.352,-29.498,-50.505,-52.486,-47.271,-14.097,-42.608],
  ["Uruguay","URY","UYU",255,41.91,6.084466714,49.51456311,14726.86362,18.145,27.689,37.037,115.086,71.058,49.213,43.239,58.961,158.97,73.019],
  ["United States","USA","USD",5.15,1,5.15,1,69231.4,0,8.078,15.991,82.053,44.787,0,-4.003,6.533,73.557,15.955],
  ["Venezuela","VEN","VES",10,5.6732,1.762673623,1.941747573,0,-65.773,-63.008,-60.3,-37.689,-50.444,0,0,0,0,0],
  ["Vietnam","VNM","VND",69000,23417,2.946577273,13398.05825,6375.564885,-42.785,-38.163,-33.636,4.162,-17.16,-24.706,-27.72,-19.787,30.679,-12.693],
  ["South Africa","ZAF","ZAR",39.9,17.03625,2.342064715,7.747572816,13261.54364,-54.523,-50.849,-47.251,-17.208,-34.155,-42.155,-44.471,-38.376,0.394,-32.926]
];

var index21 = [
  ["United Arab Emirates","ARE","AED",14.75,3.67315,4.015626914,2.606007067,39179.883,-29.1,-22.2,-9.5,7.4,16.1,-12.3,-22.1,-6.9,8.4,-14.4],
  ["Argentina","ARG","ARS",320,85.3736,3.748231303,56.53710247,9890.314,-33.8,-27.4,-15.5,0.2,8.3,11.6,-1,18.4,37.9,8.9],
  ["Australia","AUS","AUD",6.48,1.299967501,4.98474,1.144876325,54348.227,-11.9,-3.5,12.3,33.3,44.1,-4.3,-15,1.6,18.3,-6.6],
  ["Azerbaijan","AZE","AZN",3.95,1.699,2.324896998,0.697879859,4813.67,-58.9,-55,-47.6,-37.8,-32.8,-26.2,-34.4,-21.6,-8.8,-27.9],
  ["Bahrain","BHR","BHD",1.5,0.377,3.978779841,0.265017668,25997.583,-29.7,-23,-10.3,6.4,15,-1.2,-12.3,4.8,22,-3.6],
  ["Brazil","BRA","BRL",21.9,5.5046,3.978490717,3.869257951,8751.381,-29.7,-23,-10.3,6.4,15,20.1,6.6,27.5,48.4,17.2],
  ["Canada","CAN","CAD",6.77,1.2803,5.287823166,1.196113074,46271.717,-6.6,2.4,19.2,41.4,52.9,8.5,-3.6,15.2,34.2,5.9],
  ["Switzerland","CHE","CHF",6.5,0.89155,7.290673546,1.148409894,82483.925,28.8,41.2,64.3,95,110.7,14.3,1.5,21.4,41.3,11.6],
  ["Chile","CHL","CLP",2940,719.425,4.086596935,519.434629,14772.111,-27.8,-20.9,-7.9,9.3,18.1,14.7,1.8,21.7,41.8,12],
  ["China","CHN","CNY",22.4,6.4751,3.459406032,3.957597173,10286.58,-38.9,-33,-22,-7.5,0,2.5,-9,8.7,26.6,0],
  ["Colombia","COL","COP",12950,3460.5,3.742233781,2287.985866,6423.179,-33.9,-27.5,-15.7,0.1,8.2,16.4,3.3,23.5,43.8,13.6],
  ["Costa Rica","CRI","CRC",2350,613.77,3.828795803,415.1943463,12243.842,-32.4,-25.9,-13.7,2.4,10.7,10.7,-1.7,17.5,36.9,8.1],
  ["Czech Republic","CZE","CZK",89,21.5909,4.122106999,15.72438163,23538.518,-27.2,-20.2,-7.1,10.2,19.2,5,-6.8,11.4,29.7,2.5],
  ["Denmark","DNK","DKK",30,6.12065,4.901440207,5.300353357,59770.324,-13.4,-5.1,10.4,31.1,41.7,-9.8,-19.9,-4.2,11.5,-11.9],
  ["Egypt","EGY","EGP",42.5,15.64,2.717391304,7.508833922,3043.64,-52,-47.4,-38.8,-27.3,-21.4,-11.6,-21.5,-6.2,9.2,-13.8],
  ["Euro area","EUZ","EUR",4.25,0.823011399,5.1639625,0.750883392,39378.28686,-8.8,0,16.4,38.1,49.3,12.6,0,19.5,39.2,9.9],
  ["Britain","GBR","GBP",3.29,0.74137228,4.4377165,0.581272085,42378.606,-21.6,-14.1,0,18.7,28.3,-5.8,-16.3,0,16.5,-8],
  ["Guatemala","GTM","GTQ",25,7.8009,3.204758425,4.416961131,4354.336,-43.4,-37.9,-27.8,-14.3,-7.4,2.4,-9.1,8.7,26.5,-0.1],
  ["Hong Kong","HKG","HKD",20.5,7.75535,2.643336535,3.621908127,48626.576,-53.3,-48.8,-40.4,-29.3,-23.6,-46.8,-52.8,-43.5,-34.3,-48.1],
  ["Honduras","HND","HNL",87,24.103,3.60950919,15.37102473,2550.666,-36.2,-30.1,-18.7,-3.5,4.3,18.2,4.9,25.4,46,15.3],
  ["Croatia","HRV","HRK",23,6.23875,3.686635945,4.06360424,14853.016,-34.9,-28.6,-16.9,-1.4,6.6,3.4,-8.2,9.7,27.8,0.9],
  ["Hungary","HUN","HUF",900,297.42395,3.025983617,159.0106007,16469.607,-46.5,-41.4,-31.8,-19.1,-12.5,-16.7,-26.1,-11.6,2.9,-18.7],
  ["Indonesia","IDN","IDR",34000,14125,2.407079646,6007.067138,4196.67,-57.5,-53.4,-45.8,-35.6,-30.4,-22.9,-31.6,-18.2,-4.8,-24.8],
  ["India","IND","INR",190,73.39,2.588908571,33.56890459,2097.782,-54.3,-49.9,-41.7,-30.8,-25.2,-14.7,-24.3,-9.5,5.4,-16.8],
  ["Israel","ISR","ILS",17,3.179,5.347593583,3.003533569,43603.013,-5.5,3.6,20.5,43,54.6,12.3,-0.3,19.2,38.8,9.6],
  ["Jordan","JOR","JOD",2.3,0.709,3.244005642,0.406360424,4425.687,-42.7,-37.2,-26.9,-13.2,-6.2,3.5,-8.1,9.9,28,1.1],
  ["Japan","JPN","JPY",390,104.295,3.739393068,68.90459364,40255.936,-33.9,-27.6,-15.7,0,8.1,-19.1,-28.2,-14.1,0,-21],
  ["South Korea","KOR","KRW",4500,1097.35,4.100788263,795.0530035,31846.217,-27.5,-20.6,-7.6,9.7,18.5,-4,-14.8,1.9,18.6,-6.3],
  ["Kuwait","KWT","KWD",1.15,0.3037,3.786631544,0.203180212,28499.788,-33.1,-26.7,-14.7,1.3,9.5,-8.4,-18.7,-2.8,13.2,-10.6],
  ["Lebanon","LBN","LBP",15500,8750,1.771428571,2738.515901,0,-68.7,-65.7,-60.1,-52.6,-48.8,0,0,0,0,0],
  ["Sri Lanka","LKA","LKR",700,189,3.703703704,123.6749117,3852.484,-34.6,-28.3,-16.5,-1,7.1,19.1,5.8,26.4,47.2,16.3],
  ["Moldova","MDA","MDL",50,17.225,2.90275762,8.833922261,4458.192,-48.7,-43.8,-34.6,-22.4,-16.1,-7.4,-17.8,-1.7,14.5,-9.6],
  ["Mexico","MEX","MXN",54,20.11475,2.684597124,9.540636042,9862.44,-52.6,-48,-39.5,-28.2,-22.4,-20.1,-29,-15.2,-1.2,-22],
  ["Malaysia","MYS","MYR",9.99,4.052,2.465449161,1.765017668,11193.016,-56.4,-52.3,-44.4,-34.1,-28.7,-27.8,-35.9,-23.4,-10.8,-29.5],
  ["Nicaragua","NIC","NIO",124,34.8453,3.558586093,21.90812721,1920.291,-37.1,-31.1,-19.8,-4.8,2.9,17.5,4.3,24.7,45.2,14.7],
  ["Norway","NOR","NOK",52,8.5439,6.086213556,9.187279152,75294.428,7.5,17.9,37.1,62.8,75.9,0.1,-11.1,6.3,23.8,-2.3],
  ["New Zealand","NZL","NZD",6.8,1.395089286,4.87424,1.201413428,41666.635,-13.9,-5.6,9.8,30.3,40.9,4.1,-7.5,10.5,28.7,1.6],
  ["Oman","OMN","OMR",1.1,0.385,2.857142857,0.19434629,18198.309,-49.5,-44.7,-35.6,-23.6,-17.4,-22.9,-31.5,-18.2,-4.7,-24.7],
  ["Pakistan","PAK","PKR",550,160.35,3.429996882,97.17314488,1348.676,-39.4,-33.6,-22.7,-8.3,-0.9,14.1,1.3,21.1,41.1,11.4],
  ["Peru","PER","PEN",11.9,3.6207,3.286657276,2.102473498,6957.864,-41.9,-36.4,-25.9,-12.1,-5,1.5,-9.9,7.7,25.4,-0.9],
  ["Philippines","PHL","PHP",142,48.0925,2.952643344,25.08833922,3511.935,-47.8,-42.8,-33.5,-21,-14.6,-4.6,-15.3,1.2,17.9,-6.9],
  ["Poland","POL","PLN",13.08,3.7226,3.513673239,2.310954064,15600.657,-37.9,-32,-20.8,-6,1.6,-2.3,-13.3,3.7,20.7,-4.7],
  ["Qatar","QAT","QAR",13,3.641,3.570447679,2.296819788,62918.848,-36.9,-30.9,-19.5,-4.5,3.2,-35.8,-43,-31.9,-20.7,-37.4],
  ["Romania","ROU","RON",9.9,4.0089,2.469505351,1.749116608,12887.06,-56.4,-52.2,-44.4,-34,-28.6,-29.1,-37.1,-24.8,-12.4,-30.8],
  ["Russia","RUS","RUB",135,74.63,1.808924025,23.85159011,11601.418,-68,-65,-59.2,-51.6,-47.7,-47.3,-53.2,-44,-34.8,-48.5],
  ["Saudi Arabia","SAU","SAR",14,3.7518,3.731542193,2.473498233,23266.486,-34.1,-27.7,-15.9,-0.2,7.9,-4.7,-15.4,1.1,17.8,-7],
  ["Singapore","SGP","SGD",5.9,1.3308,4.433423505,1.042402827,65233.88,-21.7,-14.1,-0.1,18.6,28.2,-21.7,-30.4,-16.9,-3.2,-23.5],
  ["Sweden","SWE","SEK",52.88,8.29525,6.374732528,9.342756184,51404.434,12.6,23.4,43.6,70.5,84.3,25.4,11.3,33.1,54.9,22.4],
  ["Thailand","THA","THB",128,30.13,4.248257551,22.61484099,7806.961,-24.9,-17.7,-4.3,13.6,22.8,29.8,15.2,37.7,60.4,26.7],
  ["Turkey","TUR","TRY",14.99,7.4705,2.006559133,2.648409894,9150.862,-64.5,-61.1,-54.8,-46.3,-42,-39.7,-46.5,-36,-25.5,-41.2],
  ["Taiwan","TWN","TWD",72,27.98,2.573266619,12.72084806,25873.367,-54.5,-50.2,-42,-31.2,-25.6,-36.1,-43.2,-32.1,-21,-37.6],
  ["Ukraine","UKR","UAH",62,28.14,2.203269367,10.9540636,3706.765,-61.1,-57.3,-50.4,-41.1,-36.3,-29,-37,-24.6,-12.2,-30.7],
  ["Uruguay","URY","UYU",204,42.495,4.800564772,36.04240283,16110.742,-15.2,-7,8.2,28.4,38.8,32.7,17.8,40.8,64,29.5],
  ["United States","USA","USD",5.66,1,5.66,1,65253.518,0,9.6,27.5,51.4,63.6,0,-11.2,6.1,23.6,-2.4],
  ["Vietnam","VNM","VND",66000,23064,2.861602497,11660.77739,3416.232,-49.4,-44.6,-35.5,-23.5,-17.3,-7.4,-17.8,-1.7,14.4,-9.6],
  ["South Africa","ZAF","ZAR",33.5,15.5225,2.158157513,5.918727915,5977.954,-61.9,-58.2,-51.4,-42.3,-37.6,-32.5,-40.1,-28.4,-16.6,-34.1]
]



function select() {

	var select = document.getElementById("selectCountry");
	
	var i;
	for (i=0; i<index.length; i++) {
		countries[i]=index[i][0];
		}
	
	var i;
	for (i=0; i<countries.length; i++) {
	
		var opt = countries[i];
		var el = document.createElement("option");
		el.textContent = opt;
		el.value = i;
		
		if (el.textContent == "United States") {
			
			el.setAttribute("selected", "selected")
		}
		
		select.appendChild(el);	
	}
	
}



function fill() {

	console.clear();

	
	var country_code = document.getElementById("selectCountry").value

	var local_bigmac_price = index[country_code][3];
	var local_dollar_x = index[country_code][4];

	var gbp_x = local_dollar_x/usd_gbp;
	var local_price_gbp = local_bigmac_price/gbp_x;
	var gbp_real_x = uk_bigmac_price*gbp_x/local_bigmac_price;
	var gbp_ppp = local_bigmac_price/uk_bigmac_price;
	var gbp_valuation = ((gbp_ppp-gbp_x)/gbp_x)*100;
	
	var valuation;
	var high_low;
	if (gbp_valuation > 0) {valuation = "overvalued"; high_low = "higher"} else {valuation = "undervalued"; high_low = "lower"};
	
	
	
	var x= document.getElementsByClassName("country");
	var i;
	for (i=0; i<x.length; i++) {
	x[i].innerHTML= index[country_code][0];}
	
	
	var x= document.getElementsByClassName("uk_bigmac_price");
	var i;
	for (i=0; i<x.length; i++) {
	x[i].innerHTML= uk_bigmac_price;}
	
	
	var x= document.getElementsByClassName("local_bigmac_price");
	var i;
	for (i=0; i<x.length; i++) {
	x[i].innerHTML= local_bigmac_price.toFixed(2)}
	
	
	
	var x = document.getElementsByClassName("local_price_gbp");
	for (var i = 0; i<x.length; i++) {
	x[i].innerHTML = local_price_gbp.toFixed(2)}

	
	var x= document.getElementsByClassName("currency_name");
	var i;
	for (i=0; i<x.length; i++) {
	x[i].innerHTML= index[country_code][2];}
	
	
	var x= document.getElementsByClassName("gbp_x");
	var i;
	for (i=0; i<x.length; i++) {
	x[i].innerHTML= gbp_x.toFixed(2)}
	
	document.getElementById("gbp_real_x").innerHTML= gbp_real_x.toFixed(2);
	document.getElementById("gbp_ppp").innerHTML= gbp_ppp.toFixed(2);
	
	
	document.getElementById("high_low").innerHTML= high_low;
	
	var x= document.getElementsByClassName("valuation");
	var i;
	for (i=0; i<x.length; i++) {
	x[i].innerHTML= valuation}
	
	document.getElementById("gbp_valuation").innerHTML= gbp_valuation.toFixed(1);
	
	document.getElementById("year").innerHTML= year;
	
	
	console.log(local_bigmac_price);
	console.log(gbp_x, local_price_gbp, gbp_real_x, gbp_ppp, gbp_valuation);
	console.log(valuation);
	
	document.getElementById("02").style.display = "none";
	document.getElementById("04").style.display = "none";
	document.getElementById("06").style.display = "none";
	document.getElementById("08").style.display = "none";
	document.getElementById("10").style.display = "none";

}



function show(i) {

	document.getElementById(i).style.display = "block";
}

function show02() {
	document.getElementById("02").style.display = "block";

}

function show04() {

	document.getElementById("04").style.display = "block";
;
}

function show06() {

	document.getElementById("06").style.display = "block";

}

function show08() {

	document.getElementById("08").style.display = "block";
}


</script>


</body>



</html>