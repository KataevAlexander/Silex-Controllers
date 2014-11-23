<?php

  namespace controllers\page;

  use core\controller\ControllerBaseImpl;
  use core\vendor\Application;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

  class IndexController extends ControllerBaseImpl {
    
    function get(Request $request, Application $app) {
      return parent::get($request, $app);
    }

    function post(Request $request, Application $app) {

    }

    function put(Request $request, Application $app) {

    }

    function delete(Request $request, Application $app) {

    }

    function before(Request $request, Application $app) {
      return parent::before($request, $app);
    }

    function after(Request $request, Response $response, Application $app) {
      return parent::after($request, $response, $app);
    }

  } 