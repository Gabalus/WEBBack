<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
$user = 'u53001';
$pass = '5486130';
$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  $password=array();
  try{
    $get=$db->prepare("select password from admins where login=?");
    $get->execute(array('admin'));
    $password=$get->fetchAll()[0][0];
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
  }
  
  if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_PW'] != $password) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  if(!empty($_COOKIE['del'])){
    echo 'Пользователь '.$_COOKIE['del_user'].' удален <br>';
    setcookie('del','',100000);
    setcookie('del_user','',100000);
  }
  print('Вы авторизированы');
  $users=array();
  $pwrs=array();
  $ability_array=array('1','2','3','4');
  $ability_count=array();
  try{
    $app=$db->prepare("select * from application");
    $app->execute();
    $users=$app->fetchALL();
    $form1=$db->prepare("select ability_id,application_id from ability_application");
    $form1->execute();
    $pwrs=$form1->fetchALL();
    $count=$db->prepare("select count(*) from ability_application where ability_id=?");
    foreach($ability_array as $pwr){
      $count->execute(array($pwr));
      $ability_count[]=$count->fetchAll()[0][0];
    }
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
    exit();
  }
  include('table.php');
}
else{
  header('Location: admin.php');
}

