<!DOCTYPE html>
<html lang="en">

{if isset($view.headjs)}
    {include file='headjs.tpl'}
{else}
    {include file='head.tpl'}
{/if}

<body>
{include file='navbar.tpl'}

<main role="main">

    <div class="container">
        <div id="pageBodyProducts" class="row">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                {if $view.saved != 1 && $view.error != 1}
                    <h1 class="h1">Add new product</h1>
                    <form method="post" action="" enctype="multipart/form-data" id="formadd1">
                        <label for="name">Name</label><br />
                        <input type="text" name="name" id="name" size="30" /><br />
                        <label for="price">Price</label><br />
                        <input type="text" name="price" id="price" /><br />
                        <label for="description">Description</label><br />
                        <input type="text" name="description" id="description" size="100" /><br />
                        <label for="image">Image</label><br />
                        <input type="file" name="image" id="image" /><br />
                        <button class="mt-3 block btn btn-primary rounded" type="submit" form="formadd1">
                            Save
                        </button>
                    </form>
                {/if}
                {if $view.saved == 1}
                    <div class="block alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <div class="h2 text-center"><strong>Success! </strong> The product has been saved!</div>
                    </div>
                {/if}
                {if $view.error == 1}
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <<div class="h2 text-center"><strong>Error! </strong> The product has not been created! Please try again.</div>
                    </div>
                {/if}
                <p class="pt-5 pb-5"><a href="{$view.urlbaseaddr}products/index" class="btn btn-light mt-6 inline-block bg-white text-black no-underline px-4 py-3 shadow-lg">List products</a><br /><br /></p>
            </div>
        </div> <!-- END pageBody -->
    </div>

    <!-- feature -->
    <div class="bg-yellow text-black">
        <div class="container">
            <div class="row">
                <div class="col-lg-12"><p><br /></p></div>
            </div>
        </div>
    </div>
    <!-- /feature -->

    <!-- content -->
    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4"></div>
                <div class="col-md-1"></div>
                <div class="col-md-5"></div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>

</main> <!-- /content -->

<div class="container-footer">
    {include file='footer.tpl'}
</div>

{if $view.bodyjs == 1}
    {include file='bodyjs.tpl'}
{/if}

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{$view.urlbaseaddr}js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>