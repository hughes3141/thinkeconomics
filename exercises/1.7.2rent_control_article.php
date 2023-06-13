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
<a href = "files/1.7.2%20The%20Economist%20Explains%20Do%20Rent%20Controls%20Work.pdf" target = "_blank" ><img src = "files/1.7.2_1.jpg" style="max-width: 100%;"></a><br>
<a href = "files/1.7.2%20The%20Economist%20Explains%20Do%20Rent%20Controls%20Work.pdf" target = "_blank" >PDF: The Economist Explains: Do Rent Controls Work</a>
<p><em>30 August 2015</em></p>


<h2>Instructions</h2>
<p>Click on the link above to access the PDF to the article: Do Rent Controls Work.</p>

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

var page_title = "1.7.2 <em>The Economist</em> Explains: Do Rent Controls Work?";
var root ="images/"
var index = [
  ["Use a supply-demand diagram to explain why ‘growth has pushed up rents.’","<img src='files/1.7.2_02.jpg'></img><br>'Growth' in a city implies that more economic activity is taking place and more people are moving to the area. As more people move to the area there will be greater demand for housing, shifting Demand to the right. Greater demand, with a relatively inelastic supply curve, will mean that prices increase."],
  ["What are the benefits of rent control, as mentioned in the article?","Rent control:<ul><li>Provides long-term security for renters</li><li>Takes the balance of power away from landlords towards tenants.</li><li>Makes the market fairer: low-income households cannot be pushed out when neighbourhood becomes ‘gentrified’ (when new, high-income residents move in)</li></ul>"],
  ["Use a supply-demand diagram to explain how rent control ‘reduces the supply of property to the market.’","<img src='files/1.7.2_04.jpg'></img><br>Capped prices mean that landlords have less incentive to fix up and rent out a flat. The landlords between Qs and Q1, who would have rented out a flat at the market equilibrium price, no longer bother."],
  ["What are the drawbacks of rent control, as mentioned in the article?","<ul><li>Rent controls reduce the available supply to the market, through lack of price incentive</li><li>Landlords don’t bother to maintain their properties, because there is less turnover on the market</li><li>Landlords become choosier</li><li>Tenants stay in their properties for longer than they would otherwise, restricting available properties for newcomers.</li><li>Rent-controlled properties often go to those on higher incomes, as they have the means to track down the cheaper apartments.</li></ul>"],
  ["This article suggests that the best way to deal with high rents is to build more housing. Use a supply-demand diagram to show why this would work.","<img src='files/1.7.2_05.JPG'></img><br>Building more houses will shift supply curve to the right, pushing prices down."],
  ["Extension: Use a supply-demand diagram to show the effect of policies that reduce the growth of housing.","<img src='files/1.7.2_06.JPG'></img><br>London’s green belt means there is a strip of land around London that cannot be used for building housing. Restrictive zoning laws in San Francisco means that there are rules stating that houses can only be used as single-family residences, not multiple flats, which restricts housing for others. These types of policies make housing les available than it might have been, shifting supply curve to the left and pushing up prices.  "]
]







function populate() {

document.getElementById("page_title").innerHTML= page_title;



	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("main_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.setAttribute("class", "question");
	question.innerHTML = "<b>Question "+(i+1)+"</b>: <p>"+index[i][0]+"</p>";


	
	
	
	var button = document.createElement("button");
	button.innerHTML = "Click for Answer";
	button.setAttribute("onclick","answer("+i+")");
	button.setAttribute("id", "b"+i);
	question.appendChild(button);
	


	var answer = document.createElement("div");
	answer.setAttribute("id", "a"+i);
	answer.setAttribute("class", "answer");
	answer.innerHTML = "<p>"+index[i][1]+"</p>";
	
	
	
	

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