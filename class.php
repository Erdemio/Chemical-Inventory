<?php
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.
class db_query
{

  function get_autocomplete_data($chosen){
    if ($chosen=="chemical_names") {
      $q = mysql_query("SELECT * FROM `chemical_names`");
      $row_count= mysql_num_rows($q);
      $count = 0;
      while($row = mysql_fetch_assoc($q)){

        if ($count < $row_count-1) {
          echo "\"".$row['name']."\": null, ";
        }else{
          echo "\"".$row['name']."\": null";
        }
        $count += 1;
      }
    }else if ($chosen=="manufacturer_names") {
      $q1 = mysql_query("SELECT * FROM `manufacturer_names`");
      $row_count1= mysql_num_rows($q1);
      $count2 = 0;
      while($row = mysql_fetch_assoc($q1)){

        if ($count2 < $row_count1-1) {
          echo "\"".$row['manufacturer']."\": null, ";
        }else{
          echo "\"".$row['manufacturer']."\": null";
        }
        $count2 += 1;
      }
    }

  }
  function get_data($auth_full){
    $auth_full = $this->clear($auth_full);
    $q = mysql_query("SELECT level FROM `user` WHERE `user_auth` = '$auth_full'");
    if($q){
      while($row = mysql_fetch_assoc($q)){
        $level = $row['level'];
      }
      if($level > 1){
        echo '
          <div class="col m12 s12 l9 iomr">
            <div class="card card-wns">
                <table id="kimyasal-liste" class="highlight centered">
                  <thead>
                    <tr>
                        <th>Kimyasal Adı</th>
                        <th>Kimyasal Formülü</th>
                        <th class="no-sort">Aksiyonlar</th>
                    </tr>
                  </thead>

                  <tbody>';
                  $q = mysql_query("select name,formula,n_name,n_formula,unique_id from kimyasal GROUP BY n_name ORDER BY name ASC;");
                  if($q){
                    while($row = mysql_fetch_assoc($q)){
                      //buraya akordiyon olarak firma isimleri ekliyebilirsin
                      echo "<tr>
                              <td>".$row['name']."</td>
                              <td>".$row['formula']."</td>
                              <td>
                              <a href=\"msds.php?id=".$row['n_name']."\" data-position=\"bottom\" data-tooltip=\"Malzeme Güvenlik Bilgi Formu'nu görüntüle.\" target=\"_blank\"  class=\"waves-effect waves-light btn tooltipped\">MGBF</a>
                              <a href=\"#list\" onclick=\"getDataLi('".$row['n_name']."');\" data-position=\"bottom\" data-tooltip=\"Kimyasalı görüntüle & düzenle.\" class=\"waves-effect waves-light btn tooltipped modal-trigger\"><i class='material-icons'>edit</i></a></td>
                            </tr>";
                    }
                  }
              echo '</tbody>
                </table>
            </div>
        </div>';
        return true;
      }else{
        echo '<div class="row">
          <div class="col m12">
          <h1 class="center">Yetersiz yetkiye sahipsiniz.</h1>
          </div></div>';
          return false;
      }
    }
  }
  function get_data_with_parameters($canon,$search,$auth){
    $canon = $this->clear($canon);
    $search = $this->clear($search);
    $auth = $this->clear($auth);

    $q = mysql_query("SELECT level FROM `user` WHERE `user_auth` = '$auth'");
    if($q){
      while($row = mysql_fetch_assoc($q)){
        $level = $row['level'];
      }
      if(@$level > 1){
        if($canon=="" || $search==""){
          echo "empty-data";
        }
        else{
            if($canon=="f"){
              $q = mysql_query("select name, formula,n_name,unique_id from kimyasal WHERE `manufacturer` LIKE '%$search%' GROUP BY n_name;");
            }else if($canon=="k"){
              $q = mysql_query("select name, formula,n_name,unique_id  from kimyasal WHERE `name` LIKE '%$search%' GROUP BY n_name;");
            }
            if($q){
              while($row = mysql_fetch_assoc($q)){
                echo "<tr class=\"searched\">
                        <td>".$row['name']."</td>
                        <td>".$row['formula']."</td>
                        <td>
                        <a href=\"msds.php?id=".$row['n_name']."\" data-position=\"bottom\" data-tooltip=\"Malzeme Güvenlik Bilgi Formu'nu görüntüle.\" target=\"_blank\"  class=\"waves-effect waves-light btn tooltipped\">MGBF</a>
                        <a href=\"#list\" onclick=\"getDataLi('".$row['n_name']."');\" data-position=\"bottom\" data-tooltip=\"Kimyasalı görüntüle & düzenle.\" class=\"waves-effect waves-light btn tooltipped modal-trigger\"><i class='material-icons'>edit</i></a></td>
                      </tr>";
              }
              if(mysql_num_rows($q)<1){
                echo "not-found";
              }
            }else{
              echo "not-found";
            }
        }
      }else{
        echo 'level-error';
      }
    }
  }
  function get_data_li($cname,$auth){
    $cname = $this-> clear($cname);
    $auth = $this-> clear($auth);

    if ($this->check_level($auth)>1) {
      $f = 0;
      $q = mysql_query("SELECT * FROM `kimyasal` WHERE `n_name` = $cname ORDER BY `entry_date` DESC");
      if (mysql_num_rows($q)>0) {
          while ($row = mysql_fetch_assoc($q)) {
          if ($f==0) {
            echo '<li class="collection-header"><h4>'.$row['name'].'</h4></li>';
          }

                echo '
                      <li class="collection-item">
                        <div>
                          <p>
                            Formülü: '.$row['formula'].'
                            <br>
                            Üretici Firma: '.$row['manufacturer'].'
                            <br>
                            Miktar: '.$row['quantity'].'
                            <br>
                            Adet: '.$row['stock'].'
                            <br>
                            Giriş Tarihi: '.$row['entry_date'].'
                            <br>
                            <a href="edit.php?id='.$row['unique_id'].'" class="secondary-content btn flat-btn"><i class="material-icons">edit</i></a>
                            <br>
                          </p>
                        </div>
                      </li>';
                      $f++;
            }

      }





    }
  }

