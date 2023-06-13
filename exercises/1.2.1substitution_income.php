<html>

<head>
<?php include "../header.php";?>

<style>

.ans {
padding: 30px;background-color: pink;
display: none;
border: 1px solid black;

}

table, td, tr, th {

border: 2pt solid black;
border-collapse: collapse;

}

td {

}



.ans_link {

display: none;
margin-bottom: 20px;
margin-top: 20px;

}

</style>

</head>


<body>

<?php include "../navbar.php";?>


<div class="pagetitle">1.2.1 Substitution and Income Effects</div>

<p><button onclick ="input_0(); input_1();input_2();input_3(); input_4()" style ="display:none;">Temp</button></p>

<p>What two goods do you consume regularly?</p>
<p>Good 1: <input type="text" id="good_1"</p>
<p>Good 2: <input type="text" id="good_2"</p>
<p><button id="input_0 type="text" onclick="input_0()">Click</button></p>

<div id="output_0" style="display: none;">
<p>You've selected goods <span id="01"></span> and <span id="02"></span>.</p>
<p>Now set a budget: how much money per week can you devote to these goods?</p>
<p>&pound; <input id="input_1" type="number"> (round to the nearest &pound;)</p>
<p><button onclick="input_0(); input_1()">Click</button></p>
<p id="budget"></p>

</div>

<div id="output_1" style="display:none;">
<p>What is the price of each of these goods? (round to the nearest &pound;)</p>
<p>Price of <span id="03"></span>: &pound; <input type="number" id="good_1p"></p>
<p>Price of <span id="04"></span>: &pound; <input type="number" id="good_2p"></p>
<p><button onclick="input_0(); input_1(); input_2()">Click</button></p>
</div>

<div id="output_2" style="display:none;">
<h2>Summary</h2>
<p>You've identified the following:</p>
<p><strong>Your weekly budget: &pound;<span id="05"></span>.</strong></p>
<table>
<tr><th>Good Name</th><th>Price</th><th>Maximum Consumption</th></tr>
<tr><td id="06"></td><td id="07"></td><td id="10"></td></tr>
<tr><td id="08"></td><td id ="09"></td><td id="11"></td></tr>

</table>

<p><strong>Task:</strong>Work out your maximum consumption of both goods if you devote your enitre budget to these goods. (In other words, if you spent your entire budget on just one good, how much would you be able to purchase?)</p>
<p><button onclick="input_0(); input_1(); input_2(); input_3()">Click to check answers</button></p>
<p id="12" style="display:none;"> Once you feel okay with this, <a href="#/" onclick ="input_4()">click here</a> to move to the next part of the exercise.</p>

</div>

<div id="output_3" style="display:none; border-top: black solid 2px;">
<h1>Income Effect</h1>
<p>Let's consider your consumption of <span id="13"></span>. At the current price, you can consume <span id="14"></span> if you devote your whole budget to this good.</p>
<p>Raise the price to some new value. After the price change, how much of this good can you consume if you devote your whole budget to it?</p>
<p>New Price: &pound; <input id="new_price" type="number" style="width: 50px;"></p>
<button onclick="input_5()">Click for answer</button>
</div>

<div id="output_4" style="display:none">

<p>You can now consume <span id="15"></span> units of <span id="16"></span>.</p>
<p>Notice how this is lower than the <span id="43"></span> units you could have consumed before.</p>
<p>The price of the good went up, and you couldn't afford to buy as much of it, so you bought less of it.</p>
<p>This is known as <strong>The Income Effect.</strong></p>
<p>Make notes on this effect, then <a href="#/" onclick ="input_6()">click here</a> to move to the next part of the exercise.</p>
</div>

<div id="output_5" style="display:none; border-top: black solid 2px;">
<h1>Substitution Effect</h1>
<p>Let's consider your consumption of both <span id="17"></span> and <span id="18"></span>. You can work out opportunity cost of consuming good instead of the other by looking at the prices that you must pay to consume each good:</p>
<table>
<tr><th>Good Name</th><th>Price</th></tr>
<tr><td id="20"></td><td id="21"></td></tr>
<tr><td id="22"></td><td id ="23"></td></tr>
</table>
<p>Using this information, what is the opportunity cost of <span id="24"></span>? In other words, how many units of <span id ="25"></span> do you have to give up to consume another unit of <span id="26"></span>?</p>
<p>(Hint: It has to do with prices)</p>
<button onclick="input_7()">Click here for answer</button>
</div>

<div id = "output_6" style="display:none">
<p>The price of <span id ="27"></span> is <span id="28"></span></p>
<p>The price of <span id ="29"></span> is <span id="30"></span></p>
<p>To gain one unit of <span id="31"></span>, you must give up <span id="oppcost1"></span> units of <span id="32"></span>.</p>
<p>Now raise the price of <span id="33"></span> to some new value. After the price change, what will be the opporutnity cost of <span id="34"></span> in terms of <span id="35"></span>?</p>
<p>New Price: &pound; <input id="new_price2" type="number" style="width: 50px;"></p>
<button onclick="input_8()">Click here for answer</button>
</div>
<p></p>

