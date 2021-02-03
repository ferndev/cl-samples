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
     * this key, so no class is required. Another example:
     * return [CLDependency::new('mysmartclass', '\app\core\Smartest.php', null, null, CLFlag::NOT_SHARED)]; // <-- requires this
     * App class, Smartest, which CL might not know about, so we tell it where to find it.
     * If CL finds the required dependency, it will inject it in your Plugin, using a setter method based on the dependency key.
     * So, in the example above, it would call: setCache(cacheInstance); and setMysmartclass(smartInstance);
     * as it would expect those setter methods to be available in your Plugin
     */
    public function dependsOn(): array
    {
        return [CLDependency::new('emailService')];
    }
}
