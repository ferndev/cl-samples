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

use cl\ui\web\CLHtmlCtrl;
use cl\ui\web\CLHtmlPage;
use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';

$page1 = new CLHtmlPage(null, '');
$page1->setLookandFeel('stylish.php')
    ->addElement((new CLHtmlCtrl(''))->setLookandFeel('newcontact.php'))
    ->addElement('footer.php');
$page2 = new CLHtmlPage(null, '');
$page2->setLookandFeel('stylish.php')
    ->addElement((new CLHtmlCtrl(''))->setLookandFeel('listcontacts.php'))
    ->addElement('footer.php');
// now let's work on the App
$app = new CLHtmlApp();
// let's create a configuration
$clconfig = new CLConfig();
$clconfig->addAppConfig(CSRFSTATUS, false)
         ->setCors(['Access-Control-Allow-Origin' => ['*']])
        // set your timezone, see some examples on the right. Search PHP manual for full list
         ->addAppConfig(CURRENT_TIMEZONE, 'Europe/London') // ex: 'Africa/Harare', 'America/Los_Angeles', 'Asia/Tokyo', 'Asia/Hong_Kong', 'Asia/Seoul',
                                                              // 'America/Toronto', 'America/Havana', 'America/Bogota', 'Australia/Sydney',
                                                             // 'Europe/Madrid', 'Europe/London', 'Europe/Berlin', 'Europe/Paris', 'Europe/Moscow',
                                                             // 'Asia/Dubai', 'Asia/Singapore', 'Asia/Shanghai', 'Asia/Jerusalem', among many
		 ->addAppConfig(CORS, true)
         ->addAppConfig(RENDER_ALL, false)
         // uncomment and change your Redis connection details, if different from the default one shown below
         //->setRepoConnDetails(CLREDIS, ['redislib' => 'predis', 'scheme' => 'tcp', 'host' => '127.0.0.1', 'port' => 6379])
         ->setActiveClRepository(CLREDIS)
         ->setHaltOnErrorLevel(E_USER_ERROR);
// we create a deployment for development, which sets logging level to debug. The deployment receives our configuration
// see CLDeployment for other kind of deployments you can create
$app->setDeployment(new CLDeployment(CLDeployment::DEV, $clconfig), true)
    // We add our Plugin to our App
    ->addPlugin('rest.*', 'RedisConnPlugin')
    ->addElement('pg1',$page1, true) // here, we add the default page to our App
    ->addElement('pg2',$page2) // and we add the other page
    ->run(); // and we run the App

