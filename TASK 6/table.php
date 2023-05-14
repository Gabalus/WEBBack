<head>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<style>
  .error {
    border: 2px solid red;
  }
  table {
  text-align: center;
  border-spacing: 100px 0;
}
</style>
<body>
  <div class="table">
    <table>
      <tr>
        <th>Имя</th>
        <th>Почта</th>
        <th>Год</th>
        <th>Пол</th>
        <th>Кол-во конечностей</th>
        <th>Сверхсилы</th>
        <th>Био</th>
      </tr>
      <?php
      foreach($users as $user){
      ?>
            <tr>
              <td><?= $user['name']?></td>
              <td><?= $user['email']?></td>
              <td><?= $user['year']?></td>
              <td><?= $user['gender']?></td>
              <td><?= $user['limbs']?></td>
              <td><?php 
                $user_ability=array(
                    "1"=>FALSE,
                    "2"=>FALSE,
                    "3"=>FALSE,
					"4"=>FALSE
                );
                foreach($pwrs as $pwr){
                    if($pwr['application_id']==$user['id']){
                        if($pwr['ability_id']=='1'){
                            $user_ability['1']=TRUE;
                        }
                        if($pwr['ability_id']=='2'){
                            $user_ability['2']=TRUE;
                        }
                        if($pwr['ability_id']=='3'){
                            $user_ability['3']=TRUE;
                        }
						if($pwr['ability_id']=='4'){
                            $user_ability['4']=TRUE;
                        }
                    }
                }
				if($user_ability['1']){echo 'None<br>';}
                if($user_ability['2']){echo 'Immortality<br>';}
                if($user_ability['3']){echo 'Invisibility<br>';}
                if($user_ability['4']){echo 'Levitation<br>';}?>
              </td>
              <td><?= $user['biography']?></td>
              <td>
                <form method="get" action="edit.php">
                  <input name=edit_id value="<?= $user['id']?>" hidden>
                  <input type="submit" value=Edit>
                </form>
              </td>
            </tr>
      <?php
       }
      ?>
    </table>
    <?php
	printf('None: %d <br>',$ability_count[0]);
    printf('Immortality: %d <br>',$ability_count[1]);
    printf('Invisibility: %d <br>',$ability_count[2]);
    printf('Levitation: %d <br>',$ability_count[3]);
    ?>
  </div>
</body>
