<!DOCTYPE html>

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
    flex-wrap: wrap;
    /*
	overflow: auto;
	height: 200px;
	//width: 90%;
  */
  width: 100%;
  box-sizing:border-box;
  display: flex;


}

.float-child {

  align-self: center;
  flex: 40%;
  border: 2px solid red;
  height: 85%;
  margin: 10px;
  text-align: center;
  padding: 10px;
  box-sizing:border-box;
  height: 150px;
	
	}
	
  @media (max-width: 400px) {
        .float-child {
          flex: 100%;
        }
     
      }
	
	
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


<h1>2.2.4 Consumer Price Index: Weights Game</h1>

<h2>Instructions:</h2>
<p>The cards below will show two product categories measured by the ONS in their calculation of CPI. Click which one you think has a GREATER weight in the index, i.e. which product do housholds spend more of their income on? When you click the answer will show. If the card shows <span id="right_sign">green</span> you guessed right; <span id="wrong_sign">red</span> means you guessed wrong. See if you can get a high score!</p>
<p>You can find the data here: <a href="https://www.ons.gov.uk/economy/inflationandpriceindices/datasets/consumerpriceinflationupdatingweightsannexatablesw1tow3" target="_blank">Consumer price inflation, updating weights: Annex A</a></p>



<p><button id="start" onclick="setup()" style="display: none">Start Game</button></p>


<div class="float-container noselect">

<div class="float-child" id = "grid_1" onclick="test(1); myClear()">
	<p id="c1" class="country_name"></p>
	<p id="f1" class="country_name"></p>
	
	<p id="e1" style="display:none;">CPI Weighting: <span id="d1"></span></p>
	</div>
<div class="float-child" id = "grid_2" onclick="test(2); myClear()">
	<p id="c2" class="country_name"></p>
	<p id="f2" class="country_name"></p>

	<p id="e2" style="display:none;">CPI Weighting: <span id="d2"></span></p>
	</div>
</div>

<p>
  <label for="level_select">Level Select: </label>
  <select id="level_select" onchange="setup()">
    <option value = "1">Goods vs Services</option>
    <option value = "2">Broad Categories</option>
    <option value = "3" selected>Categories</option>
    <option value = "4">Sub-Categories</option>
    <option value = "5">Products</option>
  </select>
</p>

<p>Score: <span id ="score">0</span>/<span id="roundcount">0</span></p>

<p><button id="show_table" onclick ="show_table()">Click here to show Products and Weights</button></p>

<table id="all_table" style="table-layout: auto; width: ; display: none;" >
<tr>
	
	<th>Product</th>
	<th>CPI Weighting</th>
	
</tr>


</table>

<?php include "../footer.php"; ?>

<script>

/* 
Index is from https://www.ons.gov.uk/economy/inflationandpriceindices/datasets/consumerpriceinflationupdatingweightsannexatablesw1tow3

Updated Feruary 2022

Inex is taken pretty much as is from database.
Extra rows for categories are removed

Extra column added; this is index[i][3]
This is the 'level'
  0- all
  1- Goods Vs Services
  2- Broad Categories
    These are all in the first 12 rows of data e.g.  01  Food and non-alcoholic beverages
  3- Categories
    These are distinguished as being the head of their category e.g. 01.2 Non-alcoholic beverages
  4- Sub-Categories
    These are the next level down e.g. 01.2.1 Coffee, tea and cocoa
  5- Items
    These appear to be the most itemised level e.g. 01.2.1.1 Coffee

  You can filter for levels 4 and 5 by counting the number of full-stops: =LEN(C22)-LEN(SUBSTITUTE(C22,".",""))



*/

