<?php
/**
 * UploadHandlingPlugin.php
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

use cl\contract\CLLogger;
use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;
use cl\plugin\CLBaseResponse;

/**
 * Class UploadHandlingPlugin
 * @package app\plugin
 */
class UploadHandlingPlugin implements \cl\contract\CLPlugin
{
    protected $clServiceRequest;
    protected $logger;
    protected $pluginResponse;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }


    public function run() : CLResponse {
        error_log('executing UploadHandlingPlugin');
        $metadata = $this->clServiceRequest->getCLRequest()->post('metadata');
        error_log('metadata received: '.$metadata);
        $feedback = 'Upload failed';
        // easily get info about the attachments received
        $attachments = $this->clServiceRequest->getCLRequest()->getAttachments();
        if ($attachments != null) {
            $feedback = 'Upload completed for '.count($attachments).' files: ';$sep = '';
            error_log('attachments received');
            foreach ($attachments as $k => $v) {
                error_log('received '.$k);
                $feedback .= $sep.$k;
                $sep = ', ';
            }
        }
        $this->pluginResponse->addVars(array('feedback' => $feedback));
        return $this->pluginResponse;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }
}
