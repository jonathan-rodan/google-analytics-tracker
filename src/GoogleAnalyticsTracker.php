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
namespace GoogleAnalyticsTracker;
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

use GoogleAnalyticsTracker\HitTypes\HitType;
use GoogleAnalyticsTracker\Request\Mappers\MapperFactory;
use GoogleAnalyticsTracker\Utils\Request\Sender;
use GoogleAnalyticsTracker\Utils\UUID;

class GoogleAnalyticsTracker
{
    /**
     * @var $trackingId string      The tracking ID / web property ID. The format is UA-XXXX-Y.
     *      All collected data is associated by this ID.
     */
    private $trackingId;

    /**
     * @var $dataSource string|null Indicates the data source of the hit. Hits sent from analytics.js will have data
     *      source set to 'web'; hits sent from one of the mobile SDKs will have data source set to 'app'.
     */
    private $dataSource;

    /**
     * @var $cid       string       This anonymously identifies a particular user, device, or browser instance. For the
     *      web, this is generally stored as a first-party cookie with a two-year expiration. For mobile apps, this is
     *      randomly generated for each particular instance of an application install. The value of this field should
     *      be a random UUID (version 4) as described in http://www.ietf.org/rfc/rfc4122.txt
     */
    private $cid;

    /**
     * @var $uid       string|null  This is intended to be a known identifier for a user provided by the site
     *      owner/tracking library user.
     */
    private $uid;

    /**
     * @var $sender     Sender      Sends the payload to the specified domain
     */
    private $sender;

    function __construct($trackingId, $cid = null, $uid = null, $dataSource = null, Sender $sender = null)
    {
        $this->trackingId = $trackingId;
        $this->cid = $cid ?: UUID::v4();
        $this->uid = $uid;
        $this->dataSource = $dataSource;
        $this->sender = $sender ?: new Sender();
    }

    public function send(HitType $hit)
    {
        if($hit != null) {
            $mapperForMe = MapperFactory::getMapper($this);
            $dataFromMe = $mapperForMe->map($this);
            $mapper = MapperFactory::getMapper($hit);
            $data = $mapper->map($hit);
            $payload = http_build_query(array_merge($dataFromMe, $data));
            return $this->sender->send($payload);
        }
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param string $dataSource
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @param string $cid
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    /**
     * @return string
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @return null|string
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @return Sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getTrackingId()
    {
        return $this->trackingId;
    }

    /**
     * @return null|string
     */
    public function getUid()
    {
        return $this->uid;
    }
}
