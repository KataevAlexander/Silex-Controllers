<?php

  namespace services;

  use core\service\ServiceBaseImpl;
  use Symfony\Component\HttpFoundation\Cookie;
  use Symfony\Component\HttpFoundation\Request;

  class CookieService extends ServiceBaseImpl {

    private static $cookies = [];
    private static $setCookies = [];
    private static $clearCookies = [];

    public static function start(Request $request) {
      self::$cookies = $request->cookies->all();
    }

    public static function setCookie(Cookie $cookie) {
      array_push(self::$setCookies, $cookie);

      self::$cookies[$cookie->getName()] = $cookie->getValue();
    }

    public static function removeCookie($name) {
      array_push(self::$clearCookies, $name);
      unset(self::$cookies[$name]);
    }

    public static function getCookie($name) {
      return array_key_exists($name, self::$cookies) ? self::$cookies[$name] : null;
    }

    public static function getCookies() {
      return self::$cookies;
    }

    public static function getRemoveCookies() {
      return self::$clearCookies;
    }

    public static function getSetCookies() {
      return self::$setCookies;
    }

  }