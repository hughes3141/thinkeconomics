<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$publicPage = true;
include($path."/php_header.php");
include($path."/php_functions.php");

$message = "";
$password_err = "";
$email = "";
$resetCode = "";
$tokenValid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
  $resetCode = trim($_POST['reset_code'] ?? '');
} else {
  $email = isset($_GET['email']) ? filter_var(trim($_GET['email']), FILTER_VALIDATE_EMAIL) : false;
  $resetCode = isset($_GET['reset_code']) ? trim($_GET['reset_code']) : '';
}

if (!$email || $resetCode === '') {
  $message = "This password change link is invalid. Please request a new one from your dashboard.";
} else {
  $user = find_user_by_reset_code($resetCode, $email);

  if (!$user) {
    $message = "This password change link is invalid or has expired. Please request a new one from your dashboard.";
  } else {
    $tokenValid = true;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $results = validatePassword($_POST['password1'] ?? '', $_POST['password2'] ?? '');
      $password_err = $results['password_err'];

      if ($results['password_validate'] == 1) {
        update_user_password($user['id'], $results['password']);
        unset($_SESSION['userid']);
        header("Location: /login.php?password_changed=1");
        exit;
      }
    }
  }
}

$style_input = "";
include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Change Password</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black p-4">

    <?php if (!$tokenValid) { ?>

      <p class="pl-1 py-2 text-red-600 bg-lime-300 rounded"><?=htmlspecialchars($message)?></p>
      <p class="mt-3"><a href="/login.php" class="underline hover:bg-sky-100">Go to login</a></p>

    <?php } else { ?>

      <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" autocomplete="off">
        <input type="hidden" name="email" value="<?=htmlspecialchars($email)?>">
        <input type="hidden" name="reset_code" value="<?=htmlspecialchars($resetCode)?>">

        <div class="form-group w-full">
          <label for="password1" class="pb-1 mb-2 pt-1">New password:</label>
          <div class="mt-1.5">
            <input type="password" name="password1" id="password1" class="border px-3 py-2 text-sm w-full mb-2 rounded" placeholder="New password">
          </div>
        </div>
        <div class="form-group w-full">
          <label for="password2" class="pb-1 mb-2 pt-1">Confirm new password:</label>
          <div class="mt-1.5">
            <input type="password" name="password2" id="password2" class="border px-3 py-2 text-sm w-full mb-2 rounded" placeholder="Confirm new password">
          </div>
        </div>
        <p class="mt-1 pl-1 text-red-600 bg-lime-300 rounded"><?=htmlspecialchars($password_err)?></p>
        <p>Passwords must:
          <ul class="list-disc list-oustide">
            <li class="ml-6">Have minimum 6 characters</li>
            <li class="ml-6">At least one uppercase letter</li>
            <li class="ml-6">At least one lowercase letter</li>
            <li class="ml-6">At least one number</li>
          </ul>
        </p>

        <div class="form-group">
          <input type="submit" class="mt-3 rounded bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Change password">
        </div>
      </form>

    <?php } ?>

  </div>
</div>

<?php include $path."/footer_tailwind.php"; ?>
