[![Build Status](https://travis-ci.org/jadb/feature_toggle.svg?branch=master)](https://travis-ci.org/jadb/feature_toggle)
[![Total Downloads](https://poser.pugx.org/jadb/feature_toggle/downloads.svg)](https://packagist.org/packages/jadb/feature_toggle)
[![License](https://poser.pugx.org/jadb/feature_toggle/license.svg)](https://packagist.org/packages/jadb/feature_toggle)

# Feature Toggle

_a.k.a. Feature Flip, Feature Flag, Feature Switch_

From [Wikipedia](http://en.wikipedia.org/wiki/Feature_toggle):

> Feature Toggle is a technique in software development that attempts to provide an
> alternative to maintaining multiple source code branches, called feature branches.
>
> Continuous release and continuous deployment enables you to have quick feedback
> about your coding. This requires you to integrate your changes as early as possible.
> Feature branches introduce a by-pass to this process. Feature toggles brings you back
> to the track, but the execution paths of your feature is still “dead” and “untested”,
> if a toggle is “off”. But the effort is low to enable the new execution paths just by
> setting a toggle to “on”.

### Common use cases:

* Limited testing (i.e. employees only based on email address, subset of users, etc.)
* Gradual feature release (i.e. by location, by subscription, by browser, etc.)

## Install

FeatureToggle can be installed using [Composer][composer] (of course, you could always
clone it from GitHub).

In `composer.json`:

```json
{
    "require": {
        "jadb/feature_toggle": "*"
    }
}
```

To install, you may then run:

```
$ php composer.phar install
```

## Example

In your application's bootstrap:

```php
use FeatureToggle\FeatureRegistry;

FeatureRegistry::init('Cool Feature', [
	'description' => 'A cool new feature!',
	'strategies' => [
		'UserAgent' => [['/opera/', '/Mozilla\/5\.0/']],
		function ($Feature) {
			return !empty($_SESSION['isAdmin']);
		},
		function ($Feature) {
			return !empty($_SESSION[$Feature->getName()]);
		}
	]
]);
```

and then, anywhere in your code, you can check this feature's status like so:

```php
if (\FeatureToggle\FeatureManager::isEnabled('Cool Feature')) {
	// do something
}
```

## What's included?

### Features

* __BooleanFeature__: Tells if feature is enabled or not based on a set of strategies.
* __EnabledFeature__: Forces feature to always be enabled.
* __DisabledFeature__: Forces feature to always be disabled.

Features __MUST__ implement the `FeatureInterface`.

### Strategies

* __DateTimeStrategy__: Compares today's time to set date and time.
* __DateTimeRangeStrategy__: Checks if today's time is in set date time range.
* __UserAgentStrategy__: Checks if browser's user agent matches any allowed agent.

Strategies __MUST__ implement the `StrategyInterface`.

## Todo

* Enable feature only when {n} (or all) strategies pass
* `RedisStorage` to keep track of features
* `PercentageStrategy` enable feature to a percentage of users - requires `RedisStorage`
* Option to automatically disable a feature if error threshold reached - requires `RedisStorage`

## Contributing

* Fork
* Mod, fix, test
* _Optionally_ write some documentation (currently in `README.md`)
* Send pull request

All contributed code must be licensed under the [BSD 3-Clause License][bsd3clause].

## Bugs & Feedback

http://github.com/jadb/feature_toggle/issues

## License

Copyright (c) 2014, [Jad Bitar][jadbio]

Licensed under the [BSD 3-Clause License][bsd3clause].

Redistributions of files must retain the above copyright notice.

[jadbio]:http://jadb.io
[bsd3clause]:http://opensource.org/licenses/BSD-3-Clause
[composer]:http://getcomposer.org
