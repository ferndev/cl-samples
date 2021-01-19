<?php

namespace app\test;

use app\plugin\MailTaskPlugin;
use cl\core\CLBaseServiceRequest;
use cl\plugin\CLBaseResponse;
use PHPUnit\Framework\TestCase;

class MailTaskPluginTest extends TestCase
{
    private $mailTaskPlugin;

    protected function setUp(): void
    {
        global $start;
        // setUp is called a few times, so we avoid re-definition here
        defined('BASE_DIR') or define('BASE_DIR', realpath(__DIR__ . '/../'));
        defined('CL_DIR') or define('CL_DIR', BASE_DIR . '/vendor/ferndev/codelib/src' . DIRECTORY_SEPARATOR); // <-- you can use absolute or relative location
        defined('APP_NS') or define('APP_NS', 'app');
        if ($start == null) {
            require_once CL_DIR . 'cl/CLStart.php'; // require_once would guarantee single inclusion anyway,
            ob_end_clean();                         // but the "if" is to avoid a problem with the buffer.
        }
        // this CL Test Helper class can be used to prepare required data for a Plugin
        $clconfig = \cl\test\CLTestHelper::createConfig([]); // config entries can be added to [] as key/value pairs
        $clrequest = \cl\test\CLTestHelper::createRequest('', [], $clconfig); // POST data can be added to [] as key/value pairs
        // now we create an instance of the desired Plugin (see the actual Plugin in plugin/MailTaskPlugin.php
        // Because this Plugin requires injection of the mail service, we let the Helper know, including its class and parameters
        $this->mailTaskPlugin = \cl\test\CLTestHelper::createPluginInstance(
            'MailTaskPlugin', 'run', $clrequest, $clconfig, null, [['emailService', 'cl\messaging\email\Email', null, [$clconfig]]]);
    }

    // below are our test methods

    public function testRun()
    {
        $response = $this->mailTaskPlugin->run();
        $status = $response->getVar('status');
        $this->assertNotNull($status, 'Status should not be null');
    }

    public function testDependsOn()
    {
        $dependencies = $this->mailTaskPlugin->dependsOn();
        $this->assertNotNull($dependencies, 'There should be one dependency set here');
    }

    public function testSetEmailService()
    {
        $vars = \cl\test\CLTestHelper::getPluginVars($this->mailTaskPlugin);
        $this->assertNotNull($vars, 'The Plugin should have variables defined');
        $emailService = $vars['emailService'];
        $this->assertNotNull($emailService);
        $this->assertTrue($emailService instanceof \cl\messaging\email\Email);
    }
}