var index = [
  ["CHZQ"," CPI (overall index)",1000,0],
  ["CHZR"," 01    Food and non-alcoholic beverages",116,2],
  ["CHZS"," 02    Alcoholic beverages and tobacco",50,2],
  ["CHZT"," 03    Clothing and footwear",60,2],
  ["CHZU"," 04    Housing, water, electricity, gas and other fuels",138,2],
  ["CHZV"," 05    Furniture, household equipment and maintenance",76,2],
  ["CHZW"," 06    Health",21,2],
  ["CHZX"," 07    Transport",139,2],
  ["CHZY"," 08    Communication",25,2],
  ["CHZZ"," 09    Recreation and culture",134,2],
  ["CJUU"," 10    Education",33,2],
  ["CJUV"," 11    Restaurants and hotels",114,2],
  ["CJUW"," 12    Miscellaneous goods and services ",94,2],
  ["ICVH"," All goods",563,1],
  ["ICVI"," All services",437,1],
  ["CJUX"," 01.1 Food",105,3],
  ["CJWB"," 01.1.1 Bread and cereals",21,4],
  ["L83B","01.1.1.1 Rice",0.63,5],
  ["L83C","01.1.1.2 Flours and other cereals",0.42,5],
  ["L83H","01.1.1.3 Bread",4.83,5],
  ["L83S","01.1.1.4 Other bakery products",8.61,5],
  ["L83T","01.1.1.5 Pizza and quiche",1.26,5],
  ["L844","01.1.1.6 Pasta products and couscous",0.84,5],
  ["L846","01.1.1.7/8 Breakfast cereals and other cereal products",4.41,5],
  ["CJWC"," 01.1.2 Meat",20,4],
  ["L848","01.1.2.1 Beef and veal",2.60,5],
  ["L849","01.1.2.2 Pork",1.20,5],
  ["L84A","01.1.2.3 Lamb and goat",1.80,5],
  ["L84B","01.1.2.4 Poultry",3.00,5],
  ["L84C","01.1.2.6 Edible offal",0.20,5],
  ["L84D","01.1.2.7 Dried, salted or smoked meat",8.20,5],
  ["L84E","01.1.2.8 Other meat preparations",3.00,5],
  ["CJWD"," 01.1.3 Fish",5,4],
  ["L84F","01.1.3.1 Fresh or chilled fish",1.15,5],
  ["L84G","01.1.3.4 Frozen seafood",1.25,5],
  ["L84H","01.1.3.6 Other preserved or processed fish and seafood based preps",2.60,5],
  ["CJWE"," 01.1.4 Milk, cheese and eggs",12,4],
  ["L84I","01.1.4.1 Whole milk",0.72,5],
  ["L84J","01.1.4.2 Low fat milk",2.52,5],
  ["L84L","01.1.4.4 Yoghurt",2.04,5],
  ["L84M","01.1.4.5 Cheese and curd",3.36,5],
  ["L84N","01.1.4.6 Other milk products",2.16,5],
  ["L84O","01.1.4.7 Eggs",1.20,5],
  ["CJWF"," 01.1.5 Oils and fats",3,4],
  ["L84P","01.1.5.1 Butter",0.90,5],
  ["L84U","01.1.5.2 Margarine and other vegetable fats",1.41,5],
  ["L84V","01.1.5.3 Olive oil",0.69,5],
  ["CJWG"," 01.1.6 Fruit",11,4],
  ["L84W","01.1.6.1 Fresh or chilled fruit",8.80,5],
  ["L84X","01.1.6.3 Dried fruit and nuts",1.76,5],
  ["L852","01.1.6.4 Preserved fruit and fruit-based products",0.44,5],
  ["CJWH"," 01.1.7 Vegetables including potatoes and tubers",16,4],
  ["L853","01.1.7.1 Fresh or chilled vegetables other than potatoes and other tubers ",6.24,5],
  ["L856","01.1.7.2 Frozen vegetables other than potatoes and other tubers ",0.48,5],
  ["L857","01.1.7.3 Dried vegetables, other preserved or processed vegetables",2.24,5],
  ["L858","01.1.7.4 Potatoes",2.24,5],
  ["L859","01.1.7.5 Crisps",4.48,5],
  ["L85A","01.1.7.6 Other tubers and products of tuber vegetables",0.32,5],
  ["CJWI"," 01.1.8 Sugar, jam, syrups, chocolate and confectionery",12,4],
  ["L85B","01.1.8.1 Sugar",0.48,5],
  ["L85C","01.1.8.2 Jams, marmalades and honey",0.96,5],
  ["L85D","01.1.8.3 Chocolate",6.12,5],
  ["L85E","01.1.8.4 Confectionery products",2.40,5],
  ["L85F","01.1.8.5 Edible ices and ice cream",2.04,5],
  ["CJWJ"," 01.1.9 Food products (nec)",5,4],
  ["L85G","01.1.9.1 Sauces, condiments",2.40,5],
  ["L85H","01.1.9.4 Ready-made meals",1.80,5],
  ["L85I","01.1.9.9 Other food products n.e.c.  ",0.80,5],
  ["CJUY","01.2 Non-alcoholic beverages",11,3],
  ["CJWK","01.2.1 Coffee, tea and cocoa",2,4],
  ["L85J","01.2.1.1 Coffee",1.28,5],
  ["L85K","01.2.1.2 Tea",0.58,5],
  ["L85L","01.2.1.3 Cocoa and powdered chocolate",0.14,5],
  ["CJWL","01.2.2 Mineral waters, soft drinks and juices",9,4],
  ["L85M","01.2.2.1 Mineral or spring waters",0.90,5],
  ["L85N","01.2.2.2 Soft drinks",5.40,5],
  ["L85O","01.2.2.3 Fruit and vegetable juices",2.70,5],
  ["CJUZ","02.1 Alcoholic beverages",27,3],
  ["CJWM","02.1.1 Spirits",8,4],
  ["CJWN","02.1.2 Wine",12,4],
  ["L85Q","02.1.2.1 Wine from grapes",10.20,5],
  ["L85R","02.1.2.2 Wine from other fruits",1.32,5],
  ["L85S","02.1.2.3 Fortified wines",0.48,5],
  ["CJWO","02.1.3 Beer",7,4],
  ["L85T","02.1.3.1 Lager beer",4.69,5],
  ["L85Y","02.1.3.2 Other alcoholic beer",2.31,5],
  ["CJWP","02.2 Tobacco",23,3],
  ["L85Z","02.2.0.1 Cigarettes",19.78,5],
  ["L862","02.2.0.2 Cigars",0.23,5],
  ["L863","02.2.0.3 Other tobacco products",2.99,5],
  ["CJVA","03.1 Clothing",51,3],
  ["CJWR","03.1.2 Garments",44,4],
  ["L866","03.1.2.1 Garments for men",12.76,5],
  ["L867","03.1.2.2 Garments for women",21.56,5],
  ["L86A","03.1.2.3 Garments for infants  (0 to 2 years) and children (3 to 13 years)       ",9.68,5],
  ["CJWS","03.1.3 Other clothing and clothing accessories",6,4],
  ["L86B","03.1.3.1 Other articles of clothing",3.96,5],
  ["L86G","03.1.3.2 Clothing accessories",2.04,5],
  ["CJWT","03.1.4 Cleaning, repair and hire of clothing",1,4],
  ["L86H","03.1.4.1 Cleaning of clothing",0.82,5],
  ["L86K","03.1.4.2 Repair and hire of clothing",0.18,5],
  ["CJVB","03.2 Footwear including repairs",9,3],
  ["L86L","03.2.1.1 Footwear for men",2.70,5],
  ["L86O","03.2.1.2 Footwear for women",4.77,5],
  ["L86P","03.2.1.3 Footwear for infants and children",1.53,5],
  ["CJVC","04.1 Actual rentals for housing",87,3],
  ["CJVD","04.3 Regular maintenance and repair of the dwelling",4,3],
  ["CJWU","04.3.1 Materials for maintenance and repair",2,4],
  ["CJWV","04.3.2 Services for maintenance and repair",2,4],
  ["L89O","04.3.2.1 Services of plumbers",0.70,5],
  ["L89P","04.3.2.2 Services of electricians",0.44,5],
  ["L89Q","04.3.2.4 Services of painters",0.44,5],
  ["L89R","04.3.2.5 Services of carpenters",0.42,5],
  ["CJVE","04.4 Water supply and misc. services for the dwelling",11,3],
  ["CJWW","04.4.1 Water supply",5,4],
  ["CJWY","04.4.3 Sewerage collection",6,4],
  ["CJVF","04.5 Electricity, gas and other fuels",36,3],
  ["CJXA","04.5.1 Electricity",20,4],
  ["CJXB","04.5.2 Gas",14,4],
  ["L89X","04.5.2.1 Natural gas and town gas",13.58,5],
  ["L89Y","04.5.2.2 Liquefied hydrocarbons (butane, propane, etc.)",0.42,5],
  ["CJXC","04.5.3 Liquid fuels",1,4],
  ["CJXD","04.5.4 Solid fuels",1,4],
  ["CJVG","05.1 Furniture, furnishings and carpets",31,3],
  ["CJXF","05.1.1 Furniture and furnishings",27,4],
  ["L8A3","05.1.1.1 Household furniture",25.11,5],
  ["L8A4","05.1.1.2 Garden furniture",0.27,5],
  ["L8A7","05.1.1.3 Lighting equipment",0.81,5],
  ["L8A8","05.1.1.9 Other furniture and furnishings",0.81,5],
  ["CJXG","05.1.2 Carpets and other floor coverings",4,4],
  ["L8A9","05.1.2.1 Carpets and rugs",3.56,5],
  ["L8AC","05.1.2.2 Other floor coverings",0.44,5],
  ["CJVH","05.2 Household textiles",5,3],
  ["L8AD","05.2.0.1 Furnishings fabrics and curtains",1.85,5],
  ["L8AE","05.2.0.2 Bed linen",2.40,5],
  ["L8AF","05.2.0.3 Table linen and bathroom linen",0.75,5],
  ["CJVI","05.3 Household appliances, fitting and repairs ",14,3],
  ["CJXI","05.3.1/2 Major appliances and small electric goods",13,4],
  ["L8AG","05.3.1.1 Refrigerators, freezers and fridge-freezers",1.56,5],
  ["L8AH","05.3.1.2 Clothes washing machines, clothes drying machines and dish washing machines",2.73,5],
  ["L8AI","05.3.1.3 Cookers",1.04,5],
  ["L8AJ","05.3.1.4 Heaters, air conditioners",2.34,5],
  ["L8AK","05.3.1.5 Cleaning equipment",2.73,5],
  ["L8AL","05.3.2.2 Coffee machines, tea makers and similar appliances",1.56,5],
  ["L8AN","05.3.2.3 Irons",0.52,5],
  ["L8AO","05.3.2.9 Other small electric household appliances",0.52,5],
  ["CJXJ","05.3.3 Repair of household appliances",1,4],
  ["CJVJ","05.4 Glassware, tableware and household utensils",8,3],
  ["L8AQ","05.4.0.1 Glassware, crystal-ware, ceramic ware and chinaware",2.72,5],
  ["L8AR","05.4.0.2 Cutlery, flatware and silverware",0.40,5],
  ["L8AS","05.4.0.3 Non electric kitchen utensils and articles",4.88,5],
  ["CJVK","05.5 Tools and equipment for house and garden",7,3],
  ["L8AV","05.5.1.1 Motorized major tools and equipment",0.91,5],
  ["L8AW","05.5.1.2 Repair, leasing and rental of major tools and equipment",0.28,5],
  ["L8AX","05.5.2.1 Non-motorized small tools",1.47,5],
  ["L8AY","05.5.2.2 Miscellaneous small tool accessories",4.34,5],
  ["CJVL","05.6 Goods and services for routine maintenance",11,3],
  ["CJXK","05.6.1 Non-durable household goods",7,4],
  ["L8AZ","05.6.1.1 Cleaning and maintanance products",4.90,5],
  ["L8B2","05.6.1.2 Other non-durable small household articles",2.10,5],
  ["CJXL","05.6.2 Domestic services and household services",4,4],
  ["L8B3","05.6.2.1 Domestic services by paid staff",2.96,5],
  ["L8B4","05.6.2.9 Other domestic services and household services",1.04,5],
  ["JKWO","06.1 Medical products, appliances and equipment",14,3],
  ["CJYA","06.1.1 Pharmaceutical products",11,4],
  ["CJYH","06.1.2/3 Other medical and therapeutic equipment",3,4],
  ["L8B8","06.1.2.1 Pregnancy tests and mechanical contraceptive devices     ",0.42,5],
  ["L8B9","06.1.2.9 Other medical products n.e.c",0.57,5],
  ["L8BA","06.1.3.1 Corrective eye-glasses and contact lenses ",2.01,5],
  ["ICVJ","06.2 Out-patient services",4,3],
  ["ICVK","06.2.1/3 Medical services & paramedical services",2,4],
  ["ICVL","06.2.2 Dental services",2,4],
  ["ICVM","06.3 Hospital services",3,3],
  ["CJVM","07.1 Purchase of vehicles",50,3],
  ["CJXN","07.1.1A New cars",22,4],
  ["CJXO","07.1.1B Second-hand cars",25,4],
  ["CJXP","07.1.2/3 Motorcycles and bicycles",3,4],
  ["L8BF","07.1.2.0 Motor cycles ",0.99,5],
  ["L8BG","07.1.3.0 Bicycles",2.01,5],
  ["CJVN","07.2 Operation of personal transport equipment ",72,3],
  ["CJXQ","07.2.1 Spare parts and accessories",4,4],
  ["L8BH","07.2.1.1 Tyres",0.72,5],
  ["L8BI","07.2.1.2 Spare parts for personal transport",3.28,5],
  ["CJXR","07.2.2 Fuels and lubricants",31,4],
  ["L8BJ","07.2.2.1 Diesel",11.47,5],
  ["L8BK","07.2.2.2 Petrol",19.22,5],
  ["L8BL","07.2.2.4 Lubricants",0.31,5],
  ["CJXS","07.2.3 Maintenance and repairs",21,4],
  ["CJXT","07.2.4 Other services",16,4],
  ["L8BO","07.2.4.1 Hire of garages, parking spaces and personal transport equipment",1.28,5],
  ["L8BP","07.2.4.2 Toll facilities and parking meters",0.48,5],
  ["L8BQ","07.2.4.3 Driving lessons, test licences and road worthiness tests",14.24,5],
  ["CJVO","07.3 Transport services",17,3],
  ["CJXU","07.3.1 Passenger transport by railway",6,4],
  ["L8BR","07.3.1.1 Passenger transport by train",4.56,5],
  ["L8BS","07.3.1.2 Passenger transport by underground and tram",1.44,5],
  ["CJXV","07.3.2/6 Passenger transport by road and other transport services",8,4],
  ["L8BV","07.3.2.1 Passenger transport by bus and coach",2.80,5],
  ["L8BW","07.3.2.2 Passenger transport by taxi and hired car with driver",2.56,5],
  ["L8BX","07.3.6.2 Removal and storage services ",2.64,5],
  ["CJXW","07.3.3 Passenger transport by air",2,4],
  ["CJXX","07.3.4 Passenger transport by sea and inland waterway",1,4],
  ["CJVP","08.1 Postal services",2,3],
  ["CJYB","08.2/3 Telephone and telefax equipment and services",23,3],
  ["L8C2","08.2.0.1 Fixed telephone equipment",0.23,5],
  ["L8C3","08.2.0.2 Mobile telephone equipment",2.53,5],
  ["L8C4","08.3.0.1 Wired telephone services",1.84,5],
  ["L8C7","08.3.0.2 Wireless telephone services",7.82,5],
  ["L8C8","08.3.0.3 Internet access provision services",0.69,5],
  ["L8C9","08.3.0.4 Bundled telecommunication services",9.89,5],
  ["CJVQ","09.1 Audio-visual equipment and related products",23,3],
  ["CJYC","09.1.1 Reception and reproduction of sound and pictures",6,4],
  ["L8CA","09.1.1.1 Equipment for the reception, recording and reproduction of sound",1.68,5],
  ["L8CD","09.1.1.2 Equipment for the reception, recording and reproduction of sound and vision",3.36,5],
  ["L8CE","09.1.1.3 Portable sound and vision devices",0.54,5],
  ["L8CF","09.1.1.9 Other equipment for the reception, recording and reproduction of sound and picture",0.42,5],
  ["CJYD","09.1.2 Photographic, cinematographic and optical equipment",2,4],
  ["CJYE","09.1.3 Data processing equipment",5,4],
  ["L8CH","09.1.3.1 Personal computers",2.05,5],
  ["L8CI","09.1.3.2 Accessories for information processing equipment",1.65,5],
  ["L8CJ","09.1.3.3 Software",1.30,5],
  ["CJYF","09.1.4 Recording media",9,4],
  ["L8CK","09.1.4.1 Pre-recorded recording media",8.19,5],
  ["L8CL","09.1.4.2 Unrecorded recording media",0.36,5],
  ["L8CM","09.1.4.9 Other recording media",0.45,5],
  ["CJYG","09.1.5 Repair of audio-visual equipment & related products",1,4],
  ["CJVR","09.2 Oth. major durables for recreation & culture",16,3],
  ["ICVN","09.2.1/2/3 Major durables for in/outdoor recreation and their maintenance",16,4],
  ["L8CO","09.2.1.1 Camper vans, caravans and trailers",8.16,5],
  ["L8CP","09.2.1.3 Boats, outboard motors and fitting out of boats",3.20,5],
  ["L8CR","09.2.1.5 Major items for games and sport",1.92,5],
  ["L8CS","09.2.2.1 Musical instruments ",1.44,5],
  ["L8CQ","09.2.3.0 Maintenance and repair of other major durables for recreation and culture",1.28,5],
  ["CJVS","09.3 Other recreational items, gardens and pets",40,3],
  ["ICVP","09.3.1 Games, toys and hobbies",12,4],
  ["L8CT","09.3.1.1 Games and hobbies",5.76,5],
  ["L8CU","09.3.1.2 Toys and celebration articles",6.24,5],
  ["ICVQ","09.3.2 Equipment for sport and open-air recreation",9,4],
  ["L8CV","09.3.2.1 Equipment for sport",7.20,5],
  ["L8CW","09.3.2.2 Equipment for camping and open-air recreation",1.80,5],
  ["CJYI","09.3.3 Gardens, plants and flowers",8,4],
  ["L8CX","09.3.3.1 Garden products",1.04,5],
  ["L8CY","09.3.3.2 Plants and flowers",6.96,5],
  ["CJYJ","09.3.4/5 Pets, related products and services",11,4],
  ["L8CZ","09.3.4.1 Purchase of pets ",0.55,5],
  ["L8D2","09.3.4.2 Products for pets",6.82,5],
  ["L8D3","09.3.5.0 Veterinary and other services for pets",3.63,5],
  ["CJVT","09.4 Recreational and cultural services",26,3],
  ["ICVR","09.4.1 Recreational and sporting services",8,4],
  ["L8D4","09.4.1.1 Recreational and sporting services - Attendance        ",1.28,5],
  ["L8D5","09.4.1.2 Recreational and sporting services - Participation",6.72,5],
  ["ICVS","09.4.2 Cultural services",18,4],
  ["L8D6","09.4.2.1 Cinemas, theatres, concerts",6.48,5],
  ["L8D7","09.4.2.2 Museums, libraries, zoological gardens",3.24,5],
  ["L8D8","09.4.2.3 Television and radio licence fees, subscriptions",7.02,5],
  ["L8D9","09.4.2.4 Hire of equipment and accessories for culture",0.54,5],
  ["L8DA","09.4.2.5 Photographic services",0.72,5],
  ["ICVT","09.5 Books, newspapers and stationery",14,3],
  ["ICVU","09.5.1 Books",4,4],
  ["L8DB","09.5.1.1 Fiction books",1.56,5],
  ["L8DC","09.5.1.3 Other non-fiction books",2.40,5],
  ["L8DD","09.5.1.4 Binding services and e-book downloads",0.04,5],
  ["ICVV","09.5.2 Newspapers and periodicals",4,4],
  ["L8DE","09.5.2.1 Newspapers",2.60,5],
  ["L8DL","09.5.2.2 Magazines and periodicals",1.40,5],
  ["ICVW","09.5.3/4 Misc. printed matter, stationery, drawing materials",6,5],
  ["L8DN","09.5.3.0 Miscellaneous printed matter ",3.00,5],
  ["L8DO","09.5.4.1 Paper products",1.56,5],
  ["L8DP","09.5.4.9 Other stationery and drawing materials",1.44,5],
  ["ICVX","09.6 Package holidays",15,3],
  ["CJUU","10.0 Education",33,3],
  ["L8DT","10.1/2/5 Pre-primary, primary and secondary education(incl not definable by level) ",7.59,4],
  ["L8LF","10.4 Tertiary education",25.41,4],
  ["CJVU","11.1 Catering services",91,3],
  ["CJYL","11.1.1 Restaurants & cafes",89,4],
  ["L8LL","11.1.1.1 Restaurants, cafes and dancing establishments ",66.75,5],
  ["L8LM","11.1.1.2 Fast food and take away food services",22.25,5],
  ["CJYM","11.1.2 Canteens",2,4],
  ["CJVV","11.2 Accommodation services",23,3],
  ["L8U9","11.2.0.1 Hotels, motel, inns and similar accommodation services ",19.78,5],
  ["L8UD","11.2.0.2 Holiday centres, camping sites, youth hostels and similar accommodation services",0.69,5],
  ["L8UE","11.2.0.3 Accommodation services of other establishments",2.53,5],
  ["CJVW","12.1 Personal care",28,3],
  ["CJYN","12.1.1 Hairdressing and personal grooming establishments",5,4],
  ["L8UF","12.1.1.1 Hairdressing for men and children",1.10,5],
  ["L8UG","12.1.1.2 Hairdressing for women",2.25,5],
  ["L8UH","12.1.1.3 Personal grooming treatments",1.65,5],
  ["CJYO","12.1.2/3 Appliances and products for personal care",23,4],
  ["L8UI","12.1.2.1 Electric appliances for personal care ",1.15,5],
  ["L8UJ","12.1.3.1 Non electric appliances",1.38,5],
  ["L8UK","12.1.3.2 Articles for personal hygiene and wellness",20.47,5],
  ["CJVX","12.3 Personal effects (nec)",10,3],
  ["ICVZ","12.3.1 Jewellery, clocks and watches",7,4],
  ["L8UL","12.3.1.1 Jewellery",5.11,5],
  ["L8UM","12.3.1.2 Clocks and watches",1.33,5],
  ["L8UN","12.3.1.3 Repair of jewellery, clocks and watches",0.56,5],
  ["ICWA","12.3.2 Other personal effects",3,4],
  ["L8UO","12.3.2.1 Travel goods",1.95,5],
  ["L8UP","12.3.2.2 Articles for babies",0.42,5],
  ["L8UQ","12.3.2.9 Other personal effects n.e.c.",0.63,5],
  ["CJVY","12.4 Social protection",17,3],
  ["L8UR","12.4.0.1 Child care services",14.28,5],
  ["L8US","12.4.0.2 Retirement homes for elderly persons and residences for disabled persons  ",0.34,5],
  ["L8UT","12.4.0.3 Services to maintain people in their private homes",2.38,5],
  ["CJVZ","12.5 Insurance",6,3],
  ["CJYP","12.5.2 House contents insurance",2,4],
  ["JKWP","12.5.3/5 Health insurance and other insurance",2,4],
  ["CJYQ","12.5.4 Transport insurance",2,4],
  ["L8UW","12.5.4.1 Motor vehicle insurance",1.86,5],
  ["L8UX","12.5.4.2 Travel insurance",0.14,5],
  ["CJWA","12.6 Financial services (nec)",16,3],
  ["CJYK","12.6.2 Other financial services (nec)",16,4],
  ["L8UY","12.6.2.1 Charges by banks and post offices",11.20,5],
  ["L8UZ","12.6.2.2 Fees and service charges of brokers, investment counsellors",4.80,5],
  ["ICVY","12.7 Other services (nec)",17,3],
  ["L8V2","12.7.0.1 Administrative fees",0.51,5],
  ["L8V3","12.7.0.2 Legal services and accountancy",3.23,5],
  ["L8V4","12.7.0.3 Funeral services",3.23,5],
  ["L8V5","12.7.0.4 Other fees and services",10.03,5]
]

var index2 = [];

var clickcount = 0;

//console.log(index);



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
		cell2.innerHTML = index[i][1];
		cell3.innerHTML = index[i][2];
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

var level = document.getElementById("level_select").value;

console.log(level);

index2 = [];
for(var i=0; i<index.length; i++) {
  if(index[i][3]==level) {
    index2.push(index[i])
  }
}

console.log(index2);

num1= Math.floor(Math.random()*index2.length);

do {
  num2 = Math.floor(Math.random()*index2.length)
}

while (
  num1 == num2
)



var count1= index2[num1][1];
document.getElementById("c1").innerHTML = count1;
var cpi1= index2[num1][2];
document.getElementById("d1").innerHTML = cpi1;
key_1.style.display = "none";
var count2= index2[num2][1];
document.getElementById("c2").innerHTML = count2;
var cpi2= index2[num2][2];
document.getElementById("d2").innerHTML = cpi2;
key_2.style.display = "none";




grid_2.style.backgroundColor="white";
grid_1.style.backgroundColor="white";

console.log(num1);
console.log(num2);

count = 0;
clickcount=0;

}






function test(i) {



if (i==2) {
	if (index2[num2][2]<index2[num1][2]) {
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
	if (index2[num2][2]>index2[num1][2]) {
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