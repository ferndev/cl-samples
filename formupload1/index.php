<?php
/**
*  CL Concepts in this sample:
 * - Multi-part form to show how to handle uploads
 * - Use of programmatic controls to define your App
 * - Additional configurations for a Plugin flow (route). In this case, it only handles POST submissions
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

/**
 * this sample makes use of a free Bootstrap template: https://startbootstrap.com/template-overviews/stylish-portfolio/
 * which is provided under the The MIT License (MIT)
 */
define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';

use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;
use cl\ui\web\CLHtmlCtrl;
use cl\ui\web\CLHtmlPage;

$page1 = new CLHtmlPage(null, '');
$page1->setLookandFeel('stylish.php');
$page1->addElement((new CLHtmlCtrl(''))->setLookandFeel('myform.php')->setVars(array('cltitle' => 'Complete this form')));
$page1->addElement('footer.php');
$page1->setVars(array('title' => 'File Upload','cltitle' => 'Code-lib sample with form file upload', 'cp' => '(C) Copyright Fernando Martinez'));
$clconfig = new CLConfig();
$clconfig->addAppConfig(CSRFSTATUS, false)
         ->addAppConfig(UPLOAD_CONFIG, [UPLOAD_AUTOCONFIG => true]);
$app = new CLHtmlApp();
$app->setDeployment(new CLDeployment(CLDeployment::DEV, $clconfig), true)
    ->addPlugin('dochandler', 'UploadHandlingPlugin', 'run', [HTTP_POST]);
$app->addElement('dochandler', $page1, true)->run();
