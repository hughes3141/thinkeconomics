<html>

<head>

<?php include "../header.php"?>

<style>

.exerciseDiv {
	display: none;
}


</style>



</head>

<body>
<?php include "../navbar.php"?>

<h1>Exchange Rate Situational Exercises</h1>
<p>Look at the graphs in the exercises below. Use the information there to answer the questions.</p>

<p>
<button onclick = "divShow(1)" id ="button1">Show information for Exercise 1</button>
<div id="div1" class="exerciseDiv">
<img src="files/234_06.JPG" style="max-width: 100%">
<p>The people of the UK voted to leave the European Union on 23 June 2016. The graph above shows the exchange rate of USD to GBP.</p>
<p>Use an exchange rate diagram to explain why the exchange rate changed.</p>
<p>Source:&nbsp;<a target="_blank" href="https://www.xe.com/currencycharts/?from=GBP&amp;to=USD&amp;view=5Y">www.xe.com/</a></p>
</div>
</p>
<p>
<button onclick = "divShow(2)" id ="button2">Show information for Exercise 2</button>
<div id="div2" class="exerciseDiv">

<img src="files/234_07.JPG" style="max-width: 100%">

<p>This graph shows the value of several currencies against the USD (in index form).</p>
<p>The graph also shows the price of Brent Crude Oil, the wholesale global market price for oil.</p>
<p>Each of the countries listed is an exporter of oil.</p>
<p>For a country of your choice, use an exchange rate diagram to explain why the exchange rate has changed.</p>
<p>Source: <a target="_blank" href="https://www.economist.com/news/finance-and-economics/21674775-currency-pegs-are-still-fashion-some-are-creaking-pegs-under-pressure">www.economist.com</a> </p>

</div>

<p></p>
<button onclick = "divShow(3)" id ="button3">Show information for Exercise 3</button>
<div id="div3" class="exerciseDiv">

<img src="files/234_08.JPG" style="max-width: 100%">

<p>During 2017 there was strong growth in the global economy.</p>
<p>Interest rates rose in Canada and Britain.</p>
<p>The ECB and Japan&rsquo;s central bank reduced their QE programmes.</p>
<p>Use an exchange rate diagram to explain what has happened to the USD in 2017.</p>
<p>Source: <a target="_blank" href="https://www.economist.com/news/leaders/21735024-whether-currency-cheap-or-dear-not-always-good-guide-its-fortunes-it-now-value">www.economist.com</a></p>


</div>

<p></p>
<button onclick = "divShow(4)" id ="button4">Show information for Exercise 4</button>
<div id="div4" class="exerciseDiv">

<img src="files/234_09.JPG" style="max-width: 100%">

<p>Consider the following facts about 2017:</p>
<ul>
<li>Marine Le Pen lost the French election, running on an anti-Euro platform.</li>
<li>The Euro-zone economy showed strong signs of growth.</li>
<li>People began to wonder if the ECB would push up interest rates.</li>
<li>America&rsquo;s economy has been growing by less than expected.</li>
<li>America has been running a trade deficit, and Europe has been running a trade surplus.</li>
</ul>
<p>Use an exchange rated diagram to explain what has happened to the Euro/Dollar exchange rate.</p>
<p>Soure: <a target="_blank" href="https://www.economist.com/news/finance-and-economics/21728629-euros-strength-and-dollars-weakness-have-had-benign-effects-exchange-rate">www.economist.com</a></p>

</div>

<p></p>
<button onclick = "divShow(5)" id ="button5">Show information for Exercise 5</button>
<div id="div5" class="exerciseDiv">

<p>Extension:</p>

<img src="files/234_10.JPG" style="max-width: 100%">

<p>The VIX volatility index measures global investor fear.</p>
<p>Explain why changes in global investor fear will affect two different currencies (e.g. the Japanese Yen and the South African Rand</p>

</div>
</p>

<?php include "../footer.php"?>


<script>

var toggle = [0,0,0,0,0];

function divShow(i) {

var div = document.getElementById("div"+i);
var button = document.getElementById("button"+i);

if (toggle[(i-1)] == 0) {

	div.style.display = "block";
	button.innerHTML = "Hide information for Exercise "+i;
	toggle[(i-1)] =1;
	}
	
	else {
	div.style.display = "none";
	button.innerHTML = "Show information for Exercise "+i;
	toggle[(i-1)] =0;
	
	}




}



</script>

</body>



</thml>