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

use cl\plugin\CLBaseResponse;
use cl\ui\web\CLHtmlPage;
use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
require CL_DIR . 'cl/CLStart.php';

// we are creating a programmatic page first
$page = new \cl\ui\web\CLHtmlPage();
$page->addElement(new \cl\ui\web\CLHtmlSpan('<h3>A trivial REST server</h3><br>'))
     ->addElement(new \cl\ui\web\CLHtmlSpan('<h4>First time we open this page, we already submit a get request. See url above, and response below</h4>'))
     ->addElement(new \cl\ui\web\CLHtmlSpan('-','content')) // this will display a one line response from the Plugin
     ->addElement(new \cl\ui\web\CLHtmlHr());
// now let's add a very simple form
$form = new \cl\ui\web\CLHtmlForm('','POST','index.php/rest/');
$form->addElement(new \cl\ui\web\CLHtmlButton('submit', '', 'Submit this form',''));
$page->addElement(new \cl\ui\web\CLHtmlSpan('<br>Now an empty form we can submit to test posting to our REST server<br>'))
     ->addElement(new \cl\ui\web\CLHtmlSpan('<br>Check if the response (above the line) changes after submitting the form<br>'));
$page->addElement($form); // ok, now we have our page, with a form. This page must still be added to our App, see below
// now let's work on the App
$app = new CLHtmlApp();
// let's create a configuration
$clconfig = new CLConfig();
$clconfig->addAppConfig(CSRFSTATUS, false)
         ->setCors(['Access-Control-Allow-Origin' => ['*']])
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
    // and next, we add our Plugin to our App, but this time we do so, as an inline Plugin, created as an anonymous class
         ->addPlugin('rest.*', new class extends \cl\plugin\CLRestPlugin {
             private $data;
             public function postData(): \cl\plugin\CLBaseResponse
             {
                 _log('executed postdata');
                 return $this->prepareResponse('success')->setVar('content.value','Response from REST server: I received a Post request');
             }

             public function updateData(): \cl\plugin\CLBaseResponse
             {
                 _log('executed updateData');
                 return $this->prepareResponse('success')->setVar('content.value','Response from REST server: I received a Put request');
             }

             public function getData(): \cl\plugin\CLBaseResponse
             {
                 _log('executed getData');
                 return $this->prepareResponse('success')->setVar('content.value','Response from REST server: I received a Get request');
             }

             public function deleteData(): \cl\plugin\CLBaseResponse
             {
                 _log('executed deleteData');
                 return $this->prepareResponse('success')->setVar('content.value','Response from REST server: I received a Delete request');
             }
         })
         ->addElement('pg1',$page, true) // here, finally, we add the page to our App
         ->run(); // and we run the App

