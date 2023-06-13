<!DOCTYPE html>

<html>


<head>

<?php include "../header.php";

/*
Played in year 1 groups on 12 and 13 January 2022. Good reception, would play again.
Some changes for future:
-Set rule so that students cannot trade below 0 level of permits (use conditional with transaction and balance variables)
-Set mechanism so that students are warned if they are about to do a trade that would be to their disadvantage. e.g. set a div that becomes visible when a studnet enters in a price for a trade that is not to their advantage



*/



?>


<style>

table {
	border-collapse: collapse

}

td, th {
	border: 1px solid black;
	padding: 5px;
}

.GFG {
           background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;
        }
		
li.pstyle {
 margin-top: 1em; margin-bottom: 1em; margin-left: 0; margin-right: 0;
}


ol.pstyle_list {
	//list-style-position: inside;
	//margin: 0;
	//padding-left: 0;
	
}



#div2, #div3, #div4, #div5, #div6, #dealDiv, #sellDiv, #buyDiv, #div7, #div7_1, #div8, #div9, #div10, #div11 {

	display: none;
}

#div7 {

	margin-top: 5px;
	margin-bottom: 5px;

}

.correct {


background-color: #b3ffb3;

}

</style>

</head>


<body>
<?php include "../navbar.php"; ?>

<h1>1.7.2 Tradable Pollution Permits Game</h1>

<div id="div1">
	<h2>Instructions</h2>

	<p>Each member of the class will be in charge of a business which emits CO2 pollution. Our goal is to reduce our overall cabon emissions so that we can correct this market failure.</p>

	<label for "firmSelect">Your firm:</label>
	<select id="firmSelect">
	  <option value="" disabled selected hidden>Select your option</option>
	</select>

	<button onclick="selectFirm(); hideDiv('div1'); showDiv('div2'); showDiv('div3')">Select Firm</button>

</div>

<div id="div2">

	<h2>Your Firm: <span class="firmDetailSpan"></span></h2>
	<img id="firmImg">
	<ul>

	  <li>Type: <span class="firmDetailSpan"></span></li>
	  <li>Current Emissions: <span class="firmDetailSpan"></span> tonnes</li>
	  <li>Cost of reducing emissions by 1 tonne: &pound;<span class="firmDetailSpan"></span></li>
	</ul>

</div>

<div id="div3">

	<h2>Situation 1: Everybody Reduces Emissions</h2>

	<p>In this first situation the government has mandated that each business must reduce its emissions to 1,000 tonnes of carbon.</p>
	<p>Calculate how much this will cost for your firm:
	  <input type="number" pattern = "\d*" id="reductionCostCalculation" step="500" min="0">
	  <button onclick="checkReductionValue()">Click to check value</button>
	</p>

	<div id="div4" class="correct">
	  <p>Correct! It will cost you &pound;<span class="reductionCostSpan"></span> to reduce your emissions.</p>
	  <p>Compile this information as a class, so we can see how much it cost to reduce our emissions.</p>
	  <p>When you are ready to move on, click here: <button onclick="showDiv('div6'); hideDiv('div3'); showDiv('div7'); showDiv('div7_1');  showDiv('div8')">Next stage</button></p>
	</div>


	<div id="div5">
	  <p>Hmm . . . not quite correct. Review your work and try again.</p>
	  <p>Want a hint? <button id="toggleButton1" onclick="toggleElement('toggleButton1','toggleDiv1')">Click to show</button></p>
	  <div id ="toggleDiv1" style="display:none;">
		<p>Your firm currently produces <span class="firmDetailSpan"></span> tonnes of emissions. The new rule is that you can only produce 1,000 tonnes of emissions, so you must reduce your emissions by <span class="reducedTonnes"></span> tonnes. It costs you &pound;<span class="firmDetailSpan"></span> to reduce each tonne of emissions. So how much will it cost you to reduce by this amount?</p>
		<p>Still not sure? <button id="toggleButton2" onclick="toggleElement('toggleButton2','toggleDiv2')">Click to show</button></p>
		<div id ="toggleDiv2" style="display:none;">
		  <p>
			<span class="reducedTonnes"></span> X &pound;<span class="firmDetailSpan"></span> = &pound;<span class="reductionCostSpan"></span>. Enter this value above to get the correct answer.
		  </p>
		</div>
	  </div>
	</div>

