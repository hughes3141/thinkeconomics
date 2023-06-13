<html>

<head>
<?php include "../header.php"; ?>

<style>

.answerDiv {
	background-color: pink;
	margin: 10px;
	display: none;
	}

.question {
	margin:0px; overflow: hidden; line-height: 1.6; border: 0pt black solid; padding; 5px;;
	}

.button {
	display: none;
	}

#contextDiv {

	border: 1px solid black;
}
</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php"; ?>


<h1><span id ="page_title"></span></h1>

<img src="files/234_01.JPG" style="display:block;  margin:auto;">
<br>
<a href="https://www.economist.com/finance-and-economics/2015/12/05/keeping-it-riyal" target="_blank">Click for Link to Article</a><br>
<a href="files/2.3.4 Keeping It Riyal.pdf" target="_blank">Click to PDF of Article</a>
<button style ="width: 100%" onclick="contextToggle()" id ="contextButton">Click for Further Context</button>

<div id="contextDiv" style="display:none">

<img src="files/234_02.JPG" style="display:block;  margin:auto; max-width: 100%;">
<a href="https://www.ceicdata.com/en/indicator/saudi-arabia/foreign-exchange-reserves" target="_blank">https://www.ceicdata.com/en/indicator/saudi-arabia/foreign-exchange-reserves</a> 
<br>

<img src="files/234_03.JPG" style="display:block;  margin:auto; max-width: 100%;">
<a href="https://www.xe.com/currencycharts/?from=USD&to=SAR&view=10Y" target="_blank">https://www.xe.com/currencycharts/?from=USD&to=SAR&view=10Y</a> 

</div>

<div id="question_div"></div>



<?php include "../footer.php"; ?>

<script>


var toggle = 0;

function contextToggle() {

var div = document.getElementById("contextDiv");
var button = document.getElementById("contextButton");

	if (toggle ==0) {


		div.style.display = "block";
		button.innerHTML = "Click to Hide Context";
		toggle =1;
	
	}
	
	else {
	
		div.style.display = "none";
		button.innerHTML = "Click for Further Context";
		toggle =0;
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

var page_title = "2.3.4 Keeping It Riyal: Article Summary Questions";
var root ="files/"
var index = [
  ["Between 2013 and 2015 the combined current-accounts of Gulf countries went from 21.6% surplus to 2.5% deficit. Why was this the case?","x",""],
  ["Extension: The Saudi Arabian Riyal is pegged against the dollar. Why did the country’s central bank need to spend $7bn of foreign reserves in order to finance the country’s current account deficit?","x",""],
  ["Extension 2: What does the article mean when it states that “The price of buying a riyal in a year’s time fell to its lowest level since 2002”?","x",""],
  ["“There is little evidence for Gulf countries to devalue if they can avoid it.” Explain why devaluation of their currencies would not increase their competitiveness.","x",""],
  ["Explain why Saudi Arabia’s levels of foreign currency reserves makes the author of the article sceptical that the country will devalue its currency.","x",""],
  ["“The failure of one peg would invite speculation against the others.” With this sentence in mind, explain why it would be in Saudi Arabia’s best interest to help its neighbours defend their fixed exchange rates.","x",""]
]



function populate() {

document.getElementById("page_title").innerHTML= page_title;



	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("question_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.setAttribute("class", "question");
	question.innerHTML = "<p>"+(i+1)+": "+index[i][0]+"</p>";
	
	
	
	
	var button = document.createElement("button");
	button.innerHTML = "Click for Answer";
	button.setAttribute("onclick","answer("+i+")");
	button.setAttribute("id", "b"+i);
	button.setAttribute("class", "button");
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
	answer.setAttribute("class", "answerDiv");
	
	
	
	question.appendChild(answer);

	main_div.appendChild(question);
	
	
	
	}


}	
	
function answer(i) {
	
	if (passed == false) {

	passwordPrompt();
	}
	
	if (passed == true) 
	
	{

	

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