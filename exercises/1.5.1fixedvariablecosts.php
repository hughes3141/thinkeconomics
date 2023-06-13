<html>

<head>

<?php include "../header.php"; 



/*

This resource created September 2021 based on 1.6.1barrierstoentry.php
-based on 2.1.5sras_shifts

A few ideas to improve:
-Possibly include more types, based on the notes on this topic.


*/



?>

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


.col1 {

width: 350px;

}
.col2 {

width: 110px

}


.col3 {

width: 500px
}

.col1, .col2, .col3{

	//width: 20px;

	}

@media screen and (max-width: 600px) {
	.col1, .col2, .col3{

	width: 30%;

	}
}



.explain, #explainButton  {

display: none;

}



</style>




</head>

<body onload = "populate()">

<?php include "../navbar.php"; ?>

<h1>Fixed vs Variable Costs</h1>

<P>For each of the following, state whether it is a:</P>
<ul>
<li>Fixed Cost</li>
<li>Variable Cost</li>
</ul>


<table id ="questionTable">
<tr>
<th class="col1">Example</th>
<th class="col2">Type</th>
<th style="display:" class = "explain col3">Explanation</th>
</tr></table>

<!--
<input type="radio" id="sras_i" name="curve">
<label for="sras_i">SRAS</label>

<input type="radio" id="lras_i" name="curve">
<label for="lras_i">LRAS</label>
-->

<button onclick="submit()">Submit</button>
<br>
<button onclick="explanations()" id="explainButton">Explanations</button>

<div id="scoreDiv">Score: <span id="score"></span>/<span id="total"></span></div>

<?php include "../footer.php"; ?>

<script>

var index = 
[
  ["Rent","fixed","Rent is paid based on the size of the premises. Producing more products does not mean that you will pay higher rent. Note: though increasing production significantly would require a bigger building or factory, thus increasing rent costs, this is an increase in capital and is therefore outside of the short-run time period."],
  ["Equipment leases ","fixed","Leases are paid for having use of the equipment, not on their use. Producing more or fewer products will not change the amount paid on the lease."],
  ["Depreciation ","fixed","Depreciation is an accounting principle that substracts from the value of your machines for a time period of use. Depreciation on all capital equipment, in general, will not depend on output levels."],
  ["Marketing and advertising","fixed","Marketing and advertising budget will be put toward the marketing campaign of the whole business. Producing more, or fewer, products does not affect the budget spent ont ehse activities."],
  ["Raw materials ","variable","Raw materials are used directly in the produciton process; if you produce more, you pay more raw materials."],
  ["Direct labour ","variable","Direct labour, i.e. labour that is used in the produciton, will increase as you need to increase your output."],
  ["Interest payments ","fixed","Interest payments are payments to the bank for previous loans. Producing more of your product does not affect the amount that you will pay in interest payments."],
  ["Packaging ","variable","The more you produce, the more you will have to package. So packaging is a cost that increases with output."],
  ["Depreciation due to usage ","variable","Depreciation that occurs directly with usage would increase as more is produced, hence it is a variable cost."],
  ["Power and gas used in manufacturing","variable","The power that is directly involved in the production process will increase as output increases, so the costs of this are variable."],
  ["Administrative costs  ","fixed","Administrative costs are those costs associated with whole-business admin, and not tied to production. A business will pay these costs whether they have high or low levels of output."],
  ["Shipping","variable","The more you produce, the more you will need to ship. So shipping costs increase with output, and are therefore variable."],
  ["Basic utilities including electric and telephone service","fixed","These utilities are provided for the business regardless of output, and as they do not change as output increases they are fixed."]
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
cell1.setAttribute("class", "col1");

var cell2 = row.insertCell(1);
cell2.innerHTML = '<input type="radio" id="sras_'+i+'" name="curve_'+i+'"><label for="sras_'+i+'">Fixed Cost</label><br><input type="radio" id="lras_'+i+'" name="curve_'+i+'"><label for="lras_'+i+'">Variable Cost</label>';
cell2.setAttribute("id", "cell2_"+i);
cell2.setAttribute("class", "col2");

var cell3 = row.insertCell(2);
cell3.innerHTML = index[i][2];
cell3.setAttribute("id", "cell3_"+i);

cell3.setAttribute("class", "explain col3");



}







}

function submit() {

answers.length = 0;
console.clear();

for(var i=0; i<index.length; i++) {


	var srasid = document.getElementById("sras_"+i);
	var lrasid = document.getElementById("lras_"+i);
	//var leftid = document.getElementById("left_"+i);
	//var rightid = document.getElementById("right_"+i);
	
	

	answers2 = [];
	answers2.length = 6;
	answers2[0] = index[i][0];
	
	if (srasid.checked == true) {answers2[1]="fixed"}
	else if (lrasid.checked == true) {answers2[1]="variable"}
	
	//if (leftid.checked == true) {answers2[2]="behavioural"}
	//else if (rightid.checked == true) {answers2[2]="structural"}
	
	
	
	if (answers2[1] == index[i][1]) {answers2[3] = true} else {answers2[3] = false};
	//if (answers2[2] == index[i][2]) {answers2[4] = true} else {answers2[4] = false};
	
	
	if (answers2[3] == true) {
	
	document.getElementById("cell2_"+i).setAttribute("class", "correct");
	document.getElementById("cell3_"+i).classList.add("correct");
	document.getElementById("cell3_"+i).classList.remove("incorrect");
	
	}  
	
	else {
	
	document.getElementById("cell2_"+i).setAttribute("class", "incorrect");
	document.getElementById("cell3_"+i).classList.add("incorrect");
	document.getElementById("cell3_"+i).classList.remove("correct");
	}
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

	
	answers.push(answers2)


}


score = answersMarks.reduce((a, b) => a + b, 0)


document.getElementById("scoreDiv").style.display="block";
document.getElementById("score").innerHTML = score;
document.getElementById("total").innerHTML = index.length;


//console.log(answers);
//console.log(score);


document.getElementById("explainButton").style.display="block";

}


function explanations() {


var button = document.getElementById("explainButton");

if (button.innerHTML == "Explanations") {


		var explain = document.getElementsByClassName("explain");

		for(var i=0; i<explain.length; i++) {


			explain[i].style.display="table-cell";

		}
		
		button.innerHTML = "Hide Explanations"
	}

else {

	var explain = document.getElementsByClassName("explain");

		for(var i=0; i<explain.length; i++) {


			explain[i].style.display="none";

		}

	button.innerHTML = "Explanations"
	}

}


</script>


</body>




</html>