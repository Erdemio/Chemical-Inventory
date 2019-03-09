<?php
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.
class db_query
{

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
                  $q = mysql_query("select name, formula,n_name from kimyasal GROUP BY n_name;");
                  if($q){
                    while($row = mysql_fetch_assoc($q)){
                      //buraya akordiyon olarak firma isimleri ekliyebilirsin
                      echo "<tr>
                              <td>".$row['name']."</td>
                              <td>".$row['formula']."</td>
                              <td><a href=\"#\" data-position=\"left\" data-tooltip=\"Görüntüle\" class=\"waves-effect waves-light btn tooltipped\"><i class='material-icons'>open_in_new</i></a> <a href=\"edit?n_name=".$row['n_name']."\" data-position=\"right\" data-tooltip=\"Düzenle\"  class=\"waves-effect waves-light btn tooltipped\"><i class='material-icons'>forward</i></a></td>
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
              $q = mysql_query("select name, formula,n_name from kimyasal WHERE `manufacturer` LIKE '%$search%' GROUP BY n_name;");
            }else if($canon=="k"){
              $q = mysql_query("select name, formula,n_name from kimyasal WHERE `name` LIKE '%$search%' GROUP BY n_name;");
            }
            if($q){
              while($row = mysql_fetch_assoc($q)){
                echo "<tr class=\"searched\">
                        <td>".$row['name']."</td>
                        <td>".$row['formula']."</td>
                        <td><a href=\"#\" data-position=\"left\" data-tooltip=\"Görüntüle\" class=\"waves-effect waves-light btn tooltipped\"><i class='material-icons'>open_in_new</i></a> <a href=\"edit?n_name=".$row['n_name']."\" data-position=\"right\" data-tooltip=\"Düzenle\"  class=\"waves-effect waves-light btn tooltipped\"><i class='material-icons'>forward</i></a></td>
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
