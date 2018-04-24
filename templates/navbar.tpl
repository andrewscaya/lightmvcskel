<div class="navbar-wrapper">
    <div class="container">
        <nav class="navbar navbar-inverse navbar-fixed-top">
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
                        {foreach from=$view.links key=name item=link}
                        <li><a href="{$link}">{$name}</a></li>
                        {/foreach}
                       <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Main Menu <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        {foreach from=$view.navMenu key=navMenuEntry item=navMenuLink}
                            <li class="dropdown-header">Menu</li>
                            <li><a href="{$navMenuLink}">{$navMenuEntry}</a></li>
                            <li role="separator" class="divider"></li>
                        {/foreach}
                        </ul>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>