<?php
namespace GoogleAnalyticsTracker\Utils\Request;
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

class Sender
{
    private $domain;
    private $port;
    private $path;
    private $protocol;
    private $userAgent;

    CONST FAKE_USER_AGENT = 'googleanalyticstrackerbot/1.0 (no.contact.info/available)';

    function __construct($domain = 'www.google-analytics.com', $path = 'collect', $port = 80, $protocol = 'http', $userAgent = null)
    {
        $this->domain = $domain;
        $this->path = $path;
        $this->port = $port;
        $this->protocol = $protocol;
        $this->userAgent = $userAgent ?: self::FAKE_USER_AGENT;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function send($payload) {
        return $this->post($payload);
    }

    public function post($payload)
    {
        $url = "{$this->protocol}://{$this->domain}/{$this->path}";
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandler, CURLOPT_TIMEOUT, 5);
        curl_setopt($curlHandler, CURLOPT_USERAGENT, self::FAKE_USER_AGENT);
        curl_setopt($curlHandler, CURLOPT_HEADER, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $payload);
        curl_exec($curlHandler);
        $status = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
        curl_close($curlHandler);
        $success = (($status - ($status % 100) ) / 100) == 2;
        if(!$success) {
            error_log("Error tacking in Google Analytics ($payload)");
        }
        return $success;
    }

    public function get($payload)
    {
        $url = "{$this->protocol}://{$this->domain}/{$this->path}?$payload";
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandler, CURLOPT_TIMEOUT, 5);
        curl_setopt($curlHandler, CURLOPT_USERAGENT, self::FAKE_USER_AGENT);
        curl_setopt($curlHandler, CURLOPT_HEADER, true);
        curl_exec($curlHandler);
        $status = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
        curl_close($curlHandler);
        $success = (($status - ($status % 100) ) / 100) == 2;
        if(!$success) {
            error_log("Error tacking in Google Analytics ($payload)");
        }
        return $success;
    }
} 
