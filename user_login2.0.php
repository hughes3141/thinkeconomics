<?php

//session_unset();
//session_destroy();

session_start();


error_reporting(0);
?>


<?php include "header_tailwind.php"; ?>

<div class="container mx-auto px-4 mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Login</h1>
  <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
    <form method="post">
      
        <label for="name_input" class="text-gray-600 pb-1 ml-2 mb-2 pt-1" >Name:</label> 
        <input class="border px-3 py-2  text-sm w-full" id="name_input" type="text" name="name" placeholder =Name value ="<?php echo $_POST['name']; echo $_SESSION['name'];	 ?>"
      </div>

      
      <label for="password_input"  class="text-gray-600 pb-1 ml-2 mb-2 pt-1">Password:</label>  
        <input class="border px-3 py-2 mt-1 mb-5 text-sm w-full" id="password_input" type="password" name="password" placeholder =Password>
      </p>
      <input class="transition duration-200 bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" type="submit" value = "Login">
    </form>
    
  </div>
</div>


<?php 
//echo var_dump($_POST);

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

$link = mysqli_connect ($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
	
	die("The connection could not be established");
}

$name = htmlspecialchars($_POST['name']);
$password = $_POST["password"];
//echo "<br>";
//echo $name."<br>";
//echo empty($name);

$query = "SELECT id, name, password, usertype, groupid FROM users WHERE name ='".mysqli_real_escape_string($link, $name)."'";

if ($result = mysqli_query($link, $query)) {
	
	if ((mysqli_num_rows($result) == 0)and(empty($_POST['name'])==false)) {
			
			echo "<script type='text/javascript'>alert('This name is not in the database');</script>";
		
	}
	
	else {
				
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
		if ($row['password'] != $password) {
			echo "<script type='text/javascript'>alert('Incorrect password');</script>";
		}
		
		elseif ((empty($_POST['name'])==false)){
					
			$_SESSION["userid"] = $row[id];
			$_SESSION["name"] = $row[name];
      $_SESSION["usertype"] = $row[usertype];
      $_SESSION["groupid"] = $row[groupid];
			
			//print_r($_SESSION);
			
			echo "<script type='text/javascript'>
			window.location.href = 'user/user3.0.php';
			//document.getElementById('useridInput').value ='".$row[id]."';
			</script>";
			
      echo "<script type='text/javascript'>
			
			document.getElementById('form2').submit();
			</script>";
			
		}
		
		
	}
}



?>	




<?php 




include "footer_tailwind.php";

?>

</body>


</html>