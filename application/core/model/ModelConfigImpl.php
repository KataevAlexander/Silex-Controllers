<?php

  namespace core\model;

  class ModelConfigImpl implements ModelConfig {

    private $tplPath;
    private $urls = [];
    private $methods = [];
    private $settings = [];
    private $asserts = [];

    /**
     * @param       $tplPath
     * @param array $urls
     * @param array $methods
     * @param array $settings
     * @param array $asserts
     */
    function __construct($tplPath, array $urls, array $methods, array $settings = [], array $asserts = []) {
      $this->asserts  = $asserts;
      $this->methods  = $methods;
      $this->settings = $settings;
      $this->tplPath  = $tplPath;
      $this->urls     = $urls;
    }

    /**
     * @return array
     */
    public function getMethods() {
      return $this->methods;
    }

    /**
     * @param array $methods
     */
    public function setMethods(array $methods) {
      $this->methods = $methods;
    }

    /**
     * @return array
     */
    public function getSettings() {
      return $this->settings;
    }

    /**
     * @param array $settings
     */
    public function setSettings(array $settings) {
      $this->settings = $settings;
    }

    /**
     * @return array
     */
    public function getUrls() {
      return $this->urls;
    }

    /**
     * @param array $urls
     */
    public function setUrls(array $urls) {
      $this->urls = $urls;
    }

    /**
     * @return mixed
     */
    public function getTplPath() {
      return $this->tplPath;
    }

    /**
     * @param mixed $tplPath
     */
    public function setTplPath($tplPath) {
      $this->tplPath = $tplPath;
    }

    /**
     * @return array
     */
    public function getAsserts() {
      return $this->asserts;
    }

    /**
     * @param array $asserts
     */
    public function setAsserts(array $asserts) {
      $this->asserts = $asserts;
    }

  }