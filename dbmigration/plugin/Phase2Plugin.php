<?php
/**
 * Phase2Plugin.php
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
 * Class HttpClientPlugin
 * @package app\plugin
 */
class Phase2Plugin implements \cl\contract\CLPlugin, CLInjectable
{
    private $logger;
    private $clServiceRequest;
    private $pluginResponse;
    private $activeRepo;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }

    public function run(): CLResponse
    {
        _log('executing Phase2Plugin');
        if (!$this->activeRepo->connect()) {
            $this->pluginResponse->setVar('message', _T('Unable to connect to the db'));
            $this->pluginResponse->setVar('status', CLFlag::FAILURE);
            return $this->pluginResponse;
        }
        $entity = requestToEntity('article', ['title', 'description', 'content', 'pubdate'], $this->clServiceRequest->getCLRequest());
        if ($this->activeRepo->create($entity)) {
            $this->pluginResponse->setVar('message', _T('Article successfully saved'));
            $this->pluginResponse->setVar('status', CLFlag::SUCCESS);
            return $this->pluginResponse;
        }
        $this->pluginResponse->setVar('message', _T('Article not saved'));
        $this->pluginResponse->setVar('status', CLFlag::FAILURE);
        return $this->pluginResponse;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed $activeRepo
     * @return Phase1Plugin
     */
    public function setActiveRepo($activeRepo)
    {
        $this->activeRepo = $activeRepo;
        return $this;
    }

    /**
     * @return array required dependencies
     */
    public function dependsOn(): array
    {
        return [CLDependency::new(ACTIVE_REPO)];
    }
}
