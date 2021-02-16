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

$config = new CLConfig();
$config->setClKey('timeline')
       ->addAppConfig(LOGLEVEL, CLLogger::DEBUG)
       ->setRepoConnDetails(CLMYSQL, array('server' => 'localhost', 'user' => 'root', 'password' => 'ciler', 'dbname' => 'clsample3'));
// Pages
// -------------------------------------------
// Intro
$intro = new CLHtmlPage(null, '');
$intro->setLookandFeel('stylish.php')
    ->addElement((new CLHtmlCtrl(''))->setLookandFeel('about.php'))
    ->addElement('footer.php');
// Phase I
$phase1 = new CLHtmlPage(null, '');
$phase1->setLookandFeel('stylish.php')
    ->addElement((new CLHtmlCtrl(''))->setLookandFeel('phase1.php'))
    ->addElement('footer.php');
// Phase II
$phase2 = new CLHtmlPage(null, '');
$phase2->setLookandFeel('stylish.php')
    ->addElement((new CLHtmlCtrl(''))->setLookandFeel('phase2.php'))
    ->addElement('footer.php');
// Phase III
$phase3 = new CLHtmlPage(null, '');
$phase3->setLookandFeel('stylish.php')
    ->addElement((new CLHtmlCtrl(''))->setLookandFeel('phase3.php'))
    ->addElement('footer.php');
// here we create a Dev level deployment, and we add our configuration to it. You can add several types of deployment
// to your App (for development, production, testing, etc), and set one as active
$dpl = new CLDeployment(CLDeployment::DEV, $config);
$app = new CLHtmlApp();
$app->setDeployment($dpl, true); // we set our deployment as the currently active deployment
$app->addElement('page', $intro, true)
    ->addElement('2weeks', $phase1)
    ->addElement('4weeks', $phase2)
    ->addElement('6weeks', $phase3)
    // we now add 3 Plugins, one for each timeline, and we configure them to be called only on a POST submission.
    // So, when the 2weeks URL is first called, the $phase1 page will display, but the Plugin won't execute.
    // However, that page contains a form that triggers the same flow (2weeks timeline), and because it would be a
    // post submission, the Phase1Plugin will execute. Same logic for the other Plugins.
    ->addPlugin('2weeks*', 'Phase1Plugin', 'run', [HTTP_POST])
    ->addPlugin('4weeks*', 'Phase2Plugin', 'run', [HTTP_POST])
    ->addPlugin('6weeks*', 'Phase3Plugin', 'run', [HTTP_POST])
    ->run();
