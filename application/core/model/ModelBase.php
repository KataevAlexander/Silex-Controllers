<?php

  namespace core\model;

  use core\vendor\Application;
  use Symfony\Component\HttpFoundation\Request;

  interface ModelBase {

    public function __construct(Application $app, ModelConfig $config = null);

    public function load();

    public function loadLocalization();

    public function getSettings();

    public function setSettings(array $settings);

    public function getTplPath();

    public function setTplPath($tplPath);

    public function setRequest(Request $request);

    /** @return ModelConfig */
    public function getConfig();

  }