<div id="output_7" style = "display:none">
<p>To gain one unit of <span id="36"></span>, you must give up <span id="oppcost2"></span> units of <span id="37"></span>.</p>
<p>Notice how this is higher than the old opporutnity cost of <span id="38"></span> units of <span id="44"></span>.</p>
<p>Because the opportunity cost of <span id="39"></span> is now higher, we will change our preferences about the consumption of these goods. We will consume fewer units of <span id="40"></span>
because it costs us more units of <span id="41"></span>. In other words, even adjusting for income, we will consume fewer units of <span id="42"></span> after its price went up.</p>
<p>This change in preferences is known as <strong>The Substitution Effect.</strong></p>
<p>Both <strong>The Income Effect</strong> and <strong>The Substitution Effect</strong> explain why we consume less of a product following a rise in its price.</p>
<p>This explains why the demand curve is downward-sloping.</p>
<p>Update your notes on both of these effects.</p>

</div>


<?php include "../footer.php";?>


	<script>
	
	var good1
	var good2
	var good1p
	var good2p
	var budget
	var budget_par
	var good1m
	var good2m
	var good1p_new
	var good1m_new
	var oppcost
	var oppcost2
	
	function input_0() {
	
	good1 = document.getElementById("good_1").value;
	good2 = document.getElementById("good_2").value;
	
	document.getElementById("01").innerHTML = good1;
	document.getElementById("02").innerHTML = good2;
	document.getElementById("03").innerHTML = good1;
	document.getElementById("04").innerHTML = good2;
	document.getElementById("06").innerHTML = good1;
	document.getElementById("08").innerHTML = good2;
	document.getElementById("13").innerHTML = good1;
	document.getElementById("16").innerHTML = good1;
	document.getElementById("17").innerHTML = good1;
	document.getElementById("18").innerHTML = good2;
	document.getElementById("20").innerHTML = good1;
	document.getElementById("22").innerHTML = good2;
	document.getElementById("24").innerHTML = good1;
	document.getElementById("25").innerHTML = good2;
	document.getElementById("26").innerHTML = good1;
	document.getElementById("27").innerHTML = good1;
	document.getElementById("29").innerHTML = good2;
	document.getElementById("31").innerHTML = good1;
	document.getElementById("32").innerHTML = good2;
	document.getElementById("33").innerHTML = good1;
	document.getElementById("34").innerHTML = good1;
	document.getElementById("35").innerHTML = good2;
	document.getElementById("36").innerHTML = good1;
	document.getElementById("37").innerHTML = good2;
	document.getElementById("39").innerHTML = good1;
	document.getElementById("40").innerHTML = good1;
	document.getElementById("41").innerHTML = good2;
	document.getElementById("42").innerHTML = good1;
	document.getElementById("44").innerHTML = good2;
	
	document.getElementById("output_0").style.display = "block";
	
	console.log(good1);
	console.log(good2);
	}
	
	function input_1() {
	
	budget = document.getElementById("input_1").value;
	budget_par = parseInt(budget);
	document.getElementById("budget").innerHTML = "Budget: &pound;"+ budget;
	document.getElementById("output_1").style.display = "block";
	document.getElementById("05").innerHTML = budget;
	
	console.log(budget);
	console.log(budget_par);
	
	}
	
	function input_2() {
	
	good1p = document.getElementById("good_1p").value;
	good2p = document.getElementById("good_2p").value;
	document.getElementById("output_2").style.display = "block";
	
	document.getElementById("07").innerHTML = "&pound;"+good1p;
	document.getElementById("09").innerHTML = "&pound;"+good2p;
	document.getElementById("21").innerHTML = "&pound;"+good1p;
	document.getElementById("23").innerHTML = "&pound;"+good2p;
	document.getElementById("28").innerHTML = "&pound;"+good1p;
	document.getElementById("30").innerHTML = "&pound;"+good2p;
	
	document.getElementById("new_price").value = good1p;
	document.getElementById("new_price2").value = good1p;
	}
	
	function input_3() {
	
	good1m = budget / good1p;
	good2m = budget / good2p;
	
	document.getElementById("10").innerHTML = good1m+" units of "+good1;
	document.getElementById("11").innerHTML = good2m+" units of "+good2;
	document.getElementById("12").style.display = "block";
	document.getElementById("14").innerHTML = good1m+" units of "+good1;
	document.getElementById("43").innerHTML = good1m
	}
	
	function input_4() {
	document.getElementById("output_3").style.display = "block";
	}
	
	function input_5() {
	good1p_new = document.getElementById("new_price").value;
	good1m_new = budget / good1p_new;
	document.getElementById("15").innerHTML = good1m_new;
	document.getElementById("output_4").style.display = "block";
	
	}
	
	function input_6() {
	
	document.getElementById("output_5").style.display = "block";
	}
	
	function input_7() {
	
	
	document.getElementById("output_6").style.display = "block";
	oppcost = good1p/good2p;
	document.getElementById("oppcost1").innerHTML = oppcost;
	document.getElementById("38").innerHTML = oppcost;
	}
	
	
	function input_8() {
	
	
	document.getElementById("output_7").style.display = "block";
	good1p_new = document.getElementById("new_price2").value;
	oppcost2 = good1p_new/good2p;
	document.getElementById("oppcost2").innerHTML = oppcost2;
	}
	
	</script>


</body>

</html>