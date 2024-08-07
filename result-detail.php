<?php include "assets/components/header.php" ?>
<?php include "assets/components/navbar.php" ?>

<?php
if(isset($_GET["fid"])) {
  $id = $_GET["fid"];
  $form_expression = get_form_by_id($id);
  if($form_expression == new stdClass()) {
    echo "gaada";
  } else {
    $answers_form_expressions = get_answers_form_expression_by_slug($form_expression->slug);
  }
}
?>
<div class="container">
  <div class="row">
    <div class="col-lg-12 mt-5">
      <div class="card mt-5">
        <div class="card-body table-responsive">
          <h3 class="text-secondary semibold-header mb-4">Form hari <?= $form_expression->day ?? 'kosong' ?> Tanggal <?php $date = DateTime::createFromFormat("Y-m-d H:i:s", $form_expression->date ?? "0000-00-00 00:00:00");
                                                              echo $date->format("d M Y") ?></h3>
          <table class="table table-hover font-primary text-secondary">
            <thead>
              <tr>
                <th scope="col">Absen</th>
                <th scope="col">Nama</th>
                <th scope="col">NIS</th>
                <th scope="col">Expresi hari ini</th>
                <th scope="col">Alasannya</th>
                <th scope="col">Target</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($answers_form_expressions)) : ?>
                <?php foreach ($answers_form_expressions as $afx) : ?>
                  <tr>
                    <th class="regular-header" scope="row"><?= $afx["absen"] ?></th>
                    <td class="regular-header"><?= $afx["name"] ?></td>
                    <td class="regular-header"><?= $afx["nis"] ?></td>
                    <td class="regular-header"><?= base64_decode($afx["expression"]) ?></td>
                    <td class="regular-header"><?= base64_decode($afx["because"]) ?></td>
                    <td class="regular-header"><?= base64_decode($afx["target"]) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="6" class="text-center text-secondary medium-header">Tidak ada</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <a href="result" class="btn btn-danger text-white medium-header mt-5">Kembali</a>
</div>
<?php include "assets/components/footer.php" ?>