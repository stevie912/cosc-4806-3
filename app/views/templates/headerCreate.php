<?php
if (isset($_SESSION['pass_mismatch'])) {
  echo "Passwords do not match";
  unset($_SESSION['pass_mismatch']);
}
if (isset($_SESSION['user_exists'])) {
  echo "User already exists"; 
  unset($_SESSION['user_exists']);
}
if (isset($_SESSION['pass_insecure'])) {
  echo "Password must contain at least 8 characters, lower and upper case, and a number";
  unset($_SESSION['pass_insecure']);
}

?>

<!DOCTYPE html>
<html lang="en">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="/favicon.png">
    <title>Create new user</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
</head>
<body>