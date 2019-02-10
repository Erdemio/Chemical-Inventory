<?php
class db_query
{

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
              $time_update = mysql_query("UPDATE `user` SET `user_login_time` = '$new_time' WHERE `user`.`user_id` = '$uid';");
              $time_update = mysql_query("UPDATE `user` SET `user_auth` = '$new_auth' WHERE `user`.`user_id` = '$uid';");
              $_SESSION['auth'] = $new_auth;
              return true;
            }
          }else{
            return "timeout";
          }
        }else{
          return "timeout";
        }
      }else{
        return "timeout";
      }
    }else{
      return "timeout";
    }
  }

  function check_auth($auth){
      $auth = $this->clear($auth);
      $q = mysql_query("SELECT COUNT(*) As adet FROM `user` WHERE `user_auth` = '$auth'");
      while($row = mysql_fetch_assoc($q)){
        $count = $row['adet'];
      }
      if($count>0){
        return true;
      }else{
        return false;
      }
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
      //http://localhost/register.php?id=erdem&pw=123
  }

  private function clear($item){
    return htmlspecialchars($item, ENT_QUOTES);
  }

  private function algorithm($identy,$password,$time){
    return md5($identy+"SECRET"+$password+"SERVERSEED"+$time);
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
