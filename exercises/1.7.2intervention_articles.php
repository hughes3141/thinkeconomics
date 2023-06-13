<html>

<head>
<?php include "../header.php"; ?>
<style>

.clickthrough1 {

	display: none;
}

#newsListDiv {

	//display: none;
}
</style>


</head>


<body>
<?php include "../navbar.php"; ?>

<h1>1.7.2 Government Intervention: News Aticles</h1>

<h2>Instructions</h2>
<p>Read and discuss the articles in small groups.</p>
<p>For each article:</p>
<ul>
<li>What is the market failure?</li>
<li>What is the government trying to do to correct it?</li>
<li>What issues will arise as a result of this correction?</li>
<li>Do you think it will work?</li>
</ul>
<!--
<button onclick ="toggle()" id="toggleButton">Click to Hide List</button>
-->
<h2>Article List:</h2>
<div id="newsListDiv">
<ul id ="newsList">

</ul>
</div>

<?php include "../footer.php"; ?>

<script>

var index = [


	
	["New Zealand to ban cigarettes for future generations", "https://www.bbc.co.uk/news/world-asia-59589775", "9-Dec-21"],
	
	["New Zealand's ambitious smoke free plan (Radio Broadcast)", "https://www.bbc.co.uk/news/topics/c50znx8v8q8t/smoking?ns_mchannel=social&ns_source=twitter&ns_campaign=bbc_live&ns_linkname=undefined_p0b8wtbl%26New%20Zealand%27s%20ambitious%20smoke%20free%20plan%262021-12-09T07%3A00%3A00.000Z&ns_fee=0&pinned_post_locator=urn:pips:p0b8wtbl&pinned_post_asset_id=undefined_p0b8wtbl&pinned_post_type=share", "9-Dec-21"],
	
	
	["Smoking: Plan to make Wales 'smoke-free' by 2030", "https://www.bbc.co.uk/news/uk-wales-59203697", "8-Nov-21"],
	
	["Obesity: Ban snacking on public transport, top doctor says", "https://www.bbc.co.uk/news/health-49975720", "10-Oct-19"],
	
	["Johnson on milkshake tax (Video)", "https://www.bbc.co.uk/news/uk-politics-48802725", "28-Jun-19"],
	
	["Is it time to treat sugar like smoking?", "https://www.bbc.co.uk/news/health-48499195", "4-Jun-19"],
	
	["Gambling firms agree 'whistle-to-whistle' television sport advertising ban", "https://www.bbc.co.uk/sport/46453954", "6-Dec-18"],

	["Sugar tax on soft drinks raises £154m", "https://www.bbc.co.uk/news/business-46279224", "20-Nov-18"],
	
	["TV alcohol adverts could face '9pm watershed'", "https://www.bbc.co.uk/news/uk-scotland-46279041", "20-Nov-18"],
	
	["Smoking banned in Scottish prisons", "https://www.bbc.co.uk/news/uk-scotland-46385331", "30-Nov-18"],
	
	["Sugar tax: Drinks becoming pricier and in smaller bottles (Video)", "https://www.bbc.co.uk/news/av/uk-politics-42793821", "23-Jan-18"],
	
	["Plain tobacco packaging 'may cut smokers by 300,000 in UK'", "https://www.bbc.co.uk/news/health-39720854", "27-Apr-17"]
	
 
];

var newsList = document.getElementById("newsList");

for (var i=0; i<index.length; i++) {

	var listItem = document.createElement("li");
	var span2 = document.createElement("span");
	var link = document.createElement("a");
	
	
	link.setAttribute("href", index[i][1]);
	link.setAttribute("target", "_blank");
	link.innerHTML = index[i][0];
	
	span2.innerHTML = " ("+index[i][2]+")";
	
	listItem.appendChild(link);
	listItem.appendChild(span2);
	
	newsList.appendChild(listItem);

	

}

function toggle() {

var toggleButton = document.getElementById("toggleButton");


if (toggleButton.innerHTML == "Click to See List") {
	
	toggleButton.innerHTML = "Click to Hide List";

		document.getElementById("newsListDiv").style.display = "block";
	}
	else {
	toggleButton.innerHTML = "Click to See List";

		document.getElementById("newsListDiv").style.display = "none";



	}
}

var clickCount = 0;
function clickthrough(i) {



var points = document.getElementsByClassName(i);


if (clickCount == points.length) {

	for(var j=0; j<points.length; j++) {

	points[j].style.display = "none"

	}
	
	clickCount = 0;


}

else {
points[clickCount].style.display = "list-item";
clickCount ++;
}


/*

for(var j=0; j<points.length; j++) {

	points[j].style.display = "list-item"

}
*/


}


</script>

</body>

</html>