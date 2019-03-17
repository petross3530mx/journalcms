<?php

	$mysqli = db::getObject();// отримується бд

	class Index extends Core {// клас наслідує core

		public function getTitle() {//функція отримання заголовку
			tr::initlang();//ініціалізація мови
			$lang = $_SESSION['lang']; //змінна lang отримується з сесії
			return tr::gettranslation(18, $lang);//повертаємо заголовок сторінки
		}

		public function getContent() {// функція отримання вмісту
			global $mysqli;//оголошуєтсья доступ до глобальної змінної mysqli
			$lang = $_SESSION['lang']; //змінна lang отримується з сесії
			//поки результуючий контент пустий
			$result_content = "";
			//генерація html
			$result_content .= "
			<div class='houmi'><div class='outro'>

					<a href='?option=group'><span data-feather='file-text'></span><p>".tr::gettranslation(4, $lang)."</p></a>
					<a href='?option=compare'><span data-feather='bar-chart-2'></span><p>".tr::gettranslation(5, $lang)."</p></a>

					<a href='?option=student'><span data-feather='users'></span><p>".tr::gettranslation(6, $lang)."</p></a>
					<a href='?option=teacher'><span data-feather='users'></span><p>".tr::gettranslation(7, $lang)."</p></a>

					<a href='?option=about'><span data-feather='folder'></span><p>".tr::gettranslation(8, $lang)."</p></a>
					<a href='?option=contacts'><span data-feather='mail'></span><p>".tr::gettranslation(9, $lang)."</p></a>

			</div><div>";
			//повертаємо значення 
			return $result_content;
		}
	}
?>
