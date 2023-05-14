<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    setcookie('fio', '', 100000);
    setcookie('mail_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('sex_value', '', 100000);
    setcookie('limb_value', '', 100000);
    setcookie('bio_value', '', 100000);
    setcookie('ability', '', 100000);

  }
  //Ошибки
  
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
  $user = 'u53001';
$pass = '5486130';
$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  try{
      $id=$_GET['edit_id'];
	  var_dump($_GET['edit_id']);
      $get=$db->prepare("select * from application where id=?");
      $get->execute(array($id));
      $user=$get->fetchALL();
      $values['fio']=$user[0]['name'];
      $values['email']=$user[0]['email'];
      $values['year']=$user[0]['year'];
      $values['gender']=$user[0]['gender'];
      $values['bodyparts']=$user[0]['limbs'];
      $values['bio']=$user[0]['biography'];
      $get2=$db->prepare("select ability_id from ability_application where application_id=?");
      $get2->execute(array($id));
      $pwrs=$get2->fetchALL();

	  $temp=array(0=>empty($pwrs[0]['ability_id'])?null:$pwrs[0]['ability_id'],1=>empty($pwrs[1]['ability_id'])?null:$pwrs[1]['ability_id'],2=>empty($pwrs[2]['ability_id'])?null:$pwrs[2]['ability_id'],3=>empty($pwrs[3]['ability_id'])?null:$pwrs[3]['ability_id']);
      $values['ability'] = $temp;
  }
  catch(PDOException $e){
      print('Error: '.$e->getMessage());
      exit();
  }
  include('editform.php');
}
else {
  if(!empty($_POST['edit'])){
	$id=$_POST['id'];
    $name=$_POST['fio'];
    $email=$_POST['email'];
    $year=$_POST['year'];
    $sex=$_POST['gender'];
    $limb=$_POST['bodyparts'];
    $bio=$_POST['bio'];
	$pwrs=$_POST['ability'];
    $user = 'u53001';
$pass = '5486130';
$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $upd=$db->prepare("update application set name=?,email=?,year=?,gender=?,limbs=?,biography=? where id=?");
        $upd->execute(array($name,$email,$year,$sex,$limb,$bio,$id));
        $del=$db->prepare("delete from ability_application where application_id=?");
        $del->execute(array($id));
        $upd=$db->prepare("insert into ability_application set ability_id=?,application_id=?");
	  foreach ($pwrs as $ability) {
		$upd->execute([$ability,$id]);
	  }
    
    header('Location: edit.php?edit_id='.$id);
  }
  elseif(!empty($_POST['del'])) {
    $id=$_POST['id'];
    $user = 'u53001';
$pass = '5486130';
$db = new PDO('mysql:host=localhost;dbname=u53001', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    try {
      $del=$db->prepare("delete from ability_application where application_id=?");
      $del->execute(array($id));
	  $del1=$db->prepare("delete from users where application_id=?");
      $del1->execute(array($id));
      $stmt = $db->prepare("delete from application where id=?");
      $stmt -> execute(array($id));
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
    exit();
    }
    setcookie('del','1');
    setcookie('del_user',$id);
    header('Location: admin.php');
  }
  else{
    header('Loction: admin.php');
  }
}
