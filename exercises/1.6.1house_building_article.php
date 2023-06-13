<html>

<head>
<?php include "../header.php";?>

<style>

.answer {

background-color: pink;
margin: 10px;
display: none;
padding:10px;


}

</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php";?>

<div id="main_div">

<h1 class><span id ="page_title"></span></h1>
<a href = "files/Why British housebuilders are making such juicy profits.pdf" target = "_blank" ><img src = "files/1.6.1_2.JPG" style="max-width: 100%;"></a><br>
<a href = "files/Why British housebuilders are making such juicy profits.pdf" target = "_blank" >PDF: Why British housebuilders are making such juicy profits</a>


<h2>Instructions</h2>
<p>Click on the link above to access the PDF to the article: Why British housebuilders are making such juicy profits.</p>

<p>As you read answer the questions below.</p>
<p>You can check your answers by clicking on the buttons beneath each question.</p>



</div>

<?php include "../footer.php";?>

<script>

/*

This document was created using questions_template1.2.html

INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS 

1. Construct questions and answers in word document.
2. Convert to Array using the following:
	https://shancarter.github.io/mr-data-converter/
	Output as JSON-Row arrays
3. Change variable "page_title" to the title of the page.
4. Change array "index" to the question-answer index.
*/

var page_title = "British Housebuilders: Article Questions";
var root ="images/"
var index = [

["<p>What is the evidence, and what are some possible explanations, for why British housebuilding companies are doing so well, as mentioned in the first two paragraphs?</p>",
"<p>Evidence:</p><ul><li>Persimmon, the largest housebuilder, posted profits of &pound;1.1bn in 2018, the highest ever.</li><li>Operating margins are high, twice what they are in America.</li><li>Dividends are high, as are levels of cash.</li><li>Senior managers are being paid investment-banker salaries.</li></ul><p>Possible reasons:</p><ul><li>They are now better-managed; they are less laden with debt now than before the financial crisis of 2008-2009.</li><li>They have come up with new production methods that require lower costs of production.</li><li>They are selling more units, up by 200,000 in 2018.</li></ul>"]
,
["<p>Paragraph 3 mentions the &ldquo;Help to Buy&rdquo; scheme, a mortgage-subsidy scheme for new buyers, raising the price of houses by 5%. Use a supply-demand diagram to explain why making mortgages cheaper would raise house prices.</p>"
,
"<img src='files/1.6.1_1.JPG'><p>Government subsidy for mortgages will, as the article states, raise the purchasing power of potential new-home buyers. This effectively increases their income, which will shift demand to the right. Another way to see it is that the price of a complementary product, mortgages, has decreased, which will shift demand for houses to the right. Following the shift in demand from D1 to D2, there will now be excess demand of Q3-Q1 at price P1. This will put upwards pressure on the price until a new equilibrium is reached, at Q2P2. Given that the market for houses is fairly price inelastic in supply, the effect of the government subsidy has done little to increase the number of houses bought (small increases from Q1 to Q2) while there has been a large increase in price (from P1 to P2), mentioned in the article as 5%.</p>"]
,
["<p>Paragraph 4 mentions that the market for housebuilding has become more concentrated: between 1980 and 2019 the share of the market taken up by large builders has increased from 50% to 90%.</p><p>Paragraphs 4-6 mention several types of advantages that large builders have in the housing market. Summarise and explain these.</p>"
,
"<p>Barriers to entry:</p><ul><li>The planning process has become more complex, involving time-consuming appeals to have projects approved. Only large firms are able to have the expertise and resources required to have projects approved.</li><li>Big builders acquire large plots of land in a local area, then develop them slowly. This will mean there is less land available to smaller builders.</li><li>Because there are only a few big builders now, there is less competition when sellers sell land for residential development. This means that large builders are able to bargain down the prices they get land for, with the result being that residential-land prices are now 30% below their historical relationship with house prices.</li></ul>"]
, 
["<p>Paragraph 7, the final paragraph, suggests ways the government could lower &lsquo;barriers to entry&rsquo; for smaller builders. Summarise these.</p>"
,
"<ul><li>&lsquo;Doling out&rsquo; (i.e. selling) smaller plots of developable land, which would eliminate the advantage that large builders have over smaller ones. Transport for London is already trying this.</li><li>Publish more data on the land market, to ensure that everybody knows the fair price.</li></ul>"]
,
["<p>&ldquo;The industry needs new firms to enter the market and compete away excess profits.&rdquo; Explain who would benefit most if this were to happen. Evaluate the extent to which this would be a good thing.</p>"
,
"<p>The group most likely to benefit from more competition would be UK house buyers. More competition would reduce the monopoly position of large housebuilders, meaning they could no longer charge such high prices. The fact that there are excess profits in the industry suggest that existing housebuilders are charging prices which are above the allocatively efficient price. Increased competition would lower prices and increase consumer surplus, as existing consumers would receive a lower price and new customers would be able to purchase a house.</p><p>It may be the case that British housebuilders are reinvesting their excess profit in ways that benefit consumers in the long term. For example, perhaps these profits are going into innovative processes such as the &lsquo;lowered pitched roofs&rsquo; that are mentioned in the article. This would be a form of dynamic efficiency, and if these innovations led to long-term decreases in price then ultimately consumers benefit from the monopoly position of the housebuilders.</p><p>Overall, it seems clear that more competition would be desirable for the market. This is because the article suggests that it is mainly behavioural barriers to entry which are inflating prices and profits in the industry, to the detriment of consumers. It seems unlikely that long-term innovation in the market for housebuilding, which is a relatively un-dynamic market, will offset the loss to consumer surplus which results from artificially high prices today.</p>"]



]





function populate() {

document.getElementById("page_title").innerHTML= page_title;



	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("main_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.innerHTML = i+1+": "+index[i][0];

	question.style = "margin:10px;";
	
	
	
	var button = document.createElement("button");
	button.innerHTML = "Click for Answer";
	button.setAttribute("onclick","answer("+i+")");
	button.setAttribute("id", "b"+i);
	question.appendChild(button);
	


	var answer = document.createElement("div");
	answer.setAttribute("id", "a"+i);
	answer.setAttribute("class", "answer");
	answer.innerHTML = index[i][1];
	
	
	
	

	main_div.appendChild(question);
	main_div.appendChild(answer);
	
	
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