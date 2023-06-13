<html>

<head>
<?php include "../header.php";?>

<style>



</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php";?>


<div class="pagetitle"><span id ="page_title"></span></div>

<p>For each question, explain:</p>
<ul>
<li>Which element of AD will be affected? C, I, G, or (X-M)? Or several?</li>
<li>Will it shift AD to the right or to the left?</li>
<li>Detailed explanation of the effect on AD.</li>
</ul>



</div>

<?php include "../footer.php";?>

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

var page_title = "2.1.3 Shifts in the AD Curve: Summary Questions";
var root ="files/"
var index = [
  ["Higher interest rates","<p>This will affect <strong>consumer spending </strong>and <strong>investment.</strong></p> <p>This will shift the AD curve to the <strong>left</strong>.</p> <p>Higher interest rates means that the <em>cost of borrowing</em> has increased. The effect on <strong>consumers</strong> will be that they are not as willing to borrow money (e.g. through a credit card) to fund their consumption. Additionally, any outstanding debt that households have (e.g. variable-rate mortgages) will now have higher interest payments, leaving households with less discretionary income.</p> <p>The higher interest rate will also mean that <em>the return to savings</em> has increased. <strong>Consumers</strong> may decide to save more of their money rather than spend it.</p> <p>The higher <em>cost of borrowing </em>will affect <strong>investment</strong>. Businesses will spend less on new capital equipment if the cost of financing this purchase increases.</p><p>These effects mean that, for any given price level, AD will be lower.</p>",0],
  ["Lower consumer/ business confidence","<p>This will affect <strong>consumer spending </strong>and <strong>investment.</strong></p><p>This will shift the AD curve to the <strong>left</strong>.</p><p>As <strong>consumers</strong> are less confident about the future (e.g. they feel less confident about the security of their job) they will spend less money.</p><p>As businesses feel less confident about the economy (e.g. they expect a downturn) they will not be willing to spend money on <strong>investing </strong>in new equipment and machinery.</p><p>These effects mean that, for any given price level, AD will be lower.</p>",0],
  ["Savings rate decreases","<p>This will affect <strong>consumer spending</strong></p><p>This will shift the AD curve to the <strong>right.</strong></p><p>Households saving less of their income implies they must be spending more on <strong>consumer expenditure. </strong></p><p>For any given price level, AD will be higher.</p>",0],
  ["Low profits","<p>This will affect <strong>investment.</strong></p><p>This will shift the AD curve to the <strong>left.</strong></p><p>Low profit levels mean that businesses have less money to re-invest into their business to buy new capital equipment. This means <strong>investment</strong> will be lower.</p><p>For any given price level, AD will be lower.</p>",0],
  ["Higher income taxes","<p>This will affect <strong>consumer spending</strong></p><p>This will shift the AD curve to the <strong>left.</strong></p><p>Higher income taxes will mean that households have lower <em>disposable income</em>. The lower income will mean that <strong>consumer spending </strong>decreases.</p><p>For any given price level, AD will be lower.</p>",0],
  ["More Government Spending","<p>This will affect <strong>government spending.</strong></p><p>This will shift the AD curve to the <strong>right.</strong></p><p>With the <strong>government</strong> spending money in the economy, there is more demand for goods and services, and more income provided to the businesses who provide those goods and services.</p><p>For any given price level, AD will be higher.</p>",0],
  ["Strong currency","<p>This will affect <strong>net exports</strong></p><p>This will shift the AD curve to the <strong>left.</strong></p><p>A strong currency will mean that our <strong>exports</strong> are more expensive abroad. This will mean that we sell fewer exports.</p><p>A strong currency will also mean that <strong>importing</strong> items from abroad will be cheaper for UK residents. UK residents will import more.</p><p>Lower <strong>exports </strong>and higher <strong>imports</strong> will lead to a decrease in <strong>net exports </strong>(exports &ndash; imports).</p><p>For any given price level, AD will be lower.</p>",0],
  ["Society attitude toward spending","<p>This will affect <strong>consumer spending</strong></p><p>This will shift the AD curve to the <strong>right.</strong></p><p>Social attitudes that encourage spending (e.g. consumer culture) will make it more acceptable (and expected) for people to spend their money. This will increase <strong>consumer spending</strong>.</p><p>For any given price level, AD will be higher.</p>",0],
  ["Increase in stock market values","<p>This will affect <strong>consumer spending </strong>(and possibly <strong>investment</strong>)</p><p>This will shift the AD curve to the <strong>right.</strong></p><p>Higher stock market values will mean that households who own stocks and shares will have an <em>increase in wealth</em>. This increase will make them feel more confident; they know they have more wealth to use to offset loans, for example. <strong>Consumers</strong> will therefore spend more.</p><p>The higher prices of stocks and shares will allow firms to raise money which they could use for <strong>investment</strong> in new capital equipment.</p><p>For any given price level, AD will be higher</p>",0],
  ["Fall in house prices","<p>This will affect <strong>consumer spending.</strong></p><p>This will shift the AD curve to the <strong>left.</strong></p><p>House prices are a store of wealth; for many households they are the single largest asset. A fall in house prices means the wealth of households decreases, making them less confident and less willing to engage in consumer spending.</p><p>(As an example: when a household reviews their mortgage with the bank, which typically happens every five years, the bank will note the lower house value and the terms of the mortgage will be less favourable. A higher loan-to-value-ratio will mean the bank charges a higher interest rate, or is less willing for more to be taken out on the mortgage.)</p><p>For any given price level, AD will be lower.</p>",0],
  ["Weak currency","<p>This will affect <strong>net exports</strong></p><p>This will shift the AD curve to the <strong>right.</strong></p><p>A weak currency will mean that our <strong>exports</strong> are less expensive abroad. This will mean that we sell more exports.</p><p>A weak currency will also mean that <strong>importing</strong> items from abroad will be more expensive for UK residents. UK residents will import less.</p><p>Higher <strong>exports </strong>and lower <strong>imports</strong> will lead to an increase in <strong>net exports </strong>(exports &ndash; imports).</p><p>For any given price level, AD will be higher.</p>",0]
]


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
	
	if (index[i][2] !== 0) {
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