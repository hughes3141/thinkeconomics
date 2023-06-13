<html>


<?php include '../header.php';?>

<head>

<style>

.answer {
	border: 1px solid black;
	background-color: pink;
	display: none ;
}


</style>

</head>


<body onload = "populate()">

<?php include '../navbar.php'; ?>

<h1>PED Practice Questions</h1>

<form id="myForm" method="post" action="exercise_submit.php">

<p style="display:none">Name: <input type = "text" name ="name" id = "name" style="display:" ></p>
<div style="display:none">
<input type = "text" name ="exercise_name" id = "f1" style="display:;" >
<input type = "text" name ="mark" id = "f2" style="display:;" >
<input type = "text" name ="percentage" id = "f3" style="display:;" >
<input type = "text" name ="record" id = "f4" style="display:;" >
<input type = "text" name ="answers_sum" id = "f5" style="display:;" >
<input type = "text" name ="responses_sum" id = "f6" style="display:;" >
</div>
</form>

<div style="display:none">
	<button onclick = "test()">Click to Test</button>
	<button onclick = "stopTest()">Stop Test</button>
</div>

<button onclick="showAnswers()" style="display:">Click For Answers</button>
<div id="question_div"></div>

<?php include '../footer.php'; ?>
<script>

/*

Brought to server based on elasticity_exercise2.6.html

This version created 7 june 2021 as a quick version to help students revise for upcoming test.
Objective of this exercise to:
-Give students a way to check answers (but not upload to system)

2.6
-Using form elements to export to PHP and MySQL.

2.5
-Using exercisesOrder to call exercises on populate()

2.4
-Setting question and answer arrays
-New condition to ensure price and revenue changes are as expected based on elasticity.
2.3 Has:
-Distribution control of answer types (elastic vs inelsatic)
-Populate loop testing (e.g. function "test()")

2.2 Has a few updates:
-Enable a pedCoeff from rounded deltaPrice and deltaQuant figures


2.1 is a re-drafting of 1.3
The aim is to create a document which:
-Allows to develop quesitons across multiple types.
-Using random starting points
-Based of deltaP and deltaQ as random values
-Always using a randomGen function (no arrays or writing random functions as it goes)
-Using this to calulate the end prodcut, depending on the question.
*/



var ex_name = "Test1"

/*
index[i] follows the format:
[quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no]
*/

var index = [
[50,50, 1, 2, 3, .5, -.5,.5,.05, -.5, .5,.05],
[200, 250, 10, 60, 70, 5, -.5,.5,.05, -.5,.5,.05],
[50,70,5, 80,90,1, -.5,.5,.05, -.5,.5,.05],
[100,160,10, 60,70,5, -.5,.5,.05, -.5,.5,.05],



];


/*
exerciseOrder determines the exercises that will be used.
The length of the array determines the number of questions
1 corresponds to exercise1 etc.
Descriptions of exercises below
Note that index.length is the determinant.
*/
var exerciseOrder = [1,2,3,4]


var pedValues = [];
var deltaPriceRecord = [];
var labelRecord = [[],[]]

//var labelRecord records: [[Question Nos with ELASTIC answers], [Question Nos with INELASTIC answers]]

var questionsAnswersResponses = [];
var answersSummary = [];
var responsesSummary = [];


function showAnswers() {
	
	
	
	
	var answersClass = document.getElementsByClassName("answer");	
	

	
	for(var i=0; i<answersClass.length; i++) {
		

		
		answersClass[i].style.display = "block";
		
		
	}
}


function randomGen(min, max, step) {

	return Math.round(
	(
	Math.floor(Math.random()*((max-min)/step +1))*step+min
	)
	*1000)/1000;

}

function round(number,dpNo) {

	return Math.round(number*(10**dpNo))/(10**dpNo);

}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/*Loop testing*/
var loadCount = 0; var myVar; function test() {myVar = setInterval(test2, 10);}function test2() {loadCount ++;	populate();	console.log(loadCount)}function stopTest() {  clearInterval(myVar);}

