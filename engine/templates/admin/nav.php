<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="?option=admin">Адмінпанель</a>
    <form class="language-form" action="" method="post">
      <select class="thisselect" name="lang">
        <option value="ua" <? if($_SESSION['lang']=='ua'){echo 'selected';}; ?>>ua</option>
        <option value="ru" <? if($_SESSION['lang']=='ru'){echo 'selected';}; ?>>ru</option>
        <option value="en" <? if($_SESSION['lang']=='en'){echo 'selected';}; ?>>en</option>
      </select>
    </form>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="?option=admlogout"><? if($_SESSION['lang']=='ua'){echo 'Вийти';}if($_SESSION['lang']=='ru'){echo 'Выход';}if($_SESSION['lang']=='en'){echo 'Logout';} ?></a>
      </li>
    </ul>
</nav>
