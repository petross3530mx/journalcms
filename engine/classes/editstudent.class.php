<?php
	class EditStudent extends CoreAdmin {
		
		public function getTitle() {//перевизначена із CoreAdmin функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(64, $lang);//повертається значення функції
		}
	
		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту
			$lang = $_SESSION['lang'];//отримується мова із сесії
				global $mysqli;//використовуємо БД
				$result_content = "";//result content поки пустий
				
				if(isset($_GET['id'])) {//якщо є в адресі то
					$id = $this->toInteger($_GET['id']);//отримується ціле значення id
					$res_id = $mysqli->query("SELECT id FROM students WHERE id='%item1%'", $id);
					if($res_id->num_rows <= 0) {
						throw new Exception(5);
						exit;
					}
					else {
						$id = $this->toInteger($_GET['id']);//отримується ціле значення id
					}
				}
				
				if(isset($_POST['edit-student'])) {
					if(!isset($_GET['id'])) {
						$result_content .= "Не туди";
						exit;
					}
					else {
						$id = $this->toInteger($_GET['id']);//отримується ціле значення id
					}
					if(
						isset($_POST['label']) &&
						isset($_POST['code']) &&
						isset($_POST['grid'])
					) {
						if(
						!empty($_POST['label']) &&
						!empty($_POST['code']) &&
						!empty($_POST['grid']) //і якщо знаення не пусті
						) {
							$label = $_POST['label'];
							$code = $_POST['code'];
							$grid = $_POST['grid'];//то відповідні змінні присвоюють ці значення
 
							if(1) {


											
											$mysqli->query("UPDATE students SET grid='%item1%', label='%item2%' ,code='%item3%' WHERE id='%item4%'",$grid, $label,$code, intval($_GET['id']));
											$result_content .= "<p style='color: #0f0;'>Новость обновлена!</p>";
										



							}
							else {
								$result_content .= "<p>exeption!</p>";
							}
												
						}
						else {
							$result_content .= "<p>Вы указали не все поля!</p>";
						}
					
					}
					else {
						$result_content .= "<p>Вы указали не все поля!</p>";
					}
				}
					
				if(isset($_GET['id'])) {//якщо встановлено параметр id в адресі
				$result = $mysqli->query("SELECT * FROM students WHERE id='%item1%'",$id);
				
				$row = $mysqli->assoc($result);		//асоціатиний масив із результату запиту до БД

				//форма  відправки

				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h3>Студент ".$row['label']."</h3>
						<p class='form-element'><span>група: </span><select class='viewas' name='grid'>";
				$result_cat = $mysqli->query("
				SELECT id, name
				FROM groups
				");
				
				if($result_cat && $result_cat->num_rows > 0) {
					$rows = $mysqli->assoc($result_cat);//асоціатиний масив із результату запиту до БД
					if($rows) {
						do
						{
							if($row['grid'] == $rows['id'])
								$result_content .= "<option value='{$rows['id']}' selected>{$rows['name']}</option>";
							else
								$result_content .= "<option value='{$rows['id']}'>{$rows['name']}</option>";
						}
						while($rows = $mysqli->assoc($result_cat));
					}
					else {
						$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
					}
				}
				else {
					$result_content .= "<option value='-2'>".tr::gettranslation(62, $lang)."</option>";
				}
						
						
				$result_content .= "</select></p>";

				//form
				$result_content .= "
				<p class='form-element'><input class='viewas' type='text' value='".$row['label']."'  name='label'/></p>";

				$result_content .= "
				<p class='form-element'><input class='viewas' type='text' value='".$row['code']."'  name='code'/></p>";
				
				$result_content .= "
				<p class='form-element'><input type='submit' value='".tr::gettranslation(44, $lang)."' id='reg-user-btn' name='edit-student'/></p></form>";
				
				
				
				}
				else { //якщо не встановлено параметр в адресі

					//додається заголовок
					$result_content .="<h1 class='h2'>".tr::gettranslation(64, $lang)."</h1>";

					$result_content .= '<div class="btn-toolbar mb-2 mb-md-0">
              
            </div><br>';

					//додаєтсья основа таблиці
					$result_content .=	"<div class='table-responsive'>
            										<table class='table table-striped table-sm'>
            										  <thead>
            										    <tr>
            										      <th>#</th>
            										      <th>".tr::gettranslation(24, $lang)."</th>
            										      <th>".tr::gettranslation(17, $lang)."</th>
            										      <th>".tr::gettranslation(30, $lang)."</th>
            										      <th>".tr::gettranslation(39, $lang)."</th>
            										    </tr>
            										  </thead>
            										<tbody>";

            		//формуємо допоміжні масиви для зручного перегляду даних щоб виводиилсь не id,  а назви та імена

            		

					$grsql = "SELECT id, name FROM groups";
            		$grresult = $mysqli->query($grsql);
            		$gr = array();

            		if($grresult && $grresult->num_rows > 0) {
						$row = $mysqli->assoc($grresult);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
								//формується асоціативний масив типу ключ=>значення
								$key = $row['id'];
								$value = $row['name'];							 
								$gr[$key] = $value;									
							}
							while($row = $mysqli->assoc($grresult));
						}
						else {
							$result_content = "Error #22317 editjournal.class.php!";
						}
					}

					//запит до бд на отримання списку students
					$sql = "SELECT id, grid, label, code FROM students ORDER BY id ASC";
					$result = $mysqli->query($sql);
					
					if($result && $result->num_rows > 0) {
						$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
            						$result_content .=" <tr>
            												<td>{$row['id']}</td>
            												<td>{$row['label']}</td>
            												<td>".$gr[$row['grid']]."</td>
            												<td>{$row['code']}</td>
            												<td><a href='?option=editstudent&id={$row['id']}' >".tr::gettranslation(39, $lang)."</a></td>
            											</tr>";
                
									
							}
							while($row = $mysqli->assoc($result));
						}
						else {
							$result_content = tr::gettranslation(62, $lang);
						}
					}


					else {
						$result_content = tr::gettranslation(62, $lang);
					}

					$result_content .="</tbody></table></div>";

				}
				
				return $result_content;//повертається значення функції
		}
	}
?>