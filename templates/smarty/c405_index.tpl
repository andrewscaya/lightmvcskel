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
        <div id="pageBody">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <h1 class="h1 xl:text-blue-darker">405</h1>
                    <h2 class="h2 text-blue-darker">Method Not Allowed</h2>
                    <p class="pt-2 font-bold text-blue">Sorry, but this method is not allowed on this page!</p>
                    <p class="pt-4">Allowed method(s):</p>
                    {foreach from=$view.vars key=name item=value}
                        <div class="row justify-content-center">{$value}</div>
                    {/foreach}
                    <p class="pt-5 pb-10 text-lg-center">Let's go back <a href="{$view.urlbaseaddr}index">HOME</a>!</p>
                </div>
            </div>
        </div>
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
