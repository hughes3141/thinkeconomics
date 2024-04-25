<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $schoolId = $userInfo['schoolid'];
  $permissions = $userInfo['permissions'];
  
}


$style_input = "

    table {

      border-collapse: collapse;}
      
    td, th {

      border: 1px solid black;
      //padding: 10px;
      padding: 0px 5px 0px;
      }

    @media (min-width: 768px) { 
      
      td, th {

        //border: 1px solid black;
        padding: 10px;
        }
     }

    td.noBor {

      border: none;
    }

    ";


include($path."/header_tailwind.php");
?>




<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4 ">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Income Tax Calculator</h1>
    <div class=" container mx-auto px-1 mt-2 bg-white text-black mb-5">


    
      <div class=" w-full md:w-3/4 mx-auto pt-2">
        <div class="flex mb-1">
          <div class="">Pre-Tax Income: </div>
          <div class="grow pl-1"><input type = "number" class=" pl-1 w-full" id="input" value="12500" min="0" step="1000" onchange="calculate()"  ></div>
        </div>

        <button  class="border border-black bg-pink-200 w-full rounded px-3 my-1 " onclick = "calculate()">Calculate</button>
        <div class="flex my-1 justify-between gap-x-1">
          <div class="basis-1/2"><button class="border border-black bg-pink-100 w-full rounded px-3" onclick="changeValue(-1000);" >Subtract £1000</button></div>
          <div class="basis-1/2"><button class="border border-black bg-pink-100 w-full rounded px-3" onclick="changeValue(1000);" >Add £1000</button></div>

        </div>
        <button  class="border border-black bg-sky-200 w-full rounded px-3 my-1 " onclick = "randomIncome()">Random Income</button>
      </div>
      <div class="flex justify-around mb-1">
        <div>
          <input type="radio" id="simple" name="complexity" value ="simple" checked ="true">
          <label for="simple">Simple</label>
        </div>
        <div>
          <input type="radio" id="comp" name="complexity" value ="complex">
          <label for="comp">Adjusted Personal Allowance</label>
        </div>
      </div>
      <div class="">
        <table class="table-fixed w-full text-xs md:text-base">

          <tr>
          <th>Band</th>
          <th>Taxable Income</th>
          <th>Tax Rate</th>
          <th>Income in this Band</th>
          <th>Tax Payable in this Band</th>
          </tr>
          <tr>
          <td>Personal Allowance</td>
          <td>Up to <span id="c_0"></span></td>
          <td>0&percnt;</td>
          <td id="0_0"></td>
          <td id="0_1"></td>
          </tr>
          <tr>
          <td>Basic Rate</td>
          <td><span id="c_1"></span> to <span id="c_2"></span></td>
          <td>20&percnt;</td>
          <td id="1_0"></td>
          <td id="1_1"></td>
          </tr>
          <tr>
          <td>Higher Rate</td>
          <td><span id="c_3"></span> to <span id="c_4"></span></td>
          <td>40&percnt;</td>
          <td id="2_0"></td>
          <td id="2_1"></td>
          </tr>
          <tr>
          <td>Additional Rate</td>
          <td>over <span id="c_5"></td>
          <td>45&percnt;</td>
          <td id="3_0"></td>
          <td id="3_1"></td>
          </tr>
          <tr>
          <td class="noBor"></td>
          <td class="noBor"></td>

          <td class="noBor"><b>Total:</b></td>
          <td id="4_0"></td>
          <td id="4_1"></td>
          </tr>
          <tr>
          <td class="noBor"></td>
          <td class="noBor"></td>
          <td class="noBor"></td>
          <td colspan="2" id="4_5" style="display:none";>Disposable Income = <span id="4_2"></span> - <span id="4_3"></span> = <span id="4_4"></span></td>
          </tr>
        </table>
      </div>
      <p></p>
      <p>Average Rate of Tax: <span id="average"></span></p>
      <p style="display:none;">Marginal Rate of Tax: <span id="marginal"></span></p>
      <br>
      <p>Interesting Reading:</p>
      <ul>
      <li>
      <a class="underline text-sky-700" href="https://www.gov.uk/income-tax-rates" target ="_blank">https://www.gov.uk/income-tax-rates</a>
      </li>
      <li>
      <a class="underline text-sky-700" href="https://www.gov.uk/income-tax-rates/income-over-100000" target ="_blank">https://www.gov.uk/income-tax-rates/income-over-100000</a>
      </li>
      <li>
      <a class="underline text-sky-700" href="https://www.buzzacott.co.uk/insights/exposing-the-60-income-tax-rate" target ="_blank">Exposing the 60&percnt; tax rate</a>
      </li>
      </ul>
      </div>
  </div>
