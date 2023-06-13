<!DOCTYPE html>

<html lang="en">

<head>

<?php include "../header.php"; ?>

<style>

th, td {

  border: 1px solid black;
  padding:5px;
  text-align: center;
}

table {

  border-collapse: collapse;
}

#clearButton {
  display:none;
}

.changeButton {
  margin: 2px;
}

input[type="number"] {
	width: 30px;
}

</style>




</head>


<body>

<?php include "../navbar.php"; ?>

<h1>Terms of Trade Exercise</h1>


<p>Terms of trade is a concept that compares the value of a country&rsquo;s exports to that of its imports. It is a way of answering the following question: &ldquo;How many exports do I have to sell to purchase my imports?&rdquo;</p>
<p>Let&rsquo;s illustrate this in a personal way. In the input box below enter:</p>
<ul>
<li>The hourly wage for your job (or a job that you would like to have).</li>
<li>A consumer good that you purchase regularly.</li>
<li>The price of this good.</li>
</ul>
<p>When you click &lsquo;add row&rsquo; you will add rows to a table that will show:</p>
<ul>
<li>The number of working hours required to purchase the good</li>
<li>Your &lsquo;Terms of Trade&rsquo;</li>
</ul>

<p>
  <label for="wageRate">Hourly Wage: &pound;</label>
  <input type="number" id="wageRate" min=0 step=1 pattern="\d*" value="7">
</p>
<p>
  <span id="goodNameInput">
  <label for="goodName">Name of Good:</label>
  <input type="text" id="goodName">
</p>
<p>
  </span>
  <label for="goodPrice">Price of Good: &pound;</label>
  <input type="number" id="goodPrice" min=0 step=1 pattern="\d*" value="21">
</p>

<p>
  <input type="submit" value="Click to add row" onclick="addRow()">
</p>
<table id="summaryTable">
<tr><th>Hourly Wage</th><th>Price of <span class='goodNameClass'>Good</span></th><th>Hours Worked to Purchase <span class='goodNameClass'>Good</span></th><th>Terms of Trade</th></tr>
</table>
<div id="clearButton">
  <br>
  <button onclick="clearValues()">Clear values</button>
</div>
<p>Explore what happens with the following tasks:</p>
<ul>
<li>Gradually change the price of the good you purchase while keeping your hourly wage constant. What happens to the hours worked to purchase the good? What happens to your terms of trade?
  <p><button class="changeButton" onclick="changePrice('+')">Increase Price</button><button class="changeButton" onclick="changePrice('-')">Decrease Price</button>
  </p>
</li>
<li>Gradually change your wage while keeping the price of the good constant. What happens to the hours worked to purchase the good? What happens to your terms of trade?
  <p><button class="changeButton" onclick="changeWage('+')">Increase Wage</button><button class="changeButton" onclick="changeWage('-')">Decrease Wage</button></li>
  </p>
</ul>
<h2>Summary Questions:</h2>
<ol>
<li>Would you rather have a strong or a weak terms of trade? Explain.</li>
<li>How is the &lsquo;Hours Worked to Purchase Good&rsquo; column calculated?</li>
<li>How is the &lsquo;Terms of Trade Column&rsquo; calculated?</li>
<li>What does the &lsquo;Terms of Trade&rsquo; mean? i.e. What does a value of 110 mean compared to a value of 90?</li>
<li>Extension: Your hourly wage is a way of brining money into your life; it&rsquo;s an export. Your purchase of consumer goods is money going out of your life; it&rsquo;s an import. Use the information in this exercise to create a formula that will explain terms of trade <em>for a country</em> rather than an individual.</li>
</ol>



<?php include "../footer.php"; ?>








<script>

var data = [];

var totIndex;


function roundTo(num,to)  {

return Math.round((num + Number.EPSILON) * 10**to) / (10**to)
}

function addRow() {

	var wageRate = parseFloat(document.getElementById("wageRate").value);
	var goodPrice = parseFloat(document.getElementById("goodPrice").value);
	var goodName = document.getElementById("goodName").value;
	var table= document.getElementById("summaryTable");
	
	var dataPoint = [];
	
	dataPoint[0] = wageRate;
	dataPoint[1] = goodPrice;
	dataPoint[2] = goodPrice/wageRate;
	
	if (data.length == 0) {
		totIndex = wageRate/goodPrice;
		//table.innerHTML = "<tr><th>Hourly Wage</th><th>Price of <span class='goodNameClass'>Good</span></th><th>Hours Worked to Purchase <span class='goodNameClass'>Good</span></th><th>Terms of Trade</th></tr>";
		
		if (goodName != "") {
			var goodSpan = document.getElementsByClassName("goodNameClass");
			for (var i=0; i<goodSpan.length; i++) {
				goodSpan[i].innerHTML = goodName;
			}
		}
		
		document.getElementById("clearButton").style.display = "block";
		
		
		document.getElementById("goodNameInput").style.display = "none";
	}
	
	dataPoint[3] = (wageRate/goodPrice)/totIndex*100;

	
	var tableLength = table.rows.length;
	
	var row = table.insertRow(tableLength);
	
	data.push(dataPoint);
	console.log(data);

	// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);

	// Add some text to the new cells:
	cell1.innerHTML = "&pound;"+roundTo(dataPoint[0],2);
	cell2.innerHTML = "&pound;"+roundTo(dataPoint[1],2);
	cell3.innerHTML = roundTo(dataPoint[2],2);
	cell4.innerHTML = roundTo(dataPoint[3],2);
	
	



}

function clearValues() {

	data = [];
	var table= document.getElementById("summaryTable").innerHTML="<tr><th>Hourly Wage</th><th>Price of <span class='goodNameClass'>Good</span></th><th>Hours Worked to Purchase <span class='goodNameClass'>Good</span></th><th>Terms of Trade</th></tr>";
	document.getElementById("goodNameInput").style.display = "inline";
	document.getElementById("clearButton").style.display = "none";

}

function changeWage(i) {

	var wageRate = parseFloat(document.getElementById("wageRate").value);
	
	if (i=="+") {
		document.getElementById("wageRate").value = wageRate + 1;
		addRow();
	}
	
	if (i=="-") {
		if(wageRate>0){
			document.getElementById("wageRate").value = wageRate - 1;
			addRow();
		}
	}


}

function changePrice(i) {

	var goodPrice = parseFloat(document.getElementById("goodPrice").value);
	
	if (i=="+") {
		document.getElementById("goodPrice").value = goodPrice + 1;
		addRow();
	}
	
	if (i=="-") {
		if(goodPrice>0){
			document.getElementById("goodPrice").value = goodPrice - 1;
			addRow();
		}
	}


}



</script>

</body>


</html>