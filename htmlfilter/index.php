<?php
// no namespace specified for this app, so it defaults to 'app'

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

use cl\web\CLDeployment;

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR); // <-- you can use absolute or relative location
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';

$form = new \cl\ui\web\CLHtmlForm('','POST','index.php');
$form->addElement((new \cl\ui\web\CLHtmlDiv())->addElement(
    new \cl\ui\web\CLHtmlLabel('name','mytext','Please enter some text including html tags')))
    ->addElement((new \cl\ui\web\CLHtmlDiv())->addElement(new \cl\ui\web\CLHtmlTextArea('mytext', 5, 50)))
    ->addElement(new \cl\ui\web\CLHtmlButton('submit', '', 'Press here','', 'btn btn-success'));

$head = new \cl\ui\web\CLHtmlHead('Hello');
$head->addElement(new \cl\ui\web\CLHtmlLink('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'))
    ->addElement(new \cl\ui\web\CLHtmlScript('https://code.jquery.com/jquery-3.5.1.slim.min.js'))
    ->addElement(new \cl\ui\web\CLHtmlScript('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'))
    ->addElement(new \cl\ui\web\CLHtmlScript('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'));
$page = new \cl\ui\web\CLHtmlPage($head);
$page->addElement(new \cl\ui\web\CLHtmlSpan());
$page->addElement($form);
$page2 = new \cl\ui\web\CLHtmlPage($head);
$page2->addElement(new \cl\ui\web\CLHtmlCtrl('h1','','User Welcoming Page'));
$page2->addElement(new \cl\ui\web\CLHtmlSpan());

$dpl = new CLDeployment(CLDeployment::DEV, new \cl\web\CLConfig());
$app = new \cl\web\CLHtmlApp();
$app->setDeployment($dpl, true);
$app->addPlugin('*.*', 'WelcomePlugin')
    ->addElement('pg1', $page, true) // we start with Page pg1 as our default page
    ->addElement('pg2', $page2)
    ->run();

