<!DOCTYPE html>
<html lang="en">

<?php if (isset($view['headjs'])): ?>
    <?=$this->section('headjs', $this->fetch('headjs', ['view' => $view]))?>
<?php else: ?>
    <?=$this->section('head', $this->fetch('head', ['view' => $view]))?>
<?php endif ?>

  <body>
  <?=$this->section('navbar', $this->fetch('navbar', ['view' => $view]))?>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          <?php foreach($view['navmenu'] as $key => $value): ?>
            <li><?php echo '<a href="' . $value . '">' . $key . '</a>' ?></li>
          <?php endforeach; ?>
          </ul>
        </div>
        
        <div id="pageBody">
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1>Welcome to<br /><?php echo $view['appname'] ?>!</h1>
            <p><br /><img src="<?php echo $view['urlbaseaddr'] ?>img/lightmvc_logo.png" /><br /></p>
            <h3>You can <a href="<?php echo $view['urlbaseaddr'] ?>products/index">view a list of all products</a>!</h3>
          </div>
        </div> <!-- END pageBody -->
        
      </div>
    </div>

  <?php if ($view['bodyjs'] === 1): ?>
    <?=$this->section('bodyjs', $this->fetch('bodyjs', ['view' => $view]))?>
  <?php endif ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo $view['urlbaseaddr'] ?>js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>
