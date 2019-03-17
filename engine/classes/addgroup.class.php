<?php
	class AddGroup extends CoreAdmin {//наслідує coreadmin
		
		public function getTitle() {// заголовок
  
			tr::initlang();//ініціалізація перекладів
			$lang = $_SESSION['lang'];//змінна lang отримується з сесії
			return tr::gettranslation(89, $lang);//повертаємо заголовок сторінки
		}
	
		public function getContent() {//вміст
			$lang = $_SESSION['lang'];//змінна lang отримується з сесії
				global $mysqli;//оголошуєтсья доступ до глобальної змінної mysqli
				$result_content = "";//поки результуючий контент пустий
				
				if(isset($_POST['add-group'])) {//якщо POST змінна add-group встановлена
					if
 
						( (isset($_POST['name']) )  && (isset($_POST['year1']) ) && (isset($_POST['year2']) )  ) 
						{//і встановлено всі її параметри
						if (  (!empty($_POST['name']))&& (!empty($_POST['year1']))&&(!empty($_POST['year2'])) ) {
							//відповідним змінним привоюютьяс значення параметрів
							$full_name = strval($_POST['name']);
							$year1 = intval($_POST['year1']);
							$year2 = intval($_POST['year2']);
							//робитьзся запит до бд і обробляється результат
										$qo ="INSERT INTO groups (name, first, last) VALUES ('".$full_name."' , '".$year1."' ,'".$year2."'  );";
										$mysqli->query( $qo);								
										$result_content .= "<p style='color: #0f0;'>Предмет додано!</p>";									 
 
 				
						}
						else {//вивести попередження
							$result_content .= "<p>Заповнено не всі поля!</p>";
						}
					
					}
					else {//вивести попередження
						$result_content .= "<p>Заповнено не всі поля!</p>";
					}
				}
				//формується html форми
				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h2>".tr::gettranslation(89, $lang)."</h2>
						<p class='form-element'>";
				

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(82, $lang).": </span><input class='custom-select' name='name'></p>";

				$result_content .= "<p class='form-element'><span>Рік початку: </span><input type=number min=1910 max=".(intval(date("Y")))." class='custom-select' name='year1'></p>";

				$result_content .= "<p class='form-element'><span>Рік закінчення: </span><input type=number min=1900 max=".(intval(date("Y"))+5)." class='custom-select' name='year2'></p>";
				
				$result_content .= "<p class='form-element'><input type='submit'  class='btn btn-primary' value='Додати' id='reg-user-btn' name='add-group'/></p></form>";
					//і повертається вміст
				return $result_content;
		}
	}
?>