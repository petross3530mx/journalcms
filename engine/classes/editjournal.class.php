<?php

class EditJournal extends CoreAdmin
{
    
    public function getTitle(){// функція отримання заголовка
            tr::initlang(); //ініціалізація перекладів
            $lang = $_SESSION['lang']; //змінна lang отримується з сесії
            return tr::gettranslation(73, $lang);//повертаємо заголовок сторінки
    }
    
    public function getContent(){// функція отримання вмісту
        $lang = $_SESSION['lang'];
        global $mysqli;//оголошуєтсья доступ до глобальної змінної mysqli
        $result_content = "";//поки результуючий контент пустий
        if (isset($_GET['del'])) {//якщо встановлний параметр del, 
            $del = $_GET['del'];//отримається це в змінну
            //і відправляється запит до БД
            $mysqli->query("DELETE FROM mark WHERE event='%item1%'", $del);
            
            
        }
        if (isset($_GET['rem'])) {//якщо встановлено параметр rem
            $rem = $_GET['rem'];//отримується в змінну
            //видаляються всі оцінки
            $mysqli->query("DELETE FROM mark WHERE event='%item1%'", $del);
            // видаляються всі оцінювання
            $mysqli->query("DELETE FROM event WHERE id='%item1%'", $rem);
            
            
        }
        if ((isset($_GET['k']))&&(isset($_GET['l']))) {//якщо користувач хоче оновити оцінювання
            $k = $_GET['k'];
            $l = $_GET['l'];
            $d = $_GET['d'];
            $ls = $_GET['ls'];
            //отримуються параметри і оновлюється інформація в БД
            $querystr = "UPDATE `event` SET kind='" . $k . "', label='" . $l . "', timedate='" . $ls . "' WHERE id='" . $d . "' ";
			$mysqli->query($querystr);           
        }


        //add marks
        if ((isset($_GET['idx'])) && (isset($_GET['value'])) && (isset($_GET['student'])) && (isset($_GET['datarows'])) && (!isset($_GET['up']))) {
            //якщо потрібно поставити оцінку
            $result_content .= "";
            if (!empty($_GET['idx']) && !empty($_GET['value']) && !empty($_GET['student']) && !empty($_GET['datarows'])) {
                $idx      = $_GET['idx'];
                $value    = $_GET['value'];
                $student  = $_GET['student'];
                $datarows = $_GET['datarows'];
                if (1) {
                    $querystr = "INSERT INTO `mark` (`id`, `event`, `student`, `value`) VALUES (NULL, '" . $datarows . "', '" . $student . "', '" . $value . "');";
                    $mysqli->query($querystr);
                } else {
                    //пусті поля
                }
            } else {
                //оновлень немає
            }
            
        } 
        //якщо потрібно рновити оцінку
        else if ((isset($_GET['idx'])) && (isset($_GET['value'])) && (isset($_GET['student'])) && (isset($_GET['datarows'])) && (isset($_GET['up']))) {
            if (!empty($_GET['idx']) && !empty($_GET['value']) && !empty($_GET['student']) && !empty($_GET['datarows'])) {
                $idx      = $_GET['idx'];
                $value    = $_GET['value'];
                $student  = $_GET['student'];
                $datarows = $_GET['datarows'];

                    // формується запит до БД на встановленння значень
                    $querystr = "
                            UPDATE `mark` 
                            SET value='" . $value . "' WHERE event='" . $datarows . "' AND student='" . $student . "'";
                    $mysqli->query($querystr);


            } else {
                //пусті поля 
            }
        } else {
            //оновлень немає/
        }
        
        
        //якщо немає журналу з таким id
        if (isset($_GET['id'])) {
            $id     = $this->toInteger($_GET['id']);
            $res_id = $mysqli->query("SELECT id FROM eventlist WHERE id='%item1%'", $id);
            if ($res_id->num_rows <= 0) {
                throw new Exception(5);
                exit;
            } else {
                $id = $this->toInteger($_GET['id']);
            }
        }
        //якщо в адресі вказано журнал але не вказано id
        if (isset($_POST['journal'])) {
            if (!isset($_GET['id'])) {
                throw new Exception(5);
                exit;
            } else {
                $id = $this->toInteger($_GET['id']);
            }

        }

        //запит на додавання 
        if (isset($_GET['id'])) {
            if (isset($_POST['sbmt'])) {
                if (isset($_POST['kind']) && isset($_POST['label']) && isset($_POST['dtx1'])) {
                    if (!empty($_POST['kind']) && !empty($_POST['label']) && !empty($_POST['dtx1'])) {
                        $kind  = strval($_POST['kind']);
                        $label = strval($_POST['label']);
                        $dtx1  = strval($_POST['dtx1']);

                                    
                                    $quer = "INSERT INTO `event` (`id`, `timedate`, `eventlist`, `kind`, `label`) VALUES (NULL, '" . $dtx1 . "', '" . $_GET['id'] . "', '" . $kind . "', '" . $label . "');";
                                    $mysqli->query($quer);
                                    
                                    $result_content .= "<p style='color: #0f0;'>".tr::gettranslation(70, $lang)."</p>";
                                
                    } else {
                        $result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
                    }
                } else {
                    $result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
                }
                
                
                
                
            } else {
                $result_content .= "";
            }
            
            $result = $mysqli->query("SELECT * FROM eventlist WHERE id='%item1%'", $id);
            
            $row = $mysqli->assoc($result);
            
            $idx = $row['grid'];

            $yrr = $row['year'];

            $syrr = $row['semestr'];
            
            //форма  відправки
            
            $result_content .= "
                    <form method='post' enctype='multipart/form-data'>
                        <h2>".tr::gettranslation(74, $lang)."</h2>
                        <p class='form-element'><span>".tr::gettranslation(15, $lang).": </span><select name='cat-id'>";
            
            
            $result_cat = $mysqli->query("
                SELECT id, name
                FROM subject
                ");
            
            if ($result_cat && $result_cat->num_rows > 0) {
                $rows = $mysqli->assoc($result_cat);
                if ($rows) {
                    do {
                        if ($row['subject'] == $rows['id'])
                            $result_content .= "<option value='{$rows['id']}' selected>{$rows['name']}</option>";
                        else
                            $result_content .= "<option value='{$rows['id']}'>{$rows['name']}</option>";
                    } while ($rows = $mysqli->assoc($result_cat));
                } else {
                    $result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
                }
            } else {
                $result_content .= "<option value='-2'>".tr::gettranslation(62, $lang)."</option>";
            }
            
            
            $result_content .= "</select></p>";
            
            //викладачі
            
            
            $result_content .= "<p class='form-element'><span>".tr::gettranslation(16, $lang).": </span><select name='cat-id'>";
            
            $result_cat = $mysqli->query("
                SELECT id, full_name
                FROM users
                ");
            
            if ($result_cat && $result_cat->num_rows > 0) {
                $rows = $mysqli->assoc($result_cat);
                if ($rows) {
                    do {
                        if ($row['teacher'] == $rows['id'])
                            $result_content .= "<option value='{$rows['id']}' selected>{$rows['full_name']}</option>";
                        else
                            $result_content .= "<option value='{$rows['id']}'>{$rows['full_name']}</option>";
                    } while ($rows = $mysqli->assoc($result_cat));
                } else {
                    $result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
                }
            } else {
                $result_content .= "<option value='-2'>".tr::gettranslation(62, $lang)."</option>";
            }
            
            
            $result_content .= "</select></p>";
            
            //група
            
            
            $result_content .= "<p class='form-element'><span>".tr::gettranslation(17, $lang).": </span><select disabled name='gr-id' >";
            
            $result_cat = $mysqli->query("
                SELECT id, name
                FROM groups
                ");
            
            if ($result_cat && $result_cat->num_rows > 0) {
                $rows = $mysqli->assoc($result_cat);
                if ($rows) {
                    do {
                        if ($rows['id'] == $row['grid']) {
                            $result_content .= "<option value='{$rows['id']}' selected>{$rows['name']}</option>";
                            
                            //$idx=intval($rows['id']);
                        } else
                            $result_content .= "<option value='{$rows['id']}'>{$rows['name']}</option>";
                    } while ($rows = $mysqli->assoc($result_cat));
                } else {
                    $result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
                }
            } else {
                $result_content .= "<option value='-2'>".tr::gettranslation(62, $lang)."</option>";
            }
            
            
            $result_content .= "</select></p>";
            
                      
            $result_content .= "<p class='form-element'><span>Рік: </span><input type=number name='yr-id' value='".$yrr."'></p>";
            

            $d1=$d2='';

            if($syrr==1){
            $d1='selected';
            }
            else{
                $d2='selected';
            }

            $result_content .= "<p class='form-element'><span>Семестр: </span><select  name='sem-id'><option ".$d1." value=1>1 семестр, зимова сесія (1.02 - 1.07)</option><option ".$d2." value=2>2 семестр, літня сесія (1.09 - 1.02)</option></select></p>";
            
            
            
            $result_content .= "
                <p class='form-element'><input style='display:none;' type='submit' value='".tr::gettranslation(44, $lang)."' id='reg-user-btn' name='edit-news'/></p>
                
                </form>";
            
            
            $result_content .= '<div class="table-responsive">
                                                    <table class="tablex iklk table-striped table-sm" idx=' . $_GET["id"] . '>
                                                      <thead class="hook">
                                                        <tr>
                                                          <th>#</th>
                                                          <th>'.tr::gettranslation(24, $lang).'</th>';
            
            
            $eventlit = intval($_GET['id']);
            
            $eventlistquery = $mysqli->query("    SELECT id, label, kind, timedate FROM event  WHERE eventlist=%item1% ORDER by timedate", $eventlit);
            
            $eventrows = $mysqli->assoc($eventlistquery);
            
            do {
                $clx = '';
                if ((intval($eventrows['id'])) > 0) {
                    $clx = 'vis';
                } else {
                    $clx = 'e3x';
                }
                
                $result_content .= "<th data-id='" . $eventrows['id'] . "' data-label='" . $eventrows['label'] . "' data-kind='" . $eventrows['kind'] . "' data-timedate='" . $eventrows['timedate'] . "' data-target='#myModal2' title='".tr::gettranslation(75, $lang)."' data-toggle='modal' data-placement='top'  class='vertext " . $clx . "'>{$eventrows['label']}</th>";
                
            } while ($eventrows = $mysqli->assoc($eventlistquery));
            
            
            $result_content .= '<th class="nrw hok" data-toggle="modal" data-target="#myModal">+</th><th class=vertext>Рейтинг</th></tr>
                                                      </thead>
                                                    <tbody class="hook"  id="example" >';
            
            
            
            $result_cat = $mysqli->query("    SELECT id, label FROM students  WHERE grid='%item1%'", $idx);
            $rows       = $mysqli->assoc($result_cat);
            
            $result_content .= "<tr><td></td><td></td>";
            
            $eventlit = intval($_GET['id']);
            
            $eventlistquery = $mysqli->query("    SELECT id, label FROM event  WHERE eventlist=%item1% ORDER by timedate", $eventlit);
            
            $eventrows = $mysqli->assoc($eventlistquery);
            
            do {
                $result_content .= "<td data-toggle='tooltip' data-placement='left' title='".tr::gettranslation(76, $lang)."' class='rem' col='{$eventrows['id']}'><span data-feather='slash'></span></th>";
            } while ($eventrows = $mysqli->assoc($eventlistquery));
            
            
            $result_content .= "<td class='nrs'></td><td class=''></td></tr>";
            
            do {
                
                $result_content .= "<tr student=" . $rows['id'] . "  ><td>{$rows['id']}</td><td class='student'>{$rows['label']}</td>";
                
                
                $eventlit = intval($_GET['id']);
                
                $eventlistquery = $mysqli->query("    SELECT id, label FROM event  WHERE eventlist=%item1%  ORDER by timedate", $eventlit);
                
                $eventrows = $mysqli->assoc($eventlistquery);
                
                do {
                    
                    $markquery = $mysqli->query("    SELECT value FROM mark  WHERE event='%item1%' AND  student='%item2%'", $eventrows['id'], $rows['id']);
                    $markrows  = $mysqli->assoc($markquery);
                    
                    
                    do {
                        
                        $clx = '';
                        if ((intval($eventrows['id'])) > 0) {
                            $clx = 'vis';
                        } else {
                            $clx = 'e3x';
                        }
                        
                        $rx = "";
                        if ($markrows['value']) {
                            $rx .= 'update=' . $markrows['value'];
                        }
                        $result_content .= "<td class='" . $clx . "' datarows=" . $eventrows['id'] . " ><input class='markinput' type='text' {$rx} value={$markrows['value']}></td>";
                    } while ($markrows = $mysqli->assoc($markquery));
                    
                } while ($eventrows = $mysqli->assoc($eventlistquery));
                
                
                
                
                
                $result_content .= "<td class='nrs'></td><td class='undersumm'>{{summ}}</td></tr>";
            } while ($rows = $mysqli->assoc($result_cat));
            
            
            
            $result_cat = $mysqli->query("    SELECT id, label FROM students  WHERE grid='%item1%'", $idx);
            $rows       = $mysqli->assoc($result_cat);
            
            $result_content .= "<tr><td></td><td></td>";
            
            $eventlit = intval($_GET['id']);
            
            $eventlistquery = $mysqli->query("    SELECT id, label FROM event  WHERE eventlist=%item1% ORDER by timedate", $eventlit);
            
            $eventrows = $mysqli->assoc($eventlistquery);
            
            do {
                $result_content .= "<td title='".tr::gettranslation(68, $lang)."' data-toggle='tooltip' data-placement='left' class='rom' col='{$eventrows['id']}'><span data-feather='x'></span></th>";
            } while ($eventrows = $mysqli->assoc($eventlistquery));
            
            
            $result_content .= "<td></td><td class=tbsumm></td></tr>";
            
            
            
            
            
            $result_content .= '</tbody>
                                                </table>
                                              </div>';
            
            
            
            $result_content .= '
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form method="post" enctype="multipart/form-data">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'.tr::gettranslation(59, $lang).'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="form-element"><span class="ib">'.tr::gettranslation(81, $lang).': </span><input class="ib custom-select" name="kind"></p>
        <p class="form-element"><span class="ib">'.tr::gettranslation(82, $lang).': </span><input class="ib custom-select" name="label"></p>


        <p class="form-element"><span class="ib">'.tr::gettranslation(83, $lang).': </span><input type="text" id="datepicker" name="dtx1" class="ib custom-selectx"/>
        </p>
                                             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.tr::gettranslation(43, $lang).'</button>
        <button type="submit" name="sbmt" value="sbmt" class="btn btn-primary">'.tr::gettranslation(59, $lang).'</button>
      </div>
    </div>
  </div>
 </form>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><form method="post" enctype="multipart/form-data"><div class="modal-dialog" role="document"><div class="modal-content">

    <div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">'.tr::gettranslation(84, $lang).'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button></div>

      <div class="modal-body">
        <p class="form-element"><span class="ib">'.tr::gettranslation(81, $lang).': </span><input class="ib custom-select" id="kind" name="kind"></p>
        <p class="form-element"><span class="ib">'.tr::gettranslation(82, $lang).': </span><input class="ib custom-select" id="label" name="label"></p>
        <p class="form-element"><span class="ib">'.tr::gettranslation(83, $lang).': </span><input type="text" id="datepicker2" name="dtx1" class="ib custom-selectx"/>
        </p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.tr::gettranslation(43, $lang).'</button>
        <button id="smx" name="smx" value="smx" class="btn btn-primary">'.tr::gettranslation(44, $lang).'</button>
      </div>

    </div></div></form></div>';
            
            
            
        } else {
            
            if (isset($_POST['updx'])) {
                
                $updx      = $_POST['updx'];
                $markquery = $mysqli->query("    SELECT visibility FROM eventlist  WHERE id='%item1%'", $updx);
                $markrows  = $mysqli->assoc($markquery);
                $value     = 1;
                
                
                
                
                do {
                    if ($markrows['visibility'] == 1) {
                        $value = 0;
                    }
                    
                    
                } while ($markrows = $mysqli->assoc($markquery));
                
                
                $querystr = "
                            UPDATE `eventlist` 
                            SET visibility='" . $value . "' WHERE id='" . $updx . "'";
                $mysqli->query($querystr);
                echo "<script>console.log('uodx')</script>";
                
            }
            
            //додається заголовок
            $result_content .= "<h1 class='h2'>".tr::gettranslation(80, $lang)."</h1>";
            
            $result_content .= '<div class="btn-toolbar mb-2 mb-md-0">
 
            </div><br>';
            
            //додаєтсья основа таблиці
            $result_content .= "<div class='table-responsive'>
                                                    <table class='d4x table table-striped table-sm'>
                                                      <thead>
                                                        <tr>
                                                          <th>#</th>
                                                          <th>".tr::gettranslation(16, $lang)."</th>
                                                          <th>".tr::gettranslation(15, $lang)."</th>
                                                          <th>".tr::gettranslation(17, $lang)."</th>
                                                          <th>".tr::gettranslation(77, $lang)."</th>
                                                          <th>".tr::gettranslation(39, $lang)."</th>
                                                        </tr>
                                                      </thead>
                                                    <tbody>";
            
            //формуємо допоміжні масиви для зручного перегляду даних щоб виводиилсь не id,  а назви та імена
            
            $teachersql = "SELECT id, full_name FROM users";
            
            
            
            
            $teachersql = "SELECT id, full_name FROM users ";
            
            
            
            $teacherresult = $mysqli->query($teachersql);
            $teach         = array();
            if ($teacherresult && $teacherresult->num_rows > 0) {
                $row = $mysqli->assoc($teacherresult);
                if ($row) {
                    do {
                        //формується асоціативний масив з викладачів типу ключ=>значення
                        $key         = $row['id'];
                        $value       = $row['full_name'];
                        $teach[$key] = $value;
                    } while ($row = $mysqli->assoc($teacherresult));
                } else {
                    $result_content = "Error #22317 editjournal.class.php!";
                }
            }
            
            $subjsql    = "SELECT id, name FROM subject";
            $subjresult = $mysqli->query($subjsql);
            $subj       = array();
            if ($subjresult && $subjresult->num_rows > 0) {
                $row = $mysqli->assoc($subjresult);
                if ($row) {
                    do {
                        //формується асоціативний масив  типу ключ=>значення
                        $key        = $row['id'];
                        $value      = $row['name'];
                        $subj[$key] = $value;
                    } while ($row = $mysqli->assoc($subjresult));
                } else {
                    $result_content = "Error #22317 editjournal.class.php!";
                }
            }
            
            $grsql    = "SELECT id, name FROM groups";
            $grresult = $mysqli->query($grsql);
            $gr       = array();
            
            if ($grresult && $grresult->num_rows > 0) {
                $row = $mysqli->assoc($grresult);
                if ($row) {
                    do {
                        //формується асоціативний масив типу ключ=>значення
                        $key      = $row['id'];
                        $value    = $row['name'];
                        $gr[$key] = $value;
                    } while ($row = $mysqli->assoc($grresult));
                } else {
                    $result_content = "Error #22317 editjournal.class.php!";
                }
            }
            
            //запит до бд на отримання списку журналів
            
            
            
            if (isset($_SESSION['role'])) {
                echo '<script>' . $_SESSION['role'] . '</script>';
                $sql = "SELECT id, grid, teacher, subject, visibility FROM eventlist WHERE teacher='" . $_SESSION['role'] . "' ORDER BY id ASC";
                
            } else {
                $sql = "SELECT id, grid, teacher, subject, visibility FROM eventlist ORDER BY id ASC";
            }
            
            //$sql = "SELECT id, grid, teacher, subject, visibility FROM eventlist ORDER BY id ASC";
            
            //echo $sql;
            $result = $mysqli->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $row = $mysqli->assoc($result);
                if ($row) {
                    do {
                        $result_content .= " <tr>
                                                            <td>{$row['id']}</td>
                                                            <td>" . $teach[$row['teacher']] . "</td>
                                                            <td>" . $subj[$row['subject']] . "</td>
                                                            <td>" . $gr[$row['grid']] . "</td>
                                                            <td value={$row['id']} class='vivibilitytd'><span title='".tr::gettranslation(78, $lang)."' class='vizible{$row['visibility']}'><span  data-feather='eye'></span></span><span title='".tr::gettranslation(79, $lang)."' class='novizible{$row['visibility']}'><span  data-feather='eye-off'></span></span>";
                        
                        $resultx = $mysqli->query("SELECT * FROM event where eventlist={$row['id']} ORDER by timedate");
                        $result_content .= "(" . $resultx->num_rows . ")";
                        
                        $result_content .= "</td>
                                                            <td><a href='?option=editjournal&id={$row['id']}' >".tr::gettranslation(39, $lang)." ";
                        
                        
                        
                        //SELECT COUNT (id) FROM event WHERE eventlist=%item%", $row['id']
                        
                        $result_content .= "</a></td>
                                                        </tr>";
                        
                        
                    } while ($row = $mysqli->assoc($result));
                } else {
                    $result_content = "".tr::gettranslation(62, $lang)."";
                }
            }
            
            
            else {
                $result_content = "".tr::gettranslation(62, $lang)."";
            }
            
            $result_content .= "</tbody>
                                                </table>
                                              </div>";
            
        }
        
        return $result_content;
    }
}
?>