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
        <div id="pageBodyProducts">
            <h1>Products page</h1>
            <div class="table-responsive">
              <table class="table table-striped">
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
                <tbody>
                    <?php if (isset($view['results']['nodata'])): ?>
                    <tr>
                        <td><?php echo $view['results']['nodata'] ?></td>
                    </tr>
                    <?php else: ?>
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
                    <?php endif ?>
                </tbody>
              </table>
            </div>
            <p><a href="<?php echo $view['urlbaseaddr'] ?>products/add" class="mt-6 inline-block bg-white text-black no-underline px-4 py-3 shadow-lg">Add new product</a></p>
        </div> <!-- END pageBody -->
      </div>
    </div>

    <!-- feature -->
    <div class="w-full bg-yellow text-black">
      <div class="text-center">
          <p><br /></p>
          <h2 class="leading-normal mb-6 text-grey-darkest"></h2>
          <h3></h3>
          <p><br /></p>
      </div>
    </div>
    <!-- /feature -->

    <!-- content -->
    <div class="w-full px-6 py-12 bg-white">
      <div class="max-w-xl mx-auto flex flex-wrap">

          <div class="w-full md:w-1/2 flex flex-wrap">
          </div>

          <div class="w-full md:w-1/2 p-2 md:px-6">
              <h3>
              </h3>
              <p class="mb-5"></p>
              <p class="mb-8"></p>
              <p class="mb-8"></p>
          </div>

      </div>
    </div>
    <!-- /content -->

  <?=$this->section('footer', $this->fetch('footer', ['view' => $view]))?>

  <?php if ($view['bodyjs'] === 1): ?>
      <?=$this->section('bodyjs', $this->fetch('bodyjs', ['view' => $view]))?>
  <?php endif ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo $view['urlbaseaddr'] ?>js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>
