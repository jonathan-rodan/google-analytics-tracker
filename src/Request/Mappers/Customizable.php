<?php
namespace GoogleAnalyticsTracker\Request\Mappers;
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

class Customizable
{
    /**
     * @param \GoogleAnalyticsTracker\Customizations\Common\Customizable $customizable
     * @return array
     */
    public function map($customizable)
    {
        if (!($customizable instanceof \GoogleAnalyticsTracker\Customizations\Common\Customizable)) {
            throw new \UnexpectedValueException("The Customizable Mapper only accepts Customizable HitTypes");
        }

        $data = Array();

        $customDimensions = $customizable->getCustomDimensions();
        if(!empty($customDimensions)) {

            foreach($customizable->getCustomDimensions() as $customDimension) {
                if(!isset($customDimensionsMapper)) {
                    $customDimensionsMapper = MapperFactory::getMapper($customDimension);
                }
                list($k, $v) = $customDimensionsMapper->map($customDimension);
                $data[$k] = $v;
            }
        }

        $customMetrics = $customizable->getCustomMetrics();
        if(!empty($customMetrics)) {

            foreach($customizable->getCustomMetrics() as $customMetric) {
                if(!isset($customMetricsMapper)) {
                    $customMetricsMapper = MapperFactory::getMapper($customMetric);
                }
                list($k, $v) = $customMetricsMapper->map($customMetric);
                $data[$k] = $v;
            }
        }

        return $data;
    }
} 
