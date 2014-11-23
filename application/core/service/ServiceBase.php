<?php

  namespace core\service;

  use core\vendor\Application;

  interface ServiceBase {

    public static function init(Application $app);

  }