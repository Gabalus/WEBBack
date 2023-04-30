<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (!empty($_GET['save'])) {

    print('Спасибо, результаты сохранены.');
  }

  include('form.php');

  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u',$_POST['email'])) {
  print('Заполните email.<br/>');
  $errors = TRUE;
}

if (empty($_POST['gender']) || ($_POST['gender']!='m' && $_POST['gender']!='w')) {
  print('Заполните пол.<br/>');
  $errors = TRUE;
}
if (empty($_POST['limbs']) || ($_POST['limbs']!='1' && $_POST['limbs']!='2' && $_POST['limbs']!='3' && $_POST['limbs']!='4')) {
  print('Заполните количество конечностей.<br/>');
  $errors = TRUE;
}

if (empty($_POST['biography']) || !preg_match('/^([0-9a-zA-Zа-яА-Я\,\.\s]{1,})$/', $_POST['biography']) ){
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (!empty($_GET['save'])) {

    print('Спасибо, результаты сохранены.');
  }

  include('form.php');

  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u',$_POST['email'])) {
  print('Зфполните email.<br/>');
  $errors = TRUE;
}

if (empty($_POST['gender']) || ($_POST['gender']!='m' && $_POST['gender']!='w')) {
  print('Заполните пол.<br/>');
  $errors = TRUE;
}
if (empty($_POST['bodyparts']) || ($_POST['bodyparts']!='1' && $_POST['bodyparts']!='2' && $_POST['bodyparts']!='3' && $_POST['bodyparts']!='4')) {
  print('Заполните количество конечностей.<br/>');
  $errors = TRUE;
}

if (empty($_POST['bio']) || !preg_match('/^([0-9a-zA-Zа-яА-Я\,\.\s]{1,})$/', $_POST['bio']) ){
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}
if (empty($_POST['ability'])) {
  print('Заполните сферхспособности.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}

$user = 'u53001';
$pass = '5486130';
$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email=?, year=?, gender=?, biography=?, limbs=?");
 # var_dump($_POST);
  $stmt -> execute([$_POST['fio'], $_POST['email'],$_POST['year'],$_POST['gender'], $_POST['bio'],$_POST['bodyparts'] ]);
  $app_id = $db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO ability_application SET ability_id= ?, application_id=?");
  foreach ($_POST['ability'] as $ability) {
    $stmt->execute([$ability, $app_id]);
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');


#if ($errors) {
#  exit();
#}

#$user = 'u53001';
#$pass = '5486130';
#$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

#try {
#  $stmt = $db->prepare("INSERT INTO application SET name = ?, email=?, year=?, gender=?, bodyparts = ?, biography = ?");
 # $stmt -> execute([$_POST['fio'], $_POST['email'],$_POST['year'],$_POST['gender'], $_POST['bodyparts'],$_POST['bio'] ]);
#  $app_id = $db->lastInsertId();
#  $stmt = $db->prepare("INSERT INTO ability_application SET ability_id= ?, application_id=?");
#  foreach ($_POST['ability'] as $ability) {
#    $stmt->execute([$ability, $app_id]);
 # }
#}
#catch(PDOException $e){
#  print('Error : ' . $e->getMessage());
#  exit();
#}
#header('Location: ?save=1');
