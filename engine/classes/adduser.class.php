<?php
	class AddUser extends CoreAdmin {
		
		public function getTitle() {//перевизначена із Core функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(55, $lang);//повертається значення функції
		}
	
		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту
				global $mysqli;//використовуємо БД
				$lang = $_SESSION['lang'];//отримується мова із сесії
				$result_content = "";//result content поки пустий
				
				if(isset($_POST['add-user'])) {
					if(
 
						isset($_POST['full_name']) &&
						isset($_POST['login']) && 
						isset($_POST['e-mail']) && 
						isset($_POST['code'])
					) {
						if(
 
						!empty($_POST['full_name']) &&
						!empty($_POST['e-mail']) && 
						!empty($_POST['login']) && 
						!empty($_POST['code'])//і якщо знаення не пусті
						) {

							$full_name = strval($_POST['full_name']);
							$email = strval($_POST['e-mail']);
							$login = strval($_POST['login']);
							$code = strval($_POST['code']); //то відповідні змінні присвоюють ці значення
							if(1){	
								 
								if(1) {						
									
									
									if(1) {

										$qo ="INSERT INTO users (id, login, password, full_name, email, registered) VALUES (NULL, '".$login."', '".$code."', '".$full_name."', '".$email."', '".date("Y-m-d")."');";

										$mysqli->query( $qo);
										
										$result_content .= "<p style='color: #0f0;'>".tr::gettranslation(56, $lang)."</p>";									 
									}
									else {
										$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
									}
									
								}
								else {
									$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
								}
							}
							else {
								$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
							}
												
						}
						else {
							$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
						}
					
					}
					else {
						$result_content .= "<p>".tr::gettranslation(57, $lang)."</p>";
					}
				}
				
				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h2>".tr::gettranslation(55, $lang)."</h2>
						<p class='form-element'>";
				

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(58, $lang).": </span><input class='custom-select' name='full_name'></p>";

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(22, $lang).": </span><input class='custom-select' name='code'></p>";

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(40, $lang).": </span><input class='custom-select' name='login'></p>";

				$result_content .= "<p class='form-element'><span>e-mail: </span><input class='custom-select' name='e-mail'></p>";
				
				
				$result_content .= "<p class='form-element'><input type='submit'  class='btn btn-primary' value='".tr::gettranslation(59, $lang)."' id='reg-user-btn' name='add-user'/></p></form>";
					
				return $result_content;//повертається значення функції
		}
	}
?>