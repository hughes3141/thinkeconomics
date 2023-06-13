<html>

<head>
<?php include "../header.php"; ?>

<style>

.highlight {
	
	
	background-color:yellow;
}

.answer {
	background-color: pink; 
	margin: 10px;
	padding: 5px;
	
}
</style>


</head>

<body onload="populate()">
<?php include "../navbar.php"; ?>

<h1>Transmission Mechanism of Quantitative Easing</h1>
<p>Watch this video: <a target="_blank" href="https://youtu.be/J9wRq6C2fgo">https://youtu.be/J9wRq6C2fgo</a>. The transcript is below.</p>
<p>When you are finished, answer the below questions in notes. Once you are finished you can check against your answers.</p>

<img src ="files/232_12.JPG" style="max-width: 100%">





<div style="background-color: #e6e6e6; border: solid 1px black; margin; 5px">

<p><strong>Quantitative Easing: How It Works</strong></p>
<p>The Bank of England&rsquo;s Monetary Policy Committee has been purchasing assets financed by new money that the Bank creates electronically. Often known as Quantitative Easing, this policy is designed to inject money directly into the economy. This is in response to a sharp <span class="highlight">fall in demand</span> as businesses and consumers reduce their spending. In short, there is not enough money in the economy.</p>
<p>The aim is to boost spending to keep inflation on track to meet the 2% target. Alongside its decisions on asset purchases, the Monetary Policy Committee continues to set bank rates each month.</p>
<p>The bank purchases <span class='highlight'>assets</span> from private sector businesses, including: insurance companies, pension funds, high street banks, and non-financial firms. Most of the assets purchased are government bonds. There is a large market available, so the bank can purchase large quantities of assets fairly quickly. The Bank of England&rsquo;s injection of money into the economy works through different channels, and has a variety of potential effects. <span class='highlight'>When the bank buys assets, this increases their price, and so reduces their yield.</span> That means the return on those assets falls. This encourages sellers of assets to use the money they receive from the bank to switch into other financial assets, like company shares and bonds. As purchases of these other assets start to increase, their prices rise, which pushes down on yields generally.</p>
<p>Lower yields reduce the cost of borrowing for businesses and households. This, in turn, leads to higher consumer spending and more investment. Of course, higher asset prices also make some people better off, which provides an extra boost to spending on goods and services.</p>
<p>The Bank of England is also buying smaller amounts of private debt, like corporate bonds. These purchases are aimed at improving conditions in capital markets, making it easier for companies to raise money which they can invest in their business.</p>
<p>There&rsquo;s another way the Bank&rsquo;s purchase of assets could put money into the economy. Those selling assets to the bank of England deposit more money into their bank accounts. So commercial banks have more funds which they can use to finance new loans, and more bank lending supports spending and investment. But this channel is likely to be relatively weak as banks continue to repair their finances in the wake of the crisis. That&rsquo;s why the Bank of England s buying most of the assets from firms other than banks.</p>
<p>The extra money the Bank of England is injecting into the economy should increase spending to help keep inflation on track to meet the Government&rsquo;s 2% target. Without that boost, the amount of money in the economy would be too low, spending would be weaker, and inflation might fall below target. But as perceptions of an improvement in the economy begin to spread, this will stimulate business and consumer confidence. That will help to underpin expectations that policy is beginning to work, which should itself encourage more spending and keep inflation in line with the target. As it sets policy each month, the Monetary Policy Committee will continue to be guided by the outlook for inflation relative to its 2% target. If the Committee thinks inflation looks set to rise above target, it could raise Bank Rate, and sell assets to remove extra money it has put into the economy.</p>
<p>Source: Bank of England Website: <a target="_blank" href="https://www.bankofengland.co.uk/monetary-policy/quantitative-easing">https://www.bankofengland.co.uk/monetary-policy/quantitative-easing</a></p>

</div>


<div id="question_div">
</div>

<h2>Task</h2>
<p> Construct a diagram on an A3 sheet to show the transmission mechanism of Quantitative easing. It should start with &ldquo;Bank of England Purchases Assets&rdquo; and finish with &ldquo;Inflation at 2%&rdquo;. Illustrate your flow diagram with pictures or paste the infographics from the video (optional).</p>







<div style="display:none">
<p><u>Knowledge check: How hot are you on QE?</u></p>
<p>Explain how the Bank of England Purchasing Assets will stimulate the economy by:</p>

<p>Injecting more money into the economy (Korma):</p>

