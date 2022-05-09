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

<h1>Year 1 A Level Economics Year Plan 2021-2022</h1>
<table id="table1"></table>

<?php include "../footer.php"; ?>

<script>


index = [
  ["No.","Week","Subject Content"],
  [0,"06 Sep - 10 Sep","Introduction to Course; What is Economics?"],
  [1,"13 Sep - 17 Sep","1.1.1 Scarcity and Choice; 1.4.1 Types of Economic Systems"],
  [2,"20 Sep - 24 Sep","1.1.2 Production Possibility Frontiers (PPFs)"],
  [3,"27 Sep - 01 Oct","1.1.3 Specialisation, Division of Labour and Exchange"],
  [4,"04 Oct - 08 Oct","1.2.1 Markets and Demand; 1.2.1 Supply"],
  [5,"11 Oct - 15 Oct","1.2.2 Economic Equilibrium"],
  [6,"18 Oct - 22 Oct","1.2.3 Producer and Consumer Surplus; 1.2.4 Elasticity: PED and YED"],
  ["-","25 Oct - 29 Oct","Half Term"],
  [7,"01 Nov - 05 Nov","1.2.4 Elasticity: PED and YED"],
  [8,"08 Nov - 12 Nov","1.2.4 Elasticities: XED and PES"],
  [9,"15 Nov - 19 Nov","1.3.1 Labour Markets: Wage Determination"],
  [10,"22 Nov - 26 Nov","1.3.2 Labour Market Issues"],
  [11,"29 Nov - 03 Dec","1.4.1  The functions of price, assumptions of rationality"],
  [12,"06 Dec - 10 Dec","1.7.1 Market Failure: Public Goods, Merit/Demerit Goods, Externalities, Monopoly Power"],
  [13,"13 Dec - 17 Dec","1.7.1 Market Failure: Information Assymetry, Property Rights, Income Inequality, Volatile Prices"],
  ["-","20 Dec - 24 Dec","Break"],
  ["-","27 Dec - 31 Dec","Break"],
  [14,"03 Jan - 07 Jan","1.7.2: Government Intervention in Markets; 1.7.3 Government Failure"],
  [15,"10 Jan - 14 Jan","Intro to Macro; 2.2.1 Government Policy Objectives"],
  [16,"17 Jan - 21 Jan","2.1.1 The Circular Flow of Income"],
  [17,"24 Jan - 28 Jan","2.1.2 The Components of Aggregate Demand"],
  [18,"31 Jan - 04 Feb","2.1.3 The AD Function"],
  [19,"07 Feb - 11 Feb","2.1.4 The Aggregate Supply (AS) Function"],
  [20,"14 Feb - 18 Feb","2.1.7 AD/AS Analysis"],
  ["-","21 Feb - 25 Feb","Half Term"],
  [21,"28 Feb - 04 Mar","2.2.2 Economic Growth"],
  [22,"07 Mar - 11 Mar","2.2.3 Unemployment"],
  [23,"14 Mar - 18 Mar","2.2.4 Inflation and Deflation"],
  [24,"21 Mar - 25 Mar","2.2.5 The Balance of Payments"],
  [25,"28 Mar - 01 Apr","2.2.6 Control of National Debt"],
  [26,"04 Apr - 08 Apr","2.3.1 Fiscal Policy"],
  ["-","11 Apr - 15 Apr","Break"],
  ["-","18 Apr - 22 Apr","Break"],
  [27,"25 Apr - 29 Apr","2.3.2 Monetary Policy: Bank of England"],
  [28,"02 May - 06 May","2.3.2 Monetary Policy: Quantitative Easing"],
  [29,"09 May - 13 May","2.3.4 Exchange Rates: Interpretation and Calculation"],
  [30,"16 May - 20 May","2.3.4 Exchange Rate Policy: Fixed vs Floating Exchange Rates"],
  [31,"23 May - 27 May","2.3.5 Supply Side Policies"],
  ["-","30 May - 03 Jun","Half Term"],
  [32,"06 Jun - 10 Jun","2.1.5-2.1.6: Neoclassical Economists and Keynes vs Hayek"],
  [33,"13 Jun - 17 Jun","2.1.5-2.1.6: SRAS and LRAS"],
  [34,"20 Jun - 24 Jun","2.1.5-2.1.6: Neoclassical Self-Stabilising Equilibrium"],
  [35,"27 Jun - 01 Jul","Your Future Week"],
  [36,"04 Jul - 08 Jul","Index Week"],
  [37,"11 Jul - 15 Jul","Admin/Staff Development"]
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
		
			
			
		/*	
			if (cellInstance[0].innerHTML == "-") {
				
				
	
				
				for (var k=0; k<cellInstance.length; k++) {
					
					cellInstance[k].setAttribute("class", "break_row");
					
				}
				
				
				//cell2.setAttribute("class", "break_row");
			
			
			 
		}
		
		*/
		
		cell.push(cellInstance);
	
	}
console.log(cell);
</script>


</body>


</html>