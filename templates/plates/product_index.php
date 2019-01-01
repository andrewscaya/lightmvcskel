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
        
        <div id="pageBodyProducts">
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1>Products page</h1>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Description</th>
                      <th>Image</th>
                      <th>Options</th>
                  </tr>
                </thead>
                  <?php foreach($view['results'] as $key => $product): ?>
                    <tr>
                        <td><?php echo $product['id'] ?></td>
                        <td><?php echo $product['name'] ?></td>
                        <td><?php echo $product['price'] ?></td>
                        <td><?php echo $product['description'] ?></td>
                        <td><?php echo $product['image'] ?></td>
                        <td>
                            <a href="<?php echo $view['urlbaseaddr'] ?>products/edit/<?php echo $product['id'] ?>">Modify</a>
                        </td>
                        <td>
                            <a href="<?php echo $view['urlbaseaddr'] ?>products/delete/<?php echo $product['id'] ?>">Delete</a>
                        </td>
                    </tr>
                  <?php endforeach; ?>
              </table>
            </div>
            <p><a href="<?php echo $view['urlbaseaddr'] ?>products/add/">Add new product</a></p>
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
