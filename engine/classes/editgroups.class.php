<?php
	class EditGroups extends CoreAdmin {
		
		public function getTitle() {//перевизначена із CoreAdmin функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(85, $lang);//повертається значення функції
		}
	
		public function getContent() {//перевизначена із CoreAdmin функція отримання контенту

			$result_content='';//result content поки пустий

			$lang = $_SESSION['lang'];//отримується мова із сесії

			global $mysqli;//використовуємо БД

			if((isset($_POST['updname']))&&(isset($_GET['id']))){
				if(($_POST['updname'])!=''){//і якщо знаення не пусті
					$upd=$_POST['updname'];
					$first=$_POST['first'];
					$last=$_POST['last'];//то відповідні змінні присвоюють ці значення
					
					$query="UPDATE groups SET name='".$upd."' , first='".$first."' , last='".$last."' WHERE id='".$_GET['id']."' ";
					$mysqli->query($query);   
				}
			}

			if(isset($_GET['id'])){//якщо встановлено параметр id в адресі

				$grid=$_GET['id'];//отримується  значення id

				$query = "SELECT * FROM groups where id='".$grid."'";

				$result = $mysqli->query($query);


				$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД

				$result_content.="<form method='post' enctype='multipart/form-data'>";
					do
					{
						$result_content.= '<span style="padding-right:10px;">'.tr::gettranslation(82, $lang).'</span><input  name="updname" type=text value="'.$row['name'].'" class="ib custom-select" style="float:none;width:auto"><br><br>';

						$result_content.= '<span style="padding-right:10px;">Початок Навчання</span><input  name="first" type=text value="'.$row['first'].'" class="ib custom-select" style="float:none;width:auto"><br><br>';

						$result_content.= '<span style="padding-right:10px;">Закінчення навчання</span><input  name="last" type=text value="'.$row['last'].'" class="ib custom-select" style="float:none;width:auto"><br><br>';
					}
					while($row = $mysqli->assoc($result));

				$result_content .= " <input class='btn btn-primary' type='submit' value='".tr::gettranslation(44, $lang)."' id='reg-user-btn' name='edit'/>";

				$result_content.="</form><hr>".tr::gettranslation(29, $lang).":<hr>";





									$result_content .=	"<div class='table-responsive'>
            										<table id='myTable2' class='table table-striped table-sm'>
            										  <thead>
            										    <tr>
            										      <th onclick=sortTable(0,'myTable2')>#</th>
            										      <th onclick=sortTable(1,'myTable2')>".tr::gettranslation(24, $lang)."</th>
            										      <th onclick=sortTable(2,'myTable2')>".tr::gettranslation(17, $lang)."</th>
            										      <th onclick=sortTable(3,'myTable2')>".tr::gettranslation(30, $lang)."</th>
            										      <th onclick=sortTable(4,'myTable2')>".tr::gettranslation(31, $lang)."</th>
            										    </tr>
            										  </thead>
            										<tbody>";

            		//формуємо допоміжні масиви для зручного перегляду даних щоб виводиилсь не id,  а назви та імена

            		

					$grsql = "SELECT id, name FROM groups";
            		$grresult = $mysqli->query($grsql);
            		$gr = array();

            		if($grresult && $grresult->num_rows > 0) {
						$row = $mysqli->assoc($grresult);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
								//формується асоціативний масив типу ключ=>значення
								$key = $row['id'];
								$value = $row['name'];
								$gr[$key] = $value;
							}
							while($row = $mysqli->assoc($grresult));
						}
						else {
							$result_content = "Error";
						}
					}

					//запит до бд на отримання списку журналів
					$sql = "SELECT id, grid, label, code FROM students WHERE grid='".$_GET['id']."' ORDER BY label ASC ";
					$result = $mysqli->query($sql);

					if($result && $result->num_rows > 0) {
						$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
						if($row) { $idx=0;
							do
							{
									$idx+=1;

									$iquery="SELECT ROUND(AVG(value),2) FROM mark WHERE Student =  '".$row['id']."' ";

									$row2=$mysqli->query($iquery);

									$data = $row2->fetch_assoc();

									$mark=$data['ROUND(AVG(value),2)'];

									//print_r($data);

            						$result_content .=" <tr>
            												<td>".$idx."</td>
            												<td>{$row['label']}</td>
            												<td>".$gr[$row['grid']]."</td>
            												<td>{$row['code']}</td>
            												<td>".$mark."</td>
            											</tr>";


							}
							while($row = $mysqli->assoc($result));
						}
						else {
							$result_content = "Студентов нет!";
						}
					}


					else {
						$result_content = "Студентов нет!";
					}

					$result_content .="</tbody>
									            </table>
									          </div>";



			}
			else{

				$query = "SELECT * FROM groups";

				$result = $mysqli->query($query);


				$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
					do
					{
						$result_content.= '<div class="gruop"><a href="?option=editgroups&id='.$row['id'].'" >' . $row['name'] . '</a></div>';
					}
					while($row = $mysqli->assoc($result));

			}
				
			return $result_content;//повертається значення функції
		}
	}
?>