<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>Task 3</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<div id = "form">

  <form action=""
    method="POST">

    <label>
      Имя:<br />
      <input name="fio"/>
    </label><br />

    <label >
      Мыло:<br />
      <input name="email"
        type="email"/>
    </label><br />

    <label>
      ДР<br />
      <select name="year">
        <?php 
        for ($i = 1000; $i <= 2023; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
        }
        ?>
      </select><br />

      Пол<br/>
    <label><input type="radio" checked="checked"
      name="gender" value="m" />
      Мужской</label>
    <label><input type="radio"
      name="gender" value="f" />
      Женский</label><br />
      Конечностей<br/>
    <label><input type="radio" checked="checked"
      name="bodyparts" value="2" />
      2</label>
    <label><input type="radio"
      name="bodyparts" value="3" />
      3</label><br />
    <label><input type="radio"
      name="bodyparts" value="4" />
      4</label><br />
    <label>
      СуперСила
      <br />
      <select name="ability[]"
          multiple="multiple">
          <option value="1" selected="selected">none</option>
          <option value="2">immortality</option>
          <option value="3">invisibility</option>
          <option value="4">levitation</option>
      </select>
      </label><br />
      <label>
      Биография<br />
        <textarea name="bio"></textarea>
        </label><br />
        
      <label><input type="checkbox"
        name="check" />
        Ознакомился</label>

      <input type="submit" value="Send" />
    </form>
  </div>
</body>
