<?php
/**
 * HappyTooPlugin.php
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
 * Class HappyTooPlugin
 * @package app\plugin
 */
class HappyTooPlugin extends CLBasePlugin implements \cl\contract\CLPlugin
{

    public function run(): CLResponse
    {
        $this->logger->info('Processing user data in HappyTooPlugin');
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        if (isset($clrequest['userdata'])) {
            $this->pluginResponse->setVar('span.value','<br>HappyTooPlugin says: Happy to welcome you too! :-)', true);
        }
        return $this->pluginResponse;
    }
}
