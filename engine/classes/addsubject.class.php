<?php
	class AddSubject extends CoreAdmin {//клас наслідує coreadmin
		
		public function getTitle() {//заголовок
			tr::initlang();
			$lang = $_SESSION['lang'];
			return tr::gettranslation(108, $lang);//повертається заголовок
		}
	
		public function getContent() {//контент
				global $mysqli;//робота за БД'

			$lang = $_SESSION['lang'];//ініціалізація мови та змінної result content
				$result_content = "";
				
				if(isset($_POST['add-subject'])) {//якщо в масиві $_POST є інформація про те, що відправлено форму додавання предмету, то  
					if(
 
						isset($_POST['name']) //перевірка на те, чи надіслано ім'я'
					) {
						if(
 
						!empty($_POST['name']) //і чи воно не порожнє
						) {

							$full_name = strval($_POST['name']);
							$typo = strval($_POST['typo']);

										// запит до бд на  додавання в БД  новго предмету і вивід повідомлення

										$qo ="INSERT INTO subject (name, type) VALUES ('".$full_name."', '".$typo."');";

										$mysqli->query( $qo);
							
										$result_content .= "<p style='color: #0f0;'>Предмет додано!</p>";									 
 
												
						}
						else {//Заповнено не всі поля!
							$result_content .= "<p>".tr::gettranslation(107, $lang)."</p>";
						}
					
					}
					else {//Заповнено не всі поля!
						$result_content .= "<p>".tr::gettranslation(107, $lang)."</p>";
					}
				}
				//форма додавання предмету
				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h2>".tr::gettranslation(108, $lang)."<h2>
						<p class='form-element'>";
				

				$result_content .= "<p class='form-element'><span>назва: </span><input class='custom-select' name='name'></p>";

				$result_content .= "<p class='form-element'><span>тип: </span><select class='custom-select' name='typo'><option value=1>".tr::gettranslation(103, $lang)."</option><option value=2>".tr::gettranslation(104, $lang)."</option><option value=3>".tr::gettranslation(105, $lang)."</option><option value=4>".tr::gettranslation(106, $lang)."</option></select></p>";
				
				$result_content .= "<p class='form-element'><input type='submit'  class='btn btn-primary' value='Додати' id='reg-user-btn' name='add-subject'/></p></form>";
					
				return $result_content;//повертається html вміст
		}
	}
?>