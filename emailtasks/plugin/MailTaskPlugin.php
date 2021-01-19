<?php
/**
 * MailTaskPlugin.php
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
use cl\contract\CLResponse;
use cl\core\CLDependency;
use cl\plugin\CLBasePlugin;

/**
 * Class MailTaskPlugin
 * @package app\plugin
 */
class MailTaskPlugin extends CLBasePlugin implements \cl\contract\CLPlugin, CLInjectable
{
    use AssignedUsers;
    private $emailService;

    public function run(): CLResponse
    {
        _log('Processing user data in MailTaskPlugin');
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        $response = $this->prepareResponse();
        $adminEmail = $this->clServiceRequest->getCLConfig()->getAppConfig('adminEmail');
        if ($adminEmail == null) {
            _log('No admin email configured, so no "from" field can be set, no emails will be sent');
            return $response;
        }
        if (isset($clrequest['task'])) {
            $tasks = $clrequest['task'];
            if ($tasks != null && is_array($tasks)) {
                $this->emailTasks($adminEmail, $tasks);
            }
            // here, if the user entered his/her name we redirect to a different page (the page pg2 we declared as well
            // in index.php, and within that page, we assign the Welcome message to the span element we created there
            $response->addVars(['span.value' => 'MailTaskPlugin says: Welcome, '.$clrequest['userdata'].', I grant you access to the Welcoming Page! :-)', 'page' => 'pg2']);
        }
        return $response;
    }

    private function emailTasks($from, $tasks) {
        $pointers = ['getTask1Users', 'getTask2Users', 'getTask3Users'];
        $n = count($tasks);
        for ($i=0; $i < $n; $i++) {
            if (isset($tasks[$i])) {
                $users = $this->{$pointers[$i]}();
                foreach ($users as $user) {
                    if (isset($users) && $this->emailService != null) {
                        $this->emailService->send($this->prepareMessage($from, $user, $tasks[$i]));
                    }
                }
            }
        }
    }

    private function prepareMessage($from, $user, $task) {
        $message = 'Hi '.$user[0]. ',<br> Here is your new task. Please read carefully bellow and complete asap. Rgds<br><br>'. $task;
        return ['to' => $user[1], 'from' => $from, 'subject' => 'Your task for the day', 'message' => $message];
    }

    /**
     * @param mixed $emailService
     * @return MailTaskPlugin
     */
    public function setEmailService($emailService)
    {
        $this->emailService = $emailService;
        return $this;
    }

    /**
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
        return [CLDependency::new('emailService')];
    }
}
