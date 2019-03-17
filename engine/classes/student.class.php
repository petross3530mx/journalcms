<?php
	$mysqli = db::getObject();
	class Student extends Core {

		public function getTitle() {//перевизначена із Core функція заголовку
			tr::initlang();//ініціалізація класу перекладів

			global $mysqli;

			if(isset($_GET['id'])){

					$stqsql = "SELECT * FROM students where id='".$_GET['id']."'";

            		$stdurestlt = $mysqli->query($stqsql);
 
            		$nm='';

            		if($stdurestlt && $stdurestlt->num_rows > 0) {
						$studrow = $mysqli->assoc($stdurestlt);//асоціатиний масив із результату запиту до БД
						if($studrow) {
							do
							{
								
								$nm = $studrow['label'];
							}
							while($studrow = $mysqli->assoc($stdurestlt));
						}
						else {
							$result_content = "Error";
						}
					}



				return $nm .' студент';
			}
			else{
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(28, $lang);
			}
		}

		public function getContent() {//перевизначена із Core функція отримання контенту

			$yaerr=array();
			$predmett=array();

			$lang = $_SESSION['lang'];//отримується мова із сесії

			global $mysqli;//використовуємо БД

			$result_content = "";//result content поки пустий

			//виводитья таблиця студентів

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

					$subjsql3 = "SELECT id, name FROM subject";
            		$subjresult = $mysqli->query($subjsql3);
            		$sbjx = array();

            		if($subjresult && $subjresult->num_rows > 0) {
						$subjrow = $mysqli->assoc($subjresult);//асоціатиний масив із результату запиту до БД
						if($subjrow) {
							do
							{
								//формується асоціативний масив типу ключ=>значення
								$key = $subjrow['id'];
								$value = $subjrow['name'];
								$sbjx[$key] = $value;
							}
							while($subjrow = $mysqli->assoc($subjresult));
						}
						else {
							$result_content = "Error";
						}
					}


 

				if(isset($_GET['id'])){
					$id=intval($_GET['id']);
					$groupid=0;
					//запит до бд на отримання списку студентів
					$sql = "SELECT  grid, label, code FROM students where id='".$id."'";
					$result = $mysqli->query($sql);

					if($result && $result->num_rows > 0) {

						

						$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
						if($row) { $idx=0;
							do
							{
									$idx+=1;

									$iquery="SELECT ROUND(AVG(value),2) FROM mark WHERE Student =  '".$id."' ";

									$row2=$mysqli->query($iquery);

									$data = $row2->fetch_assoc();

									$mark=$data['ROUND(AVG(value),2)'];

									//print_r($data);

            						$result_content .=" <div class=stud> 
            												<div class='left'>".tr::gettranslation(24, $lang)."</div><div>{$row['label']}</div>
            												<div class='left'>".tr::gettranslation(17, $lang)."</div><div>".$gr[$row['grid']]."</div>
            												<div class='left'>".tr::gettranslation(30, $lang)."</div><div>{$row['code']}</div>
            												<div class='left'>".tr::gettranslation(31, $lang)."</div><div>".$mark."</div>
            											</div><hr>";
            											$groupid = $row['grid'];

							}
							while($row = $mysqli->assoc($result));
						}
						else {
							$result_content = "Студентов нет!";
						}


					$filtrquery = 'SELECT subject, year FROM eventlist WHERE grid='.$groupid.'  AND visibility=1 ORDER BY year DESC ' ;


            		$filterresult = $mysqli->query($filtrquery);


            		if($filterresult && $filterresult->num_rows > 0) {
						$filterrow = $mysqli->assoc($filterresult);//асоціатиний масив із результату запиту до БД
						if($filterrow) {
							do
							{

								$value=$filterrow['subject'];
								if(!in_array($value, $predmett)){
						        $predmett[]=$value;
						        }

						        $value=$filterrow['year'];
								if(!in_array($value, $yaerr)){
						        $yaerr[]=$value;
						        }
								
							}
							while($filterrow = $mysqli->assoc($filterresult));
						}
						else {
							$result_content = "Error";
						}
					}



					// print_r($yaerr);
					// print_r($predmett);




					$result_content.='<div class="filter"><p>'.tr::gettranslation(27, $lang).':</p><div><p>'.tr::gettranslation(110, $lang).':</p><select class="sel-year"><option value="jobx">'.tr::gettranslation(109, $lang).'</option>';


					foreach($yaerr as $key => $value):

					$vul=array_search($value, $yaerr);
					$result_content.='<option value="yr-'.$vul.'">'.$value.'</option>'; //close your tags!!
					endforeach;


					$result_content.='</select></div><div><p>'.tr::gettranslation(112, $lang).':</p><select class="sel-sem"><option value="jobx">'.tr::gettranslation(109, $lang).'</option><option value="sem-1">1</option><option value="sem-2">2</option></select></div><div><p>'.tr::gettranslation(111, $lang).':</p><select class="sel-dubj"><option value="jobx">'.tr::gettranslation(109, $lang).'</option>';

					foreach($predmett as $key => $value):
					$result_content.='<option value="sub-'.$value.'">'.$sbjx[$value].'</option>'; //close your tags!!
					endforeach;


					$result_content.='</select></div></div>';

					$result_content.='<hr>
					<div class="cawr"><div class="jobx"><div class="jobx"><div class="jobx"><div class="acord1"><div class="con con1"><div class="cls0">'.tr::gettranslation(111, $lang).'</div></div><div class="con con2"><div class="cls4">  '.tr::gettranslation(113, $lang).'</div></div><div class="con con3"><a>'.tr::gettranslation(39, $lang).'</a></div></div></div></div></div></div>';

					
					$grsql = "SELECT * FROM eventlist WHERE grid=  '".$groupid."' AND visibility=1 ORDER BY year DESC ";
            		$grresult = $mysqli->query($grsql);
            		$gr = array();

            		if($grresult && $grresult->num_rows > 0) {

						$row = $mysqli->assoc($grresult);//асоціатиний масив із результату запиту до БД
						if($row) {
							do
							{
								$classxcawpr='';

								$vul=array_search($row['year'], $yaerr);

								$classxcawpr.=' sub-'.$row['subject'].' yr-'.$vul.' sem-'.$row['semestr'];


								$result_content.="<div class='cawpr".$classxcawpr."'><div class='jobx'><div class='jobx'><div class='jobx'><div class='acord1' ><div class='con con1'><div class=cls0>".$sbjx [ intval($row['subject'])]." </div><div class=cls2> "    .$row['year']." </div><div class=cls3> / ".$row['semestr'].   " ".tr::gettranslation(112, $lang)."  </div></div><div class='con con2'><div class=cls4>";

									$val=0;$marked=0;


								$grsql23 = "SELECT * FROM event where eventlist=".$row['id']." ORDER BY  timedate";
													//$result_content.="<hr>".$grsql2;
								            		$gtx54 = $mysqli->query($grsql23);

								            		if($gtx54 && $gtx54->num_rows > 0) {
														$rwymk = $mysqli->assoc($gtx54);//асоціатиний масив із результату запиту до БД
														if($rwymk) {
															do
															{
																$id = $rwymk['id'];

																$myssql="SELECT value FROM mark WHERE student='".$_GET['id']."' AND event=".$id;
																$medl=$mysqli->query($myssql);
																$medl= $mysqli->assoc($medl);


																$val+=1;
																$marked+=$medl['value'];

																;

																

																//print_r($medl);
																

																//$result_content.='</div>';
																

															}
															while($rwymk = $mysqli->assoc($gtx54));
														}
														else {
															$result_content = "Error";
														}
													}



								$result_content.=$marked ."   </div></div><div class='con con3'><a href='?option=group&id=".$row['id']."'>".tr::gettranslation(39, $lang)."</a></div></div></div></div></div></div>";
								//print_r($row);//формується асоціативний масив типу ключ=>значення

							}
							while($row = $mysqli->assoc($grresult));
						}
						else {
							$result_content = "Error";
						}
					}
						 

					}


				}
				else{
				$result_content .="<h1 class='h2'>".tr::gettranslation(29, $lang)."</h1>";

					$result_content .= '<div class="btn-toolbar mb-2 mb-md-0"></div><br>';

					//додаєтсья основа таблиці
					$result_content .=	"<div class='table-responsive'>
            										<table id='myTable2' class='table table-striped table-sm'>
            										  <tbody>
            										    <tr>
            										      <th onclick=sortTable(0,'myTable2')>#</th>
            										      <th onclick=sortTable(1,'myTable2')>".tr::gettranslation(24, $lang)."</th>
            										      <th  >"

            										      .tr::gettranslation(17, $lang)."



            										      <select class='custom-select' name='filt' onchange=filter3(this,'myTable2');>
													<option value=>- Select a group -</option>
													<option value=''>All groups</option><option value='545иi'>545иi</option><option value='550ст'>550ст</option><option value='555а'>555а</option><option value='519а'>519а</option><option value='ssd'>ssd</option><option value='545а'>545а</option><option value='Uhegf'>Uhegf</option></select>


            										      </th>
            										      <th onclick=sortTable(3,'myTable2')>".tr::gettranslation(30, $lang)."</th>
            										      <th onclick=sortTable(4,'myTable2')>".tr::gettranslation(31, $lang)."</th>
            										    </tr>
            										  ";

            		//формуємо допоміжні масиви для зручного перегляду даних щоб виводиилсь не id,  а назви та імена

            		

					

					//запит до бд на отримання списку студентів
					$sql = "SELECT id, grid, label, code FROM students ORDER BY label ASC";
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
            												<td><a href='?option=student&id={$row['id']}' >{$row['label']}</a></td>
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

					$result_content .="</tbody></table></div>";



				}

			return $result_content;//повертається значення функції


		
	}}


?>