function populate() {


	
	console.clear();
	
	var count = 0;
	var typeDistribution = []
	
	do {
		document.getElementById("question_div").innerHTML="";
		var typeDistribution = []
		questionsAnswersResponses.length=0;
		answersSummary.length=0;
		labelRecord[0].length = 0;
		labelRecord[1].length = 0;
		pedValues.length = 0;
		
		for(var i=0; i<index.length; i++) {
			questionsAnswersResponses.push([]);
	//		}
	//		for(var j=0; j<(index.length); j++) {
				index[i].push(i);
				
				if (exerciseOrder[i] == 1) {
					genExercise1.apply(this, index[(i)]);
					}
				if (exerciseOrder[i] == 2) {
					genExercise2.apply(this, index[(i)]);
					}
				if (exerciseOrder[i] == 3) {
					genExercise3.apply(this, index[(i)]);
					}
				if (exerciseOrder[i] == 4) {
					genExercise4.apply(this, index[(i)]);
					}
			}
		
		
		count ++;
		
		typeDistribution.push(labelRecord[0].length/index.length);
		typeDistribution.push(labelRecord[1].length/index.length);

	
	}
	
	while (
		
		//(labelRecord[0].length > index.length*.7)||
		//(labelRecord[1].length > index.length*.7)
		
		typeDistribution[0]>.7||
		typeDistribution[1]>.7
		
	)
	
	//console.log(labelRecord);
	//console.log(typeDistribution);
	//console.log(count);
	//return count;
	
	/*
	
	for(var i=0; i<index.length; i++) {
	
		genExercise2.apply(this, index[i]);
	}
	*/
	

	console.log(questionsAnswersResponses);
	//console.log(index);
	
	
}
	
	
var pedCoeff = [];
var price = [];
var quant = [];
var revenue = [];
var deltaPrice = [];
var deltaQuant = []
var deltaPriceDirection;
var deltaQuantDirection;
var deltaRevenueDirection;
var pedCoeffLabel;




/*
var pedCoeff = [PED using unrounded deltaQuant[1] and deltaPrice[1], PED using these figures rounded to 2dp];
var price = [price 1, price 2 (a rounded figure to 2dp following the randomly suggested deltaP from deltaPrice[0])];
var quant = [quant 1, quant 2 (a rounded figure to 0dp following the randomly suggested deltaQ from deltaPrice[0])];
var revenue = [price1 x quant1, price2 x quant2];
var deltaPrice = [randomly generated delta from index, delta calculated useing rounded figures price[1] ];
var deltaQuant = [randomly generated delta from index, delta calculated useing rounded figures quant[1]]
*/

