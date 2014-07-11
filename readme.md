## Acquia Util Framework

This is something I've hacked together in 30 minutes so I could do ad-hoc search queries against a solr index.

It's by no means clean or awesome yet. But maybe it could be.

## Usage

There are a couple of steps you'll need to do in order to get this working.

1. The script tries to create a ```~/.acquia-util``` folder where it can hold configuration files. Creating this ahead of time would be a good idea.
2. The script has you pass a config string so it knows what search index to use. It's simply named whatever you're checking. You'll want a .php file named the same thing in the ```~/.acquia-util``` folder. For example ```~/.acquia-util/llama.php``` would be the llama instance. Structure of this file is below.

### Usage example
A couple of commands are supported, but the simplest usage is to search on a string:

```./run SolrSearch llama kittens```

The "llama" is the search index identifier, with "kittens" being the search string.

It also supports facet searching like so:

```./run SolrSearch::facetSearch llama tm_vid_9_names 'Security'```

The parameters are search index identifier, facet name, and search string.

### Structure of config file
It's simply a php file, structured in an array. This will change eventually, but I needed something quick and dirty.

You'll need to look up the API key from your acquia hosting page.

```php
<?php

$config = array(
  'network-identifier' => 'IKRY-XXXXX',
  'search-identifier'  => 'IKRY-XXXXX',
  'network-key'        => 'SUPERSECRETHASHKEY',
);

```

### Todo:
* Save search index config locally.
* Automated Testing
* Pretty formatting
* More commands
