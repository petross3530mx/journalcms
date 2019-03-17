<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="?option=admin">
          <span data-feather="home"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Адмінпанель';}if($_SESSION['lang']=='ru'){echo 'Админпанель';}if($_SESSION['lang']=='en'){echo 'Adminpanel';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?option=index">
          <span data-feather="file"></span>
          <? if($_SESSION['lang']=='ua'){echo 'На сайт';}if($_SESSION['lang']=='ru'){echo 'На сайт';}if($_SESSION['lang']=='en'){echo 'Go Home';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?option=admlogout">
          <span data-feather="users"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Вихід';}if($_SESSION['lang']=='ru'){echo 'Выход';}if($_SESSION['lang']=='en'){echo 'Logout';} ?>
        </a>
      </li>
      <hr class="sidehr">
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <a class="d-flex align-items-center text-muted" >
        <span>
        <? if($_SESSION['lang']=='ua'){echo 'Журнали';}if($_SESSION['lang']=='ru'){echo 'Журналы';}if($_SESSION['lang']=='en'){echo 'Journals';} ?>
         </span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='addjournal')){echo 'active';} ?>" href="?option=addjournal">
          <span data-feather="plus-circle"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Додати';}if($_SESSION['lang']=='ru'){echo 'Добавить';}if($_SESSION['lang']=='en'){echo 'Add';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='editjournal')){echo 'active';} ?>" href="?option=editjournal">
          <span data-feather="file-text"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Переглянути';}if($_SESSION['lang']=='ru'){echo 'Смотреть';}if($_SESSION['lang']=='en'){echo 'View';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='deletejournal')){echo 'active';} ?>" href="?option=deletejournal">
          <span data-feather="trash"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Видалити';}if($_SESSION['lang']=='ru'){echo 'Удалить';}if($_SESSION['lang']=='en'){echo 'Delete';} ?>
        </a>
      </li>
      <hr class="sidehr">
    </ul>

      <?	if(!isset($_SESSION['role'])){ ?>
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <a class="d-flex align-items-center text-muted" href="#">
        <span>
        <? if($_SESSION['lang']=='ua'){echo 'Студенти';}if($_SESSION['lang']=='ru'){echo 'Студенты';}if($_SESSION['lang']=='en'){echo 'Students';} ?>
        </span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='addstudent')){echo 'active';} ?>" href="?option=addstudent">
          <span data-feather="user-plus"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Додати';}if($_SESSION['lang']=='ru'){echo 'Добавить';}if($_SESSION['lang']=='en'){echo 'Add';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='editstudent')){echo 'active';} ?>" href="?option=editstudent">
          <span data-feather="users"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Переглянути';}if($_SESSION['lang']=='ru'){echo 'Смотреть';}if($_SESSION['lang']=='en'){echo 'View';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='deletestudent')){echo 'active';} ?>" href="?option=deletestudent">
          <span data-feather="user-minus"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Видалити';}if($_SESSION['lang']=='ru'){echo 'Удалить';}if($_SESSION['lang']=='en'){echo 'Delete';} ?>
        </a>
      </li>
      <hr class="sidehr">
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <a class="d-flex align-items-center text-muted" href="#">
        <span>
          <? if($_SESSION['lang']=='ua'){echo 'Викладачі';}if($_SESSION['lang']=='ru'){echo 'Преподаватели';}if($_SESSION['lang']=='en'){echo 'Teachers';} ?>
         </span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='adduser')){echo 'active';} ?>" href="?option=adduser">
          <span data-feather="user-plus"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Додати';}if($_SESSION['lang']=='ru'){echo 'Добавить';}if($_SESSION['lang']=='en'){echo 'Add';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  <? if(($_GET['option']=='edituser')){echo 'active';} ?>" href="?option=edituser">
          <span data-feather="users"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Переглянути';}if($_SESSION['lang']=='ru'){echo 'Смотреть';}if($_SESSION['lang']=='en'){echo 'View';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  <? if(($_GET['option']=='deleteuser')){echo 'active';} ?>" href="?option=deleteuser">
          <span data-feather="user-minus"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Видалити';}if($_SESSION['lang']=='ru'){echo 'Удалить';}if($_SESSION['lang']=='en'){echo 'Delete';} ?>
        </a>
      </li>
      <hr class="sidehr">
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <a class="d-flex align-items-center text-muted" href="?option=addnews">
        <span>
          <? if($_SESSION['lang']=='ua'){echo 'Предмети';}if($_SESSION['lang']=='ru'){echo 'Предметы';}if($_SESSION['lang']=='en'){echo 'Subjects';} ?>
        </span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="?option=addsubject">
          <span data-feather="plus-circle"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Додати';}if($_SESSION['lang']=='ru'){echo 'Добавить';}if($_SESSION['lang']=='en'){echo 'Add';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?option=editsubject">
          <span data-feather="plus-circle"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Переглянути';}if($_SESSION['lang']=='ru'){echo 'Смотреть';}if($_SESSION['lang']=='en'){echo 'View';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?option=deletesubject">
          <span data-feather="file-text"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Видалити';}if($_SESSION['lang']=='ru'){echo 'Удалить';}if($_SESSION['lang']=='en'){echo 'Delete';} ?>
        </a>
      </li>
      <hr class="sidehr">
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <a class="d-flex align-items-center text-muted" href="?option=addnews">
        <span>
          <? if($_SESSION['lang']=='ua'){echo 'Групи';}if($_SESSION['lang']=='ru'){echo 'Группы';}if($_SESSION['lang']=='en'){echo 'Groups';} ?>
        </span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="?option=addgroup">
          <span data-feather="plus-circle"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Додати';}if($_SESSION['lang']=='ru'){echo 'Добавить';}if($_SESSION['lang']=='en'){echo 'Add';} ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?option=deletegroup">
          <span data-feather="file-text"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Видалити';}if($_SESSION['lang']=='ru'){echo 'Удалить';}if($_SESSION['lang']=='en'){echo 'Delete';} ?>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="?option=editgroups">
          <span data-feather="file-text"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Переглянути';}if($_SESSION['lang']=='ru'){echo 'Смотреть';}if($_SESSION['lang']=='en'){echo 'View';} ?>
        </a>
      </li>
      <hr class="sidehr">
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <a class="d-flex align-items-center text-muted" href="?option=addnews">
        <span>
          <? if($_SESSION['lang']=='ua'){echo 'Настройки';}if($_SESSION['lang']=='ru'){echo 'Настройки';}if($_SESSION['lang']=='en'){echo 'Settings';} ?>
        </span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link <? if(($_GET['option']=='translate')){echo 'active';} ?>" href="?option=translate">
          <span data-feather="plus-circle"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Переклади';}if($_SESSION['lang']=='ru'){echo 'Переводы';}if($_SESSION['lang']=='en'){echo 'Translations';} ?>
        </a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="?option=translate">
          <span data-feather="plus-circle"></span>
          <? if($_SESSION['lang']=='ua'){echo 'Настройки';}if($_SESSION['lang']=='ru'){echo 'Настройки';}if($_SESSION['lang']=='en'){echo 'Settings';} ?>
        </a>
      </li> -->
      <hr class="sidehr">
    </ul>

    <? } ?>
  </div>
</nav>
