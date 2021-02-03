<?php
/**
 * HttpClientPlugin.php
 */

namespace app\plugin;
/**
 * Copyright 2021 Fernando Martinez
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use cl\contract\CLInjectable;
use cl\contract\CLLogger;
use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;
use cl\core\CLDependency;

/**
 * Class HttpClientPlugin
 * @package app\plugin
 */
class HttpClientPlugin implements \cl\contract\CLPlugin, CLInjectable
{
    private $logger;
    private $clServiceRequest;
    private $pluginResponse;
    /**
     * @var \cl\core\CLSimpleHttpClient
     */
    private $httpclient;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }

    public function run(): CLResponse
    {
        _log('executing HttpClientPlugin');
        $response = $this->httpclient->get(
            (new \cl\web\CLBasicHttpClientRequest('https://openlibrary.org/subjects/programming.json?limit=25'))
                ->addHeader('Accept', 'application/json')
        );
        $this->pluginResponse->addVars(['head.value' => 'Programming Books Received', 'body.value' => $this->getBookList($response->getPayload()[0])]);
        return $this->pluginResponse;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed $httpclient
     */
    public function setHttpclient($httpclient): void
    {
        $this->httpclient = $httpclient;
    }

    /**
     * @return array required dependencies
     * each entry provides information about a dependency, in the form: CLDependency::new('key'), where key is the key
     * assigned to that dependency. A key is assigned to a dependency, either by Code-lib (CL), or, if not a dependency
     * pre-configured by CL, by a Plugin in your App the first time it is needed.
     * When a dependency is configured for the first time by your App, it must tell the framework where to find it, and
     * how you want it instantiated. Use additional parameters of CLDependency::new to achieve that.
     * For instance, the $classname parameter allows you to specify the full class name (namespace and class name) of
     * your dependency. $exClass allows CL to reinforce what parent class your $classname must extend or implement.
     * Use $params if you need to pass any parameters to the dependency, and $instType to indicate whether this dependency
     * can be shared or not, by using values CLFlag::SHARED or CLFlag::NOT_SHARED.
     * is an array as well, which specifies the dependency key, optional class, optional params, and optional instantiation
     * type. Ex.:
     * return [CLDependency::new('cache', null, null, null, CLFlag::SHARED)],  // <-- requires a cache instance. CL knows about
     * this key, so no class is required
     * return [CLDependency::new('mysmartclass', '\app\core\Smartest.php', null, null, CLFlag::NOT_SHARED)]; // <-- requires this
     * App class, Smartest, which CL might not know about, so we tell it where to find it.
     * If CL finds the required dependency, it will inject it in your Plugin, using a setter method based on the dependency key.
     * So, in the example above, it would call: setCache(cacheInstance); and setMysmartclass(smartInstance);
     * as it would expect those setter methods to be available in your Plugin.
     * For this sample, given that our dependency key is 'httpclient', it would then expect a setter: setClhttpclient,
     * which you can see defined above.
     * Notice that because httpclient is a dependency known to CL, you don't have to specify its classname or its parent
     */
    public function dependsOn(): array
    {
        return [CLDependency::new('httpclient')];
    }

    private function getBookList($data): string {
        if ($data == null) { return 'no books returned'; }
        $jsondata = json_decode($data, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $works = $jsondata['works']??[];
            if (count($works) > 0) {
                $html = '<h3>Number of books returned: '.count($works).'</h3>';
                $html .= '<ul>';
                foreach ($works as $work) {
                    $html .= '<li><div><strong>Title:</strong> ' . $work['title'] . '</div>';
                    if (isset($work['authors'])) {
                        foreach ($work['authors'] as $author) {
                            $html .= '<div><strong>Author:</strong> ' . $author['name'] . '</div>';
                        }
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
                return $html;
            }
        }
        return 'no books returned';
    }
}
