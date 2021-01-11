<?php
/**
 * CL Concepts in this sample: REST, CORS, Plugins, setting timezone,
 */

namespace app;
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

use cl\ui\web\CLHtmlPage;
use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';
$page = new \cl\ui\web\CLHtmlPage();
$page->addElement(new \cl\ui\web\CLHtmlSpan('Hello'));
$app = new CLHtmlApp();
$clconfig = new CLConfig();
$clconfig->addAppConfig(CSRFSTATUS, false)
         ->setCors(['Access-Control-Allow-Origin' => ['http://localhost:8087']])
        // set your timezone, see some examples on the right. Search PHP manual for full list
         ->addAppConfig(CURRENT_TIMEZONE, 'America/New_York') // ex: 'Africa/Harare', 'America/Los_Angeles', 'Asia/Tokyo', 'Asia/Hong_Kong', 'Asia/Seoul',
                                                              // 'America/Toronto', 'America/Havana', 'America/Bogota', 'Australia/Sydney',
                                                             // 'Europe/Madrid', 'Europe/London', 'Europe/Berlin', 'Europe/Paris', 'Europe/Moscow',
                                                             // 'Asia/Dubai', 'Asia/Singapore', 'Asia/Shanghai', 'Asia/Jerusalem', among many
		 ->addAppConfig(CORS, true)
         ->addAppConfig(RENDER_ALL, false)
         ->setHaltOnErrorLevel(E_USER_ERROR);
// we create a deployment for development, which sets logging level to debug. The deployment receives our configuration
// see CLDeployment for other kind of deployments you can create
$app->setDeployment(new CLDeployment(CLDeployment::DEV, $clconfig), true)
         ->addPlugin('rest.*', 'RestPlugin')
         ->addElement('pg1',$page, true)
         ->run();

