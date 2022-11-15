<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");



//include($path."/header_tailwind.php"); ?>

<html>

<head>
<?php include "../header.php"; ?>


<!--
  This page will automatically update with new articles with new additions to the news database with the keyword "competition policy resource"

-->
<style>

.clickthrough1 {

	display: none;
}

#newsListDiv {

	display: none;
}
</style>


</head>


<body>
<?php include "../navbar.php"; ?>

<h1>1.6.7 Competition Policy</h1>

<img src="files/1.6.7_1.png" alt="CMA Logo">
<p>Why do businesses need to be regulated for competition purposes?</p>
<button onclick="clickthrough('clickthrough1')">Click through answers</button>
<ul>
<li class="clickthrough1">Mergers need to be investigated.
<ul>
<li class="clickthrough1">Mergers could increase prices</li>
<li class="clickthrough1">Mergers could discourage innovation</li>
<li class="clickthrough1">Mergers could limit consumer choice.</li>
</ul>
</li>
<li class="clickthrough1">Ensure that firms do not engage in anti-competitive behaviour, e.g. cartels.</li>
<li class="clickthrough1">Consumers need to be protected (under consumer law).</li>
</ul>

<iframe width="560" height="315" src="https://www.youtube.com/embed/ejY31B867N4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<iframe width="560" height="315" src="https://www.youtube.com/embed/jN-8Gag7vBQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<h2>Useful information from the CMA:</h2>
<ul>
<li>
<a href="https://www.gov.uk/government/organisations/competition-and-markets-authority" target ="_blank">CMA Website</a>
</li>
<li>
<a href ="https://www.gov.uk/government/organisations/competition-and-markets-authority/about" target="_blank">About the CMA</a>
</li>
<li>
<a href ="https://youtu.be/c5-QxpiHfNc" target ="_blank">Video: How You Can Help Fight Cartels</a>
</li>
<li>
<a href ="https://youtu.be/cemTusT9ufs" target ="_blank">Video: Abuse of Dominant Market Position</a>
</li>
<li>
<a href="https://www.youtube.com/watch?v=jN-8Gag7vBQ&list=PLJREEEp2I-xekJrmVFH-X21S-uHTG_R4x" target ="_blank">Competing Fairly in Business (Video Playlist)</a>
</li>
</ul>
<h2>Useful competition news sources:</h2>
<ul>
<li>
<a href ="https://www.bbc.co.uk/news/topics/c6mk2jjnvpmt/competition-and-markets-authority" target ="_blank">BBC Newsfeed: Competition and Markets Authority</a>
</li>
<li>
<a href = "https://www.theguardian.com/business/competition-commission" target ="_blank">The Guardian Topic Page: Competition and Markets Authority</a>
</li>
<li>
<a href="https://www.gov.uk/cma-cases" target ="_blank">CMA Case Studies</a>
</li>

</ul>
<h2>Ohter CMA Info:</h2>
<ul>
<li>
<a href ="http://news.bbc.co.uk/1/hi/education/4420822.stm" target = "_blank">Private Schools Fee-Fixing</a>
</li>

<li>

<a href ="files/In the moneySainsbury’s and Asda have got a lot of what it takes to get along.pdf" target ="_blank">Sainsburys-Asda Merger Article (The Economist 2018.05.03)</a>
</li>

<li>


<a href="
https://www.bbc.co.uk/news/av/business-56176885" target ="_blank">CMA Boss: 'Imbalance of power' between big tech and sovereign nations (Video)</a>
</li>

<li>
<a href="
https://www.pinsentmasons.com/out-law/guides/competition-law---the-basics" target ="_blank">Explanatoin of UK Competition Law (Super Extension)</a>
</li>
</ul>
<h2>CMA Selected News Stories:</h2>
<button onclick ="toggle()" id="toggleButton">Click to See List</button>
<div id="newsListDiv">
<ul id ="newsList">

  <?php
    $articles = $articles = getNewsArticlesByKeyword("competition policy resource");

    foreach($articles as $article) {
      ?>
        <li><a target="_blank" href="<?=$article['link']?>"><?=$article['headline']?></a> (<?=date("d-M-Y", strtotime($article['datePublished']));?>)</li>
      <?php
    }

  ?>

</ul>
</div>

<?php include "../footer.php"; ?>

<script>

