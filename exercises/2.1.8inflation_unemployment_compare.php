<html>


<head>
<?php include "../header.php"; ?>

<style>

.countryDiv {

width: 600; border: 1px solid black; padding: 5px; margin: 5px; max-width: 90%;
}

table {
	border-collapse: collapse;
	width: 350px;

	}
	
td, th {
	border: 1px solid black;
	padding: 4px;
	vertical-align:top
	}
	
th {
	
}

iframe {
	
	max-width: 100%;
}

</style>

</head>


<body>
<?php include "../navbar.php"; ?>

<h1>2.1.8 Comparison Between Inflation and Unemployment</h1>
<p>Use the graphs to explaion the relationship between inflation and unemployment in the countries listed. Can you explain any patterns here using historical context?</p>



<h2>Countries:</h2>
<ul>
<li><a href="#uk">UK</a></li>
<li><a href="#usa">USA</a></li>

<li style="display:none;"><a href="#euroarea">Euro Area</a></li>

<li style="display:none;"><a href="#australia">Australia</a></li>
<li style="display:none;"><a href="#japan">Japan</a></li>
<li style="display:none;"><a href="#china">China</a></li>
</ul>


<div  class="countryDiv" id="uk">
<h2>The United Kingdom</h2>
<img src="files/2.1.8_03.png" alt="UK Inflation and Unemployment: 1971-2020">
source: <a href = "https://www.ons.gov.uk/timeseriestool?query=CZBH,BCJE" target="_blank">ONS</a>
<!--
<h2 style ="text-align: center;">United Kingdom Unemployment Rate (&percnt;)</h2>




<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukueilor&v=202112140748V20200908&d1=19910101&h=300&w=600' height='300' width='600'  style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />

source: <a href='https://tradingeconomics.com/united-kingdom/unemployment-rate'>tradingeconomics.com</a>


<h2 style ="text-align: center;">United Kingdom Annual Inflation Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukrpcjyr&v=202112091308V20200908&d1=19910101&h=300&w=600' height='300' width='600' style="max-width: 100%;"  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/inflation-cpi'>tradingeconomics.com</a>

source: <a href='https://tradingeconomics.com/united-kingdom/inflation-cpi'>tradingeconomics.com</a>

-->


</div>


<div class="countryDiv" class="countryDiv" id="usa">
<h2 style ="text-align: center;">United States Unemployment Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=usurtot&v=202112031345V20200908&d1=19500109&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />

source: <a href='https://tradingeconomics.com/united-states/unemployment-rate'>tradingeconomics.com</a>

<h2 style ="text-align: center;">United States Annual Inflation Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=cpi+yoy&v=202112101416V20200908&d1=19500109&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />


source: <a href='https://tradingeconomics.com/united-states/inflation-cpi'>tradingeconomics.com</a>


</div>

<div class="countryDiv" class="countryDiv" id="euroarea" style="display:none;">
<h2 style ="text-align: center;">Euro Area Unemployment Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=eurr002w&v=202104262315V20200908&d1=20070427&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/euro-area/interest-rate'>tradingeconomics.com</a>

<h2 style ="text-align: center;">Euro Area Annual Inflation Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=eccpemuy&v=202104262315V20200908&d1=20070427&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/euro-area/inflation-cpi'>tradingeconomics.com</a>


</div>


<div class="countryDiv" class="countryDiv" id="australia" style="display:none;">
<h2 style ="text-align: center;">Australia Unemployment Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=rbatctr&v=202104262315V20200908&d1=20070427&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/australia/interest-rate'>tradingeconomics.com</a>

<h2 style ="text-align: center;">Australia Annual Inflation Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=aucpiyoy&v=202104262315V20200908&d1=20070427&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/australia/inflation-cpi'>tradingeconomics.com</a>


</div>


<div class="countryDiv" class="countryDiv" id="japan" style="display:none;">
<h2 style ="text-align: center;">Japan Interest Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=bojdtr&v=202104270346V20200908&d1=19900427&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/japan/interest-rate'>tradingeconomics.com</a>

<h2 style ="text-align: center;">Japan Annual Inflation Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=jncpiyoy&v=202104262315V20200908&d1=19900427&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/japan/inflation-cpi'>tradingeconomics.com</a>

</div>


<div class="countryDiv" class="countryDiv" id="china" style="display:none;">
<h2 style ="text-align: center;">China Interest Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=chlr12m&v=202104262315V20200908&d1=20140101&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/china/interest-rate'>tradingeconomics.com</a>

<h2 style ="text-align: center;">China Annual Inflation Rate (&percnt;)</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=cncpiyoy&v=202104262315V20200908&d1=20140101&d2=20310427&h=300&w=600' height='300' width='600' style="max-width: 100%;" frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/china/inflation-cpi'>tradingeconomics.com</a>

</div>



<?php include "../footer.php"; ?>
<script>


var password = <?php include "password.php" ?>;

var passed = true;


function passwordPrompt() {

 var promptBox = prompt("Password for hints:");
  if (promptBox != null) {
   if (promptBox == password) {
		passed = true;
		}
	else {
		passed = false}
  }



}
	
function answer(i) {

	if (passed == false) {

	passwordPrompt();
	}
	
	if (passed == true) {

	

	var b = document.getElementById("button");

	
	
	
	if (b.innerHTML == "Click for Hints") {
	
		var a = document.getElementById("hints");
		a.style.display = "block";
		b.innerHTML="Click to Hide";
		}
		
	
	else if (b.innerHTML == "Click to Hide") {
	
		var a = document.getElementById("hints");
		a.style.display = "none";
		b.innerHTML="Click for Hints";
		}
	}


}


</script>


</body>


</html>