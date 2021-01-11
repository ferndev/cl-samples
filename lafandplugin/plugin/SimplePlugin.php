<?php
/**
 * SimplePlugin.php
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
use cl\plugin\CLBaseResponse;

/**
 * Class SimplePlugin
 * @package app\plugin
 */
class SimplePlugin implements \cl\contract\CLPlugin
{
    protected $clServiceRequest;
    protected $logger;
    protected $pluginResponse;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }


    public function run() : CLResponse {
        // this Plugin only does one thing: it sets 2 variables which the framework will set on the active look and feel (LAF).
        // See in the look and feel, that cltitle is contained in the page LAF: stylish.php, while aboutus is in the
        // child control LAF: about.php
        $this->pluginResponse->addVars(array('cltitle' => 'Page title replaced by Plugin', 'aboutus' => 'SimplePlugin says: Codelib works nicely with the Stylish portfolio Bootstrap template'));
        return $this->pluginResponse;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }
}