function genValues(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no) {



	do {
		deltaQuant[0] = randomGen(deltaQuantMin, deltaQuantMax, deltaQuantStep);
		deltaPrice[0] = randomGen(deltaPriceMin, deltaPriceMax, deltaPriceStep);
		
		price[0] = randomGen(priceMin, priceMax, priceStep);
		quant[0] = randomGen(quantMin, quantMax, quantStep);
		price[1] = round((price[0]*(1+deltaPrice[0])), 2);
		quant[1] = round((quant[0]*(1+deltaQuant[0])), 0);
		
		deltaQuant[1]=(quant[1]-quant[0])/quant[0];
		deltaPrice[1]=(price[1]-price[0])/price[0];
	
		pedCoeff[0] = round((deltaQuant[1]/deltaPrice[1]), 2);
		pedCoeff[1] = round((round(deltaQuant[1], 2)/round(deltaPrice[1],2)), 2);
		
		revenue[0] = quant[0]*price[0];
		revenue[1] = quant[1]*price[1];
		
		
	
	}
	while (
		(deltaQuant[0]*deltaPrice[0]>0)||
		(deltaQuant[0] ==0)||
		(deltaPrice[0] ==0)||
		
		(price[0]==price[1])||
		(quant[0]==quant[1])||
		
		(round(pedCoeff[0],1) == -1)||
		
		//((pedCoeff[0]>-1.1)&&(pedCoeff[0]<-0.9)&&(deltaQuant[0]>.25))||
		((pedCoeff[0]<-1)&&(price[0]<price[1])&&(revenue[0]<revenue[1]))||
		((pedCoeff[0]<-1)&&(price[0]>price[1])&&(revenue[0]>revenue[1]))||
		((pedCoeff[0]>-1)&&(price[0]<price[1])&&(revenue[0]>revenue[1]))||
		((pedCoeff[0]>-1)&&(price[0]>price[1])&&(revenue[0]<revenue[1]))||
		
		(pedCoeff[0] < -3)||
		(pedCoeff[0] !== pedCoeff[1])||
		
		(pedValues.includes(pedCoeff[0]) == true)
		
	)
	
	if (deltaPrice[0] > 0) {deltaPriceDirection = "rises"}
	else if (deltaPrice[0] < 0) {deltaPriceDirection = "falls"}
	if (deltaQuant[0] > 0) {deltaQuantDirection = "rises"}
	else if (deltaQuant[0] < 0) {deltaQuantDirection = "falls"}
	if (revenue[1]>revenue[0]) {deltaRevenueDirection = "rises"}
	else if (revenue[1]<revenue[0]) {deltaRevenueDirection = "falls"}
	
	if (pedCoeff[0]<-1) {pedCoeffLabel = 1; labelRecord[0].push(question_no)}
	else if (pedCoeff[0]>-1) {pedCoeffLabel = 0; labelRecord[1].push(question_no)}
	
	pedValues.push(pedCoeff[0]);
	
	//console.log("Quantity: "+quant+", Price: "+price);
	//console.log("deltaQuant: "+deltaQuant+", deltaPrice: "+deltaPrice);
	//console.log("PED "+question_no+": "+pedCoeff);
	//console.log("Revenue: "+revenue);
	//console.log(pedCoeffLabel);
	
	
	
	var x = [];
	x[0]=[quant[0], quant[1]];
	x[1]=[price[0], price[1]];
	x[2]=deltaQuant[1];
	x[3]=deltaPrice[1];
	x[4]=pedCoeff[0];
	x[5]=[(revenue[0]), (revenue[1])];
	x[6]= pedCoeffLabel;

	/*
	x[0]="Q:"+quant;
	x[1]="P:"+price;
	x[2]= "dQ:"+round(deltaQuant[1], 4);
	x[3]= "dP:"+round(deltaPrice[1], 4);

	x[4]= "PED:"+pedCoeff[0];
	x[5]= "Rev:"+revenue;
	x[6]= pedCoeffLabel;
	
*/
	//questionsAnswersResponses[question_no].push("Q:"+quant+",P:"+price+",dQ:"+round(deltaQuant[1], 4)+",dP:"+round(deltaPrice[1], 4)+",PED:"+pedCoeff[0]+",Rev:"+revenue+","+pedCoeffLabel)
	questionsAnswersResponses[question_no].push(x);
	//questionsAnswersResponses[question_no].push([]);
	

}

