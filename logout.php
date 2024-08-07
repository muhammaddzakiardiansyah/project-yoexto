<?php include "assets/components/header.php" ?>
<?php

setcookie("key_1", "", time() - 3600, "/");
setcookie("key_2", "", time() - 3600, "/");
session_unset();
session_destroy();

header("Location: /");