<html>


<head>



<?php include "../header.php"; ?>

<style>

table {

	border-collapse: collapse;

}


th, td {

	border: 1pt solid black;
	padding: 5px;
	text-align: center;

}

td.col3 {
	
	text-align: left;
	
	
}


.break_row {
	
	
		background-color: #d9d9d9;
	
}


</style>


</head>



<body>

<?php include "../navbar.php"; ?>

<h1>Year 2 A Level Economics Year Plan 2021-2022</h1>
<table id="table1"></table>

<?php include "../footer.php"; ?>

<script>


var index = [
  ["No.","Week","Subject Content"],
  [1,"13 Sep - 17 Sep","Welcome back to course; 1.6.1 Introduction to Market Structures\n1.5.1 Costs, Revenues, and Profits"],
  [2,"20 Sep - 24 Sep","1.5.1 Economies of Scale"],
  [3,"27 Sep - 01 Oct","1.5.2 The growth of Firms"],
  [4,"04 Oct - 08 Oct","1.5.3 Efficiency"],
  [5,"11 Oct - 15 Oct","1.6.3 Perfect Competition"],
  [6,"18 Oct - 22 Oct","1.6.4 Monopolistic Competition"],
  ["-","25 Oct - 29 Oct","Half Term"],
  [7,"01 Nov - 05 Nov","1.6.5 Monopoly"],
  [8,"08 Nov - 12 Nov","1.6.6 Oligopoly"],
  [9,"15 Nov - 19 Nov","1.6.2 Business Objectives; Non-Profit Maximising"],
  [10,"22 Nov - 26 Nov","1.6.7 Competition Policy"],
  [11,"29 Nov - 03 Dec","1.6.8 Privatisation"],
  [12,"06 Dec - 10 Dec","2.1.4 Short Run Aggregate Supply (SRAS), 2.1.5 Long Run Aggregate Supply (LRAS); Neoclassical macroeconomic model. 2.1.6 AS/AD Analysis"],
  [13,"13 Dec - 17 Dec","2.1.8 The Phillips Curve: Short Run and Long Run Implications"],
  ["-","20 Dec - 24 Dec","Break"],
  ["-","27 Dec - 31 Dec","Break"],
  [14,"03 Jan - 07 Jan","3.1.1 Tariffs and Protectionism; Comparative vs Absolute Advantage"],
  [15,"10 Jan - 14 Jan","3.1.1 Globalisation and the WTO"],
  [16,"17 Jan - 21 Jan","3.2.1 The European Union; Advantages and Disadvantages of Member States. The European Monetary Union"],
  [17,"24 Jan - 28 Jan","3.3.1 Measurement of Economic Development: GNP and PPP; HDI"],
  [18,"31 Jan - 04 Feb","3.3.2 Obstacles to Development"],
  [19,"07 Feb - 11 Feb","3.3.2 Obstacles to Development"],
  [20,"14 Feb - 18 Feb","3.3.3 Solutions to Developmental Problems"],
  ["-","21 Feb - 25 Feb","Half Term"],
  [21,"28 Feb - 04 Mar","3.3.3 Solutions to Developmental Problems"],
  [22,"07 Mar - 11 Mar","2.2.6 Control of the National Debt"],
  [23,"14 Mar - 18 Mar","2.3.3 Financial Stability: The Financial Sector, Asset Bubbles, The Role and Purpose of Regulation"],
  [24,"21 Mar - 25 Mar","2.2.1: Government Policy Objectives; 2.2.2 Economics Growth (Review)"],
  [25,"28 Mar - 01 Apr","2.2.3 Unemployment; 2.2.4 Inflation and Deflation (Review)"],
  [26,"04 Apr - 08 Apr","2.2.5 The Balance of Payments (Review)"],
  ["-","11 Apr - 15 Apr","Break"],
  ["-","18 Apr - 22 Apr","Break"],
  [27,"25 Apr - 29 Apr","Revision and Review"],
  [28,"02 May - 06 May","Revision and Review"],
  [29,"09 May - 13 May","Revision and Review"],
  [30,"16 May - 20 May","Revision and Review"],
  [31,"23 May - 27 May","Monday 23 May: Component 1 Paper (PM) (Provisional)"],
  ["-","30 May - 03 Jun","Half Term"],
  [32,"06 Jun - 10 Jun","Monday 6 June: Component 2 Paper (PM) (Provisional)"],
  [33,"13 Jun - 17 Jun","Monday 13 June: Component 3 Paper (PM) (Provisional)"]
]

var table1 = document.getElementById("table1");
	var row = [];
	var cell = [];
	
	

for(var i=0; i<index.length; i++) {
	
		row.push(table1.insertRow(i))
		
		var cellInstance = [];
		
		var classname ="";
		
		for (var j=0; j<3; j++) {
			
			
			
			var cell2 = row[i].insertCell(j);
			cell2.innerHTML = index[i][j];
			
			
			if (i==0) {
				
				cell2.style.fontWeight = 'bold';
			}
			
			if (cell2.innerHTML =="-") {
				
				classname = "break_row"
				
			}
			
			cell2.setAttribute("class", classname);
			
			if (j == 2) {
				
				cell2.classList.add("col3");
				
			}
				cellInstance.push(cell2);
			}
		
			
			
		
		
		cell.push(cellInstance);
	
	}
console.log(cell);
</script>


</body>


</html>