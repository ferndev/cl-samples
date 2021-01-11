<?php
/**
 * HelloPlugin.php
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

use cl\contract\CLLogger;
use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;

/**
 * Class HelloPlugin
 * @package app\plugin
 */
class HelloPlugin implements \cl\contract\CLPlugin
{
    private $logger;
    private $clServiceRequest;
    private $pluginResponse;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }

    public function run(): CLResponse
    {
        // we can log with this global function
        _log('executing HelloPlugin');
        // or we can log using the logger class injected to our Plugin
        $this->logger->info('always before rendering the output');
        // since we have a very simple page, defined programmatically, as view, we direct our output to the head and to the body of the page,
        // so we may have a page title and page content.
        // take a look at $app->addElement() in index.php of this sample, for details of how we defined our page
        $this->pluginResponse->addVars(['head.value' => 'My Plugin Page Title', 'body.value' => 'Hello, World! I am a Plugin']);
        return $this->pluginResponse;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }
}
