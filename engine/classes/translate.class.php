<?php
	class Translate extends CoreAdmin {

		public function getTitle() { // функція отримання заголовка
      		tr::initlang(); //ініціалізація перекладів
			$lang = $_SESSION['lang']; //змінна lang отримується з сесії
			return tr::gettranslation(38, $lang); //повертаємо заголовок сторінки
		}

		public function getContent() { // функція отримання вмісту
				global $mysqli; //оголошуєтсья доступ до глобальної змінної mysqli
				$result_content = ""; //поки результуючий контент пустий
        		$lang = $_SESSION['lang']; //змінна lang отримується з сесії


					if((isset($_POST['num'])) && (isset($_POST['luk'])) && (isset($_POST['lru'])) && (isset($_POST['len']))){
						//якщо встановлено всі параметри для редагування мови
						$num = $_POST['num'];
						$luk = $_POST['luk'];
						$lru = $_POST['lru'];
						$len = $_POST['len'];
						//то кожній новій змінній присвоюємоь їх значення

						$mysqli->query("UPDATE  translations SET ua='%item1%', ru='%item2%' , en='%item3%' WHERE id='%item4%'",$luk, $lru, $len, $num);
						//потім робиться update запит до mysql і оновлюється інформація в базі

						$result_content .=tr::gettranslation(45, $lang);//виводиться фраза типу переклад оновлено



					}

					//далі виводиться html  модальне вікно для редагування перекладів
					$result_content .='

					<div class="modal fade " id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  >
					    <form method="post" enctype="multipart/form-data">
					        <div class="modal-dialog" role="document">
					            <div class="modal-content">
					                <div class="modal-header">
					                    <h5 class="modal-title" id="exampleModalLabel">'.tr::gettranslation(46, $lang).'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">×</span></button></div>

					                <div class="modal-body">
															<input type="hidden" id="num" name="num">
					                    <p class="form-element"><span class="ib">українська: </span><input class="ib custom-select" id="uk" name="luk"></p>
					                    <p class="form-element"><span class="ib">русский: </span><input class="ib custom-select" id="ru" name="lru"></p>
					                    <p class="form-element"><span class="ib">english: </span><input type="text" id="en" name="len" class="ib custom-select">
					                    </p>
					                </div>

					                <div class="modal-footer">
					                    <button type="button" class="btn btn-secondary" data-dismiss="modal">'.tr::gettranslation(43, $lang).'</button>
					                    <button id="smx" name="smx" value="62" class="btn btn-primary">'.tr::gettranslation(44, $lang).'</button>
					                </div>

					            </div>
					        </div>
					    </form>
					</div>

		';
					//опісля - таблиця для перегляду перекладів
					//додається заголовок
					$result_content .="<h1 class='h2'>".tr::gettranslation(38, $lang)."</h1>";

					$result_content .= '<div class="btn-toolbar mb-2 mb-md-0">

          <div class="form-group w100">
              <input type="text" class="form-control pull-right" id="search" placeholder="'.tr::gettranslation(41, $lang).'">
          </div>

            </div><br>';

					//додаєтсья основа таблиці
					$result_content .=	"<div class='table-responsive'>
            										<table class='table table-striped table-sm' id='mytable'>
            										  <thead>
            										    <tr>
            										      <th>#</th>
            										      <th>ua</th>
            										      <th>ru</th>
            										      <th>en</th>
            										    </tr>
            										  </thead>
            										<tbody>";

            		//запит до бд на отримання списку перекладів по id
					$sql = "SELECT * FROM translations ORDER BY id DESC";


					$result = $mysqli->query($sql);
					//якщо  в результаті запиту до бд результатів більше ніж 0
					if($result && $result->num_rows > 0) {
						//з них формується асоціативний масив
						$row = $mysqli->assoc($result);
						//і для кожного рядка формуєтсья html код таблиці із змінних цього масиву (наприклад $row['ua'])
						if($row) {
							do
							{



            						$result_content .=" <tr class='rowchange' value={$row['id']} data-target='#myModal2'  data-toggle='modal'>
            												<td>{$row['id']}</td>
            												<td class=ua>{$row['ua']}</td>
            												<td class=ru>{$row['ru']}</td>
            												<td class=en>{$row['en']}</td>
            											</tr>";


							}
							while($row = $mysqli->assoc($result));//цикл do - while, тому тут while
						}
						else { //інакше
							$result_content = "перекладів немає";//не заморочувались з перекладами цієї фрази оскільки такого результату не буде
						}
					}


					else {//інакше
						$result_content = "перекладів немає";//не заморочувались з перекладами цієї фрази оскільки такого результату не буде
					}
					//до вмісту додається кінцівка таблиці
					$result_content .="</tbody></table></div>";

				return $result_content;//і повертаєтся сформована змінна
		}
	}
?>
