<?php

namespace AcquiaUtil\Commands;

use Acquia\Search\AcquiaSearchService;
use Acquia\Network\AcquiaNetworkClient;
use Acquia\Common\Services;

/**
 * Runs a simple ->select() against a search index.
 *
 * Example `./run SolrSearch subscription "Here is my search query"`
 */
class SolrSearch extends \AcquiaUtil\Base\Command
{
  protected $_search;

  protected $_index;

  protected $_config;

  /**
   * Overloaded constructor to setup commands
   *
   * @param array $argv
   *   Command Params Passed into the function.
   * @returns null
   */
  public function __construct($argv)
  {
    parent::__construct($argv);
    $this->_config = \AcquiaUtil\Base\Config::instance($this->_argv[0]);

    if (!$network_identifier = $this->_config->get('network-identifier')) {
      $this->promptForConfig();
    }

    $network = AcquiaNetworkClient::factory(array(
        'network_id' => $this->_config->get('network-identifier'),
        'network_key' => $this->_config->get('network-key'),
    ));

    $acquiaServices = Services::ACQUIA_SEARCH;
    $subscription = $network->checkSubscription($acquiaServices);

    $this->_search = AcquiaSearchService::factory($subscription);

    $this->_index = $this->_search->get($this->_config->get('search-identifier'));
  }

  /**
   * Asks for any missing config variables and saves them.
   */
  public function promptForConfig()
  {
    $network_identifier = \cli\prompt('Enter the network identifier');
    $network_key = \cli\prompt('Enter the network key');
    $search_identifier = \cli\prompt('Enter the search identifier (probably same as network identifier)');

    $this->_config->set('network-identifier', $network_identifier);
    $this->_config->set('network-key', $network_key);
    $this->_config->set('search-identifier', $search_identifier);

    $this->_config->save();
  }

  /**
   * Runs a simple search against the selected solr instance
   *
   * @returns array
   */
  public function select()
  {
    return $this->_index->select($this->_argv[1]);
  }

  /**
   * Allows you to search on a single facet.
   *
   * @returns array
   */
  public function facetSearch()
  {
    return $this->_index->select(array('q' => "{$this->_argv[1]}:{$this->_argv[2]}"));
  }

  /**
   * Alias for ->select()
   *
   * @returns array
   */
  public function run()
  {
    return $this->select();
  }
}