</div>

<div id="div6">

	<h2>Situation 2: Cap and Trade System</h2>
	<p>We are going to reduce our emissions, but this time we are going to use a different system.</p>
	<p>Instead of forcing all firms to reduce their emissions, the government will give each firm <em>permits for the right to pollute</em>. Each firm will initially have the permits to emit 1,000 tonnes of carbon. You can either use these permits so that your firm can emit carbon, or you can sell them to other firms so that they can emit carbon. The key is that once the trading is done, you must only pollute as much carbon as you have permits for. If you don't have enough permits, you will need to reduce your carbon emissions until it matches the number of permits you have. If you sell all your permits, this means that you will have to reduce your emissions to zero.</p>
	<p></p>
	<p>Buy and sell permits with other firms around the room. It's up to you to negotiate the price of permits. Record all trades in the form below. You can keep trading until nobody wants to trade anymore.</p>

</div>

<div id="div7">

	<table id="summaryTable">
	  <tr>
		<th></th>
		<th>Permits</th>
		<th>Money</th>
	  </tr>
	  <tr>
		<td><strong>Initial Balance</strong></td>
		<td>1,000</td>
		<td>&pound;0</td>
	  </tr>

	</table>
</div>

<div id="div7_1">
  <p>
    <button onclick = "showDiv('dealDiv'); showDiv('inputDiv'); hideDiv('div8'); hideDiv('div7_1'); hideDiv('dealDiv_3')">Make a deal</button>
  </p>
  	
</div>

<div id="dealDiv">
  <div id="inputDiv">
	  <p>
		  <div id="dealDiv_2">
			  <label for="tradePartnerInput">Trade Partner:</label>
			  <input id="tradePartnerInput" onchange="dealButton()" placeholder="Name of Trading Partner">
			  <button onclick="showDiv('dealDiv_3'); hideDiv('dealDiv_2')">Enter Trading Partner</button>
		  </div>
		  <div id="dealDiv_3">
		  <button onclick="showDiv('sellDiv'); hideDiv('inputDiv')">Selling to <span class="tradePartner"></span></button>
		  <button onclick="showDiv('buyDiv'); hideDiv('inputDiv')">Buying from <span class="tradePartner"></span></button>
		  </div>
	  </p>
  </div>
  <div id="sellDiv">
    <h3>Selling to <span class="tradePartner"></span></h3>
	<p>How many permits are you selling to <span class="tradePartner"></span>? <input id = "permitsSold" type="number" pattern = "\d*"></p>
	<p>What is the price per permit? <input id = "priceSold" type="number" pattern = "\d*"></p>
	<p style="display:none;">How much money did you collect from this sale (in pounds)? <input id = "moneySold" type="number" pattern = "\d*"></p>
	<p>
    <button onclick="dealExecute()">DO THE DEAL!</button>
  </p>
  </div>
  <div id="buyDiv">
    <h3>Buying from <span class="tradePartner"></span></h3>
	<p>How many permits are you buying from <span class="tradePartner"></span>? <input id = "permitsBuy" type="number" pattern = "\d*"></p>
	<p>What is the price per permit? <input id = "priceBuy" type="number" pattern = "\d*"></p>
	<p style="display:none;">How much money did you pay for this transaction (in pounds)? <input id = "moneyBuy" type="number" pattern = "\d*"></p>
	<p>
    <button onclick="dealExecute()">DO THE DEAL!</button>
  </p>
  </div>
  
  <p id="dealCancelButton">
    <button onclick="dealCancel()">Cancel the deal</button>
  </p>
