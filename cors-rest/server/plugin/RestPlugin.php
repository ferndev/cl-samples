<?php
/**
 * RestPlugin.php
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

/**
 * Class RestPlugin
 * A sample Code-lib Plugin able to process REST requests, responding with appropriate JSON data
 * @package app\plugin
 */
class RestPlugin extends \cl\plugin\CLBasePlugin
{
    private $trivialStore = []; // together with the persist and load functions below, let's create a very basic file store
    private $storePath = BASE_DIR.'/resources/temp/';

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse) {
        parent::__construct($clServiceRequest, $pluginResponse);
        // if the sample cannot create this temp folder it will fail with anException. Make sure at least the resources/
        // folder under your App root folder, exists and is writable.
        \cl\util\Util::ensurePathExists(BASE_DIR.'/resources/temp/');
        $this->load();
        if (count($this->trivialStore) == 0) {

            $this->trivialStore['fern1'] = new User('fern1', 'fern1@example.com');
            $this->trivialStore['user2'] = new User('user2', 'user2@example.com');
            $this->persist();
        }
    }

    /**
     * We map here http methods to our Plugin methods
     * @return string[] // specifically, for a GET request, we will call the getData() function, for a POST, the addData fn, etc
     */
    protected function mapHttpMethod() : array {
        return ['get' => 'getData', 'post' => 'addData', 'put' => 'updateData'];
    }

    public function getData(): \cl\plugin\CLBaseResponse
    {
        $elems = $this->getFlowElements(); // this will return an array with the elements in the flow key.
                                           // For instance, for rest/users/peter, it would return ['rest','users','peter']
        $users = [];
        if (count($elems) >= 4 && $elems[1] == 'users' && $elems[2] == 'username') {
            $username = $elems[3];
            $user = $this->getUserByUsername($username);
            if ($user != null) { $users[] = $user; }
        } else {
            $users = $this->getAllUsers();
        }
        $n = count($users);
        error_log($n.' users returned');
        $response = $this->prepareResponse('success');
        $response->setVar('users', $users);
        $response->setVar(CLFlag::PRODUCES, 'json'); // just to make sure, but likely CL would return JSON based on the request
        return $response;
    }

    public function addData(): \cl\plugin\CLBaseResponse
    {
        $request = $this->clServiceRequest->getCLRequest()->getRequest();
        // data is not really persisted in this sample
        if (isset($request['username']) && isset($request['email'])) {
            $user = new User($request['username'], $request['email']);
            $this->trivialStore[$request['username']] = $user;
            $this->persist();
        }
        return $this->prepareResponse('success');
    }

    public function updateData(): \cl\plugin\CLBaseResponse
    {
        error_log('in update data');
        // data is not really persisted in this sample
        $request = $this->clServiceRequest->getCLRequest()->getRequest();
        if (isset($request['username']) && isset($request['email'])) {
            if (isset($this->trivialStore[$request['username']])) {
                $user = new User($request['username'], $request['email']);
                $this->trivialStore[$request['username']] = $user;
                $this->persist();
                return $this->prepareResponse('success');
            } else {
                return $this->prepareResponse('failure');
            }
        }
        return $this->prepareResponse('failure');
    }

    private function getUserByUsername($username) {
        return $this->trivialStore[$username] ?? null;
    }

    private function getAllUsers() : array {
        return $this->trivialStore ?? [];
    }

    private function persist() {
        file_put_contents($this->storePath.'trivialstore', serialize($this->trivialStore));
    }

    private function load() {
        if (!file_exists($this->storePath.'trivialstore')) { return false; }
        $this->trivialStore = unserialize(file_get_contents($this->storePath.'trivialstore'));
        return true;
    }
}
