<?php
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.
class db_query
{
  function export_form_items($stok_tipi,$kolon_adi,$auth){
    $auth = $this->clear($auth);
    $stok_tipi = $this->clear_array($stok_tipi);
    $kolon_adi = $this->clear_array($kolon_adi);

    if ($this->check_level($auth)>1) {
      $gerekli_tip = ['var','yok'];
      $gerekli_kolon = ['name','formula','manufacturer','quantity','stock','entry_date'];

      $size_row = 5;
      $size_header = 4;

      $tipler=0;
      foreach ($stok_tipi as $key) {
        if (in_array($key, $gerekli_tip)) {
            if ($key=="var") {
              $tipler = $tipler + 1;
            }else if ($key=="yok") {
              $tipler = $tipler + 2;
            }else{
              $tipler = 0;
            }
        }
      }//foreach

      $kolon = 0;
      $select = "";
      if (count($kolon_adi)>0) {
          foreach ($kolon_adi as $key => $value) {
            if (in_array($key, $gerekli_kolon)) {
              if ($kolon==0) {
                $select = $select.$key;
              } else {
                $select =  $select.",".$key;
              }
              $kolon++;
            }
          }//foreach
      }else {
        $select = "*";
      }

      switch ($tipler) {
        case 1:
          //echo "Stokta olanlar indiriliyor.";
            $q = mysql_query("SELECT $select FROM `kimyasal` WHERE `stock` <> '0'");
          break;

        case 2:
          //echo "Stokta olmayanlar ";
            $q = mysql_query("SELECT $select FROM `kimyasal` WHERE `stock` = '0'");
          break;

        case 3:
          //echo "Stokta hem olan, hem olmayanlar ";
          $q = mysql_query("SELECT $select FROM `kimyasal`");
          break;

        default:
          //echo "Hatalı.";
          break;
      }

      if (mysql_num_rows($q)>0) {
        echo '<table border="1"><tr>';

        foreach($kolon_adi as $key => $value){
            echo "<th style=\"background-color:#FFA500\"><font size=$size_header>".$key."</font></th>";
        }
        echo '</tr>';
          while ($row=mysql_fetch_assoc($q)) {
            echo "<tr>";
              foreach ($kolon_adi as $key => $value) {
                echo "<td><font size=$size_row>".$row[$key]."</font></td>";
              }
            echo "</tr>";
          }

          echo '<tr><td colspan="'.count($kolon_adi).'" align="center" valign="center"><i>'.@$_SESSION['user'].' tarfından, '.date('G:i j.m.Y', time()).' tarihinde oluşturuldu.</i></td></tr>';
          echo '</table>';
      }
    }//güvenlik bitişi
  }


