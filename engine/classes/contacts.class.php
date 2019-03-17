<?php
	$mysqli = db::getObject();
	class Contacts extends Core {//клас наслідує core

		public function getTitle() { // gettitle функція
			tr::initlang(); //ініціалізація перекладів//змінна lang отримується з сесії
			$lang = $_SESSION['lang'];//змінна lang отримується з сесії
			return tr::gettranslation(37, $lang);//повертаємо заголовок сторінки
		}

		public function getContent() {//getcontent функція
			global $mysqli;//оголошуєтсья доступ до БД
			$lang = $_SESSION['lang'];//змінна lang отримується з сесії
			//html формування
			$result_content = '<a class="btn btn-primary e2x" style="margin-left:0" href="?option=index"><span data-feather=home></span><p>'.tr::gettranslation(3, $lang).' </p></a> ';


					$result_content .= "<h2 style='color: #777;'>".tr::gettranslation(37, $lang)."</h2>";

					$result_content .= "<div id='contains'>".tr::gettranslation(99, $lang)."</div>";
					
			return $result_content;//повертається результат
		}
	}
?>
