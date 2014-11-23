<?php

  namespace core\service;

  use core\vendor\Application;

  abstract class ServiceBaseImpl implements ServiceBase {

    /** @var Application */
    protected static $app;

    public static function init(Application $app) {
      self::$app = $app;
    }

    protected static function merge() {
      return array_merge(func_get_args());
    }

    private function __construct() { }

    private function __wakeup() { }

    private function __clone() { }

  }