 <?php
class EditSubject extends CoreAdmin //
{
    
    public function getTitle() // функція отримання заголовка
    {
        tr::initlang(); //ініціалізація перекладів
        $lang = $_SESSION['lang']; //змінна lang отримується з сесії
        return tr::gettranslation(86, $lang); //повертаємо заголовок сторінки
    }
    
    public function getContent() // функція отримання вмісту
    {
        
        $result_content = ''; //змінна поки пуста
        
        $lang = $_SESSION['lang']; //змінна lang отримується з сесії
        
        global $mysqli; //оголошуєтсья доступ до БД
        
        if ((isset($_POST['updname'])) && (isset($_GET['id']))) { //якщо був запит на оновлення предмету,
            if (($_POST['updname']) != '') {
                $upd   = $_POST['updname']; //то оновлюємо його в базі
                $query = "UPDATE subject SET name='" . $upd . "' WHERE id='" . $_GET['id'] . "' ";
                $mysqli->query($query);
            }
        }
        
        if (isset($_GET['id'])) { //якщо в адресі встановлено  id
            
            $grid = $_GET['id']; //присвоюється змінна з адреси
            
            $query = "SELECT * FROM subject where id='" . $grid . "'"; //ФОРмується запит до БД
            
            $result = $mysqli->query($query); //робиться запит до бд
            
            
            $row = $mysqli->assoc($result); //формуєтьяс асоціативний масив із результату запиту
            
            $result_content .= "<form method='post' enctype='multipart/form-data'>"; //формуєтсья код форми редагування предмету
            do {
                $result_content .= "<h1 class='h2'>" . tr::gettranslation(86, $lang) . " - " . $row['name'] . " </h1><br><hr><br>";
                $result_content .= '<span style="padding-right:10px;">' . tr::gettranslation(82, $lang) . '</span><input  name="updname" type=text value="' . $row['name'] . '" class="ib custom-select" style="float:none;width:auto">';
            } while ($row = $mysqli->assoc($result));
            
            $result_content .= " <input class='btn btn-primary' type='submit' value='" . tr::gettranslation(44, $lang) . "' id='reg-user-btn' name='edit'/>";
            
            $result_content .= "</form> <hr>";
            
            
        } else { //якщо id не встановлено, отримується просто список предметів
            
            $result_content .= "<h1 class='h2'>" . tr::gettranslation(86, $lang) . "</h1>";
            
            $query = "SELECT * FROM subject"; ///формується запит до БД
            
            $result = $mysqli->query($query); //отримується результа  запиту до БД
            
            
            $row = $mysqli->assoc($result); //і перебір результатів і вивід їх в результуючий контент
            do {
                $result_content .= '<div class="gruop"><a href="?option=editsubject&id=' . $row['id'] . '" >' . $row['name'] . '</a></div>';
            } while ($row = $mysqli->assoc($result));
            
        }
        
        return $result_content; //повертається значення вмісту
    }
}
?> 