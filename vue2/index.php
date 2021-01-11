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

use cl\ui\web\CLHtmlPage;
use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';
$app = new CLHtmlApp();
$app->setLookandFeel('vue');
$app->addPlugin('user.*', 'UserPlugin'); // this plugin will handle any flow starting with user/ (for instance: user/register, user/login)
$clconfig = new CLConfig();
$clconfig->addAppConfig(CSRFSTATUS, false)
         ->addAppConfig(RENDER_ALL, false)
    // to sucessfully run this app, you will need to create a db using the provided 'user.sql' script, and configure the
    // app below to connect to your db
    ->setRepoConnDetails(CLMYSQL, array('server' => 'localhost', 'user' => 'root', 'password' => 'ciler', 'dbname' => 'clsample'))
         ->setHaltOnErrorLevel(E_ERROR | E_COMPILE_ERROR | E_NOTICE);
$app->setDeployment(new CLDeployment(CLDeployment::DEV, $clconfig), true)
         ->addElement('pg1',new CLHtmlPage(null, ''), true)
         ->run();

