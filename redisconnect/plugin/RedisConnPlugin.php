<?php
/**
 * RedisConnPlugin.php
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
use cl\core\CLDependency;
use cl\core\CLFlag;
use cl\plugin\CLBaseResponse;

/**
 * Class RedisConnPlugin
 * Handles user requests and stores and retrieves data from Redis
 * @package app\plugin
 */
class RedisConnPlugin extends \cl\plugin\CLRestPlugin implements CLInjectable
{
    private $activeRepo;

    /**
     * @inheritDoc
     */
    public function postData(): \cl\contract\CLResponse
    {
        _log('executed postdata');
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        if (isset($clrequest['cname'])) {
            if (!$this->activeRepo->connect()) {
                return $this->prepareResponse(_T('unable to connect to Redis'), CLFlag::FAILURE,null, $this->clServiceRequest->getCLRequest()->getRequest());
            }
            $entity = $this->prepareEntity();
            if (!isset($entity)) { return $this->prepareResponse(_T('Input data seems incorrect'), CLFlag::FAILURE,null, $this->clServiceRequest->getCLRequest()->getRequest()); }
            if ($this->activeRepo->create($entity)) {
                return $this->prepareResponse(_T('You have successfully posted to your redis server'), CLFlag::SUCCESS);
            }
            return $this->prepareResponse(_T('Unfortunately posting failed'), CLFlag::FAILURE,null, $this->clServiceRequest->getCLRequest()->getRequest());
        }
        return $this->prepareResponse('success')->setVar('content.value','Response from REST server: I saved your request to Redis');
    }

    /**
     * @inheritDoc
     */
    public function updateData(): \cl\contract\CLResponse
    {
        // TODO: Implement updateData() method.
    }

    /**
     * @inheritDoc
     */
    public function getData(): \cl\contract\CLResponse
    {
        if (!$this->activeRepo->connect()) {
            return $this->prepareResponse(_T('unable to connect to Redis'), CLFlag::FAILURE,null, $this->clServiceRequest->getCLRequest()->getRequest());
        }

        $response = $this->activeRepo->executeCommand('smembers', 'usercontacts');
        if ($response != null && count($response) > 0) {
            foreach ($response as $contact) {
                $userdata[] = $this->activeRepo->read($contact);
            }
        }
        if (!isset($userdata) || count($userdata) == 0) {
            return $this->prepareResponse(_T('Unfortunately no data was returned'), CLFlag::FAILURE, 'pg2', $this->clServiceRequest->getCLRequest()->getRequest());
        }
        return $this->prepareResponse('success', CLFlag::SUCCESS, 'pg2')->setVar('contacts',$userdata);
    }

    /**
     * @inheritDoc
     */
    public function deleteData(): \cl\contract\CLResponse
    {
        // TODO: Implement deleteData() method.
    }

    /**
     * @param mixed $activeRepo
     * @return RedisConnPlugin
     */
    public function setActiveRepo($activeRepo)
    {
        $this->activeRepo = $activeRepo;
        return $this;
    }

    public function dependsOn(): array
    {
        return [CLDependency::new(ACTIVE_REPO)];
    }

    private function prepareEntity() {
        $entity = $this->requestToEntity('', array('cname', 'email', 'cell'));
        $entity->setEntityName($entity->getField('cname'));
        // we indicate in this way, we want a reference to the entityName added to this redis list (in the way Redis works)
        $entity->setField('list', 'usercontacts');
        return $entity;
    }
}
