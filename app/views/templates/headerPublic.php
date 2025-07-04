<?php
if (isset($_SESSION['auth']) == 1) {    //user is logged in
    header('Location: /home');
}

if ($_SESSION['failed_attempts'] > 2) {    //lockout after 3 failed login attempts
  unset($_SESSION['failed_attempts']);
  header('Location: /lockout');
}  

if (isset($_SESSION['failed_attempts'])) {
    echo "You will be temporarily locked out after " . (3 - $_SESSION['failed_attempts']) . " more unsuccessful login attempts<br>";
}

if (isset($_SESSION['no_user'])) {
    echo "No such user exists<br>";
    unset($_SESSION['no_user']);  
}
?>

<!DOCTYPE html>
<html lang="en">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <link rel="icon" href="/favicon.png">
    <title>COSC 4806</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
</head>
<body>