function genExercise1(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no) {	

/*
Exercise 1 is an elasticity exercised based on calculating PED from initial P and Q and changes in each.
P and Q values are generated randomly using the randomGen function
deltaP and deltaQ are generated randomly using the randomGen function
Optional extra questions to include:
-Say whether elastic/inelastic (p6)
-Calculate original and new revenues (p4, p5)
*/

	genValues(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no)
	
	
	//Document Formatting		
	

	
	var div = document.createElement("div");
	var header = document.createElement("h2");
	header.innerHTML = "Question "+(question_no+1)+":";
	var p1 = document.createElement("p");
	p1.innerHTML = 'Price '+deltaPriceDirection+' from &pound;'+price[0].toFixed(2)+' to &pound;'+price[1].toFixed(2);
	var p2 = document.createElement("p");
	p2.innerHTML = 'Quantity '+deltaQuantDirection+' from '+quant[0]+' to '+quant[1];
	var p3 = document.createElement("p");
	p3.innerHTML = 'What is the PED of this product?'

	//	<input type="number" id ="'+question_no+'_0" class="question_'+question_no+' ex1">';
	var p4 = document.createElement("p");
	p4.innerHTML = 'What was the revenue for this product before the price change?'
	//	<input type="number" id ="'+question_no+'_1" class="question_'+question_no+' ex1">';
	var p5 = document.createElement("p");
	p5.innerHTML = 'What is the revenue for this product after the price change?'
	// <input type="number" id ="'+question_no+'_2" class="question_'+question_no+' ex1">';
	var p6 = document.createElement("p");
	p6.innerHTML = 'This product is:<br><input type="radio" id="elastic_'+question_no+'" name="elasticity" ><label for="elastic_'+question_no+'">Elastic</label><br><input type="radio" id="inelastic_'+question_no+'" name="elasticity" ><label for="inelastic_'+question_no+'">Inelastic</label>';
	var p7 = document.createElement("div");
	p7.innerHTML = '<input type="text" class="question_'+question_no+' ex1" id = "pedCoeffType_'+question_no+'">';
	p7.style.display="none";
	
	


	
	div.appendChild(header);
	div.appendChild(p1);
	div.appendChild(p2);
	div.appendChild(p3);
	//div.appendChild(p6);
	div.appendChild(p7);
	div.appendChild(p4);
	div.appendChild(p5);
	
	
	document.getElementById("question_div").appendChild(div);
	
	
	//Answers:
	
	var answers = [pedCoeff[0], pedCoeffLabel, round(revenue[0], 2), round(revenue[1],2)];
	questionsAnswersResponses[question_no].push(answers);
	answersSummary.push(answers);
	
			
	var p8 = document.createElement("div");
	p8.setAttribute("class", "answer");
	p8.innerHTML = '<h2>Answers:</h2>PED: '+answers[0]+'<br>Old Revenue: &#163;'+answers[2].toFixed(2)+'<br>New Revenue: &#163;'+answers[3].toFixed(2);	
	div.appendChild(p8);
}			
	
function genExercise2(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no) {


/*
Exercise 2 is an elasticity exercised based on calculating PED from initial P and Revenue (e.g. 1101.170603) and changes in each.
P and Q values are generated randomly using the randomGen function.
Revenue is derived from this.
deltaP and deltaQ are generated randomly using the randomGen function
*/

	genValues(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no)

	//Document Formatting		
	
	var div = document.createElement("div");
	var header = document.createElement("h2");
	header.innerHTML = "Question "+(question_no+1)+":";
	var p1 = document.createElement("p");
	p1.innerHTML = 'Price '+deltaPriceDirection+' from &pound;'+price[0].toFixed(2)+' to &pound;'+price[1].toFixed(2);
	var p2 = document.createElement("p");
	p2.innerHTML = 'Revenue '+deltaRevenueDirection+' from &pound;'+numberWithCommas(revenue[0].toFixed(2))+' to &pound;'+numberWithCommas(revenue[1].toFixed(2));
	var p3 = document.createElement("p");
	p3.innerHTML = 'What is the PED of this product?'
	//<input type="number" id ="'+question_no+' " class="question_'+question_no+' ex2">';
	
	
	div.appendChild(header);
	div.appendChild(p1);
	div.appendChild(p2);
	div.appendChild(p3);	
		
	document.getElementById("question_div").appendChild(div);
	
	
	//Answers:
	
	var answers = [pedCoeff[0]];
	questionsAnswersResponses[question_no].push(answers);
	answersSummary.push(answers);			
	
	
	var p8 = document.createElement("div");
	p8.setAttribute("class", "answer");
	p8.innerHTML = '<h2>Answer:</h2>PED: '+answers[0];	
	div.appendChild(p8);
		
}

