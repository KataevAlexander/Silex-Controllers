<?php

  namespace core\vendor\traits;

  use Symfony\Component\Yaml\Yaml;

  trait LocalizationTrait {

    public function addLocalization($path, $locale = null) {
      $locale = is_null($locale) ? $this['locale'] : $locale;

      $way = sprintf('%s/data/localization/%s/%s.yml', DR, trim($path, '/'), $locale);
      if (file_exists($way)) {
        $this['translator']->addResource('yaml', $way, $locale);
      }
    }

    public function getLocalization($path, $locale = null) {
      $locale = is_null($locale) ? $this['locale'] : $locale;

      $way = sprintf('%s/data/localization/%s/%s.yml', DR, trim($path, '/'), $locale);
      if (file_exists($way)) {
        return Yaml::parse($way);
      }
    }

  }