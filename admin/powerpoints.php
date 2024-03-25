<html>


<head>

<?php include "../header.php"; ?>

<style>

ul {
  list-style-type: none;
  //margin: 0;
  //padding: 0;
}

</style>

</head>


<body>
<?php include "../navbar.php"; ?>
<h1>PowerPoints From Lessons</h1>
<p>The following links contain the most up-to-date versions of each PowerPoint. Please only view, do not edit.</p>
<ul>
<div id ="div1"></div>
</ul>
<?php include "../footer.php"; ?>

<script>


index = [

			["1.1.1 Scarcity, Choice, Opportunity Cost","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EWvSuR1hrtNIqRnJS5BeJJkBrWs84KCjkuxlg2wVatcQeA"],
			
			["1.1.2 Production Possibility Frontiers (PPFs)","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ef7GcJGUzjRPrGufrsWqAn8BmsNs6ozanZNo_zsn8FnQtw?e=20zxb8"],
			
			["1.1.3 Secialisation, Division of Labour, and Exchange","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ES4bCxb5KGlMnraWzhYZWTAB3zB5-gOg2fbVMH11TNceAQ?e=D2DRf9"],
			
			["1.2.1 Demand",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ERipoGxYkq1DgdUp1HPwrGoBmDYi4yO6ohW7TSQ2NRVyOw?e=pp6twJ"],
			
			["1.2.1 Supply",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ebj9tpZAhH9AliyOdggldsQBADEz5wgECI7naP-BPmq_Rw?e=aJavqT"],
			
			["1.2.2 Economic Equilibrium",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EbW2dQGTGbNOj7oS5zPpaJ4BrqSEfS7boxPrvXFTFpe1Kw?e=B29i2Y"],
			
			["1.2.2 The Bodmin House Auction Game",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EVXA7ZyLUopNi3YYqQZnpgcBmdeuuZqSK53pJHmNCcUhpg?e=usiNiC"],
			
			["1.2.3 Consumer and Producer Surplus",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EYQtwLirIgJGjSB9Yo72hDMBYyW3XCxdpGkyQh_2vXGDRA?e=bsn1uH"],
			
			["1.2.4 Price Elasticity of Demand",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ESK2wOojLK1MhBTTkVJGWjQBrZDL0NBSCBg-2jhg1QkB0g?e=yE0LcQ"],
			
			["1.2.4 YED, XED, PES",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EYW2lb-_eDdEnfC5idUkyV4BZhPsQAEFAN84AA5ov6vvEw?e=M3nLCO"],
			
			["1.3.1 Wage Determination",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EUZpRzAiI8VNtfqDuSxRdswBbocSfswtCR9B23B5ZNbTkw?e=zQKxxF"],
			
			["1.3.2 Labour Market Issues",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ET9992haEItKhZpdT_IAC0gBQdtvWpuhYnNe1cTY3ZsFJA?e=QrhMZD"],
			
			["1.4.1 Resource Allocation",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ETw_Ibf0RIVOgoqxmhkMAwIB13ysWkdXM2OwkGY9nchsHQ?e=1oz5Kk"],

			["1.4.1 Rationality and Prospect Theory",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ERflF8Mjr5pBr86fwtGi0G4B2el2W_KycaSJV24KemrXyw?e=3OWTsk"],
			
			["1.7.1 Externalities",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EZp33BS4rZpMneBwHHGyhhsB4qbHp65eDLxStHZlchn4Qg?e=GVu4hA"],
			
			["1.7.1 Public Goods",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EWn12uO5mP1CgCYnhWH4KAAB0nmYX_Lb9YWhaCYCRgHigg?e=MDki8J"],
			
			["1.7.1 Information Asymmetry",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EQ5tan3UTppHhYf3I06fBr0BMpUFyLrXs1Z5VA8-eHDI2w?e=kxnpe3"],
			
			["1.7.1 Income Inequality",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EfJLQRKigDBMgTlUvPXrP_ABJt1ajYkjZFsYuRABxkUlDw?e=KESecl"],
			
			["1.7.1 Property Rights",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EegRRs-keLpKn7eIYsUcTdwBlXqRc_oK9HEno-9grDEb5A?e=TAcaIP"],
			
			["1.7.1 Volatile Prices",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EfjxZ9l4e5NKpv2Bc8KiG1QB0uI-KBmIm6oSt-PWR9h65Q?e=yrlVX0"],
			
			["1.7.1 Monopoly Power",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EfAsVaGIenBFu06vNSfiVCkBTeDDDqpPb1ATZksbsq5VGg?e=huiaOk"],
			
			["1.7.2 Government Intervention",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EZSRlr7phqFOiGf-MF5_vq8B7dGYXtYhsugQS-ESmL3iXA?e=lGn8b9"],
			
			["1.7.2 Maximum/Minimum Prices",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EVBzaOXwgFZCsfxJmqCST0wBN_GzOxJoQ31I5vk1NXt5fg?e=WDmrYR"],
			
			["1.7.2 Tradable Pollution Permits",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EXPWTL3PHBpCi5udA6ZUXxABGxIaMFCPhBAfnewjDFrbpw?e=yg8mPP"],
			
			["1.7.3 Government Failure",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EZlhmN79xARGjVAmAavcCgQBZPkra0HYxvFChLbpxGiDAA?e=47xhNs"],
			
			
			
			["1.5.1 Short Run Costs, Long Run Costs, Profit",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ESttxPhxVOtFsk0Uy12GxGsBcieRsNUTkJzWpNr5HP-nSw?e=dldADk"],
			
			["1.5.1 Economies of Scale",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EdiJELDdmLNLt20AOQvLGKoBexe9HLPxfPaAy77_ZzW6Cw?e=yQ9Qes"],
			
			["1.5.2 The Growth of Firms",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ecq_dLA-LRFHv9M8l5H1unABkrEq3QrGkmTaoLiXSWBMXA?e=uUhz0N"],
			
			["1.6.1 Background To Market Structures",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ed64sNQ04o5Eosif0Yx2sFQBWfiBO-0XNndikxiXlPnwkw?e=chPOjr"],
			
			["1.6.2 Business Objectives",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ES53dWQLfHlLnud5X1Ra0S0BmJTQhjOMEHBCCKFYedjbPQ?e=89iflS"],
			
			["1.6.3 Perfect Competition",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ERegD3SNZtJGpAeKBAhIIrwBfniU1gfwWxU7TZyWJPU9Lw?e=OiFI1I"],
			
			["1.6.4 Monopolistic Competition",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EUz1B4X-MN9LqvCQdC4ZbXkBYNcKmjBnpz0fmz-iD9UYlQ?e=SrQ9kw"],
			
			["1.6.5 Monopoly",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EeLUhaiK7tVIgSb7WzDuN20B0cGa9VG5Rh1OKZi5Vys18w?e=BfzUyf"],
			
			["1.6.5 Price Discriminination",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EeoXuFzzYGpNqpCHSOT3uzIBTmXvm_55nhwQhwv1KURDpg?e=wHlX98"],
			
			["1.6.6 Game Theory",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EV34N0cXNWVEobgFxho0-ZgBKG06NaHDtny36G9xttQhww?e=dsku8l"],
			
			["1.6.6 Oligopoly",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ESYkoM3VskNOu-AZUzwE9NQBCxXfrDK8tlXLQ8XxQ_JjrA?e=Fc66cb"],
			
			["1.6.7 Competition Policy",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ERGeXqi_2ntIh7wBwP7RZjEBSupwH3fJTkV6iktMMKAlxA?e=VJVX7b"],
			
			["1.6.8 Privatisation",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EQbcoymVfRlHqSPEaupEj84BmL_Drq58VNe9pSKOC0GrPw?e=xw4Lyo"],
			
			["2.1.1 Circular Flow of Income",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EVZ4uEuOjQNJlwYF0AXK3XsB9zaQL7HBqYEJDq6iKiplvg?e=7h5VdV"],
			
			["2.1.2 Influences on AD",
			"https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ESUClLiWSBVMvSXgWBjXb4EBa2THOXY2m5CVJhqIlUXrdA?e=x3pe5t"],
			
			
        ["2.1.3 The AD Curve","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EaF6Xq8f5lREt6jvri14WTEB9z9vt7j55Q9ZSxAhCguo5w?e=PK691e"],
        ["2.1.4 Keynesian Aggregate Supply","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Eb0QfYoiWX1Ij1p3ESjEmYQBlbxG_IKuGQoqBE4giv91IQ?e=hs5ftL"],
        ["2.1.5 AS/AD Revision","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ETQbDOqaPORGnxSMn0N3aeQBNHg4eXg8NfqEjjHOmrY0DA?e=U7vNuK"],
       	["2.1.5 Neoclassical AS/AD","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EUrws2xO0WxNt0gYbOhyE8EBDxxvGazQt6hYYa2rzxL-UQ?e=ydjYAL"],
	["2.1.7 Keynes vs Hayek","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EcyJYPdTSGpDhra6yyMWTUgBO-KTHCnOtGCzWWGJG2FdaQ?e=tDfZVa"],
	["2.1.8 Phillips Curve","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ESvmmI2JRHxKtweZilcnNTsBwLQuxLQLYLKhw8uw3UjE4A?e=K0evpr"],
		["2.2.2 Economic Growth","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ef3Ed7xBRk5Hjatn0TKePV4Bya8-S-8acki0HV2zaf4fhg?e=HFGgcs"],
  		
		["2.2.3 Unemployment","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EW64qZif6ZJCtsqvaC5AZd0B7v4CE3P1aZvY3NdlGCH7pw?e=ZXiF00"],
  		["2.2.4 Inflation","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EZip31N6CVFBkQafmpGAuHoBvOb5j2LTyO0yyyMfZOLdcw?e=zSaNbv"],
  		["2.2.5 Balance of Payments","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EVApZOwf-fNAttCAP_un44sBhTXac7TEDWu103IyfSUfeA?e=CRThgG"],
		["2.2.6 Public Sector Debt","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EWoL2wCkfQZEk1Js__L5e48BpfVmfU5e_ix87kn6sbjFgA?e=g65Fii"],
  		["2.3.1 Fiscal Policy","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ec-LrMmi3KtBqzb33xZHDLMBkmmt3RyGKa-XiuVDNPiIlg?e=miKpfj"],
  		["2.3.2 Monetary Policy","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EfmhvhWpHilIiDJGiQp6LHQBV7qCq0WdBguDwkD0qova5A?e=Hr58hc"],
  		["2.3.3 Financial Stability","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ETSKQcMKX2VGpixo2CK7oZ8BGzfMMOmjiY4HfEokWqlR3g?e=BQ5pxK"],
  		["2.3.4 Exchange Rates","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EWusHqVElhpMhFFcJ3H1iy0B6i6epJE6JqTH1NWd6vQ3tw?e=loLlzU"],
  		["2.3.5 Supply Side Policies","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Ea2t0coMlTFEnNVX05fF0TEBnyNufjjFnUWK6iFXVtVT6g?e=lskTnw"],



      ["3.1.1 Trade","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EUYbGytvzFxEt2oTmTCoAQEBgrNuOBI_hYUgLkYd3LtBWQ?e=doTdIJ"],
    
      ["3.1.1 Comparative and Absolute Advantage","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ET9XGx8F3Z1Gu0bVg_jcaJABjib-nf8eE3RlNqzWjKjIyw?e=Gw8zjZ"],
      ["3.1.1 Terms of Trade","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EZHWMlRIGK9CqLjFMysvTRYBdCXus3XSNYQGMnpUfuyyQA?e=jsjxgG"],
      ["3.1.1 Globalisation","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Eb41MO3YF3NLnQMzpMvSqboBRn9i9woe2yv6LbN0uebBhg?e=LaY4JT"],
      ["3.2.1 The European Union","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/Eb8g-qVioVJDgov33kc1grYBofbwxlKwFfsV6uVaapYnoQ?e=tG2L3h"],
      ["3.2.1 Monetary Union","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EUI5d875M7BDjtMuuewyX-cBGUvsYToPMdccIRPS3I8mJA?e=WzeNBH"],
      ["3.3.1 Measurement of Economic Development","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EZtaHau4Op9Eq02t9cWRh8cB01qCwPH8M8WIucZwM1CyqA?e=vJSiHp"],
      ["3.3.2 Obstacles to Development","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/EUOqAtqikspMgXNvECKL8ycBcsrULag_J6uQU2GqWvX2lw?e=9WiW1N"],
      ["3.3.3 Solutions to Economic Development","https://truropenwith-my.sharepoint.com/:p:/g/personal/ryanhughes_callywith_ac_uk/ERdh3HkAolNKnThSOxHT9yUBjiILu04jIjVEWeDqPMJuxA?e=wRGwoy"]

]




 



 




var div = document.getElementById("div1");

for(var i=0; i<index.length; i++) {
	
	var p = document.createElement("li");
	
	var link = document.createElement("a");
	link.innerHTML = index[i][0];
	link.setAttribute("href", index[i][1]);
	link.setAttribute("target", "_blank");
	
	p.appendChild(link);
	div.appendChild(p);
	
	
}


</script>

</body>


</html>