function genExercise3(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no) {	

/*
Exercise 3 requires calculating the change in quantity given P change and PED
*/

	genValues(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no)
	
	
	//Document Formatting		
	
	var div = document.createElement("div");
	var header = document.createElement("h2");
	header.innerHTML = "Question "+(question_no+1)+":";
	var p1 = document.createElement("p");
	p1.innerHTML = 'Price '+deltaPriceDirection+' from &pound;'+price[0].toFixed(2)+' to &pound;'+price[1].toFixed(2);
	var p2 = document.createElement("p");
	p2.innerHTML = 'Original Quantity: '+quant[0];
	var p3 = document.createElement("p");
	p3.innerHTML = 'PED: '+pedCoeff[0];
	var p4 = document.createElement("p");
	p4.innerHTML = 'What is the new Quantity following the price change?'
	//	<input type="number" id ="'+question_no+'" class="question_'+question_no+' ex3">';
	/*var p5 = document.createElement("p");
	p5.innerHTML = 'What is the revenue for this product after the price change? <input type="number" id ="'+question_no+'_2">';
	var p6 = document.createElement("p");
	p6.innerHTML = 'This product is:<br><input type="radio" id="elastic_'+question_no+'" name="elasticity" ><label for="elastic_'+question_no+'">Elastic</label><br><input type="radio" id="inelastic_'+question_no+'" name="elasticity" ><label for="inelastic_'+question_no+'">Inelastic</label>';
	*/
	div.appendChild(header);
	div.appendChild(p1);
	div.appendChild(p2);
	div.appendChild(p3);

	div.appendChild(p4);

	
	document.getElementById("question_div").appendChild(div);
			
	//Answers:
	
	var answers = [quant[1]];
	questionsAnswersResponses[question_no].push(answers);	
	answersSummary.push(answers);
	
	
	var p8 = document.createElement("div");
	p8.setAttribute("class", "answer");
	p8.innerHTML = '<h2>Answer:</h2>New Quantity: '+answers[0];	
	div.appendChild(p8);
}			
	
function genExercise4(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no) {	

/*
Exercise 4 requires calculating Revenue 2 from Pchnage, PED, and Revenue 1
*/

	genValues(quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no)
	
	
	//Document Formatting		
	
	var div = document.createElement("div");
	var header = document.createElement("h2");
	header.innerHTML = "Question "+(question_no+1)+":";
	var p1 = document.createElement("p");
	p1.innerHTML = 'Price '+deltaPriceDirection+' from &pound;'+price[0].toFixed(2)+' to &pound;'+price[1].toFixed(2);
	var p2 = document.createElement("p");
	p2.innerHTML = 'Original Revenue: &pound;'+numberWithCommas(revenue[0].toFixed(2));
	var p3 = document.createElement("p");
	p3.innerHTML = 'PED: '+pedCoeff[0];
	var p4 = document.createElement("p");
	p4.innerHTML = 'What is the new Revenue following the price change? '
	//<input type="number" id ="'+question_no+'" class="question_'+question_no+' ex4">';
	/*var p5 = document.createElement("p");
	p5.innerHTML = 'What is the revenue for this product after the price change? <input type="number" id ="'+question_no+'_2">';
	var p6 = document.createElement("p");
	p6.innerHTML = 'This product is:<br><input type="radio" id="elastic_'+question_no+'" name="elasticity" ><label for="elastic_'+question_no+'">Elastic</label><br><input type="radio" id="inelastic_'+question_no+'" name="elasticity" ><label for="inelastic_'+question_no+'">Inelastic</label>';
	*/
	div.appendChild(header);
	div.appendChild(p1);
	div.appendChild(p2);
	div.appendChild(p3);
	//div.appendChild(p6);
	div.appendChild(p4);
	//div.appendChild(p5);
	
	document.getElementById("question_div").appendChild(div);
			
	//Answers:
	
	var answers = [round(revenue[1],2)];
	questionsAnswersResponses[question_no].push(answers);
	answersSummary.push(answers);	
	
	var p8 = document.createElement("div");
	p8.setAttribute("class", "answer");
	p8.innerHTML = '<h2>Answer:</h2>New Revenue: &#163;'+numberWithCommas(answers[0].toFixed(2));	
	div.appendChild(p8);

}			




