<html>

<head>


<?php include "../header.php"; ?>

<style>



</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php"; ?>


<div class="pagetitle"><span id ="page_title"></span></div>
<p>Instructions: Read the articles below and answer the questions.</p>

<a href= "files/Measuring_development.pdf" target="_blank">Article 1: Measuring Development</a>
<br>
<a href= "files/Measuring_wellbeing.pdf" target="_blank">Article 2: Measuring Well-Being</a>




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

var page_title = "3.3.1 Limitations of GDP: Summary Questions";
var root ="files/"
var index = [ ["Article 1: Measuring Economic Development: What is included in the indicator &lsquo;inclusive wealth&rsquo;?","This indicator would put a dollar value on manufactured capital, human capital, and natural capital.",0], ["Article 1: Measuring Economic Development: Describe the difference between the growth of inclusive wealth compared to GDP between 1992 and 2010.","From 1992 to 2010, global GDP increased by 50%, but inclusive wealth only rose by 6%.",0], ["Article 1: Measuring Economic Development: What are the conclusions of this difference in growth?","The growth in GDP seems to have come at the expense of inclusive wealth. A good example is Qatar: a rise in GDP of 85%, but a fall in inclusive wealth. This is because countries around the world are growing in ways that are unsustainable.",0], ["Article 2: Measuring Well-being What does the Sustainable Economic Development Assessment (SEDA) measure?","The SEDA measures economics, investment, and sustainability. Economics includes: income, stability and employment; investment includes: health, education and infrastructure; sustainability includes: inequality, civil society, government and environment.",0], ["Article 2: Measuring Well-being Why does the United States rate low in the SEDA table?","The USA ranks 19th; this is due to high income inequality and low health and education scores.",0], ["Article 2: Measuring Well-being What is the relationship between SEDA and financial inclusion?","The more financial inclusion in a country (i.e. the grater the percentage of individuals 15 and over with a bank account), the greater the well-being of a country.",0], ["Both Articles: Explain why these two figures explain why GDP alone may not be a good measure of development.","They each point out that there are many other things besides GDP that measure the quality of life in a country. In particular, if countries grow their GDP at the expense of the environment, they will not improve the quality of life of their citizens.",0] ]



function populate() {

document.getElementById("page_title").innerHTML= page_title;



	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("main_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.innerHTML = "<p>"+(i+1)+": "+index[i][0]+"</p>";

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