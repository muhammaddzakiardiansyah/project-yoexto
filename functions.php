<?php

function get_user_by_id(int $id): object
{
  global $connection;

  $sql = $connection->prepare("SELECT * FROM users WHERE id = ?");
  $sql->bind_param("i", $id);
  $sql->execute();
  $result = $sql->get_result();
  if ($result->num_rows <= 0) {
    return new stdClass();
  } else {
    return $result->fetch_object();
  }
}

function login(array $data_login): int
{
  global $connection, $password_secret_key;

  $username = htmlspecialchars($data_login["username"]);
  $password = $data_login["password"];

  $sql = $connection->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
  $sql->bind_param("s", $username);
  $sql->execute();
  $result = $sql->get_result();
  if ($result->num_rows < 0) {
    return 404;
  } else {
    $data_result = $result->fetch_object();
    $password_key = $password . $password_secret_key;
    $verify_password = password_verify($password_key, $data_result->password);
    if (!$verify_password) {
      return 400;
    } else {
      $_SESSION["user_login"] = ["id" => $data_result->id, "login" => true, "username" => $data_result->username];
      $key_1 = base64_encode($data_result->id);
      $key_2 = base64_encode($data_result->username);
      setcookie("key_1", $key_1, time() + 86400, "/");
      setcookie("key_2", $key_2, time() + 86400, "/");
      return 200;
    }
  }
}

function create_form_expression(array $data_form_expression): int
{
  global $connection;

  $id = mt_rand(1000000000, 9000000000);
  $day = htmlspecialchars($data_form_expression["day"]);
  $date = $data_form_expression["date"];
  $caption = htmlspecialchars($data_form_expression["caption"]);
  $slug = $day . "-" . $date;
  $user_id = htmlspecialchars($data_form_expression["user_id"]);

  $sql = $connection->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
  $sql->bind_param("s", $user_id);
  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows < 0) {
    return 404;
  } else {
    $get_form = $connection->prepare("SELECT * FROM form_expressions WHERE slug = ? LIMIT 1");
    $get_form->bind_param("s", $slug);
    $get_form->execute();
    $result_get_from = $get_form->get_result();
    if($result_get_from->num_rows > 0) {
      return 400;
    } else {
      $stmt = $connection->prepare("INSERT INTO form_expressions (id, day, date, caption, slug) VALUE (?, ?, ?, ?, ?)");
      $stmt->bind_param("issss", $id, $day, $date, $caption, $slug);
  
      if ($stmt->execute()) {
        return 201;
      } else {
        return 500;
      }
    }
  }
}

function get_all_form_expression(string $limit = "6"): array
{
  global $connection;

  $sql = $connection->prepare("SELECT * FROM form_expressions ORDER BY date DESC LIMIT ?");
  $sql->bind_param("s", $limit);
  $sql->execute();
  $result = $sql->get_result();
  if ($result->num_rows <= 0) {
    return [];
  } else {
    $rows = [];
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }
}

function get_form_by_id(string $id): object
{
  global $connection;

  $sql = $connection->prepare("SELECT * FROM form_expressions WHERE id = ? ORDER BY created_at DESC LIMIT 1");
  $sql->bind_param("s", $id);
  $sql->execute();
  $result = $sql->get_result();
  return $result->fetch_object() ?? new stdClass();
}

function get_form_today(): object
{
  global $connection;

  $sql = $connection->prepare("SELECT * FROM form_expressions ORDER BY created_at DESC LIMIT 1");
  $sql->execute();
  $result = $sql->get_result();
  return $result->fetch_object() ?? new stdClass();
}

function delete_form_by_id(string $id): int
{
  global $connection;

  $get_form = $connection->prepare("SELECT * FROM form_expressions WHERE id = ? LIMIT 1");
  $get_form->bind_param("s", $id);
  $get_form->execute();
  $result_form = $get_form->get_result();
  if ($result_form->num_rows <= 0) {
    return 404;
  } else {
    $delete_answer = $connection->prepare("DELETE FROM answers_form_expressions WHERE form_expression_id = ?");
    $delete_answer->bind_param("s", $id);
    if ($delete_answer->execute()) {
      $delete_form = $connection->prepare("DELETE FROM form_expressions WHERE id = ?");
      $delete_form->bind_param("s", $id);
      if ($delete_form->execute()) {
        return 200;
      } else {
        return 500;
      }
    } else {
      return 500;
    }
  }
}

function create_answer_form_expression(array $data_answer_form_expression): int
{
  global $connection;

  $id = mt_rand(1000000000, 9000000000);
  $form_expression_id = intval(htmlspecialchars($data_answer_form_expression["form_expression_id"]));
  $nis = htmlspecialchars($data_answer_form_expression["nis"]);
  $expression = htmlspecialchars($data_answer_form_expression["expression"]);
  $because = htmlspecialchars($data_answer_form_expression["excuse"]);
  $target = htmlspecialchars($data_answer_form_expression["target"]);

  $expression_encrypted = base64_encode($expression);
  $because_encrypted = base64_encode($because);
  $target_encrypted = base64_encode($target);

  $sql = $connection->prepare("SELECT * FROM nis_students WHERE nis = ? LIMIT 1");
  $sql->bind_param("s", $nis);
  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows <= 0) {
    return 404;
  } else {
    $data_result = $result->fetch_object();

    $get_answer = $connection->prepare("SELECT * FROM answers_form_expressions WHERE form_expression_id = ? AND nis = ? LIMIT 1");
    $get_answer->bind_param("is", $form_expression_id, $nis);
    $get_answer->execute();
    $result_get_answer = $get_answer->get_result();

    if ($result_get_answer->num_rows <= 0) {
      $stmt = $connection->prepare("INSERT INTO answers_form_expressions (id, form_expression_id, nis, name, absen, expression, because, target) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("iississs", $id, $form_expression_id, $nis, $data_result->name, $data_result->absen, $expression_encrypted, $because_encrypted, $target_encrypted);

      if ($stmt->execute()) {
        return 201;
      } else {
        return 500;
      }
    } else {
      return 400;
    }
  }
}

function get_answers_form_expression_by_slug(string $slug): array
{
  global $connection;

  $sql = $connection->prepare("SELECT fx.day, fx.date, afx.nis, afx.name, afx.absen, afx.expression, afx.because, afx.target, afx.created_at FROM form_expressions as fx JOIN answers_form_expressions as afx ON fx.id = afx.form_expression_id WHERE fx.slug = ? ORDER BY afx.absen ASC");
  $sql->bind_param("s", $slug);
  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows <= 0) {
    return [];
  } else {
    $rows = [];
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }
}
