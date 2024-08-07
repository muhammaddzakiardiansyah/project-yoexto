<?php include "assets/components/header.php" ?>
<?php

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $csrf_token_in_session = $_SESSION["csrf_token"] ?? "";
  $csrf_token_on_input = $_POST["csrf_token"] ?? "";
  if ($csrf_token_on_input !== $csrf_token_in_session) {
    unset($_SESSION["csrf_token"]);
    $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
    echo '
      <script>
        Swal.fire({
          title: "Failed!",
          text: "CSRF Token incorret!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
      </script>
    ';
  } else {
    unset($_SESSION["csrf_token"]);
    $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
    $login = login($_POST);
    if ($login === 404) {
      echo '
      <script>
        Swal.fire({
          title: "Failed!",
          text: "Username not found!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
      </script>
    ';
    } elseif ($login === 400) {
      echo '
      <script>
        Swal.fire({
          title: "Failed!",
          text: "Username or Password incorret!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
      </script>
    ';
    } elseif ($login === 200) {
      echo '
      <script>
        Swal.fire({
          title: "Success!",
          text: "Authentication successfuly!",
          icon: "success",
          showConfirmButton: false,
          timer: 2500,
        });
        setTimeout(() => {
          document.location.href = "/";
        }, 2500);
      </script>
    ';
    }
  }
}

?>
<div class="container">
  <div class="row section-login d-flex justify-content-center align-items-center">
    <div class="col-lg-5">
      <div class="card">
        <h3 class="mb-3 text-secondary semibold-header">Login</h3>
        <form action="" id="login" class="font-primary regular-header" method="post">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?? "" ?>">
          <div class="mb-3">
            <label for="username" class="form-label text-secondary regular-header">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label text-secondary regular-header">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            <p class="text-secondary reguler-header mt-3"><input type="checkbox" class="form-check-input mr-2" id="seePassword"> See Password</p>
          </div>
          <button type="submit" class="btn btn-danger mt-4 text-white medium-header">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  const inputPassword = document.getElementById("password");
  const togglePassword = document.getElementById("seePassword");
  togglePassword.addEventListener("change", () => {
    inputPassword.getAttribute("type") === "password" ? inputPassword.setAttribute("type", "text") : inputPassword.setAttribute("type", "password");
  });

  $().ready(() => {
    $("#login").validate({
      rules: {
        username: {
          required: true,
          minlength: 5,
        },
        password: {
          required: true,
          minlength: 8,
        },
      },
      messages: {
        username: {
          required: "Username tidak boleh kosong!",
          minlength: "Username wajib memiliki panjang 5 karakter",
        },
        password: {
          required: "Password tidak boleh kosong!",
          minlength: "Password wajib memiliki panjang 8 karakter",
        },
      },
    });
  });
</script>
<?php include "assets/components/footer.php" ?>