  function get_msds($id){
    $id = $this->clear($id);

    $q = mysql_query("SELECT * FROM `msds` WHERE `n_id` = $id");
    if(mysql_num_rows($q)>0){
        while ($row = mysql_fetch_assoc($q)) {
          echo $row['msds'];
        }
        return true;
    }else{
      return false;
    }

  }

  /* Ekleme İşlemleri */
  function insert_chemical($ka,$formula,$uf,$m,$a,$gt,$author,$msds){
    $ka =       $this->clear($ka);
    $formula =  $this->clear($formula);
    $uf =       $this->clear($uf);
    $m =        $this->clear($m);
    $a =        $this->clear($a);
    $gt =       $this->clear($gt);
    $author =   $this->clear($author);
    $state = "false";

    if ($this->check_level($author)>1) {
    //varsa al yoksa ben yazıyorum.
    $q_kimyasal_adi = mysql_query("SELECT `n_name` FROM `chemical_names` WHERE `name` = '$ka'");
    if (mysql_num_rows($q_kimyasal_adi)>0) {
      while ($row = mysql_fetch_assoc($q_kimyasal_adi)) {
        $ka = $row['n_name'];
      }
    }else{
      $insert = mysql_query("INSERT INTO `chemical_names` (`n_name`, `name`) VALUES (NULL, '$ka');");
      if ($insert) {
        $find = mysql_query("SELECT `n_name` FROM `chemical_names` WHERE `name` = '$ka'");
        while ($row = mysql_fetch_assoc($find)) {
          $ka = $row['n_name'];
        }
      }
    }

    $q_uretici_firma = mysql_query("SELECT `n_manufacturer` FROM `manufacturer_names` WHERE `manufacturer` = '$uf'");
    if (mysql_num_rows($q_uretici_firma)>0) {
      while ($row = mysql_fetch_assoc($q_uretici_firma)) {
        $uf = $row['n_manufacturer'];
      }
    }else{
      $insert = mysql_query("INSERT INTO `manufacturer_names` (`n_manufacturer`, `manufacturer`) VALUES (NULL, '$uf')");
      if ($insert) {
        $find = mysql_query("SELECT `n_manufacturer` FROM `manufacturer_names` WHERE `manufacturer` = '$uf'");
        while ($row = mysql_fetch_assoc($find)) {
          $uf = $row['n_manufacturer'];
        }
      }
    }

    $q_formula = mysql_query("SELECT * FROM `chemical_formula` WHERE `formula` = '$formula'");

    if (mysql_num_rows($q_formula)>0) {
      while ($row = mysql_fetch_assoc($q_formula)) {
        $formula = $row['n_formula'];
      }
    }else{
      $insert = mysql_query("INSERT INTO `chemical_formula` (`n_formula`, `formula`) VALUES (NULL, '$formula')");
      if ($insert) {
        $find = mysql_query("SELECT `n_formula` FROM `chemical_formula` WHERE `formula` = '$formula'");
        while ($row = mysql_fetch_assoc($find)) {
          $formula = $row['n_formula'];
        }
      }
    }

    $new_date = explode("-",$gt);
    $date = @$new_date[2].'-'.@$new_date[1].'-'.@$new_date[0];

    $q_id = mysql_query("SELECT `id`,`level` FROM `user` WHERE `user_auth` = '$author'");
    $id_count = mysql_num_rows($q_id);

    if ($id_count) {
      while ($row = mysql_fetch_assoc($q_id)) {
        $id = $row['id'];
        $perm = $row['level'];
      }
      if ($perm>1) {
        $chemical_insert = mysql_query("INSERT INTO `chemical` (`unique_id`, `n_name`, `n_formula`, `n_manufacturer`, `quantity`, `stock`, `entry_date`,`author`) VALUES (NULL, '$ka', '$formula', '$uf', '$m', '$a', '$date', $id);");
        if ($chemical_insert) {
          //ekleme başarılı
          $q = @mysql_query("SELECT * FROM `msds` WHERE `n_id` = $ka");
          if (mysql_num_rows($q)>0) {
            echo "71";
          }else{
            echo "70";
          }
        }
      }else{
        echo "8";
      }
    }else{
      echo "9";
    }

  }

  }

