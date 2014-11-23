<?php

  use core\vendor\Application;

  require_once sprintf('%s/vendor/vendor/autoload.php', DR);
  require_once sprintf('%s/application/core/autoload.php', DR);

  $app = new Application();
  $app->run();