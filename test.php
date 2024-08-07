<?php

// echo base64_encode(openssl_random_pseudo_bytes(32));

// for($i = 0; $i >= 5; $i+1) {
//   echo $i;
// }

$pass = "anggelikaCantik" . "IFN396grgki(&#34ijrfIJNnmfkfoo";

echo password_hash($pass, PASSWORD_ARGON2I), PHP_EOL, mt_rand(1000000000, 9000000000);

var_dump(0 < 0);