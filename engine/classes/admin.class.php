<?php
	class Admin extends CoreAdmin {//наслідує coreadmin

		public function getTitle() {//функція отримання загловка
			tr::initlang();
			$lang = $_SESSION['lang'];
			return tr::gettranslation(42, $lang);
		}

		public function getContent() {//функція отримання вмісту

			$lang = $_SESSION['lang'];//присвоєння змінної мов із змінно сесії

 			$result_content = "";

			if(isset($_SESSION['role'])){//якщо встановлена роль , тобто це вже не адміністратор, а звичайний користувач

				global $mysqli;
				//формується уже html відповідь
				$result_content.="<p class='houmi'>".tr::gettranslation(48, $lang).", <strong>";
				//запит до БД щоб отримати по id вкладача ім'я'
				$sql = "SELECT full_name FROM users WHERE id='".$_SESSION['role']."'";

				$result = $mysqli->query($sql);


							$row = $mysqli->assoc($result);
							do
							{
								$result_content.= $row['full_name']; //і це ім'я додаєтсья до виводу'
							}
							while($row = $mysqli->assoc($result));

				$result_content.="</strong>!</p>".tr::gettranslation(100, $lang)."";//html




				//шукаємо кількість оцінювань і журналів
				$sql = "SELECT id, grid, teacher, subject, visibility FROM eventlist WHERE teacher='".$_SESSION['role']."' ORDER BY id ASC";

				$result = $mysqli->query($sql); $result_content.="".$result->num_rows." <br>";

				$rez=0;
	
							$row = $mysqli->assoc($result);
							do
							{
								$resultx = $mysqli->query("SELECT * FROM event where eventlist={$row['id']}" );
								 $rez+=$resultx->num_rows;
								 $row2 = $mysqli->assoc($resultx);

								 while($row2 = $mysqli->assoc($resultx));
							}
							while($row = $mysqli->assoc($result));


				$result_content .= tr::gettranslation(101, $lang).$rez."<br>";




			}
				else{//якщо це адміністратор то формується html
				$result_content .=" <p class='houmi'>".tr::gettranslation(48, $lang).", <strong>". $_SESSION['admin']. "</strong>!</p>
				<div class='houmi'>

					<a href='?option=index'><span data-feather='home'></span><p>".tr::gettranslation(2, $lang)."</p></a>
					<a href='?option=editjournal'><span data-feather='file-text'></span><p>".tr::gettranslation(1, $lang)."</p></a>

					<a href='#'><span data-feather='folder'></span><p>".tr::gettranslation(49, $lang)."</p></a>
					<a href='?option=editstudent'><span data-feather='users'></span><p>".tr::gettranslation(50, $lang)."</p></a>

					<a href='?option=edituser'><span data-feather='users'></span><p>".tr::gettranslation(51, $lang)."</p></a>
					<a href=''><span data-feather='bar-chart-2'></span><p>".tr::gettranslation(52, $lang)."</p></a>

				</div>";
			}

			//повертається результат
				return $result_content;
		}
	}
?>
