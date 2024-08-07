<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "yoexto";
$password_secret_key = "IFN396grgki(&#34ijrfIJNnmfkfoo";

$connection = new mysqli($servername, $username, $password, $database);

if($connection->error) {
  die("Database failed connection! " . $connection->error);
} else {
  include "./functions.php";
}