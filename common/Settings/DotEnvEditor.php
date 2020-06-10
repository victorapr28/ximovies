<?php namespace Common\Settings;

use Dotenv\Dotenv;

/**
 * Class DotEnvEditor
 * @package Common\Settings
 */
class DotEnvEditor
{
    public function load()
    {

        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
}
