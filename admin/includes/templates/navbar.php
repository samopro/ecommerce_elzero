<?php include 'header.php'; ?>

<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN') ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="categories.php"><?php echo lang('CATEGORIES') ?></a></li>
            <li><a href="items.php"><?php echo lang('ITEMS') ?></a></li>
            <li><a href="members.php"><?php echo lang('MEMBERS') ?></a></li>
            <li><a href="comments.php"><?php echo lang('COMMENTS') ?></a></li> 
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Samir <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../index.php">Visit Shop</a></li>
                <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="logout.php">Logout</a></li> 
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
</nav>