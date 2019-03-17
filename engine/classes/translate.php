<?php

	class tr {    //клас translate (tr - скорочено)

    public static function gettranslation($id, $lang) { //функція отримання перекладу фрази з таблиці translations в базі данних
      global $mysqli; $result_content = '';  //використовується глобальна змінна mysqli (змінна з index.php). проголошується змінна result content
      $tquery = $mysqli->query("SELECT * FROM translations  WHERE id=%item1% ", $id);   //отримуємо всі переклади для кнкретної фрази в базі
      $trows = $mysqli->assoc($tquery); //утворюється асоціативний масив
        do // Do-while цикл
        {
          $result_content = $trows[$lang];//результат присвоюється як отримане поле
        }
        while ($trows = $mysqli->assoc($tquery)); //поки є рядки асоціативногго масиву
      return $result_content;//повертається значення
    }

		public static function gettlang() { //функція отримання мови за промовчанням з таблиці settings в базі данних
			global $mysqli; $result_content = '';  //використовується глобальна змінна mysqli (змінна з index.php). проголошується змінна result content
			$tquery = $mysqli->query("SELECT value FROM settings  WHERE id=2 "); //отримуємо всі значення для настройки в БД, де значення id=2 (настройки перекладів)
      $trows = $mysqli->assoc($tquery); //утворюється асоціативний масив
        do
        {
          $result_content = $trows['value'];//результат присвоюється як отримане поле асоціативного масиву з індексом value
        }
        while ($trows = $mysqli->assoc($tquery));//поки є рядки асоціативногго масиву
      return $result_content;//повертається значення
		}

		public static function initlang(){
			if(!isset($_SESSION['lang'])){//якщо не встановлено мови в сесії
				$_SESSION['lang']=tr::gettlang();//встановлюється мова з бази
			}
			if(isset($_POST['lang'])){//якщо встановлена змінна $_POST['lang'] (хтось перемкнув перемикач мов)
				$_SESSION['lang'] = $_POST['lang'];//то мова встановлюється та, що встановлена на перемикачі
			}
		}
	}
  ?>
