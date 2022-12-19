<?php



// Initialize the session
session_start();

date_default_timezone_set("Europe/London");


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}

//The following ensures that only user id = 1 can use this!!! 
if($_SESSION['userid'] != 1) {
  header("location: /index.php");
}

$style_input = "
  
  input, button, textarea, th, td {
    border: 1px solid black;
  }

  
  ";

include($path."/header_tailwind.php");


?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Login Log</h1>
    <div class="font-mono text-md container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php 
        if($_GET) {
          //print_r($_GET);
        }
      ?>
      <form method = "get" action = "">
        <label>Name Search: </label>
        <input type="text" name = "searchName">
        <input type = "submit" name="submit" value="Search Name">
      </form>

        

        
        

    <?php
      if ($_GET) {
        if($_GET['submit'] == "Search Name") {
          $results = loginLogReturn(null, $_GET['searchName']);
        }
       }
      else {
       $results = loginLogReturn();
      }

      if(count($results)>0) {
        ?>
        <table>
          <tr>
            <th>Name</th>
            <th>dateTime</th>
            <th>source</th>
          </tr>
        <?php
      } else {
        ?>
        <p>Your search did not yield any results.</p>
        <?php
      }
      foreach ($results as $result) {
        //print_r( $result);
        ?>
          <tr>
            <td class="pr-3"><?=$result['first']." ".$result['last']?></td>
            <td class="pr-3"><?=$result['dateTime']?></td>
            <td class="pr-3"><?=$result['last_url']?></td>
          </tr>
        <?php
      }

    ?>
        
      </table>
    </div>
</div>

<?php include($path."/footer_tailwind.php");?>