var index = [
  ["Competition watchdog says helicopter merger raises concerns","https://www.bbc.co.uk/news/uk-scotland-scotland-business-59333133","16-Nov-21"],
  ["JD Sports furious after being forced to sell Footasylum","https://www.bbc.co.uk/news/business-59160634","04-Nov-21"],
  ["Facebook fined a record £50m by UK competition watchdog","https://www.bbc.co.uk/news/technology-58980442","20-Oct-21"],
  ["Competition watchdog clears Viagogo-Stubhub merger","https://www.bbc.co.uk/news/business-58493484","08-Sep-21"],
  ["Covid PCR tests: Call to investigate cost of travel tests in Wales","https://www.bbc.co.uk/news/uk-wales-politics-58260242","25-Aug-21"],
  ["Nvidia's takeover of Arm raises serious concerns, says watchdog","https://www.bbc.co.uk/news/business-58284204","20-Aug-21"],
  ["Covid testing is rip-off, says former regulator","https://www.bbc.co.uk/news/business-58200203","17-Aug-21"],
  ["Competition watchdog says Facebook could have to sell Giphy","https://www.bbc.co.uk/news/technology-58188322","12-Aug-21"],
  ["Groupon told to improve how it treats customers","https://www.bbc.co.uk/news/business-58145635","09-Aug-21"],
  ["Funeral firms ordered to make prices clearer","https://www.bbc.co.uk/news/business-57494550","16-Jun-21"],
  ["Apple and Google investigated by UK competition body","https://www.bbc.co.uk/news/technology-57484720","15-Jun-21"],
  ["Facebook probed by UK and EU competition watchdogs","https://www.bbc.co.uk/news/business-57355371","04-Jun-21"],
  ["Asda takeover 'could lead to higher petrol prices'","https://www.bbc.co.uk/news/business-56815934","20-Apr-21"],
  ["Virgin Media and O2 'blockbuster' merger provisionally approved","https://www.bbc.co.uk/news/technology-56746288","14-Apr-21"],
  ["Google, Facebook and Amazon face new UK regulator","https://www.bbc.co.uk/news/technology-56648922","07-Apr-21"],
  ["Danske Bank reprimanded by UK competition watchdog","https://www.bbc.co.uk/news/uk-northern-ireland-56650635","06-Apr-21"],
  ["Former FP McCann bosses banned over role in price fixing","https://www.bbc.co.uk/news/uk-northern-ireland-56446101","18-Mar-21"],
  ["Apple investigated in UK over 'unfair' App Store claims","https://www.bbc.co.uk/news/technology-56279514","04-Mar-21"],
  ["Facebook and Google 'too powerful' says watchdog boss","https://www.bbc.co.uk/news/business-56174671","23-Feb-21"],
  ["Gumtree Shpock tie-up could raise fees and reduce choice, warns watchdog","https://www.bbc.co.uk/news/business-56084600","16-Feb-21"],
  ["Online shoppers warned about hidden price rises","https://www.bbc.co.uk/news/technology-55733928","20-Jan-21"],
  ["Nvidia takeover of chip designer Arm investigated","https://www.bbc.co.uk/news/technology-55560417","06-Jan-21"],
  ["Rangers face competition investigation over replica kit pricing","https://www.bbc.co.uk/news/uk-scotland-scotland-business-55329475","16-Dec-20"],
  ["Billionaire Issa brothers' Asda takeover deal probed","https://www.bbc.co.uk/news/uk-england-lancashire-55239932","09-Dec-20"],
  ["Lastminute.com to pay £7m in holiday refunds","https://www.bbc.co.uk/news/business-55142938","01-Dec-20"],
  ["ComparetheMarket fined £17.9m over competition law breach","https://www.bbc.co.uk/news/business-54986073","19-Nov-20"],
  ["Visa and Mastercard accused of charging 'excessive' fees","https://www.bbc.co.uk/news/business-54606252","20-Oct-20"],
  ["UK U-turn allows Amazon to invest in Deliveroo","https://www.bbc.co.uk/news/business-53169889","24-Jun-20"],
  ["Berkshire estate agents directors banned for price-fixing","https://www.bbc.co.uk/news/uk-england-berkshire-53051702","15-Jun-20"],
  ["JD Sports' takeover of Footasylum blocked by watchdog","https://www.bbc.co.uk/news/business-52556415","06-May-20"],
  ["Competition watchdog raises fintech merger concerns","https://www.bbc.co.uk/news/uk-scotland-scotland-business-52099301","30-Mar-20"],
  ["Tesco told not to block rival supermarkets","https://www.bbc.co.uk/news/business-51505773","14-Feb-20"]
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
	
	//newsList.appendChild(listItem);

	

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