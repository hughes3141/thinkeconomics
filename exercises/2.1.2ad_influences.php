<!DOCTYPE html>

<html lang="en">


<head>

<?php include "../header.php"; ?>

<style>

/* Style the buttons that are used to open and close the accordion panel */
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .accordion:hover {
  background-color: #ccc;
}

/* Style the accordion panel. Note: hidden by default */
.panel {
  padding: 0 0 0 18px;
  background-color: white;
  display: none;
  overflow: hidden;
}

.accordion:after {
  content: '\02795'; /* Unicode character for "plus" sign (+) */
  font-size: 13px;
  color: #777;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2796"; /* Unicode character for "minus" sign (-) */
}

.top {
  background-color: pink;
  font-size: large;
  
}

iframe {
	max-width: 100%;
}

</style>


</head>



<body>
<?php include "../navbar.php"; ?>
<h1>2.1.2 Influences on AD</h1>





<p><span>AD = C + I + G + (X-M)</span></p>
<p>
  <a href="https://commonslibrary.parliament.uk/research-briefings/sn02787/" target="_blank">Components of GDP (Link)</a>
</p>

<button class="accordion top">Consumer Expenditure</button>
<div class="panel">
  <h2>Consumer Expenditure</h2>
  <div>
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinconspe&v=202201201746V20200908&d1=19970128&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/consumer-spending'>tradingeconomics.com</a>
  </div>
  <button class="accordion">Consumer Expenditure as &percnt; of GDP (Selected Countries)</button>
  <div class="panel">
    <iframe src="https://data.worldbank.org/share/widget?end=2020&indicators=NE.CON.PRVT.ZS&locations=GB-US-CN-IN-RU&start=2005&view=chart" width='600' height='400' frameBorder='0' scrolling="no" ></iframe>
  
  </div>
  <button class="accordion">Income (GDP) and Consumer Expenditure</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukgrybzq&v=202112220753V20200908&d1=19970127&type=type=column&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/gdp-growth'>tradingeconomics.com</a>
  </div>
  

  <button class="accordion">Disposable Income and Consumer Expenditure</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkindisperinc&v=202201201746V20200908&d1=19970202&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/disposable-personal-income'>tradingeconomics.com</a>
  </div>
  
  
  
  <button class="accordion">UK Interest Rate and Consumer Expenditure</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukbrbase&v=202112161224V20200908&d1=19970127&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/interest-rate'>tradingeconomics.com</a>
  </div>
  
  <button class="accordion">Consumer Confidence and Consumer Expenditure</button>
  <div class="panel">
  
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukcci&v=202201210041V20200908&d1=19970127&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/consumer-confidence'>tradingeconomics.com</a>
	<!-- alternate start date: 20120124 -->
  </div>
  
  
  <button class="accordion">Wealth (House Prices) and Consumer Expenditure</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinhouind&v=202201201757V20200908&d1=19970202&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/housing-index'>tradingeconomics.com</a>
    <img src="files/2.1.2_03.jpg" alt="House Prices">
	<img src="files/2.1.2_04.jpg" alt="House Prices and Assets. Sources: https://www.economist.com/special-report/2020/01/16/how-housing-became-the-worlds-biggest-asset-class, https://www.economist.com/special-report/2020/01/16/housing-is-at-the-root-of-many-of-the-rich-worlds-problems">
  </div>
  
  <button class="accordion">Wealth (Stock Market) and Consumer Expenditure</button>
  <div class="panel">
  
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinconspe&v=202201201746V20200908&d1=19970202&title=false&url2=/united-kingdom/stock-market&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/consumer-spending'>tradingeconomics.com</a>
  </div>
  
  <button class="accordion">Availability of Credit and Consumer Expenditure</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinconcre&v=202201201748V20200908&d1=19970202&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/consumer-credit'>tradingeconomics.com</a>
    <p>Consumer credit (excluding student loans) is defined as borrowing by UK individuals to finance current expenditure on goods and/or services excluding loans issued by the Student Loans Company. Consumer credit (excluding student loans) is split into two components; credit card lending and ‘other’ lending (mainly overdrafts and other loans/advances).</p>

  
    <a href="https://www.bbc.co.uk/news/av/business-23334314/a-look-at-personal-debt-around-the-world" target="_blank">A look at personal debt around the world</a>
	
  </div class="panel">
  
  <button class="accordion">Household Debt and Consumer Expenditure</button>
  <div class="panel">
  
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinhdtg&v=202201201747V20200908&d1=19970202&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/households-debt-to-gdp'>tradingeconomics.com</a>
	
  </div>
  
  <button class="accordion">Household Saving and Consumer Expenditure</button>
  <div class="panel">
  
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinpersav&v=202201201746V20200908&d1=19970202&title=false&url2=/united-kingdom/consumer-spending&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/personal-savings'>tradingeconomics.com</a>
    <p>In the United Kingdom, the saving ratio estimates the amount of money households have available to save as a percentage of their gross disposable income plus pension accumulations.</p>

	
  </div>
  
  <button class="accordion">Cultural Attitudes and Consumer Expenditure</button>
  <div class="panel">
    <a href="https://www.bbc.co.uk/news/av/business-25309669/china-s-consumer-spending-drive" target="_blank">China's consumer spending drive</a>
  </div>


