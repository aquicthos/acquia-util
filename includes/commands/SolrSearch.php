<?php

namespace AcquiaUtil\Commands;

use Acquia\Search\AcquiaSearchService;
use Acquia\Network\AcquiaNetworkClient;
use Acquia\Common\Services;

class SolrSearch
{
  protected $_search;

  protected $_index;

  public function __construct($credentials, $index)
  {
    $this->_search = AcquiaSearchService::factory($credentials);

    $this->_index = $this->_search->get($index);
  }

  public function __call($function, $args)
  {
    var_dump("subcommand does not exist.");
  }

  public function select($keywords)
  {
    return $this->_index->select($keywords);
  }

  public static function factory($argv)
  {
    $config = \AcquiaUtil\Base\Config::instance($argv[0]);

    $network = AcquiaNetworkClient::factory(array(
        'network_id' => $config->get('network-identifier'),  // Acquia Network identifier
        'network_key' => $config->get('network-key'),  // Acquia Network key
    ));

    $acquiaServices = Services::ACQUIA_SEARCH;

    $subscription = $network->checkSubscription($acquiaServices);

    $class = new static($subscription, $config->get('network-identifier'));

    return $class->select($argv[1]);
  }
}
