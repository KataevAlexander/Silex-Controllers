<?php

  namespace core\vendor\application;

  use core\vendor\Application;
  use services\CookieService;
  use services\LogService;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

  class ApplicationController {

    /** @var ApplicationModel */
    private $model;

    function __construct(ApplicationModel $model) {
      $this->model = $model;
    }

    public function after(Request $request, Response $response) {
      foreach (CookieService::getRemoveCookies() as $cookie) {
        $response->headers->clearCookie($cookie);
      }

      foreach (CookieService::getSetCookies() as $cookie) {
        $response->headers->setCookie($cookie);
      }

      return $response;
    }

    public function finish(Application $app) {
      $records = LogService::getRecords();

      /** @var \core\vendor\Logger $monolog */
      $monolog = $app['monolog'];

      foreach ($records as $value) {
        $monolog->addRecord($value['level'], $value['message'], $this->model->convertLogContext($value['context']), true);
      }
    }

  }