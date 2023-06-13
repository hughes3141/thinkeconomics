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

<img src="files/234_04.JPG" style="display:block;  margin:auto;">
<br>
<a href="https://www.economist.com/finance-and-economics/2015/10/15/pegs-under-pressure" target="_blank">Click for Link to Article</a><br>
<a href="files/2.3.4 Pegs Under Pressure.pdf" target="_blank">Click to PDF of Article</a>
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

var page_title = "2.3.4 Pegs Under Pressure";
var root ="files/"
var index = [
  ["“This penchant for pegs makes sense.” Explain two advantages, cited in the article, of operating a fixed exchange rate system.","x",""],
  ["“Pegs come with strings attached.” Explain the disadvantages of using a fixed exchange rate system, as mentioned in the article.","x",""],
  [" “In a free market, a shock such as the collapse in the value of exports would boost relative demand for foreign exchange, which in turn would cause the domestic currency to depreciate.” Explain this sentence, using an exchange rate diagram.","x",""],
  ["Explain how Hong Kong is able to maintain a stable exchange rate against the dollar.","x",""],
  ["Explain, specifically, how Saudi Arabia intends to defend its fixed exchange rate against the dollar.","x",""],
  ["Extension: Why would breaking the Kazach tenge’s devaluation might lead to street protests.","x",""],

  ["Extension: Why has the Nigerian central bank banned purchase of certain items?","x",""],
  ["Extension: Why would increasing prices in the manufacturing sector, caused by the import ban, help to further depreciate the value of the Nigerian currency?","x",""],
  ["Which part of the ‘impossible trinity’ does Venezuela appear to be cracking down on? Explain how this will help to stabilise its exchange rate.","x",""]
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