<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

include "header_tailwind.php"; ?>

<!--
<section class="bg-white border-b py-8 text-black">
-->
<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Notes</h1>
    
  <div class="container mx-auto px-0 mt-2 bg-white text-black ">
      

    
      <ul style="list-style-type: none; padding: 0px;" id = "listbox">
      </ul>

      <?php for($x=0; $x<10; $x++) {echo "<br>";}?>
  </div>
</div>



<script>

var index = [
  
  ["Microeconomics","","h1","x"],
  ["The Economic Problem and Basic Economic Understanding","","h2","x"],
  ["1.1.1: Scarcity, choice and opportunity cost","1.1.1","a","x"],
  ["1.1.2: Production possibility frontiers (PPFs)","1.1.2","a",""],
  ["1.1.3: Specialisation, division of labour and exchange","1.1.3","a",""],
  ["Supply, Demand, Markets, and Elasticity","","h2","x"],
  ["1.2.1: Factors influencing demand and supply in product markets","1.2.1","a",""],
  ["1.2.2: The determination of equilibrium price and output in a freely competitive market","1.2.2","a",""],
  ["1.2.3: Consumer and producer surplus","1.2.3","a",""],
  ["1.2.4: Price Elasticity of Demand","1.2.4_1","a","x"],
  ["1.2.4: Price, income and cross price elasticities of demand, price elasticity of supply","1.2.4","a",""],
  ["1.3.1: Wage determination","1.3.1","a",""],
  ["1.3.2: Labour market issues","1.3.2","a",""],
  ["Resource Allocation","","h2",""],
  ["1.4.1: How resources are allocated in a free market economy","1.4.1","a",""],
  ["Theory of the Firm","Theory of the Firm","h2","x"],
  ["1.5.1: Costs, revenues and profits","1.5.1","a","x"],
  ["1.5.2: The growth of firms","1.5.2","a",""],
  ["1.5.3: Efficiency","1.5.3","a",""],
  ["1.6.1: Background to Market Structures","1.6.1","a","x"],
  ["1.6.2: Business Objectives","1.6.2","a",""],
  ["1.6.3: Perfect Competition","1.6.3","a",""],
  ["1.6.4: Monopolistic Competition","1.6.4","a",""],
  ["1.6.5: Monopoly","1.6.5","a",""],
  ["1.6.6: Oligopoly","1.6.6","a",""],
  ["1.6.7: Competition Policy","1.6.7","a",""],
  ["1.6.8: Privatisation","1.6.8","a",""],
  ["Market Failiure","Market Failiure","h2",""],
  ["1.7.1: Understanding Market Failure","1.7.1","a",""],
  ["1.7.2: Why and how governments intervene in markets","1.7.2","a",""],
  ["1.7.3: The effects of government intervention","1.7.3","a",""],
  ["Macroeconomics","Macroeconomics","h1","x"],
  ["Macroeconomic Theory","Macroeconomic Theory","h2","x"],
  ["2.1.1: The circular flow of income model","2.1.1","a",""],
  ["2.1.2: The components of aggregate demand (AD)","2.1.2","a",""],
  ["2.1.3: The AD function","2.1.3","a",""],
  ["2.1.4: Keynesian AS/AD Analysis","2.1.4","a","x"],
  ["2.1.5/2.1.6: SRAS and LRAS","2.1.5_6","a","x"],

  ["2.1.7: Neoclassical AS/AD Analysis","2.1.7","a","x"],
  ["2.1.8: The short run Phillips curve","2.1.8","a",""],
  ["2.1.9: The long run Phillips curve","2.1.9","a",""],
  ["Government Policy Objectives","Government Policy Objectives","h2",""],
  ["2.2.1: Government policy objectives","2.2.1","a",""],
  ["2.2.2: Actual vs potential economic growth","2.2.2","a",""],
  ["2.2.3: Unemployment","2.2.3","a",""],
  ["2.2.4: Inflation and deflation","2.2.4","a",""],
  ["2.2.5: The balance of payments","2.2.5","a",""],
  ["2.2.6: Control of the national (public sector) debt","2.2.6","a",""],
  ["Government Policies","Government Policies","h2",""],
  ["2.3.1: Fiscal Policy","2.3.1","a",""],
  ["2.3.2: Monetary Policy","2.3.2","a",""],
  ["2.3.3: Financial Stability","2.3.3","a",""],
  ["2.3.4: Exchange rates and exchange rate policy","2.3.4","a",""],
  ["2.3.5: Supply Side Policies","2.3.5","a",""],
  ["Global Economics","Global Economics","h1",""],
  ["International Trade","International Trade","h2",""],
  ["3.1.1: International Trade","3.1.1","a",""],
  ["3.2.1: Non-UK Economies","3.2.1","a",""],
  ["Economic Development","Economic Development","h2",""],
  ["3.3.1: Measurement of Economic Development","3.3.1","a",""],
  ["3.3.2: Obstacles to Economic Development","3.3.2","a",""],
  ["3.3.3: Solutions to Economic Development","3.3.3","a",""]
]





	var divBox = document.getElementById("listbox");
	
	for(var i=0; i<index.length; i++) {
		if (index[i][3] == "x") {
			var item = document.createElement(index[i][2]);
      
      if(index[i][2] =="h1") {
        item.classList.add("font-mono", "text-lg", "bg-pink-300", "pl-1")
      }
      if(index[i][2] =="h2") {
        item.classList.add("font-mono", "text-lg", "bg-pink-200", "pl-1", )
      }
			item.innerHTML = index[i][0];
			
				if (item.nodeName == "A") {
					item.setAttribute("href", "notes/"+index[i][1]+".php");

          
					
					var list = document.createElement("li");
					list.appendChild(item);
					item = list;

          item.classList.add("ml-2");
				}
			
			divBox.appendChild(item);
			}
		}



</script>

<?php include "footer_tailwind.php";?>
