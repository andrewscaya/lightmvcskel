<!DOCTYPE html>
<html lang="en">

{if isset($view.headjs)}
    {include file='headjs.tpl'}
{else}
    {include file='head.tpl'}
{/if}

  <body>
  {include file='navbar.tpl'}

    <div class="container">
      <div class="row">
        <div id="pageBody">
          <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 main">
              <h1>Delete product</h1>
              {if $view.saved == 1}
                  <div class="alert-success"><p>The product has been deleted!</p></div>
              {/if}
              {if $view.error == 1}
                  <div class="alert-danger"><p>The product has not been deleted! Please try again.</p></div>
              {/if}
              <p><br /><br /><a href="{$view.urlbaseaddr}products/index" class="mt-6 inline-block bg-white text-black no-underline px-4 py-3 shadow-lg">List products</a><br /><br /></p>
          </div>
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

  {include file='footer.tpl'}

  {if $view.bodyjs == 1}
      {include file='bodyjs.tpl'}
  {/if}

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{$view.urlbaseaddr}js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>