  function insert_msds($name,$file,$auth){
    $name = $this-> clear($name);
    $auth = $this-> clear($auth);

    if ($this->check_level($auth)>1) {

    $q= mysql_query("SELECT * FROM `chemical_names` WHERE `name` = '$name'");
    if (mysql_num_rows($q)>0) {
      while ($row = mysql_fetch_assoc($q)) {
        $temp = $row['n_name'];
      }

      $data = addslashes(file_get_contents($file['tmp_name']));

      $q = mysql_query("INSERT INTO `msds` (`id`, `n_id`, `msds`, `author`) VALUES (NULL, '$temp','$data', '$auth')");
      if($q){
          return "101";
      }else{
          return "102";
      }
    }
  }else{
    return "yetersiz_yetki";
  }

  }

  /* Güncelleme İşlemleri */
  function update_chemical($ka,$formula,$uf,$m,$a,$gt,$author,$msds){
    $ka =       $this->clear($ka);
    $formula =  $this->clear($formula);
    $uf =       $this->clear($uf);
    $m =        $this->clear($m);
    $a =        $this->clear($a);
    $gt =       $this->clear($gt);
    $author =   $this->clear($author);
    $state = "false";

    if ($this->check_level($author)>1) {
    //varsa al yoksa ben yazıyorum.
    $q_kimyasal_adi = mysql_query("SELECT `n_name` FROM `chemical_names` WHERE `name` = '$ka'");
    if (mysql_num_rows($q_kimyasal_adi)>0) {
      while ($row = mysql_fetch_assoc($q_kimyasal_adi)) {
        $ka = $row['n_name'];
      }
    }else{
      $insert = mysql_query("INSERT INTO `chemical_names` (`n_name`, `name`) VALUES (NULL, '$ka');");
      if ($insert) {
        $find = mysql_query("SELECT `n_name` FROM `chemical_names` WHERE `name` = '$ka'");
        while ($row = mysql_fetch_assoc($find)) {
          $ka = $row['n_name'];
        }
      }
    }

    $q_uretici_firma = mysql_query("SELECT `n_manufacturer` FROM `manufacturer_names` WHERE `manufacturer` = '$uf'");
    if (mysql_num_rows($q_uretici_firma)>0) {
      while ($row = mysql_fetch_assoc($q_uretici_firma)) {
        $uf = $row['n_manufacturer'];
      }
    }else{
      $insert = mysql_query("INSERT INTO `manufacturer_names` (`n_manufacturer`, `manufacturer`) VALUES (NULL, '$uf')");
      if ($insert) {
        $find = mysql_query("SELECT `n_manufacturer` FROM `manufacturer_names` WHERE `manufacturer` = '$uf'");
        while ($row = mysql_fetch_assoc($find)) {
          $uf = $row['n_manufacturer'];
        }
      }
    }

    $q_formula = mysql_query("SELECT * FROM `chemical_formula` WHERE `formula` = '$formula'");

    if (mysql_num_rows($q_formula)>0) {
      while ($row = mysql_fetch_assoc($q_formula)) {
        $formula = $row['n_formula'];
      }
    }else{
      $insert = mysql_query("INSERT INTO `chemical_formula` (`n_formula`, `formula`) VALUES (NULL, '$formula')");
      if ($insert) {
        $find = mysql_query("SELECT `n_formula` FROM `chemical_formula` WHERE `formula` = '$formula'");
        while ($row = mysql_fetch_assoc($find)) {
          $formula = $row['n_formula'];
        }
      }
    }

    $new_date = explode("-",$gt);
    $date = @$new_date[2].'-'.@$new_date[1].'-'.@$new_date[0];

    $q_id = mysql_query("SELECT `id`,`level` FROM `user` WHERE `user_auth` = '$author'");
    $id_count = mysql_num_rows($q_id);

    if ($id_count) {
      while ($row = mysql_fetch_assoc($q_id)) {
        $id = $row['id'];
        $perm = $row['level'];
      }
      if ($perm>1) {
        $chemical_insert = mysql_query("INSERT INTO `chemical` (`unique_id`, `n_name`, `n_formula`, `n_manufacturer`, `quantity`, `stock`, `entry_date`,`author`) VALUES (NULL, '$ka', '$formula', '$uf', '$m', '$a', '$date', $id);");
        if ($chemical_insert) {
          //ekleme başarılı
          $q = @mysql_query("SELECT * FROM `msds` WHERE `n_id` = $ka");
          if (mysql_num_rows($q)>0) {
            echo "71";
          }else{
            echo "70";
          }
        }
      }else{
        echo "8";
      }
    }else{
      echo "9";
    }

  }

  }
  function update_msds($name,$file,$auth){
    $name = $this-> clear($name);
    $auth = $this-> clear($auth);

      if ($this->check_level($auth)>1) {

        //id geldi gelen id ile veritabanında msds varmı bak varsa güncelle yoksa insertle!
        $q = mysql_query("SELECT * FROM `user` WHERE `user_auth` = '$auth'");
        if (mysql_num_rows($q)>0) {
          while ($row = mysql_fetch_assoc($q)) {
            $auth = $row['user_id'];
          }
        }
        ////
      $q = mysql_query("SELECT * FROM `msds` WHERE `n_id` = $name");
      if (mysql_num_rows($q)>0) {
            $data = addslashes(file_get_contents($file['tmp_name']));
            $q = mysql_query("UPDATE `msds` SET `msds`= '$data'  WHERE `msds`.`n_id` = $name;");
            if($q){
                return "101";
            }else{
                return "102";
            }
      }else{
        $data = addslashes(file_get_contents($file['tmp_name']));
        $q = mysql_query("INSERT INTO `msds` (`id`, `n_id`, `msds`, `author`) VALUES (NULL, '$name','$data', '$auth')");
        if($q){
            return "101";
        }else{
            return "102";
        }
      }


    }else{
      return "yetersiz_yetki";
    }


  }

