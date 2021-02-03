<?php

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

use cl\contract\CLLogger;
use cl\ui\web\CLHtmlHead;
use cl\ui\web\CLHtmlPage;
use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';

$config = new CLConfig();
// by default, the log folder of your App is a folder called logs, which you must create within your App's root folder.
// but you can change that and tell CL where logs must go, with the 'logFolder' config option:
$config->addAppConfig('httpclient', 'curl')
       ->addAppConfig(LOGLEVEL, CLLogger::DEBUG);
// here we create a Dev level deployment, and we add our configuration to it. You can add several types of deployment
// to your App (for development, production, testing, etc), and set one as active
$dpl = new CLDeployment(CLDeployment::DEV, $config);
$app = new CLHtmlApp();
$app->setDeployment($dpl, true); // we set our deployment as the currently active deployment
$app->addElement('page', new CLHtmlPage(new CLHtmlHead(null, 'phead')), true)
    ->addPlugin('page*', 'HttpClientPlugin') // this Plugin will always be called just before the
    ->run();                                      // output is sent to the browser.
