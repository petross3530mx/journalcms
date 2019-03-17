<?php
	class Logout extends Core {// наслідує core
		
		public function getTitle() {//функція заголовка
			return "exit";
		}
	
		public function getContent() {//функція отримання вмісту
			if(!isset($_SESSION['user'])) {//якщо не встановленно сесію користувача, припиняєтсья
				header("Location: index.php");//редірект на головну
				exit;//вихід
			}
			else {
				unset($_SESSION['user']);//інакше видаляютсья змінні сесії
				unset($_SESSION['role']);
				header("Location: index.php");//редірект на головну
				exit;
			}
			session_destroy();//припиняється сесія
			return "exit";
		}
	}
?>