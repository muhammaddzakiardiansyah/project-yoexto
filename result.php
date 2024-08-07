<?php include "assets/components/header.php" ?>
<?php include "assets/components/navbar.php" ?>
<?php
if(isset($_POST["btn-limit"])) {
  $form_expressions = get_all_form_expression($_POST["limit"]);
} else {
  $form_expressions = get_all_form_expression();
}
?>
<div class="container">
  <div class="row">
    <div class="col-lg-8 mt-5">
      <form action="" class="mt-5" method="post">
        <label for="limit" class="text-secondary medium-header">Limit</label>
        <input type="number" class="w-10" name="limit" id="limit">
        <button type="submit" name="btn-limit">Ok</button>
      </form>
    </div>
    <div class="col-lg-12">
      <?php if ($form_expressions !== []) : ?>
        <?php foreach ($form_expressions as $fx) : ?>
          <div class="card mt-4">
            <a href="result-detail.php?fid=<?= $fx["id"] ?>" class="text-decoration-none">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div class="title">
                  <h3 class="text-secondary semibold-header">Form expression hari <span class="text-danger"><?= $fx["day"] ?></span></h3>
                  <p class="text-secondary medium-header">Tanggal <?php $date = DateTime::createFromFormat("Y-m-d H:i:s", $fx["date"]);
                                                                  echo $date->format("d M Y") ?></p>
                </div>
                <a onclick="return confirm('Yakin ingin menghapus form ini?')" href="delete-form-expression.php?fid=<?= $fx["id"] ?>" class="btn btn-secondary"><i class="bi bi-trash3 text-danger"></i></a>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="card mt-5">
          <div class="card-body">
            <h4 class="text-secondary medium-header">Belum ada form ekspresi yang dibuat</h4>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include "assets/components/footer.php" ?>