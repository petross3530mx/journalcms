<?php
	class AddStudent extends CoreAdmin {
		
		public function getTitle() {//перевизначена із Core функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(60, $lang);//повертається значення функції
 
		}
	
		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту
				$lang = $_SESSION['lang'];//отримується мова із сесії
				global $mysqli;//використовуємо БД
				$result_content = "";//result content поки пустий
				
				if(isset($_POST['add-student'])) {
					if(
 
						isset($_POST['groups']) &&
						isset($_POST['label']) && 
						isset($_POST['code'])//якщо значення встановлено
					) {
						if(
 
						!empty($_POST['groups']) &&
						!empty($_POST['label']) && 
						!empty($_POST['code'])//і якщо знаення не пусті
						) {

							$groups = intval($_POST['groups']);
							$label = strval($_POST['label']);
							$code = strval($_POST['code']); //то відповідні змінні присвоюють ці значення
							if(1){	
								 
								if(1) {						
									
									
									if(1) {
										$mysqli->query("INSERT INTO students (grid, label, code) VALUES ('%item1%','%item2%','%item3%')",$groups,$label,$code);
									
										$result_content .= "<p style='color: #0f0;'>".tr::gettranslation(61, $lang)."</p>";									 
									}
									else {
										$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
									}
									
								}
								else {
									$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
								}
							}
							else {//Не правильний формат вводу
								$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
							}
												
						}
						else {//Заповнено не всі поля!
							$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
						}
					
					}
					else {//Заповнено не всі поля!
						$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
					}
				}
				
				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h2>".tr::gettranslation(60, $lang)."</h2>
						<p class='form-element'><span>".tr::gettranslation(17, $lang).": </span><select class='custom-select' name='groups'>";
						
				
				$result = $mysqli->query("
				SELECT id, name
				FROM groups
				");
				
				if($result && $result->num_rows > 0) {
					$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
					if($row) {
						do
						{
							$result_content .= "<option value='{$row['id']}'>{$row['name']}</option>";
						}
						while($row = $mysqli->assoc($result));
					}
					else {
						$result_content .= "<option value='-1'>".tr::gettranslation(17, $lang)."</option>";
					}
				}
				else {
					$result_content .= "<option value='-1'>".tr::gettranslation(17, $lang)."</option>";
				}
						
				$result_content .= "</select></p>";

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(58, $lang).": </span><input class='custom-select' name='label'></p>";

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(63, $lang).": </span><input class='custom-select' name='code'></p>";
				
				$result_content .= "<p class='form-element'><input type='submit' class='btn btn-primary' value='".tr::gettranslation(59, $lang)."' id='reg-user-btn' name='add-student'/></p></form>";
					
				return $result_content;//повертається значення функції
		}
	}
?>