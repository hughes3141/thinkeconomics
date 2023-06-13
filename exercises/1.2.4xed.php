<html>


<?php

/*

This resource was created in July 2021 quickly.

A few ideas to make it better:
-Inclue extensive information/review section after user submits work to explain (remember there are multiple correct answers for each question).

*/


?>

<head>

<?php include "../header.php"; ?>


<style>

table {

border: 1px solid black;
border-collapse: collapse;
}

td, th {
border: 1px solid black;
padding: 5px;
}


.correct {


background-color: #b3ffb3;

}

.incorrect {


background-color: #ffffb3;
//#ffd699;

}

#scoreDiv {

display: none;
}

</style>




</head>

<body onload="populate()">

<?php include "../navbar.php"; ?>




<h1>XED Exercises</h1>

<p>What do you think the impact of a 20% fall in the price of the first product will be on the demand for the second product?</p>
<p>Pick from the options below:</p>

<ul id ="choiceList">


</ul>



<table id="questionTable">
<tbody><tr>
<th>20% fall in the price of</th>
<th>Impact on demand</</th>
<th>Demand changes . . .</th>
</tbody>
</table>



<button onclick="submit()">Submit</button>

<div id="scoreDiv">Score: <span id="score"></span>/<span id="total"></span></div>

<?php include "../footer.php"; ?>

<script>

var index = 
[
  ["Petrol","Cars", [1]],
  ["Tea","Coffee", [3]],
  ["Xbox 1","Call of Duty", [0]],
  ["BP petrol","Shell petrol", [4]],
  ["Xbox 1","Playstation 4", [3]],
  ["Cars","Petrol", [0]],
  ["Cars","Motorcycles", [3]],
  ["Cars","Bananas", [2]],
  ["Bananas","Apples", [1,3]],
  ["Bus travel","Cars", [3]],
  ["Evian","Volvic", [3,4]],
  ["iPhones","iTunes downloads", [0]],
  ["Grapes","Tomatoes", [2]]
]

var choices = ["Rises more than proportionately", "Rises less than proportionately", "No change", "Falls less than proportionately", "Falls more than proportionately"]


var answers = [];
var answersMarks = []
var score;

function populate() {


for(var i=0; i<index.length; i++) {

var div = document.createElement("div");

var table = document.getElementById("questionTable");

var x = document.getElementById("questionTable").rows.length;

//Enable the following line to have table items generated in order as appears in index:
var y = i+1;

//Enable the following line to have table items generated in random order:
//var y = Math.floor(Math.random()*x) +1;




console.log(y);

var row = table.insertRow(y);
var cell1=row.insertCell(0);

cell1.innerHTML = "A 20% fall in the price of:<br><br><b>"+index[i][0]+"</b>";
cell1.setAttribute("id", "cell1_"+i);

var cell2 = row.insertCell(1);
cell2.innerHTML = "Will have what impact on the demand for:<br><br><b>"+index[i][1]+"</br>";
cell2.setAttribute("id", "cell2_"+i);

var cell3 = row.insertCell(2);



	for (var j=0; j<5; j++) {
	
		var tickbox = document.createElement("input");
		tickbox.setAttribute("type", "radio");
		tickbox.setAttribute("id", i+"_"+j);
		tickbox.setAttribute("name", "q_"+i);
		
		var label = document.createElement("label");
		label.setAttribute("for", i+"_"+j);
		label.innerHTML = choices[j];
		
		var br = document.createElement("br");
		
		cell3.appendChild(tickbox);
		cell3.appendChild(label);
		cell3.appendChild(br);
	
	
	}


//cell3.innerHTML = '<input type="radio" id="left_'+i+'" name="dir_'+i+'"><label for="left_'+i+'">Left</label><br><input type="radio" id="right_'+i+'" name="dir_'+i+'"><label for="right_'+i+'">Right</label>';
cell3.setAttribute("id", "cell3_"+i);





}


	for (var i=0; i<choices.length; i++) {
		
		var listItem = document.createElement("li");
		listItem.innerHTML = choices[i];
		
		document.getElementById("choiceList").appendChild(listItem);

	}




}

function submit() {

answers.length = 0;
console.clear();

for(var i=0; i<index.length; i++) {


	var answerID = [
	
	document.getElementById(i+"_"+0),
	document.getElementById(i+"_"+1),
	document.getElementById(i+"_"+2),
	document.getElementById(i+"_"+3),
	document.getElementById(i+"_"+4)
	
	]

/*
	var srasid = document.getElementById("sras_"+i);
	var lrasid = document.getElementById("lras_"+i);
	var leftid = document.getElementById("left_"+i);
	var rightid = document.getElementById("right_"+i);
	
*/

	answers2 = [];
	answers2.length = 6;
	answers2[0] = index[i][0]+" and "+index[i][1];
	
	for (var j=0; j<5; j++) {
	
		if (answerID[j].checked == true) {answers2[1] = j};
	
	
	
	}
	
	
/*	
	if (srasid.checked == true) {answers2[1]="sras"}
	else if (lrasid.checked == true) {answers2[1]="lras"}
	
	if (leftid.checked == true) {answers2[2]="left"}
	else if (rightid.checked == true) {answers2[2]="right"}
	
*/	


	if (index[i][2].includes(answers2[1])) {answers2[2] = true} else {answers2[2] = false};
	
	//if (answers2[1] == index[i][2]) {answers2[2] = true} else {answers2[2] = false};
	
	
	
	//if (answers2[2] == index[i][2]) {answers2[4] = true} else {answers2[4] = false};
	
	
	if (answers2[2] == true) {
	
		document.getElementById("cell1_"+i).setAttribute("class", "correct");
		document.getElementById("cell2_"+i).setAttribute("class", "correct");
		document.getElementById("cell3_"+i).setAttribute("class", "correct");
		
		answersMarks[i] =1;
		
		}  
		
		else {
		
		document.getElementById("cell1_"+i).setAttribute("class", "incorrect");
		document.getElementById("cell2_"+i).setAttribute("class", "incorrect");
		document.getElementById("cell3_"+i).setAttribute("class", "incorrect");
		
		answersMarks[i] =0;
		
		
		}
		
		
	//if (answers2[4] == true) {document.getElementById("cell3_"+i).setAttribute("class", "correct")}  else {document.getElementById("cell3_"+i).setAttribute("class", "incorrect")}
	
/*	
	
	if ((answers2[3] == true)&(answers2[4] == true)) {
		document.getElementById("cell1_"+i).setAttribute("class", "correct");
		//answers2[5] = 1;
		answersMarks[i] =1;
	}  
	else {
	
		document.getElementById("cell1_"+i).setAttribute("class", "incorrect");
		//answers2[5] = 0;
		answersMarks[i] =0;
	}
*/
	
	answers.push(answers2)


}


score = answersMarks.reduce((a, b) => a + b, 0)


document.getElementById("scoreDiv").style.display="block";
document.getElementById("score").innerHTML = score;
document.getElementById("total").innerHTML = index.length;


console.log(answers);
//console.log(score);


}




</script>







</body></html>