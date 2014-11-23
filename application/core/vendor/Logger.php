<?php

  namespace core\vendor;

  use services\LogService;

  class Logger extends \Monolog\Logger {

    public function addRecord($level, $message, array $context = array(), $immediately = false) {
      if (!$immediately) {
        LogService::log($message, $context, $level);
      } else {
        return \Monolog\Logger::addRecord($level, $message, $context);
      }

      return true;
    }

  }