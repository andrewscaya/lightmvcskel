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
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          {foreach from=$view.navMenu key=navMenuEntry item=navMenuLink}
            <li><a href="{$navMenuLink}">{$navMenuEntry}</a></li>
          {/foreach}
          </ul>
        </div>
        
        <div id="pageBodyProducts">
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
              <h1>Add new product</h1>
              <form method="post" action="" enctype="multipart/form-data">
                  <label for="name">Name</label><br />
                  <input type="text" name="name" id="name" size="30" /><br />
                  <label for="price">Price</label><br />
                  <input type="text" name="price" id="price" /><br />
                  <label for="description">Description</label><br />
                  <input type="text" name="description" id="description" size="100" /><br />
                  <label for="image">Image</label><br />
                  <input type="file" name="image" id="image" /><br />
                  <input type="submit" name="submit" /><br />
              </form>
              {if $view.saved == 1}
                  <div class="alert-success"><p>The product has been saved!</p></div>
              {/if}
              {if $view.error == 1}
                  <div class="alert-danger"><p>The product has not been created! Please try again.</p></div>
              {/if}
              <p><br /><br /><a href="{$view.urlbaseaddr}products/index/">List products</a><br /><br /></p>
          </div>
        </div> <!-- END pageBody -->
        
      </div>
    </div>

{if $view.bodyjs == 1}
    {include file='bodyjs.tpl'}
{/if}

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>
