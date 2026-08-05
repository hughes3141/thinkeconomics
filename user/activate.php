<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$publicPage = true;
include($path."/php_header.php");
include($path."/php_functions.php");

$message = "";

if (is_get_request()) {

  $email = isset($_GET['email']) ? filter_var(trim($_GET['email']), FILTER_VALIDATE_EMAIL) : false;
  $activation_code = isset($_GET['activation_code']) ? trim($_GET['activation_code']) : '';

  if (!$email || $activation_code === '') {
    $message = "This activation link is invalid. Please check the link from your email, or register again.";
  } else {
    $user = find_unverified_user($activation_code, $email);

    if ($user && activate_user($user['id'])) {
      header("Location: /login.php?activated=1");
      exit;
    } else {
      $message = "This activation link is invalid or has expired. Please register again to receive a new link.";
    }
  }
} else {
  $message = "This activation link is invalid. Please check the link from your email, or register again.";
}

$style_input = "";
include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Account Activation</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black p-4">
    <p class="pl-1 py-2 text-red-600 bg-lime-300 rounded"><?=htmlspecialchars($message)?></p>
    <p class="mt-3"><a href="/user/newuser.php" class="underline hover:bg-sky-100">Register again</a> or <a href="/login.php" class="underline hover:bg-sky-100">go to login</a>.</p>
  </div>
</div>

<?php include $path."/footer_tailwind.php"; ?>
