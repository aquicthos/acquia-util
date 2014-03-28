<?php

namespace AcquiaUtil\Base;

/**
 * Autoloader. Only responds to the AcquiaUtil namespace.
 */
class Autoloader
{
  public static function autoload($class)
  {
    if (strpos($class, 'AcquiaUtil') === FALSE) {
      return;
    }

    $non_namespace = str_replace('AcquiaUtil\\', '', $class);

    $bits = explode('\\', $non_namespace);
    $class_name = array_pop($bits);

    $file = dirname(__FILE__) . '/../' . strtolower(implode('/', $bits)) . '/' . $class_name . '.php';

    if (file_exists($file)) {
      include_once $file;
    }
  }

  public static function register()
  {
    spl_autoload_register(__CLASS__ . '::autoload');
  }
}
