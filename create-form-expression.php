<?php include "assets/components/header.php" ?>
<?php include "assets/components/navbar.php" ?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    $create_form_expression = create_form_expression($_POST);
    if ($create_form_expression === 404) {
      echo '
      <script>
        Swal.fire({
          title: "Failed!",
          text: "User not found!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
      </script>
    ';
    } elseif ($create_form_expression === 500) {
      echo '
      <script>
        Swal.fire({
          title: "Failed!",
          text: "Failed create form expression!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
      </script>
    ';
    } elseif ($create_form_expression === 400) {
      echo '
      <script>
        Swal.fire({
          title: "Failed!",
          text: "Form expression has created!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
      </script>
    ';
    } elseif ($create_form_expression === 201) {
      echo '
      <script>
        Swal.fire({
          title: "Success!",
          text: "Success create form expression!",
          icon: "success",
          showConfirmButton: false,
          timer: 2500,
        });
        setTimeout(() => {
          document.location.href = "result";
        }, 2500);
      </script>
    ';
    }
  }
}

?>

<div class="container">
  <div class="row mx-auto">
    <div class="col-lg-10 mx-auto mt-5">
      <div class="card mt-5">
        <h3 class="mb-3 text-secondary semibold-header">Create form expression</h3>
        <form action="" id="create-form-expression" class="font-primary regular-header" method="post">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
          <input type="hidden" name="user_id" value="<?= $_SESSION["user_login"]["id"] ?>">
          <div class="mb-3">
            <label for="day" class="form-label text-secondary regular-header">Day</label>
            <input type="text" name="day" id="day" class="form-control">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label text-secondary regular-header">Date</label>
            <input type="date" class="form-control" name="date" id="date">
          </div>
          <div class="mb-3">
            <label for="caption" class="form-label text-secondary regular-header">Caption</label>
            <textarea class="form-control" name="caption" id="caption" rows="4" placeholder="Enter Caption"></textarea>
          </div>
          <button type="submit" class="btn btn-danger mt-4 text-white medium-header">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  const inputDay = document.getElementById("day");

  function getDay() {
    const date = new Date();
    switch (String(date.getDay())) {
      case "1":
        arguments
        return "Senin";
        break;
      case "2":
        arguments
        return "Selasa";
        break;
      case "3":
        arguments
        return "Rabu";
        break;
      case "4":
        arguments
        return "Kamis";
        break;
      case "5":
        arguments
        return "Jumat";
        break;
      case "6":
        arguments
        return "Sabtu";
        break;
      case "7":
        arguments
        return "Ahad";
        break;
    }
  }
  inputDay.value = getDay();
  const inputDate = document.getElementById("date");

  function getDate() {
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
  date.value = getDate();

  $().ready(() => {
    $("#create-form-expression").validate({
      rules: {
        day: {
          required: true,
        },
        date: {
          required: true,
        },
        caption: {
          required: true,
        },
      },
      messages: {
        day: {
          required: "Hari tidak boleh kosong!",
        },
        date: {
          required: "Tanggal tidak boleh kosong!",
        },
        caption: {
          required: "Caption tidak boleh kosong!",
        },
      },
    });
  });
</script>
<?php include "assets/components/footer.php" ?>