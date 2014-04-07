<?php

namespace AcquiaUtil\Base;

/**
 * Base functions to handle subcommand dispatching
 *
 */
class Command
{
  /**
   * Holds the argv sent in to factory
   *
   * @var array
   */
  protected $_argv;

  public function __construct($argv)
  {
    $this->_argv = $argv;
  }

  /**
   * Magic __call for non-existant subcommands.
   *
   * @throws Exception
   */
  public function __call($function, $args)
  {
    throw new \Exception("Subcommand does not exist.");
  }

  public static function factory($argv)
  {
    return new static($argv);
  }
}
