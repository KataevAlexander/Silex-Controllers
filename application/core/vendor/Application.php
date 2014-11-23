<?php

  namespace core\vendor;

  use core\service\ServiceBaseImpl;
  use core\vendor\application\ApplicationController;
  use core\vendor\application\ApplicationModel;
  use core\vendor\traits\LocalizationTrait;
  use Silex\Application\MonologTrait;
  use Silex\Application\TwigTrait;
  use Silex\Application\UrlGeneratorTrait;
  use Silex\Provider\HttpCacheServiceProvider;
  use Silex\Provider\MonologServiceProvider;
  use Silex\Provider\SessionServiceProvider;
  use Silex\Provider\TranslationServiceProvider;
  use Silex\Provider\TwigServiceProvider;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Translation\Loader\YamlFileLoader;
  use Symfony\Component\Translation\Translator;
  use Symfony\Component\Yaml\Yaml;

  class Application extends \Silex\Application {
    use TwigTrait;
    use UrlGeneratorTrait;
    use MonologTrait;
    use LocalizationTrait;

    public function __construct(array $values = []) {
      parent::__construct($values);

      $this['route_class'] = 'core\\vendor\\Route';

      $this->config();
      $this->provider();
      $this->load();

      ServiceBaseImpl::init($this);

      $controller = new ApplicationController(new ApplicationModel());

      $this->after(function (Request $request, Response $response) use ($controller) {
        return $controller->after($request, $response);
      });

      $this->finish(function () use ($controller) {
        $controller->finish($this);
      });
    }

    public function escape($text, $flags = ENT_COMPAT, $charset = null, $doubleEncode = true) {
      return parent::escape(trim($text), $flags, $charset, $doubleEncode);
    }

    protected function config() {
      date_default_timezone_set('UTC');

      $config = Yaml::parse(sprintf('%s/data/config/config.yml', DR));

      $this['debug'] = false;
      $this['locale'] = 'en';
      $this['config'] = $this->share(function () use ($config) {
        return $config;
      });
      $this['debug'] = $this['config']['debug'];
    }

    protected function provider() {
      $this->register(new TwigServiceProvider(), [
        'twig.path'    => sprintf('%s/application/views/', DR),
        'twig.options' => [
          'auto_reload' => true,
          'cache'       => sprintf('%s/data/cache/twig', DR)
        ]
      ]);

      $this->register(new SessionServiceProvider(), [
        'session.storage.options' => [
          'name'            => 'session',
          'cookie_httponly' => true
        ]
      ]);

      $this->register(new TranslationServiceProvider(), [
        'locale_fallback' => 'en',
      ]);

      $this['translator'] = $this->share($this->extend('translator', function (Translator $translator) {
        $translator->addLoader('yaml', new YamlFileLoader());

        return $translator;
      }));

      $this->register(new HttpCacheServiceProvider(), [
        'http_cache.cache_dir' => sprintf('%s/data/cache/http', DR),
      ]);

      $this->register(new MonologServiceProvider(), [
        'monolog.logfile'      => sprintf('%s/data/log/monolog.log', DR),
        'monolog.name'         => 'monolog',
        'monolog.logger.class' => 'core\\vendor\\Logger'
      ]);
    }

    protected function load() {
      $getClass = function (array $exploded, $prefix, $type) {
        $path = sprintf('%s\\%s', $prefix, str_replace('.php', '', implode('\\', $exploded)));
        $path = str_replace('Controller', $type, $path);

        return $path;
      };

      $controllers = ApplicationModel::load(sprintf('%s/application/controllers/*', DR), 'php');
      foreach ($controllers as $path) {
        $exploded = explode('/', $path);
        $exploded = array_slice($exploded, array_search('controllers', $exploded) + 1);

        $modelClass = $getClass($exploded, 'models', 'Model');
        $controllerClass = $getClass($exploded, 'controllers', 'Controller');

        if (strpos($controllerClass, 'Abstract') !== false) {
          continue;
        }

        $controller = new $controllerClass(new $modelClass($this));
        $this->mount('', $controller);
      }
    }

  }