  function id_to_n($id,$auth){
    $id = $this->clear($id);
    $auth = $this->clear($auth);
    if ($this->check_level($auth)>1) {
    $q = @mysql_query("SELECT `n_name` FROM `chemical` WHERE `unique_id` = $id");
    if (@mysql_num_rows($q)>0) {
      while ($row = mysql_fetch_assoc($q)) {
        return $row['n_name'];
      }
    }
    }
  }

  /* Güvenlik Prosedürleri */
  function check_auth($auth){
    $auth = $this->clear($auth);
    $q = mysql_query("SELECT COUNT(*) As adet FROM `user` WHERE `user_auth` = '$auth'");
    while($row = mysql_fetch_assoc($q)){
      $count = $row['adet'];
    }
    if(@$count>0){
      return true;
    }else{
      return false;
    }
  }
  function check_level($auth){
    $auth = $this->clear($auth);
    $q = mysql_query("SELECT level FROM `user` WHERE `user_auth` = '$auth'");
    while($row = mysql_fetch_assoc($q)){
      $level = $row['level'];
    }
    return $level;
  }

  private function clear($item){
    return htmlspecialchars($item, ENT_QUOTES);
  }

  private function algorithm($identy,$password,$time){
    return md5($identy+"SECRET"+$password+"SERVERSEED"+$time);
  }

