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
              <h1>Delete product</h1>
              <?php if ($view['saved'] === 1): ?>
                  <div class="alert-success"><p>The product has been deleted!</p></div>
              <?php endif ?>
              <?php if ($view['error'] === 1): ?>
                  <div class="alert-danger"><p>The product has not been deleted! Please try again.</p></div>
              <?php endif ?>
              <p><br /><br /><a href="<?php echo $view['urlbaseaddr'] ?>products/index">List products</a><br /><br /></p>
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