<p>Increasing the value of assets (Madras):</p>

<p>Decreasing Bond Yields (Vindaloo):</p>
</div>



<iframe width="560" style="max-width:100%" height="315" src="https://www.youtube.com/embed/J9wRq6C2fgo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<?php include "../footer.php"; ?>
<script>

/*

Created from questions_template1.3.html
Includes function for headings

INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS 

1. Construct questions and answers in word document.
2. Convert to Array using the following:
	https://shancarter.github.io/mr-data-converter/
	Output as JSON-Row arrays
3. Change variable "page_title" to the title of the page.
4. Change array "index" to the question-answer index.
*/


var root ="files/"
var index = [
  ["What is the likely cause of the <span class='highlight'>‘sharp fall in demand’</span> ? What type of demand is this?","The fall in demand is due to lower consumer spending and business investment. This can be caused by any number of things- low confidence due to the financial crisis (2009), the shock of the Brexit vote (2016), or a response to covid-19 (2020). This is aggregate demand.", ""],
  ["What sorts of <span class='highlight'>‘assets’</span> is the Bank purchasing?","Most of the assets purchased are government bonds.", ""],
  ["<span class='highlight'>‘When the bank buys assets, this increases their price, and so reduces their yield.’</span> Explain why this happens.","The yield of an asset is measured as its annual coupon payment divided by price. The annual coupon payment is what the holder of the bond receives every year for holding the bond; this value is fixed. If the price of the bond rises, the proportion of the price paid each year as the coupon payment goes down. Hence, bond yields reduce.", ""],
  ["Explain why the Bank of England’s asset purchases will lower yields generally.","Sellers of assets bought by the Bank of England use their money to buy other financial assets, like shares. This pushes up the prices of these assets, which likewise lowers their yield.", ""],
  ["Explain why higher asset prices, and by implication lower yields, will increase Aggregate Demand.","Higher asset prices make some people better off, which leads to them spending more in the economy. Lower yields reduce the cost of borrowing for businesses and households.", ""],
  ["Evaluate whether increased money in the economy will stimulate higher levels of bank lending.","On one hand it should: because the people who sold the bonds will put the money in the bank, which the banks lend out. But on the other hand: the banks might keep the money, rather than lending it out, in order to repair their finances.", ""],
  ["Extension: Explain why inflation expectations will help keep inflation at its target rate. ","This is explained in the last paragraph. As the policy is seen to be working, business and consumer confidence will improve. So people think the policy is working, which makes them even more confident, and the cycle continues.", ""],
  ["How could this policy eventually be reversed?", "The Bank of England could reverse this policy by selling the assets it has already bought, thus removing extra money from the economy.", ""],
  ["Extension: What are the possible disadvantages of this policy?","<p>This policy might not be successful because banks might hold onto the money rather than lending it out again.</p><p>Increasing the amount of money in circulation risks causing inflation. The Quantity Theory of Money states that MV = PT. Hence increasing the money supply (M) will lead to rises in price level (P).</p>",""],
  ["Super-extension: Find out what &lsquo;helicopter money&rsquo; is. Why would this be more/less effective than QE?", "<p>Helicopter money involves creating new money and giving it straight to the public, bypassing the banks. It is unorthodox and has not been tried before. Supporters of it say that it would bypass the banks, which may wish to hold on to money that they get through Quantitative Easing. But other people think it could more easily spiral out of control. More info: <a href='https://www.youtube.com/watch?v=8BXInn-pgsg' target='_blank'>CNN youtube</a> and <a href='https://www.investopedia.com/articles/personal-finance/082216/what-difference-between-helicopter-money-and-qe.asp' target='_blank'>Investopedia</a>.</p>",""]
]






function populate() {





	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("question_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.innerHTML = "<p>"+(i+1)+": "+index[i][0]+"</p>";
	
	question.style = "margin:10px; overflow: hidden; line-height: 1.6; border: pt black solid; padding; 5px;";
	
	
	
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
	answer.setAttribute("class", "answer");
	answer.innerHTML = index[i][1];
	/*
	answer.style.backgroundColor = "pink";
	answer.style.margin = "10px";
	*/
	answer.style.display = "none";
	
	
	question.appendChild(answer);

	main_div.appendChild(question);
	
	
	
	}


}	

var password =  <?php include "../password.php"; ?>;

var passed = false;


function passwordPrompt() {

 var promptBox = prompt("Password for answers:");
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


}
	
</script>





</body>



</html>