</div>

<div id="div8">
	<p><button onclick="review(); hideDiv('div10')">Click Here</button> when you're done dealing and you want to review your final position. You should only do this when you are sure you can't make any money by doing more trades.</p>
	<p> If you want to cancel all the deals and start with a new table, click this button: 
    <button onclick = "startAgain()">Start again</button>
  </p>
</div>

<div id="div9">
  <button onclick="reviewReverse()">Click to go back to trading</button>
  <h2>Review</h2>
  
  <p>Now that you're done with your permit trading, you can commence with your polluting. Remember that you can only pollute for as many permits as you've traded for, so you'll have to reduce any excess emissions until it reaches the level of your permits.</p>
  <p>You've got enough permits to emit <span id="permitCount"></span> tonnes of pollution. Your production process requires <span class="firmDetailSpan"></span> tonnes of pollution. You will need to reduce your pollution by <span id="residualEmissionRequirement"></span> tonnes.</p>
  <p>It costs you &pound;<span class="firmDetailSpan"></span> to reduce each tonne of emissions.</p>
  <p>How much do you still have to spend to bring your emissions down to the level of your permits?</p>
  <p>What is your overall financial position, including the money that you gained/lost from trading the permits?</p>
  <button id="toggleButton3" onclick="toggleElement('toggleButton3','div10')">Click to show</button>
  <div id="div10">
    <p>It will cost you &pound;<span id="reductionCost"></span> to reduce your emissions to the required level.</p>
	<p>Your closing balance from the end of permit trading is &pound;<span id="endBalance"></span>.</p>
	<p>Your overall financial position is <strong>&pound;<span id="finalPosition"></span></strong>.</p>
	<button id = "div11Button" onclick="showDiv('div11'); hideDiv('div11Button')">Click for summary</button>
  </div>
  <div id="div11">
	  <h2>Summary</h2>
	  <p>In Situation 1, it cost you <strong>&pound;<span class="reductionCostSpan"></span></strong> to reduce your emissions.</p>
	  <p>In Situation 2, your overall financial position is <strong>&pound;<span id="finalPosition2"></span></strong>.</p>
	  <ol class="pstyle_list">
		<li class="pstyle">Are you financially better off under the Situation 1 or Situation 2? Why is that?</li>
		<li class="pstyle">What do you expect will be the collective position of the whole class? Is society better off under Situation 1 or Situation 2? (We will review all financial positions as a class)</li>
		<li class="pstyle">Explain why tradable pollution permits are an efficient way of solving market failure arising from CO2 emissions.</li>
	  </ol>
  </div>

</div>


<?php include "../footer.php"; ?>
<script>

var balance = [1000,0,0];

var index = [
  ["Firm A",1000,2,"Retailer","tpp_firmA.jpg"],
  ["Firm B",3500,10,"Factory","tpp_firmB.jpg"],
  ["Firm C",5000,8,"Power Station","tpp_firmC.jpg"],
  ["Firm D",1500,7,"Refinery","tpp_firmD.jpg"],
  ["Firm E",1000,1,"Restaurant","tpp_firmE.jpg"],
  ["Firm F",1000,3,"Cinema","tpp_firmF.jpg"],
  ["Firm G",2500,6,"Factory","tpp_firmG.jpg"],
  ["Firm H",1500,9,"Smelting Station","tpp_firmH.jpg"],
  ["Firm I",1000,5,"Chemical Processing","tpp_firmI.jpg"],
  ["Firm J",2500,10,"Factory","tpp_firmJ.jpg"]
]

var firmInformation;

var reductionCost;

var firmSelect = document.getElementById("firmSelect");

for (var i=0; i<index.length; i++) {
	
	var option = document.createElement("option");
	option.text = index[i][0];
	option.setAttribute("value", i);
	
	firmSelect.add(option);

}

