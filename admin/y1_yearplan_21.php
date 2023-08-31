<html>


<head>



<?php //include "../header.php"; ?>

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

<?php //include "../navbar.php"; ?>

<h1>Year 1 A Level Economics Year Plan 2022-2023</h1>
<table id="table"></table>

<?php



$startDate = "2023-09-04";

$topics = 

[
  ["Introduction to Course; What is Economics?"],
  ["1.1.1 Scarcity and Choice; 1.4.1 Types of Economic Systems"],
  ["1.1.2 Production Possibility Frontiers (PPFs)"],
  ["1.1.3 Specialisation"],
  ["1.2.1 Supply and Demand Curves"],
  ["1.2.2 The Determination of Economic Equilibrium\n1.4.1 The Role of Profit and Prices in a Market System"],
  ["1.2.3 Producer and Consumer Surplus; 1.2.4 Introduction to Elasticity"],
  ["1.2.4 Elasticity: PED and YED"],
  ["1.2.4 Elasticities: XED and PES"],
  ["1.3.1 Labour Markets: Wage Determination"],
  ["1.3.2 Labour Market Issues"],
  ["1.7.1 Market Failure: Externalities"],
  ["1.7.1 Market Failure: Information Assymetry"],
  ["1.7.2 Government Intervention in Markets"],
  ["1.7.3 Government Failure"],
  ["Intro to Macro; 2.2.1 Government Policy Objectives"],
  ["2.1.1 The Circular Flow of Income"],
  ["2.1.2 The Components of Aggregate Demand"],
  ["2.1.3 The AD Function; 2.1.4 The Aggregate Supply (AS) Function"],
  ["2.1.7 AD/AS Analysis"],
  ["2.1.5-2.1.6: SRAS and LRAS; Neoclassical Economists and Keynes vs Hayek"],
  ["2.2.2 Economic Growth"],
  ["2.2.3 Unemployment"],
  ["2.2.4 Inflation and Deflation"],
  ["2.2.5 The Balance of Payments"],
  ["2.2.6 Control of National Debt"],
  ["2.3.1 Fiscal Policy"],
  ["2.3.2 Monetary Policy: Bank of England"],
  ["2.3.2 Monetary Policy: Quantitative Easing"],
  ["2.3.4 Exchange Rates: Interpretation and Calculation"],
  ["2.3.4 Exchange Rate Policy: Fixed vs Floating Exchange Rates"],
  ["2.3.5 Supply Side Policies"],
  ["1.4.1 Assumptions of Rationality"],
  ["1.4.1 Assumptions of Rationality"],
  ["1.4.1 Assumptions of Rationality (Presentations); Introduciton to Final Project"],
  ["Your Future Week"],
  ["Index Week/Final Project"],
  ["Admin/Staff Development"]
];

$holidays = (array) json_decode('{
  "Week":[7,15,16,23,30,31,38],
  "Descriptor":["Half Term","Break","Break","Half Term","Break","Break","Half Term"]
}');





print_r($topics);

echo "<br>".$startDate;
echo "<br>";
print_r($holidays);
var_dump($holidays);

?>

<table>
  <tr>
    <th>No</th>
    <th>Week</th>
    <th>Topic</th>
  </tr>

<?php
  $week_count = 0;
  $holiday_count = 0;
  $weeks_total = count($topics)+count($holidays["Week"]);

  echo $weeks_total;

  for ($key=0; $key<$weeks_total; $key++) {
  //foreach($topics as $key => $week) {
    $format = 'd M';
    $monday = date($format, strtotime($startDate . ' + '.($key * 7).' day'));
    $friday = date($format, strtotime($monday . ' + 4 day'));
    $holiday_mark = false;
    if(in_array($key, $holidays['Week'])) {
      $holiday_mark = true;
    }
    
    ?>
    <tr>
      <?php
          if($holiday_mark == false) {
            ?>

            <td><?=$week_count?></td>
            <td><?=$monday." - ".$friday?></td>
            <td><?=$topics[$week_count][0]?></td>
            <?php
            $week_count++;
          }
          else {
            ?>
            <td></td>
            <td><?=$monday." - ".$friday?></td>
            <td><?=$holidays['Descriptor'][$holiday_count]?></td>
            <?php
            $holiday_count++;

          }
      ?>


    </tr>
    <?php
  }

?>

</table>

<?php include "../footer.php"; ?>

<script>


