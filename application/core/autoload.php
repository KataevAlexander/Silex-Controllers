<?php

  spl_autoload_register(function ($class) {
    $file = sprintf('%s/application/%s.php', DR, str_replace('\\', '/', $class));

    if (file_exists($file)) {
      require_once $file;
    }
  });