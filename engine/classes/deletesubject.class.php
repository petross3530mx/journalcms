<?php
    class DeleteSubject extends CoreAdmin {
        
        public function getTitle() {//клас наслідує core відповідно перевизначає gettitle
            tr::initlang();//ініціалізація перекладів
            $lang = $_SESSION['lang'];//змінна lang отримується з сесії
            return tr::gettranslation(88, $lang);//повертаємо заголовок сторінки
        }
    
        public function getContent() {//getcontent функція
                global $mysqli;//оголошуєтсья доступ до БД
                $lang = $_SESSION['lang'];//змінна lang отримується з сесії
                $result_content = "";//змінна поки пуста
                if(isset($_POST['delete-sublect'])) {//якщо в запиті було видалення
                    if(isset($_POST['list-delete'])) {//отримуєтсья списко на видалення
                        $list = $_POST['list-delete'];//присвоюється змінна цьому значенню
                        for($i = 0; $i < count($list); $i++) {//перебір масиву
                             
                            if(1) {
                                $mysqli->query("DELETE FROM subject WHERE id='%item1%'", $this->toInteger($list[$i]));
                                $result_content .= "<p>".tr::gettranslation(72, $lang)."</p>";
                            }
                            else {
                                $result_content .= "<p>".tr::gettranslation(57, $lang)." 1 </p>";
                            }
                        }
                    }
                    else {
                        $result_content .= "<p>".tr::gettranslation(57, $lang)." 2 </p>";
                    }
                }
                //далі формується список предметів 
                $sql = "SELECT *  FROM subject ORDER BY id DESC";
                $result = $mysqli->query($sql);
                //і виводитсья цей  список як форма для видалення
                if($result && $result->num_rows > 0) {
                    $row = $mysqli->assoc($result);
                    if($row) {
                        $result_content .= "<form method='post'>";
                        $result_content .= "<h1 class='h2'>".tr::gettranslation(88, $lang)."</h1><br>";
                        
                        do
                        {
                        $result_content .= "<p class='news-edit'><input type='checkbox' value='{$row['id']}' name='list-delete[]' /><span style='margin-left: 10px;'>[ {$row['name']} ] - {$row['name']}</span></p>";
                        }
                        while($row = $mysqli->assoc($result));

                        $result_content .= "<p class='form-element'><input class='btn btn-primary' type='submit' id='reg-user-btn' name='delete-sublect' value='".tr::gettranslation(68, $lang)."' /></p>
                        <div class='line'></div>";

                        $result_content .= "</form>";
                    }
                    else {
                        $result_content = "".tr::gettranslation(57, $lang)."";
                    }
                }
                else {
                    $result_content = "".tr::gettranslation(57, $lang)."";
                }
            
                
                return $result_content; //повертається значення вмісту
        }
    }
?>