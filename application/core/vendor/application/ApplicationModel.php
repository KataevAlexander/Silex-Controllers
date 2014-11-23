<?php

  namespace core\vendor\application;

  use core\vendor\Application;

  class ApplicationModel {

    public function convertLogContext($context) {
      foreach ($context as $key => $value) {
        if (is_array($value)) {
          $content[$key] = $this->convertLogContext($value);
          continue;
        }

        if (is_string($value) or is_numeric($value)) {
          $content[$key] = mb_convert_encoding($value, 'UTF-8');
          continue;
        }

        $content[$key] = $value;
      }

      return $context;
    }

    public static function load($dir, $ext) {
      $list = [];

      foreach (glob($dir) as $filename) {
        if (is_file($filename) and strpos($filename, '.' . $ext)) {
          array_push($list, $filename);
        }

        if (is_dir($filename)) {
          $list = array_merge($list, self::load($filename . '/*', $ext));
        }
      }

      return $list;
    }

  }