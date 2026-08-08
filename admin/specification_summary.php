<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$style_input = "

  th, td {
    border-bottom: 1px solid #cbd5e1;
    border-right: 1px solid #cbd5e1;
    padding: 6px 8px;
    vertical-align: top;
  }

  table {
    border-collapse: separate;
    border-spacing: 0;
    border-top: 1px solid #cbd5e1;
    border-left: 1px solid #cbd5e1;
    width: 100%;
    margin-bottom: 1.5rem;
  }

";

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Specification Summary</h1>

  <div class="container mx-auto p-4 mt-2 bg-white text-black mb-5">

    <div class="border-2 rounded border-sky-200 p-3 mb-4">
      <p>This page reproduces the subject content tables from each exam board's published A Level Economics specification, word for word, using each board's own table headings. It's a reference tool for comparing exactly what each specification says, not a summary or rewording.</p>
    </div>

    <div class="mb-4">
      <span class="font-mono">Jump to:</span>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#eduqas">Eduqas</a>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#wjec">WJEC</a>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#aqa">AQA</a>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#edexcel">Edexcel</a>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#ocr">OCR</a>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#cie">CIE</a>
      <a class="underline hover:bg-sky-100 text-sky-700" href="#ib">IB</a>
    </div>

    <!-- ============================================================ -->
    <!-- EDUQAS -->
    <!-- ============================================================ -->
    <h2 id="eduqas" class="text-xl bg-pink-300 p-1 font-mono mb-2">Eduqas</h2>
    <p class="mb-4">Eduqas (the England-facing brand of WJEC/CBAC) and WJEC publish the same A Level Economics specification content, word for word — WJEC is the Wales-regulated version of the same document. Rather than duplicate the full tables twice, see the <a class="underline text-sky-700 hover:bg-sky-100" href="#wjec">WJEC section below</a> for the complete verbatim content, which applies equally to Eduqas.</p>

    <!-- ============================================================ -->
    <!-- WJEC -->
    <!-- ============================================================ -->
    <h2 id="wjec" class="text-xl bg-pink-300 p-1 font-mono mb-2">WJEC (also applies to Eduqas)</h2>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Scarcity and choice</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Scarcity, choice and opportunity cost</td>
        <td>Define and illustrate the concepts of scarcity, choice and opportunity cost for society, individuals and the government</td>
        <td>Learners should understand that these concepts show that all economies have to decide what, how and for whom to produce and understand the difference between economic goods and free goods</td>
      </tr>
      <tr>
        <td>Production possibility frontiers (PPFs)</td>
        <td>Use production possibility frontier diagrams to depict choice, opportunity cost, short and long-term economic growth and efficiency<br><br>Understand movements along and shifts in PPFs<br><br>Understand that the PPF is usually drawn concave to the origin because of imperfect factor substitution and why a straight line PPF is an indication of perfect factor substitutability of resources<br><br>Explain factors which may shift the PPF inwards or outwards<br><br>Relate long-term economic growth and changes in productivity to outward or skewed shifts in an economy's PPFs</td>
        <td>Learners will need to understand the concept of increasing opportunity cost at the margin as output increases<br><br>Learners should be able to understand the link between PPFs and economic potential as shown by the long run aggregate supply curve</td>
      </tr>
      <tr>
        <td>Specialisation, division of labour and exchange</td>
        <td>Understand the advantages and disadvantages of specialisation<br><br>Define productivity and explain how it may be increased by the use of specialisation and other factors</td>
        <td>Learners should understand the importance of specialisation at the individual and national level</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Demand and supply in product markets</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Factors influencing demand and supply in product markets</td>
        <td>Define a product market<br><br>Explain the objectives of economic agents: that firms seek to maximise profits and consumers seek to maximise satisfaction/utility<br><br>Understand the importance of marginal utility in the derivation of demand curves<br><br>Identify the main influences on demand and supply in product markets<br><br>Understand why demand curves normally slope downward from left to right<br><br>Understand why supply curves will normally slope upward from left to right, for example, producers will be able to make higher profits at higher prices and that higher levels of output mean increased marginal costs in the short run</td>
        <td>Knowledge of indifference analysis will not be required<br><br>Learners should be aware that firms and consumers are assumed to behave rationally<br><br>Learners should understand the concept of diminishing marginal utility. Understanding the law of equi-marginal returns is not required<br><br>Learners should have a basic understanding of the substitution and income effects of a price change<br><br>Learners should be aware of the assumption that firms are price takers in this analysis of the supply curve</td>
      </tr>
      <tr>
        <td>The determination of equilibrium price and output in a freely competitive market</td>
        <td>Illustrate, using diagrams, equilibrium price and output situations in product markets<br><br>Explain effects on price and output of shifts in demand and supply curves</td>
        <td>Learners should be able to understand the reasons for movements along and shifts of demand and supply curves</td>
      </tr>
      <tr>
        <td>Consumer and producer surplus</td>
        <td>Define, explain and illustrate, using diagrams, consumer surplus and producer surplus</td>
        <td>Learners should be aware that consumer surplus and producer surplus are jointly maximised at the free market equilibrium<br><br>Learners should be able to calculate the value of consumer and producer surplus, for example, calculating the area of a triangle from the figures given on a diagram</td>
      </tr>
      <tr>
        <td>Price, income and cross price elasticities of demand, price elasticity of supply</td>
        <td>Understand the meaning of the terms price, income and cross price elasticities of demand and price elasticity of supply<br><br>Explain the relationship between price elasticity of demand and total revenue<br><br>Use the concept of income elasticity to distinguish between normal and inferior goods<br><br>Apply the concept of elasticity to economic contexts for example, in the incidence of taxation and the incidence of subsidies</td>
        <td>Learners should be able to define, calculate and interpret numerical values of elasticity<br><br>Learners should be aware of the factors which influence price, income and cross price elasticities of demand and price elasticity of supply<br><br>Learners should understand that price elasticity of demand varies along a straight line downward sloping demand curve<br><br>Learners should be able to evaluate the extent to which knowledge of price elasticity of demand and supply are important to decision-making in firms and government</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Demand and supply in labour markets</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Wage determination</td>
        <td>Identify the main influences on demand and supply in labour markets<br><br>Understand determinants of the elasticity of the demand and supply of labour<br><br>Understand the causes and implications of wage differentials</td>
        <td>Knowledge of marginal revenue product theory is not required<br><br>Knowledge of the factors which cause shifts in the demand and supply curves of labour is required, illustrated by the use of diagrams<br><br>Learners should take the opportunity to investigate wages in Wales compared to the rest of the UK</td>
      </tr>
      <tr>
        <td>Labour market issues</td>
        <td>Understand the factors which affect flexibility in labour markets, for example, trade union power, regulation, welfare payments and income tax rates<br><br>Evaluate the effects of the statutory national minimum wage on labour markets<br><br>Explain the impact of migration on labour markets</td>
        <td>Learners should understand the links between issues in the labour market and supply side performance in the economy<br><br>Learners should understand the impact of the national minimum wage on economic agents and the wider economy<br><br>Learners should investigate the case for a regional minimum wage for Wales<br><br>Learners should be able to illustrate this through the use of diagrams</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Resource allocation</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>How resources are allocated in a free market economy</td>
        <td>Understand the role of profit and the function of prices in allocating resources to different uses<br><br>Understand that changes in one market affect other markets, for example, interrelationships between factor and product markets</td>
        <td>Learners should be aware of the main assumptions upon which free markets operate, such as a large number of buyers and sellers, perfect information<br><br>Learners should understand that, in reality, economic agents do not always behave rationally</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Market failure</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Understanding market failure</td>
        <td>Define market failure and have an understanding of efficiency, that is, the maximisation of consumer/producer surplus at the free market equilibrium output<br><br>Understand that market failure may take many forms, including public goods; merit and demerit goods; externalities; monopoly power; information asymmetries and gaps; an absence of private property rights; income inequality; volatile prices<br><br>Appreciate the reasons for, and the consequences of, each source of market failure for economic agents</td>
        <td>Learners should be able to distinguish between public goods and private goods<br><br>Learners should be able to draw and analyse diagrams showing the external benefits of consumption and the external costs of consumption and production<br><br>Learners should be able to derive the socially efficient level of output and identify and explain welfare loss</td>
      </tr>
      <tr>
        <td>Why and how governments intervene in markets</td>
        <td>Explain why and how governments intervene in markets, for example, to correct market failure and reduce income inequality<br><br>Evaluate government intervention policies</td>
        <td>Governments may intervene by using policies, such as taxation (specific and ad valorem taxes), subsidies, state provision and regulation, minimum and maximum prices, use of prices, for example, road pricing and tradeable pollution permits<br><br>Simple demand and supply diagrams should be used<br><br>Learners should be able to link policies to the reduction of income inequality, for example, progressive taxation and the benefits system, price stabilisation and guaranteed minimum price schemes in agriculture and the national minimum wage<br><br>Learners should take the opportunity to investigate how the Welsh government has intervened to correct market failure, for example, free NHS prescriptions and charges for plastic bags<br><br>Opportunities to apply income inequality in a Welsh context might include differences in income between areas of Wales, such as parts of rural Wales and South Wales Valleys compared to cities such as Cardiff and Swansea</td>
      </tr>
      <tr>
        <td>The effects of government intervention</td>
        <td>Explain that, in certain cases, government intervention can create distortions in markets, for example, in agriculture, housing and labour markets<br><br>Understand the reasons for government failure and be able to evaluate its effects</td>
        <td>Learners should be aware of distortions in markets and examples of government failure</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Macroeconomic theory</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>The circular flow of income model</td>
        <td>Explain the flows in the circular flow model and understand that they should be equal (income = output = expenditure)<br><br>Explain injections into and withdrawals from the circular flow<br><br>Use the model to explain the concept of national income equilibrium and to explain how changes in injections and withdrawals might lead to changes in the equilibrium level of national income, and hence explain the multiplier process</td>
        <td>Learners will not be required to calculate the multiplier</td>
      </tr>
      <tr>
        <td>The units of aggregate demand (AD)</td>
        <td>Define the units of aggregate demand: consumption, investment, government spending and net exports (exports minus imports)<br><br>Explain the factors which affect the levels of consumption and investment in the economy</td>
        <td>Learners should explain the importance of factors such as income and profit, wealth, interest rates, expectations and taxation<br><br>Knowledge of the Keynesian theory of the consumption function, the marginal efficiency of capital and the accelerator effect are not required</td>
      </tr>
      <tr>
        <td>The AD function</td>
        <td>Understand why an AD function will slope downward from left to right<br><br>Understand that changes in the units of AD can cause the function to shift</td>
        <td>Learners are expected to explain at least one of the following: the real balance effect, the trade effect and the interest rate effect</td>
      </tr>
      <tr>
        <td>The aggregate supply (AS) function</td>
        <td>Understand the shape of the Keynesian long run aggregate supply (LRAS) curve<br><br>Understand the factors which might result in a shift in LRAS</td>
        <td>Learners are expected to realise that the LRAS is vertical at the full employment level of output<br><br>These include: changes in the quantity, quality and efficiency of use of factors of production, changes in the state of technology and changes in factor market flexibility<br><br>Learners should understand how changes in policy instruments may be used to bring such shifts about</td>
      </tr>
      <tr>
        <td>AD/AS analysis</td>
        <td>Illustrate and explain how AD and AS interact to determine the equilibrium level of output, employment and prices in the long run</td>
        <td>Diagrammatic analysis is required</td>
      </tr>
      <tr>
        <td>Short run aggregate supply (SRAS)</td>
        <td>Understand why the SRAS function is assumed to slope upwards from left to right<br><br>Understand why a SRAS function might shift</td>
        <td>Learners should understand the assumptions behind SRAS analysis, such as fixed input prices, productivity and technology<br><br>Learners should be aware that SRAS in this form is associated with Monetarist and Neo-Classical economists<br><br>Factors might include changes in labour costs, changes in commodity prices, changes in the value of the exchange rate, taxation and subsidies</td>
      </tr>
      <tr>
        <td>Long run aggregate supply (LRAS)</td>
        <td>Understand that there are differences between Keynesian and Neo-Classical views on what the AS curve will look like in the long run<br><br>Explain the Neo-Classical view of the process through which an economy might adjust to long run equilibrium<br><br>Understand that Keynesian economists disagree with this process of adjustment because of issues such as inflexible factor markets ('sticky wage', etc.) and that, consequently, the LRAS function may not be vertical at the equilibrium level of output</td>
        <td>Learners should understand the assumptions of flexible product and factor markets which underpin this analysis</td>
      </tr>
      <tr>
        <td>The short run Phillips curve</td>
        <td>Explain that there may be a trade-off between inflation and unemployment in the short run and that such trade-offs have been observed in the UK</td>
        <td>Diagrammatic analysis is required</td>
      </tr>
      <tr>
        <td>The long run Phillips curve</td>
        <td>Argue that Neo-Classical economists believe that the short run Phillips curve is not stable due to the role of expectations; in the long run, attempts to hold unemployment below its natural rate/NAIRU will result in accelerating inflation and that when the economy eventually return to its natural rate/NAIRU it will do so with a higher level of inflation<br><br>Understand that changes on the supply side (either favourable or adverse) can cause the position of the long run Phillips curve to shift and that economic policy changes can bring such shifts about</td>
        <td>Learners should understand the role of inflationary expectations within this model<br><br>Diagrammatic analysis is required</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Macroeconomic objectives</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Government policy objectives</td>
        <td>Explain the main macroeconomic objectives and possible conflicts between policy objectives</td>
        <td>Learners should understand why governments have attempted to achieve low inflation, low levels of unemployment, sustainable economic growth and equilibrium in the current account of the balance of payments</td>
      </tr>
      <tr>
        <td>Economic growth<br><br>Actual vs potential economic growth<br>Causes of growth<br>Benefits and costs of growth</td>
        <td>Explain the differences between changes in measured gross domestic product (GDP) (actual growth) and potential growth and understand that by 'economic growth' economists are generally referring to an increase in the productive capacity of the economy rather than short-term changes in the level of national income<br><br>Explain the differences between actual and potential growth using the concepts of positive and negative output gaps and the business cycle<br><br>Understand what is meant by the term 'recession'<br><br>Understand that growth can be brought about by changes in factors such as the quantity, quality and efficiency of use of factors of production, changes in the state of technology and changes in factor market flexibility<br><br>Understand why growth may be beneficial to an economy in terms of impact on households, governments and firms</td>
        <td>Learners should be able to illustrate actual and potential growth diagrammatically using both PPF and AD/AS analysis<br><br>Learners should be able to discuss the importance of these factors and discuss the extent to which changes in policy instruments may be used to create growth<br><br>Learners should be able to evaluate these benefits in terms of how evenly such benefits may be distributed, the opportunity costs of growth, the sustainability of growth and the side-effects of growth in terms of conflicts with other policy objectives</td>
      </tr>
      <tr>
        <td>Unemployment<br><br>Measurement and types<br>Costs<br>Causes</td>
        <td>Understand that unemployment can be measured in different ways and be aware of the current major approaches and the problems with measuring unemployment accurately<br><br>Examine the costs of unemployment; these may be both economic and social and may apply to households, governments, firms and the economy<br><br>Understand demand side causes, such as cyclical unemployment, driven by a fall in the level of GDP (different schools of thought have different views about how temporary this is likely to be)<br><br>Understand supply side causes are driven by problems in factor markets, such as occupational and geographical inflexibility, lack of incentives to work and real wage unemployment</td>
        <td>Learners should understand the differences between economically active and inactive individuals and should understand what is meant by the labour force<br><br>Learners should be made aware of differences in unemployment rates between Wales and other economies as well as differences between various Welsh regions<br><br>Learners should understand that Keynesian and Neo-Classical economists have different views as to the real underlying causes of unemployment<br><br>Learners should understand the natural rate of unemployment</td>
      </tr>
      <tr>
        <td>Solutions</td>
        <td>Understand that solutions to unemployment will depend on its cause and nature, but that approaches can broadly be characterised as either demand side or supply side<br><br><em>Demand side solutions</em><br>Understand that, where a negative output gap exists, governments can use fiscal and monetary policy to increase the level of aggregate demand<br><br>Evaluate the appropriateness and potential effectiveness of such solutions<br><br><em>Supply side solutions</em><br>Explain and evaluate potential supply side approaches to the reduction of unemployment, targeted at particular labour market problems</td>
        <td>Learners should be aware of policies to improve mobility of labour and labour market flexibility</td>
      </tr>
      <tr>
        <td>Inflation and deflation<br><br>Measurement and calculation<br>Causes<br>Costs<br>Solutions<br>Deflation</td>
        <td>Understand how inflation is calculated via weighted changes in price indices, generally over a twelve month period<br><br>Identify the major measures of inflation in use at the present time and the differences between them<br><br>Understand demand-pull and cost-push explanations of inflation<br><br>Explain and evaluate the quantity theory of money<br><br>Appreciate that rising prices can create costs, but that these costs will depend on the level of inflation, the cause of inflation and the extent to which it was anticipated<br><br>Explain and evaluate possible responses to the issue of inflation in terms of how effective or desirable solutions are likely to be<br><br>Understand that, as with inflation, deflation may be either demand side or supply side driven and the effects will depend upon the cause — deflationary pressure caused by supply side improvements may be viewed as beneficial under some circumstances<br><br>Understand that demand-deflation can create major problems for economies and understand the costs of such deflation to households, governments and firms as well as the difficulties governments face when trying to end deflationary spirals once they have taken hold</td>
        <td>Learners should be able to calculate simple price indices and understand the purpose of weights<br><br>Learners should be able to calculate and interpret index numbers, in the context of inflation and in other areas<br><br>Learners should understand the role of expectations in sustaining and driving inflation through mechanisms such as the wage-price spiral<br><br>Costs include redistributive effects, macroeconomic effects and efficiency effects<br><br>Approaches may include using fiscal and/or monetary policy to control AD/the money supply, supply side policies to improve labour and product market flexibility, direct controls on wages and prices and attempts to reduce inflationary expectations</td>
      </tr>
      <tr>
        <td>The balance of payments<br><br>Measurement<br>Current account imbalances: causes<br>Current account imbalances: impacts<br>Solutions to current account deficits</td>
        <td>Understand what is meant by the balance of payments<br><br>Understand that the balance of payments sums to zero overall and that a current account deficit or surplus will be matched by compensating flows on the capital/financial accounts<br><br>Understand why countries may end up running current account deficits (or surpluses) and what is meant by a structural deficit (or surplus)<br><br>Understand the possible link between changes in the terms of trade and the overall current account balance<br><br>Evaluate the consequences of a current account deficit/surplus<br><br>Evaluate possible approaches to dealing with a sustained current account deficit</td>
        <td>Detailed knowledge of the sub-units of the balance of payments is not required<br><br>Factors may include: productivity, factor costs, exchange rates, industrial structure, commodity prices, protectionist policies and sources of comparative advantage<br><br>Learners should be able to calculate the terms of trade index<br><br>Understanding the nature of the deficit/surplus, its causes and the nature of compensating capital inflows are likely to be significant in evaluation<br><br>These may include exchange rate policies, deflationary policies, supply side reforms and protectionism</td>
      </tr>
      <tr>
        <td>Control of the national (public sector) debt<br><br>Measurement<br>Causes<br>Implications<br>Solutions</td>
        <td>Understand the relationship between the budget/fiscal deficit and the national (public sector) debt<br><br>Understand that deficits may result from either discretionary or automatic government policy<br><br>Explain why governments have been concerned about high levels of public sector debt<br><br>Concerns may include opportunity cost of interest payments, risk of credit downgrades, confidence issues surrounding refinancing and the risk of crowding out and slower growth<br><br>Discuss the extent to which it is appropriate to tighten fiscal policy during periods of economic downturn as a way of reducing the budget/fiscal deficit</td>
        <td>Learners should understand the difference between structural and cyclical deficits<br><br>Learners should be able to evaluate the extent to which these concerns are reasonable and hence whether debt is always a bad thing</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Policy instruments</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td><strong>Fiscal policy</strong></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Framework</td>
        <td>Understand the overall purpose and structure of the budget<br><br>Analyse the possible impact of changes in tax and spending on the economy using AD/AS diagrams and the Laffer curve</td>
        <td>Learners should be aware of the major areas of government expenditure and sources of revenue<br><br>Learners should be able to explain the differences between current expenditure and capital expenditure and between direct and indirect taxes and their relative desirability</td>
      </tr>
      <tr>
        <td>Demand side fiscal policy</td>
        <td>Explain how Keynesian economists believe that fiscal policy can and should be used to control the level of aggregate demand in the economy under certain circumstances</td>
        <td>Learners should be able to illustrate this idea using AD/AS diagrams<br><br>Learners should be able to evaluate the use of demand side fiscal policy in terms of both its effectiveness and possible side effects, for example, on the public sector debt</td>
      </tr>
      <tr>
        <td>Supply side fiscal policy</td>
        <td>Explain that fiscal policy can be used to achieve policy objectives by operating on the supply side in the longer term (examples might include influencing incentives to work and to invest, improving infrastructure)</td>
        <td>Learners should be able to evaluate the effectiveness of these types of policy</td>
      </tr>
      <tr>
        <td><strong>Monetary policy</strong></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Framework</td>
        <td>Understand the role of the Bank of England in creating monetary and financial stability, and its status as lender of the last resort<br><br>Understand the purpose of the Bank's inflation target, its symmetrical nature and any other objectives that the Bank may be required to pursue</td>
        <td></td>
      </tr>
      <tr>
        <td>The operation of monetary policy and monetary stability<br><br>Interest rates</td>
        <td>Understand how changes in interest rates may be used to achieve the Bank's objectives and the factors the Bank is likely to take into account when setting base interest rates<br><br>Understand how interest rate changes can impact both the real economy and inflation<br><br>Discuss the extent to which changes in interest rates are likely to affect the exchange rate</td>
        <td>Learners should be able to evaluate the likely impact of changes in interest rates and the overall effectiveness of interest rate control as a policy tool<br><br>Learners should be able to use AD/AS diagrams to support their analysis and evaluation<br><br>Learners may take the opportunity to investigate whether interest rates set by the Bank of England are appropriate for all areas of the UK, especially the Welsh economy</td>
      </tr>
      <tr>
        <td>Quantitative easing (QE)</td>
        <td>Understand the role of QE within the financial system and be able to explain how QE is expected to work</td>
        <td>Learners should be able to evaluate the impact and risks of QE<br><br>Learners should understand the process through which QE may eventually be reversed<br><br>Detailed knowledge of different measures of the money supply is not required</td>
      </tr>
      <tr>
        <td>Direct intervention</td>
        <td>Understand that central banks can intervene directly in the banking system to stimulate lending activity, for example, funding for lending<br><br>Learners should be able to analyse and evaluate any additional changes to the operation of monetary policy that arise over time</td>
        <td></td>
      </tr>
      <tr>
        <td><strong>Financial stability</strong></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>The financial sector</td>
        <td>Understand the changes in the structure of the UK economy in recent years, in particular the growing size and influence of the financial sector</td>
        <td>Learners should be able to evaluate the extent to which the UK's large financial sector is beneficial to the real economy</td>
      </tr>
      <tr>
        <td>Asset bubbles</td>
        <td>Explain, with appropriate examples (for example the financial crisis of 2007-08), how asset bubbles may arise and what the economic consequences of such bubbles may be</td>
        <td></td>
      </tr>
      <tr>
        <td>The role and purpose of regulation</td>
        <td>Understand the need for regulation of the financial system in terms of creating financial stability</td>
        <td>Learners are not expected to have a detailed understanding of the system of financial regulation in the UK</td>
      </tr>
      <tr>
        <td><strong>Exchange rates and exchange rate policy</strong></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Exchange rates in a free market</td>
        <td>Explain that in a free-float system, the exchange rate will be determined by the forces of demand and supply<br><br>Use demand and supply diagrams to analyse and evaluate the factors which might cause exchange rates to appreciate or depreciate<br><br>Evaluate the possible impacts of changes in exchange rates on the policy objectives<br><br>Evaluate the microeconomic effects of exchange rate changes on households and firms</td>
        <td>Learners should understand that demand for a currency is equal to exports plus capital inflows, whilst supply is equal to imports plus capital outflows<br><br>Such factors may include interest rates, QE, trade flows, confidence, safe haven issues and speculation<br><br>Learners should be able to use AD/AS diagrams to support their analysis</td>
      </tr>
      <tr>
        <td>Exchange rate policy</td>
        <td>Understand how monetary authorities can influence the value of an exchange rate in a floating system (a 'managed' or 'dirty' float)<br><br>Evaluate the advantages and disadvantages of policies which hold exchange rates artificially above or below their free market levels</td>
        <td>Learners should understand what is meant by an exchange rate index</td>
      </tr>
      <tr>
        <td>Supply side policies</td>
        <td>Understand what is meant by supply side policies and understand how they can be used to try to increase trend growth/LRAS in the economy as well as the flexibility of product and factor markets</td>
        <td>Learners should be able to evaluate supply side policies in terms of both their effectiveness and possible side effects<br><br>Learners should be able to analyse and evaluate the impact of supply side policies using AD/AS analysis and PPFs</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">International trade</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Advantages and disadvantages of free trade<br>Protectionism<br>Globalisation<br>Trade and the UK</td>
        <td>Understand the advantages and disadvantages of international trade from the point of view of the economy as a whole and for households, firms and government<br><br>Understand the arguments for and against the implementation of protectionist policies<br><br>Explain and illustrate key methods of protectionism<br><br>Evaluate the costs and benefits of globalisation<br><br>Identify the UK's major export sectors<br><br>Evaluate the extent to which an increasingly integrated world economy is beneficial to the UK</td>
        <td>Learners should be able to explain the theory of comparative advantage using numerical and graphical approaches<br><br>Learners should understand the difference between absolute and comparative advantage<br><br>Learners should be able to explain and numerically illustrate the terms of trade<br><br>Methods include: tariffs (diagram required), quotas, subsidies, exchange rate manipulation and administrative/regulatory policies<br><br>Learners should understand the role of the World Trade Organisation (WTO) in policing trade agreements and negotiations</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Non-UK economies</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>European Union</td>
        <td>Learners need to draw on examples from economies other than the UK when discussing economic problems<br><br>Analyse and evaluate the advantages and disadvantages of membership of the EU for member states and prospective members<br><br>Evaluate whether the continuous expansion of the EU is beneficial for both existing members and new members<br><br>Evaluate the benefits and possible drawbacks of membership of the economic and monetary union (EMU)<br><br>Assess the EMU in terms of its fit with an optimal currency area</td>
        <td>Learners should have some understanding of typical economic problems facing more economically developed countries (MEDCs), LEDCs and emerging economies<br><br>Learners should have an understanding of the structure of the EMU (eurozone), including the role of the European Central Bank</td>
      </tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Economic development</h3>
    <table>
      <tr><th>Content</th><th>Amplification</th><th>Additional guidance notes</th></tr>
      <tr>
        <td>Measurement</td>
        <td>Understand what is meant by the concept of economic development<br><br>Evaluate the extent to which changes in national income are a good indicator of changes in the level of development in a country<br><br>Identify and understand other possible measures of economic development, including: the human development index (HDI); the economic structure of an economy; more indirect indicators such as access to health and education, access to the internet and mobile phone usage</td>
        <td>Learners should be able to explain the difference between GDP and gross national product (GNP)<br><br>Learners should understand the meaning and significance of purchasing power parity adjustments<br><br>Learners will not be expected to calculate HDI<br><br>Learners should have an awareness of the United Nations Millennium Development Goals</td>
      </tr>
      <tr>
        <td>Obstacles</td>
        <td>Discuss why LEDCs may face difficulties in competing with MEDCs and in raising their level of economic development<br><br>Explain and evaluate relevant obstacles; including: the extent to which endowment with natural resources is beneficial or whether there is a 'resource curse', low levels of health and education, low life expectancy, the impact of MEDC trade policies, the impact of poor levels of infrastructure, capital and technology, the effect of institutional weakness and poor governance, high levels of public sector debt and rapid population growth</td>
        <td></td>
      </tr>
      <tr>
        <td>Solutions</td>
        <td>Explain and evaluate possible approaches to raising the level of economic development; including: liberalisation — a move towards a more free-market based system involving internal and external liberalisation, international aid, debt relief, government intervention in the form of policies such as import and export substituting industrialisation and encouraging FDI</td>
        <td></td>
      </tr>
    </table>

    <!-- ============================================================ -->
    <!-- AQA -->
    <!-- ============================================================ -->
    <h2 id="aqa" class="text-xl bg-pink-300 p-1 font-mono mb-2">AQA</h2>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">3.1 Individuals, firms, markets and market failure</h3>
    <p class="mb-3">This section of the specification is primarily about microeconomics.<br><br>Students will be required to acquire knowledge and understanding of a selection of microeconomic models and to apply these to current problems and issues. Microeconomic models such as demand and supply, perfect competition, monopoly, the operation of the price mechanism and the causes of market failure are central to this part of the specification. Students will need to demonstrate a realistic understanding of the decisions made by firms and how their behaviour can be affected by the structure and characteristics of the industry in which they operate. Other key models relate to the operation of labour markets, wage determination and causes of inequalities in the distribution of income and wealth.<br><br>Students will be expected to understand that traditional economic theory generally assumes that economic agents act rationally but they should also be introduced to models that recognise that consumer and firms' behaviour is often governed by more complex influences.<br><br>During their course of study, students should be provided with opportunities to use economic models to explore current economic behaviour. They should be able to apply their knowledge and skills to a wide variety of situations and to different markets and examples of market failure, including environmental and labour market failures. They should appreciate and be able to assess the impact that developments in the European Union and in the global economy have upon microeconomic behaviour and performance.</p>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.1 Economic methodology and the economic problem</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.1.1 Economic methodology<br><br>Economics as a social science.<br>Similarities to and differences in methodology from natural and other sciences.<br>The difference between positive and normative statements.<br>How value judgements influence economic decision making and policy.<br>People's views concerning the best option are influenced by the positive consequences of different decisions and by moral and political judgements.</td><td>Students should understand how thinking as an economist may differ from other forms of scientific enquiry.</td></tr>
      <tr><td>3.1.1.2 The nature and purpose of economic activity<br><br>The central purpose of economic activity is the production of goods and services to satisfy needs and wants.<br>The key economic decisions are: what to produce, how to produce and who is to benefit from the goods and services produced.</td><td></td></tr>
      <tr><td>3.1.1.3 Economic resources<br><br>The economists' classification of economic resources into land, labour, capital and enterprise, which are the factors of production.<br>The environment is a scarce resource.</td><td></td></tr>
      <tr><td>3.1.1.4 Scarcity, choice and the allocation of resources<br><br>The fundamental economic problem is scarcity and that it results from limited resources and unlimited wants.<br>Scarcity means that choices have to be made about how scarce resources are allocated between different uses.<br>Choices have an opportunity cost.</td><td></td></tr>
      <tr><td>3.1.1.5 Production possibility diagrams<br><br>Production possibility diagrams illustrate different features of the fundamental economic problem, such as: resource allocation, opportunity cost and trade-offs, unemployment of economic resources, economic growth.<br>Why all points on the boundary are productively efficient but not all points on the boundary are allocatively efficient.</td><td>Students should be able to use production possibility diagrams to illustrate these features.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.2 Individual economic decision making</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.2.1 Consumer behaviour<br><br>Rational economic decision making and economic incentives.<br>Utility theory: total and marginal utility, and the hypothesis of diminishing marginal utility.<br>Utility maximisation.<br>The importance of the margin when making choices.</td><td>Students should appreciate that the hypothesis of diminishing marginal utility supports a downward sloping demand curve but they are not expected to understand the principle of equi-marginal utility or to use this principle to explain why there is likely to be an inverse relationship between price and quantity demanded.</td></tr>
      <tr><td>3.1.2.2 Imperfect information<br><br>The importance of information for decision making.<br>The significance of asymmetric information.</td><td>Students should recognise that imperfect information makes it difficult for economic agents to make rational decisions and is a potential source of market failure.</td></tr>
      <tr><td>3.1.2.3 Aspects of behavioural economic theory<br><br>Bounded rationality and bounded self-control.<br>Biases in decision making: rules of thumb, anchoring, availability and social norms.<br>The importance of altruism and perceptions of fairness.</td><td>Students should appreciate that behavioural economists question the assumption of traditional economic theory that individuals are rational decision makers who endeavour to maximise their utility. They should understand some of the reasons why an individual's economic decisions may be biased.</td></tr>
      <tr><td>3.1.2.4 Behavioural economics and economic policy<br><br>Choice architecture and framing.<br>Nudges.<br>Default choices, restricted choice and mandated choice.</td><td>Students should appreciate that insights provided by behavioural economists can help governments and other agencies influence economic decision making.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.3 Price determination in a competitive market</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.3.1 The determinants of the demand for goods and services<br><br>A demand curve shows the relationship between price and quantity demanded.<br>The causes of shifts in the demand curve.</td><td></td></tr>
      <tr><td>3.1.3.2 Price, income and cross elasticities of demand<br><br>Be able to calculate price, income and cross elasticities of demand.<br>The relationship between income elasticity of demand and normal and inferior goods.<br>The relationship between cross elasticity of demand and substitute and complementary goods.<br>The relationships between price elasticity of demand and firms' total revenue (total expenditure).<br>The factors that influence these elasticities of demand.</td><td>Students should be able to interpret numerical values of these elasticities of demand.</td></tr>
      <tr><td>3.1.3.3 The determinants of the supply of goods and services<br><br>A supply curve shows the relationship between price and quantity supplied.<br>Understand that higher prices imply higher profits and that this will provide the incentive to expand production.<br>The causes of shifts in the supply curve.</td><td>Students should also know that, under perfect competition, the supply curve is the marginal cost curve.</td></tr>
      <tr><td>3.1.3.4 Price elasticity of supply<br><br>Be able to calculate price elasticity of supply.<br>The factors that influence price elasticity of supply.</td><td>Students should be able to interpret numerical values of price elasticity of supply.</td></tr>
      <tr><td>3.1.3.5 The determination of equilibrium market prices<br><br>How the interaction of demand and supply determines equilibrium prices in a market economy.<br>The difference between equilibrium and disequilibrium.<br>Why excess demand and excess supply lead to changes in price.</td><td>Students should be able to use demand and supply diagrams to help them to analyse causes of changes in equilibrium market prices.<br><br>They should be able to apply their knowledge of the basic model of demand and supply to a variety of real-world markets.<br><br>They should be aware of the assumptions of the model of supply and demand.</td></tr>
      <tr><td>3.1.3.6 The interrelationship between markets<br><br>Changes in a particular market are likely to affect other markets.<br>The implications of joint demand, competitive demand, composite demand, derived demand and joint supply.</td><td>Students should, for example, be able to explore the impact of changes in demand, supply and price in one market upon other related markets.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.4 Production, costs and revenue</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.4.1 Production and productivity<br><br>Production converts inputs, or the services of factors of production such as capital and labour, into final output.<br>The meaning of productivity, including labour productivity.</td><td></td></tr>
      <tr><td>3.1.4.2 Specialisation, division of labour and exchange<br><br>The benefits of specialisation and division of labour.<br>Why specialisation necessitates an efficient means of exchanging goods and services, such as the use of money as a medium of exchange.</td><td></td></tr>
      <tr><td>3.1.4.3 The law of diminishing returns and returns to scale<br><br>The difference between the short run and the long run.<br>The difference between marginal, average and total returns.<br>The law of diminishing returns.<br>Returns to scale.<br>The difference between increasing, constant and decreasing returns to scale.</td><td>Students should appreciate that both the law of diminishing returns and returns to scale explain relationships between inputs and output.<br><br>They should also understand that these relationships have implications for costs of production.</td></tr>
      <tr><td>3.1.4.4 Costs of production<br><br>The difference between fixed and variable costs.<br>The difference between marginal, average and total costs.<br>The difference between short-run and long-run costs.<br>The reasons for the shape of the marginal, average and total cost curves.<br>How factor prices and productivity affect firms' costs of production and their choice of factor inputs.</td><td>Students should be able to calculate different costs from given data. They should also be able to draw and interpret cost curves.</td></tr>
      <tr><td>3.1.4.5 Economies and diseconomies of scale<br><br>The difference between internal and external economies of scale.<br>Reasons for diseconomies of scale.<br>The relationship between returns to scale and economies or diseconomies of scale.<br>The relationship between economies of scale, diseconomies of scale and the shape of the long-run average cost curve.<br>The L-shaped long-run average cost curve.<br>The concept of the minimum efficient scale of production.</td><td>Students should be able to categorise and give examples of both internal and external economies of scale.<br><br>Students should understand the significance of the minimum efficient scale for the structure of an industry and barriers to entry.</td></tr>
      <tr><td>3.1.4.6 Marginal, average and total revenue<br><br>The difference between marginal, average and total revenue.<br>Why the average revenue curve is the firm's demand curve.<br>The relationship between average and marginal revenue.<br>The relationship between marginal revenue and total revenue.</td><td>Students should be able to calculate marginal, average and total revenue from given data. They should also be able to draw and interpret revenue curves.</td></tr>
      <tr><td>3.1.4.7 Profit<br><br>Profit is the difference between total revenue and total costs.<br>The difference between normal and abnormal (supernormal) profit.<br>The role of profit in a market economy.</td><td></td></tr>
      <tr><td>3.1.4.8 Technological change<br><br>The difference between invention and innovation.<br>Technological change can affect methods of production, productivity, efficiency and firms' costs of production.<br>Technological change can lead to the development of new products, the development of new markets and may destroy existing markets.<br>Technological change can influence the structure of markets.</td><td>Students should understand how the process of creative destruction is linked to technological change.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.5 Perfect competition, imperfectly competitive markets and monopoly</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.5.1 Market structures<br><br>The spectrum of competition ranging from perfect competition at one end of the spectrum to pure monopoly at the other end of the spectrum.<br>Factors such as the number of firms, the degree of product differentiation and ease of entry are used to distinguish between different market structures.</td><td></td></tr>
      <tr><td>3.1.5.2 The objectives of firms<br><br>The models that comprise the traditional theory of the firm are based upon the assumption that firms aim to maximise profits.<br>The profit-maximising rule (MC=MR).<br>The reasons for and the consequences of a divorce of ownership from control.<br>Firms have a variety of other possible objectives.<br>The satisficing principle.</td><td>Students should recognise that firms have a range of possible objectives including survival, growth, quality, maximising their sales revenue and increasing their market share.<br><br>Students should be able to discuss how the divorce of ownership from control may affect the objectives of firms, their conduct and performance.</td></tr>
      <tr><td>3.1.5.3 Perfect competition<br><br>The formal diagrammatic analysis of the perfectly competitive model in the short and long run.<br>The implications of the following for the behaviour of firms and the industry: large numbers of producers, identical products, freedom of entry and exit, and perfect knowledge.<br>Firms operating in perfectly competitive markets are price takers.<br>The proposition that, given certain assumptions, relating for example to a lack of externalities, perfect competition will result in an efficient allocation of resources.</td><td>Students should be aware that perfect competition, in both product and labour markets, provides a yardstick for judging the extent to which real world markets perform efficiently or inefficiently, and the extent to which a misallocation of resources occurs.<br><br>Students should also be able to assess critically the proposition that perfectly competitive markets lead to an efficient allocation of resources.</td></tr>
      <tr><td>3.1.5.4 Monopolistic competition<br><br>The formal diagrammatic analysis of the monopolistically competitive model in the short and long run.<br>The main characteristics of monopolistically competitive markets.<br>Monopolistically competitive markets will be subject to non-price competition.</td><td></td></tr>
      <tr><td>3.1.5.5 Oligopoly<br><br>The main characteristics of oligopolistic markets.<br>Oligopolistic markets can be very different in relation to, for example, the number of firms, the degree of product differentiation and ease of entry.<br>Oligopoly can be defined in terms of market structure or in terms of market conduct (behaviour).<br>Concentration ratios and how to calculate a concentration ratio.<br>The difference between collusive and non-collusive oligopoly.<br>The difference between cooperation and collusion.<br>The kinked demand curve model.<br>The reasons for non-price competition, the operation of cartels, price leadership, price agreements, price wars and barriers to entry.<br>The factors which influence prices, output, investment, expenditure on research and advertising in oligopolistic industries.<br>The significance of interdependence and uncertainty in oligopoly.<br>The advantages and disadvantages of oligopoly.</td><td>Students should be aware of the various factors which affect the behaviour and performance of firms in a variety of real world markets. The factors include different barriers to entry and the degree of concentration and product differentiation.<br><br>The kinked demand curve model should be used as an illustration of the interdependence between firms and not taught as if it is the only model of oligopoly.<br><br>Students should recognise that collusion may allow oligopolists to act as a monopolist and maximise their joint profits.</td></tr>
      <tr><td>3.1.5.6 Monopoly and monopoly power<br><br>The formal diagrammatic analysis of the monopoly model.<br>That monopoly power is influenced by factors such as barriers to entry, the number of competitors, advertising and the degree of product differentiation.<br>The advantages and disadvantages of monopoly.</td><td>Students should appreciate that firms operating in monopolistically competitive and oligopolistic markets are price makers and have varying degrees of monopoly power.</td></tr>
      <tr><td>3.1.5.7 Price discrimination<br><br>The conditions necessary for price discrimination.<br>The advantages and disadvantages of price discrimination.</td><td>Students should be aware of real-world examples of price discrimination and be able to assess its impact on producers and consumers.<br><br>A diagrammatic analysis of price discrimination is expected.</td></tr>
      <tr><td>3.1.5.8 The dynamics of competition and competitive market processes<br><br>Both the short-run and long-run benefits which are likely to result from competition.<br>That firms do not just compete on the basis of price but that competition will, for example, also lead firms to strive to improve products, reduce costs, improve the quality of the service provided.<br>The process of creative destruction.</td><td>Students should understand that if firms have monopoly power and are making large profits, over time there will be an incentive for new firms to enter the market and to innovate to overcome the existing barriers to entry. Students should understand that this process of creative destruction is a fundamental feature of the way in which competition operates in a market economy.</td></tr>
      <tr><td>3.1.5.9 Contestable and non-contestable markets<br><br>The significance of market contestability for the performance of an industry.<br>Concepts such as sunk costs and hit-and-run competition.</td><td></td></tr>
      <tr><td>3.1.5.10 Market structure, static efficiency, dynamic efficiency and resource allocation<br><br>The difference between static efficiency and dynamic efficiency.<br>The conditions required for productive efficiency (minimising average total costs) and allocative efficiency (price = marginal cost).<br>Dynamic efficiency is influenced by, for example, research and development, investment in human and non-human capital and technological change.</td><td>Students should be able to apply efficiency concepts when comparing the performance of firms in markets with different structures. They should understand how conduct and performance indicators can be used to compare market structures.</td></tr>
      <tr><td>3.1.5.11 Consumer and producer surplus<br><br>Be able to apply these concepts when discussing economic efficiency and welfare issues, such as price discrimination and the dead-weight losses associated with monopoly.</td><td>Diagrammatic analysis is expected.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.6 The labour market</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.6.1 The demand for labour, marginal productivity theory<br><br>The demand for a factor is derived from the demand for the product.<br>The marginal productivity theory of the demand for labour.<br>The demand curve for labour shows the relationship between the wage rate and number of workers employed.<br>The causes of shifts in the demand curve for labour.<br>The determinants of the elasticity of demand for labour.</td><td></td></tr>
      <tr><td>3.1.6.2 Influences upon the supply of labour to different markets<br><br>The supply of labour to a particular occupation is influenced by monetary and non-monetary considerations.<br>Non-monetary considerations include job satisfaction and dissatisfaction and working conditions.<br>The supply curve for labour shows the relationship between the wage rate and number of workers willing to work in an occupation.<br>The causes of shifts in the market supply curve for labour.</td><td>Students will not be required to understand the determinants of an individual's supply of labour or the backward-bending supply curve.</td></tr>
      <tr><td>3.1.6.3 The determination of relative wage rates and levels of employment in perfectly competitive labour markets<br><br>The economists' model of wage determination in a perfectly competitive labour market.<br>Role of market forces in determining relative wage rates.</td><td>Students should appreciate that all real-world markets are imperfectly competitive to a greater or lesser extent.</td></tr>
      <tr><td>3.1.6.4 The determination of relative wage rates and levels of employment in imperfectly competitive labour markets<br><br>How various factors such as monopsony power, trade unions and imperfect information contribute to imperfections in a labour market.<br>How, in a monopsony labour market, the employer can use market power to reduce both the relative wage rate and the level of employment below those that would exist in a perfectly competitive labour market.</td><td>The use of relevant diagrams is expected.</td></tr>
      <tr><td>3.1.6.5 The Influence of trade unions in determining wages and levels of employment<br><br>The various factors that affect the ability of trade unions to influence wages and levels of employment in different labour markets.<br>How wages and employment are likely to be affected by the introduction of a trade union into a previously perfectly competitive labour market and into a monopsony labour market.</td><td>The use of relevant diagrams is expected.</td></tr>
      <tr><td>3.1.6.6 The National Minimum Wage<br><br>The effects of a national minimum wage upon labour markets.<br>The advantages and disadvantages of a national minimum wage.</td><td></td></tr>
      <tr><td>3.1.6.7 Discrimination in the labour market<br><br>The conditions necessary for wage discrimination.<br>The impact of gender, ethnicity and other forms of discrimination on wages, levels and types of employment.</td><td>Real-world examples should be used to illustrate wage discrimination.<br><br>Students should be able to assess the advantages and disadvantages of wage discrimination for workers, employers and the economy as a whole.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.7 The distribution of income and wealth: poverty and inequality</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.7.1 The distribution of income and wealth<br><br>The difference between income and wealth.<br>The various factors which influence the distribution of income and wealth.<br>The difference between equality and equity in relation to the distribution of income and wealth.<br>The Lorenz curve and Gini coefficient.<br>The likely benefits and costs of more equal and more unequal distributions.</td><td>Some knowledge of the distribution of household income and wealth in the United Kingdom is expected.<br><br>Students should understand that the degree of inequality can be measured but that whether or not a given distribution of income is equitable (fair and just) involves a value judgement.<br><br>Students will be expected to interpret measures of inequality such as the Gini coefficient but they will not be expected to calculate the Gini coefficient.<br><br>Students should understand that excessive inequality is both a cause and consequence of market failure. They should also appreciate that value judgements will influence people's views of what constitutes an equitable distribution of income and wealth and that these views will influence policy prescriptions.</td></tr>
      <tr><td>3.1.7.2 The problem of poverty<br><br>The difference between relative and absolute poverty.<br>The causes and effects of poverty.</td><td></td></tr>
      <tr><td>3.1.7.3 Government policies to alleviate poverty and to influence the distribution of income and wealth<br><br>The policies which are available to influence the distribution of income and wealth and to alleviate poverty.<br>The economic consequences of such policies.</td><td>Students should be able to evaluate the various approaches to redistributing income and wealth and alleviating poverty, recognising the moral and political perspectives.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1.8 The market mechanism, market failure and government intervention in markets</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.1.8.1 How markets and prices allocate resources<br><br>The rationing, incentive and signalling functions of prices in allocating resources and coordinating the decisions of buyers and sellers in a market economy.<br>The advantages and disadvantages of the price mechanism and of extending its use into new areas of activity.</td><td>Students should understand how economic incentives influence what, how and for whom goods and services are produced.<br><br>Students should be able to assess the view that the price mechanism is an impersonal method of allocating resources.<br><br>They should also be able to assess the view that introducing the price mechanism and markets into some fields of human activity may be undesirable and is likely to affect the nature of the activity, eg introducing a market for blood changes the nature of the transaction and the incentives involved.</td></tr>
      <tr><td>3.1.8.2 The meaning of market failure<br><br>Market failure occurs whenever a market leads to a misallocation of resources.<br>The difference between complete market failure (resulting in a missing market) and partial market failure (where a market exists but contributes to resource misallocation).<br>How public goods, positive and negative externalities, merit and demerit goods, monopoly and other market imperfections, and inequalities in the distribution of income and wealth can lead to market failure.</td><td>Students should be able to provide examples to inform their discussion of each of these causes of market failure.</td></tr>
      <tr><td>3.1.8.3 Public goods, private goods and quasi-public goods<br><br>Pure public goods are non-rival and non-excludable and recognition of the significance of these characteristics.<br>The difference between a public good and a private good.<br>Circumstances when a public good may take on some of the characteristics of a private good and become a quasi-public good.<br>The significance of technological change, eg television broadcasting is now excludable.<br>The free-rider problem.<br>The tragedy of the commons.</td><td>Students should appreciate the relevance of the 'tragedy of the commons' for environmental market failures.</td></tr>
      <tr><td>3.1.8.4 Positive and negative externalities in consumption and production<br><br>Externalities exist when there is a divergence between private and social costs and benefits.<br>Why negative externalities are likely to result in over-production and that positive externalities are likely to result in under-production.<br>Why the absence of property rights leads to externalities in both production and consumption and hence market failure.</td><td>Students should be able to illustrate the misallocation of resources resulting from externalities in both production and consumption, using diagrams showing marginal private and social cost and benefit curves.</td></tr>
      <tr><td>3.1.8.5 Merit and demerit goods<br><br>The classification of merit and demerit goods depends upon a value judgement.<br>Such products may be subject to positive and negative externalities in consumption.<br>How under-provision of merit goods and over-provision of demerit goods may also result from imperfect information.</td><td>Students should be able to illustrate the misallocation of resources resulting from the consumption of merit and demerit goods using diagrams showing marginal private and social cost and benefit curves.<br><br>It should be understood that not all products that result in positive or negative externalities in consumption are either merit or demerit goods.</td></tr>
      <tr><td>3.1.8.6 Market imperfections<br><br>Why imperfect and asymmetric information can lead to market failure.<br>Why the existence of monopoly and monopoly power can lead to market failure.<br>Why the immobility of factors of production can lead to market failure.</td><td></td></tr>
      <tr><td>3.1.8.7 Competition policy<br><br>The general principles of UK competition policy and some awareness of EU competition policy.<br>The costs and benefits of such policies.</td><td>Examples of real-world applications of such policies should provide contexts in which students can evaluate the use of economic models to explore economic behaviour and further develop their appreciation of the behaviour of firms.<br><br>Detailed knowledge of UK and EU competition law is not required.</td></tr>
      <tr><td>3.1.8.8 Public ownership, privatisation, regulation and deregulation of markets<br><br>The arguments for and against the public ownership of firms and industries.<br>The arguments for and against the privatisation of state-owned enterprises.<br>The arguments for and against the regulation of markets.<br>The arguments for and against the deregulation of markets.<br>The problem of regulatory capture.</td><td>Students should be able to assess the application of such policies in the United Kingdom and be able to evaluate their effects on economic performance.</td></tr>
      <tr><td>3.1.8.9 Government intervention in markets<br><br>The existence of market failure, in its various forms, provides an argument for government intervention in markets.<br>Governments influence the allocation of resources in a variety of ways, including through public expenditure, taxation and regulation.<br>Governments have a range of objectives and these affect how they intervene in a mixed economy to influence the allocation of resources.<br>The use of indirect taxation, subsidies, price controls, state provision and regulation, the extension of property rights and pollution permits to correct market failure.</td><td>Students should be able to apply economic models to assess the role of markets and the government in a variety of situations.<br><br>Students should be able to explain, analyse and evaluate the strengths and weaknesses of the market economy and the role of government within it.<br><br>Students should be able to evaluate the case for and against government intervention in particular markets and to assess the relative merits of different methods of intervention.</td></tr>
      <tr><td>3.1.8.10 Government failure<br><br>Government failure occurs when government intervention in the economy leads to a misallocation of resources.<br>Inadequate information, conflicting objectives and administrative costs are possible sources of government failure.<br>Governments may create, rather than remove, market distortions.<br>Government intervention can lead to unintended consequences.</td><td>Students should appreciate that the possibility of government failure means that, even when there is market failure, government intervention will not necessarily improve economic welfare.</td></tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">3.2 The national and international economy</h3>
    <p class="mb-3">This section of the specification is primarily about macroeconomics. However, students should understand that microeconomic principles underpin the behaviour of the macroeconomy. Understanding some aspects of macroeconomic behaviour requires that students have a firm grasp of related microeconomic principles, for example, understanding of price elasticity of demand is essential when analysing the impact of changes in the exchange rate on an economy.<br><br>Students should have a good knowledge of developments in the UK economy and government policies over the past fifteen years. They should also be aware of developments in the world economy, including the European Union, and how these have affected the UK. They are not required to have specific knowledge of economic developments in any individual country, other than the UK, but if this is needed, relevant data will be presented to students.<br><br>Students should recognise that there are a number of models demonstrating how the macroeconomy works and should appreciate that different economic models provide insights into different aspects of the behaviour of the macroeconomy. When using these models students should be critically aware of the assumptions upon which they are based and their limitations when they are used to make sense of real world phenomena. Furthermore, they should be prepared to propose, analyse and evaluate possible solutions to macroeconomic problems. They will be required to assess the impact and effectiveness of current government policies to deal with these problems, as well as considering alternative policies and approaches.</p>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2.1 The measurement of macroeconomic performance</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.2.1.1 The objectives of government economic policy<br><br>The main objectives of government macroeconomic policy: economic growth, price stability, minimising unemployment and a stable balance of payments on current account.<br>The possibility of conflict arising, at least in the short run, when attempting to achieve these objectives.</td><td>Students should be aware that governments may also have other objectives of macroeconomic policy, such as balancing the budget and achieving an equitable distribution of income.<br><br>They should be aware that the importance attached to the different objectives changes over time.</td></tr>
      <tr><td>3.2.1.2 Macroeconomic indicators<br><br>Data which is commonly used to measure the performance of an economy, such as: real GDP, real GDP per capita, Consumer Prices and Retail Prices Indices (CPI/RPI), measures of unemployment, productivity and the balance of payments on current account.</td><td></td></tr>
      <tr><td>3.2.1.3 Uses of index numbers<br><br>How index numbers are calculated and interpreted, including the base year and the use of weights.<br>How index numbers are used to measure changes in the price level and changes in other economic variables.</td><td>A detailed technical knowledge is not expected of indices such as the Retail Prices Index (RPI) and Consumer Prices Index (CPI), but students should have an awareness of their underlying features, for example, the concept of the 'average family' and a 'basket of goods and services'.</td></tr>
      <tr><td>3.2.1.4 Uses of national income data<br><br>The use and limitations of national income data to assess changes in living standards over time.<br>The use and limitations of national income data to compare differences in living standards between countries.<br>The importance of using purchasing power parity (PPP) exchange rates when making international comparisons of living standards.</td><td></td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2.2 How the macroeconomy works: the circular flow of income, aggregate demand/aggregate supply analysis and related concepts</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.2.2.1 The circular flow of income<br><br>What national income measures.<br>The difference between nominal and real income.<br>Real national income as an indicator of economic performance.<br>The circular flow of income concept, the equation income = output = expenditure, and of the concepts of equilibrium and full employment income.<br>The difference between injections and withdrawals into the circular flow of income.<br>The effect of changes in injections and withdrawals on national income.</td><td>Students are not expected to have a detailed knowledge of the construction of national income accounts.</td></tr>
      <tr><td>3.2.2.2 Aggregate demand and aggregate supply analysis<br><br>Changes in the price level are represented by movements along the aggregate demand (AD) and aggregate supply (AS) curves.<br>The various factors that shift the AD curve and the short-run AS curve.<br>The factors which affect long-run AS and distinguish them from those which affect short-run AS.<br>Underlying economic growth is represented by a rightward shift in the long-run AS curve.<br>How to use AD/AS diagrams to illustrate macroeconomic equilibrium.<br>How both demand-side and supply-side shocks affect the macroeconomy</td><td>Students should be able to use AD and AS analysis to help them explain macroeconomic problems and issues. For example, they should be able to use AD and AS diagrams to illustrate changes in the price level, demand-deficient (cyclical) unemployment and economic growth.<br><br>Students should also understand how global economic events can affect the domestic economy.</td></tr>
      <tr><td>3.2.2.3 The determinants of aggregate demand<br><br>What is meant by AD.<br>The determinants of AD, ie the determinants of consumption, investment, government spending, exports and imports.<br>The basic accelerator process.<br>The determinants of savings.<br>The difference between saving and investment.</td><td>Students will not be required to undertake calculations to illustrate the operation of the accelerator.<br><br>Students should understand how changes in net exports affect aggregate demand and economic performance.</td></tr>
      <tr><td>3.2.2.4 Aggregate demand and the level of economic activity<br><br>The role of AD in influencing the level of economic activity.<br>The multiplier process and an explanation of why an initial change in expenditure may lead to a larger impact on local or national income.<br>The concept of the marginal propensity to consume and use the marginal propensity to consume to calculate the size of the multiplier.<br>Why the size of the marginal propensity to consume determines the magnitude of the multiplier effect.</td><td>Students will only be required to calculate the multiplier from the marginal propensity to consume.<br><br>Calculations from the marginal propensities to withdraw will not be expected.</td></tr>
      <tr><td>3.2.2.5 Determinants of short-run aggregate supply<br><br>The price level and production costs are the main determinants of the short-run AS.<br>Changes in costs, such as: money wage rates, raw material prices, business taxation and productivity, will shift the short-run AS curve.</td><td></td></tr>
      <tr><td>3.2.2.6 Determinants of long-run aggregate supply<br><br>The fundamental determinants of long-run AS such as technology, productivity, attitudes, enterprise, factor mobility, and economic incentives.<br>The position of the vertical long-run AS curve represents the normal capacity level of output of the economy.<br>The importance of the institutional structure of the economy in determining aggregate supply, such as the role of the banking system in providing business investment funds, should also be understood.<br>The Keynesian AS curve.</td><td></td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2.3 Economic performance</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.2.3.1 Economic growth and the economic cycle<br><br>The difference between short-run and long-run growth.<br>The various demand-side and supply-side determinants of short-run growth of real national income and the long-run trend rate of economic growth.<br>The costs and benefits of economic growth.<br>The impact of growth on individuals, the economy and the environment.<br>The concept of the economic cycle and the use of a range of economic indicators, such as real GDP, the rate of inflation, unemployment and investment, to identify the various phases of the economic cycle.<br>The difference between positive and negative output gaps.<br>The causes of changes in the various phases of the economic cycle, including both global and domestic demand-side and supply-side shocks.</td><td>Students should be able to use a production possibility curve and AD/AS diagrams to illustrate the distinction between short-run and long-run economic growth.<br><br>Students should understand that long-run economic growth occurs when the productive capacity of the economy is increasing and is a term used to refer to the trend rate of growth of real national output in an economy over time.<br><br>Students should be able to discuss the sustainability of economic growth.<br><br>Students should understand that a positive output gap occurs when real GDP is above the productive potential of the economy, and a negative output gap occurs when real GDP is below the economy's productive potential.<br><br>Students should be able to discuss causes of cyclical instability such as: excessive growth in credit and levels of debt, asset price bubbles, destabilising speculation and animal spirits or herding.</td></tr>
      <tr><td>3.2.3.2 Employment and unemployment<br><br>The main UK measures of unemployment, ie the claimant count and the Labour Force Survey measure.<br>The concepts of voluntary and involuntary unemployment.<br>The terms seasonal, frictional, structural and cyclical unemployment.<br>How employment and unemployment may be determined by both demand-side and supply-side factors.<br>The concept of, and the factors which determine, real wage unemployment.<br>The concept of, and the factors which determine, the natural rate of unemployment.<br>The consequences of unemployment for individuals and for the performance of the economy.</td><td>Students should appreciate that unemployment has a variety of causes and hence the appropriate policies to reduce unemployment depend on the cause.<br><br>They should understand that a negative output gap is linked to cyclical unemployment and that supply-side causes of unemployment affect the position of the long-run aggregate supply curve.</td></tr>
      <tr><td>3.2.3.3 Inflation and deflation<br><br>The concepts of inflation, deflation and disinflation.<br>Demand-pull and cost-push influences on the price level.<br>Fisher's equation of exchange MV = PQ and the Quantity Theory of Money in relation to the monetarist model.<br>The effects of expectations on changes in the price level<br>The consequences of inflation for both individuals and the performance of the economy.<br>The consequences of deflation for both individuals and the performance of the economy.<br>How changes in world commodity prices affect domestic inflation.<br>How changes in other economies can affect inflation in the UK.</td><td>Students should understand that deflation exists when the price level is falling, whereas disinflation is when the rate of inflation is falling.<br><br>Students should appreciate that deflationary policies are policies to reduce aggregate demand and do not necessarily result in deflation.<br><br>Students can use T instead of Q in the Fisher equation but using Q means that PQ is nominal national income and overcomes the difficulties associated with the inclusion of intermediate transactions.</td></tr>
      <tr><td>3.2.3.4 Possible conflicts between macroeconomic policy objectives<br><br>How negative and positive output gaps relate to unemployment and inflationary pressures.<br>Both the short-run Phillips curve and the long-run, L-shaped Phillips curve.<br>The implications of the short-run Phillips curve and the long-run, L-shaped Phillips curve for economic policy.<br>How economic policies may be used to try to reconcile possible policy conflicts both in the short run and the long run.</td><td>Students should be able to use macroeconomic models, including the AD/AS model, to analyse the causes of possible conflicts between policy objectives in the short run and long run. They should be able to discuss approaches to reconciling these conflicts and the monetarist/supply-side view that the major macroeconomic objectives are compatible in the long run.<br><br>The L-shaped Phillips curve is also known as the vertical long-run Phillips curve.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2.4 Financial markets and monetary policy</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.2.4.1 The structure of financial markets and financial assets<br><br>The characteristics and functions of money.<br>Definitions of the money supply and the distinction between narrow money and broad money.<br>The difference between the money market, the capital market and the foreign exchange market.<br>The role of financial markets in the wider economy.<br>The difference between debt and equity.<br>Why there is an inverse relationship between market interest rates and bond prices.</td><td>Students should know that ways in which firms raise finance include: issuing shares, issuing corporate bonds and borrowing from a bank.<br><br>Students should know the terms coupon and maturity in relation to government bonds and be able to calculate the yield on a government bond.</td></tr>
      <tr><td>3.2.4.2 Commercial banks and investment banks<br><br>The difference between a commercial bank and an investment bank.<br>The main functions of a commercial bank.<br>The structure of a commercial bank's balance sheet.<br>The objectives of a commercial bank, ie liquidity, profitability and security.<br>Potential conflicts between these objectives.<br>How banks create credit.</td><td>Students should be aware of the differences between a commercial bank and an investment bank but they do not need a detailed knowledge of the activities and functions of an investment bank. They should also be aware that many banks are engaged in both investment banking and commercial banking activities and that this may increase systemic risk.<br><br>Students should be aware that there are other institutions that operate in financial markets but they do not need to know about their activities or their functions.<br><br>Students will not be required to calculate the credit multiplier.</td></tr>
      <tr><td>3.2.4.3 Central banks and monetary policy<br><br>The main functions of a central bank.<br>That monetary policy involves the central bank taking action to influence interest rates, the supply of money and credit and the exchange rate.<br>The current objectives of monetary policy set by the government.<br>The role of the Monetary Policy Committee of the Bank of England (MPC) and how it uses changes in bank rate to try to achieve the objectives for monetary policy, including the government's target rate of inflation.<br>The factors considered by the MPC when setting the bank rate.<br>How changes in the exchange rate affect aggregate demand and the various macroeconomic policy objectives.<br>The monetary policy transmission mechanism, including the relationship between changes in interest rates and the exchange rate.<br>How the Bank of England can influence the growth of the money supply.</td><td>Students should understand current and recent instruments of monetary policy such as: quantitative easing, Funding for Lending and forward guidance.<br><br>Students should understand how the MPC of the Bank of England uses changes in bank rate to try to achieve the objectives for monetary policy, including the government's target rate of inflation.</td></tr>
      <tr><td>3.2.4.4 The regulation of the financial system<br><br>Regulation of the financial system in the UK, eg the role of the Bank of England, the Prudential Regulation Authority (PRA), the Financial Policy Committee (FPC) and the Financial Conduct Authority (FCA).<br>Why a bank might fail, including the risks involved in lending long term and borrowing short term.<br>Liquidity ratios and capital ratios and how they affect the stability of a financial institution.<br>Moral hazard.<br>Systemic risk and the impact of problems that arise in financial markets upon the real economy.</td><td>An in-depth knowledge of the PRA, FPC and the FCA is not expected but students should appreciate their role in trying to maintain the stability of the financial system.<br><br>Students will not be required to calculate liquidity or capital ratios.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2.5 Fiscal policy and supply-side policies</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.2.5.1 Fiscal policy<br><br>Fiscal policy involves the manipulation of government spending, taxation and the budget balance.<br>Fiscal policy can have both macroeconomic and microeconomic functions.<br>How fiscal policy can be used to influence aggregate demand.<br>How fiscal policy can be used to influence aggregate supply.<br>How government spending and taxation can affect the pattern of economic activity.<br>The types of and reasons for public expenditure.<br>Why governments levy taxes.<br>The difference between direct and indirect taxes.<br>The difference between progressive, proportional and regressive taxes.<br>The principles of taxation, such as that taxes should be equitable.<br>The role and relative merits of different UK taxes.<br>The relationship between the budget balance and the national debt.<br>Cyclical and structural budget deficits and surpluses.<br>The consequences of budget deficits and surpluses for macroeconomic performance.<br>The significance of the size of the national debt.<br>The role of the Office for Budget Responsibility.</td><td>Students should be able to assess the economic significance of changes in the level and distribution of both public expenditure and taxation.<br><br>They should be able to discuss the issue of the budget balance and be able to evaluate the possible economic consequences of a government running a budget deficit or budget surplus.<br><br>They should be able to assess the impact of measures used to rebalance the budget.</td></tr>
      <tr><td>3.2.5.2 Supply-side policies<br><br>The difference between supply-side policies and supply-side improvements in the economy.<br>How supply-side policies can help to achieve supply-side improvements in the economy.<br>How supply-side policies, such as tax changes designed to change personal incentives, may increase the potential output of the economy and improve the underlying trend rate of economic growth.<br>How supply-side policies can affect unemployment, the rate of change of prices and UK external performance, as reflected in the balance of payments on current account.<br>The role of supply-side policies in reducing the natural rate of unemployment.<br>Free market supply-side policies include measures such as: tax cuts, privatisation, deregulation and some labour market reforms.<br>Interventionist supply-side policies include measures such as: government spending on education and training, industrial policy, subsidising spending on research and development.<br>Supply-side policies can have microeconomic as well as macroeconomic effects.</td><td>Students should recognise that supply-side changes in the economy often originate in the private sector, independently of government, eg through productivity improvements, innovation and investment.<br><br>Students should recognise that supply-side policies can involve government intervention to deal with market failures such as short-termism, as well as policies to improve economic incentives and the operation of markets.</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2.6 The international economy</h4>
    <table>
      <tr><th>Content</th><th>Additional information</th></tr>
      <tr><td>3.2.6.1 Globalisation<br><br>The causes of globalisation.<br>The main characteristics of globalisation.<br>The consequences of globalisation for less-developed and for more-developed countries.<br>The role of multinational corporations in globalisation.</td><td></td></tr>
      <tr><td>3.2.6.2 Trade<br><br>The model of comparative advantage.<br>The distinction between comparative and absolute advantage.<br>The model shows that specialisation and trade can increase total output.<br>Other economic benefits of trade, such as the ability to exploit economies of scale and increased competition.<br>The costs of international trade.<br>The reasons for changes in the pattern of trade between the UK and the rest of the world.<br>The nature of protectionist policies, such as: tariffs, quotas and export subsidies.<br>The causes and consequences of countries adopting protectionist policies.<br>The main features of a customs union.<br>The main characteristics of the Single European Market (SEM).<br>The role of the World Trade Organisation (WTO).</td><td>Students should be able to use a simple numerical example to illustrate the principle of comparative advantage and the associated benefits of trade.<br><br>Students should be able to use a diagram to illustrate the effects of imposing a tariff on imports.</td></tr>
      <tr><td>3.2.6.3 The balance of payments<br><br>The difference between the current, capital and financial accounts on the balance of payments.<br>The current account comprises trade in goods, trade in services, primary income and secondary income.<br>The meaning of a deficit and a surplus on the current account.<br>The factors that influence a country's current account balance such as productivity, inflation and the exchange rate.<br>The consequences of investment flows between countries.<br>The policies that might be used to correct a balance of payments deficit or surplus.<br>Expenditure-switching and expenditure-reducing policies.<br>The effect policies used to correct a deficit or surplus may have upon other macroeconomic policy objectives.<br>The significance of deficits and surpluses for an individual economy.<br>The implications for the global economy of a major economy or economies with imbalances deciding to take corrective action.</td><td>Students should have a detailed knowledge of the structure of the current account of the balance of payments but only need a general appreciation of the other sections of the balance of payments account.<br><br>Students should appreciate the difference between foreign direct investment (FDI) and portfolio investment.</td></tr>
      <tr><td>3.2.6.4 Exchange rate systems<br><br>How exchange rates are determined in freely floating exchange rate systems.<br>How governments can intervene to influence the exchange rate.<br>The advantages and disadvantages of fixed and floating exchange rate systems.<br>Advantages and disadvantages for a country of joining a currency union, eg the eurozone.</td><td></td></tr>
      <tr><td>3.2.6.5 Economic growth and development<br><br>The difference between growth and development.<br>The main characteristics of less-developed economies.<br>The main indicators of development, including the Human Development Index (HDI).<br>Factors that affect growth and development, such as: investment, education and training.<br>Barriers to growth and development, such as: corruption, institutional factors, poor infrastructure, inadequate human capital, lack of property rights.<br>Policies that might be adopted to promote economic growth and development.<br>The role of aid and trade in promoting growth and development.</td><td>Students should appreciate the links between this and other parts of the specification, such as: globalisation, trade, the determinants of economic growth and inequality.<br><br>Students should be able to compare market-based strategies and interventionist strategies for promoting growth and development.</td></tr>
    </table>

    <!-- ============================================================ -->
    <!-- EDEXCEL -->
    <!-- ============================================================ -->
    <h2 id="edexcel" class="text-xl bg-pink-300 p-1 font-mono mb-2">Edexcel (Pearson Economics A, 9EC0)</h2>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Theme 1: Introduction to markets and market failure</h3>
    <h4 class="font-mono bg-sky-100 p-1 mb-1">1.1 Nature of economics</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>1.1.1 Economics as a social science</td><td>a) Thinking like an economist: the process of developing models in economics, including the need to make assumptions<br>b) The use of the ceteris paribus assumption in building models<br>c) The inability in economics to make scientific experiments</td></tr>
      <tr><td>1.1.2 Positive and normative economic statements</td><td>a) Distinction between positive and normative economic statements<br>b) The role of value judgements in influencing economic decision making and policy</td></tr>
      <tr><td>1.1.3 The economic problem</td><td>a) The problem of scarcity – where there are unlimited wants and finite resources<br>b) The distinction between renewable and non-renewable resources<br>c) The importance of opportunity costs to economic agents (consumers, producers and government)</td></tr>
      <tr><td>1.1.4 Production possibility frontiers</td><td>a) The use of production possibility frontiers to depict: the maximum productive potential of an economy; opportunity cost (through marginal analysis); economic growth or decline; efficient or inefficient allocation of resources; possible and unobtainable production<br>b) The distinction between movements along and shifts in production possibility curves, considering the possible causes for such changes<br>c) The distinction between capital and consumer goods</td></tr>
      <tr><td>1.1.5 Specialisation and the division of labour</td><td>a) Specialisation and the division of labour: reference to Adam Smith<br>b) The advantages and disadvantages of specialisation and the division of labour in organising production<br>c) The advantages and disadvantages of specialising in the production of goods and services to trade<br>d) The functions of money (as a medium of exchange, a measure of value, a store of value, a method of deferred payment)</td></tr>
      <tr><td>1.1.6 Free market economies, mixed economy and command economy</td><td>a) The distinction between free market, mixed and command economies: reference to Adam Smith, Friedrich Hayek and Karl Marx<br>b) The advantages and disadvantages of a free market economy and a command economy<br>c) The role of the state in a mixed economy</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">1.2 How markets work</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>1.2.1 Rational decision making</td><td>a) The underlying assumptions of rational economic decision making: consumers aim to maximise utility; firms aim to maximise profits</td></tr>
      <tr><td>1.2.2 Demand</td><td>a) The distinction between movements along a demand curve and shifts of a demand curve<br>b) The factors that may cause a shift in the demand curve (the conditions of demand)<br>c) The concept of diminishing marginal utility and how this influences the shape of the demand curve</td></tr>
      <tr><td>1.2.3 Price, income and cross elasticities of demand</td><td>a) Understanding of price, income and cross elasticities of demand<br>b) Use formulae to calculate price, income and cross elasticities of demand<br>c) Interpret numerical values of: price elasticity of demand (unitary elastic, perfectly and relatively elastic, and perfectly and relatively inelastic); income elasticity of demand (inferior, normal and luxury goods; relatively elastic and relatively inelastic); cross elasticity of demand (substitutes, complementary and unrelated goods)<br>d) The factors influencing elasticities of demand<br>e) The significance of elasticities of demand to firms and government in terms of: the imposition of indirect taxes and subsidies; changes in real income; changes in the prices of substitute and complementary goods<br>f) The relationship between price elasticity of demand and total revenue (including calculation)</td></tr>
      <tr><td>1.2.4 Supply</td><td>a) The distinction between movements along a supply curve and shifts of a supply curve<br>b) The factors that may cause a shift in the supply curve (the conditions of supply)</td></tr>
      <tr><td>1.2.5 Elasticity of supply</td><td>a) Understanding of price elasticity of supply<br>b) Use formula to calculate price elasticity of supply<br>c) Interpret numerical values of price elasticity of supply: perfectly and relatively elastic, and perfectly and relatively inelastic<br>d) Factors that influence price elasticity of supply<br>e) The distinction between short run and long run in economics and its significance for elasticity of supply</td></tr>
      <tr><td>1.2.6 Price determination</td><td>a) Equilibrium price and quantity and how they are determined<br>b) The use of supply and demand diagrams to depict excess supply and excess demand<br>c) The operation of market forces to eliminate excess demand and excess supply<br>d) The use of supply and demand diagrams to show how shifts in demand and supply curves cause the equilibrium price and quantity to change in real-world situations</td></tr>
      <tr><td>1.2.7 Price mechanism</td><td>a) Functions of the price mechanism to allocate resources: rationing; incentive; signalling<br>b) The price mechanism in the context of different types of markets, including local, national and global markets</td></tr>
      <tr><td>1.2.8 Consumer and producer surplus</td><td>a) The distinction between consumer and producer surplus<br>b) The use of supply and demand diagrams to illustrate consumer and producer surplus<br>c) How changes in supply and demand might affect consumer and producer surplus</td></tr>
      <tr><td>1.2.9 Indirect taxes and subsidies</td><td>a) Supply and demand analysis, elasticities, and: the impact of indirect taxes on consumers, producers and government; the incidence of indirect taxes on consumers and producers; the impact of subsidies on consumers, producers and government; the area that represents the producer subsidy and consumer subsidy</td></tr>
      <tr><td>1.2.10 Alternative views of consumer behaviour</td><td>a) The reasons why consumers may not behave rationally: consideration of the influence of other people's behaviour; the importance of habitual behaviour; consumer weakness at computation</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">1.3 Market failure</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>1.3.1 Types of market failure</td><td>a) Understanding of market failure<br>b) Types of market failure: externalities; under-provision of public goods; information gaps</td></tr>
      <tr><td>1.3.2 Externalities</td><td>a) Distinction between private costs, external costs and social costs<br>b) Distinction between private benefits, external benefits and social benefits<br>c) Use of a diagram to illustrate: the external costs of production using marginal analysis; the distinction between market equilibrium and social optimum position; identification of welfare loss area<br>d) Use of a diagram to illustrate: the external benefits of consumption using marginal analysis; the distinction between market equilibrium and social optimum position; identification of welfare gain area<br>e) The impact on economic agents of externalities and government intervention in various markets</td></tr>
      <tr><td>1.3.3 Public goods</td><td>a) Distinction between public and private goods using the concepts of non-rivalry and non-excludability<br>b) Why public goods may not be provided by the private sector: the free rider problem</td></tr>
      <tr><td>1.3.4 Information gaps</td><td>a) The distinction between symmetric and asymmetric information<br>b) How imperfect market information may lead to a misallocation of resources</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">1.4 Government intervention</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>1.4.1 Government intervention in markets</td><td>a) Purpose of intervention with reference to market failure and using diagrams in various contexts: indirect taxation (ad valorem and specific); subsidies; maximum and minimum prices<br>b) Other methods of government intervention: trade pollution permits; state provision of public goods; provision of information; regulation</td></tr>
      <tr><td>1.4.2 Government failure</td><td>a) Understanding of government failure as intervention that results in a net welfare loss<br>b) Causes of government failure: distortion of price signals; unintended consequences; excessive administrative costs; information gaps<br>c) Government failure in various markets</td></tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Theme 2: The UK economy — performance and policies</h3>
    <h4 class="font-mono bg-sky-100 p-1 mb-1">2.1 Measures of economic performance</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>2.1.1 Economic growth</td><td>a) Rates of change of real Gross Domestic Product (GDP) as a measure of economic growth<br>b) Distinction between: real and nominal; total and per capita; value and volume<br>c) Other national income measures: Gross National Income (GNI)<br>d) Comparison of rates of growth between countries and over time<br>e) Understanding of Purchasing Power Parities (PPPs) and the use of PPP-adjusted figures in international comparisons<br>f) The limitations of using GDP to compare living standards between countries and over time<br>g) National happiness: UK national wellbeing; the relationship between real incomes and subjective happiness</td></tr>
      <tr><td>2.1.2 Inflation</td><td>a) Understanding of: inflation; deflation; disinflation<br>b) The process of calculating the rate of inflation in the UK using the Consumer Prices Index (CPI)<br>c) The limitations of CPI in measuring the rate of inflation<br>d) The Retail Prices Index (RPI) as an alternative measure of the rate of inflation<br>e) Causes of inflation: demand pull; cost push; growth of the money supply<br>f) The effects of inflation on consumers, firms, the government and workers</td></tr>
      <tr><td>2.1.3 Employment and unemployment</td><td>a) Measures of unemployment: the claimant count; the International Labour Organisation (ILO) and the UK Labour Force Survey<br>b) The distinction between unemployment and under-employment<br>c) The significance of changes in the rates of: employment; unemployment; inactivity<br>d) The causes of unemployment: structural unemployment; frictional unemployment; seasonal unemployment; demand deficiency and cyclical unemployment; real wage inflexibility<br>e) The significance of migration and skills for employment and unemployment<br>f) The effects of unemployment on consumers, firms, workers, the government and society</td></tr>
      <tr><td>2.1.4 Balance of payments</td><td>a) Components of the balance of payments, with particular reference to the current account, and the balance of trade in goods and services<br>b) Current account deficits and surpluses<br>c) The relationship between current account imbalances and other macroeconomic objectives<br>d) The interconnectedness of economies through international trade</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2.2 Aggregate demand (AD)</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>2.2.1 The characteristics of AD</td><td>a) Components of AD: C+I+G+(X-M)<br>b) The relative importance of the components of AD<br>c) The AD curve<br>d) The distinction between a movement along, and a shift of, the AD curve</td></tr>
      <tr><td>2.2.2 Consumption (C)</td><td>a) Disposable income and its influence on consumer spending<br>b) An understanding of the relationship between savings and consumption<br>c) Other influences on consumer spending: interest rates; consumer confidence; wealth effects</td></tr>
      <tr><td>2.2.3 Investment (I)</td><td>a) Distinction between gross and net investment<br>b) Influences on investment: the rate of economic growth; business expectations and confidence; Keynes and 'animal spirits'; demand for exports; interest rates; access to credit; the influence of government and regulations</td></tr>
      <tr><td>2.2.4 Government expenditure (G)</td><td>a) The main influences on government expenditure: the trade cycle; fiscal policy</td></tr>
      <tr><td>2.2.5 Net trade (X-M)</td><td>a) The main influences on the (net) trade balance: real income; exchange rates; state of the world economy; degree of protectionism; non-price factors</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2.3 Aggregate supply (AS)</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>2.3.1 The characteristics of AS</td><td>a) The AS curve<br>b) The distinction between movement along, and a shift of, the AS curve<br>c) The relationship between short-run AS and long-run AS</td></tr>
      <tr><td>2.3.2 Short-run AS</td><td>a) Factors influencing short-run AS: changes in costs of raw materials and energy; changes in exchange rates; changes in tax rates</td></tr>
      <tr><td>2.3.3 Long-run AS</td><td>a) Different shapes of the long-run AS curve: Keynesian; classical<br>b) Factors influencing long-run AS: technological advances; changes in relative productivity; changes in education and skills; changes in government regulations; demographic changes and migration; competition policy</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2.4 National income</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>2.4.1 National income</td><td>a) The circular flow of income<br>b) The distinction between income and wealth</td></tr>
      <tr><td>2.4.2 Injections and withdrawals</td><td>a) The impact of injections into, and withdrawals from, the circular flow of income</td></tr>
      <tr><td>2.4.3 Equilibrium levels of real national output</td><td>a) The concept of equilibrium real national output<br>b) The use of AD/AS diagrams to show how shifts in AD or AS cause changes in the equilibrium price level and real national output</td></tr>
      <tr><td>2.4.4 The multiplier</td><td>a) The multiplier ratio<br>b) The multiplier process<br>c) Effects of the multiplier on the economy<br>d) Understanding of marginal propensities and their effects on the multiplier: the marginal propensity to consume (MPC); the marginal propensity to save (MPS); the marginal propensity to tax (MPT); the marginal propensity to import (MPM)<br>e) Calculations of the multiplier using the formulae 1/(1-MPC) and 1/MPW, where MPW=MPS+MPT+MPM<br>f) The significance of the multiplier for shifts in AD</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2.5 Economic growth</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>2.5.1 Causes of growth</td><td>a) Factors which could cause economic growth<br>b) The distinction between actual and potential growth<br>c) The importance of international trade for (export-led) economic growth</td></tr>
      <tr><td>2.5.2 Output gaps</td><td>a) Distinction between actual growth rates and long-term trends in growth rates<br>b) Understanding of positive and negative output gaps and the difficulties of measurement<br>c) Use of an AD/AS diagram to illustrate an output gap (level of spare capacity) in an economy</td></tr>
      <tr><td>2.5.3 Trade (business) cycle</td><td>a) Understanding of the trade (business) cycle<br>b) Characteristics of a boom<br>c) Characteristics of a recession</td></tr>
      <tr><td>2.5.4 The impact of economic growth</td><td>a) The benefits and costs of economic growth and the impact on: consumers; firms; the government; current and future living standards</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2.6 Macroeconomic objectives and policies</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>2.6.1 Possible macroeconomic objectives</td><td>a) Economic growth<br>b) Low unemployment<br>c) Low and stable rate of inflation<br>d) Balance of payments equilibrium on current account<br>e) Balanced government budget<br>f) Protection of the environment<br>g) Greater income equality</td></tr>
      <tr><td>2.6.2 Demand-side policies</td><td>a) Distinction between monetary and fiscal policy<br>b) Monetary policy instruments: interest rates; asset purchases to increase the money supply (quantitative easing)<br>c) Fiscal policy instruments: government spending and taxation<br>d) Distinction between government budget (fiscal) deficit and surplus<br>e) Distinction between, and examples of, direct and indirect taxation<br>f) Use of AD/AS diagrams to illustrate demand-side policies<br>g) The role of the Bank of England: the role and operation of the Bank of England's Monetary Policy Committee<br>h) Awareness of demand-side policies in the Great Depression and the Global Financial Crisis of 2008: different interpretations; policy responses in the US and UK<br>i) Strengths and weaknesses of demand-side policies</td></tr>
      <tr><td>2.6.3 Supply-side policies</td><td>a) Distinction between market-based and interventionist methods<br>b) Market-based and interventionist policies: to increase incentives; to promote competition; to reform the labour market; to improve skills and quality of the labour force; to improve infrastructure<br>c) Use of AD/AS diagrams to illustrate supply-side policies<br>d) Strengths and weaknesses of supply-side policies</td></tr>
      <tr><td>2.6.4 Conflicts and trade-offs between objectives and policies</td><td>a) Potential conflicts and trade-offs between the macroeconomic objectives<br>b) Short-run Phillips curve<br>c) Potential policy conflicts and trade-offs</td></tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Theme 3: Business behaviour and the labour market</h3>
    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.1 Business growth</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>3.1.1 Sizes and types of firms</td><td>a) Reasons why some firms tend to remain small and why others grow<br>b) Significance of the divorce of ownership from control: the principal-agent problem<br>c) Distinction between public and private sector organisations<br>d) Distinction between profit and not-for-profit organisations</td></tr>
      <tr><td>3.1.2 Business growth</td><td>a) How businesses grow: organic growth; forward and backward vertical integration; horizontal integration; conglomerate integration<br>b) Advantages and disadvantages of: organic growth; vertical integration; horizontal integration; conglomerate integration<br>c) Constraints on business growth: size of the market; access to finance; owner objectives; regulation</td></tr>
      <tr><td>3.1.3 Demergers</td><td>a) Reasons for demergers<br>b) Impact of demergers on businesses, workers and consumers</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.2 Business objectives</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>3.2.1 Business objectives</td><td>a) Different business objectives and reasons for them: profit maximisation; revenue maximisation; sales maximisation; satisficing<br>b) Diagrams and formulae to illustrate the different business objectives: profit maximisation; revenue maximisation; sales maximisation</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.3 Revenues, costs and profits</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>3.3.1 Revenue</td><td>a) Formulae to calculate and understand the relationship between: total revenue; average revenue; marginal revenue<br>b) Price elasticity of demand and its relationship to revenue concepts (calculation required)</td></tr>
      <tr><td>3.3.2 Costs</td><td>a) Formulae to calculate and understand the relationship between: total cost; total fixed cost; total variable cost; average (total) cost; average fixed cost; average variable cost; marginal cost<br>b) Derivation of short-run cost curves from the assumption of diminishing marginal productivity<br>c) Relationship between short-run and long-run average cost curves</td></tr>
      <tr><td>3.3.3 Economies and diseconomies of scale</td><td>a) Types of economies and diseconomies of scale<br>b) Minimum efficient scale<br>c) Distinction between internal and external economies of scale</td></tr>
      <tr><td>3.3.4 Normal profits, supernormal profits and losses</td><td>a) Condition for profit maximisation<br>b) Normal profit, supernormal profit and losses<br>c) Short-run and long-run shut-down points: diagrammatic analysis</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.4 Market structures</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>3.4.1 Efficiency</td><td>a) Allocative efficiency<br>b) Productive efficiency<br>c) Dynamic efficiency<br>d) X-inefficiency<br>e) Efficiency/inefficiency in different market structures</td></tr>
      <tr><td>3.4.2 Perfect competition</td><td>a) Characteristics of perfect competition<br>b) Profit maximising equilibrium in the short run and long run<br>c) Diagrammatic analysis</td></tr>
      <tr><td>3.4.3 Monopolistic competition</td><td>a) Characteristics of monopolistically competitive markets<br>b) Profit maximising equilibrium in the short run and long run<br>c) Diagrammatic analysis</td></tr>
      <tr><td>3.4.4 Oligopoly</td><td>a) Characteristics of oligopoly: high barriers to entry and exit; high concentration ratio; interdependence of firms; product differentiation<br>b) Calculation of n-firm concentration ratios and their significance<br>c) Reasons for collusive and non-collusive behaviour<br>d) Overt and tacit collusion; cartels and price leadership<br>e) Simple game theory: the prisoner's dilemma in a simple two firm/two outcome model<br>f) Types of price competition: price wars; predatory pricing; limit pricing<br>g) Types of non-price competition</td></tr>
      <tr><td>3.4.5 Monopoly</td><td>a) Characteristics of monopoly<br>b) Profit maximising equilibrium<br>c) Diagrammatic analysis<br>d) Third degree price discrimination: necessary conditions; diagrammatic analysis; costs and benefits to consumers and producers<br>e) Costs and benefits of monopoly to firms, consumers, employees and suppliers<br>f) Natural monopoly</td></tr>
      <tr><td>3.4.6 Monopsony</td><td>a) Characteristics and conditions for a monopsony to operate<br>b) Costs and benefits of a monopsony to firms, consumers, employees and suppliers</td></tr>
      <tr><td>3.4.7 Contestability</td><td>a) Characteristics of contestable markets<br>b) Implications of contestable markets for the behaviour of firms<br>c) Types of barrier to entry and exit<br>d) Sunk costs and the degree of contestability</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.5 Labour market</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>3.5.1 Demand for labour</td><td>a) Factors that influence the demand for labour<br>b) Demand for labour as a derived demand</td></tr>
      <tr><td>3.5.2 Supply of labour</td><td>a) Factors that influence the supply of labour to a particular occupation<br>b) Market failure in labour markets: the geographical and occupational mobility and immobility of labour</td></tr>
      <tr><td>3.5.3 Wage determination in competitive and non-competitive markets</td><td>a) Diagrammatic analysis of labour market equilibrium<br>b) Understanding of current labour market issues<br>c) Government intervention in the labour market: maximum and minimum wages; public sector wage setting; policies to tackle labour market immobility<br>d) The significance of the elasticity of demand for labour and the elasticity of supply of labour</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3.6 Government intervention</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>3.6.1 Government intervention</td><td>a) Government intervention to control mergers<br>b) Government intervention to control monopolies: price regulation; profit regulation; quality standards; performance targets<br>c) Government intervention to promote competition and contestability: enhancing competition between firms through promotion of small business; deregulation; competitive tendering for government contracts; privatisation<br>d) Government intervention to protect suppliers and employees: restrictions on monopsony power of firms; nationalisation</td></tr>
      <tr><td>3.6.2 The impact of government intervention</td><td>a) The impact of government intervention on: prices; profit; efficiency; quality; choice<br>b) Limits to government intervention: regulatory capture; asymmetric information</td></tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Theme 4: A global perspective</h3>
    <h4 class="font-mono bg-sky-100 p-1 mb-1">4.1 International economics</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>4.1.1 Globalisation</td><td>a) Characteristics of globalisation<br>b) Factors contributing to globalisation in the last 50 years<br>c) Impacts of globalisation and global companies on individual countries, governments, producers and consumers, workers and the environment</td></tr>
      <tr><td>4.1.2 Specialisation and trade</td><td>a) Absolute and comparative advantage (numerical and diagrammatic): assumptions and limitations relating to the theory of comparative advantage<br>b) Advantages and disadvantages of specialisation and trade in an international context</td></tr>
      <tr><td>4.1.3 Pattern of trade</td><td>a) Factors influencing the pattern of trade between countries and changes in trade flows between countries: comparative advantage; impact of emerging economies; growth of trading blocs and bilateral trading agreements; changes in relative exchange rates</td></tr>
      <tr><td>4.1.4 Terms of trade</td><td>a) Calculation of terms of trade<br>b) Factors influencing a country's terms of trade<br>c) Impact of changes in a country's terms of trade</td></tr>
      <tr><td>4.1.5 Trading blocs and the World Trade Organisation (WTO)</td><td>a) Types of trading blocs (regional trade agreements and bilateral trade agreements): free trade areas; customs unions; common markets; monetary unions: conditions necessary for their success with particular reference to the Eurozone<br>b) Costs and benefits of regional trade agreements<br>c) Role of the WTO in trade liberalisation<br>d) Possible conflicts between regional trade agreements and the WTO</td></tr>
      <tr><td>4.1.6 Restrictions on free trade</td><td>a) Reasons for restrictions on free trade<br>b) Types of restrictions on trade: tariffs; quotas; subsidies to domestic producers; non-tariff barriers<br>c) Impact of protectionist policies on consumers, producers, governments, living standards, equality</td></tr>
      <tr><td>4.1.7 Balance of payments</td><td>a) Components of the balance of payments: the current account; the capital and financial accounts<br>b) Causes of deficits and surpluses on the current account<br>c) Measures to reduce a country's imbalance on the current account<br>d) Significance of global trade imbalances</td></tr>
      <tr><td>4.1.8 Exchange rates</td><td>a) Exchange rate systems: floating; fixed; managed<br>b) Distinction between revaluation and appreciation of a currency<br>c) Distinction between devaluation and depreciation of a currency<br>d) Factors influencing floating exchange rates<br>e) Government intervention in currency markets through foreign currency transactions and the use of interest rates<br>f) Competitive devaluation/depreciation and its consequences<br>g) Impact of changes in exchange rates: the current account of the balance of payments (reference to Marshall-Lerner condition and J curve effect); economic growth and employment/unemployment; rate of inflation; foreign direct investment (FDI) flows</td></tr>
      <tr><td>4.1.9 International competitiveness</td><td>a) Measures of international competitiveness: relative unit labour costs; relative export prices<br>b) Factors influencing international competitiveness<br>c) Significance of international competitiveness: benefits of being internationally competitive; problems of being internationally uncompetitive</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">4.2 Poverty and inequality</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>4.2.1 Absolute and relative poverty</td><td>a) Distinction between absolute poverty and relative poverty<br>b) Measures of absolute poverty and relative poverty<br>c) Causes of changes in absolute poverty and relative poverty</td></tr>
      <tr><td>4.2.2 Inequality</td><td>a) Distinction between wealth and income inequality<br>b) Measurements of income inequality: the Lorenz curve (diagrammatic analysis); the Gini coefficient<br>c) Causes of income and wealth inequality within countries and between countries<br>d) Impact of economic change and development on inequality<br>e) Significance of capitalism for inequality</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">4.3 Emerging and developing economies</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>4.3.1 Measures of development</td><td>a) The three dimensions of the Human Development Index (HDI) (education, health and living standards) and how they are measured and combined<br>b) The advantages and limitations of using the HDI to compare levels of development between countries and over time<br>c) Other indicators of development</td></tr>
      <tr><td>4.3.2 Factors influencing growth and development</td><td>a) Impact of economic factors in different countries: primary product dependency; volatility of commodity prices; savings gap: Harrod-Domar model; foreign currency gap; capital flight; demographic factors; debt; access to credit and banking; infrastructure; education/skills; absence of property rights<br>b) Impact of non-economic factors in different countries</td></tr>
      <tr><td>4.3.3 Strategies influencing growth and development</td><td>a) Market-orientated strategies: trade liberalisation; promotion of FDI; removal of government subsidies; floating exchange rate systems; microfinance schemes; privatisation<br>b) Interventionist strategies: development of human capital; protectionism; managed exchange rates; infrastructure development; promoting joint ventures with global companies; buffer stock schemes<br>c) Other strategies: industrialisation: the Lewis model; development of tourism; development of primary industries; Fairtrade schemes; aid; debt relief<br>d) Awareness of the role of international institutions and non-government organisations (NGOs): World Bank; International Monetary Fund (IMF); NGOs</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">4.4 The financial sector</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>4.4.1 Role of financial markets</td><td>a) To facilitate saving<br>b) To lend to businesses and individuals<br>c) To facilitate the exchange of goods and services<br>d) To provide forward markets in currencies and commodities<br>e) To provide a market for equities</td></tr>
      <tr><td>4.4.2 Market failure in the financial sector</td><td>a) Consideration of: asymmetric information; externalities; moral hazard; speculation and market bubbles; market rigging</td></tr>
      <tr><td>4.4.3 Role of central banks</td><td>a) Key functions of central banks: implementation of monetary policy; banker to the government; banker to the banks – lender of last resort; role in regulation of the banking industry</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">4.5 Role of the state in the macroeconomy</h4>
    <table>
      <tr><th>Subject content</th><th>What students need to learn</th></tr>
      <tr><td>4.5.1 Public expenditure</td><td>a) Distinction between capital expenditure, current expenditure and transfer payments<br>b) Reasons for the changing size and composition of public expenditure in a global context<br>c) The significance of differing levels of public expenditure as a proportion of GDP on: productivity and growth; living standards; crowding out; level of taxation; equality</td></tr>
      <tr><td>4.5.2 Taxation</td><td>a) Distinction between progressive, proportional and regressive taxes<br>b) The economic effects of changes in direct and indirect tax rates on other variables: incentives to work; tax revenues: the Laffer curve; income distribution; real output and employment; the price level; the trade balance; FDI flows</td></tr>
      <tr><td>4.5.3 Public sector finances</td><td>a) Distinction between automatic stabilisers and discretionary fiscal policy<br>b) Distinction between a fiscal deficit and the national debt<br>c) Distinction between structural and cyclical deficits<br>d) Factors influencing the size of fiscal deficits<br>e) Factors influencing the size of national debts<br>f) The significance of the size of fiscal deficits and national debts</td></tr>
      <tr><td>4.5.4 Macroeconomic policies in a global context</td><td>a) Use of fiscal policy, monetary policy, exchange rate policy, supply-side policies and direct controls in different countries, with specific reference to the impact of: measures to reduce fiscal deficits and national debts; measures to reduce poverty and inequality; changes in interest rates and the supply of money; measures to increase international competitiveness<br>b) Use and impact of macroeconomic policies to respond to external shocks to the global economy<br>c) Measures to control global companies' (transnationals') operations: the regulation of transfer pricing; limits to government ability to control global companies<br>d) Problems facing policymakers when applying policies: inaccurate information; risks and uncertainties; inability to control external shocks</td></tr>
    </table>

    <!-- ============================================================ -->
    <!-- OCR -->
    <!-- ============================================================ -->
    <h2 id="ocr" class="text-xl bg-pink-300 p-1 font-mono mb-2">OCR (H460)</h2>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Component 1: Microeconomics (H460/01)</h3>
    <h4 class="font-mono bg-sky-100 p-1 mb-1">1. Introduction to Microeconomics</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>1.1 The economic problem</td><td>Explain: Economic goods and free goods; The economic problem: scarcity, choice, needs, and wants; Normative and positive statements; The role of economic agents: government, firms, and households; The factors of production: land, labour, capital, and enterprise; The rewards of the factors of production: rent, wages, interest and profit<br><br>Evaluate: The problem of scarcity and the requirement to make choices; Rationality as a way of understanding the behaviour of economic agents; The different objectives of the economic agents in an economy</td></tr>
      <tr><td>1.2 The allocation of resources</td><td>Explain: Incentives; Market, planned and mixed economic systems; Economic efficiency: productive and allocative efficiency<br><br>Evaluate: The effectiveness of incentives on the behaviour of economic agents and resource allocation; The allocation of resources in the different economic systems</td></tr>
      <tr><td>1.3 Opportunity cost</td><td>Explain: Opportunity cost and trade-off<br><br>Explain, with the aid of a diagram: Movements along a production possibility curve (PPC); Shifts of a production possibility curve (PPC); The usefulness of the concept of opportunity cost</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2. The role of markets</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>2.1 Specialisation and trade</td><td>Explain: Specialisation and the division of labour; Barter systems; Money as a medium of exchange<br><br>Evaluate: The role of specialisation and the division of labour in addressing the problem of scarcity</td></tr>
      <tr><td>2.2 Demand</td><td>Explain, with the aid of a diagram: The relationship between price and quantity demanded; Individual and market demand; Joint, competitive and composite demand; Movements along the demand curve (extension/contraction); Shifts of the demand curve (increase/decrease)</td></tr>
      <tr><td>2.3 Supply</td><td>Explain, with the aid of a diagram: The relationship between price and quantity supplied; Individual and market supply; Joint and competitive supply; Movements along the supply curve (extension/contraction); Shifts of the supply curve (increase/decrease)</td></tr>
      <tr><td>2.4 Consumer and producer surplus</td><td>Explain, with the aid of a diagram: Consumer surplus and producer surplus; The effects of changes in price on consumer surplus; The effects of changes in price on producer surplus<br><br>Evaluate: The impact of changes in price on consumer and producer surplus</td></tr>
      <tr><td>2.5 The interaction of markets</td><td>Explain: Ceteris paribus<br><br>Explain, with the aid of a diagram: The interaction of demand and supply; Market equilibrium and disequilibrium<br><br>Evaluate: The impact of changes in demand and/or supply in one market on a related market(s)</td></tr>
      <tr><td>2.6 Elasticity</td><td>Explain: Elasticity<br><br>Explain and calculate: Price elasticity of demand (PED); Income elasticity of demand (YED); Cross elasticity of demand (XED); Price elasticity of supply (PES)<br><br>Explain, with the aid of a diagram: Different values of PED, YED, XED and PES; The relationship between PED and a firm's total revenue<br><br>Evaluate: Factors which determine the value of PED, YED, XED and PES; The usefulness and significance of PED, YED, XED and PES</td></tr>
      <tr><td>2.7 The concept of the margin</td><td>Explain: Margin; Total and marginal utility, diminishing marginal utility and the demand curve<br><br>Explain and calculate: Marginal values</td></tr>
      <tr><td>2.8 Market failure and externalities</td><td>Explain: Market failure; Marginal social cost, marginal external cost, marginal private cost, marginal social benefit, marginal external benefit and marginal private benefit<br><br>Explain, with the aid of a diagram: Positive and negative externalities (external benefits and external costs); consumption and production</td></tr>
      <tr><td>2.9 Information failure</td><td>Explain: Information failure; Asymmetric information and moral hazard; Merit and demerit goods<br><br>Explain, with the aid of a diagram: Market failure caused by information failure<br><br>Evaluate: Consumption and production of merit goods; Consumption and production of demerit goods</td></tr>
      <tr><td>2.10 Public goods</td><td>Explain: Public goods, private goods and quasi-public goods; The characteristics of a public good; non-excludability, non-diminishability/non-rivalry, non-rejectability and zero marginal cost; The free rider problem<br><br>Evaluate: The provision of public goods</td></tr>
      <tr><td>2.11 Government intervention</td><td>Explain: Government intervention in markets: Taxation, subsidies, government expenditure, price controls, buffer stock systems, public/private partnerships, legislation, regulation, tradable pollution permits, information provision, competition policy; Government failure<br><br>Evaluate: The effectiveness of government intervention; Causes and consequences of government failure</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3. Business Objectives</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>3.1 Business objectives</td><td>Explain: Maximisation objectives: profit, sales revenue, sales volume, growth and utility; Non-maximising objectives: profit satisficing, social welfare, corporate social responsibility (CSR); The principal-agent problem</td></tr>
      <tr><td>3.2 Costs and economies of scale</td><td>Evaluate: Maximisation and non-maximisation objectives; Factors which influence the choice of objectives<br><br>Explain and calculate: Fixed, variable, total, average, marginal costs<br><br>Explain: Short run and long run in terms of fixed and variable factors<br><br>Explain, with the aid of a diagram: The law of diminishing returns; Internal and external economies of scale; Diseconomies of scale; Minimum efficient scale<br><br>Evaluate: Causes of economies and diseconomies of scale; The significance of economies and diseconomies of scale</td></tr>
      <tr><td>3.3 Revenue and profit</td><td>Explain and calculate: Total, average and marginal revenue; Profit/loss<br><br>Explain: Accounting, normal and supernormal profit</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">4. Market structures</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>4.1 Perfect competition</td><td>Explain: The characteristics of perfect competition<br><br>Explain, with the aid of a diagram: Short run perfect competition; supernormal profit/loss; Long run perfect competition: normal profits; Individual firm in perfect competition as a price taker; Equilibrium price and output for a firm in perfect competition; Allocative efficiency in short run and long run perfect competition; Productive efficiency in long run perfect competition</td></tr>
      <tr><td>4.2 Monopoly</td><td>Explain: The characteristics of monopoly; Dynamic efficiency; X-inefficiency<br><br>Explain, with the aid of a diagram: Monopoly; supernormal profit in both short and long run; A monopolist as a price maker; Equilibrium price and output for a profit maximising monopolist; Productive and allocative efficiency with a profit maximising monopolist; Price discrimination by a firm with monopoly power; Natural monopoly<br><br>Evaluate: Advantages and disadvantages of a monopoly; Advantages and disadvantages of a natural monopoly</td></tr>
      <tr><td>4.3 Monopolistic competition</td><td>Explain: The characteristics of monopolistic competition<br><br>Explain, with the aid of a diagram: Short run monopolistic competition; supernormal profit/loss; Long run monopolistic competition; normal profits; Equilibrium price and output for a firm in monopolistic competition<br><br>Evaluate: Advantages and disadvantages of monopolistic competition</td></tr>
      <tr><td>4.4 Oligopoly</td><td>Explain: The characteristics of oligopoly; Non-price competition; Interdependence: kinked demand curve; Types of collusion; Product differentiation<br><br>Evaluate and calculate: Concentration ratios<br><br>Evaluate: Advantages and disadvantages of oligopoly markets</td></tr>
      <tr><td>4.5 Contestable markets</td><td>Explain: The characteristics of a contestable market; Productive and allocative efficiency in a contestable market<br><br>Evaluate: Advantages and disadvantages of a contestable market</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">5. The labour market</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>5.1 Demand for labour</td><td>Explain: Derived demand for labour; Factors affecting the demand for labour in an industry; Factors affecting wage elasticity of demand for labour; Productivity and unit labour costs<br><br>Explain, with the aid of a diagram: Marginal revenue product theory in relation to employment and wage determination</td></tr>
      <tr><td>5.2 Supply of labour</td><td>Explain: Factors affecting the supply of labour to an industry; Factors affecting the wage elasticity of the supply of labour; Short run and long run supply of labour<br><br>Explain, with the aid of a diagram: Economic rent and transfer earnings</td></tr>
      <tr><td>5.3 The interaction of labour markets</td><td>Explain: Wage differentials; Monopsony; Trade union; Bilateral monopoly<br><br>Explain, with the aid of a diagram: The determination of wages in a highly competitive labour market; Changes in demand for, and supply of, labour<br><br>Evaluate: The impact of changes in labour market flexibility and mobility of labour; The impact of trade union activity on labour markets; The impact of a monopsonist employer on a labour market; The impact of a bilateral monopoly on a labour market</td></tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">Component 2: Macroeconomics (H460/02)</h3>
    <h4 class="font-mono bg-sky-100 p-1 mb-1">1. Aggregate demand and aggregate supply</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>1.1 Circular flow of income</td><td>Explain: The circular flow of income, with injections and leakages; The methods of measuring national income, output and expenditure</td></tr>
      <tr><td>1.2 Aggregate demand</td><td>Explain: Aggregate demand and its components<br><br>Explain, with the aid of a diagram: The relationship between aggregate demand and price level; Shifts in the aggregate demand curve<br><br>Evaluate: The relationship between changes in income and consumption; The role of expectations</td></tr>
      <tr><td>1.3 Aggregate supply</td><td>Explain: Aggregate supply<br><br>Explain, with the aid of a diagram: The relationship between aggregate supply and price level in the short run and long run; Shifts in the aggregate supply curve in the short run and long run</td></tr>
      <tr><td>1.4 The interaction of aggregate demand and supply</td><td>Explain: The assumptions underlying the aggregate demand and aggregate supply models; Equilibrium in the macroeconomy<br><br>Evaluate: Effects of changes in aggregate demand and aggregate supply on macroeconomic indicators</td></tr>
      <tr><td>1.5 The multiplier and the accelerator</td><td>Explain: Factors which determine the size of the national income multiplier<br><br>Explain, with the aid of a diagram: The national income multiplier and accelerator; The impact of the national income multiplier and accelerator on aggregate demand and economic cycle; Output gaps; aggregate demand and aggregate supply model and a production possibility curve (PPC)<br><br>Explain and calculate: Average and marginal propensities to consume, save and withdraw; Size of the national income multiplier<br><br>Evaluate: Causes and consequences of an output gap</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">2. Economic policy objectives</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>2.1 Economic growth</td><td>Explain: Economic growth; The policy objective of economic growth; The different stages of the economic cycle; Real and nominal Gross Domestic Product (GDP); changes in GDP over time<br><br>Explain and calculate: Economic growth rates; GDP per capita<br><br>Explain, with the aid of a diagram: Short run and long run economic growth<br><br>Evaluate: Causes and consequences of economic growth in the short run and long run</td></tr>
      <tr><td>2.2 Development</td><td>Explain: The structure of an economy in terms of primary, secondary and tertiary sectors; The policy objective of sustainable development<br><br>Evaluate: The relationship between economic growth and sustainable development; The usefulness of macroeconomic measures such as GDP, the Human Development Index (HDI) and other alternative social and cultural indicators</td></tr>
      <tr><td>2.3 Employment</td><td>Explain: Employment and unemployment; The policy objective of full employment; The labour force survey and claimant count measures of unemployment<br><br>Evaluate: Causes and consequences of unemployment; Effects of full employment</td></tr>
      <tr><td>2.4 Inflation</td><td>Explain: Inflation, deflation, disinflation and hyperinflation; The policy objective of low and stable inflation; Real and nominal values; Measuring inflation using the Consumer Prices Index and Retail Prices Index<br><br>Explain and calculate: The rate of inflation using index numbers<br><br>Evaluate: Causes and consequences of inflation and deflation</td></tr>
      <tr><td>2.5 Balance of payments</td><td>Explain: Balance of payments; The components of the current account: trade in goods, trade in services, primary and secondary income; The policy objective of a sustainable balance of payments position; Imbalances on the balance of payments<br><br>Explain and calculate: Balances on the different components on the balance of payments<br><br>Evaluate: Causes and consequences of imbalances on the balance of payments</td></tr>
      <tr><td>2.6 Trends in macroeconomic indicators</td><td>Explain: Key trends in UK macroeconomic performance in the last 20 years<br><br>Evaluate: The current performance of the UK economy compared with other developed economies, emerging and developing economies</td></tr>
      <tr><td>2.7 Income distribution and welfare</td><td>Explain: Income and wealth; distribution and inequality; The policy objective of a more even distribution of income; Absolute and relative poverty; Inequality data; Gini coefficients and relevant quantiles<br><br>Explain, with the aid of a diagram: The distribution of income (Lorenz curve)<br><br>Evaluate: Causes and consequences of poverty and inequality</td></tr>
      <tr><td>2.8 The Phillips Curve</td><td>Explain: Natural rate of unemployment; non-accelerating inflation rate of unemployment (NAIRU)<br><br>Explain, with the aid of a diagram: Keynesian and neo-classical approaches to aggregate supply; Short-run and long-run Phillips Curve<br><br>Evaluate: The usefulness of the Phillips Curve for macroeconomic policymakers</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">3. Implementing policy</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>3.1 Fiscal policy</td><td>Explain: Government budget; Direct, indirect, progressive, proportional and regressive taxation; Current and capital government expenditure; Budget surplus, deficit and balanced budget; Cyclical and structural budget position; National and government debt; Discretionary fiscal policy and automatic stabilisers; Crowding out; The Laffer curve<br><br>Explain and calculate: Average and marginal tax rates<br><br>Evaluate: The effectiveness of using fiscal policy to achieve the government's macroeconomic objectives</td></tr>
      <tr><td>3.2 Monetary policy</td><td>Explain, with the aid of a diagram: Changes in interest rates; Changes in money supply; Inflation rate targets; Quantitative easing; Influence of exchange rates<br><br>Evaluate: The effectiveness of using monetary policy to achieve the government's macroeconomic objectives</td></tr>
      <tr><td>3.3 Supply side policy</td><td>Explain, with the aid of a diagram: Privatisation, deregulation and subsidies; Competition policy; Investment in infrastructure, education, training, research and development; Reforms of the tax and benefit system; Improved labour market flexibility; Immigration control<br><br>Evaluate: The effectiveness of using supply side policy measures to achieve the government's macroeconomic objectives</td></tr>
      <tr><td>3.4 Policy conflicts</td><td>Evaluate: Conflicts and trade-offs between policy objectives</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">4. The global context</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>4.1 International trade</td><td>Explain: International trade; Patterns of international trade over time<br><br>Evaluate: Advantages and disadvantages of international trade to developed, emerging and developing countries</td></tr>
      <tr><td>4.2 Exchange rates</td><td>Explain and calculate: Exchange rates<br><br>Explain, with the aid of a diagram: Determination of exchange rates in fixed and floating exchange rate systems<br><br>Evaluate: Causes and consequences of exchange rate changes; Advantages and disadvantages of different exchange rate systems</td></tr>
      <tr><td>4.3 Globalisation</td><td>Explain: Globalisation; International competitiveness; Absolute and comparative advantage; Terms of trade; Marshall-Lerner condition and J-curve<br><br>Explain and calculate: Terms of trade<br><br>Evaluate: Comparative advantage as an explanation of international trade patterns; Causes and consequences of globalisation on developed, emerging and developing countries; The impact of the performance of emerging economies on other economies</td></tr>
      <tr><td>4.4 Trade policies and negotiations</td><td>Explain: Protectionism; Economic integration through free trade areas, customs unions, monetary union, economic union<br><br>Explain, with the aid of a diagram: The impact of tariffs and quotas on trade creation and trade diversion<br><br>Evaluate: Advantages and disadvantages of protectionism and free trade; The role of the World Trade Organisation (WTO) in promoting free trade</td></tr>
    </table>

    <h4 class="font-mono bg-sky-100 p-1 mb-1">5. The financial sector</h4>
    <table>
      <tr><th>Topic</th><th>Students should be able to:</th></tr>
      <tr><td>5.1 Money and interest rates</td><td>Explain: Functions and characteristics of money; The creation and supply of money; Narrow and broad money in terms of liquidity; The relationship between the money supply and the price level; Fisher equation of exchange<br><br>Explain, with the aid of a diagram: The determination of interest rates</td></tr>
      <tr><td>5.2 The financial sector</td><td>Explain: The role of the financial sector; The role of savings and investment in promoting economic development; The Harrod-Domar model; Microfinance<br><br>Evaluate: The role of the financial sector in promoting economic development</td></tr>
      <tr><td>5.3 Financial regulation</td><td>Explain: Purpose and methods of financial regulation; The role and functions of a central bank<br><br>Evaluate: The importance of the regulation of financial institutions; The effectiveness of different policy measures available to a central bank in targeting macroeconomic indicators; The role of the International Monetary Fund (IMF) and the World Bank in regulating the global financial system</td></tr>
    </table>

    <!-- ============================================================ -->
    <!-- CIE -->
    <!-- ============================================================ -->
    <h2 id="cie" class="text-xl bg-pink-300 p-1 font-mono mb-2">CIE (9708)</h2>
    <p class="mb-3">CIE's syllabus lists content as numbered learning objectives under each topic, rather than a Content/Amplification table — reproduced here in that same structure.</p>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">AS Level content</h3>
    <table>
      <tr><th>Topic</th><th>Learning objectives</th></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">1. Basic economic ideas and resource allocation</td></tr>
      <tr><td>1.1 Scarcity, choice and opportunity cost</td><td>Fundamental economic problem of scarcity; Need to make choices at all levels (individuals, firms, governments); Nature and definition of opportunity cost, arising from choices; Basic questions of resource allocation: what to produce, how to produce, for whom to produce</td></tr>
      <tr><td>1.2 Economic methodology</td><td>Economics as a social science; Positive and normative statements (the distinction between facts and value judgements); Meaning of the term ceteris paribus; Importance of the time period (short run, long run, very long run)</td></tr>
      <tr><td>1.3 Factors of production</td><td>Nature and definition of factors of production: land, labour, capital and enterprise; Difference between human capital and physical capital; Rewards to the factors of production; Division of labour and specialisation; Role of the entrepreneur in contemporary economies: risk and organisation of the other factors of production</td></tr>
      <tr><td>1.4 Resource allocation in different economic systems</td><td>Decision-making in market, planned and mixed economies; Resource allocation in these economic systems</td></tr>
      <tr><td>1.5 Production possibility curves</td><td>Nature and meaning of a production possibility curve (PPC); Shape of the PPC: constant and increasing opportunity costs; Causes and consequences of shifts in a PPC; Significance of a position within a PPC</td></tr>
      <tr><td>1.6 Classification of goods and services</td><td>Nature and definition of free goods and private goods (economic goods); Nature and definition of public goods; Nature and definition of merit goods: under-consumption as a result of imperfect information in the market; Nature and definition of demerit goods: over-consumption as a result of imperfect information in the market</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">2. The price system and the microeconomy</td></tr>
      <tr><td>2.1 Demand and supply curves</td><td>Effective demand; Individual and market demand and supply; Determinants of demand; Determinants of supply; Causes of a shift in the demand curve (D); Causes of a shift in the supply curve (S); Distinction between the shift in the demand or supply curve and the movement along these curves</td></tr>
      <tr><td>2.2 Price elasticity, income elasticity and cross elasticity of demand</td><td>Definition of price elasticity, income elasticity and cross elasticity of demand (PED, YED, XED); Formulae for and calculation of price elasticity, income elasticity and cross elasticity of demand; Significance of relative percentage changes, the size and sign of the coefficient; Descriptions of elasticity values: perfectly elastic, (highly) elastic, unitary elasticity, (highly) inelastic, perfectly inelastic; Variation in price elasticity of demand along the length of a straight-line demand curve; Factors affecting price elasticity, income elasticity and cross elasticity of demand; Relationship between price elasticity of demand and total expenditure on a product; Implications for decision-making of price elasticity, income elasticity and cross elasticity of demand</td></tr>
      <tr><td>2.3 Price elasticity of supply</td><td>Definition of price elasticity of supply (PES); Formula for and calculation of price elasticity of supply; Significance of relative percentage changes, the size and sign of the coefficient of price elasticity of supply; Factors affecting price elasticity of supply; Implications for speed and ease with which firms react to changed market conditions</td></tr>
      <tr><td>2.4 The interaction of demand and supply</td><td>Definition of market equilibrium and disequilibrium; Effects of shifts in demand and supply curves on equilibrium price and quantity; Relationships between different markets: joint demand (complements), alternative demand (substitutes), derived demand, joint supply; Functions of price in resource allocation: rationing, signalling (transmission of preferences) and incentivising</td></tr>
      <tr><td>2.5 Consumer and producer surplus</td><td>Meaning and significance of consumer surplus; Meaning and significance of producer surplus; Causes of changes in consumer and producer surplus; Significance of price elasticity of demand and of supply in determining the extent of these changes</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">3. Government microeconomic intervention</td></tr>
      <tr><td>3.1 Reasons for government intervention in markets</td><td>Addressing the non-provision of public goods; Addressing the over-consumption of demerit goods and the under-consumption of merit goods; Controlling prices in markets</td></tr>
      <tr><td>3.2 Methods and effects of government intervention in markets</td><td>Impact and incidence of specific indirect taxes; Impact and incidence of subsidies; Direct provision of goods and services; Maximum and minimum prices; Buffer stock schemes; Provision of information</td></tr>
      <tr><td>3.3 Addressing income and wealth inequality</td><td>Difference between income as a flow concept and wealth as a stock concept; Measuring income and wealth inequality: Gini coefficient (calculation not required); Economic reasons for inequality of income and wealth; Policies to redistribute income and wealth: minimum wage, transfer payments, progressive income taxes, inheritance and capital taxes, state provision of essential goods and services</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">4. The macroeconomy</td></tr>
      <tr><td>4.1 National income statistics</td><td>Meaning of national income; Measurement of national income: Gross Domestic Product (GDP), Gross National Income (GNI), Net National Income (NNI); Adjustment of measures from market prices to basic prices</td></tr>
      <tr><td>4.2 Introduction to the circular flow of income</td><td>The circular flow of income; Injections and leakages/withdrawals</td></tr>
      <tr><td>4.3 Aggregate Demand and Aggregate Supply analysis</td><td>Aggregate demand and aggregate supply; Determinants of aggregate demand; Determinants of short-run and long-run aggregate supply; Equilibrium level of real national income</td></tr>
      <tr><td>4.4 Economic growth</td><td>Distinction between growth in actual and potential output; Causes of growth; Costs and benefits of economic growth</td></tr>
      <tr><td>4.5 Unemployment</td><td>Definition and measurement of unemployment; Causes and types of unemployment; Consequences of unemployment</td></tr>
      <tr><td>4.6 Price stability</td><td>Definition, causes and measurement of inflation; Definition, causes and measurement of deflation; Consequences of inflation and deflation</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">5. Government macroeconomic intervention</td></tr>
      <tr><td>5.1 Government macroeconomic policy objectives</td><td>Government macroeconomic policy objectives: economic growth, full employment, price stability, balance of payments stability, redistribution of income</td></tr>
      <tr><td>5.2 Fiscal policy</td><td>Measures of fiscal policy; Direct and indirect taxation; Distinction between budget deficit and budget surplus; Reasons for taxation; Impact of fiscal policy on government macroeconomic policy objectives</td></tr>
      <tr><td>5.3 Monetary policy</td><td>Measures of monetary policy; Impact of monetary policy on government macroeconomic policy objectives</td></tr>
      <tr><td>5.4 Supply-side policy</td><td>Measures of supply-side policy; Impact of supply-side policy on government macroeconomic policy objectives</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">6. International economic issues</td></tr>
      <tr><td>6.1 The reasons for international trade</td><td>Meaning of, and reasons for, international trade; Theory of absolute and comparative advantage; Terms of trade</td></tr>
      <tr><td>6.2 Protectionism</td><td>Meaning of protectionism; Methods of protectionism: tariffs, quotas, embargoes, subsidies, administrative barriers; Reasons for protectionism; Effects of protectionism on economic agents</td></tr>
      <tr><td>6.3 Current account of the balance of payments</td><td>Structure of the current account of the balance of payments; Causes of current account deficits and surpluses; Consequences of current account deficits and surpluses</td></tr>
      <tr><td>6.4 Exchange rates</td><td>Meaning of the exchange rate; Determination of the exchange rate; Fixed, floating and managed exchange rate systems; Depreciation, appreciation, devaluation and revaluation; Factors influencing exchange rates</td></tr>
      <tr><td>6.5 Policies to correct imbalances in the current account of the balance of payments</td><td>Expenditure switching and expenditure reducing policies; Effectiveness of policies to correct current account imbalances</td></tr>
    </table>

    <h3 class="font-mono text-lg bg-sky-200 p-1 mb-1">A Level content (in addition to AS Level)</h3>
    <table>
      <tr><th>Topic</th><th>Learning objectives</th></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">7. The price system and the microeconomy</td></tr>
      <tr><td>7.1 Utility</td><td>Meaning of utility; Total and marginal utility; Law of diminishing marginal utility</td></tr>
      <tr><td>7.2 Indifference curves and budget lines</td><td>Indifference curves and their properties; Budget lines; Consumer equilibrium; Effects of changes in price and income</td></tr>
      <tr><td>7.3 Efficiency and market failure</td><td>Meaning of allocative and productive efficiency; Meaning of market failure; Causes of market failure</td></tr>
      <tr><td>7.4 Private costs and benefits, externalities and social costs and benefits</td><td>Distinction between private, external and social costs and benefits; Positive and negative externalities of production and consumption; Divergence between private and social efficiency</td></tr>
      <tr><td>7.5 Types of cost, revenue and profit, short-run and long-run production</td><td>Total, average and marginal cost, revenue and profit; Law of diminishing returns; Short-run and long-run production; Economies and diseconomies of scale</td></tr>
      <tr><td>7.6 Different market structures</td><td>Characteristics of perfect competition, monopolistic competition, oligopoly and monopoly; Price and output determination in each market structure; Efficiency implications of each market structure</td></tr>
      <tr><td>7.7 Growth and survival of firms</td><td>Reasons for the growth of firms; Types of integration; Reasons why small firms survive</td></tr>
      <tr><td>7.8 Differing objectives and policies of firms</td><td>Profit maximisation and alternative business objectives; Pricing strategies</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">8. Government microeconomic intervention</td></tr>
      <tr><td>8.1 Government policies to achieve efficient resource allocation and correct market failure</td><td>Policies to correct externalities; Policies to address under-provision of public goods; Policies to address information failure; Competition policy</td></tr>
      <tr><td>8.2 Equity and redistribution of income and wealth</td><td>Meaning of equity; Causes of inequality; Policies to redistribute income and wealth</td></tr>
      <tr><td>8.3 Labour market forces and government intervention</td><td>Determination of wages in competitive and non-competitive labour markets; Labour market imperfections; Government intervention in labour markets: minimum wage, maximum wage</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">9. The macroeconomy</td></tr>
      <tr><td>9.1 The circular flow of income</td><td>Withdrawals and injections; National income equilibrium</td></tr>
      <tr><td>9.2 Economic growth and sustainability</td><td>Causes and consequences of economic growth; Sustainability of economic growth</td></tr>
      <tr><td>9.3 Employment/unemployment</td><td>Costs of unemployment; Policies to reduce unemployment</td></tr>
      <tr><td>9.4 Money and banking</td><td>Functions of money; Structure and functions of a central bank and commercial banks; Meaning and measurement of the money supply</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">10. Government macroeconomic intervention</td></tr>
      <tr><td>10.1 Government macroeconomic policy objectives</td><td>Government macroeconomic policy objectives in more depth</td></tr>
      <tr><td>10.2 Links between macroeconomic problems and their interrelatedness</td><td>Conflicts between macroeconomic policy objectives</td></tr>
      <tr><td>10.3 Effectiveness of policy options to meet all macroeconomic objectives</td><td>Evaluation of fiscal, monetary and supply-side policy effectiveness</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">11. International economic issues</td></tr>
      <tr><td>11.1 Policies to correct disequilibrium in the balance of payments</td><td>Expenditure switching and reducing policies in more depth; Marshall-Lerner condition; J-curve effect</td></tr>
      <tr><td>11.2 Exchange rates</td><td>Determination of exchange rates in more depth; Government intervention in currency markets</td></tr>
      <tr><td>11.3 Economic development</td><td>Meaning of economic development; Indicators of development: HDI and others</td></tr>
      <tr><td>11.4 Characteristics of countries at different levels of development</td><td>Characteristics of developed, emerging and developing economies</td></tr>
      <tr><td>11.5 Relationship between countries at different levels of development</td><td>Obstacles to development; Role of trade and aid in development</td></tr>
      <tr><td>11.6 Globalisation</td><td>Meaning and causes of globalisation; Impact of globalisation on developed and developing economies</td></tr>
    </table>

    <!-- ============================================================ -->
    <!-- IB -->
    <!-- ============================================================ -->
    <h2 id="ib" class="text-xl bg-pink-300 p-1 font-mono mb-2">IB (International Baccalaureate)</h2>
    <div class="border-2 rounded border-sky-200 p-3 mb-3">
      <p>The IB doesn't publish a detailed Content/Amplification table publicly — the full subject guide is restricted to IB member schools. What follows is the complete unit/topic list from the public subject brief, which is the most detail available outside that restricted guide.</p>
    </div>
    <table>
      <tr><th>Code</th><th>Topic</th></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">Unit 1: Introduction to economics</td></tr>
      <tr><td>1.1</td><td>What is economics?</td></tr>
      <tr><td>1.2</td><td>How do economists approach the world?</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">Unit 2: Microeconomics</td></tr>
      <tr><td>2.1</td><td>Demand</td></tr>
      <tr><td>2.2</td><td>Supply</td></tr>
      <tr><td>2.3</td><td>Competitive market equilibrium</td></tr>
      <tr><td>2.4</td><td>Critique of the maximizing behaviour of consumers and producers</td></tr>
      <tr><td>2.5</td><td>Elasticity of demand</td></tr>
      <tr><td>2.6</td><td>Elasticity of supply</td></tr>
      <tr><td>2.7</td><td>Role of government in microeconomics</td></tr>
      <tr><td>2.8</td><td>Market failure — externalities and common pool or common access resources</td></tr>
      <tr><td>2.9</td><td>Market failure — public goods</td></tr>
      <tr><td>2.10</td><td>Market failure — asymmetric information (HL only)</td></tr>
      <tr><td>2.11</td><td>Market failure — market power (HL only)</td></tr>
      <tr><td>2.12</td><td>The market's inability to achieve equity (HL only)</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">Unit 3: Macroeconomics</td></tr>
      <tr><td>3.1</td><td>Measuring economic activity and illustrating its variations</td></tr>
      <tr><td>3.2</td><td>Variations in economic activity — aggregate demand and aggregate supply</td></tr>
      <tr><td>3.3</td><td>Macroeconomic objectives</td></tr>
      <tr><td>3.4</td><td>Economics of inequality and poverty</td></tr>
      <tr><td>3.5</td><td>Demand management (demand-side policies) — monetary policy</td></tr>
      <tr><td>3.6</td><td>Demand management — fiscal policy</td></tr>
      <tr><td>3.7</td><td>Supply-side policies</td></tr>
      <tr><td colspan="2" class="bg-sky-100 font-semibold">Unit 4: The global economy</td></tr>
      <tr><td>4.1</td><td>Benefits of international trade</td></tr>
      <tr><td>4.2</td><td>Types of trade protection</td></tr>
      <tr><td>4.3</td><td>Arguments for and against trade control/protection</td></tr>
      <tr><td>4.4</td><td>Economic integration</td></tr>
      <tr><td>4.5</td><td>Exchange rates</td></tr>
      <tr><td>4.6</td><td>Balance of payments</td></tr>
      <tr><td>4.7</td><td>Sustainable development</td></tr>
      <tr><td>4.8</td><td>Measuring development</td></tr>
      <tr><td>4.9</td><td>Barriers to economic growth and/or economic development</td></tr>
      <tr><td>4.10</td><td>Economic growth and/or economic development strategies</td></tr>
    </table>

  </div>
</div>

<?php include($path."/footer_tailwind.php"); ?>
