<?php
	class DeleteJournal extends CoreAdmin {
		
		public function getTitle() {//перевизначена із CoreAdmin функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(71, $lang);//повертається значення функції
		}
	
		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту
				global $mysqli;//використовуємо БД
				$lang = $_SESSION['lang'];//отримується мова із сесії
				$result_content = "";//result content поки пустий

				if(isset($_POST['del-journal'])) {//якщо натиснуто кнопку вдалення то передивляємось список вибраних елементів і видаляємо
					if(isset($_POST['list-delete'])) {
						$list = $_POST['list-delete'];
						for($i = 0; $i < count($list); $i++) {
							$res_id = $mysqli->query("SELECT id FROM eventlist WHERE id='%item1%'",$this->toInteger($list[$i]));
							if($res_id && $res_id->num_rows == 1) {
								$mysqli->query("DELETE FROM eventlist WHERE id='%item1%'", $this->toInteger($list[$i]));
								$result_content .= "<p>:Журнал видалено id({$list[$i]})</p>";
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

				//додаткові масиви

				$teachersql = "SELECT id, full_name FROM users";$teacherresult = $mysqli->query($teachersql);
            		$teach = array();
            		if($teacherresult && $teacherresult->num_rows > 0) {
						$row = $mysqli->assoc($teacherresult);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
								//формується асоціативний масив з викладачів типу ключ=>значення
								$key = $row['id'];
								$value = $row['full_name'];							 
								$teach[$key] = $value;									
							}
							while($row = $mysqli->assoc($teacherresult));
						}
						else {
							$result_content = "Error #22317 editjournal.class.php!";
						}
					}

					$subjsql = "SELECT id, name FROM subject";$subjresult = $mysqli->query($subjsql);
            		$subj = array();
            		if($subjresult && $subjresult->num_rows > 0) {
						$row = $mysqli->assoc($subjresult);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
								//формується асоціативний масив  типу ключ=>значення
								$key = $row['id'];
								$value = $row['name'];							 
								$subj[$key] = $value;									
							}
							while($row = $mysqli->assoc($subjresult));
						}
						else {
							$result_content = "Error #22317";
						}
					}

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



					//якщо викладач це робить, то видаляти може лише власні журнали

					if(isset($_SESSION['role'])){
            			echo '<script>'.$_SESSION['role'].'</script>';
						$sql = "SELECT id, grid, teacher, subject, visibility FROM eventlist WHERE teacher='".$_SESSION['role']."' ORDER BY id DESC";

					}
					else{//якщо адміістратор, то видаляти може що завгодно
						$sql = "SELECT id, grid, teacher, subject  FROM eventlist ORDER BY id DESC";
					}

				
				
				$result = $mysqli->query($sql);
				//формується код форми для видаленнян всього що можливо
				if($result && $result->num_rows > 0) {
					$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
					if($row) {
						$result_content .= "<form method='post'>
						
						<div class='line'></div>
						";
						do
						{
						$result_content .= "<p class='news-edit'><input type='checkbox' value='{$row['id']}' name='list-delete[]' /><span style='margin-left: 10px;'>".$gr[$row['grid']]." / ".$subj[$row['subject']]." / ".$teach[$row['teacher']]." / "."";



						$resultx = $mysqli->query("SELECT * FROM event where eventlist={$row['id']}" );
						$result_content .="(".$resultx->num_rows.") полів</span></p>";


						}
						while($row = $mysqli->assoc($result));
						$result_content .= "<p class='form-element block'><input  class='btn btn-primary ' type='submit' id='reg-user-btn' name='del-journal' value='".tr::gettranslation(68, $lang)."' /></p></form>";
					}
					else {
						$result_content = "".tr::gettranslation(62, $lang)."";
					}
				}
				else {
					$result_content = "".tr::gettranslation(62, $lang)."";
				}
			
				
				return $result_content;//повертається значення функції
		}
	}
?>