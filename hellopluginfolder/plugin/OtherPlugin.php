<?php
/**
 * OtherPlugin.php
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
use cl\core\CLFlag;

/**
 * Class OtherPlugin
 * @package app\plugin
 */
class OtherPlugin implements \cl\contract\CLPlugin, CLInjectable
{
    private $logger;
    private $clServiceRequest;
    private $pluginResponse;
    private $dependency;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }

    public function run(): CLResponse
    {
        // we can log with this global function
        _log('executing OtherPlugin');
        // or we can log using the logger class injected to our Plugin
        $this->logger->info('always before rendering the output'); // look into the logs2/ folder of your App to find the applog_info_ log file
        $this->pluginResponse->setVar('_body.value', '<br>OtherPlugin also gets output from same injected dependency:'.$this->dependency->sayHello(), true);
        $this->pluginResponse->setVar('_body.value', '<br>Note in the code that OtherPlugin only specifies the dependency key, and it is up to CL to know by then what it is.', true);
        return $this->pluginResponse;
    }

    public function setPluginDependency($dependency) {
        $this->dependency = $dependency;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Notice how this Plugin only specifies the dependency key, but nothing else.
     * Because this Plugin executes after HelloPlugin, CL already knows what pluginDependency is
     * @return CLDependency[]
     */
    public function dependsOn(): array
    {
        return [new CLDependency('pluginDependency',null,null,null,CLFlag::SHARED)];
    }
}
