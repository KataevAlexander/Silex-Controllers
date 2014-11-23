<?php

  namespace core\model;

  use core\vendor\Application;
  use Symfony\Component\HttpFoundation\Request;

  abstract class ModelBaseImpl implements ModelBase {

    /** @var Application */
    protected $app;

    /** @var Request */
    protected $request;

    /** @var array */
    protected $settings = array();

    /** @var string */
    protected $tplPath;

    /** @var ModelConfig */
    protected $config;

    public function load() { }

    public function loadLocalization() { }

    public function __construct(Application $app, ModelConfig $config = null) {
      $this->app    = $app;
      $this->config = $config;
    }

    public function getSettings() {
      return array('settings' => $this->settings);
    }

    public function setSettings(array $settings) {
      $this->settings = array_merge($this->settings, $settings);
    }

    public function getTplPath() {
      return $this->tplPath;
    }

    public function setTplPath($tplPath) {
      $this->tplPath = $tplPath;
    }

    public function setRequest(Request $request) {
      $this->request = $request;
    }

    /** @return ModelConfig */
    public function getConfig() {
      return $this->config;
    }

  }