function submit() {

var scoreSummary = [];
var scoreCumulative = [];

for(var j=0; j<index.length; j++) {


	var ex1Responses = [];
	
	if (exerciseOrder[j] == 1) {
		var exercise1 = document.getElementsByClassName("ex1")
		}
	if (exerciseOrder[j] == 2) {
		var exercise1 = document.getElementsByClassName("ex2")
		}	
	if (exerciseOrder[j] == 3) {
		var exercise1 = document.getElementsByClassName("ex3")
		}
	if (exerciseOrder[j] == 4) {
		var exercise1 = document.getElementsByClassName("ex4")
		}
	

	if (exerciseOrder[j] == 1) {
		var pedButton = [];
		pedButton[0] = document.getElementById("elastic_"+j);
		pedButton[1] = document.getElementById("inelastic_"+j);
		var pedCoeffResponse;
		if (pedButton[0].checked == true) {
			pedCoeffResponse = 1
			}
		else if (pedButton[1].checked == true) {
			pedCoeffResponse = 0
			}
		document.getElementById("pedCoeffType_"+j).value = pedCoeffResponse
	}

for(var i=0; i<exercise1.length; i++) {

	if (exercise1[i].classList.contains("question_"+j) == true) {
		console.log(exercise1[i].value);
		if ((exercise1[i].value =="Elastic")||(exercise1[i].value =="Inelastic")) {
			ex1Responses.push((exercise1[i].value))
			}
		else {
			ex1Responses.push(parseFloat(exercise1[i].value))
			}
		}
		
}


if (questionsAnswersResponses[j].length = 3) {
		questionsAnswersResponses[j].pop();}
		
	questionsAnswersResponses[j].push(ex1Responses);
	
	
	responsesSummary.push(ex1Responses);
	
	
var score = [];

	for(var i=0; i<questionsAnswersResponses[j][1].length; i++) {
		if (round(questionsAnswersResponses[j][1][i],2) == round(questionsAnswersResponses[j][2][i], 2)) {
			score.push(true);
			scoreCumulative.push(true)
			}
		else {
			score.push(false);
			scoreCumulative.push(false)
			}
		
		
	}
	


		
		
	
	scoreSummary.push(score);
	
	//Check this next one:
	//questionsAnswersResponses[j].push(score);
	


}

var countScore = 0;
for(var i = 0; i < scoreCumulative.length; ++i){
    if(scoreCumulative[i] == true)
        countScore++;
}

var scorePercentage = countScore/(scoreCumulative.length)

console.clear();
console.log(questionsAnswersResponses);
console.log(answersSummary);
console.log(responsesSummary);
//console.log(scoreSummary);
console.log(scoreCumulative);
console.log(scorePercentage);

/*
console.log(questionsAnswersResponses[1][1].length);
for (var i=0; i<index.length; i++) {
console.log(questionsAnswersResponses[j][1].length)
}
 */



//console.log(score);

	document.getElementById("f1").value = ex_name;
	document.getElementById("f2").value = countScore;
	document.getElementById("f3").value = scorePercentage;
	document.getElementById("f4").value = questionsAnswersResponses;
	document.getElementById("f5").value = answersSummary;
	document.getElementById("f6").value = responsesSummary;
	
	//document.getElementById("myForm").submit();
	
}
/*

More exercises:

-Calculate 



*/

</script>


</body>

</html>