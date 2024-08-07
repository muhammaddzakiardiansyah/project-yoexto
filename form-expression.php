<?php include "assets/components/header.php" ?>
<?php

$form_today = get_form_today();

date_default_timezone_set("Asia/Jakarta");
$date = date("H:i");

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
    if ($_POST["date"] >= "09:00") {
      echo '
        <script>
          Swal.fire({
            title: "Gagal!",
            text: "Anda melebihi batas waktu untuk submit form!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
        </script>
      ';
    } else {
      $answers_form_expression = create_answer_form_expression($_POST);
      if ($answers_form_expression === 500) {
        echo '
        <script>
          Swal.fire({
            title: "Gagal!",
            text: "Anda gagal submit form!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
        </script>
      ';
      } elseif ($answers_form_expression === 404) {
        echo '
        <script>
          Swal.fire({
            title: "Gagal!",
            text: "NIS anda tidak terdaftar!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
        </script>
      ';
      } elseif ($answers_form_expression === 400) {
        echo '
        <script>
          Swal.fire({
            title: "Gagal!",
            text: "Anda sudah mengisi form ekpresi!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
        </script>
      ';
      } elseif ($answers_form_expression === 201) {
        echo '
        <script>
          Swal.fire({
            title: "Berhasil!",
            text: "Anda berhasil submit form!",
            icon: "success",
            showConfirmButton: false,
            timer: 2500,
          });
          setTimeout(() => {
            document.location.href = "submited";
          }, 2500);
        </script>
      ';
      }
    }
  }
}

?>
<div class="container">
  <div class="row mx-auto mt-5">
    <?php if($form_today != new stdClass()) : ?>
      <form action="" id="form-expression" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
        <input type="hidden" name="date" value="<?= $date ?>">
        <input type="hidden" name="form_expression_id" value="<?= $form_today->id ?>">
        <div class="col-lg-10 mx-auto">
          <div class="card mb-4">
            <div class="card-body">
              <h2 class="text-secondary semibold-header mb-3">Form Expression</h2>
              <h5 class="text-secondary medium-header"><?php $date = DateTime::createFromFormat("Y-m-d H:i:s", $form_today->date);
                                                        echo $form_today->day . ", " . $date->format("Y/m/d") ?></h5>
              <p class="text-secondary regular-header mt-4"><?= $form_today->caption ?></p>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="text-secondary semibold-header mb-3">NIS</h5>
              <input type="text" class="form-control" name="nis" id="nis" placeholder="Masukan NIS">
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="mb-3 text-secondary semibold-header">Bagaimana ekspresimu hari ini ?</h4>
              <div class="container mt-5">
                <div class="row">
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression1">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-grin fs-3"></i>
                              Bahagia Buanget
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression1" value="Bahagia Buanget">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression2">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-laughing fs-3"></i>
                              Bahagia
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression2" value="Bahagia" checked>
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression3">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-smile fs-3"></i>
                              B Aja
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression3" value="B Aja">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression4">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-neutral fs-3"></i>
                              Hmmmm
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression4" value="Hmmmm">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression5">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-sunglasses fs-3"></i>
                              Mengkerenn
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression5" value="Mengkerenn">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression6">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-angry fs-3"></i>
                              Sangat Marah
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression6" value="Sangat Marah">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression7">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-frown fs-3"></i>
                              Sedihh
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression7" value="Sedihh">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression8">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-smile-upside-down fs-3"></i>
                              Gua udah muakk
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression8" value="Gua udah muakk">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression9">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-tear fs-3"></i>
                              Cemas
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression9" value="Cemas">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression10">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-surprise fs-3"></i>
                              Ckp tw s
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression10" value="Ckp tw s">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression11">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-dizzy fs-3"></i>
                              Axsdefjy4hf
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression11" value="Axsdefjy4hf">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-3">
                    <div class="card card-expression">
                      <label for="expression12">
                        <div class="card-body">
                          <div class="d-flex align-items-center justify-content-between column-gap-2 text-secondary semibold-header">
                            <div class="emoji d-flex align-items-center column-gap-2">
                              <i class="bi bi-emoji-wink fs-3"></i>
                              Aku gapapa kok
                            </div>
                            <input type="radio" class="form-check-input" name="expression" id="expression12" value="Aku gapapa kok">
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="text-secondary semibold-header mb-3">Coba jelaskan alasanya</h5>
              <textarea class="form-control" name="excuse" id="excuse" rows="4" placeholder="Ceritakan disini"></textarea>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="text-secondary semibold-header mb-3">Apa targetmu hari ini?</h5>
              <textarea class="form-control" name="target" id="target" rows="4" placeholder="Tuliskan disini"></textarea>
            </div>
          </div>
          <div class="d-flex justify-content-end mb-5">
            <button class="btn btn-danger text-white medium-header" type="submit"><i class="bi bi-send"></i> Kirim</button>
          </div>
        </div>
      </form>
    <?php else : ?>
      <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
          <h4 class="text-secondary medium-header">Tidak ada form ekspresi hari ini</h4>
          <a href="/" class="btn btn-danger text-white medium-header">Kembali</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<script>
  $().ready(() => {
    $("#form-expression").validate({
      rules: {
        nis: {
          required: true,
          minlength: 7,
        },
        target: {
          required: true,
        }
      },
    });
  });
</script>
<?php include "assets/components/footer.php" ?>