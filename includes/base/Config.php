<?php

namespace AcquiaUtil\Base;

// TODO: This can probably be used with Guzzle for betterness.
class Config
{
  protected $config_dir;

  protected $config_file;

  protected $config = array();

  protected static $instances = array();

  public function __construct($config_name)
  {
    $this->config_dir = $_SERVER['HOME'] . '/.acquia-util';

    if (!is_dir($this->config_dir)) {
      mkdir($this->config_dir);
    }

    $this->config_file = $this->config_dir . '/' . $config_name . '.json';

    if (is_file($this->config_file)) {
      $config = file_get_contents($this->config_file);

      $config = json_decode($config, true);
    } else {
      // Support legacy php configuration arrays.
      $config_file = $this->config_dir . '/' . $config_name . '.php';

      if (!is_file($config_file)) {
        return;
        // TODO: Is this a good idea or a bad idea?
        throw new \ConfigException("Configuration file not found. Please define settings file.");
      }

      include $config_file;
    }

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

  /**
   * Sets a configuration item
   *
   * @param string $item
   * @param mixed $value
   *
   * @returns self
   */
  public function set($item, $value)
  {
    $this->config[$item] = $value;

    return $this;
  }

  /**
   * Save the configuration file to $this->config_file
   */
  public function save()
  {
    $config = json_encode($this->config);

    file_put_contents($this->config_file, $config);
  }

  public static function instance($config_name)
  {
    if (empty(static::$instances[$config_name])) {
      static::$instances[$config_name] = new static($config_name);
    }

    return static::$instances[$config_name];
  }
}
