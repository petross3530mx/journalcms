<?php
	if(!defined('ROOT'))//якщо не встановлено  замінної ROOT, то встановити її
		define('ROOT',"default");

	abstract class CoreAdmin { //абстрактний клас coreadmin

		public function __construct() {
			session_start();//функція PHP викликається для старту сесії
			if(!isset($_SESSION['admin'])) {//якщо не всатновлено параметру $_SESSION['admin'],
				header("Location: index.php?option=login"); // то перейти на вхід і зупинити конструктор
				exit;
			}
		}

		private $_templates = "admin"; //визначення назви шаблону адмінпанелі

		private function replaceAFile($html_tmp) {//функція перебору файлів шаблону
			$tmp_name = $this->_templates;//отримуєтьс назва шаблону
			preg_match_all("/%(.*)%/", $html_tmp, $replaceArray);//екрануються спецсимволи
			for($i = 0; $i < count($replaceArray[0]); $i++) {  // перебір масиву файлів
				$file_url_replace = ROOT."/engine/templates/".$tmp_name."/".$replaceArray[1][$i].".php";//формуєтсья назва і адреса файлу
				if(file_exists($file_url_replace)) {//якщо файл існує
					$replaceContent = file_get_contents($file_url_replace);// присвоєння змінній значення вмісту за адресою файлу
					$html_tmp = str_replace($replaceArray[0][$i], $replaceContent, $html_tmp);//заміна адрес файлів на їх вміст в змінній $html_tmp
				}
			}
			return $html_tmp;//повертається значення  $html_tmp
		}

		private function replaceOnlyRootTmp($html_tmp) {//заміна мітки %root%
			$tmp_name = $this->_templates;//отримується назва шаблону
			$rootURL = "engine/templates/".$tmp_name;//отримується адреса шаблону
			$html_tmp = str_replace("%root%", $rootURL, $html_tmp);// заміна мітки %root% на адресу root в $html_tmp
			return $html_tmp;//повертаєстья значення $html_tmp
		}


		private function replaceOnlyContent($html_tmp) {////замінити %content% мітку на контент
			$content = $this->getContent();//отримується контент в змінну з конкретного підключеного файлу
			$html_tmp = str_replace("%content%", $content, $html_tmp);//в оброблювану з шаблону змінну $html_tmp йде заміна мітки на сам вміст
			return $html_tmp;//повертаєстья значення $html_tmp
		}

		private function replaceOnlyTitle($html_tmp) {//заміна мітки %title%  на заголовок
			$title = $this->getTitle();//отримується заголовок з підключеного PHP файлу
			$html_tmp = str_replace("%title%", $title, $html_tmp);//в оброблювану з шаблону змінну $html_tmp йде заміна мітки на сам заголовок
			return $html_tmp;//повертаєстья значення $html_tmp
		}

		public function screening($text) {////функція  трансляції спецсимволів з PHP
			$symbol = array(//створюється масив  спецсимволів'
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
				$uniq_file = ROOT."/uniq_include/".$this->unicName().".php";////створюється файл  з унікальним іменем
				file_put_contents($uniq_file, $html);//записати вміст в файл

				require_once $uniq_file;//підключення файлу

				if(file_exists($uniq_file)) {//якщо файл існує,-видалити
					unlink($uniq_file);//
				}
			}
			else {
				throw new Exception('1'); //інакше повернути помилку
			}
		}

		public function unicName() {//функція генерації випадкових назв
			$uniq_name_start = md5(uniqid());//сформувати псевдовипадкову змінну
			$file_ex = ROOT."/uniq_include/".$uniq_name_start.".php";//згенерувати назву і адресу файлу за правилом
			if(!file_exists($file_ex))//перевірити нявність файлу
				return $uniq_name_start;//повернути унікальну назву
			else//інакше
				$this->unicName();//викликати функцію ще раз
		}

		public function unicFileName($root_file, $extends) {//функція унікального імені
			$uniq_name_start = md5(uniqid());//генеруєтсья унікальний хеш
			$file_ex = $root_file."/".$uniq_name_start.".".$extends;// формується назва файлу
			if(!file_exists($file_ex))//якщо файлу ще не існує
				return $uniq_name_start;//повернути цю назву
			else// інакше
				$this->unicName();// викликати  функцію unicName
		}

		protected function getView($format_string="") {//функція отримання перегляду
			$tmp_name = $this->_templates;//ім'я поточного шаблону
			$get_view = "";//оголошенні змінних
			$result = "";
			$get_view_url = ROOT."/engine/templates/". $tmp_name . "/view.php";//адреса переглду
			if(!file_exists($get_view_url)) {// якщо фаайл не існує, повернути false
				return false;
			}
			else {//інакше
				$get_view = file_get_contents($get_view_url);//змінна присвоює вміст файлу
			}

			$result = $get_view;//присвоюється результат

			$format_string = explode(";;", $format_string);//аналіз отриманих переметрів, перетворення
			for($j = 0; $j < count($format_string); $j++) {//цикл перебору отриманих змінних
				$extd = explode("=", $format_string[$j]);//розбиття строки на підстроки, тепер розділювач - знак =
				if(isset($extd[0]) && isset($extd[1])) {//якщо обидва значення існують, то
					if(preg_match("/^%(.*)%$/", $extd[0])) {//відекранувати символи
						$result_string = $extd[1];//додати ліву частину
						if(isset($extd[2])) {//і якщо встановлена права частина
							for($i = 2; $i < count($extd); $i++) {//цикл перебору
								$result_string .= "=".$extd[$i];//додати через дорівнює праву частину
							}
						}
						$result = str_replace($extd[0], $this->screening($result_string), $result);//транслювати змінну строки в резуультат
					}
				}
			}
			return str_replace("<?","&lt;?",$result);//повернути результат з обробленими спецсимволами
		}

		public function toInteger($int) {//функція отримання цілого значення
			return abs((int)$int);//повернути це значення
		}

		public function pageNav($nPage, $count) { //посторінкова навігація

			global $mysqli;

			$limit = 2;

			$lim_res = $mysqli->query("SELECT * FROM settings WHERE title='%item1%'","page");
			if($lim_res->num_rows == 1) {
				$row_lim = $mysqli->assoc($lim_res);
				$limit = $row_lim['value'];
				$res_p_nav = "";
				$first = "";
				$back = "";
				$page2left = "";
				$page1left = "";
				$page = "<span class='light-page-nav'>{$nPage}</span>";
				$page1right = "";
				$page2right = "";
				$forward = "";
				$last = "";

				$uri = "?";

				if($_SERVER['QUERY_STRING']) {
					foreach($_GET as $key => $value) {
						if($key != "page")
							$uri .= "{$key}={$value}&";
					}
				}


				$pages = ceil($count / $limit);



				if($nPage > 3) {
					$first = "<a href='{$uri}page=1' class='dark-page-nav'>&laquo;</a>";
				}
				if($nPage < ($pages - 2)) {
					$last = "<a href='{$uri}page=".( $pages )."' class='dark-page-nav'>&raquo;</a>";
				}

				if($nPage > 1) {
					$back = "<a href='{$uri}page=".($nPage-1)."' class='dark-page-nav'>&lt;</a>";
				}
				if($nPage < $pages) {
					$forward = "<a href='{$uri}page=".($nPage+1)."' class='dark-page-nav'>&gt;</a>";
				}

				if(($nPage - 2) > 0) {
					$page2left = "<a href='{$uri}page=".($nPage - 2)."' class='dark-page-nav'>".($nPage - 2)."</a>";
				}

				if(($nPage - 1) > 0) {
					$page1left = "<a href='{$uri}page=".($nPage - 1)."' class='dark-page-nav'>".($nPage - 1)."</a>";
				}

				if(($nPage + 1) < $pages) {
					$page2right = "<a href='{$uri}page=".($nPage + 2)."' class='dark-page-nav'>".($nPage + 2)."</a>";
				}

				if(($nPage) < $pages) {
					$page1right = "<a href='{$uri}page=".($nPage + 1)."' class='dark-page-nav'>".($nPage + 1)."</a>";
				}

				$res_p_nav .= "<div id='navigation-page'>";

				$res_p_nav .= $first.$back.$page2left.$page1left.$page.$page1right.$page2right.$forward.$last;

				$res_p_nav .= "</div>";



				return $res_p_nav;

			}

		}

		abstract function getContent();//абстрактна функція отримання вмісту
		abstract function getTitle();//абстрактна функція отримання заголовку
	}
?>