var firmDetailKey = [0,3,1,2,1,2,2,1,2];

function showDiv(i) {

  document.getElementById(i).style.display = "block";

}

function hideDiv(i) {

  document.getElementById(i).style.display = "none";

}



function selectFirm() {

	var firmNumber = document.getElementById("firmSelect").value;
	
	firmInformation = index[firmNumber];
	console.log(firmInformation);
	
	var firmDetailSpan = document.getElementsByClassName("firmDetailSpan");
	
	for(var i=0; i<firmDetailSpan.length; i++) {
	
		if ((i==2)||(i==4)||(i==7)) {firmDetailSpan[i].innerHTML = index[firmNumber][firmDetailKey[i]].toLocaleString();}
		else {
			firmDetailSpan[i].innerHTML = index[firmNumber][firmDetailKey[i]];
		}
	}
	
	var image = document.getElementById("firmImg");
	image.setAttribute("src", "files/"+index[firmNumber][4])
	
	
	reductionCost = (index[firmNumber][1]-1000)*index[firmNumber][2];
	//alert(reductionCost);
	
	var reductionCostSpan = document.getElementsByClassName("reductionCostSpan");
	for(var i=0; i<reductionCostSpan.length; i++) {
		reductionCostSpan[i].innerHTML = reductionCost.toLocaleString();
	}
	
	var reducedTonnes = index[firmNumber][1]-1000;
	var x = document.getElementsByClassName("reducedTonnes");
	for(var i=0; i<x.length; i++) {
	  x[i].innerHTML = reducedTonnes.toLocaleString();
	}
	
	//document.getElementById("reductionCost").innerHTML = "&pound;"+(balance[2]*firmInformation[2]).toLocaleString();

}

function toggleElement(i,j) {
	//var initial = document.getElementById(i).innerHTML;
	var toggledDiv = document.getElementById(j);
	if (toggledDiv.style.display === "none") {
	  toggledDiv.style.display="block";
	  document.getElementById(i).innerHTML = "Click to hide";
	} else {
	  toggledDiv.style.display="none";
	  document.getElementById(i).innerHTML = "Click to show";
	}
	
	
}

function checkReductionValue() {

	var inputValue = parseInt(document.getElementById("reductionCostCalculation").value);
	if (inputValue === reductionCost) {
		showDiv("div4");
		hideDiv("div5")}
	else {showDiv("div5");
		hideDiv("div4")}

}

function dealButton() {
	var x = document.getElementById("tradePartnerInput").value;
	var y = document.getElementsByClassName("tradePartner");
	for(var i=0; i<y.length; i++) {
		y[i].innerHTML=x;
	}
}

function dealExecute() {
	
	//Defining transaction data variable
	var transactionRaw = [];
	
	transactionRaw[0] = document.getElementById("tradePartnerInput").value;
	transactionRaw[1] = document.getElementById("permitsSold").value;
	transactionRaw[2] = document.getElementById("moneySold").value;
	transactionRaw[3] = document.getElementById("permitsBuy").value;
	transactionRaw[4] = document.getElementById("moneyBuy").value;
	transactionRaw[5] = document.getElementById("priceSold").value;
	transactionRaw[6] = document.getElementById("priceBuy").value;
	
	var transaction = [];
	
	transaction[0] = transactionRaw[0];
	
	for(var i=1; i<7; i++) {
	  if(transactionRaw[i]=='') {transaction[i]=0
	 } else {
	  transaction[i] = parseFloat(transactionRaw[i])}
	
	  
	}
	
	//Use the following if allowing user input by price and quantity.
	
	transaction[2] = transaction[1]*transaction[5];
	transaction[4] = transaction[3]*transaction[6];
	
	balance[0] = balance[0]-parseFloat(transaction[1])+parseFloat(transaction[3]);
	balance[1] = balance[1]+parseFloat(transaction[2])-parseFloat(transaction[4]);
	balance[2] = firmInformation[1] - balance[0];
	console.log(transaction);
	console.log(balance);
	
	
	var table = document.getElementById("summaryTable");
	
	var totalRowCount = table.rows.length;
	var row = table.insertRow(totalRowCount);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);

	// Add some text to the new cells:
	cell1.innerHTML = "Deal: "+transaction[0];
	cell2.innerHTML = ((transaction[1])*-1+parseFloat(transaction[3])).toLocaleString();
	cell3.innerHTML = "&pound;"+((transaction[2])-parseFloat(transaction[4])).toLocaleString();
	
	var totalRowCount = table.rows.length;
	var row = table.insertRow(totalRowCount);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);

	// Add some text to the new cells:
	cell1.innerHTML = "<strong>New Balance</strong>"
	cell2.innerHTML = balance[0].toLocaleString();
	cell3.innerHTML = "&pound;"+balance[1].toLocaleString();
	
	
	hideDiv("sellDiv");
	hideDiv("buyDiv");
	hideDiv("dealCancelButton");
	
	dealCancel();
	showDiv("dealCancelButton");
	
	showDiv('div8'); showDiv('div7_1'); showDiv('dealDiv_2');
}