</div>







<script>

  //populate();

var index = [
  [12500,0],
  [50000,0.2],
  [125000,0.4],
  [0,0.45],
  [100000, 2]
]

populate();
/* 
index[0] to index[3] have the format:
[threshold, marginal tax rate]

index[4] has:
[threshold at which PA is clawed back, rate of clawback]
*/

function populate() {
	
	var spans = [];
	var numbers = [index[0][0], index[0][0]+1, index[1][0], index[1][0]+1, index[2][0],index[2][0]]
	for(var i=0; i<6; i++) {
		
		spans[i]=document.getElementById("c_"+i);
		spans[i].innerHTML = "&pound;"+toComma(numbers[i]);
	}
	
	
	
}

function calculate() {

	var band;
	var tax;
	var postTaxIncome;
	var summary;
	var marginal;
	
	var tableValues = [[],[],[],[]];
	
	var complex = false; 
	var clawback;
	
	var complexButton = document.getElementById("comp");
	if (complexButton.checked) {
		complex = true;
	}
	
	console.log(complex);	
	
		for(var i=0; i<4; i++) {
			for(var j=0; j<2; j++) {
			
				tableValues[i][j] = document.getElementById(i+"_"+j);
			
			}
		
		}
		
	console.log(tableValues);

	var income = document.getElementById("input").value;
	
	if (income <= index[0][0]) {
		band = 0}
		
	else if (income <= index[1][0]) {
		band = 1}
	
	else if (income <= index[2][0]) {
		band = 2}
		
	else {
		band = 3}
		
	if (band ==0) {
		tax = 0;
		postTaxIncome = income-tax;
		marginal = (index[0][1]*100).toFixed(0)+"&percnt;";
		
		
			summary = [[income, tax], [0,0], [0,0],[0,0]];
			for(var i=0; i<4; i++) {
				for(var j=0; j<2; j++) {
					tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
				}
			}
		}
	if (band ==1) {
		tax = (income-index[0][0])*index[1][1];
		postTaxIncome = income - tax;
		marginal = (index[1][1]*100).toFixed(0)+"&percnt;";
		
			summary = [[index[0][0], 0], [income-index[0][0],(income-index[0][0])*index[1][1]], [0,0],[0,0]];
			for(var i=0; i<4; i++) {
				for(var j=0; j<2; j++) {
					tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
				}
			}
		
		}
	if (band ==2) {
		
		if (complex == false) {
			tax = (index[1][0]-index[0][0])*index[1][1] + (income-index[1][0])*index[2][1];
			postTaxIncome = income - tax;
			marginal = (index[2][1]*100).toFixed(0)+"&percnt;";
			
				summary = [[index[0][0], 0], [index[1][0]-index[0][0],(index[1][0]-index[0][0])*index[1][1]], [income-index[1][0],(income-index[1][0])*index[2][1]],[0,0]];
				for(var i=0; i<4; i++) {
					for(var j=0; j<2; j++) {
						tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
					}
				}
		}
		
		else if (complex == true) {
			
			if (income<= index[4][0]) {
							tax = (index[1][0]-index[0][0])*index[1][1] + (income-index[1][0])*index[2][1];
							postTaxIncome = income - tax;
							marginal = (index[2][1]*100).toFixed(0)+"&percnt;";
							
								summary = [[index[0][0], 0], [index[1][0]-index[0][0],(index[1][0]-index[0][0])*index[1][1]], [income-index[1][0],(income-index[1][0])*index[2][1]],[0,0]];
								for(var i=0; i<4; i++) {
									for(var j=0; j<2; j++) {
										tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
									}
								}
			}
			else if (income>index[4][0] && income<=(index[4][0]+(index[4][1]*index[0][0]))) {
							clawback = (income - index[4][0])*.5;
							tax = (index[1][0]-index[0][0])*index[1][1] + (income-index[1][0]+clawback)*index[2][1];
							postTaxIncome = income - tax;
							
							marginal = ((index[2][1]*1.5)*100).toFixed(0)+"&percnt;";
							
								summary = [[index[0][0]-clawback, 0], [index[1][0]-index[0][0],(index[1][0]-index[0][0])*index[1][1]], [income-index[1][0]+clawback,(income-index[1][0]+clawback)*index[2][1]],[0,0]];
								for(var i=0; i<4; i++) {
									for(var j=0; j<2; j++) {
										tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
									}
								}
				
				
			}
			
			else if (income>(index[4][0]+(index[4][1]*index[0][0]))) {
					
							clawback = (index[4][1]*index[0][0])*.5;
							tax = (index[1][0]-index[0][0])*index[1][1] + (income-index[1][0]+clawback)*index[2][1];
							postTaxIncome = income - tax;
							
							marginal = ((index[2][1])*100).toFixed(0)+"&percnt;";
							
								summary = [[index[0][0]-clawback, 0], [index[1][0]-index[0][0],(index[1][0]-index[0][0])*index[1][1]], [income-index[1][0]+clawback,(income-index[1][0]+clawback)*index[2][1]],[0,0]];
								for(var i=0; i<4; i++) {
									for(var j=0; j<2; j++) {
										tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
									}
								}
				
			}
				
			
		}
	}
		
	if (band ==3) {
		
		if (complex == false) {
			tax = (index[1][0]-index[0][0])*index[1][1] + (index[2][0]-index[1][0])*index[2][1] + (income-index[2][0])*index[3][1];
			postTaxIncome = income - tax;
			marginal = (index[3][1]*100).toFixed(0)+"&percnt;";
			
				summary = [[index[0][0], 0], [index[1][0]-index[0][0],(index[1][0]-index[0][0])*index[1][1]], [index[2][0]-index[1][0],(index[2][0]-index[1][0])*index[2][1]],[income-index[2][0],(income-index[2][0])*index[3][1]]];
				for(var i=0; i<4; i++) {
					for(var j=0; j<2; j++) {
						tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
					}
				}
		}
		
		else if (complex == true) {
			
					clawback = (index[4][1]*index[0][0])*.5;
					tax = (index[1][0]-index[0][0])*index[1][1] + (index[2][0]-index[1][0]+clawback)*index[2][1] + (income-index[2][0])*index[3][1];
					postTaxIncome = income - tax;
					marginal = (index[3][1]*100).toFixed(0)+"&percnt;";
					
						summary = [[index[0][0]-clawback, 0], [index[1][0]-index[0][0],(index[1][0]-index[0][0])*index[1][1]], [index[2][0]-index[1][0]+clawback,(index[2][0]-index[1][0]+clawback)*index[2][1]],[income-index[2][0],(income-index[2][0])*index[3][1]]];
						for(var i=0; i<4; i++) {
							for(var j=0; j<2; j++) {
								tableValues[i][j].innerHTML = "&pound;"+toComma(summary[i][j]);
							}
						}	
			
			
		}
	}	
		
	console.log(band);
	console.log(tax, postTaxIncome);

	document.getElementById("4_1").innerHTML = "<b>&pound;"+toComma(tax)+"</b>";
	
	document.getElementById("4_0").innerHTML = "<b>&pound;"+toComma(income)+"</b>";
	
	document.getElementById("4_2").innerHTML = "&pound;"+toComma(income)+"";
	document.getElementById("4_3").innerHTML = "&pound;"+toComma(tax)+"";
	document.getElementById("4_4").innerHTML = "<b>&pound;"+toComma(postTaxIncome)+"</b>";
	document.getElementById("4_5").style.display = "table-cell";
	
	var average = ((tax/income)*100).toFixed(2)+"&percnt;";
	document.getElementById("average").innerHTML = average;
	document.getElementById("marginal").innerHTML = marginal;
	
	
	if (complex == true && income>index[4][0]) {
		
		
		var spans = [];
		var numbers = [index[0][0]-clawback, index[0][0]-clawback+1, index[1][0]-clawback, index[1][0]-clawback+1, index[2][0],index[2][0]]
		for(var i=0; i<6; i++) {
		
			spans[i]=document.getElementById("c_"+i);
			spans[i].innerHTML = "&pound;"+toComma(numbers[i]);
		}
		
	}
	
	else {
		
		populate();
	}
}

function randomIncome() {

	var rIncome = Math.floor(Math.random()*300)*1000;
	document.getElementById("input").value = rIncome;

}


function toComma(x) {
	const y = (Math.round(x*100))/100;
	 
    return y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function toComma2(x) {
	 const fixedNumber = Number.parseFloat(x).toFixed(2)
    return fixedNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function changeValue(x) {
  var input = document.getElementById("input");
  var val = parseInt(input.value);
  
  val += x;
  input.value = val;
  console.log(val);
  calculate();

  
  

}

</script>

<?php   include($path."/footer_tailwind.php");?>