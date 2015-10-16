<?php
/**
 *  Copyright (c) 2015 Jonathan Rodan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
use GoogleAnalyticsTracker\GoogleAnalyticsTracker;
use GoogleAnalyticsTracker\HitTypes\Event;
use GoogleAnalyticsTracker\HitTypes\Page;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/FakeSender.php";

//Test event 1

$fakeSender = new FakeSender();

$googleAnalyticsTracker = new GoogleAnalyticsTracker('UA-12345-1', '1234-1234-1234-123455678' , 'uid' , 'dataSource', $fakeSender);

//Event with dimension and metric

$event = new Event("category", 'action', 'label', 1);
$event->setCustomDimension(1, "dimension[1]");
$event->setCustomMetric(1, 1);

$fakeSender->setExpects("v=1&tid=UA-12345-1&cid=1234-1234-1234-123455678&uid=uid&ds=dataSource&t=event&ea=action&ec=category&el=label&ev=1&cd1=dimension%5B1%5D&cm1=1");
$googleAnalyticsTracker->send($event);

//Event with least amount of thins possible

$event = new Event("category", 'action');
$fakeSender->setExpects("v=1&tid=UA-12345-1&cid=1234-1234-1234-123455678&uid=uid&ds=dataSource&t=event&ea=action&ec=category");
$googleAnalyticsTracker->send($event);

//Page with multiple dimensions
$page = new Page("domain","/path","title");
$page->setCustomDimension(5,"DimensionFive");
$page->setCustomDimension(9,"DimensionNine");
$fakeSender->setExpects("v=1&tid=UA-12345-1&cid=1234-1234-1234-123455678&uid=uid&ds=dataSource&t=pageview&dh=domain&dp=%2Fpath&dt=title&cd5=DimensionFive&cd9=DimensionNine");
$googleAnalyticsTracker->send($page);


//Page with no title and multiple metrics
$page = new Page("domain","/path/longer");
$page->setCustomMetric(2,4);
$page->setCustomMetric(19,8);
$fakeSender->setExpects("v=1&tid=UA-12345-1&cid=1234-1234-1234-123455678&uid=uid&ds=dataSource&t=pageview&dh=domain&dp=%2Fpath%2Flonger&cm2=4&cm19=8");
$googleAnalyticsTracker->send($page);
