<?php

  namespace core\controller;

  use core\model\ModelBase;
  use core\vendor\Application;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

  interface ControllerBase {

    function __construct(ModelBase $model, array $config);

    function get(Request $request, Application $app);

    function post(Request $request, Application $app);

    function put(Request $request, Application $app);

    function delete(Request $request, Application $app);

    function before(Request $request, Application $app);

    function after(Request $request, Response $response, Application $app);

  }