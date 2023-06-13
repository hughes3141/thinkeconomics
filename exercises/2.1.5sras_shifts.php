<html>

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

<body onload = "populate()">

<?php include "../navbar.php"; ?>

<h1>SRAS and LRAS Shifts</h1>

<P>For each of the following, state:</P>
<ul>
<li>Whether the event would shift SRAS or LRAS</li>
<li>Whether it would shift the curve left or right</li>
</ul>


<table id ="questionTable">
<tr>
<th style="width: 50%">Situation</th>
<th>Curve</th>
<th>Shift</th>
</tr></table>

<!--
<input type="radio" id="sras_i" name="curve">
<label for="sras_i">SRAS</label>

<input type="radio" id="lras_i" name="curve">
<label for="lras_i">LRAS</label>
-->

<button onclick="submit()">Submit</button>

<div id="scoreDiv">Score: <span id="score"></span>/<span id="total"></span></div>

<?php include "../footer.php"; ?>

<script>

var index = 
[
  ["Improved vocational training programmes","lras","right"],
  ["Improved manufacturing capacity","lras","right"],
  ["Rise in oil prices","sras","left"],
  ["Improvement to the mobility of labour","lras","right"],
  ["Increase in money wages","sras","left"],
  ["Improved Innovation","lras","right"],
  ["Reduced raw material prices","sras","right"],
  ["Decrease in the exchange rate","sras","left"],
  ["Increase in VAT","sras","left"],
  ["Increase in occupational licensing", "lras", "left"]
]


var answers = [];
var answersMarks = []
var score;

function populate() {


for(var i=0; i<index.length; i++) {

var div = document.createElement("div");

var table = document.getElementById("questionTable");

var x = document.getElementById("questionTable").rows.length;
var y = Math.floor(Math.random()*x) +1;



console.log(y);

var row = table.insertRow(y);
var cell1=row.insertCell(0);

cell1.innerHTML = index[i][0];
cell1.setAttribute("id", "cell1_"+i);

var cell2 = row.insertCell(1);
cell2.innerHTML = '<input type="radio" id="sras_'+i+'" name="curve_'+i+'"><label for="sras_'+i+'">SRAS</label><br><input type="radio" id="lras_'+i+'" name="curve_'+i+'"><label for="lras_'+i+'">LRAS</label>';
cell2.setAttribute("id", "cell2_"+i);

var cell3 = row.insertCell(2);
cell3.innerHTML = '<input type="radio" id="left_'+i+'" name="dir_'+i+'"><label for="left_'+i+'">Left</label><br><input type="radio" id="right_'+i+'" name="dir_'+i+'"><label for="right_'+i+'">Right</label>';
cell3.setAttribute("id", "cell3_"+i);





}







}

function submit() {

answers.length = 0;
console.clear();

for(var i=0; i<index.length; i++) {


	var srasid = document.getElementById("sras_"+i);
	var lrasid = document.getElementById("lras_"+i);
	var leftid = document.getElementById("left_"+i);
	var rightid = document.getElementById("right_"+i);
	
	

	answers2 = [];
	answers2.length = 6;
	answers2[0] = index[i][0];
	
	if (srasid.checked == true) {answers2[1]="sras"}
	else if (lrasid.checked == true) {answers2[1]="lras"}
	
	if (leftid.checked == true) {answers2[2]="left"}
	else if (rightid.checked == true) {answers2[2]="right"}
	
	
	
	if (answers2[1] == index[i][1]) {answers2[3] = true} else {answers2[3] = false};
	if (answers2[2] == index[i][2]) {answers2[4] = true} else {answers2[4] = false};
	
	
	if (answers2[3] == true) {document.getElementById("cell2_"+i).setAttribute("class", "correct")}  else {document.getElementById("cell2_"+i).setAttribute("class", "incorrect")}
	if (answers2[4] == true) {document.getElementById("cell3_"+i).setAttribute("class", "correct")}  else {document.getElementById("cell3_"+i).setAttribute("class", "incorrect")}
	
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

	
	answers.push(answers2)


}


score = answersMarks.reduce((a, b) => a + b, 0)


document.getElementById("scoreDiv").style.display="block";
document.getElementById("score").innerHTML = score;
document.getElementById("total").innerHTML = index.length;


//console.log(answers);
//console.log(score);


}




</script>


</body>




</html>