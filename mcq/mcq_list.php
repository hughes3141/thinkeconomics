<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
  $link = mysqli_connect($servername, $username, $password, $dbname);

  if (mysqli_connect_error()) {
    
    die ("The connection could not be established");
  }

?>
<html>


<head>

<style>

.innerdiv {

border: 2px solid red;
}


#d2 {

position: fixed;
right:0;
top: 0;
border: 3px solid green;
background-color: white;
width: 150px;
}

td {

border: 1px solid black;

}

</style>


</head>



<body onload=" populate(), topicList()">

<h1>Multiple Choice Question List</h1>

<form method="get">
<select id="select" name="topic" >

</select>
<input type="submit" >Choose Topic</input>
</form>

<div id = "d2">
<p>Total: <span id = "total"></span></p>
<p>Checked: <span id="checked"></span></p>
<p>Left: <span id="left"></span></p>
<button onclick="tabulate()">Tabluate</button>
<table id ="table01"></table>
<a href="https://shancarter.github.io/mr-data-converter/" target="_blank;">Data Converter</a>
<div id="d3"></div>
</div>

<div id ="d1"></div>


<?php



$topic = $_GET['topic'];

$querylist = array();


$query = "SELECT * FROM question_bank_3 WHERE Topic='".$topic."'";

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		$response = array();
		//print_r($row);
	
		array_push($response, $row[No]);
		array_push($response, $row[Answer]);
		array_push($response, "");
		array_push($response, "");
		array_push($querylist, $response);
		}

				
	}

?>

<script>

/*
23.03.2021
Uses information from database to generate list of question images.
*/

var topics = ["1.1.1","1.1.2","1.1.3","1.2.1","1.2.2","1.2.3","1.2.4","1.3.1","1.3.2","1.4.1","1.5.1","1.5.2","1.5.3","1.6.1","1.6.2","1.6.3","1.6.4","1.6.5","1.6.6","1.6.7","1.6.8","1.7.1","1.7.2","1.7.3","2.1.1","2.1.2","2.1.3","2.1.4","2.1.5","2.1.6","2.1.7","2.1.8","2.1.9","2.2.1","2.2.2","2.2.3","2.2.4","2.2.5","2.2.6","2.3.1","2.3.2","2.3.3","2.3.4","2.3.5","3.1.1","3.2.1","3.3.1","3.3.2","3.3.3"]

var index = <?php echo json_encode($querylist);?>;
console.log(index);

var totalQs;

/* index:

index[0]: Clone of index1;
index[1]: Clone of index1;
index[2]: Checkbox;
index[3]: Queston Order
*/

function imageExists(image_url){

    var http = new XMLHttpRequest();

    http.open('HEAD', image_url, false);
    http.send();

    return http.status != 404;

}




function topicList() {
	var select = document.getElementById("select");
	
	for(var i=0; i<topics.length; i++) {
		
		var option = document.createElement("option");
		option.setAttribute("value", topics[i]);
		option.innerHTML = topics[i];
		
		if (option.innerHTML == "<?php echo $_GET['topic'] ?>") {
			option.selected = true;
			
		} 
		select.appendChild(option);
		
		
	}
	
}

function populate() {



	var div = document.getElementById("d1")


	for(var i = 0; i<index.length; i++) {
	
		/*index[i].push("");
		index[i].push("");
	*/
		
		var innerdiv = document.createElement("div");
		var p1 = document.createElement("p");
		p1.innerHTML = (index[i][0])/*.toFixed(6)*/;
		
		var check = document.createElement("input");
		check.setAttribute("type", "checkbox");
		check.setAttribute("onclick", "update("+i+")");
		check.setAttribute("id", "check_"+i);
		
		var number = document.createElement("input");
		number.setAttribute("type", "number");
		number.setAttribute("onchange", "update("+i+")");
		number.setAttribute("id", "num_"+i);
		number.style.width = "50px";
		
		innerdiv.setAttribute("class", "innerdiv");
		var img = document.createElement("img");
		
		var bigjpg = (index[i][0])/*.toFixed(6)*/+".JPG";
		var smljpg = (index[i][0])/*.toFixed(6)*/+".jpg";
	
		/*if (typeof bigjpg != "undefined") {*/
		
		/*if (imageExists("question_img/"+bigjpg)) {*/
		
		img.setAttribute("src", "question_img/"+bigjpg);
		
		img.setAttribute("onerror", "this.onerror=null; this.src='question_img/"+smljpg+"'");
		
		
		/*
		img.onerror = function(e) {
			
			img.setAttribute("src", "question_img/"+smljpg);
		
		};
		*/
		/*
		
		}else if (typeof smljpg != "undefined") {
		
		img.setAttribute("src", "question_img/"+smljpg);
		}
		*/
		
		var p = document.createElement("p");
	
		
		p.innerHTML = index[i][1];
		
		p1.appendChild(check);
		p1.appendChild(number);
		innerdiv.appendChild(p1);
		
		innerdiv.appendChild(img);
		innerdiv.appendChild(p);
		div.appendChild(innerdiv);
		
	
	
	}

update(0);
}



function update(i) {


if (index.length>0) {

	
	var checkbox = document.getElementById("check_"+i);
	var numInput = document.getElementById("num_"+i);
	
	if (checkbox.checked == true) {
		
		index[i][2] = 1
	
	}
	
	else {
	
		index[i][2] = "";
		numInput.value = "";
	
	}
	
	
	
	if (checkbox.checked == true) {
		
		index[i][3] = numInput.value;
	
	}
	else {
	
		index[i][3] = "";
	
	}
	
	var questionSelect = [];
	
	for(var j=0; j<index.length; j++) {
		
		questionSelect[j] = Number(index[j][2])
	
	}
	
	function getSum(total, num) {
		return total + parseFloat(num);
		}
	
	totalQs = questionSelect.reduce(getSum, 0);
console.log(index[i]);
console.log(totalQs);


	document.getElementById("total").innerHTML = index.length;
	document.getElementById("checked").innerHTML = totalQs;
	document.getElementById("left").innerHTML = index.length-totalQs;
}
}


function tabulate() {

	index2 = [];
	var table = document.getElementById("table01");
	table.innerHTML = "";
	
	var div3 = document.getElementById("d3");
	div3.innerHTML ="";
	/*
	for(var i=0; i<(totalQs); i++) {
	
		function checkIndex(j) {
			return (j-1) == i
		}
		
		var k = index[i][3].findIndex(checkIndex);
		index2[i] = index[k]
	
	}
	*/
	

	for(var i=1; i<(totalQs+1); i++) {
	
		for(var j=0; j<index.length; j++) {
			if (index[j][3]==i) {
				index2.push(index[j])
				}
			
			}
	
	}
	var table = document.getElementById("table01");
	var div3 = document.getElementById("d3");
	
	for(var i=0; i<index2.length; i++) {
		
		/*index2[i].pop();
		index2[i].pop();*/
		var row = table.insertRow(i);
		
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		cell1.innerHTML = (index2[i][0])/*.toFixed(6)*/;
		cell2.innerHTML = index2[i][1];
		
		var par = document.createElement("span");
		par.innerHTML = index2[i][0]+", "
		div3.appendChild(par);
	}
	
	
	

console.log(index2);
}

</script>





</body>


</html>