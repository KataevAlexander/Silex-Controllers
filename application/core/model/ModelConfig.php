<?php

  namespace core\model;

  interface ModelConfig {

    public function getUrls();

    public function setUrls(array $urls);

    public function getMethods();

    public function setMethods(array $methods);

    public function getSettings();

    public function setSettings(array $settings);

    public function getTplPath();

    public function setTplPath($path);

    public function getAsserts();

    public function setAsserts(array $asserts);

  }