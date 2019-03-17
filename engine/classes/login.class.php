<?php
    class Login extends Core {//login наслідує core

        public function getTitle() {//функція заголовка
          tr::initlang();
          $lang = $_SESSION['lang'];
          return tr::gettranslation(19, $lang);
        }
        public function getContent() {//функція отримання вмісту
            $lang = $_SESSION['lang'];//встановлюється мова
            if(isset($_SESSION['admin'])) {//якщо встановлено змінну сесії адмін
                header("Location: index.php?option=admin");//то відбувається редірект в адмінпанель
                exit;//і вихід звідси
            }
            else {//інакше

                $result_content = "";//присвоюємо result content пусте значення

             if (isset($_POST['sbmt'])) { //якщо є запит на відновлення паролю
                
                $eventx = 1;//додаткова змінна  для того  щоб перевіряти наявність пошти  в списку адрес
                
                if (isset($_POST['mail'])) { //перевіряємо, чи надійшла пошта в запит
                    
                    $mail = $_POST['mail'];//і присвоєння значення змінної
                    
                    global $mysqli;// глобальна змінна mysqli

                    //ствроюється SQL запит для еревірки наявності користувачів в системі
                    
                    $eventlistquery = $mysqli->query("    SELECT * FROM users ");
                    $eventrows      = $mysqli->assoc($eventlistquery);
                    do {
                        if ($mail == $eventrows['email']) {
                            //якщо пошта є в списку пошт, додається до допоміжної змінної 1
                            $eventx += 1;
                            //формується html  листа

                            $rs = '. Логін:' . strval($eventrows['login']) . '. Пароль:' . strval($eventrows['password']);
                            //перетворення html сутностеей для надсилання
                            $result = htmlentities($rs);
                            
                            $result2 = strval($result);
                            
                            //підключається SMTP клас і надсилаються на пошту дані для входу 
                            require_once "sendmail.class.php";
                            $mailSMTP = new SendMailSmtpClass('chor.komitet@yandex.com', 'an_7870', 'ssl://smtp.yandex.ru', 'Journal', 465);
                            $headers  = "MIME-Version: 1.0\r\n";
                            $headers .= "Content-type: text/html; charset=utf-8\r\n";
                            $headers .= "From: Journal <chor.komitet@yandex.com>\r\n";
                            $result = $mailSMTP->send($mail, 'Відновлення паролю до облікового запису ', $result, $headers);
                            if ($result === true) {
                                $result_content .= tr::gettranslation(90, $lang) ." ". $mail . ". ". tr::gettranslation(91, $lang) ;
                            } else {
                                $result_content .= tr::gettranslation(92, $lang)  . $mail . "," . tr::gettranslation(93, $lang);
                            }
                        }
                        
                    } while ($eventrows = $mysqli->assoc($eventlistquery));
                    
                }
                if ($eventx == 1) { //якщо електронної адреси немає в переліку користувачів
                    $result_content .= tr::gettranslation(94, $lang) . $mail . tr::gettranslation(95, $lang);
                }
                
            }


                
                if(isset($_POST['admin-login'])) {//якщо запит на вхід до системи
                    if(!empty($_POST['login']) && !empty($_POST['password'])) {
                        global $mysqli;
                        //перевірка хешу
                        $hash_admin = md5($_POST['login'].";".$_POST['password']);
                        //запит до бД
                        $result = $mysqli->query("SELECT hash FROM admin WHERE hash='%item1%'",$hash_admin);
                        //якщо одне співпадіння, то 
                        if($result && $result->num_rows == 1) {
                            //присвоюється змінна сесіїї результату введеному в полі логіна
                            $_SESSION['admin'] = $_POST['login'];
                            //редірект
                            header("Location: index.php?option=admin");
                            exit;
                        }
                        else {

                            // інакше присвоюється логін і пароль з пост масиву
                            $login=$_POST['login'];

                            $pass=$_POST['password'];

                            // формуєтсья запит до таблиці викладачів у БД
                            $subjsql = "SELECT id, login, password FROM users WHERE login='".$login."' AND password='".$pass."' ";

                            //запит до БД
                            $subjresult = $mysqli->query($subjsql);
                            $subj = array();
                            $row5 = $mysqli->assoc($subjresult);

                            unset($_SESSION['role']);

                            //прибираєм роль із змінних сесії
                                do
                                {
                                    //присвоюються логін і пароль із введених у системі
                                    $log = $row5['login'];
                                    $px = $row5['password'];

                                    if(($log==$login)&&($px==$pass)){//порівнюємо чи є вони у тих, що в базі

                                                                    $_SESSION['admin'] = $_POST['login'];
                                                                    $_SESSION['role'] = $row5['id'];
                                                                    header("Location: index.php?option=admin");
                                                                    // якщо так, то відбуваєтсья вхід в систему від імені викладача
                                                                    exit;
                                    }
                                }
                            while($row5 = $mysqli->assoc($subjresult));

                        }
                        $result_content .= "<div class='centertext'>".tr::gettranslation(20, $lang)."</div>";
                        //повідомлення про помилку авторизації
                    }
                    else {
                        $result_content .= "<div class='centertext'>".tr::gettranslation(20, $lang)."</div>";
                    }
                }
                //формування html коду форми входу
                $result_content .= "

                    <form class='form-signin' method='post'>

                         <input type='text' name='login' class='form-control' placeholder='".tr::gettranslation(21, $lang)."'>
                         <input type='text' name='password' class='form-control' type='password' placeholder='".tr::gettranslation(22, $lang)."'>
                        <p><input class='btn btn-lg btn-primary btn-block' type='submit' name='admin-login' value='".tr::gettranslation(23, $lang)."' /></p>
                        <a  data-toggle='modal' data-target='#myModal'>".tr::gettranslation(96, $lang)."</a>
                    </form>

                ";

                //формування коду модального вікна відновлення паролю

                $result_content .= '
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form method="post" enctype="multipart/form-data">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">'.tr::gettranslation(97, $lang).'</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <p class="form-element"><span class="ib ibx">E-mail: </span><input class="ib ibx custom-select" name="mail"></p>
                                                                             
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.tr::gettranslation(43, $lang).'</button>
                                        <button type="submit" name="sbmt" value="sbmt" class="btn btn-primary">'.tr::gettranslation(98, $lang).'</button>
                                      </div>
                                    </div>
                                  </div>
                                 </form>';


                return $result_content;
                //повертається вміст сторінки
            }
        }
    }
?>
