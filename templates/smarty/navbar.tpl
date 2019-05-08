<div class="navbar-wrapper">
    <div class="container">
        <nav class="navbar navbar-inverse navbar-fixed-top shadow-lg">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{$view.links.Home}"><img src="{$view.logo}" alt="Logo"><b>{$view.title}</b></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        {foreach from=$view.links key=name item=value}
                            <li><a href="{$value}">{$name}</a></li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>