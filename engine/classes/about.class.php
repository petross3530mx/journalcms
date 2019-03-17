<?php
	$mysqli = db::getObject();
	class About extends Core {

		public function getTitle() {//отримання заголовка
			tr::initlang();//ініціалізація мов
			$lang = $_SESSION['lang'];// отримується значення з сісії
			return tr::gettranslation(35, $lang);//повертається заголовок
		}

		public function getContent() {//отриманні вмісту
			global $mysqli;////оголошуєтсья доступ до глобальної змінної mysqli
			$lang = $_SESSION['lang'];//змінна lang отримується з сесії
			$result_content = "";//поки результуючий контент пустий
			//формується html відповіді
			$result_content .= "<h2 style='color: #777;'>".tr::gettranslation(35, $lang)."</h2>";
			$result_content .= "<div id='contains'>".tr::gettranslation(36, $lang)."</div>";

			$result_content .= '<a style="margin-left:0" class="btn btn-primary e2x" href="?option=index"><span data-feather=home></span><p>'.tr::gettranslation(2, $lang).'</p></a> ';
			//повертається відповідь
			return $result_content;
		}
	}
?>
