<?php include "assets/components/header.php" ?>
<?php
if (isset($_GET["fid"])) {
  $id = $_GET["fid"];
  $delete_form = delete_form_by_id($id);
  if ($delete_form === 404) {
    echo '
        <script>
          Swal.fire({
            title: "Gagal!",
            text: "ID tidak ditemukan!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
        </script>
      ';
  } elseif ($delete_form === 500) {
    echo '
        <script>
          Swal.fire({
            title: "Gagal!",
            text: "Gagal menghapus form!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
        </script>
      ';
  } elseif ($delete_form === 200) {
    echo '
        <script>
          Swal.fire({
            title: "Success!",
            text: "Berhasil menghapus form!",
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
