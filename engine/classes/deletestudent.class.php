<?php
	class DeleteStudent extends CoreAdmin {
		
		public function getTitle() { // функція отримання заголовка
			tr::initlang();//ініціалізація перекладів
			$lang = $_SESSION['lang'];//змінна lang отримується з сесії
			return tr::gettranslation(65, $lang);//повертаємо заголовок сторінки
		}
	
		public function getContent() { // функція отримання вмісту
				global $mysqli; //оголошуєтсья доступ до БД
				$lang = $_SESSION['lang'];//змінна lang отримується з сесії
				$result_content = "";//змінна поки пуста
				if(isset($_POST['delete-student'])) {//якщо в запиті було видалення студента
					if(isset($_POST['list-delete'])) {//отримуєтсья списко на видалення
						$list = $_POST['list-delete'];//присвоюється змінна цьому значенню
						for($i = 0; $i < count($list); $i++) {//перебір масиву
							$res_id = $mysqli->query("SELECT id, label FROM students WHERE id='%item1%'",$this->toInteger($list[$i]));
							if($res_id && $res_id->num_rows == 1) {
								$mysqli->query("DELETE FROM students WHERE id='%item1%'", $this->toInteger($list[$i]));
								$result_content .= "<p>".tr::gettranslation(66, $lang)." id({$list[$i]}) ".tr::gettranslation(67, $lang)."</p>";
							}
							else {
								$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
							}
						}
					}
					else {
						$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
					}
				}
				//далі формується список студентів
				$sql = "SELECT id, label, code  FROM students ORDER BY id DESC";
				$result = $mysqli->query($sql);
				//і виводитсья цей  список як форма для видалення
				if($result && $result->num_rows > 0) {
					$row = $mysqli->assoc($result);
					if($row) {
						$result_content .= "<form method='post'>";
						$result_content .= "<h1 class='h2'>".tr::gettranslation(65, $lang)."</h1><br>";//заголовок
						
						do
						{
						$result_content .= "<p class='news-edit'><input type='checkbox' value='{$row['id']}' name='list-delete[]' /><span style='margin-left: 10px;'>[ {$row['code']} ] - {$row['label']}</span></p>";
						}
						while($row = $mysqli->assoc($result));

						$result_content .= "<p class='form-element'><input class='btn btn-primary' type='submit' id='reg-user-btn' name='delete-student' value='".tr::gettranslation(68, $lang)."' /></p>
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