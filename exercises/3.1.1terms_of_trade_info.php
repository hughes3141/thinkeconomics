<!DOCTYPE html>


<html lang="en">

<head>

<?php include "../header.php"; ?>

<style>

@media screen and (max-width: 400px) {
    iframe {
        //max-width: 100% !important;
        //width: auto !important;
        //height: auto;
		
		height: 200px;
    }
}

img {
	width: 600px;
	max-width: 100%;
}

iframe:not(#worldBankEmbed) {
	max-width: 100%;
	//height: auto;
	//min-height: 200px;
}

</style>


</head>

<body>

<?php include "../navbar.php"; ?>

<h1>Terms of Trade: Data</h1>

<h2>United Kingdom:</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedkinteroftra&v=202107132317V20200908&d1=19970201&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-kingdom/terms-of-trade'>tradingeconomics.com</a>

<h2>United States:</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=unitedstateroftra&v=202112271718V20200908&d1=19970201&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/united-states/terms-of-trade'>tradingeconomics.com</a>

<h2>Australia:</h2>

<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=australiateroftra&v=202112291825V20200908&d1=19970201&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/australia/terms-of-trade'>tradingeconomics.com</a>
<h2>(Copper Prices):</h2>
<img src="files/3.1.1_02.JPG" alt="Copper Prices: 1997-2022">

<h2>Norway:</h2>
<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=norwayteroftra&v=202201221003V20200908&d1=19970201&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/norway/terms-of-trade'>tradingeconomics.com</a>

<h2>(Oil Prices):</h2>
<img src="files/3.1.1_01.JPG" alt="Oil Prices: 1997-2022">

<h2>South Korea:</h2>
<iframe src='https://d3fy651gv2fhd3.cloudfront.net/embed/?s=southkoreteroftra&v=202201041612V20200908&d1=19970201&h=300&w=600' height='300' width='600'  frameborder='0' scrolling='no'></iframe><br />source: <a href='https://tradingeconomics.com/south-korea/terms-of-trade'>tradingeconomics.com</a>

<h2>Terms of Trade (Selected Countries):</h2>

<iframe id="worldBankEmbed" src="https://data.oecd.org/chart/6B37" width="860" height="645" style= "min-width: 582" style="border: 0" mozallowfullscreen="true" webkitallowfullscreen="true" allowfullscreen="true"><a href="https://data.oecd.org/chart/6B37" target="_blank">OECD Chart: Terms of trade, Total, Ratio, Annual, 2006 – 2020</a></iframe>
<p>Compare others on the link included here: <a href="https://data.oecd.org/chart/6B37" target="_blank">OECD Data</p>
<?php include "../footer.php"; ?>
</body>

</html>

	
	
	