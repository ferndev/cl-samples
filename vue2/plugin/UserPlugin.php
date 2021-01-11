<?php
/**
 * UserPlugin.php
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

use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;
use cl\core\CLFlag;
use cl\plugin\CLUserPlugin;

/**
 * Class UserPlugin
 * A sample user plugin for a code-lib PHP web app
 * this plugin delegates to CLUserPlugin, to handle user registration and login
 * @package app\plugin
 */
class UserPlugin extends CLUserPlugin implements \cl\contract\CLPlugin {

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        parent::__construct($clServiceRequest, $pluginResponse);
    }

    public function run(): CLResponse
    {
        // delegate processing to the parent plugin
        $response = parent::run($this->pluginResponse);
        // we then intercept the response from the parent plugin,
        // so we can do further processing if necessary. Here, just as an example, we set imaginary
        // visits, sales, and unique visits percentage for a fictitious website, when the user login.
        // Finally, return the response
        $status = $response->getVar('status');
        $clrequest = $this->clServiceRequest->getCLRequest();
        $clflow = $clrequest->getRequestId();
        // first, let's make sure the user just logged in successfully
        if ($status == null || $status != CLFlag::SUCCESS || $clflow !== 'user/login') { return $response; }
        $response->setVar('visits', 100000);
        $response->setVar('sales', 10000);
        $response->setVar('uniquevisits', '24%');
        return $response;
    }
}
