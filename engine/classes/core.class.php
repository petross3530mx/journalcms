<?php
	if(!defined('ROOT'))  //якщо не встановлено  замінної ROOT, то встановити її
		define('ROOT',"default");

	abstract class Core {//абстрактний клас core

		public function __construct() { //конструктор
			session_start(); //функція PHP викликається для старту сесії
		}

		private $_templates = "frontend"; //стандартний шаблон

		private function replaceAFile($html_tmp) {//функція заміни файлу
			$tmp_name = $this->_templates;//отримується назва шаблону
			preg_match_all("/%(.*)%/", $html_tmp, $replaceArray);//перетворення html символів для коректної заміни в наборі файлів $replaceArray

			for($i = 0; $i < count($replaceArray[0]); $i++) {//цикл
				$file_url_replace = ROOT."/engine/templates/".$tmp_name."/".$replaceArray[1][$i].".php"; //генерація назви файлу
				if(file_exists($file_url_replace)) {//якщо файл існує
					$replaceContent = file_get_contents($file_url_replace);//замінений контент = отримання вмісту з файлу
					$html_tmp = str_replace($replaceArray[0][$i], $replaceContent, $html_tmp); //результуючий html = заміна $replaceArray[0][$i] на  $replaceContent
				}
			}
			return $html_tmp;//повертаєтсья тимчасовий html
		}

		private function replaceOnlyRootTmp($html_tmp) {//заміна мітки %root%
			$tmp_name = $this->_templates;//отримується назва шаблону
			$rootURL = "engine/templates/".$tmp_name;//отримується адреса шаблону
			$html_tmp = str_replace("%root%", $rootURL, $html_tmp); // заміна мітки %root% на адресу root в $html_tmp
			return $html_tmp;//повертаєстья значення $html_tmp
		}


		private function replaceOnlyContent($html_tmp) {//замінити %content% мітку на контент
			$content = $this->getContent();//отримується контент в змінну з конкретного підключеного файлу
			$html_tmp = str_replace("%content%", $content, $html_tmp);//в оброблювану з шаблону змінну $html_tmp йде заміна мітки на сам вміст
			return $html_tmp; //повертаєстья значення $html_tmp
		}

		private function replaceOnlyTitle($html_tmp) {//заміна мітки %title%  на заголовок
			$title = $this->getTitle();//отримується заголовок з підключеного PHP файлу
			$html_tmp = str_replace("%title%", $title, $html_tmp);//в оброблювану з шаблону змінну $html_tmp йде заміна мітки на сам заголовок
			return $html_tmp; //повертаєстья значення $html_tmp
		}
/*
& lt; & gt; це об'єкти, які використовуються у HTML та XML-документах.
Вони зазвичай не потрібні у PHP-коді.
Якщо потрібно вивести HTML з кодом PHP, тоді HTML-частина, яку ви виводите, може містити їх,

використовуєстья також, щоб не можна було використати фактичний код,
тут використовується при трансляції спецсимволів з PHP в HTML код, також щоб при роботі з БД символи не виконувались як код
*/
		public function screening($text) { //функція  трансляції спецсимволів з PHP
			$symbol = array( //створюється масив  спецсимволів'
				"<?" => "&lt;?",
				"?>" => "?&gt;",
				"$" => "\$"
			);

			foreach($symbol as $key => $value) {//foreach масив перебору символів в змінній $text
				$text = str_replace($key, $value, $text);//заміна спецсимволів в змінній $text
			}
			return $text;//повертаєтсья значення змінної
		}

		public function getBody() {//отримання вмісту сторінки
			$tmp_name = $this->_templates;//отримати назву шаблону
			$tmp_url = ROOT."/engine/templates/".$tmp_name."/main.php";//отримати адресу головного файлу шаблону

			if(file_exists($tmp_url)) {//якщо файл існує,
				$html = file_get_contents($tmp_url);// створити змінну з вмісту файлу шаблону
				$html = $this->replaceAFile($html);// замінити все згідно з мітками
				$html = $this->replaceOnlyRootTmp($html);//
				$html = $this->replaceOnlyTitle($html);//
				$html = $this->replaceOnlyContent($html);//
				$uniq_file = ROOT."/uniq_include/".$this->unicName().".php";//створюється файл  з унікальним іменем
				file_put_contents($uniq_file, $html);//записати вміст в файл

				require_once $uniq_file;// підключення файлу

				if(file_exists($uniq_file)) {//якщо файл існує,-видалити
					unlink($uniq_file);
				}
			}
			else {
				throw new Exception('1');//інакше повернути помилку
			}
		}

		private function unicName() {//функція генерації випадкових назв
			$uniq_name_start = md5(uniqid());//сформувати псевдовипадкову змінну
			$file_ex = ROOT."/uniq_include/".$uniq_name_start.".php";// згенерувати назву і адресу файлу за правилом
			if(!file_exists($file_ex))//перевірити нявність файлу
				return $uniq_name_start;// повернути унікальну назву
			else //інакше
				$this->unicName();//викликати функцію ще раз
		}

		protected function getView($format_string="") {//функція отримання перегляду, коли є набір форматованих параметрів, наприаклад
			//a=b;c=d;e=f

			$tmp_name = $this->_templates;//отримується  назва шаблону
			$get_view = "";//оголошуються пусті змінні
			$result = "";
			$get_view_url = ROOT."/engine/templates/". $tmp_name . "/view.php"; // адреса файлу перегляду за промовчанням
			if(!file_exists($get_view_url)) {//якщо файл не існує
				return false;//повернути false в getview
			}
			else { //інакше
				$get_view = file_get_contents($get_view_url);//присвоїти змінній  вміст відповідного файлу.
			}

			$result = $get_view; //  і присвоїти файлу відповідне значення

			$format_string = explode(";;", $format_string); //прийняти розділtення елементів масиву через ;

			for($j = 0; $j < count($format_string); $j++) {//тепер аналізуються отримані елементи через =
				$extd = explode("=", $format_string[$j]);
				if(isset($extd[0]) && isset($extd[1])) {
					if(preg_match("/^%(.*)%$/", $extd[0])) {
						$result_string = $extd[1];
						if(isset($extd[2])) {
							for($i = 2; $i < count($extd); $i++) {
								$result_string .= "=".$extd[$i];
							}
						}
						$result = str_replace($extd[0], $this->screening($result_string), $result);
					}
				}
			}
			return str_replace("<?","&lt;?",$result);
		}

		public function toInteger($int) {//функція отримання цілого значення
			return abs((int)$int);//повернути відповідне значення
		}

		abstract function getContent();//абстрактна функція отримання вмісту
		abstract function getTitle();//абстрактна функція отримання заголовку
	}
?>
