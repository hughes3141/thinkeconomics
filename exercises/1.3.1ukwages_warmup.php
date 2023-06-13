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


<h1>1.3.1 UK Wages Comparison Warm-Up</h1>

<h2>Instructions:</h2>
<p>The cards below will show two occupations. Click which one you think has the higher annual salary. When you click the answer will show. If the card shows <span id="right_sign">green</span> you guessed right; <span id="wrong_sign">red</span> means you guessed wrong. See if you can get a high score!</p>
<p>You can find the data here: <a href="https://www.ons.gov.uk/visualisations/dvc1633/beeswarm/datadownload.xlsx" target="_blank">ONS Download: Annual full-time gross pay by occupation</a></p>
<p>This data is part of the following Release: <a href="https://www.ons.gov.uk/employmentandlabourmarket/peopleinwork/earningsandworkinghours/bulletins/annualsurveyofhoursandearnings/2021" target="_blank">Employee earnings in the UK: 2021</a></p>

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
	<p id="e1" style="display:none;">Annua Salary: <span id="d1"></span></p>
	</div>
<div class="float-child col2" id = "grid_2" onclick="test(2); myClear()">
	<p id="c2" class="country_name"></p>
	<p id="e2" style="display:none;">Annual Salary: <span id="d2"></span></p>
	</div>
</div>
<p>Score: <span id ="score">0</span>/<span id="roundcount">0</span></p>

<p><button id="show_table" onclick ="show_table()">Click here to show occupations and salaries</button></p>

<table id="all_table" style="table-layout: auto; width: ; display: none;" >
<tr>
	
	<th>Occupation</th>
	<th>Salary</th>
	
</tr>


</table>

<?php include "../footer.php"; ?>

<script>

/* 
Source material taken from: https://www.transparency.org/en/cpi/2020/index/nzl 
Used Mr Data Converter to put into array. https://shancarter.github.io/mr-data-converter/
*/

