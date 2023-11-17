<?php 

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$downloadPermissions = null;
$userId = null;

if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
} else {
  $userId = $_SESSION['userid'];
  $userInfo = getUserInfo($userId);
  $permissions = $userInfo['permissions'];
  if((str_contains($permissions, "news_article_download") || str_contains($userInfo['school_permissions'], "news_article_download"))) {
    $downloadPermissions = 1;
  }

}

/*
Note that the permission "news_article_download" must be present in either permissions for school or for user for article download to be available.


*/





error_reporting(0);
$style_input = <<<END

th, td {
  
  border: 1px solid black;
  padding: 5px;
  word-wrap:break-word;
}

table {
  
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;

}

.col1, .col3 {
  width: 10%;
}

.col2 {
  width: 80%;
}

@media only screen and (max-width: 600px) {
  .col1, .col3 {
    width: 25%;
  }

  .col2 {
    width: 50%;
}
}

td p {
  margin-top: 0px;
}

END;

$get_selectors = array(
  'id' => (isset($_GET['id']) && $_GET['id'] != "") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic']) && $_GET['topic'] != "") ? $_GET['topic'] : null,
  'keyword' => (isset($_GET['keyword']) && $_GET['keyword'] != "") ? $_GET['keyword'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate'] != "") ? $_GET['startDate'] : null,
  'endDate' => (isset($_GET['endDate']) && $_GET['endDate'] != "") ? $_GET['endDate'] : null,
  'orderBy' => (isset($_GET['orderBy']) && $_GET['orderBy'] != "") ? $_GET['orderBy'] : null,
  'limit' => (isset($_GET['limit']) && $_GET['limit'] != "") ? $_GET['limit'] : 100,
  'searchFor' => (isset($_GET['searchFor']) && $_GET['searchFor'] != "") ? $_GET['searchFor'] : ""
);

$newsArticles = getNewsArticles($get_selectors['id'], $get_selectors['keyword'], $get_selectors['topic'], $get_selectors['startDate'], $get_selectors['endDate'], $get_selectors['orderBy'], null, $get_selectors['limit'], $get_selectors['searchFor'])
?>

<?php include "header_tailwind.php"; ?>









<?php 

//print_r($_POST);
/*
if (isset($_SESSION['userid'])==false) {

  $_SESSION['name'] = $_POST['name'];
  $_SESSION['userid'] = $_POST['userid'];
  $_SESSION['usertype'] = $_POST['usertype'];
  $_SESSION['groupid'] = $_POST['groupid'];

}
*/
//print_r($_SESSION);

?>
<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
<h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">News List</h1>

<?php 

//print_r($newsArticles);
//var_dump($get_selectors);

//var_dump($permissions);
//print_r($userInfo);


echo <<<END
    <table class="bg-white text-black">
      <tr>
        <th class='col1'>
          <form method = "get">
            <select class="text-black"style="width: 100%;" onchange="this.form.submit()" name="topic">
              <option value="">Topic</option>
END;

$sql = "SELECT * FROM topics";
$result = $conn->query($sql);
if($result) {
  while ($row = $result->fetch_assoc()) {
    echo "<option value = '".$row['topicCode']."'";
    if($_GET['topic']==$row['topicCode']) {
      echo " selected ";
    }
    echo ">";
    echo "(".$row['topicCode'].") ".$row['topicName'];
    
    echo "</option>"; 
  }
}

echo <<<END
            </select>
          </form>
        </th>
        <th class='col2'>Article</th><th class='col3'>Date Published</th>
      </tr>
END;


$imgSource = "https://www.thinkeconomics.co.uk";

foreach ($newsArticles as $row) {
    echo "<tr>";
  
    //print_r($row);
    //echo "<td>".$row['id']."</td>";
    echo "<td>".$row['topic']."</td>";
    echo "<td><p><strong>Headline: </strong>".$row['headline'];
    
    echo "</p><p><strong>Link: </strong><a class = 'hover:bg-sky-100' target ='_blank' href='".$row['link']."'>".$row['link']."</a>";

    if($row['path'] != "" && $downloadPermissions) {
      ?>
      <a class="bg-sky-100 hover:bg-sky-200  rounded whitespace-nowrap" target="_blank" href="<?=$imgSource.$row['path']?>">Download PDF</a>
      <?php
    }
    echo "</p>";

    if ($row['explanation']!="") {
      echo "<p><strong>Explanation: </strong>".$row['explanation']."</p";
    }

    

    echo "</td>";

    $date = strtotime($row['datePublished']);
    $formatDate = date( 'd M Y', $date );
    echo "<td>".$formatDate."</td>";
    

  }



  

  
  
  
      





echo "</table>";


?>
</div>
<?php


include "footer_tailwind.php";


?>



</body>

</html>