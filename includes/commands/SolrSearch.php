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
    $config = \AcquiaUtil\Base\Config::instance($this->_argv[0]);

    $network = AcquiaNetworkClient::factory(array(
        'network_id' => $config->get('network-identifier'),
        'network_key' => $config->get('network-key'),
    ));

    $acquiaServices = Services::ACQUIA_SEARCH;
    $subscription = $network->checkSubscription($acquiaServices);

    $this->_search = AcquiaSearchService::factory($subscription);

    $this->_index = $this->_search->get($config->get('search-identifier'));
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
