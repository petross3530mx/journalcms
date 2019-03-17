<?php
$mysqli = db::getObject();
class Group extends Core
  {
    
    public function getTitle()//перевизначена із Core функція заголовку
      {
        tr::initlang();//ініціалізація класу перекладів
        $lang = $_SESSION['lang'];//отримується мова із сесії
        return tr::gettranslation(25, $lang); //повертається значення функції
      }
    
    public function getContent()//перевизначена із Core функція отримання контенту
      {
        
        $lang = $_SESSION['lang'];//отримується мова із сесії
        
        global $mysqli;//використовуємо БД
        
        $result_content = "";//result content поки пустий
        
        
        
        
        if (isset($_GET['id']))//якщо встановлено параметр в адресі
          {
            
            
            $id = $this->toInteger($_GET['id']);//отримується ціле значення id
            
            $result = $mysqli->query("SELECT * FROM eventlist WHERE id='%item1%'", $id);
            
            $row = $mysqli->assoc($result);//асоціатиний масив із результату запиту до БД
            
            $idx = $row['grid'];
            
            $result_content .= '<div class="floatright"><a class="btn btn-primary e2x" href="?option=index"><span data-feather="fe-arrow-left"></span><p>' . tr::gettranslation(3, $lang) . '</p></a><p>' . tr::gettranslation(15, $lang) . ': ';
            $subjsql    = "SELECT id, name FROM subject where id=" . $row['subject'] . " ";
            $subjresult = $mysqli->query($subjsql);
            $subj       = array();
            $row5       = $mysqli->assoc($subjresult);//асоціатиний масив із результату запиту до БД
            do
              {
                $result_content .= $row5['name'];
              } while ($row5 = $mysqli->assoc($subjresult));
            
            
            $result_content .= '</p><p>' . tr::gettranslation(16, $lang) . ':';
            
            $teachersql    = "SELECT full_name FROM users where id=" . $row['teacher'] . " ";
            $teacherresult = $mysqli->query($teachersql);
            $teach         = array();
            $row3          = $mysqli->assoc($teacherresult);//асоціатиний масив із результату запиту до БД
            do
              {
                $result_content .= "" . ($row3['full_name']) . "";
              } while ($row3 = $mysqli->assoc($teacherresult));
            
            $result_content .= '</p><p> ' . tr::gettranslation(17, $lang) . ' : ';
            $grsql    = "SELECT id, name FROM groups where id=" . $row['grid'] . "";
            $grresult = $mysqli->query($grsql);
            $gr       = array();
            if ($grresult && $grresult->num_rows > 0)
              {
                $row7 = $mysqli->assoc($grresult);//асоціатиний масив із результату запиту до БД
                if ($row7)
                  {
                    do
                      {
                        $result_content .= $row7['name'];
                      } while ($row7 = $mysqli->assoc($grresult));
                  }
                else
                  {
                    $result_content = "Error #22317 editjournal.class.php!";
                  }
              }
            
            
            
            
            
            $result_content .= '</p></div><div class="table-responsive">
                                                    <table  id="myTable2" class="outrok outroky tablex outrok2 table-striped table-sm" idx=' . $_GET["id"] . '>
                                                      <thead class="hook">
                                                        <tr >
                                                          <th onclick=sortTable(0,"myTable2")>#</th>
                                                          <th onclick=sortTable(1,"myTable2") class=""norm>' . tr::gettranslation(24, $lang) . '</th>';
            
            
            $eventlit = intval($_GET['id']);
            
            $eventlistquery = $mysqli->query("    SELECT id, label FROM event  WHERE eventlist=%item1% ORDER by timedate", $eventlit);
            
            $eventrows = $mysqli->assoc($eventlistquery);//асоціатиний масив із результату запиту до БД
            $ix        = 1;
            do
              {
                $ix += 1;
                $result_content .= "<th onclick=sortTable(" . $ix . ",'myTable2') class=vertext2 title='" . $eventrows['label'] . "' >" . $eventrows['label'] . "</th>";
                
              } while ($eventrows = $mysqli->assoc($eventlistquery));
            
            
            $result_content .= '<th>Рейтинг</th></tr> </thead>
                                                    <tbody class="hook">';
            
            $numx = 0;
            
            $result_cat = $mysqli->query("    SELECT id, label FROM students  WHERE grid='%item1%' ORDER by label", $idx);
            $rows       = $mysqli->assoc($result_cat);//асоціатиний масив із результату запиту до БД
            
            do
              {
                $numx += 1;
                
                
                $result_content2='';
                
                $eventlit = intval($_GET['id']);
                
                $eventlistquery = $mysqli->query("    SELECT id, label FROM event  WHERE eventlist=%item1%  ORDER by timedate", $eventlit);
                
                $eventrows = $mysqli->assoc($eventlistquery);//асоціатиний масив із результату запиту до БД
                
                $total=0;
                do
                  {
                    
                    $markquery = $mysqli->query("    SELECT value FROM mark  WHERE event='%item1%' AND  student='%item2%'", $eventrows['id'], $rows['id']);
                    $markrows  = $mysqli->assoc($markquery);//асоціатиний масив із результату запиту до БД
                    
                    
                    do
                      {
                        $result_content2 .= "<td class='ctr' datarows=" . $eventrows['id'] . " title='" . $eventrows['label'] . "'  >{$markrows['value']}</td>";
                        $total+=intval($markrows['value']);
                      } while ($markrows = $mysqli->assoc($markquery));
                    
                  } while ($eventrows = $mysqli->assoc($eventlistquery));
                
                  $result_content2.="<td>".$total."/100</td>";
                
                $result_content1 = "<tr student=" . $rows['id'] . "  ><td >" . $numx . "</td><td style='background: linear-gradient(to right, #fdfdfd 0%, #b2cfef {$total}%, #ffffff {$total}%);'  class='student'><a href='?option=student&id={$rows['id']}'>{$rows['label']}</a></td>";
                
                $result_content .=$result_content1.$result_content2;
                $result_content .= "</tr>";
              } while ($rows = $mysqli->assoc($result_cat));
            
            
            
            $result_content .= '</tbody></table></div>';

            $result_content .='<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>';



            $resul_content = '<canvas id="bar-chart-horizontal" width="800" height="450"></canvas>';

            $resul_content="<script>new Chart(document.getElementById('bar-chart-horizontal'), {
    type: 'horizontalBar',
    data: {
      labels: ['Africa', 'Asia', 'Europe', 'Latin America', 'North America'],
      datasets: [
        {
          label: 'Population (millions)',
          backgroundColor: ['#3e95cd', '#8e5ea2','#3cba9f','#e8c3b9','#c45850'],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});</script>";
                       
          }
        else  {  //якщо не встановлено параметр в адресі        
            $result_content .= '<a class="btn btn-primary e2x" href="?option=index"><span data-feather=home></span><p>' . tr::gettranslation(3, $lang) . '</p></a>';
            
            
            $result_content .= '
                                    <h3 class="ttx">' . tr::gettranslation(10, $lang) . '</h3>
                                    <table class=" outrok table table-striped table-sm" id="sf" style="width: 400px;" border="1" cellpadding="0" cellspacing="0">
                                          <tr>

                                            <td>
                                                <select class="custom-select" name="filt" onchange="filter1(this, ' . "'sf'" . '); this.options[0].selected = true; ">
                                                    <option value="">' . tr::gettranslation(11, $lang) . '</option>
                                                    <option value="">' . tr::gettranslation(12, $lang) . '</option>';
            
            $get = $mysqli->query("SELECT * FROM groups");
            while ($row = $mysqli->assoc($get))
              {
                $result_content .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
              }
            $result_content .= '</select></td>
            <td><select class="custom-select" name="filt" onchange="filter11(this, ' . "'sf'" . '); this.options[0].selected = true; "><option value="">' . tr::gettranslation(13, $lang) . '</option><option value="">' . tr::gettranslation(14, $lang) . '</option> ';
            
            
            $result = $mysqli->query("SELECT name FROM subject ");
            while ($row = $mysqli->assoc($result))
              {
                $result_content .= "<option class='custom-select'>" . $this->screening($row['name']) . "</option>";
              }
            $result_content .= '</select></td><td class="custom-selectx"><a>' . tr::gettranslation(31, $lang) .'</a></td></tr>';
            
            //формуємо асоціативні масиви для відобрження інформації
            
            $subjsql    = "SELECT id, name FROM subject";
            $subjresult = $mysqli->query($subjsql);
            $subj       = array();
            if ($subjresult && $subjresult->num_rows > 0)
              {
                $row = $mysqli->assoc($subjresult);//асоціатиний масив із результату запиту до БД
                if ($row)
                  {
                    do
                      {
                        //формується асоціативний масив  типу ключ=>значення
                        $key        = $row['id'];
                        $value      = $row['name'];
                        $subj[$key] = $value;
                      } while ($row = $mysqli->assoc($subjresult));
                  }
                else
                  {
                    $result_content = "Error #22317 editjournal.class.php!";
                  }
              }
            
            $grsql    = "SELECT id, name FROM groups";
            $grresult = $mysqli->query($grsql);
            $gr       = array();
            
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
                        $gr[$key] = $value;
                      } while ($row = $mysqli->assoc($grresult));
                  }
                else
                  {
                    $result_content = "Error #22317 editjournal.class.php!";
                  }
              }
            
            $result = $mysqli->query("SELECT * FROM eventlist ");
            while ($row = $mysqli->assoc($result))
              {
                if (intval($row['visibility']) != 0)
                  {
                    $grid    = intval($row['grid']);
                    $mid     = intval($row['id']);
                    $subject = intval($row['subject']);


                  $iquery="SELECT ROUND(AVG(value),2) FROM mark WHERE Student='1' ";

                   $iquery = "SELECT ROUND(AVG(value),2) FROM mark WHERE event IN (SELECT id FROM event WHERE eventlist=".$mid.")";


                  $row2=$mysqli->query($iquery);

                  $data = $row2->fetch_assoc();

                  $mark=$data['ROUND(AVG(value),2)'];


                    $result_content .= "<tr>
                                      		<td class='custom-selectx'><a href='?option=group&id=" . $mid . "'>" . $gr[$grid] . "</a></td>
                                            <td class='custom-selectx'><a href='?option=group&id=" . $mid . "'>" . $subj[$subject] . "</a></td>
                                            <td class='custom-selectx'><a href='?option=group&id=" . $mid . "'>". $mark."</a></td>
                                       </tr>";
                  }
              }
            
            $result_content .= '</table>';
            
          }
   
        return $result_content; //повертається значення функції
      }
  }
?>