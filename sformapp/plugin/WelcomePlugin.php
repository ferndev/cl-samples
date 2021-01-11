<?php
/**
 * WelcomePlugin.php
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
use cl\plugin\CLBasePlugin;

/**
 * Class WelcomePlugin
 * @package app\plugin
 */
class WelcomePlugin extends CLBasePlugin implements \cl\contract\CLPlugin
{
    public function run(): CLResponse
    {
        $this->logger->info('Processing user data in WelcomePlugin');
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        $response = $this->prepareResponse();
        if (isset($clrequest['userdata'])) {
            // here, if the user entered his/her name we redirect to a different page (the page pg2 we declared as well
            // in index.php, and within that page, we assign the Welcome message to the span element we created there
            $response->addVars(['span.value' => 'WelcomePlugin says: Welcome, '.$clrequest['userdata'].', I grant you access to the Welcoming Page! :-)', 'page' => 'pg2']);
        } else {
            $response->addVars(['span.value' => 'Welcome, Anonymous']);
        }
        return $response;
    }
}
