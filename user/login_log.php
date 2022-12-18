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



include($path."/header_tailwind.php");


?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Login Log/h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <table>
        <tr>
          <th>Name</th>
          <th>dateTime</th>
          <th>source</th>
        </tr>
        

        
        

    <?php
      $results = loginLogReturn();
      foreach ($results as $result) {
        //print_r( $result);
        ?>
          <tr>
            <td><?=$result['first']." ".$result['last']?></td>
            <td class="px-5"><?=$result['dateTime']?></td>
            <td class="px-5"><?=$result['last_url']?></td>
          </tr>
        <?php
      }

    ?>
        
      </table>
    </div>
</div>

<?php include($path."/footer_tailwind.php");?>