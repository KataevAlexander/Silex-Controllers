<?php

  namespace services;

  use core\service\ServiceBaseImpl;
  use Monolog\Logger;

  class LogService extends ServiceBaseImpl {

    private static $records = [];

    public static function log($message, array $context = array(), $level = Logger::INFO) {
      array_push(self::$records, [
        'message' => $message,
        'context' => $context,
        'level'   => $level
      ]);
    }

    public static function getRecords() {
      return self::$records;
    }

  }