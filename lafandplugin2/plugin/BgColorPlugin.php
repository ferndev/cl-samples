<?php
/**
 * BgColorPlugin.php
 */

namespace app\plugin;
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
use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;
use cl\plugin\CLBaseResponse;

/**
 * Class SimplePlugin
 * @package app\plugin
 */
class BgColorPlugin extends \cl\plugin\CLBasePlugin
{
    public function run() : CLResponse {
        _log('executing BgColorPlugin');
        $elems = $this->getFlowElements(); // we receive the elements of the current cl flow as an array
        if (count($elems) >= 2) {
            $color = $elems[1];
            $lafFolder = strtolower($color).'_laf';
            switch($color) {
                case 'red':
                    $laf = 'red_laf';
                    break;
                case 'green':
                case 'blue':
                    $laf = [$lafFolder.'/stylish.php', $lafFolder.'/content.php', $lafFolder.'/footer.php'];
                    break;
                default:
                    $laf = ['blue_laf/stylish.php', 'blue_laf/content.php', 'blue_laf/footer.php'];
            }
        } else {
            $laf = ['green_laf/stylish.php', 'green_laf/content.php', 'green_laf/footer.php'];
        }
        $this->pluginResponse->addVars(['laf' => $laf]);
        return $this->pluginResponse;
    }
}
