<html>

<head>
<?php include "../header.php"; ?>

<style>
.floatRight {float: right;
width: 600;
max-width: 95%;
margin: 10px;}




</style>

</head>


<body>

<?php include "../navbar.php"; ?>

<h1>Transmission Mechanism of Monetary Policy</h1>
<img class="floatRight" src="files/232_9.jpg">
<p>Monetary policy is the process by which the Bank of England sets the interest rate &ndash; and sometimes carries out other measures &ndash; in order to reach a target rate of inflation.</p>
<p>The target rate of inflation is 2.0%, measured by Consumer Prices Index. This a <strong>symmetric target</strong> because it should neither be too high or too low of this target rate (+/- 1.0%).</p>
<p>The Monetary Policy Committee of the Bank of England meets eight times per year to set the official bank rate.</p>
<p>The way the bank rate affects the economy is known as the <em>transmission mechanism of monetary policy</em><strong>. </strong>It is useful to know this so that you can really expand on your analysis of monetary policy.</p>

<img  src="files/232_10.jpg" style="clear:both; width:100%; height:auto">
<p>Fill in the above diagam with the following items:</p>
<ul>
<li>Interest rates rise</li>
<li>Market rates rise</li>
<li>Asset prices fall</li>
<li>Expectations/Confidence Falls</li>
<li>Exchange rate rises</li>
<li>Domestic demand falls</li>
<li>Net external demand falls</li>
<li>Total demand falls</li>
<li>Domestic inflationary pressure falls</li>
<li>Import prices fall</li>
<li>Inflation falls</li>
</ul>
<h2>Explanation</h2><p>Next, explain the links in the diagram by answering these questions:</p>
<p><span style="text-decoration: underline;">If the Bank of England lowers its official rate . . .</span></p>
<ol>
<li>What happens to market rates? Why?</li>
<li>What happens to asset prices? Why?</li>
<li>What happens to expectations/confidence? Why?</li>
<li>What happens to the exchange rate? Why?</li>
</ol>
<p><span style="text-decoration: underline;">As a result of these changes:</span></p>
<ol>
<li>What happens to domestic demand (C+I)?</li>
<li>What happens to net external demand (X-M)?</li>
<li>What happens to total demand and domestic inflationary pressure?</li>
<li>As a result of higher exchange rate, what happens to import prices?</li>
<li><strong>Draw an AS/AD diagram to show the effects of these changes, and how it has meant that inflation will go up.</strong></li>
</ol>
<button onclick = "key()">Click to <span id="showHide">show</span> diagram key</button>
<img id="key" src="files/232_11.jpg" style="clear:both; width:100%; height:auto; display:none">
<?php include "../footer.php"; ?>


</body>
<script>
var count = 0;
function key() {

var img = document.getElementById("key");
var showHide = document.getElementById("showHide");



if (count == 0) {
	img.style.display = "inline-block";
	count = 1;
	showHide.innerHTML = "hide"}
	
else if (count == 1) {
	img.style.display = "none";
	count = 0;
	showHide.innerHTML = "show"}

console.log(count);
}

</script>
</html>