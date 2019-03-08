<?php
if(!defined('check_for_direct_access')) {
   die('Doğrudan erişim yasaklıdır.<br>Direct access not permitted.');
}
?>
<div id="logoff" class="modal mlogoff">
  <div class="modal-content">
    <h4>Çıkış yap</h4>
    <p>Güvenli çıkış yapmak için Evet'e tıklayın.</p>
  </div>
  <div class="modal-footer">
    <a href="javascript:void(0)" class="modal-close btn waves-effect waves-light">Geri dön</a>
    <a href="logoff" class="btn waves-effect red waves-light">Çıkış yap<i class="material-icons right">exit_to_app</i></a>
  </div>
</div>
