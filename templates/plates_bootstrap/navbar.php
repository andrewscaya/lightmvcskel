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
                    <a class="navbar-brand" href="<?php echo $view['links']['Home'] ?>"><img src="<?php echo $view['logo'] ?>" alt="Logo"><b><?php echo $view['title'] ?></b></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php foreach($view['links'] as $key => $value): ?>
                            <li><?php echo '<a href="' . $value . '">' . $key . '</a>' ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>