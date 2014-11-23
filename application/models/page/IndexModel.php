<?php

  namespace models\page;
  
  use core\model\ModelBaseImpl;
  use core\model\ModelConfig;
  use core\model\ModelConfigImpl;
  use core\vendor\Application;

  class IndexModel extends ModelBaseImpl {

    public function __construct(Application $app, ModelConfig $config = null) {
      parent::__construct($app, $config ?: new ModelConfigImpl('/page/index.twig', ['/'], ['get']));
    }

    public function loadLocalization() {
      $this->app->addLocalization('/page/index/');
    }

  } 