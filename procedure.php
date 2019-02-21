<?php
if(@empty($_SESSION['auth'])){
  header("location:login?error=first_login");
}else{
  if ($q -> check_auth(@$_SESSION['auth'])==false) {
    header("location:login?error=not_authorized");
  }
}
 ?>
