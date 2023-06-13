<html>

<head>


<?php include "../header.php"; ?>

<style>



</style>

</head>


<body onload = "populate()">


<?php include "../navbar.php"; ?>


<div class="pagetitle"><span id ="page_title"></span></div>





</div>

<?php include "../footer.php"; ?>

<script>

/*
INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS 

1. Construct questions and answers in word document.
2. Convert to Array using the following:
	https://shancarter.github.io/mr-data-converter/
	Output as JSON-Row arrays
3. Change variable "page_title" to the title of the page.
4. Change array "index" to the question-answer index.
*/

var page_title = "3.3.1 Measurement of Development: Summary Questions";
var root ="files/"
var index = [ ["Mozambique&rsquo;s GDP/Capita is $650 but GNI/Capita is $1,151. Explain the possible reason for this difference. (2)","GNI per capita is higher than GDP per capita. This suggests that there is a positive net income from abroad. This could be explained if the citizens of Mozambique were receiving remittances from family members working abroad. This would mean that incomes for citizens in Mozambique are higher than what is generated in the country by domestically based factors of production. It could also be the case that Mozambique is earning income from factories which are producing materials abroad, but are owned by citizens of Mozambique.",""], ["Kazakhstan&rsquo;s GDP/Capita is $11,568 but GNI/Capita is only $10,451. Explain the possible reason for this difference. (2)","GDP per capita is higher than GNI per capita. This suggests that there is a negative net income from abroad. In other words, goods are produced in Kazakhstan (contributing to GDP) but the income from these goods (i.e. the profit made from producing them) goes to foreign owners. Alternatively, it may be that people in Kazakhstan are sending their incomes to families in other countries.",""], ["Briefly explain three reasons that higher GNI might be expected to lead to higher living standards in an economy. (6)","Higher GNI per capita will enable the population to afford better healthcare, meaning that life expectancy will be longer. Higher GNI per capita will enable citizens to encourage their children to attend school, which will improve the years of schooling in the country (and give citizens a more fulfilled life). Higher GNI will also enable citizens to be able to purchase the types of conveniences and luxuries (e.g. washing machines) that makes life easier.",""], ["With reference to the chart, discuss the extent to which GNI per capita is a good indicator of living standards within a country. (8)","GNI is largely a good indicator of living standards in a country. This is shown by the strong positive correlation between the two variables. The richest countries such as the UK and Norway, have the highest scores on the Human Development index. Indeed, GNI per capita is a component of the index. However, there are outliers. Equatorial Guinea is a relatively rich country, yet it has the same HDI score as India, which is has lower income measured as GNI per capita. This may be due to the fact that income in Equatorial Guinea is unevenly distributed; as a country which relies heavily on petroleum for its economic output, it is likely that this industry concentrates income in a relatively small proportion of the population, and the effects of rising income are not felt by most citizens of the country. Another outlier is Cuba: despite having relatively lower incomes, they score in the &lsquo;High&rsquo; region of the HDI. This is likely because Cuba has invested heavily in education and health programmes for its population. Despite low incomes, all Cubans have access to these facilities which will raise their standard of living.","331_1"], ["Explain what is meant by GDP per head adjusted for purchasing power parity (PPP). (2)","GDP per head adjusted for Purchasing Power Parity (PPP) means that the income per capita is adjusted using an exchange rate that equalises a basket of goods in both countries. Using the data it is clear that incomes in the UK are higher than those in India in US dollars: $44,000 compared with $1,000. However, adjusting for PPP makes UK income $36,000 per capita and India income $3,000 per capita. This suggests that prices of similar goods are more expensive in the UK than they are in India, so PPP adjustments reflect this and make Indian income appear to be higher.","331_2"], ["Chad and Swaziland are both LEDCs located in sub-Saharan Africa. Based on the data above, discuss the extent to which it is fair to conclude that living standards in Swaziland are higher than those in Chad? (8)","Both Swaziland and Chad would rank as Low Development Countries as rated by the United Nations, as they both have HDI below 0.55. However, Swaziland has a higher HDI figure, suggesting that it has a higher level of development, and this is supported by the data. The most striking difference is the level of education in Swaziland compared to Chad: Swaziland ranks significantly higher in all three listed statistics (MYS, EYS, and adult literacy rate) (though only MYS and EYS are included in HDI). Swaziland has better health infrastructure, given that it spends more of its GDP on health and has a much lower infant mortality rate than Chad. Swaziland also has a much higher GNI per capita figure when compare with Chad. The only statistic in which Chad is favourable compared with Swaziland is life expectancy, with 51.18 in Chad compared with 49 in Swaziland. This is probably due to the high prevalence of HIV in Swaziland, at 26.5% compared with 2.7% in Chad. This probably also accounts for the higher level of healthcare expenditure in Swaziland. Despite this I would still say it is fair to conclude that living standards in Swaziland are better than those in Chad; so long as an individual does not contract HIV, Swaziland appears to offer a higher standard of living.","331_3"], ["MCQ","The answer is A. This question pretty much explains exactly GNI must be adjusted at PPP; because if an individual has a high income in a country with high costs of living, then their income will appear overly-high compared with an individual with a low income in a country with low costs of living. PPP adjusts the figures to reflect costs of living.","331_4"], ["MCQ","The answer is B. This is because GDP includes production in a country, but if the profits of the multinational operating in the country are then sent (repatriated) abroad, then it will not count in the country&rsquo;s GNI/GNP figures.","331_5"] ]




function populate() {

document.getElementById("page_title").innerHTML= page_title;



	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("main_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.innerHTML = i+1+": "+index[i][0];
	question.appendChild(document.createElement("br"));
	question.style = "margin:10px; overflow: hidden; line-height: 1.6; border: 1pt black solid; padding; 5px;";
	
	
	
	var button = document.createElement("button");
	button.innerHTML = "Click for Answer";
	button.setAttribute("onclick","answer("+i+")");
	button.setAttribute("id", "b"+i);
	question.appendChild(button);
	
	if (index[i][2] !== "") {
	var img = document.createElement("img");
	img.src = root+index[i][2]+".jpg";
	/*
	img.style.width = "500px";
	img.style.height = "400px"; */
	img.style.margin = "10px";
	img.style.float ="right";

	question.appendChild(img);
	}

	var answer = document.createElement("div");
	answer.setAttribute("id", "a"+i);
	answer.innerHTML = index[i][1];
	answer.style.backgroundColor = "pink";
	answer.style.margin = "10px";
	answer.style.display = "none";
	
	
	question.appendChild(answer);

	main_div.appendChild(question);
	
	
	
	}


}	
	
function answer(i) {

	

	var b = document.getElementById("b"+i);

	
	
	
	if (b.innerHTML == "Click for Answer") {
	
		var a = document.getElementById("a"+i);
		a.style.display = "block";
		b.innerHTML="Click to Hide";
		}
		
	
	else if (b.innerHTML == "Click to Hide") {
	
		var a = document.getElementById("a"+i);
		a.style.display = "none";
		b.innerHTML="Click for Answer";
		}



}
	
</script>


</body>

</html>