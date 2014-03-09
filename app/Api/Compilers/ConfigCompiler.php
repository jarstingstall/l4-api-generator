<?php namespace Api\Compilers;

use Config;

class ConfigCompiler
{
    public function compile()
    {
        $driver = Config::get('api-generator.driver');
        $resources = Config::get('api-generator.resources');
        $prefix = Config::get('api-generator.prefix');

        return compact('driver', 'resources', 'prefix');
    }
}