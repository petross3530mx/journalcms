<?php
	class AdmLogOut extends CoreAdmin {// наслідує coreadmin
		
		public function getTitle() {//функція заголовка
			return "exit()";
		}
	
		public function getContent() {//функція отримання вмісту
				global $mysqli;
				$result_content = "";
				
				if(!isset($_SESSION['admin'])) {
					header("Location: index.php");//редірект на головну
					exit;
				}
				
					unset($_SESSION['admin']);	unset($_SESSION['role']);//unset 
				header("Location: index.php");//редірект на головну
				exit;
				
				return $result_content;
		}
	}
?>