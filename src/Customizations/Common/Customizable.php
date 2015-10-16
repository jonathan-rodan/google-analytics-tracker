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
namespace GoogleAnalyticsTracker\Customizations\Common;

use GoogleAnalyticsTracker\Customizations\CustomDimension;
use GoogleAnalyticsTracker\Customizations\CustomMetric;
use GoogleAnalyticsTracker\HitTypes\HitType;

class Customizable implements HitType
{
    protected $customDimensions = Array();
    protected $customMetrics = Array();

    /**
     * @return mixed
     */
    public function getCustomDimensions()
    {
        return $this->customDimensions;
    }

    /**
     * @param $id    int
     * @param $value string
     * @return $this
     */
    public function setCustomDimension($id, $value)
    {
        $this->customDimensions[$id] = new CustomDimension($id, $value);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomMetrics()
    {
        return $this->customMetrics;
    }

    /**
     * @param $id    int
     * @param $value float
     * @return $this
     */
    public function setCustomMetric($id, $value)
    {
        $this->customMetrics[$id] = new CustomMetric($id, $value);
        return $this;
    }
}