var index = [
  ["Chief executives and senior officials",1115,90.000],
  ["Production managers and directors in manufacturing",1121,48.260],
  ["Production managers and directors in construction",1122,45.977],
  ["Production managers and directors in mining and energy",1123,45.000],
  ["Financial managers and directors",1131,64.384],
  ["Marketing and sales directors",1132,75.631],
  ["Purchasing managers and directors",1133,47.092],
  ["Advertising and public relations directors",1134,64.641],
  ["Human resource managers and directors",1135,47.923],
  ["Information technology and telecommunications directors",1136,63.810],
  ["Functional managers and directors n.e.c.",1139,53.919],
  ["Financial institution managers and directors",1150,45.351],
  ["Managers and directors in transport and distribution",1161,38.783],
  ["Managers and directors in storage and warehousing",1162,31.025],
  ["Senior police officers",1172,58.734],
  ["Senior officers in fire, ambulance, prison and related services",1173,44.642],
  ["Health services and public health managers and directors",1181,51.599],
  ["Social services managers and directors",1184,37.546],
  ["Managers and directors in retail and wholesale",1190,28.824],
  ["Managers and proprietors in agriculture and horticulture",1211,33.376],
  ["Hotel and accommodation managers and proprietors",1221,27.946],
  ["Restaurant and catering establishment managers and proprietors",1223,22.994],
  ["Publicans and managers of licensed premises",1224,26.587],
  ["Leisure and sports managers",1225,30.176],
  ["Health care practice managers",1241,35.659],
  ["Residential, day and domiciliary  care managers and proprietors",1242,37.297],
  ["Property, housing and estate managers",1251,37.468],
  ["Garage managers and proprietors",1252,35.917],
  ["Hairdressing and beauty salon managers and proprietors",1253,24.009],
  ["Waste disposal and environmental services managers",1255,43.224],
  ["Managers and proprietors in other services n.e.c.",1259,30.043],
  ["Biological scientists and biochemists",2112,38.956],
  ["Physical scientists",2113,38.773],
  ["Social and humanities scientists",2114,32.277],
  ["Natural and social science professionals n.e.c.",2119,38.471],
  ["Civil engineers",2121,42.530],
  ["Mechanical engineers",2122,41.167],
  ["Electrical engineers",2123,50.354],
  ["Electronics engineers",2124,49.367],
  ["Design and development engineers",2126,40.827],
  ["Production and process engineers",2127,40.790],
  ["Engineering professionals n.e.c.",2129,43.165],
  ["IT specialist managers",2133,48.053],
  ["IT project and programme managers",2134,50.343],
  ["IT business analysts, architects and systems designers",2135,49.510],
  ["Programmers and software development professionals",2136,44.024],
  ["Web design and development professionals",2137,33.490],
  ["Information technology and telecommunications professionals n.e.c.",2139,42.091],
  ["Conservation professionals",2141,31.215],
  ["Environment professionals",2142,35.782],
  ["Research and development managers",2150,48.623],
  ["Medical practitioners",2211,64.504],
  ["Psychologists",2212,44.468],
  ["Pharmacists",2213,43.847],
  ["Ophthalmic opticians",2214,42.453],
  ["Veterinarians",2216,40.052],
  ["Medical radiographers",2217,41.495],
  ["Health professionals n.e.c.",2219,36.956],
  ["Physiotherapists",2221,35.353],
  ["Occupational therapists",2222,33.680],
  ["Speech and language therapists",2223,32.923],
  ["Therapy professionals n.e.c.",2229,32.951],
  ["Nurses",2231,35.971],
  ["Midwives",2232,41.264],
  ["Higher education teaching professionals",2311,51.034],
  ["Further education teaching professionals",2312,37.319],
  ["Secondary education teaching professionals",2314,41.412],
  ["Primary and nursery education teaching professionals",2315,38.010],
  ["Special needs education teaching professionals",2316,34.097],
  ["Senior professionals of educational establishments",2317,59.841],
  ["Education advisers and school inspectors",2318,39.711],
  ["Teaching and other educational professionals n.e.c.",2319,27.582],
  ["Solicitors",2413,44.355],
  ["Legal professionals n.e.c.",2419,76.522],
  ["Chartered and certified accountants",2421,41.321],
  ["Management consultants and business analysts",2423,42.690],
  ["Business and financial project management professionals",2424,51.009],
  ["Actuaries, economists and statisticians",2425,48.952],
  ["Business and related research professionals",2426,36.219],
  ["Business, research and administrative professionals n.e.c.",2429,50.787],
  ["Architects",2431,43.000],
  ["Town planning officers",2432,37.040],
  ["Quantity surveyors",2433,45.063],
  ["Chartered surveyors",2434,38.855],
  ["Construction project managers and related professionals",2436,38.952],
  ["Social workers",2442,37.890],
  ["Probation officers",2443,37.374],
  ["Clergy",2444,28.089],
  ["Welfare professionals n.e.c.",2449,31.208],
  ["Librarians",2451,27.599],
  ["Archivists and curators",2452,28.234],
  ["Quality control and planning engineers",2461,38.999],
  ["Quality assurance and regulatory professionals",2462,44.460],
  ["Environmental health professionals",2463,38.140],
  ["Journalists, newspaper and periodical editors",2471,35.544],
  ["Public relations professionals",2472,30.324],
  ["Laboratory technicians",3111,22.152],
  ["Electrical and electronics technicians",3112,35.101],
  ["Engineering technicians",3113,36.537],
  ["Building and civil engineering technicians",3114,28.860],
  ["Quality assurance technicians",3115,27.115],
  ["Planning, process and production technicians",3116,30.233],
  ["Science, engineering and production technicians n.e.c.",3119,27.646],
  ["Architectural and town planning technicians",3121,29.165],
  ["Draughtspersons",3122,30.496],
  ["IT operations technicians",3131,30.885],
  ["IT user support technicians",3132,29.583],
  ["Dispensing opticians",3216,26.018],
  ["Pharmaceutical technicians",3217,25.385],
  ["Medical and dental technicians",3218,24.214],
  ["Health associate professionals n.e.c.",3219,23.096],
  ["Youth and community workers",3231,27.041],
  ["Child and early years officers",3233,25.848],
  ["Housing officers",3234,28.980],
  ["Counsellors",3235,25.803],
  ["Welfare and housing associate professionals n.e.c.",3239,25.326],
  ["Police officers (sergeant and below)",3312,42.234],
  ["Fire service officers (watch manager and below)",3313,36.808],
  ["Prison service officers (below principal officer)",3314,32.313],
  ["Police community support officers",3315,26.753],
  ["Protective service associate professionals n.e.c.",3319,34.702],
  ["Authors, writers and translators",3412,30.934],
  ["Arts officers, producers and directors",3416,37.361],
  ["Photographers, audio-visual and broadcasting equipment operators",3417,24.887],
  ["Graphic designers",3421,26.977],
  ["Product, clothing and related designers",3422,30.140],
  ["Sports coaches, instructors and officials",3442,22.865],
  ["Ship and hovercraft officers",3513,53.330],
  ["Legal associate professionals",3520,27.364],
  ["Estimators, valuers and assessors",3531,31.644],
  ["Brokers",3532,66.813],
  ["Insurance underwriters",3533,40.542],
  ["Finance and investment analysts and advisers",3534,36.159],
  ["Taxation experts",3535,50.214],
  ["Importers and exporters",3536,34.550],
  ["Financial and accounting technicians",3537,41.144],
  ["Financial accounts managers",3538,38.427],
  ["Business and related associate professionals n.e.c.",3539,29.711],
  ["Buyers and procurement officers",3541,31.588],
  ["Business sales executives",3542,33.961],
  ["Marketing associate professionals",3543,28.372],
  ["Estate agents and auctioneers",3544,25.411],
  ["Sales accounts and business development managers",3545,46.203],
  ["Conference and exhibition managers and organisers",3546,26.898],
  ["Conservation and environmental associate professionals",3550,24.552],
  ["Public services associate professionals",3561,34.721],
  ["Human resources and industrial relations officers",3562,29.256],
  ["Vocational and industrial trainers and instructors",3563,30.148],
  ["Careers advisers and vocational guidance specialists",3564,26.496],
  ["Inspectors of standards and regulations",3565,32.272],
  ["Health and safety officers",3567,36.373],
  ["National government administrative occupations",4112,26.487],
  ["Local government administrative occupations",4113,27.058],
  ["Officers of non-governmental organisations",4114,28.609],
  ["Credit controllers",4121,24.761],
  ["Book-keepers, payroll managers and wages clerks",4122,26.000],
  ["Bank and post office clerks",4123,22.344],
  ["Finance officers",4124,25.522],
  ["Financial administrative occupations n.e.c.",4129,23.004],
  ["Records clerks and assistants",4131,23.257],
  ["Pensions and insurance clerks and assistants",4132,22.516],
  ["Stock control clerks and assistants",4133,23.503],
  ["Transport and distribution clerks and assistants",4134,26.166],
  ["Library clerks and assistants",4135,21.324],
  ["Human resources administrative occupations",4138,22.257],
  ["Sales administrators",4151,22.316],
  ["Other administrative occupations n.e.c.",4159,23.080],
  ["Office managers",4161,32.004],
  ["Office supervisors",4162,26.754],
  ["Medical secretaries",4211,21.526],
  ["Legal secretaries",4212,21.827],
  ["School secretaries",4213,20.867],
  ["Company secretaries",4214,30.170],
  ["Personal assistants and other secretaries",4215,28.838],
  ["Receptionists",4216,19.044],
  ["Typists and related keyboard occupations",4217,20.196],
  ["Farmers",5111,26.037],
  ["Horticultural trades",5112,23.273],
  ["Gardeners and landscape gardeners",5113,21.496],
  ["Groundsmen and greenkeepers",5114,21.151],
  ["Agricultural and fishing trades n.e.c.",5119,25.469],
  ["Smiths and forge workers",5211,16.519],
  ["Sheet metal workers",5213,25.148],
  ["Metal plate workers, and riveters",5214,33.211],
  ["Welding trades",5215,27.416],
  ["Metal machining setters and setter-operators",5221,28.599],
  ["Tool makers, tool fitters and markers-out",5222,31.723],
  ["Metal working production and maintenance fitters",5223,32.110],
  ["Precision instrument makers and repairers",5224,27.822],
  ["Air-conditioning and refrigeration engineers",5225,32.702],
  ["Vehicle technicians, mechanics and electricians",5231,28.337],
  ["Vehicle body builders and repairers ",5232,26.453],
  ["Vehicle paint technicians",5234,27.239],
  ["Boat and ship builders and repairers",5236,29.642],
  ["Rail and rolling stock builders and repairers",5237,46.753],
  ["Electricians and electrical fitters",5241,32.540],
  ["Telecommunications engineers",5242,34.669],
  ["IT engineers",5245,28.898],
  ["Electrical and electronic trades n.e.c.",5249,34.787],
  ["Skilled metal, electrical and electronic trades supervisors",5250,36.428],
  ["Bricklayers and masons",5312,27.956],
  ["Roofers, roof tilers and slaters",5313,24.309],
  ["Plumbers and heating and ventilating engineers",5314,31.695],
  ["Carpenters and joiners",5315,27.961],
  ["Glaziers, window fabricators and fitters",5316,23.058],
  ["Construction and building trades n.e.c.",5319,27.054],
  ["Plasterers",5321,26.806],
  ["Floorers and wall tilers",5322,25.477],
  ["Painters and decorators",5323,24.797],
  ["Construction and building trades supervisors",5330,37.582],
  ["Weavers and knitters",5411,22.105],
  ["Upholsterers",5412,21.128],
  ["Footwear and leather working trades",5413,19.703],
  ["Pre-press technicians",5421,24.427],
  ["Printers",5422,27.069],
  ["Print finishing and binding workers",5423,21.376],
  ["Butchers",5431,23.721],
  ["Bakers and flour confectioners",5432,20.543],
  ["Fishmongers and poultry dressers",5433,20.564],
  ["Chefs",5434,20.443],
  ["Cooks",5435,18.084],
  ["Catering and bar managers",5436,21.293],
  ["Glass and ceramics makers, decorators and finishers",5441,24.707],
  ["Furniture makers and other craft woodworkers",5442,24.446],
  ["Other skilled trades n.e.c.",5449,25.160],
  ["Nursery nurses and assistants",6121,17.922],
  ["Childminders and related occupations",6122,23.327],
  ["Playworkers",6123,14.345],
  ["Teaching assistants",6125,17.789],
  ["Educational support assistants",6126,16.721],
  ["Veterinary nurses",6131,21.724],
  ["Pest control officers",6132,24.950],
  ["Animal care services occupations n.e.c.",6139,20.144],
  ["Nursing auxiliaries and assistants",6141,22.093],
  ["Ambulance staff (excluding paramedics)",6142,26.939],
  ["Dental nurses",6143,18.644],
  ["Houseparents and residential wardens",6144,24.735],
  ["Care workers and home carers",6145,20.789],
  ["Senior care workers",6146,22.417],
  ["Undertakers, mortuary and crematorium assistants",6148,26.625],
  ["Sports and leisure assistants",6211,21.000],
  ["Travel agents",6212,21.050],
  ["Air travel assistants",6214,20.873],
  ["Rail travel assistants",6215,34.572],
  ["Leisure and travel service occupations n.e.c.",6219,20.774],
  ["Hairdressers and barbers",6221,15.405],
  ["Beauticians and related occupations",6222,15.210],
  ["Housekeepers and related occupations",6231,20.077],
  ["Caretakers",6232,22.568],
  ["Cleaning and housekeeping managers and supervisors",6240,22.003],
  ["Sales and retail assistants",7111,19.358],
  ["Retail cashiers and check-out operators",7112,18.686],
  ["Telephone salespersons",7113,20.782],
  ["Pharmacy and other dispensing assistants",7114,18.353],
  ["Vehicle and parts salespersons and advisers",7115,23.883],
  ["Collector salespersons and credit agents",7121,19.901],
  ["Debt, rent and other cash collectors",7122,21.288],
  ["Roundspersons and van salespersons",7123,21.333],
  ["Merchandisers and window dressers",7125,22.608],
  ["Sales related occupations n.e.c.",7129,24.055],
  ["Sales supervisors",7130,23.103],
  ["Call and contact centre occupations",7211,20.453],
  ["Telephonists",7213,22.703],
  ["Communication operators",7214,27.608],
  ["Market research interviewers",7215,20.821],
  ["Customer service occupations n.e.c.",7219,22.379],
  ["Customer service managers and supervisors",7220,29.790],
  ["Food, drink and tobacco process operatives",8111,21.234],
  ["Glass and ceramics process operatives",8112,22.656],
  ["Textile process operatives",8113,24.321],
  ["Chemical and related process operatives",8114,30.425],
  ["Rubber process operatives",8115,26.037],
  ["Plastics process operatives",8116,22.543],
  ["Metal making and treating process operatives",8117,26.608],
  ["Electroplaters",8118,26.906],
  ["Process operatives n.e.c.",8119,27.545],
  ["Paper and wood machine operatives",8121,23.361],
  ["Coal mine operatives",8122,27.187],
  ["Quarry workers and related operatives",8123,32.328],
  ["Energy plant operatives",8124,33.271],
  ["Metal working machine operatives",8125,23.461],
  ["Water and sewerage plant operatives",8126,30.669],
  ["Printing machine assistants",8127,23.300],
  ["Plant and machine operatives n.e.c.",8129,24.002],
  ["Assemblers (electrical and electronic products)",8131,21.890],
  ["Assemblers (vehicles and metal goods)",8132,29.703],
  ["Routine inspectors and testers",8133,26.903],
  ["Weighers, graders and sorters",8134,25.329],
  ["Tyre, exhaust and windscreen fitters",8135,22.905],
  ["Sewing machinists",8137,18.500],
  ["Assemblers and routine operatives n.e.c.",8139,22.511],
  ["Scaffolders, stagers and riggers",8141,33.244],
  ["Road construction operatives",8142,31.622],
  ["Rail construction and maintenance operatives",8143,35.744],
  ["Construction operatives n.e.c.",8149,25.477],
  ["Large goods vehicle drivers",8211,30.994],
  ["Van drivers",8212,22.908],
  ["Bus and coach drivers",8213,25.149],
  ["Taxi and cab drivers and chauffeurs",8214,21.513],
  ["Crane drivers",8221,36.572],
  ["Fork-lift truck drivers",8222,25.283],
  ["Agricultural machinery drivers",8223,31.180],
  ["Mobile machine drivers and operatives n.e.c.",8229,30.249],
  ["Train and tram drivers",8231,59.198],
  ["Marine and waterways transport operatives",8232,32.063],
  ["Air transport operatives",8233,24.470],
  ["Rail transport operatives",8234,49.893],
  ["Farm workers",9111,23.912],
  ["Forestry workers",9112,22.878],
  ["Fishing and other elementary agriculture occupations n.e.c.",9119,21.722],
  ["Elementary construction occupations",9120,24.285],
  ["Industrial cleaning process occupations",9132,21.309],
  ["Packers, bottlers, canners and fillers",9134,20.683],
  ["Elementary process plant occupations n.e.c.",9139,22.075],
  ["Postal workers, mail sorters, messengers and couriers",9211,27.665],
  ["Elementary administration occupations n.e.c.",9219,18.142],
  ["Window cleaners",9231,19.580],
  ["Street cleaners",9232,20.598],
  ["Cleaners and domestics",9233,18.482],
  ["Launderers, dry cleaners and pressers",9234,17.295],
  ["Refuse and salvage occupations",9235,21.156],
  ["Vehicle valeters and cleaners",9236,19.200],
  ["Elementary cleaning occupations n.e.c.",9239,19.287],
  ["Security guards and related occupations",9241,25.680],
  ["Parking and civil enforcement occupations",9242,21.992],
  ["Elementary security occupations n.e.c.",9249,21.300],
  ["Shelf fillers",9251,18.302],
  ["Elementary sales occupations n.e.c.",9259,21.319],
  ["Elementary storage occupations",9260,23.061],
  ["Hospital porters",9271,21.724],
  ["Kitchen and catering assistants",9272,16.254],
  ["Waiters and waitresses",9273,16.146],
  ["Bar staff",9274,15.896],
  ["Leisure and theme park attendants",9275,16.194],
  ["Other elementary services occupations n.e.c.",9279,18.484]
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

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function populate() {
	
	index.sort(function(a,b){return b[2] - a[2]});
	console.log(index);

	var table = document.getElementById("all_table");
	
	var i;
	for(i=0; i<index.length; i++) {
		var row = table.insertRow(i+1);
		//var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(0);
		var cell3 = row.insertCell(1);
		//cell1.innerHTML = index[i][4];
		cell2.innerHTML = index[i][0];
		cell3.innerHTML = "&pound;"+ numberWithCommas(parseInt(index[i][2]*1000));
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
		document.getElementById("show_table").innerHTML = "Click here to show occupations and salaries";
		
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
var cpi1= "&pound;"+ numberWithCommas(parseInt(index[num1][2]*1000));
document.getElementById("d1").innerHTML = cpi1;
key_1.style.display = "none";
var count2= index[num2][0];
document.getElementById("c2").innerHTML = count2;
var cpi2= "&pound;"+ numberWithCommas(parseInt(index[num2][2]*1000));
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



</body>



</html>