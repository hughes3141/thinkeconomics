<html>

<head>
<?php include "../header.php";?>

<style>

.answer {

background-color: pink;
margin-top: 10px;
display: none;
padding:10px;


}

.question {


	margin-top:10px;
	
	}


</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php";?>

<div id="main_div">

<h1 class><span id ="page_title"></span></h1>
<a href = "files/2.1.8%20Economist%20Briefing-%20The%20natural%20rate%20of%20unemployment.pdf" target = "_blank" ><img src = "files/2.1.8_01.JPG" style="max-width: 100%;"></a><br>
<a href = "files/2.1.8%20Economist%20Briefing-%20The%20natural%20rate%20of%20unemployment.pdf" target = "_blank" >PDF: Briefing The Natural Rate of Unemployment</a>
<p><em>26 August 2017</em></p>


<h2>Instructions</h2>
<p>Click on the link above to access the PDF to the article: The Natural Rate of Unemployment Briefing.</p>

<p>As you read answer the questions below.</p>
<p>You can check your answers by clicking on the buttons beneath each question.</p>



</div>

<?php include "../footer.php";?>

<script>

/*

This document was created using 1.1.3construction_productivity_problem.php

INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS INSTRUCTIONS 

1. Construct questions and answers in word document.
2. Convert to Array using the following:
	https://shancarter.github.io/mr-data-converter/
	Output as JSON-Row arrays
3. Change variable "page_title" to the title of the page.
4. Change array "index" to the question-answer index.
*/

var page_title = "2.1.8 Phillips Curve Briefing from <em>The Economist</em>";
var root ="images/"
var index = [
  ["<p>Briefly explain the costs of unemployment referred to in P1.</p>", "<ul><li>Loss in human output (hours, days, years) of people who are idle but would rather be working</li><li>Lives ruined- possibly through lack of purpose as unemployed</li><li>Budgets sunk- both personal budgets and government fiscal budget</li><li>Government toppled- no government will survive with an economy with persistently high unemployment.</li></ul>"],
  
  ["<p>Briefly explain why unemployment can never be 0%, using fictional and structural unemployment.</p>","<p>Frictional unemployment refers to people between jobs- as long as people switch jobs, there will be some people unemployed</p><p>Structural unemployment refers to people who lose jobs due to changes in the industry (e.g. loss of manufacturing base). As long as there are industries changing, there will be structural unemployment (although the ability to retrain/move would allow this to be lower).</p>"],
  
  ["<p>Consider the following paraphrase from the article: “The relationship between wages and employment offers a menu for policymakers; they can choose a level of unemployment that fits with what they see as acceptable inflation.” Explain this statement using the Phillips curve and the wage-price spiral.</p>","<p>This is the explanation of the Short Run Phillips Curve. In essence:</p><ul><li>If governments want low unemployment, they can get it, as long as they accept higher inflation. Stimulating AD to lower unemployment creates a smaller pool of available workers, giving more power to workers in the wage negotiating process. This pushes up wages, which will push up firms&rsquo; costs, which will lead to them increasing prices, which increases cost of living and encourages workers to further push up their wages.</li><li>If governments allow unemployment to be higher, then inflation will be lower. High unemployment gives workers less negotiating power when determining wages, leading to lower wages, lower costs for firms, which means that firms can lower prices, leading to lower costs of living, leading to less need to negotiate high wages.</li></ul><p>In effect: the SRPC illustrates that there is a trade-off governments make: get unemployment down at the expense of high inflation, or achieve low inflation at the expense of high unemployment.</p>"],
  
  ["<p>Summarise the argument that Milton Friedman put forward to why unemployment would eventually reach its ‘natural rate’ as stated in P3-P5 on page 2.</p>","<p>Milton Friedman argued that there is not a menu choice- a &lsquo;natural rate of unemployment&rsquo; or NAIRU will prevail.</p><p>This is because:</p><ul><li>If government stimulates AD, this leads to higher inflation. Because workers are slow to change their wage contracts, this will make them artificially cheap. This will mean firms hire more of them, lowering unemployment. (The SRPC relationship)</li><li>However, when the workers negotiate their next contract, they will build in the new inflation rate to their negotiations. This will erode their artificially cheap labour, which means that unemployment would rise again.</li><li>So, in order for the central bank to continue with low unemployment, they will have to continue to &lsquo;surprise&rsquo; workers with ever-higher inflation rates. The conclusion: if unemployment stays below the natural rate, inflation will accelerate.</li></ul>"],
  
  ["<p>P7 on page 2 describes what happened to inflation and unemployment in the 1970s. How can this be reconciled with what we know about the Phillips Curve and the NAIRU?</p>","<p>In the 1970s both inflation and unemployment were high, going against the idea of a Phillips curve. Maybe inflationary expectations had gone so high that there was a new SRPC, with very high inflation and unemployment.</p><p>The NAIRU may have changed due to poor supply-side policies that made labour less flexible.</p>"],
  
  ["<p>Explain how Paul Volcker managed to tame inflation in the USA after 1980.</p>","<p>Volcker allowed a recession in the early 1980s; he set interest rates at nearly 20% in 1981. This led to high unemployment, over 10%. However, it got inflation down to where people then started to expect that it would be low, and people believed the central bank would keep it low, leading to SRPCs with lower inflationary expectations.</p>"],
  
  ["<p>Explain what has happened to inflation and unemployment since the recession of 2007-2008. What does this imply about inflationary expectations, the credibility of central banks, and the natural rate of unemployment?</p>","<p>Unemployment has varied- to as high as 10% after the recession, to as low as 4.3% now. Yet inflation has not changed. The SPRC is now flat.</p><p>This is down to two things:</p><ul><li>It is possible that the NAIRU is changing as well. It is difficult to estimate, and recent changes in labour market suggest that the power dynamic between firms and workers may change.</li><li>It is possible that expectations of low inflation are keeping SRPCs from shifting to the right. This is down to the credibility of central banks- because inflation has been so low for so long, people believe them when they say that they will continue to keep it low.</li></ul><p>So the danger now- possibly that political pressure will force central banks to expand monetary policy, given that there appears to be no link with inflation and unemployment. Yet if that happens the central banks may lose their credibility- which would take them back to the early 1980s.</p>"]
]







function populate() {

document.getElementById("page_title").innerHTML= page_title;



	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("main_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.setAttribute("class", "question");
	question.innerHTML = "<b>Question "+(i+1)+"</b>: "+index[i][0];


	
	
	
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