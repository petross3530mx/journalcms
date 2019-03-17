<?php
	class AddJournal extends CoreAdmin {

		public function getTitle() {//перевизначена із CoreAdmin функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(69, $lang);//повертається значення функції
		}

		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту
				global $mysqli;//використовуємо БД
				$lang = $_SESSION['lang'];//отримується мова із сесії
				$result_content = "";//result content поки пустий

				if(isset($_POST['add-journal'])) {//якщо масив отриманих значень з форм містить add journal (тобто була натиснута кнопка)
					if(	isset($_POST['groups']) && isset($_POST['subject']) )
					 {
						if(

						!empty($_POST['groups']) &&
						!empty($_POST['subject']) //і якщо знаення не пусті
						) {

							$groups = intval($_POST['groups']);
							$subject = intval($_POST['subject']);
							$semestr = intval($_POST['semestr']);
							$year = intval($_POST['yer']);
							$user='';
							//то відповідні змінні присвоюють ці значення

							if(isset($_SESSION['role'])){
								$user = $_SESSION['role'];
							}
							else{
								$user = $_POST['user'];
							}
							//механізм додавання журналів викладачем


									if(1) {
										$quer = "INSERT INTO eventlist ( grid, teacher, subject, semestr, year) VALUES ( ".$groups.", ".$user.",  ".$subject.",  ".$semestr.",  ".$year." )";
										$mysqli->query( $quer );

										$result_content .= "<p style='color: #0f0;'>".tr::gettranslation(70, $lang)."!</p>";

									}

							else {
								$result_content .= "<p>1</p>";
							}

						}
						else {//Вы указали не все поля!
							$result_content .= "<p> 2</p>";
						}

					}
					else {//Вы указали не все поля!
						$result_content .= "<p>3</p>";
						
					}
				}
				//виведення html форми на додавання журналу
				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h2>".tr::gettranslation(69, $lang)."</h2>
						<p class='form-element'><span>".tr::gettranslation(17, $lang).": </span><select id=changator1  class='custom-select' name='groups'>";


				$result = $mysqli->query("
				SELECT *
				FROM groups
				");

				$min=999;
				$max=999;

				if($result && $result->num_rows > 0) {
					$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
					if($row) {
						do
						{
							if ($min==999){$min=intval($row['first']);}
							if ($max==999){$max=intval($row['last']);}
							$result_content .= "<option  value='{$row['id']}' first='{$row['first']}' last={$row['last']}>{$row['name']}</option>";
						}
						while($row = $mysqli->assoc($result));
					}
					else {
						$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
					}
				}
				else {
					$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
				}


				$result_content .= "</select></p>";



				$result_content .= "<p class='form-element'><span>".tr::gettranslation(15, $lang).": </span><select class='custom-select' name='subject'>";


				$result = $mysqli->query("
				SELECT id, name
				FROM subject
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
						$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
					}
				}
				else {
					$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
				}


				$result_content .= "</select></p>";

				$disabled='';
				//якщо додає викладач, то спочатку елемент буде не видимим
				if(isset($_SESSION['role'])){
								$disabled=' disabled ';

							}
							else{
								$disabled='';
							}

				$result_content .= "<p class='form-element'><span>".tr::gettranslation(16, $lang).": </span><select ".$disabled."   class='custom-select' name='user'>";


				$result = $mysqli->query("
				SELECT id, full_name
				FROM users
				");


 
				if($result && $result->num_rows > 0) {
					$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
					if($row) {
						do
						{
 

							if(isset($_SESSION['role'])){
								if($row['id']==$_SESSION['role']){
									$result_content .= "<option value='{$row['id']}'>{$row['full_name']}</option>";
								}

							}
							else{
								$result_content .= "<option value='{$row['id']}'>{$row['full_name']}</option>";
							}



						}
						while($row = $mysqli->assoc($result));
					}
					else {
						$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
					}
				}
				else {
					$result_content .= "<option value='-1'>".tr::gettranslation(62, $lang)."</option>";
				}


				$result_content .= "</select></p>";




				$result_content .= "
				<p class='form-element'><span>Семестр</span><select   class='custom-select' name='semestr'><option value=1>1 семестр, зимова сесія (1.02 - 1.07)</option><option value=2>2 семестр, літня сесія (1.09 - 1.02)</option></select></p>";

				$result_content .= "
				<p class='form-element'><span>Рік</span><input id='changator2' type= number  min='".$min."' max='".$max."' value=".intval(date("Y"))." class='custom-select' name='yer'></p>";



				$result_content .= "<p class='form-element'><input class='btn btn-primary' type='submit' value='".tr::gettranslation(59, $lang)."' id='reg-user-btn' name='add-journal'/></p>

				</form>";




				return $result_content;//повертається значення функції
		}
	}
?>
