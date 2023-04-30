<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['bodyparts'] = !empty($_COOKIE['bodyparts_error']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);

  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните email.</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Заполните год.</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['bodyparts']) {
    setcookie('bodyparts_error', '', 100000);
    $messages[] = '<div class="error">Заполните кол-во конечностей.</div>';
  }
  if ($errors['ability']) {
    setcookie('ability_error', '', 100000);
    $messages[] = '<div class="error">Заполните суперспособность.</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['bodyparts'] = empty($_COOKIE['bodyparts_value']) ? '' : $_COOKIE['bodyparts_value'];
  $values['ability'] = empty($_COOKIE['ability_value']) ? array() : json_decode($_COOKIE['ability_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];

  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  setcookie('fio_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['email']) || !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i', $_POST['email'])) {
  setcookie('email_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  setcookie('year_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['gender']) || ($_POST['gender']!='m' && $_POST['gender']!='f')) {
  setcookie('gender_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
else {
  setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
}
if (empty($_POST['bodyparts']) || ($_POST['bodyparts']!='2' && $_POST['bodyparts']!='3' && $_POST['bodyparts']!='4')) {
   setcookie('bodyparts_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
}
else {
  setcookie('bodyparts_value', $_POST['bodyparts'], time() + 30 * 24 * 60 * 60);
}

foreach ($_POST['ability'] as $ability) {
  if (!is_numeric($ability) || !in_array($ability, [1, 2, 3, 4])) {
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
    break;
  }
}
if (!empty($_POST['ability'])) {
  setcookie('ability_value', json_encode($_POST['ability']), time() + 24 * 60 * 60);
}

if (empty($_POST['bio']) || !preg_match('/^[0-9A-Za-z0-9А-Яа-я,\.\s]+$/', $_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}
else {
  setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
}

if ($errors) {
  exit();
}

$user = 'u53001';
$pass = '5486130';
$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, year = ?, gender = ?, bodyparts = ?, biography = ?");
  $stmt->execute([$_POST['fio'], $_POST['email'], $_POST['year'], $_POST['gender'], $_POST['bodyparts'], $_POST['bio']]);
  $app_id = $db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO ability_application SET application_id = ?, ability_id=?");
  foreach ($_POST['ability'] as $ability) {
    $stmt->execute([$app_id,$ability ]);
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');
