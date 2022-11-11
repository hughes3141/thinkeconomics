<html>


<head>

<?php include "../header.php";?>


<style>

.countryDiv {

background-color: pink;
border: 2px solid black;
padding: 5px;


}

.countryDiv h2 {
	
	
	margin:0;
}



</style>

</head>


<body>

<?php include "../navbar.php";?>

<h1>Market Economy vs Planned Economy</h1>
<p>Which is a better way of distributing resources- a market economy or a planned economy?</p>
<p>Use the country fact-files to build up evidence to support one side or other in a debate.</p>
<p>Some common things to look for:</p>
<ul>
<li>Structure of the Economy</li>
<li>Real GDP growth rate (an indicator of income growth)</li>
<li>GDP per capita (an indicator of average income)</li>
<li>Gini index- a measurement of inequality (25 is very equal, 67 is very unequal)</li>
<li>Life expectancy at birth</li>
<li>Literacy rate</li>
</ul>

<div class="countryDiv">
<h2>USA:</h2>
<p><a class="overview" target = "_blank" href="https://www.cia.gov/the-world-factbook/countries/united-states/#economy">https://www.cia.gov/the-world-factbook/countries/united-states/#economy</a></p>
<p><a class="data" target = "_blank"  href="http://hdr.undp.org/en/countries/profiles/USA">http://hdr.undp.org/en/countries/profiles/USA</a></p>

</div>
<div class="countryDiv">
<h2>UK</h2>
<p><a class="overview" target = "_blank"  href="https://www.cia.gov/the-world-factbook/countries/united-kingdom/#economy">https://www.cia.gov/the-world-factbook/countries/united-kingdom/#economy</a></p>
<p><a class="data" target = "_blank"  href="http://hdr.undp.org/en/countries/profiles/GBR">http://hdr.undp.org/en/countries/profiles/GBR</a></p>

</div>

<div class="countryDiv">

<h2>Sweden</h2>
<p><a class="overview" target = "_blank"  href="https://www.cia.gov/the-world-factbook/countries/sweden/#economy">https://www.cia.gov/the-world-factbook/countries/sweden/#economy</a></p>
<p><a class="data" target = "_blank"  href="http://hdr.undp.org/en/countries/profiles/SWE">http://hdr.undp.org/en/countries/profiles/SWE</a></p>

</div>


<div class="countryDiv">
<h2>Cuba</h2>
<p><a  class="overview" target = "_blank"  href="https://www.cia.gov/the-world-factbook/countries/cuba/#economy">https://www.cia.gov/the-world-factbook/countries/cuba/#economy</a></p>
<p><a class="data" target = "_blank"  href="http://hdr.undp.org/en/countries/profiles/CUB">http://hdr.undp.org/en/countries/profiles/CUB</a></p>

</div>

<div class="countryDiv">

<h2>North Korea</h2>
<p><a  class="overview" target = "_blank" href="https://www.cia.gov/the-world-factbook/countries/korea-north/#economy">https://www.cia.gov/the-world-factbook/countries/korea-north/#economy</a></p>

</div>

<div class="countryDiv">
<h2>Belarus</h2>
<p><a class="overview" target = "_blank" href="https://www.cia.gov/the-world-factbook/countries/korea-north/#economy">https://www.cia.gov/the-world-factbook/countries/korea-north/#economy</a></p>
<p><a class="data"  target = "_blank"  href="http://hdr.undp.org/en/countries/profiles/BLR">http://hdr.undp.org/en/countries/profiles/BLR</a> &nbsp;&nbsp;</p>

</div>

<div class="countryDiv">
<h2>Japan</h2>
<p><a class="overview" target = "_blank"  href="https://www.cia.gov/the-world-factbook/countries/korea-north/#economy">https://www.cia.gov/the-world-factbook/countries/korea-north/#economy</a></p>
<p><a class="data" target = "_blank"  href="http://hdr.undp.org/en/countries/profiles/JPN">http://hdr.undp.org/en/countries/profiles/JPN</a></p>

</div>

<h2>Explore other countries:</h2>
<p><a target = "_blank" href="https://www.cia.gov/the-world-factbook/countries/">https://www.cia.gov/the-world-factbook/countries/</a></p>
<p><a  target = "_blank" href="http://hdr.undp.org/en/countries">http://hdr.undp.org/en/countries</a></p>

<?php include "../footer.php";?>

<script>

var divs = document.getElementsByClassName("countryDiv");

for(var i=1; i<divs.length; i=i+2)	{

	divs[i].style.backgroundColor = "white";

}

var divs = document.getElementsByClassName("overview");

for(var i=0; i<divs.length; i++)	{

	divs[i].innerHTML = "Economic Overview"

}

var divs = document.getElementsByClassName("data");

for(var i=0; i<divs.length; i++)	{

	divs[i].innerHTML = "UN HDR Data"

}


</script>



</body>


</html>