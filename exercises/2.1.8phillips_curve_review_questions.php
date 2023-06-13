<!DOCTYPE html>

<html lang="en">

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

<h1>Phillips Curve Review Questions</h1>

<img src = "files/2.1.8_06.jpg" style="max-width: 100%;">


<h2>Instructions</h2>
<p>Answer these questions in notes. You can click the button to check your answers.</p>




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
  ["<p>Explain, using a Phillips Curve diagram, the effect on inflation and unemployment of a one-off expansionary fiscal policy.</p>",

		"<p><img src='files/2.1.8_04.jpg' alt='One-off Expansionary Fiscal Policy'></p><p>Expansionary fiscal policy will lead to an increase in AD. This will lower unemployment from NAIRU to U1, giving power to workers who are able to push up their wages, which will push up costs to firms and cause them to increase prices, meaning inflation rises from 2% to 5%.</p>"],
  
  ["<p>Explain what is meant by the <strong>money illusion</strong></p>",
		
		"<p>The money illusion refers to workers thinking they are getting a real wage increase due to their inflationary expectations not being accurate. As an example: if workers receive a 5% wage increase and they think that inflation will be 2%, they believe they have a 3% increase in real wages. This may be an illusion if inflation is actually at 5% (meaning their real wage increase is 0%).</p>"],
  
  ["<p>Explain, using a Phillips Curve diagram, the effect on inflation and unemployment of a sustained expansionary fiscal policy designed to keep unemployment low.</p>",
  
	"<p><img src='files/2.1.8_05.jpg' alt='Sustained Expansionary Fiscal Policy'></p><p>If the government sustains expansionary fiscal policy, workers will cease to perceive the money illusion. The money illusion will stop. This changes the workers&rsquo; inflationary expectations, leading to a shift in SRPC from SPRC1 to SRPC2. As workers realise that they no longer have higher real wages to entice them into the market unemployment increases from U1 to NAIRU, while maintaining 5% inflation. If the expansionary policy is continued, we will travel from C to D on SRPC2, which will eventually lead to a new SRPC with even higher levels of expected inflation.</p>"],
  
  ["<p>Explain the importance of <strong>inflationary expectations</strong> in your analysis above.</p>",
  
	"<p>Inflationary expectations shifts the SRPC. As we expect inflation to be 2%, we stay on SRPC1. Once we expect inflation at 5%, we shift SRPC to SRPC2.</p><p>Inflationary expectations change as the money illusion is broken. The money illusion implies that workers haven&rsquo;t yet changed their inflationary expectations.</p>"],
  
  ["<p>Explain how continued and sustained expansionary fiscal policy will only ever lead to inflation (climb the ladder up).</p>",
	
	"<p><img src='files/2.1.8_06.jpg' alt='Climb the Ladder Up'></p><p>Expansionary fiscal policy will push inflation below the NAIRU (e.g. to U1). This will cause an increase in inflation, say from 2% (point A) to 5% (point B). As the economy remains at 5% inflation, workers change their inflationary expectations from 2% to 5%, shifting the Short Run Phillips Curve from SRPC1 to SRPC2, moving from point B to point C. Continued expansionary fiscal policy to keep unemployment at U1 will now require inflation of 8%, moving from point C to point D. But 8% inflation changes inflationary expectations, shifting the Short Run Phillips Curve from SRPC2 to SRPC3, moving from point D to point E. Thus, to continue unemployment at U1, even higher inflation is needed (point F). SRPC3 represents a Phillips Curve with high inflationary expectations, in which the trade-off between inflation and unemployment is significantly worse.</p>"],
  
  ["<p>Use a diagram to show how a government can &lsquo;shock&rsquo; an economy into lower inflationary expectations (i.e. what Paul Volcker did in the USA in the 1980s) (climb the ladder down).</p>",
  
	"<p><img src='files/2.1.8_07.jpg' alt='Climb the Ladder Down'></p><p>If you start with high inflation at NAIRU (point A) and you want to lower inflationary expectations, you need to first increase unemployment above the NAIRU. Conducting contractionary fiscal policy to raise unemployment to U2 will lower inflation of 5% (moving from point A to point B). Eventually workers adjust their inflationary expectations from 8% to 5%, shifting Short Run Phillips Curve from SRPC1 to SRPC2, moving from point B to point C. Continued contractionary fiscal policy will raise unemployment to U2 and lower inflation to 2% (point D). Given time for inflationary expectations to adjust to 2%, the Short Run Phillips Curve will shift from SRPC2 to SRPC3, moving to point E. SRPC3 represents a Philips Curve with low inflationary expectations, where the trade-off between inflation and unemployment is significantly better.</p>"],
  
  ["<p>Explain, using a diagram, what will shift the Long-Run Phillips curve.</p>",
	
	"<p><img src='files/2.1.8_08.jpg' alt='Shifts to LRPC'></p><p>The LRPC is shifted by real factors in the economy that make the labour force more flexible. To shift the LRPC left (desirable), the government would have to implement labour market reforms that would allow for greater labour market flexibility, allowing for lower levels of unemployment no matter the level of inflationary expectations. This may include:</p><ul><li>Improved skills levels</li><li>Decreased union power</li><li>Improved mobility of labour</li><li>Better job information</li><li>Reduction of employment licensing regulations</li></ul><p>It could be argued that the rise of the &lsquo;gig economy&rsquo; of informal work would also allow for grater labour market flexibility.</p><p>Shifting the LRPC right (undesirable) would be due to policies that decrease labour market flexibility, such as:</p><ul><li>Increased union power</li><li>Increased licensing regulations.</li><li>Decreased labour mobility</li><li>Increased regulations in hiring/firing people.</li></ul>"]
]







function populate() {





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