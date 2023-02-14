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
<a href = "files/1.1.3 The Construction Industry's Productivity Problem.pdf" target = "_blank" ><img src = "files/1.1.3_01.JPG" style="max-width: 100%;"></a><br>
<a href = "files/1.1.3 The Construction Industry's Productivity Problem.pdf" target = "_blank" >PDF: The Construction Industry's Productivity Problem</a>
<p><em>17 August 2017</em></p>


<h2>Instructions</h2>
<p>Click on the link above to access the PDF to the article: The Construction Industry's Productivity Problem.</p>

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

var page_title = "The Construction Industry's Productivity Problem: Article Questions";
var root ="images/"
var index = [
  ["<p>What has happened to productivity growth worldwide since the financial crisis?</p>","<p>Since the financial crisis, productivity growth has been weak.</p>"],
  ["<p>Why has that been?</p>","<p>Because of the uncertainty, firms are more likely to hire more workers than to invest in new equipment.</p>"],
  ["<p>What has been the trend in average value-added per hour in the construction industry?</p>","<p>It has been a quarter of that in the manufacturing industry; since 1995 it has gone up by approximately 20%.</p>"],
  ["<p>What has been the situation in rich countries? (no need to be specific).</p>","<p>In rich countries construction productivity has been especially poor.</p>"],
  ["<p>Explain the main reasons why the construction industry has seen poor productivity growth.</p>","<p>The construction industry has seen poor productivity growth because:</p><ul><li>Most building companies are small: less than 5% of builders work for construction firms that employ over 10,000 workers in the USA, compared with 23% in business services and 25% in manufacturing. This suggests that many of these smaller firms are not able to invest in the type of capital equipment that would make them more productive.</li><li>Its profit margins are the lowest in any industry besides retailing- implying that firms do not have enough profit to invest in expensive, productive machinery.</li><li>The industry is highly cyclical- it goes through booms and busts. Firms don&rsquo;t want to invest in expensive capital because it raises their fixed costs, which they may not be able to pay in a downturn.</li></ul>"],
  ["<p>Explain one suggestion that could make the construction industry more productive, yet which is generally not invested in.</p>","<ul><li>Project management software would allow building firms to plan out projects to be carried out in the most time-efficient way.</li><li>Mass production would allow products to be completed on an assembly-line, rather than more slowly and by hand on a building site.</li><li>Remote-controlled cranes would be more time-efficient than human-operated ones, which would make a firm more productive.</li></ul>"],
  ["<p>What does the article suggest the government could do to improve productivity in the construction industry?</p>","<p>The article suggests that governments improve productivity in construction in the following ways:</p><ul><li>Governments could smooth out their spending on construction projects. This would mean that construction companies would know they have regular work and would be more willing to invest in capital equipment (in American and Europe, the public sector accounts for 20-30% of all construction spending).</li><li>Governments could make building codes across districts more similar to encourage mass production of construction components. There are currently 93,000 different building codes in America. If these were simpler, construction companies could make more mass-produced products that would be appropriate for all areas.</li><li>Require public-sector projects to use software to produce digital construction plans. The hope would be that if construction companies use them for public projects, they would have the technology and be happy to use them on smaller private projects.</li></ul>"],
  ["<p>According to the article, why is it so important to boost productivity in construction?</p>","<p>It is important to boos productivity in the construction industry because this industry is worth $10trn each year, and the money wasted on low productivity means that investors, citizens, and customers are not benefitting as much as they could be.</p>"]
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