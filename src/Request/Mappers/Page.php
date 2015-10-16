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

class Page extends Customizable
{

    /**
     * @param \GoogleAnalyticsTracker\HitTypes\Page $page
     * @return mixed
     */
    public function map($page)
    {
        if (!($page instanceof \GoogleAnalyticsTracker\HitTypes\Page)) {
            throw new \UnexpectedValueException("The Page Mapper only accepts Page HitTypes");
        }
        $data = Array(
            't' => \GoogleAnalyticsTracker\HitTypes\Page::TYPE,
            'dh' => $page->getDomain(),
            'dp' => $page->getPage()
        );

        if ($page->hasTitle()) {
            $data['dt'] = $page->getTitle();
        }

        $data = array_merge($data, parent::map($page));

        return $data;
    }
}
