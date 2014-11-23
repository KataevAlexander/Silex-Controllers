<?php

  namespace core\vendor;

  class Route extends \Silex\Route {

    public function __construct($pattern = '', array $defaults = array(), array $requirements = array(), array $options = array()) {
      parent::__construct($pattern, $defaults, $requirements, $options);

      $this->assert('locale', '\w\w');
      $this->value('locale', 'en');
    }

  }