  function register($identy,$password,$time){
    $auth = $this->algorithm($identy,$password,$time);
    $q = mysql_query("INSERT INTO `user` (`id`, `user_id`, `user_auth`, `user_login_time`) VALUES (NULL, '$identy', '$auth', '$time');");
    if(@$q){
      echo 'Register Successful';
    }else
    {
      echo 'Register error';
    }
  }

  function login($identy,$password){
    $q = mysql_query("SELECT user_login_time FROM `user` WHERE `user_id` = '$identy'");
    if($q){
      while($row = mysql_fetch_assoc($q)){
        $time = $row['user_login_time'];
      }
      if (@$time > 0) {
        $auth = $this->algorithm($identy,$password,@$time);
        $q2 = mysql_query("SELECT * FROM `user` WHERE `user_auth` = '$auth'");
        if($q2){
          while($row = mysql_fetch_assoc($q2)){
            $time2 = $row['user_login_time'];
            $uid = $row['user_id'];
          }
          if (@$time > 0) {
            if (@$time == @$time2) {
              $_SESSION['user']=$uid;
              $new_time = time();
              $new_auth = $this->algorithm($identy,$password,$new_time);
              $time_update = mysql_query("UPDATE `user` SET `user_login_time` = '$new_time', `user_auth` = '$new_auth' WHERE `user`.`user_id` = '$uid';");
              $_SESSION['auth'] = $new_auth;
              return true;
            }
          }else{
            return false;
          }
        }else{
          return false;
        }
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  /*Komutlar burada biter*/
  private function close() {
      $this->connection = @mysql_close($this->connection);
      if($this->connection) { return true ;} else { return false ;}
  }

  function __destruct() {
      $this->close();
  }

}

?>
