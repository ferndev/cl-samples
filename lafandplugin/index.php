<?php
/**
 * index.php
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

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';

use cl\web\CLHtmlApp;
use cl\ui\web\CLHtmlCtrl;
use cl\ui\web\CLHtmlPage;

$page1 = new CLHtmlPage(null, '');
$page1->setLookandFeel('stylish.php')
      ->addElement((new CLHtmlCtrl(''))->setLookandFeel('about.php')->setVars(array('aboutus' => 'Code-lib and Stylish Portfolio - a perfect combination for your next project! :-)')))
      ->addElement('footer.php')
      ->setVars(array('title' => 'Hello, World...','cltitle' => 'Code-lib sample with installed (stylish) look & feel', 'cp' => '(C) Your Company'));

$app = new CLHtmlApp();
$app
    ->addPlugin(CLHtmlApp::BEFORE_RENDER, 'SimplePlugin')
    ->addElement('pg1', $page1, true)
    ->run();
