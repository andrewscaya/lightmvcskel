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
          <div id="pageBody">
              <p><br /><br /><br /></p>
              <div class="container max-w-xl mx-auto text-left flex items-center flex-wrap">
                  <div class="col-lg-8">
                      <h1>Welcome to<br /><?php echo $view['appname'] ?>!</h1>
                      <p class="text-md md:text-lg text-grey-dark leading-normal">
                          You can view a list of all products!
                      </p>
                      <p><a href="<?php echo $view['urlbaseaddr'] ?>products/index" class="mt-6 inline-block bg-white text-black no-underline px-4 py-3 shadow-lg">View products</a></p>
                  </div>
                  <div class="col-lg-4">
                    <p><br /><img src="<?php echo $view['urlbaseaddr'] ?>img/lightmvc_logo.png" class="shadow-lg" /><br /></p>
                  </div>
              </div>
              <p><br /><br /><br /></p>
          </div> <!-- END pageBody -->
        </div>
    </div>

    <!-- feature -->
    <div class="w-full bg-yellow text-black">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <p><br /></p>
                    <h2 class="leading-normal mb-6 text-grey-darkest"><b>Easily create PHP applications by using any PHP library within this very modular, event-driven and Swoole-enabled framework!</b></h2>
                    <h3><a href="https://lightmvcframework.net/" target="_blank">https://lightmvcframework.net/</a></h3>
                    <p><br /></p>
                </div>
            </div>
        </div>
    </div>
    <!-- /feature -->

    <!-- content -->
    <div class="w-full px-6 py-12 bg-white">
        <div class="max-w-xl mx-auto flex flex-wrap">

            <div class="w-full md:w-1/2 flex flex-wrap">
                <div class="w-full md:w-1/3 p-2">
                </div>
                <div class="w-full md:w-1/3 p-2">
                    <img src="<?php echo $view['urlbaseaddr'] ?>img/symfony.png" class="w-full h-auto" />
                </div>
                <div class="w-full md:w-1/3 p-2">
                </div>
                <div class="w-full md:w-1/3 p-2">
                </div>
                <div class="w-full md:w-1/3 p-2">
                    <img src="<?php echo $view['urlbaseaddr'] ?>img/laminas-logo.svg" class="w-full h-auto" />
                </div>
                <div class="w-full md:w-1/3 p-2">
                </div>
                <div class="w-full md:w-1/3 p-2">
                </div>
                <div class="w-full md:w-1/3 p-2">
                    <img src="<?php echo $view['urlbaseaddr'] ?>img/swoole.png" class="w-full h-auto" />
                </div>
                <div class="w-full md:w-1/3 p-2">
                </div>
            </div>

            <div class="w-full md:w-1/2 p-2 md:px-6">
                <h3>
                    Build applications using PSR-15 compliant middleware and PSR-7 compliant HTTP messages.
                </h3>
                <p class="mb-5">Built upon proven technologies like Laminas Diactoros, Laminas Stratigility, and Laminas EventManager!</p>
                <p class="mb-8">Many great technologies, like Pimple, FastRoute, Plates, and Whoops come together to become the LightMVC Framework!</p>
                <p class="mb-8">And, let's not forget these great-looking templates created with Bootstrap and Tailwind CSS!</p>
                <a href="<?php echo $view['urlbaseaddr'] ?>products/index" class="inline-block bg-black text-white text-3xl px-4 py-3 no-underline">Browse our products</a>
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
