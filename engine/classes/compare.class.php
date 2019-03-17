<?php
	$mysqli = db::getObject();
	class Compare extends Core {

		public function getTitle() {//перевизначена із Core функція заголовку
			tr::initlang();//ініціалізація класу перекладів
			$lang = $_SESSION['lang'];//отримується мова із сесії
			return tr::gettranslation(26, $lang);//повертається значення функції
		}

		public function getContent() {//перевизначена із Core функція отримання контенту

			$lang=$_SESSION['lang'];//отримується мова із сесії

			global $mysqli;//використовуємо БД

			$result_content = "";//result content поки пустий

			if (isset($_GET['id'])){//якщо встановлено параметр в адресі


				$id = $this->toInteger($_GET['id']);//отримується ціле значення id

				$result = $mysqli->query("SELECT * FROM eventlist WHERE id='%item1%'",$id);

				$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД

				$idx=$row['grid'];

				



			$grsql    = "SELECT * FROM groups";
            $grresult = $mysqli->query($grsql);
            $gr       = array();
            $yr       = date("Y");

            
            if ($grresult && $grresult->num_rows > 0)
              {
                $row = $mysqli->assoc($grresult);//асоціатиний масив із результату запиту до БД
                if ($row)
                  {
                    do
                      {
                        //формується асоціативний масив типу ключ=>значення
                        $key      = $row['id'];
                        $value    = $row['name'];
                        $last    = $row['last'];
                        $first    = $row['first'];
                        $gr[$key][0] = $key;
                        $gr[$key][1] = $value;
                        $gr[$key][2] = $first;
                        $gr[$key][3] = $last; 
                      } while ($row = $mysqli->assoc($grresult));
                  }
                else
                  {
                    $result_content = "Error #22317 editjournal.class.php!";
                  }
              }


            $coursea = array($_GET['id']); 
            $yra = array();

            $yyr       = array();

			foreach ($gr as $key) {
			    //echo $key[1].$key[2].$key[3];
			    $course = $yr - $key[2];
			    $grpid = $key[1];

			    if(in_array($course, $coursea)){
			    	//$result_content.= "група" .$grpid." курс".$course. "/";
			    	//grpid = 

			    	$elst    = "SELECT * FROM eventlist WHERE grid=".$key[0];
			    	//$result_content .= $elst;
		            $elresult = $mysqli->query($elst);
  
		            if ($elresult && $elresult->num_rows > 0)
		              {
		                $elrow = $mysqli->assoc($elresult);//асоціатиний масив із результату запиту до БД
		                if ($elrow)
		                  {
		                    do
		                      {
			                      	if(!in_array($elrow['year'], $yyr)){
			                      			$yyr[] = $elrow['year'];
									    }
		                      } while ($elrow = $mysqli->assoc($elresult));
		                  }
		                else
		                  {
		                    $result_content = "Error #22317 editjournal.class.php!";
		                  }
		              }
			    }
			}

			$result_content.= 'групи';
			foreach ($gr as $key) {

						 $course = $yr - $key[2];

						 if(in_array($course, $coursea)){
		              		$result_content.='<div class=grlst>'.$key[1].'</div>';
		              		}
		       }


					rsort($yyr) ;
		              foreach ($yyr as $key) {

		              	$result_content.='<div class=yearc><hr><div class=clear><p>'.$key.':<hr></p></div><hr>';

		              	$result_content.='<div class=firstrow>';

		              	$yaerel = "SELECT * FROM eventlist WHERE visibility=1 AND semestr=1 AND year=".$key;

		              	 $yur = $mysqli->query($yaerel);
 

						            if ($yur && $yur->num_rows > 0)
						              {
						                $grow = $mysqli->assoc($yur);//асоціатиний масив із результату запиту до БД
						                if ($grow)
						                  {
						                    do
						                      {

						                      	$result_content.='<div class=clsem>';
						                        //формується асоціативний масив типу ключ=>значення
						                        $Avgq="SELECT ROUND(AVG(value),2) FROM mark WHERE event IN (SELECT id FROM event WHERE eventlist='".$grow['id']."') ";
						                        $row2=$mysqli->query($Avgq);
						                        $data = $row2->fetch_assoc();
						                        $mark=$data['ROUND(AVG(value),2)'];



						                        $result_content .="<div class=soldu teacher=".$grow['teacher']." subject=".$grow['subject']."  grid=".$grow['grid']." mark=".$mark." >";
						                        $result_content .=$grow['year']." / ".$grow['semestr'];
						                        $result_content .="</div></div>";
 
						                      } while ($grow = $mysqli->assoc($yur));
						                  }
						                else
						                  {
						                    $result_content = "Error #22317 editjournal.class.php!";
						                  }
						              }

						              $result_content.='</div><div class=secrow>';

						              $yaerel = "SELECT * FROM eventlist WHERE visibility=1 AND semestr=2  AND year=".$key;

		              	 $yur = $mysqli->query($yaerel);
 

						            if ($yur && $yur->num_rows > 0)
						              {
						                $grow = $mysqli->assoc($yur);//асоціатиний масив із результату запиту до БД
						                if ($grow)
						                  {
						                    do
						                      {

						                      	$result_content.='<div class=clsem>';
						                        //формується асоціативний масив типу ключ=>значення
						                        $Avgq="SELECT ROUND(AVG(value),2) FROM mark WHERE event IN (SELECT id FROM event WHERE eventlist='".$grow['id']."') ";
						                        $row2=$mysqli->query($Avgq);
						                        $data = $row2->fetch_assoc();
						                        $mark=$data['ROUND(AVG(value),2)'];



						                        $result_content .="<div class=soldu teacher=".$grow['teacher']." subject=".$grow['subject']."  grid=".$grow['grid']." mark=".$mark." >";
						                        $result_content .=$grow['year']." / ".$grow['semestr'];
						                        $result_content .="</div></div>";
 
						                      } while ($grow = $mysqli->assoc($yur));
						                  }
						                else
						                  {
						                    $result_content = "Error #22317 editjournal.class.php!";
						                  }
						              }

						              $result_content.='</div>';



		              $result_content.='<div class=clear></div></div>';}
            //  print_r($gr);
			}

			else{





				$result = $mysqli->query("SELECT * FROM eventlist WHERE id='%item1%'");

				$row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД

				$idx=$row['grid'];

				



			$grsql    = "SELECT * FROM groups";
            $grresult = $mysqli->query($grsql);
            $gr       = array();
            $yr       = date("Y");

            
            if ($grresult && $grresult->num_rows > 0)
              {
                $row = $mysqli->assoc($grresult);//асоціатиний масив із результату запиту до БД
                if ($row)
                  {
                    do
                      {
                        //формується асоціативний масив типу ключ=>значення
                        $key      = $row['id'];
                        $value    = $row['name'];
                        $last    = $row['last'];
                        $first    = $row['first'];
                        $gr[$key][1] = $value;
                        $gr[$key][3] = $first;
                        $gr[$key][2] = $last; 
                      } while ($row = $mysqli->assoc($grresult));
                  }
                else
                  {
                    $result_content = "Error #22317 editjournal.class.php!";
                  }
              }


            $coursea = array(); 

             $st='<p  class=center>'.tr::gettranslation(114, $lang).'</p><hr><div class=courses><a href=/?option=compare&id=1><div class=nm>1</div><p>'.tr::gettranslation(114, $lang).'</p></a><a href=/?option=compare&id=2><div class=nm>2</div><p>'.tr::gettranslation(114, $lang).'</p></a><a href=/?option=compare&id=3><div class=nm>3</div><p>'.tr::gettranslation(114, $lang).'</p></a><a href=/?option=compare&id=4><div class=nm>4</div><p>'.tr::gettranslation(114, $lang).'</p></a><a href=/?option=compare&id=5><div class=nm>5</div><p>'.tr::gettranslation(114, $lang).'</p></a></div>';

             $fs='<p class=center>'.tr::gettranslation(115, $lang).'</p><hr><div class=courses>';

			foreach ($gr as $key) {

				$course = $yr - $key[3];

				$end = $yr -  $key[2];

			    //$result_content.= "<hr>група ".$key[1]."/ конец".$key[2]."/ начало".$key[3]."/ курс". $course." /<hr>";

			   
			    
			    
			    if( $end > 0 ){
			    	if(!in_array($course, $coursea)){
			    	$coursea[] = $course;
			    		$fs.='<a href=/?option=compare&id='.$course.'>'.tr::gettranslation(115, $lang).' '.$key[2].'</a>';
			    	}
			    	

			    }
			    else{
			    	//$st.='<a href=/?option=compare&id='.$course.'>курс '.$course.'</a>';
			    }

			    


			    if(!in_array($course, $coursea)){
			    	$coursea[] = $course;

			    	//print_r($course);
			    	//print_r($coursea);
			    }

			}
			$fs.='</div>';

			$result_content.=$st."<hr>".$fs;

			//print_r($gr);


				}



			return $result_content;//повертається значення функції
		}
	}
?>
