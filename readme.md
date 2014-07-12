## Acquia Util Framework

This is something I've hacked together in 30 minutes so I could do ad-hoc search queries against a solr index.

It's by no means clean or awesome yet. But maybe it could be.

## Installation

Make sure you install [composer](https://getcomposer.org/download/) first and then run:

```
composer install
```

## Usage

There are a couple of steps you'll need to do in order to get this working.

1. The script tries to create a ```~/.acquia-util``` folder where it can hold configuration files. Creating this ahead of time would be a good idea.
2. The script has you pass a config string so it knows what search index to use. As of the latest version, SolrSearch will ask you for the information it needs if it does not find the configuration file.

### Config file
As of the latest version the configuration file is a json file.

You'll need to look up the API keys from your acquia hosting page before searching, as SolrSearch will ask for the configuration information it needs before it produces its first search results.


### Usage example
A couple of commands are supported, but the simplest usage is to search on a string:

```./run SolrSearch llama kittens```

The "llama" is the search index identifier, with "kittens" being the search string.

It also supports facet searching like so:

```./run SolrSearch::facetSearch llama tm_vid_9_names 'Security'```

The parameters are search index identifier, facet name, and search string.

### Todo:
* Save search index config locally.
* Automated Testing
* Pretty formatting
* More commands
