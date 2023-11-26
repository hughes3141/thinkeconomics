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


include($path."/header_tailwind.php");

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Multiple Choice Questions (MCQs)</h1>
    <div class="container mx-auto px-0 mt-2 bg-white text-black">
      <ul class="list-none">
        <h2 class="font-mono text-xl bg-pink-300 pl-1">Year 1</h2>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">Micro</h3>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=47">1.1.1 Scarcity, Choice, Opportunity Cost Exercises</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=17">1.1.2 PPF Exercises 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=18">1.1.2 PPF Exercises 2</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=54">1.1.3 Specialisation and Division of Labour</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=46">1.1.3 Specialisation Questions Only</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=19">1.1.3 Labour Index Tables Only (3 Qs)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=56">1.2.1 Supply and Demand Homework Questions</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=63">1.2.2 Equilibrium Practice 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=78">1.2.2 Equilibrium Practice 2</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=68">1.2.2 Equlibrium Practice (Taxes and Subsidies)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=71">1.2.4 PED Homework Questions 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=72">1.2.4 PED Homework Questions 2</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=73">1.2.4 YED Homework Questions</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=75">1.2.4 XED Homework Questions</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=76">1.2.4 PES Homework Questions</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=132">1.3.1 Wage Determination</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=79">1.7.1 Externalities (No Graphs)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=80">1.7.1 Externalities (Graphs Only)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=81">1.7.2 Government Intervention: Types 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=82">1.7.2 Government Intervention: Types 2</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=83">1.7.2 Government Intervention: Maximum/Minimum Prices</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=84">1.7.2 Government Intervention: Buffer Stock Schemes</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=85">1.7.3 Government Failure</a></li>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">Macro</h3>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=27">2.1.1 Circular Flow of Income (5qs)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=87">2.1.2 Components of AD: Definitions and Calculations</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=88">2.1.2 Components of AD: Influences on Components</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=30">2.1.3 AD Questions</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=32">2.1.5/2.1.6 SRAS and LRAS Shifts</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=33">2.1.7 Neoclassical AS/AD (1)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=34">2.1.7 Neoclassical AS/AD (2)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=36">2.1.7 Neoclassical AS/AD (3)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=94">2.2.4 Inflaton and Deflation Exercises 1(11qs)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=94">2.2.4 Inflaton and Deflation Exercises 2(10qs)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=66">2.2.5 Balance of Payments Exercise 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=102">2.3.1 Fiscal Policy Exercises 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=103">2.3.1 Fiscal Policy Exercises 2</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=108">2.3.2 Monetary Policy Exercises 1</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=109">2.3.2 Monetary Policy Exercises 2</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=15">2.3.2 QE Only Exercise</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=45">2.3.4 Exchange Rates Practice</a></li>
        <h2 class="font-mono text-xl bg-pink-300 pl-1">Year 2</h2>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">Micro</h3>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=52">1.5.1 Economies of Scale</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=51">1.5.1 EoS and Cost Curves</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=116">1.5.3 Efficiency</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=113">1.6.3/1.6.4 Theory of the Firm Exercises</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=69">1.6.5 Monopoly Questions</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=64">1.6.6 Oligopoly</a></li>
        <h2 class="font-mono text-xl bg-pink-300 pl-1">Eduqas Past Papers</h2>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=98">C1 Spec Paper</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=99">C1 June 2017</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=100">C1 June 2018</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=6">C1 June 2019</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=104">WJEC 2016</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=105">WJEC 2017</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=106">WJEC 2018</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a href="mcq/mcq_exercise.php?quizid=107">WJEC 2019</a></li>

      </ul>
    </div>
</div>

<?php include "footer_tailwind.php"; ?>
