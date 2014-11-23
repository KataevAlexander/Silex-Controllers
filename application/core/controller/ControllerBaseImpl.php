<?php

  namespace core\controller;

  use core\controller\exceptions\ControllerMethodMustBeOverriddenException;
  use core\model\ModelBase;
  use core\vendor\Application;
  use Silex\Controller;
  use Silex\ControllerCollection;
  use Silex\ControllerProviderInterface;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;

  /**
   * Class ControllerBaseImpl
   *
   * @package core\controller
   * @author  kataev
   */
  abstract class ControllerBaseImpl implements ControllerBase, ControllerProviderInterface {

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \core\model\ModelBase
     */
    protected $model;

    /**
     * @param ModelBase $model
     * @param array     $config
     */
    final function __construct(ModelBase $model, array $config = []) {
      $this->model   = $model;
      $this->config  = $config;
    }

    /**
     * @param \Silex\Application $app
     *
     * @return ControllerCollection
     */
    final public function connect(\Silex\Application $app) {
      $model  = $this->model;
      $config = $model->getConfig();

      $model->setTplPath($config->getTplPath());
      $model->setSettings($config->getSettings());

      /** @var ControllerCollection $controllers */
      $controllers = $app['controllers_factory'];

      foreach ($config->getUrls() as $url) {
        $route = null;

        foreach ($config->getMethods() as $method) {
          /** @var Controller $route */
          $route = $controllers->$method($url, function (Request $request, Application $app) use ($method) {
            $this->model->setRequest($app['request']);

            if ($before = $this->before($request, $app)) {
              return $before ? : null;
            }

            return $this->$method($request, $app);
          });

          foreach ($config->getAsserts() as $key => $assert) {
            $route->assert($key, $assert);
          }
        }

        $route->after(function (Request $request, Response $response, Application $app) {
          return $this->after($request, $response, $app);
        });
      }

      return $controllers;
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return Response
     */
    function get(Request $request, Application $app) {
      $model = $this->model;

      $model->load();
      $model->loadLocalization();

      return $app->render($model->getTplPath(), $model->getSettings());
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return Response
     *
     * @throws exceptions\ControllerMethodMustBeOverriddenException
     */
    function post(Request $request, Application $app) {
      throw new ControllerMethodMustBeOverriddenException;
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return Response
     *
     * @throws exceptions\ControllerMethodMustBeOverriddenException
     */
    function put(Request $request, Application $app) {
      throw new ControllerMethodMustBeOverriddenException;
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return Response
     *
     * @throws exceptions\ControllerMethodMustBeOverriddenException
     */
    function delete(Request $request, Application $app) {
      throw new ControllerMethodMustBeOverriddenException;
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return null|mixed
     */
    function before(Request $request, Application $app) {
      return null;
    }

    function after(Request $request, Response $response, Application $app) {
      return $response;
    }

  }