  function get_autocomplete_data($chosen,$auth){
    $auth = $this->clear($auth);
    if ($this->check_level($auth)>1) {
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
  }
  function get_data($auth,$extend=0){

    $auth= $this->clear($auth);
    if ($this->check_level($auth)>1) {
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
                  if ($extend == "stock") {
                    $q = mysql_query("select name,formula,n_name,n_formula,unique_id from kimyasal WHERE `stock` = '0' GROUP BY n_name ORDER BY name ASC;");
                  }else{
                    $q = mysql_query("select name,formula,n_name,n_formula,unique_id from kimyasal WHERE `stock` <> '0' GROUP BY n_name ORDER BY name ASC;");
                  }

                  if($q){
                    while($row = mysql_fetch_assoc($q)){
                      //buraya akordiyon olarak firma isimleri ekliyebilirsin
                      $custom_id=$row['n_name'];
                      $color = "red";
                      $new_q = mysql_query("SELECT * FROM `msds` WHERE `n_id` = $custom_id");
                      if (mysql_num_rows($new_q)>0) {
                        $color = "blue";
                      }
                      echo "<tr>
                              <td>".$row['name']."</td>
                              <td>".$row['formula']."</td>
                              <td>
                              <a href=\"msds.php?id=".$row['n_name']."\" data-position=\"bottom\" data-tooltip=\"Malzeme Güvenlik Bilgi Formu'nu görüntüle.\" target=\"_blank\"  class=\"$color darken-1 waves-effect waves-light btn tooltipped\">MGBF</a>
                              <a href=\"#list\" onclick=\"getDataLi('".$row['n_name']."','$extend');\" data-position=\"bottom\" data-tooltip=\"Kimyasalı görüntüle & düzenle.\" class=\"blue darken-2 waves-effect waves-light btn tooltipped modal-trigger\"><i class='material-icons'>edit</i></a></td>
                            </tr>";
                    }
                  }
              echo '</tbody>
                </table>
            </div>
        </div>';
        return true;
      }
      else{
        echo '<div class="row">
          <div class="col m12">
          <h1 class="center">Yetersiz yetkiye sahipsiniz.</h1>
          </div></div>';
          return false;
      }
  }
  function get_data_with_parameters($canon,$search,$auth,$pg=0){
    $canon = $this->clear($canon);
    $search = $this->clear($search);
    $auth = $this->clear($auth);

    if ($this->check_level($auth)>1) {
        if($canon=="" || $search==""){
          echo "empty-data";
        }
        else{
          if ($pg=="stock") {
              if($canon=="f"){
                $q = mysql_query("select name, formula,n_name,unique_id from kimyasal WHERE `manufacturer` LIKE '%$search%' AND  `stock` = '0' GROUP BY n_name;");
              }else if($canon=="k"){
                $q = mysql_query("select name, formula,n_name,unique_id  from kimyasal WHERE `name` LIKE '%$search%' AND  `stock` = '0' GROUP BY n_name;");
              }
          }else{
              if($canon=="f"){
                $q = mysql_query("select name, formula,n_name,unique_id from kimyasal WHERE `manufacturer` LIKE '%$search%' AND  `stock` <> '0'GROUP BY n_name;");
              }else if($canon=="k"){
                $q = mysql_query("select name, formula,n_name,unique_id  from kimyasal WHERE `name` LIKE '%$search%' AND  `stock` <> '0' GROUP BY n_name;");
              }
          }


            if(mysql_num_rows($q)>0){
              while($row = mysql_fetch_assoc($q)){
                $custom_id=$row['n_name'];
                $color = "red";
                $new_q = mysql_query("SELECT * FROM `msds` WHERE `n_id` = $custom_id");
                if (mysql_num_rows($new_q)>0) {
                  $color = "blue";
                }
                echo "<tr class=\"searched\">
                        <td>".$row['name']."</td>
                        <td>".$row['formula']."</td>
                        <td>
                        <a href=\"msds.php?id=".$row['n_name']."\" data-position=\"bottom\" data-tooltip=\"Malzeme Güvenlik Bilgi Formu'nu görüntüle.\" target=\"_blank\"  class=\"$color darken-1 waves-effect waves-light btn tooltipped\">MGBF</a>
                        <a href=\"#list\" onclick=\"getDataLi('".$row['n_name']."','$pg');\" data-position=\"bottom\" data-tooltip=\"Kimyasalı görüntüle & düzenle.\" class=\"blue darken-2 waves-effect waves-light btn tooltipped modal-trigger\"><i class='material-icons'>edit</i></a></td>
                      </tr>";
              }

            }else{
                echo "not-found";
            }
        }
      }else{
        echo 'level-error';
      }




  }
  function get_data_li($cname,$auth,$pg){
    $cname = $this-> clear($cname);
    $auth = $this-> clear($auth);
    $pg = $this-> clear($pg);
    $range="";
    if ($this->check_level($auth)>1) {
      $f = 0;

      if ($pg=="stock") {
        $q = mysql_query("SELECT * FROM `kimyasal` WHERE `n_name` = $cname AND `stock` = '0' ORDER BY `entry_date` DESC");
      }else{
        $q = mysql_query("SELECT * FROM `kimyasal` WHERE `n_name` = $cname AND `stock` <> '0' ORDER BY `entry_date` DESC");
      }

      if (mysql_num_rows($q)>0) {
          while ($row = mysql_fetch_assoc($q)) {

            $percent = $this->date_percent($row['entry_date']);


            if ($percent>=100) {
              $range = "range1";
              $percent=100;
            }else if($percent >=80){
              $range = "range2";
            }else if($percent <0){
              $range = "";
              $percent=0;
            }else{
              $range="";
              //$percent=0;
            }


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
                            Rafta geçen süre: '.round($percent).'%
                            <div class="progress">
                                <div class="determinate '.$range.'" style="width: '.$percent.'%"></div>
                            </div>
                            <br>
                            <a href="edit.php?id='.$row['unique_id'].'" class="blue darken-2 secondary-content btn flat-btn"><i class="material-icons">edit</i></a>
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
  function update_chemical($id,$ka,$f,$uf,$m,$a,$gt,$author,$msds){
    $id =       $this->clear($id);
    $ka =       $this->clear($ka);
    $f =  $this->clear($f);
    $uf =       $this->clear($uf);
    $m =        $this->clear($m);
    $a =        $this->clear($a);
    $gt =       $this->clear($gt);
    $author =   $this->clear($author);
    $state = "8";

          if ($this->check_level($author)>1) {

            $q = mysql_query("SELECT * FROM `kimyasal` WHERE `unique_id` = $id");
            if (mysql_num_rows($q)>0) {
              while ($row = mysql_fetch_assoc($q)) {
                $name = $row['name'];
                $formula = $this->clear($row['formula']);
                $manufacturer = $row['manufacturer'];
                $quantity = $row['quantity'];
                $stock = $row['stock'];
                $entry_date = $row['entry_date'];
                $new_date = explode("-",$entry_date);
                $date2 = @$new_date[2].'-'.@$new_date[1].'-'.@$new_date[0];
              }

              if ($name != $ka) {
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
                          //$ka artık bizim için bir numara ve güncelleyelim
                          $update = mysql_query("UPDATE `chemical` SET `n_name` = '$ka' WHERE `chemical`.`unique_id` = $id;");
                          if(!$update){
                            $state="7";
                          }
              }



              if ($uf != $manufacturer) {
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
                          //$ka artık bizim için bir numara ve güncelleyelim
                          $update = mysql_query("UPDATE `chemical` SET `n_manufacturer` = '$uf' WHERE `chemical`.`unique_id` = $id;");
                          if(!$update){
                            $state="7";
                          }
              }
              if ($quantity != $m) {
                $update = mysql_query("UPDATE `chemical` SET `quantity` = '$m' WHERE `chemical`.`unique_id` = $id;");
                if(!$update){
                  $state="7";
                }
              }
              if ($stock != $a) {
                $update = mysql_query("UPDATE `chemical` SET `stock` = '$a' WHERE `chemical`.`unique_id` = $id;");
                if(!$update){
                  $state="7";
                }
              }
              if ($date2 != $gt) {
                  $new_date = explode("-",$gt);
                  $date = @$new_date[2].'-'.@$new_date[1].'-'.@$new_date[0];
                $update = mysql_query("UPDATE `kimyasal` SET `entry_date` = '$date' WHERE `kimyasal`.`unique_id` = $id;");
                if(!$update){
                  $state="7";
                }
              }
              if ($f != $formula) {
                          $q_formula = mysql_query("SELECT * FROM `chemical_formula` WHERE `formula` = '$f'");

                          if (mysql_num_rows($q_formula)>0) {
                            while ($row = mysql_fetch_assoc($q_formula)) {
                              $formula = $row['n_formula'];
                            }
                          }else{
                            $insert = mysql_query("INSERT INTO `chemical_formula` (`n_formula`, `formula`) VALUES (NULL, '$f')");
                            if ($insert) {
                              $find = mysql_query("SELECT `n_formula` FROM `chemical_formula` WHERE `formula` = '$f'");
                              while ($row = mysql_fetch_assoc($find)) {
                                $formula = $row['n_formula'];
                              }
                            }
                          }
                          //$ka artık bizim için bir numara ve güncelleyelim
                          $update = mysql_query("UPDATE `chemical` SET `n_formula` = '$formula' WHERE `chemical`.`unique_id` = $id;");
                          if(!$update){
                            $state="7";
                          }
              }

              echo $state;
            }else{
              return "1";
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

  function header_tag($id,$auth){
    $id   = $this-> clear($id);
    $auth = $this-> clear($auth);
    if ($this->check_level($auth)>1) {
        $q = mysql_query("SELECT `name` FROM `kimyasal` WHERE `unique_id` = $id");
        if ($q) {
          if (mysql_num_rows($q)>0) {
            while ($row = mysql_fetch_assoc($q)) {
              return $row['name'];
            }
          }else{
            return "-1";
          }
        }else{
          return "-2";
        }
    }
  }

  function stock_count(){
      $q1 = mysql_query("SELECT `unique_id` FROM `kimyasal` WHERE `stock` <> '0'");
      $q2 = mysql_query("SELECT `unique_id` FROM `kimyasal` WHERE `stock` = '0'");
      $stocks = mysql_num_rows($q1)." ".mysql_num_rows($q2);
    return $stocks;
  }

  function update_form_data($id,$auth){
    $id = $this-> clear($id);
    $auth = $this-> clear($auth);
    $q = mysql_query("SELECT * FROM `kimyasal` WHERE `unique_id` = $id");
    if ($this->check_level($auth)>1) {
    if ($q && mysql_num_rows($q)>0) {
      $id = @$_GET['id'];
      while ($row = mysql_fetch_assoc($q)) {

      echo '<form class="edit_form" id="edit_form" enctype="multipart/form-data" method="post">
              <div class="row">
                  <div class="col m12 s12 l8 iomr">
                    <div class="card card-wns">
                        <div class="card-content ">
                          <div class="row">
                            <div class="col m12 s12 l12">
                              <div class="col s12">
                                <div class="row">
                                  <div class="input-field col s12">
                                    <i class="material-icons prefix">label_outline</i>
                                    <input type="text" value="'.$row["name"].'" id="ka" class="autocomplete" autocomplete="off" onchange="input2span(\'ka\')" name="ka">
                                    <label for="ka">Kimyasal adı düzenlemek için tıklayın</label>
                                  </div>
                                </div>
                              </div>

                              <div class="col s12">
                                <div class="row">
                                  <div class="input-field col s12 m8 l10">
                                    <i class="material-icons prefix">label_important_outline</i>
                                    <input type="text" value="'.$row["formula"].'" name="formula" autocomplete="off" id="kf" name="kf" onchange="input2span(\'kf\')">
                                    <label for="kf" class="truncate">Kimyasal formülü düzenlemek için tıklayın</label>
                                  </div>
                                  <div class="input-field col s12 m4 l2">
                                    <button onclick="upItem()" class="btn waves-effect waves-light col s5 blue darken-1" type="button" name="action">
                                      <i class="material-icons">arrow_upward</i>
                                    </button>
                                    <button onclick="downItem()" class="btn waves-effect waves-light col s5 offset-s1 blue darken-1" type="button" name="action">
                                      <i class="material-icons">arrow_downward</i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="col s12">
                                <div class="row">
                                  <div class="input-field col s12">
                                    <i class="material-icons prefix">build</i>
                                    <input type="text" value="'.$row["manufacturer"].'" id="uf" class="autocomplete" name="uf" onchange="input2span(\'uf\')">
                                    <label for="uf" class="truncate">Üretici firma düzenlemek için tıklayın</label>
                                  </div>
                                </div>
                              </div>
                              <div class="col s12">
                                <div class="row">
                                  <div class="input-field col s12 l12">
                                    <i class="material-icons prefix">exposure</i>
                                    <input type="text" id="m" autocomplete="off" name="m" onchange="input2span(\'m\')"  value="'.$row["quantity"].'">
                                    <label for="m" class="truncate">Miktar düzenlemek için tıklayın</label>
                                  </div>
                                </div>
                              </div>
                              <div class="col s12">
                                <div class="row">
                                  <div class="input-field col s12 m8 l10">
                                    <i class="material-icons prefix">exposure</i>
                                    <input type="text" id="a" name="a" autocomplete="off" onchange="input2span(\'a\')"  value="'.$row["stock"].'">
                                    <label for="a" class="truncate">Adet düzenlemek için tıklayın</label>
                                  </div>

                                  <div class="input-field col s12 m4 l2">
                                    <button class="btn waves-effect waves-light col s5 blue darken-1" type="button" id="count-down">
                                      <i class="material-icons">exposure_neg_1</i>
                                    </button>
                                    <button class="btn waves-effect waves-light col s5 offset-s1 blue darken-1" type="button" id="count-up">
                                      <i class="material-icons">exposure_plus_1</i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="col s12">
                                <div class="row">
                                  <div class="input-field col s12">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="text" class="datepicker" id="gt" autocomplete="off" name="gt" onchange="input2span(\'gt\')"  value="'.$row["entry_date"].'">
                                    <label for="gt" class="truncate">Giriş tarihi güncellemek için tıklayın</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="col m12 s12 l4">
                    <div class="card card-wns">
                      <div class="card-content">
                        <ul class="collection">
                          <li class="collection-item">Kimyasal adı: <span id="ka_span"></span></li>
                          <li class="collection-item">Kimyasal formülü: <span id="kf_span"></span></li>
                          <li class="collection-item">Üretici firma: <span id="uf_span"></span></li>
                          <li class="collection-item">Miktar: <span id="m_span"></span></li>
                          <li class="collection-item">Adet: <span id="a_span"></span></li>
                          <li class="collection-item">Giriş tarihi: <span id="gt_span"></span></li>
                        </ul>
                      </div>
                      <div class="card-action">
                        <input type="hidden" name="action" value="update_form">
                        <input type="hidden" name="id" value="';
                        echo $id
                         .'">
                        <button class="btn blue waves-effect waves-light" type="button" id="gonder-insert">Güncelle
                          <i class="material-icons right">send</i>
                        </button>
                        <button class="btn red waves-effect waves-light" type="button" id="gonder-sil">Sil
                          <i class="material-icons right">delete</i>
                        </button>
                      </div>
                    </div>
                  </div>
                  </form>';
      }
    }
    }
  }
  function chemical_delete($id,$auth){
    $id = $this->clear($id);
    $auth = $this->clear($auth);

    if ($this->check_level($auth)>1) {

      $q = @mysql_query("SELECT visible FROM `chemical` WHERE `unique_id` = $id");

      if (mysql_num_rows($q)>0) {
          $q = @mysql_query("DELETE FROM `chemical` WHERE `chemical`.`unique_id` = $id");
          if (@$q) {
            return "8";
          }else{
            return "9";
          }
      }else{
        return "10";
      }
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

  function date_percent($push){
    $now_time = time(); //2019-05-04
    $entry_time = strtotime($push); //2017-05-04
    $passed_time = $now_time - $entry_time; //geçen süre

    $end_time = 31536000*2; // raf ömrü 2 yıl.

    $percent = $passed_time / $end_time * 100;
    return $percent;
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

  private function clear_array($items_get){
    $clear_array = [];
    foreach ((array)$items_get as $key => $value) {
      $clear_array[htmlspecialchars($key, ENT_QUOTES)]=$value;
    }
    return $clear_array;
  }

  private function algorithm($identy,$password,$time){
    return md5($identy+"SECRET"+$password+"SERVERSEED"+$time);
  }

  function register($identy,$password,$time){
    $identy = $this->clear($identy);
    $password = $this->clear($password);
    $time = $this->clear($time);
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
    $identy = $this->clear($identy);
    $password = $this->clear($password);
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

  function reset_password($pw1,$auth){
    $pw1 = $this->clear($pw1);
    $auth = $this->clear($auth);

    $q = mysql_query("SELECT * FROM `user` WHERE `user_auth` = '$auth'");
    if ($q) {
      if (mysql_num_rows($q)>0) {
        while ($row = mysql_fetch_assoc($q)) {
          $identy = $row['user_id'];
        }

        $new_time = time();
        $new_auth = $this->algorithm($identy,$pw1,$new_time);
        $time_update = mysql_query("UPDATE `user` SET `user_login_time` = '$new_time', `user_auth` = '$new_auth' WHERE `user`.`user_id` = '$identy';");
        if ($time_update) {
          $_SESSION['auth'] = $new_auth;
          $_SESSION['user']=$identy;
          return "3";
        }else{
          return "5";
        }
      }else{
        return "2";
        //kullanıcı bulunamadı işlem yapılmadı
      }
    }else{
      return "1";
      //illegal bir deneme sağlandı
    }

  }

  private function clear($item){
    return htmlspecialchars($item, ENT_QUOTES);
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
