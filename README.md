# Concise

[![Latest Version](https://img.shields.io/github/release/toin0u/concise.svg?style=flat-square)](https://github.com/toin0u/concise/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/toin0u/concise.svg?style=flat-square)](https://travis-ci.org/toin0u/concise)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/toin0u/concise.svg?style=flat-square)](https://scrutinizer-ci.com/g/toin0u/concise)
[![Quality Score](https://img.shields.io/scrutinizer/g/toin0u/concise.svg?style=flat-square)](https://scrutinizer-ci.com/g/toin0u/concise)
[![HHVM Status](https://img.shields.io/hhvm/toin0u/concise.svg?style=flat-square)](http://hhvm.h4cc.de/package/toin0u/concise)
[![Total Downloads](https://img.shields.io/packagist/dt/toin0u/concise.svg?style=flat-square)](https://packagist.org/packages/toin0u/concise)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2344d739-b954-4c9b-ae14-18bf9f095d7e/mini.png)](https://insight.sensiolabs.com/projects/2344d739-b954-4c9b-ae14-18bf9f095d7e)

**Concise your urls via extern providers :)**

## Install

Via Composer

``` bash
$ composer require toin0u/concise
```


## Usage

Simple example using `Google` provider:

``` php
use Concise\Concise;
use Concise\Provider\Google;
use Ivory\HttpAdapter\GuzzleHttpAdapter;

$concise = new Concise(new Google(new GuzzleHttpAdapter));

// Returns the shortened URL
$concise->shorten('http://any.url');

// Returns the expanded URL
$concise->expand('http://short.ly/1234');
```

For full list of available adapters check the official [documentation](https://github.com/egeloen/ivory-http-adapter/blob/master/doc/adapters.md).

Currently supported providers:

- Bitly
- Google
- Tinycc


### Provider chaining

You can shorten a URL using multiple providers at once.

Make sure to add the `Provider`s in the chain in the SAME ORDER for both shortening and expanding. Expanding is automatically done in a reversed order.

``` php
use Concise\Concise;
use Concise\Provider\Chain;

$chain = new Chain;

$chain->addProvider(/* add a Provider instance here */);
$chain->addProvider(/* add another Provider instance here */);

$concise = new Concise($chain);
```


### Caching

When working with lots of URLs it probably makes sense to cache already shortened/expanded URLs. This way you can avoid unnecessary HTTP requests.

To use caching install a PSR-6 cache implementation, like [Stash](http://www.stashphp.com/):

``` bash
$ composer require tedivm/stash
```


``` php
use Concise\Concise;
use Concise\Provider\Cache;
use Stash\Pool;

$cache = new Cache(/* add a Provider instance here */, new Pool);
$concise = new Concise($cache);
```


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Antoine Corcy](https://github.com/toin0u)
- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/toin0u/concise/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
