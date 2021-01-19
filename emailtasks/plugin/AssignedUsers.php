<?php


namespace app\plugin;

/**
 * Class AssignedUsers
 * Provides hardcoded list of users for each task. In real life you would likely get this from a db
 * replace with valid email addresses if you wish to try this sample
 * @package app\plugin
 */
trait AssignedUsers
{
    public function getTask1Users(): array {
        return [['Paul', 'paul@example.com'], ['Henry', 'henry@example.com']];
    }

    public function getTask2Users(): array {
        return [['Sean', 'sean@example.com'], ['Miguel', 'miguel@example.com']];
    }

    public function getTask3Users(): array {
        return [['Lee', 'lee@example.com']];
    }
}
