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

<!--
<section class="bg-white border-b py-8 text-black">
-->
<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Notes</h1>
    
  <div class="container mx-auto px-0 mt-2 bg-white text-black ">
      

    
      <ul style="list-style-type: none; padding: 0px;">

      <?php

        //$sql = "SELECT * FROM notes_index WHERE user = ? ORDER BY orderNo";
        $sql = "SELECT * FROM notes_index ORDER BY orderNo";


        $stmt= $conn->prepare($sql);

        //$stmt-> bind_param("i", $_SESSION['userid']);
        //$stmt-> bind_param();

        $stmt-> execute();

        $result = $stmt-> get_result();

        if($result -> num_rows>0) {
          while($row = $result->fetch_assoc()) {
            if ($row['heading']=="h2") {
              echo "<h2 class = 'font-mono text-lg bg-pink-300 pl-1'>";
              echo ($row['topic']!="") ? $row['topic']." " : null;
              echo $row['title']."</h2>";
            }
            elseif ($row['heading']=="h3") {
              echo "<h3 class = 'font-mono text-lg bg-pink-200 pl-1 ml-2'>";
              echo ($row['topic']!="") ? $row['topic']." " : null;
              echo $row['title']."</h2>";
            }

            elseif ($row['heading']=="a") {
              echo "<li class='ml-2 mr-2 hover:bg-sky-100'><a class = 'block' target='blank' href = '".$row['link']."'>".$row['topic'].": ".$row['title'];
              echo ($row['source'] != "") ? " (".$row['source'].")" : null;
              echo "</a></li>";
            }
            //echo $row['title'];
            //echo "<br>";
          }
        }

      ?>

      </ul>

      <?php for($x=0; $x<10; $x++) {echo "<br>";}?>
  </div>
</div>



<script>



</script>

<?php include "footer_tailwind.php";?>
