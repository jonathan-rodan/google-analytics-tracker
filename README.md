# google-analytics-tracker

PHP Library for the [`Analytics Measurement Protocol`](https://developers.google.com/analytics/devguides/collection/protocol/v1/?hl=en) of `Google Analytics`

# Features

You can send `events` and `pages` with `custom dimensions` and `custom metrics` with a very simple interface.

# Installing

Using Composer `jonathan-rodan/google-analytics-tracker`.

```
"require": {
        "jonathan-rodan/google-analytics-tracker": "master"
},
"repositories" : [
    {
        "type": "git",
        "url": "https://github.com/jonathan-rodan/google-analytics-tracker.git"
    }
]
```

# Example Code

## Instantiating the tracker

```php
require_once __DIR__ . "/../vendor/autoload.php";

$tid = 'UA-0000000-00';

$tracker = new \GoogleAnalyticsTracker\GoogleAnalyticsTracker($tid);
$tracker->setUserAgent('yourcustomeventsenderbot/1.0 (+http://your.domanin.com/contactus)');
```

You should have the Tracking Id from Google Analytics.

You should specify a [formatted user agent string](https://en.wikipedia.org/wiki/User_agent#Format). If you don't specify any, a default `googleanalyticstrackerbot/1.0 (no.contact.info/available)` user agent will be used.

[Client Id](https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cid) and [User Id](https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#uid) can be specified in the constructor and with the setters.

Option 1
```php
$tracker = new \GoogleAnalyticsTracker\GoogleAnalyticsTracker($tid, $clientId, $userId);
```
option 2
```php
$tracker = new \GoogleAnalyticsTracker\GoogleAnalyticsTracker($tid);
$tracker->setClientId($clientId);
$tracker->setUserId($userId);
```

If you want to keep track of the Client Ids, you can create one using our `\GoogleAnalyticsTracker\Utils\UUID::v4()` function. If you don't specify a Client Id, we will create one using that same function.
This library has no persistence layer. That means that we don't keep track and maintain the Client Ids.

## Sending Events

Simple Event with a label and a value of 10.

```php
require_once __DIR__ . "/../vendor/autoload.php";

$tid = 'UA-0000000-00';

$tracker = new \GoogleAnalyticsTracker\GoogleAnalyticsTracker($tid);
$tracker->setUserAgent('yourcustomeventsenderbot/1.0 (+http://your.domanin.com/contactus)');

$event = new \GoogleAnalyticsTracker\HitTypes\Event("Event Category", "Event Action", "The label of the event", 10);
$event->setCustomDimension(6, "foo")
      ->setCustomDimension(17, "bar");

$tracker->send($event) //true on success, false on failure.
```

When sending the value, without a label, and with metrics:

```php
require_once __DIR__ . "/../vendor/autoload.php";

$tid = 'UA-0000000-00';

$tracker = new \GoogleAnalyticsTracker\GoogleAnalyticsTracker($tid);
$tracker->setUserAgent('yourcustomeventsenderbot/1.0 (+http://your.domanin.com/contactus)');

$event = new \GoogleAnalyticsTracker\HitTypes\Event("Event Category", "Event Action");
$event->setCustomDimension(6, "foo")
      ->setCustomMetric(17, 1)
      ->setCustomMetric(2, 1000)
      ->setValue(10);

$tracker->send($event) //true on success, false on failure.
```

## Sending Pages

```php
require_once __DIR__ . "/../vendor/autoload.php";

$tid = 'UA-0000000-00';

$tracker = new \GoogleAnalyticsTracker\GoogleAnalyticsTracker($tid);
$tracker->setUserAgent('yourcustomeventsenderbot/1.0 (+http://your.domanin.com/contactus)');

$page = new Page("domain", "/path", "title");
$page->setCustomDimension(5, "DimensionFive");
$page->setCustomDimension(9, "DimensionNine");

$tracker->send($page) //true on success, false on failure.
```

# To be implemented

* E-Commerce Tracking
* Social Interacions
* Exception Tracking (in google analytics, the library logs an error with error_log when a request to google analytics fails).
* User Timing
* App / Screen Tracking (Which doesn't apply in PHP)

# Requirements

* Google Analytics Tracker works with `PHP 5.3` or above. It has not been tested for `HHVM`.

# Author

* Jonathan Rodan (https://github.com/jonathan-rodan)

# License

Google Analytics Tracker is licensed under the MIT License - see the `LICENSE` file for details
