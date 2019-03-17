<?php
$mysqli = db::getObject();
class Teacher extends Core{//клас наслідує core

    public function getTitle()// gettitle функція
    {
        tr::initlang();
        $lang = $_SESSION['lang'];
        return tr::gettranslation(32, $lang);  
    }
    public function getContent()//getcontent функція
    { 
        $lang = $_SESSION['lang'];//змінна lang отримується з сесії
        global $mysqli;//оголошуєтсья доступ до БД
        $result_content = "";
        if (isset($_GET['id'])) {// якщо встановлено id нічого не робиться, інакше виводиться список викладачів
        } else {
            $result_content .= '<div style="margin-bottom:22px;"><a style="margin-left:0px;" class="btn btn-primary e2x" href="?option=index"><span data-feather=home></span><p>' . tr::gettranslation(3, $lang) . '</p></a> </div> ';
            
        }
        
        
        $result_content .= "<h1 class='h2'>" . tr::gettranslation(34, $lang) . "</h1>";
        
        $result_content .= '<br>';
        //додаєтсья основа таблиці
        $result_content .= "<div class='table-responsive'>
                                                    <table class='table table-striped table-sm'>
                                                      <thead>
                                                        <tr>
                                                          <th>#</th>
                                                          <th>" . tr::gettranslation(16, $lang) . "</th>
                                                          <th>email</th>
                                                          <th>" . tr::gettranslation(33, $lang) . "</th>
                                                        </tr>
                                                      </thead>
                                                    <tbody>";
        
        
        $sql    = "SELECT id, full_name, login, email , registered FROM users ORDER BY registered DESC";
        $result = $mysqli->query($sql);
        $idm    = 0;
        if ($result && $result->num_rows > 0) {
            $row = $mysqli->assoc($result);
            if ($row) {
                do {
                    $idm += 1;
                    $result_content .= " <tr>
                                            <td>" . $idm . "</td>
                                            <td>{$row['full_name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['registered']}</td>
                                         </tr>";
                } while ($row = $mysqli->assoc($result));
            } else {
                $result_content = "Викладачів немає";
            }
        }        
        else {
            $result_content = "Викладачів немає";
        }
        
        $result_content .= "</tbody></table></div>";
        
        return $result_content;
    }
}
?>