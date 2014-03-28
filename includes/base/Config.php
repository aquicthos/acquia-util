<?php

namespace AcquiaUtil\Base;

class Config
{
  protected $config_dir;

  protected $config = array();

  protected static $instances = array();

  public function __construct($config_name)
  {
    $this->config_dir = $_SERVER['HOME'] . '/.acquia-util';

    if (!is_dir($this->config_dir)) {
      mkdir($this->config_dir);
    }

    $config_file = $this->config_dir . '/' . $config_name . '.php';

    if (!is_file($config_file)) {
      touch($config_file);
    }

    include $config_file;

    if (!empty($config)) {
      $this->config = $config;
    }
  }

  public function get($item, $default = NULL)
  {
    if (isset($this->config[$item])) {
      return $this->config[$item];
    }

    return $default;
  }

  // TODO: Standardize on a format yadda yadda.
  public function set($item, $value)
  {

  }

  public static function instance($config_name)
  {
    if (empty(static::$instances[$config_name])) {
      static::$instances[$config_name] = new static($config_name);
    }

    return static::$instances[$config_name];
  }
}
