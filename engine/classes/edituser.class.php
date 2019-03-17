<?php
	class EditUser extends CoreAdmin {

		public function getTitle() {//перевизначена із Core функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(47, $lang);//повертається значення функції
		}

		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту
				global $mysqli;//використовуємо БД
				$lang = $_SESSION['lang'];//отримується мова із сесії
				$result_content = "";//result content поки пустий

				if(isset($_GET['id'])) {//якщо встановлено параметр id в адресі
					$id = $this->toInteger($_GET['id']);//отримується ціле значення id
					$res_id = $mysqli->query("SELECT id FROM users WHERE id='%item1%'", $id);
					if($res_id->num_rows <= 0) {
						throw new Exception(5);
						exit;
					}
					else {
						$id = $this->toInteger($_GET['id']);//отримується ціле значення id
					}
				}

				if(isset($_POST['edit-user'])) {//якщо почато редагування користувача і не встановлено id (такого бути не має) 
					if(!isset($_GET['id'])) {
						$result_content .= "Не туди";
						exit;
					}
					else {
						$id = $this->toInteger($_GET['id']);//отримується ціле значення id
					}
					if(
						isset($_POST['full_name']) && isset($_POST['code']) && isset($_POST['email']) && isset($_POST['login'])
					) {
						if(
						!empty($_POST['full_name']) && !empty($_POST['code']) && !empty($_POST['email']) && !empty($_POST['login'])
						) {//і якщо знаення не пусті
							$full_name = $_POST['full_name']; $code = $_POST['code'];
							$email = $_POST['email']; $login = $_POST['login']; //то відповідні змінні присвоюють ці значення


							if(1) {
											$mysqli->query("UPDATE users SET full_name='%item1%', password='%item2%' , email='%item3%', login='%item4%' WHERE id='%item5%'",$full_name, $code, $email, $login, intval($_GET['id']));
											$result_content .= "<p style='color: #0f0;'>".tr::gettranslation(54, $lang)."</p>";

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
				$result = $mysqli->query("SELECT * FROM users WHERE id='%item1%'",$id);

				$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД

				//форма  відправки

				$result_content .= "
					<form method='post' enctype='multipart/form-data'>
						<h3>".tr::gettranslation(16, $lang)." ".$row['full_name']."</h3>";


				//викладачі
				$result_content .= "
				<label>".tr::gettranslation(16, $lang).":</label><p class='form-element'><input class='viewas custom-select' type='text' value='".$row['full_name']."'  name='full_name'/></p>";

				$result_content .= "
				<label> ".tr::gettranslation(40, $lang).":</label><p class='form-element'><input class='viewas custom-select' type='text' value='".$row['login']."'  name='login'/></p>";

				$result_content .= "
				<label>E-mail:</label><p class='form-element'><input class='viewas custom-select' type='text' value='".$row['email']."'  name='email'/></p>";

				$result_content .= "
				<label>".tr::gettranslation(53, $lang).":</label><p class='form-element'><input class='viewas custom-select' type='password' value='".$row['password']."'  name='code'/></p>";

				$result_content .= "
				<p class='form-element' style='    display: block;'><input class='btn btn-primary' type='submit' value='".tr::gettranslation(44, $lang)."' id='reg-user-btn' name='edit-user'/></p></form>";



				}
				else {//якщо не встановлено параметр id в адресі

					//додається заголовок
					$result_content .="<h1 class='h2'>".tr::gettranslation(47, $lang)."</h1>";

					$result_content .= '<div class="btn-toolbar mb-2 mb-md-0">

            </div><br>';

					//додаєтсья основа таблиці
					$result_content .=	"<div class='table-responsive'>
            										<table class='table table-striped table-sm'>
            										  <thead>
																	<tr>
																		<th>#</th>
																		<th>".tr::gettranslation(16, $lang)."</th>
																		<th>".tr::gettranslation(40, $lang)."</th>
																		<th>email</th>
																		<th>".tr::gettranslation(33, $lang)."</th>
																		<th>".tr::gettranslation(39, $lang)."</th>
																	</tr>
            										  </thead>
            										<tbody>";

            		//формуємо допоміжні масиви для зручного перегляду даних щоб виводиилсь не id,  а назви та імена

            		//запит до бд на отримання списку журналів
					$sql = "SELECT id, full_name, login, email , registered FROM users ORDER BY registered DESC";
					$result = $mysqli->query($sql);

					if($result && $result->num_rows > 0) {
						$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
            						$result_content .=" <tr>
            												<td>{$row['id']}</td>
            												<td>{$row['full_name']}</td>
            												<td>{$row['login']}</td>
            												<td>{$row['email']}</td>
            												<td>{$row['registered']}</td>
            												<td><a href='?option=edituser&id={$row['id']}' >".tr::gettranslation(39, $lang)."</a></td>
            											</tr>";


							}
							while($row = $mysqli->assoc($result));
						}
						else {
							$result_content = " нет!";
						}
					}


					else {
						$result_content = " нет!";
					}

					$result_content .="</tbody></table></div>";

				}

				return $result_content;//повертається значення функції
		}
	}
?>
