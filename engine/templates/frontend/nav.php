<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">%title% </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample07">
        <ul class="navbar-nav mr-auto">

        <form class="form-inline my-2 my-md-0">
          <a class="nav-link login" href="?option=admin"><span data-feather='terminal'></span><span data-feather='users'></span></a>
        </form>


        <form class="language-form" action="" method="post">
          <select class="thisselect" name="lang">
            <option value="ua" <? if($_SESSION['lang']=='ua'){echo 'selected';}; ?>>ua</option>
            <option value="ru" <? if($_SESSION['lang']=='ru'){echo 'selected';}; ?>>ru</option>
            <option value="en" <? if($_SESSION['lang']=='en'){echo 'selected';}; ?>>en</option>
          </select>
        </form>
      </div>

    </div>
  </nav>
