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
	//text-align: center;
	vertical-align: top;

}

td.col3 {
	
	width: 10px;	
	
}

</style>

</head>

<body>


<?php include "../navbar.php"; ?>

<h1>Eduqas A Level Economics Topic List</h1>
<table id="table1"></table>

<?php include "../footer.php"; ?>

<script>

var index = [
  ["Unit No.","Topic","Topic Family"],
  ["1.1.1","Scarcity, choice and opportunity cost","The Economic Problem and Basic Economic Understanding"],
  ["1.1.2","Production possibility frontiers (PPFs) ",""],
  ["1.1.3","Specialisation, division of labour and exchange",""],
  ["1.2.1","Factors influencing demand and supply in product markets","Supply, Demand, Markets, and Elasticity"],
  ["1.2.2","The determination of equilibrium price and output in a freely competitive market",""],
  ["1.2.3","Consumer and producer surplus",""],
  ["1.2.4","Price, income and cross price elasticities of demand, price elasticity of supply",""],
  ["1.3.1","Wage determination","Labour Market Economics"],
  ["1.3.2","Labour market issues",""],
  ["1.4.1","How resources are allocated in a free market economy","Resource Allocation"],
  ["1.5.1","Costs, revenues and profits","Theory of the Firm (Y2)"],
  ["1.5.2","The growth of firms ",""],
  ["1.5.3","Efficiency ",""],
  ["1.6.1","Background to Market Structures",""],
  ["1.6.2","Business Objectives",""],
  ["1.6.3","Perfect Competition",""],
  ["1.6.4","Monopolistic Competition",""],
  ["1.6.5","Monopoly",""],
  ["1.6.6","Oligopoly",""],
  ["1.6.7","Competition Policy",""],
  ["1.6.8","Privatisation",""],
  ["1.7.1","Understanding Market Failure","Market Failure"],
  ["1.7.2","Why and how governments intervene in markets",""],
  ["1.7.3","The effects of government intervention",""],
  ["2.1.1","The circular flow of income model","Macroeconomic Theory"],
  ["2.1.2","The components of aggregate demand (AD)",""],
  ["2.1.3","The AD function",""],
  ["2.1.4","The aggregate supply (AS) function",""],
  ["2.1.5","Short run aggregate supply (SRAS)",""],
  ["2.1.6","Long run aggregate supply (LRAS)",""],
  ["2.1.7","AD/AS Analysis",""],
  ["2.1.8","The short run Phillips curve",""],
  ["2.1.9","The long run Phillips curve",""],
  ["2.2.1","Government policy objectives","Government Policy Objectives"],
  ["2.2.2","Actual vs potential economic growth",""],
  ["2.2.3","Unemployment",""],
  ["2.2.4","Inflation and deflation",""],
  ["2.2.5","The balance of payments",""],
  ["2.2.6","Control of the national (public sector) debt",""],
  ["2.3.1","Fiscal Policy","Government Policies"],
  ["2.3.2","Monetary Policy ",""],

  ["2.3.3","Financial Stability",""],
  ["2.3.4","Exchange rates and exchange rate policy",""],
  ["2.3.5","Supply Side Policies",""],
  ["3.1.1","International Trade","International Trade (Y2)"],
  ["3.2.1","Non-UK Economies",""],
  ["3.3.1","Measurement of Economic Development","Economic Development (Y2)"],
  ["3.3.2","Obstacles to Economic Development",""],
  ["3.3.3","Solutions to Economic Development",""]
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
			
				if (j == 2) {
					
					cell2.classList.add("col3");
					
				}
			
		
				cellInstance.push(cell2);
			}
		
			
			
		
		cell.push(cellInstance);
	
	}
	
console.log(cell);	

/*
for (var i=0; i<2; i++)	{
	
	cell[1][2].setAttribute("rowspan", (i+2));
	cell[1+i][2]="";
	
}

*/

function rowSpanner(rowNo, spanLength) {
	
	cell[rowNo][2].setAttribute("rowspan", spanLength);
	for (var i=0; i<(spanLength-1); i++)	{


		row[(rowNo+1+i)].deleteCell(-1);
	}	
	
}

cell[1][2].setAttribute("rowspan", "3");
for (var i=0; i<2; i++)	{


		row[(1+1+i)].deleteCell(-1);
	}	
	
rowSpanner(4,4);
rowSpanner(8,2);
rowSpanner(11,11);
rowSpanner(22,3);
rowSpanner(25,9);
rowSpanner(34,6);
rowSpanner(40,5);
rowSpanner(45,2);
rowSpanner(47,3);
</script>


</body>






</html>