index1 = [
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

index =
[
  ["No.","Week","Subject Content"],
  [0,"05 Sep - 09-Sep","Introduction to Course; What is Economics?"],
  [1,"12 Sep - 16-Sep","1.1.1 Scarcity and Choice; 1.4.1 Types of Economic Systems"],
  [2,"19 Sep - 23-Sep","1.1.2 Production Possibility Frontiers (PPFs)"],
  [3,"26 Sep - 30-Sep","1.1.3 Specialisation, Division of Labour and Exchange"],
  [4,"03 Oct - 07-Oct","1.2.1 Supply and Demand Curves"],
  [5,"10 Oct - 14-Oct","1.2.2 The Determination of Economic Equilibrium; 1.4.1 The Role of Profit and Prices in a Market System"],
  [6,"17 Oct - 21-Oct","1.2.3 Producer and Consumer Surplus; 1.2.4 Introduction to Elasticity"],
  ["-","24 Oct - 28-Oct","Half Term"],
  [7,"31 Oct - 04-Nov","1.2.4 Elasticity: PED and YED"],
  [8,"07 Nov - 11-Nov","1.2.4 Elasticities: XED and PES"],
  [9,"14 Nov - 18-Nov","1.3.1 Labour Markets: Wage Determination"],
  [10,"21 Nov - 25-Nov","1.3.2 Labour Market Issues"],
  [11,"28 Nov - 02-Dec","1.7.1 Market Failure: Externalities, Merit and Demerit Goods, Public Goods"],
  [12,"05 Dec - 09-Dec","1.7.1 Market Failure: Information Assymetry, Property Rights, Income Inequality, Volatile Prices"],
  [13,"12 Dec - 16-Dec","1.7.2 Government Intervention in Markets"],
  ["-","19 Dec - 23-Dec","Break"],
  ["-","26 Dec - 30-Dec","Break"],
  [14,"02 Jan - 06-Jan","1.7.3 Government Failure"],
  [15,"09 Jan - 13-Jan","Intro to Macro; 2.2.1 Government Policy Objectives"],
  [16,"16 Jan - 20-Jan","2.1.1 The Circular Flow of Income"],
  [17,"23 Jan - 27-Jan","2.1.2 The Components of Aggregate Demand"],
  [18,"30 Jan - 03-Feb","2.1.3 The AD Function; 2.1.4 The Aggregate Supply (AS) Function"],
  [19,"06 Feb - 10-Feb","2.1.7 AD/AS Analysis"],
  ["-","13 Feb - 17-Feb","Half Term"],
  [20,"20 Feb - 24-Feb","2.1.5-2.1.6: SRAS and LRAS; Neoclassical Economists and Keynes vs Hayek"],
  [21,"27 Feb - 03-Mar","2.2.2 Economic Growth"],
  [22,"06 Mar - 10-Mar","2.2.3 Unemployment"],
  [23,"13 Mar - 17-Mar","2.2.4 Inflation and Deflation"],
  [24,"20 Mar - 24-Mar","2.2.5 The Balance of Payments"],
  [25,"27 Mar - 31-Mar","2.2.6 Control of National Debt"],
  ["-","03 Apr - 07-Apr","Break"],
  ["-","10 Apr - 14-Apr","Break"],
  [26,"17 Apr - 21-Apr","2.3.1 Fiscal Policy"],
  [27,"24 Apr - 28-Apr","2.3.2 Monetary Policy: Bank of England"],
  [28,"01 May - 05-May","2.3.2 Monetary Policy: Quantitative Easing"],
  [29,"08 May - 12-May","2.3.4 Exchange Rates: Interpretation and Calculation"],
  [30,"15 May - 19-May","2.3.4 Exchange Rate Policy: Fixed vs Floating Exchange Rates"],
  [31,"22 May - 26-May","2.3.5 Supply Side Policies"],
  ["-","29 May - 02-Jun","Half Term"],
  [32,"05 Jun - 09-Jun","1.4.1 Assumptions of Rationality"],
  [33,"12 Jun - 16-Jun","1.4.1 Assumptions of Rationality"],
  [34,"19 Jun - 23-Jun","1.4.1 Assumptions of Rationality (Presentations); Introduciton to Final Project"],
  [35,"26 Jun - 30-Jun","Your Future Week"],
  [36,"03 Jul - 07-Jul","Index Week/Final Project"],
  [37,"10 Jul - 14-Jul","Admin/Staff Development"]
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