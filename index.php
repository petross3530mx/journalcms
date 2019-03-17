<?php
	// Отримання кореня сайту
	$root_result = str_replace("\\","/",dirname(__FILE__));
	define('ROOT',$root_result);
	// перевірка на виключення
	try {
		// Створення масиву з адресами основних файлів (класи core, підключення о БД, клас core admin)
		$include_list = array( ROOT."/engine/classes/core.class.php", ROOT."/engine/classes/translate.php", ROOT."/engine/classes/db.class.php", ROOT."/engine/classes/coreadmin.class.php" );
		// Підключення файлів з масиву
		for($i = 0; $i < count($include_list); $i++) {
			if(file_exists($include_list[$i])){
				require_once $include_list[$i];
			}
		}

		// Підключення класу index за промовчанням
		$option = "index";
		$req_option_index  = ROOT."/engine/classes/index.class.php";

		// якщо встановлений пареметр option отримуємо його
		if(isset($_GET['option'])) {

			//формування змінної, значення якої отримується з GET параметра option

			$ob_option = $_GET['option'];
			//підключаєтсья файл для класу з папки engine/classes
			$req_class = ROOT."/engine/classes/".$ob_option.".class.php";

			if(file_exists($req_class)) {//якщо файл існує

				require_once $req_class;//підключається файл
				if(class_exists($ob_option)) {//перевіряється в ньому наявність відповідного класу
					$option = $ob_option;//і якщо клас у файлі існує, то  підключається поція
				}
			}
		}

		// якщо option index - отримуємо головну сторінку
		if($option == "index")
			require_once $req_option_index;


		$view = new $option; //закінчується підключення класів

		$mysqli = db::getObject();//підключається БД

		$view->getBody();//отримується код сторіки з класу

	}
	catch(Exception $e) {//якщо є помилка, то вона виводиться
		header("Location: error.php?error=".$e->getMessage());
	}


?>