</div>
<button class="accordion top">Investment</button>
<div class="panel ">
  <h2>Investment</h2>
  <!--
  <div>
	<img src="files/2.1.2_01.jpg" alt="UK Investment" style="width: 600px;">
  </div>
  <br>
  -->
  <div>
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkingrofixcapfo&v=202201200940V20200908&d1=19970201&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/gross-fixed-capital-formation'>tradingeconomics.com</a>
  </div>
  <button class="accordion">Investment as &percnt; of GDP (Selected Countries)</button>
  <div class="panel">
    <iframe src="https://data.worldbank.org/share/widget?end=2020&indicators=NE.GDI.FTOT.ZS&locations=GB-US-CN-TH&start=2004" width='600' height='400' frameBorder='0' scrolling="no" ></iframe>
  </div>
  
  <button class="accordion">GDP Growth (Income) and Investment</button>
  <div class="panel">
     <!--<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukgrybzq&v=202112220753V20200908&d1=19970127&type=type=column&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/gdp-growth'>tradingeconomics.com</a>
	 -->
	 <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukgrybzq&v=202112220753V20200908&d1=19970201&type=type=column&title=false&url2=/united-kingdom/gross-fixed-capital-formation&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/gdp-growth'>tradingeconomics.com</a>
  </div>
  
  <button class="accordion">New Orders and Investment</button>
  <div class="panel">
     <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinneword&v=202111131004V20200908&d1=19970202&title=false&url2=/united-kingdom/gross-fixed-capital-formation&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/new-orders'>tradingeconomics.com</a>
      <p>In the United Kingdom, because new orders heavily affect business confidence they are a leading indicator for growth in gross domestic product.</p>

  </div>
  
  <button class="accordion">UK Interest Rate and Investment</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=ukbrbase&v=202201261218V20200908&d1=19970201&title=false&url2=/united-kingdom/gross-fixed-capital-formation&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/interest-rate'>tradingeconomics.com</a>
  </div>
  <button class="accordion">Business Confidence and Investment</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=eur1uk&v=202201251119V20200908&d1=19970201&title=false&url2=/united-kingdom/gross-fixed-capital-formation&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/business-confidence'>tradingeconomics.com</a>
  </div>
  <button class="accordion">Corporate Profits and Investment</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkincorpro&v=202201201738V20200908&d1=19970201&title=false&url2=/united-kingdom/gross-fixed-capital-formation&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/corporate-profits'>tradingeconomics.com</a>
  </div>

</div>
<button class="accordion top">Government Spending</button>
<div class="panel">
  <h2>Government Spending</h2>
  <button class="accordion">Government Spending (% of GDP)</button>
  <div class="panel">
	<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkigovspetogdp&v=202110271310V20200908&d1=19970127&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/government-spending-to-gdp'>tradingeconomics.com</a>
  </div>
  <button class="accordion">Government Spending (Total Figures)</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkingovspe&v=202201201726V20200908&d1=19970127&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/government-spending'>tradingeconomics.com</a>
  </div>
  

</div>
<button class="accordion top">Net Exports</button>
<div class="panel">
  <h2>Net Exports</h2>
  <div>
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=uktbttba&v=202201201542V20200908&d1=19970128&type=type=column&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/balance-of-trade'>tradingeconomics.com</a>
  </div>
  <button class="accordion">Net Trade in Goods and Services (Selected Countries)</button>
  <div class="panel">
    <iframe src="https://data.worldbank.org/share/widget?end=2020&indicators=BN.GSR.GNFS.CD&locations=CN-GB-US-DE&start=2004" width='600' height='400' frameBorder='0' scrolling="no" ></iframe>
  </div>
  
  <button class="accordion">Income (GDP Growth) and Net Exports</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=uktbttba&v=202201201542V20200908&d1=19970127&type=type=column&title=false&url2=/united-kingdom/gdp-growth&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/balance-of-trade'>tradingeconomics.com</a>
  </div>
  
  <button class="accordion">Disposable Personal Income and Net Exports</button>
  <div class="panel">
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=uktbttba&v=202201201542V20200908&d1=19970202&type=type=column&title=false&url2=/united-kingdom/disposable-personal-income&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/balance-of-trade'>tradingeconomics.com</a>
  </div>
  
  <button class="accordion">Exchange Rate and Net Exports</button>
  <div class="panel">
  
    <iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=uktbttba&v=202201201542V20200908&d1=19970202&type=type=column&title=false&url2=/united-kingdom/currency&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/balance-of-trade'>tradingeconomics.com</a>
  
    <br>
    <img src="files/2.1.2_02.jpg" alt="GBP to USD 1997-2022" style="width: 600px;">
	
  </div>

</div>

<?php include "../footer.php"; ?>

<script>




var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}


</script>

</body>

</html>