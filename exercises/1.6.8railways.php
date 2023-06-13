<html>

<head>
<?php include "../header.php"; ?>
<style>

.clickthrough1 {

	display: none;
}

#newsListDiv {

	display: none;
}


#article_summary {
	
	
	display: none;
	background-color: pink;
}
</style>


</head>


<body>
<?php include "../navbar.php"; ?>

<h1>1.6.8 Privatisation: Railway Information</h1>

<img src="files/1.6.8great_british_railways.jpg" alt="Great British Railways" style="//max-width: 50%;">
<br>

<iframe width="400" height="300" style = "max-width: 100%;" frameborder="0" src="https://www.bbc.co.uk/news/av-embeds/57176858/vpid/p09j36fq"></iframe>


<p>What is the rationale behind privatisation?</p>
<button onclick="clickthrough('clickthrough1')">Click through answers</button>
<ul>
<li class="clickthrough1">Financial- financial gain from government selling assets.

<li class="clickthrough1">Efficiency improvements-private managers will be more x-efficient.</li>
<li class="clickthrough1">Investment- private profits will help make industries more dynamically efficient.</li>



</ul>



<h2>Videos:</h2>
<ul>
<li>
<a href="https://youtu.be/U6V-HDbX9A8" target ="_blank">Why did we sell off the railways? | FT Feature</a>
</li>
<li>
<a href ="https://youtu.be/Ob6FM5NCJQU" target="_blank">Should our railways be renationalised? - BBC Newsnight</a>
</li>
<li>
<a href ="https://youtu.be/njJ94o1B0qI" target ="_blank">Why are Britain’s trains so bad - could nationalisation fix them?</a>
</li>

</ul>
<!--
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

-->
<h2>More Railway Information:</h2>
<ul>
<li>
<a href ="files/Pocket_%20Nationalisation%E2%80%99s%20high%20short-term%20price%20and%20higher%20long-term%20cost.pdf" target = "_blank">Economist Article: Nationalisation's High Short-Term Price and Higher Long-Term Cost</a>

<button onclick ="toggle_id('article_summary')" id ="toggle_article_summary">Click to See Summary of Article</button>
<div id="article_summary">
<h3>Article Summary: Nationalisation&rsquo;s High Short-Term Price and Higher Long-Term Cost</h3>
<ul>
<li>Labour&rsquo;s manifesto (as of 2017) included nationalising many private industries, for example the water system, energy- supply network, Royal mail, and the railways.</li>
<li>The cost would be high: &pound;60bn for water industry, and &pound;5bn for Royal Mail.</li>
<li>If they were to take back the railways, they could do this for less money by simply taking them back at the end of the franchise running out.
<ul>
<li>However, as the companies knew they would not get the franchise again they would probably cut back on investment.</li>
</ul>
</li>
<li>The long-term damage would mainly be due to the <strong>under-investment and inefficiency</strong> that were problems before privatisation. &ldquo;Satisfaction in railways is higher than in most of Europe.&rdquo;</li>
<li>Counter-arguments about why things should change:
<ul>
<li>Private companies in utilities still rip off customers.</li>
<li>There is a lot of regulation: the &lsquo;super-regulator&rsquo; of CMA, followed by individual regulators e.g. Ofgem. This leads to senior staff who are better at navigating the system rather than thinking about making the system better.</li>
</ul>
</li>
</ul>
</div>

</li>


<li>
<a href ="files/Access%2028%20-%2004%20-%20How%20Privatization%20Became%20a%20Train%20Wreck.pdf" target = "_blank">How Privatisation Became A Train Wreck</a>

</li>

</ul>

<h2>Rail Nationalisation Selected News Stories:</h2>
<button onclick ="toggle()" id="toggleButton">Click to See List</button>
<div id="newsListDiv">
<ul id ="newsList">

</ul>
</div>

<?php include "../footer.php"; ?>

<script>

var index = [
  ["Better rail services promised in huge shake-up","https://www.bbc.co.uk/news/business-57176858","20-May-21"],
  ["There’s nothing ‘great’ about this new British Railways revamp", "https://www.theguardian.com/commentisfree/2021/may/20/great-british-railways-ministers-rail-system-train-companies", "20-May-21"],
  ["Rail franchises axed as help for train firms extended","https://www.bbc.co.uk/news/business-54232015","21-Sep-20"],
  ["Rail nationalisations may be coming down the track","https://www.bbc.co.uk/news/business-54197168","18-Sep-20"],
  ["What has gone wrong with rail franchising?","https://www.bbc.co.uk/news/business-49356029","16-Aug-19"],
  ["Have train fares gone up or down since British Rail?","https://www.bbc.co.uk/news/magazine-21056703","22-Jan-13"]
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


function toggle_id(i) {

	var toggle_div = document.getElementById(i);
	var button = document.getElementById("toggle_"+i);
	
	
	



	if (toggle_div.style.display == "block") {
		
		
		toggle_div.style.display = "none";
		button.innerHTML = "Click to show";
	}

	else {
		
		toggle_div.style.display = "block"
		button.innerHTML = "Click to hide";
	}



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