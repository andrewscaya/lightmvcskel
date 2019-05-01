<?php

$baseConfig['env'] = 'production'; // 'development' or 'production'

$baseConfig['appName'] = 'The LightMVC Framework Skeleton Application';

// Required configuration
require 'events.config.php';

require 'commands.config.php';

require 'routes.config.php';

require 'view.config.php';

// Optional configuration
include 'middleware.config.php';

include 'session.config.php';