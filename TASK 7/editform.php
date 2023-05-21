<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>Task 6	</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>

<div id = "form">

  <form action="edit.php"
    method="POST">

    <label>
      Имя:<br />
      <input name="fio"
      <?php print($errors['fio'] ? 'class="error"' : '');?> value="<?php print $values['fio'];?>"/>
    </label><br />

    <label >
      Мыло:<br />
      <input name="email"
        type="email"
        <?php print($errors['email'] ? 'class="error"' : '');?> value="<?php print $values['email'];?>"/>
    </label><br />

    <label>
      ДР<br />
      <select name="year">
        <?php 
        for ($i = 1000; $i <= 2022; $i++) {
          $selected= ($i == $values['year']) ? 'selected="selected"' : '';
          printf('<option value="%d" %s>%d год</option>', $i, $selected, $i);
        }
        ?>
      </select><br />

      Пол<br/>
    <label><input type="radio" checked="checked"
      name="gender" value="m" 
      <?php print($errors['gender'] ? 'class="error"' : '');?>
      <?php if ($values['gender']=='m') print 'checked';?>
      />
      Мужской</label>
    <label><input type="radio"
      name="gender" value="f" 
      <?php print($errors['gender'] ? 'class="error"' : '');?>
      <?php if ($values['gender']=='f') print 'checked';?>
      />
      Женский</label><br />
      Конечностей<br/>
    <label><input type="radio" checked="checked"
      name="bodyparts" value="2" 
      <?php print($errors['bodyparts'] ? 'class="error"' : '');?>
      <?php if ($values['bodyparts']=='2') print 'checked';?>
      />
      2</label>
    <label><input type="radio"
      name="bodyparts" value="3" 
      <?php print($errors['bodyparts'] ? 'class="error"' : '');?>
      <?php if ($values['bodyparts']=='3') print 'checked';?>
      />
      3</label><br />
    <label><input type="radio"
      name="bodyparts" value="4" 
      <?php print($errors['bodyparts'] ? 'class="error"' : '');?>
      <?php if ($values['bodyparts']=='4') print 'checked';?>
      />
      4</label><br />
    <label>
      СуперСила
      <br />
      <select name="ability[]"
          multiple="multiple" <?php print($errors['ability'] ? 'class="error"' : '');?>>
          <option value="1" <?php print(in_array('1', $values['ability']) ? 'selected ="selected"' : '');?>>none</option>
          <option value="2" <?php print(in_array('2', $values['ability']) ? 'selected ="selected"' : '');?>>immortality</option>
          <option value="3" <?php print(in_array('3', $values['ability']) ? 'selected ="selected"' : '');?>>invisibility</option>
          <option value="4" <?php print(in_array('4', $values['ability']) ? 'selected ="selected"' : '');?>>levitation</option>
      </select>
      </label><br />
      <label>
      Биография<br />
        <textarea name="bio"
        <?php print($errors['bio'] ? 'class="error"' : '');?>><?php print $values['bio'];?></textarea>
        </label><br />
        
          <input name='id' hidden value=<?php print($_GET['edit_id']);?>>
    <input type="submit" name='edit' value="Изменить"/>
    <input type="submit" name='del' value="Удалить"/>
	  
    </form>
  </div>
    <form action="admin.php" method="POST">
    <input type="submit" name="back" value="Назад">
  </form>
</body>