function startAgain() {
	
	var table = document.getElementById("summaryTable");
	table.innerHTML = "<tr><th></th>		<th>Permits</th>		<th>Money</th>	  </tr>	  <tr>		<td><strong>Initial Balance</strong></td>		<td>1,000</td>	<td>&pound;0</td>	  </tr>";
	
	balance = [1000,0,0];
	
	
	
}


function dealCancel() {

	document.getElementById("dealDiv").style.display="none";
	document.getElementById("sellDiv").style.display="none";
	document.getElementById("buyDiv").style.display="none";
	
	document.getElementById("tradePartnerInput").value = "";
	document.getElementById("permitsSold").value = "";
	document.getElementById("moneySold").value = "";
	document.getElementById("permitsBuy").value = "";
	document.getElementById("moneyBuy").value = "";
	document.getElementById("priceBuy").value = "";
	document.getElementById("priceSold").value = "";
	
	
	var y = document.getElementsByClassName("tradePartner");
	for(var i=0; i<y.length; i++) {
		y[i].innerHTML="";
	}

	showDiv('div8'); showDiv('div7_1'); showDiv('dealDiv_2');
}


function review() {
/*
let text = "Confirmation: You are done with dealing permits, and you are ready to review.";
  if (confirm(text) == true) {
   */ 
	showDiv('div9');
	hideDiv('div6');

	hideDiv('div7_1');
	hideDiv('div8');
	
	
	//balance[0] = balance[0]-parseFloat(transaction[1])+parseFloat(transaction[3]);
	//balance[1] = balance[1]+parseFloat(transaction[2])-parseFloat(transaction[4]);
	balance[2] = firmInformation[1] - balance[0];

	console.log(balance);
	
	
	
	document.getElementById("permitCount").innerHTML = balance[0].toLocaleString();
	document.getElementById("residualEmissionRequirement").innerHTML = balance[2].toLocaleString();
	
	document.getElementById("reductionCost").innerHTML = (balance[2]*firmInformation[2]).toLocaleString();
	
	document.getElementById("endBalance").innerHTML = balance[1].toLocaleString()
	
	document.getElementById("finalPosition").innerHTML = (balance[2]*firmInformation[2]*-1+balance[1]).toLocaleString();
	
	document.getElementById("finalPosition2").innerHTML = (balance[2]*firmInformation[2]*-1+balance[1]).toLocaleString();
	
 // } 



}

function reviewReverse() {


	showDiv('div6'); 
	showDiv('div7_1'); 
	showDiv('div8')
	
	hideDiv('div9');
	
	hideDiv('div10');
	hideDiv('div11');
	document.getElementById('toggleButton3').innerHTML = "Click to show";
	
	showDiv('div11Button');
	

}

</script>

</body>



</html>