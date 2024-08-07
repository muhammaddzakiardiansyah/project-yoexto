<?php
session_start();

require "./config.php";

if (isset($_COOKIE["key_1"]) && isset($_COOKIE["key_2"])) {
  $id = base64_decode($_COOKIE["key_1"]);
  $user = get_user_by_id($id);
  if ($user != new stdClass()) {
    $username = base64_decode($_COOKIE["key_2"]);
    if ($user->username == $username) {
      $_SESSION["user_login"] = ["id" => $user->id, "login" => true, "username" => $user->username];
    }
  }
}

if (!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Yoexto</title>
  <!-- link favicon -->
  <link rel="shortcut icon" href="/assets/images/envelope-open-heart.svg" type="image/x-icon">
  <!-- link css -->
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/customize.css">
  <!-- link sweetalert -->
  <script src="/assets/js/sweetalert2.all.min.js"></script>
  <!-- link jquery validate -->
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/jquery.validate.min.js"></script>
  <!-- link file typed js -->
  <script src="/assets/js/typed.umd.js"></script>
  <!-- animated on scroll -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="font-primary">