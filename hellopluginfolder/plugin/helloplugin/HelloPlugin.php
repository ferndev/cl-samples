<?php
/**
 * HelloPlugin.php
 */

namespace app\plugin\helloplugin;
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
 * Class HelloPlugin
 * @package app\plugin\helloplugin
 */
class HelloPlugin implements \cl\contract\CLPlugin, CLInjectable
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
        _log('executing HelloPlugin');
        // or we can log using the logger class injected to our Plugin
        $this->logger->info('always before rendering the output');
        // notice how here we use the injected dependency to produce the output (sayHello)
        $this->pluginResponse->addVars(['_phead.value' => 'HelloPlugin Sets the Page Title',
            '_body.value' => 'HelloPlugin gets output from injected dependency:'.$this->dependency->sayHello()]);
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
     * This method, which is part of the CLInjectable interface, specifies what dependencies must be injected to this Plugin.
     * It does so by returning an array of CLDependency objects, one per required dependency.
     * In this case, there is only one dependency required.
     * The first parameter of a CLDependency is its key, in this example 'pluginDependency' below, and it will be used by CL
     * to identify the name of the dependency setter in this Plugin. So, for this sample, this plugin must declare a
     * method called setPluginDependency($dependency) (see above).
     * @return array required dependencies
     * each entry is an array as well, which specifies the dependency key, optional class, optional params, and optional instantiation
     * type. Ex.:
     * return [['cache', null, CLFlag::SHARED],  // <-- requires a cache instance. CL knows about this key, so no class is required
     *         ['mysmartclass', '\app\core\Smartest.php', CLFlag::NOT_SHARED]]; // <-- requires this App class, which CL might not know about, so we tell it where to find it
     * notice that CL will use the key passed to determine the name of a setter method that will receive the instance in your Plugin class.
     * so, in the example above, it would call: setCache(cacheInstance); and setMysmartclass(smartInstance);
     */
    public function dependsOn(): array
    {
        return [new CLDependency('pluginDependency','\app\plugin\helloplugin\PluginDependency',null,null,CLFlag::SHARED)];
    }
}
