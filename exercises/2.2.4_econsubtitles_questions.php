<html>

<head>
<?php include "../header.php";?>

<style>



</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php";?>


<div class="pagetitle"><span id ="page_title"></span></div>

<a href = "https://www.bbc.co.uk/sounds/play/b0bfwvz7" target = "_blank" >Link: Economics with Subtitles: How Condoms Can Cost A Week's Wages</a>
<a href = "https://www.bbc.co.uk/sounds/play/b0bfwvz7" target = "_blank" ><img src = "files/234_title.JPG" style="max-width: 100%;"></a>

<h1>Instructions</h1>
<p>Click on the link above to access the radio programme &ldquo;The Price of Stuff: How Condoms Can Cost A Week&rsquo;s Wages&rdquo;, originally broadcast on BBC Radio 4 in August 2018.</p>
<p>As you listen answer the questions below.</p>
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

var page_title = "Economics with Subtitles: Inflation Questions";
var root ="images/"
var index = [
  ["<p><strong>The Price of Stuff: How Condoms Can Cost a Week&rsquo;s Wages</strong></p>\n<p>What is the monthly earning of a Venezuelan on the minimum wage?</p>","<p>3m Bolivars per month</p>",0],
  ["<p>How long would it take to earn the money required to purchase a pack of condoms in Venezuela?</p>","<p>2 weeks</p>",0],
  ["<p>What has been the effect of the high price of condoms in Venezuela?</p>","<p>There has been a rise in the number of unwanted pregnancies. There has also been a rise in STDs and HIV. Many women are choosing to become permanently sterilised.</p>",0],
  ["<p>Why can people charge more for things when they are scarce?</p>","<p>The seller can keep increasing their prices until enough people drop out until you have the number of people who are willing to buy the goods.</p>",0],
  ["<p>What are the two causes of inflation, according to the programme?</p>","<p>Excess demand. Because there are more people who want the good or service, they can push the prices up. The cost of the good can increase as well- because of the increased cost of wages, for example. This causes sellers to push their prices up.</p>",0],
  ["<p>What happens when the government prints money?</p>","<p>Everyone&rsquo;s got more money to spend. If the government floods more money in the system. If the government prints more money, there is more money sloshing around, so people can drive up prices and it becomes a self-fulfilling prophecy. Money loses its value, so shopkeepers charge more money for their bread, which pushes prices up.</p>",0],
  ["<p><strong>&ldquo;Inflation has reached 3%, its highest level for five years. The cost of living is rising faster than wages for millions of workers, but the incomes of pensioners are set to be protected.&rdquo;</strong></p><p>What is a &lsquo;basket of goods.&rsquo;</p>","<p>The ONS looks at a &lsquo;basket of goods&rsquo; and looks at how the prices of items in the basket change over time.</p>\n<p>These are the goods and services that everybody consumes. They look at how these prices have changed over time. They add the prices together to get a representation of spending. If inflation is 3%, then prices of goods and services are going up by 3% across everything we&rsquo;re buying.</p>",0],
  ["<p>Are the following items included in the basket of goods that are used by the ONS to calculate inflation?</p>\n<ul><li>Cashews</li><li>Brown chestnut mushrooms</li><li>Chia seeds</li><li>Blueberries</li><li>Grapes</li><li>Satsumas/Clementine</li><li>Aubergines</li><li>Baked Beans</li><li>Pak Choi</li><li>Chicken</li><li>Bread</li><li>Miso Paste</li><li>Corned Beef</li></ul>","<ol>\n<ul><li>Cashews <em>No</em></li><li>Brown chestnut mushrooms <em>Yes</em></li><li>Chia seeds <em>No</em></li><li>Blueberries <em>Yes</em></li><li>Grapes <em>Yes</em></li><li>Satsumas/Clementine <em>Yes</em></li><li>Aubergines <em>No</em></li><li>Baked Beans <em>Yes</em></li><li>Pak Choi <em>No</em></li><li>Chicken <em>Yes</em></li><li>Bread <em>Yes</em></li><li>Miso Paste <em>No</em></li><li>Corned Beef <em>Yes</em></li></ul></ol>",0],
  ["<p>How often do they change the basket of goods that represents consumer spending?</p>","<p>Every year.</p>",0],
  ["<p>Why might different parts of society have different inflation rates?</p>","<p>Because different income groups have different spending patterns, e.g. low income groups may purchase more food, and high-income groups spend more money.</p>",0],
  ["<p>What is meant by &lsquo;shrinkflation&rsquo;?</p>","<p>When the size of a packet of goods falls, but the price stays the same. This is essentially an increase in price.</p>",0],
  ["<p>How are &lsquo;weightings&rsquo; determined for different goods in the &lsquo;basket of goods&rsquo;?</p>","<p>It is determined based on the amount that households spend on them. The more money people spend on a certain item determines how much weighting it will have.</p>",0],
  ["<p>What is the weighting for the following items:</p>\n<ul><li>Food (excluding alcohol):</li><li>Housing:</li></ul>","<ol>\n<ul><li>Food (excluding alcohol): <em>8%</em></li><li>Housing: <em>30% (biggest single item); and also all housing costs.</em></li></ul></ol>",0],
  ["<p>How is &lsquo;opportunity cost&rsquo; used to determine the price of housing for owner-occupiers?</p>","<p>By looking at the price of the next-best alternative, which is renting. By living in the home, I am forgoing the rent that I could be charging on it- so it is the cost to me.</p>",0],
  ["<p>What is the &lsquo;RPI&rsquo;? What is the difference between the CPI and the RPI?</p>","<p>The RPI is the &lsquo;retail prices index.&rsquo; The RPI is a historical measure. It has fallen out of favour because of the ways it is put together- it doesn&rsquo;t measure inflation very well. But because people have signed contracts with RPI in them, the ONS must continue to measure by this measure.</p>",0],
  ["<p><strong>Bread vs Beyonc&eacute;</strong></p>\n<p>1998: Spice Girls. The price of a loaf of bread is &pound;0.50. How much do you think it would cost to see the Spice Girls? How much did it actually cost?</p>","<p>&pound;23.50</p>",0],
  ["<p>2002: Destiny&rsquo;s Child. The price of a loaf of bread now costs &pound;0.58. How much do you think it will cost to see Destiny&rsquo;s Child at Wembley Arena? How much did it actually cost?</p>","<p>&pound;25</p>",0],
  ["<p>2012: Stone Roses. The price of a loaf of bread now cost &pound;1.20. How much do you think it will cost to see the Stone Roses comeback show? How much did it actually cost?</p>","<p>&pound;55</p>",0],
  ["<p>2018: Beyonce. The price of a loaf of bread now cost &pound;1.06. How much do you think it will cost to see Beyonce on tour with Jay Z? How much did it actually cost?</p>","<p>&pound;85</p>",0],
  ["<p>What was the average ticket price for big arena gigs in 1999? What is it in 2016?</p>","<p>&pound;22.58, &pound;45.49</p>",0],
  ["<p>Why have the price of concert tickets gone up so much quicker than bread?</p>","<p>Suggested answers: elastic supply of bread, inelastic supply of Beyonce. Things will go up in price if they are inelastic in supply following an increase in demand.</p>",0],
  ["<p>What are the reasons why bread may have gone down in price?</p>","<p>Because the pound may fluctuate, or the supply of wheat may be short for a period of time (volatile prices).</p>",0],
  ["<p><strong>What about deflation?</strong></p>\n<p>What is the suggested definition of &lsquo;deflation,&rsquo; as mentioned in this podcast?</p>","<p>Deflation is the general decreasing of prices over a period of time. Prices come down again.</p>",0],
  ["<p>Given the story of &lsquo;Mike,&rsquo; why is deflation a bad thing?</p>","<p>Because if you see the price of a good fall after you&rsquo;ve bought it, you will not want to spend money again in the future. If prices are going down, people will stop spending money- why would you spend money today if you think it&rsquo;s going to be cheaper tomorrow? This would mean that people would stop spending. When people stop spending, suppliers cut their prices again- it causes a downward spiral, a &lsquo;self-fulfilling prophecy.&rsquo;</p>",0],
  ["<p>Have we ever seen deflation in the UK?</p>","<p>In the banking crisis, it went to 0% for a brief period of time.</p>",0],
  ["<p>What is the Bank of England&rsquo;s role in keeping inflation steady?</p>","<p>The government sets an inflation target of 2%, and it&rsquo;s the Bank of England&rsquo;s responsibility (either through interest rates or other means) to help nudge the economy along to help meet that target.</p>",0],
  ["<p>Why is 2% a good inflation target for the Bank of England?</p>","<p>If I expect prices to go up a bit in the future, I&rsquo;m more inclined to spend now. This will help push AD to the right and boost economic growth.</p>",0],
  ["<p>What are the key takeaways about inflation?</p>","<p>Inflation happens when there is not enough stuff to go around. When it gets really high, it can cause chaos. If it goes low, then it means people may lose their jobs. The inflation rate in the news is just an average- it may not apply to you. There is only one Beyonce, so the price of her concerts may go up by more than average.</p>",0]
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
	
	if (index[i][2] !== 0) {
	var img = document.createElement("img");
	img.src = root+index[i][2];
	img.style.width = "100px";
	img.style.height = "100px";
	/*img.style.display = "inline-block";*/
	question.appendChild(img);
	}

	var answer = document.createElement("div");
	answer.setAttribute("id", "a"+i);
	answer.innerHTML = index[i][1];
	answer.style.backgroundColor = "pink";
	answer.style.margin = "10px";
	answer.style.display = "none";
	
	
	

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