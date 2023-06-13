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

.col3 {

	display: none;
}

</style>

</head>

<body>
<?php include "../navbar.php";?>
<h1>1.6.2 Objectives of Firms: Graph Points</h1>
<p>Match up the objectives in the left column with the point on the graph below.</p>

<img src="files/1.6.2objectives.jpg">

<table id ="questionTable">
<tr>
<th style="width: 50%">Objective/Event</th>
<th>Point on Graph</th>
<th class ="col3">Explanation</th>
</tr></table>

<button onclick="submit()">Submit</button>
<br>


<div id="scoreDiv">Score: <span id="score"></span>/<span id="total"></span></div>


<button onclick="toggle()" id ="toggleButton">Click to show explanations</button>
<?php include "../footer.php";?>
<script>

var index = 
[
  ["Profits are maximised","C","This occurs where MR = MC (where we usually draw the output)"],
  ["PED = -1","D","PED is unt elastic where revenue is maximised; in other words, where MR = 0"],
  ["The firm is allocatively efficient","F","Allocative Efficiency occurs where P=MC; where MC = AR (because AR = P)"],
  ["Normal profits are made (point 1/2)","A, G","Normal Profit is defined as Economic Profit = 0; where AR = AC"],
  ["Normal profits are made (point 2/2)","A, G","Normal Profit is defined as Economic Profit = 0; where AR = AC"],
  ["Sales revenue is maximised","D","Sales Revenue is maximised at the point where MR = 0"],
  ["The firm is productively efficient","E","Productive Efficiency occurs where AC is at its lowest point; where AC = MC"],
  ["Output maximisation occurs (subject to normal profit being made)","G","This is the highest possible level that output can occur before the firm starts to make a loss"],
  ["Community surplus would be maximised","F","This phrase is another definition of Allocative Efficiency; where P = MC"],
  ["Diminishing returns to the variable factor set in","B","Diminishin Returns to Variable Factor mean that the MC curve changes direction from down-sloping to upward-sloping"]
]


var answers = [];
var answersMarks = []
var score;


function toggle() {

var toggleButton = document.getElementById("toggleButton");
var col3 = document.getElementsByClassName("col3");

if (toggleButton.innerHTML == "Click to show explanations") {
	
	toggleButton.innerHTML = "Click to hide explanations";

		for (var i=0; i<col3.length; i++) {
	
		col3[i].style.display="table-cell";
	
		}
	}
	else {
	toggleButton.innerHTML = "Click to show explanations";

		for (var i=0; i<col3.length; i++) {
	
		col3[i].style.display="none";
	
		}
		}



}

for(var i=0; i<index.length; i++) {

var div = document.createElement("div");

var table = document.getElementById("questionTable");

var x = document.getElementById("questionTable").rows.length;
var y = Math.floor(Math.random()*x) +1;



console.log(y);

var row = table.insertRow(x);
var cell1=row.insertCell(0);

cell1.innerHTML = index[i][0];
cell1.setAttribute("id", "cell1_"+i);

var cell2 = row.insertCell(1);
cell2.innerHTML = '<select name="point" id="point'+i+'"><option value="" selected></option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option></select>';
cell2.setAttribute("id", "cell2_"+i);


var cell3 = row.insertCell(2);
cell3.innerHTML = index[i][2];
cell3.setAttribute("id", "cell3_"+i);
cell3.setAttribute("class", "col3");





}









function submit() {

answers.length = 0;
console.clear();

for(var i=0; i<index.length; i++) {

	var response = document.getElementById("point"+i).value;
	//var srasid = document.getElementById("sras_"+i);
	//var lrasid = document.getElementById("lras_"+i);
	//var leftid = document.getElementById("left_"+i);
	//var rightid = document.getElementById("right_"+i);
	
	

	answers2 = [];
	answers2.length = 6;
	answers2[0] = index[i][1];
	answers2[1] = response;
	if ((answers2[1] != "")&&(answers2[0].includes(answers2[1]))) {answers2[2] = true}
	else {answers2[2] = false};
	
	if (answers2[2] == true) {document.getElementById("cell2_"+i).setAttribute("class", "correct");document.getElementById("cell1_"+i).setAttribute("class", "correct");answersMarks[i] =1;document.getElementById("cell3_"+i).classList.add("correct");document.getElementById("cell3_"+i).classList.remove("incorrect")}  else {document.getElementById("cell2_"+i).setAttribute("class", "incorrect");document.getElementById("cell1_"+i).setAttribute("class", "incorrect");answersMarks[i] =0;document.getElementById("cell3_"+i).classList.add("incorrect");document.getElementById("cell3_"+i).classList.remove("correct")}
	
	/*
	
	if (srasid.checked == true) {answers2[1]="structural"}
	else if (lrasid.checked == true) {answers2[1]="behavioural"}
	
	//if (leftid.checked == true) {answers2[2]="behavioural"}
	//else if (rightid.checked == true) {answers2[2]="structural"}
	
	
	
	if (answers2[1] == index[i][1]) {answers2[3] = true} else {answers2[3] = false};
	//if (answers2[2] == index[i][2]) {answers2[4] = true} else {answers2[4] = false};
	
	
	if (answers2[3] == true) {document.getElementById("cell2_"+i).setAttribute("class", "correct")}  else {document.getElementById("cell2_"+i).setAttribute("class", "incorrect")}
	//if (answers2[4] == true) {document.getElementById("cell3_"+i).setAttribute("class", "correct")}  else {document.getElementById("cell3_"+i).setAttribute("class", "incorrect")}
	
	if (
	(answers2[3] == true)
	//& (answers2[4] == true)
	) 
	{
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

console.log(answers);

score = answersMarks.reduce((a, b) => a + b, 0)


document.getElementById("scoreDiv").style.display="block";
document.getElementById("score").innerHTML = score;
document.getElementById("total").innerHTML = index.length;


//console.log(answers);
//console.log(score);


}




</script>

</body>

</body>


</html>