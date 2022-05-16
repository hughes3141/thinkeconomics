<html>

<head>
<?php include "../header.php"; ?>

<style>



</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php"; ?>


<h1>Today Programme 23 April 2021</h1>
<h2>Discussion of Fiscal Policy</h2>
<div style="border: 1px solid black; margin: 5px; padding: 10px; width:410px; max-width: 95%; float: right">
<img style = "width: 400px; height: auto; margin:5px" src="files/20210423.JPG">
<br>
<audio controls style="width:100%;">
<source src = "files/today_govdebt_2021.04.23.wav" type = "audio/wav">

Your browser does not support the audio element.
</audio>

<br>
<p><a href="https://www.bbc.co.uk/sounds/play/m000v9t1" target ="_blank">Click for original Programme (Clip at 2:21:50)</a></p>
</div>

<p><em>Nick Robinson interviewing Faisal Islam, BBC Economics correspondent.</em></p>
<p>Government borrowing has been over &pound;300bn in 2020/2021. These are high figures, the highest annual figure in government borrowing since World War 2. But the treasury thought they might be higher- possibly &pound;400bn at the beginning of the year, so in some ways there is an element of relief. And after all, these are &lsquo;deficits of choice&rsquo;; the government chose to spend money on supporting jobs rather than let people go unemployed. There was a &pound;250bn difference between borrowing in 2020/21 compared with 2019/20. The bulk of this is that the government spend more- &pound;200bn. Another &pound;30bn to &pound;40bn is that tax receipts fell. &nbsp;In the past few months of 2021, taxes have held up better than you may have expected.</p>

<p>In the past governments would have referred to borrowing with the phrase &lsquo;paying it back.&rsquo; Plenty of economists may say that it does not work like that- it is not like personal finances. Is this still the way that governments think?</p>
<img style = "float:right; clear: both" src="files/20210423_2.JPG">
<p>The sort of mindset that we saw in 2010, the era of &lsquo;austerity&rsquo;, has obviously not continued. The pandemic was a different set of events- a freakish, one-off pandemic. This is helped because interest costs (on government debt) have (up to now) been quite low. In fact, even with all this extra borrowing, interest payments on government debt this year were a fifth lower- &pound;39bn in 2020/2021, compared with &pound;48bn the year before, where we had a much lower level of borrowing. There is fear that these low rates will not continue forever- even recently the government has started to pay higher rates, though they have not yet reached 1%. Yet even that would be quite low in historical context. Borrowing costs are currently around 0.7%. But even that may be a good sign- a sign that markets expect that the economy will bounce back.</p>
<p>There are other signs that the economy is about to pick up again. For example, look at retail numbers. In March 2021, even before the physical reopening of retail, there was a 5% monthly increase in retail sales, nearly 20% in clothing. This is the result of pent-up demand, and because now we can go out again people want to look good in new clothes (or maybe their old clothes no longer fit).</p>


<div id="question_div"></div>
<?php include "../footer.php"; ?>

<script>

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

var page_title = "3.3.1 Measurement of Development: Summary Questions";
var root ="files/"
var index = [
  ["Question","Answer", ""],
  ["Question","Answer", ""],
  ["Question","Answer", ""],
  ["Question","Answer", ""],
  ["Question","Answer", ""],
  ["Question","Answer", ""],
  ["Question","Answer", ""]
]



function populate() {





	var i; 
	for (i=0; i<index.length; i++) {
	
	var main_div = document.getElementById("question_div");

	var question = document.createElement("div");
	question.setAttribute("id", "q"+i);
	question.innerHTML = "<p>"+(i+1)+": "+index[i][0]+"</p>";
	
	question.style = "margin:10px; overflow: hidden; line-height: 1.6; border: pt black solid; padding; 5px;";
	
	
	
	var button = document.createElement("button");
	button.innerHTML = "Click for Answer";
	button.setAttribute("onclick","answer("+i+")");
	button.setAttribute("id", "b"+i);
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
	answer.style.backgroundColor = "pink";
	answer.style.margin = "10px";
	answer.style.display = "none";
	
	
	question.appendChild(answer);

	main_div.appendChild(question);
	
	
	
	}


}	
	
function answer(i) {

	

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
	
</script>


</body>

</html>