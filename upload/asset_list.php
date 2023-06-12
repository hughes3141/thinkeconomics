<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }

}

$style_input = "
  th, td {
    border: 1px solid black;
  }

  
  ";


include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Asset List</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <pre>
    <?php
      $assets = getUploadsInfo();
      print_r($assets);
    ?>
    </pre>

    <table>
      <tr>
        <th>id</th>
        <th>Path</th>
        <th>Alt Text</th>
        <th>Notes</th>
      </tr>
      <?php
        foreach ($assets as $asset) {
          ?>
          <tr>
            <td><?=$asset['id']?></td>
            <td><?=$asset['uploadRoot']?><?=$asset['path']?></td>
            <td><?=$asset['altText']?></td>
            <td><?=$asset['notes']?></td>
          </tr>
          <?php
        }
      ?>
    </table>
  </div>
</div>

<script>

</script>

<?php   include($path."/footer_tailwind.php");?>
