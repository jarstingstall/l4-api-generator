<?php namespace Api\Compilers;

use Config;

class ConfigCompiler
{
    /**
     * Database driver
     *
     * @var string
     */
    protected $driver;

    /**
     * Array of resources
     *
     * @var array
     */
    protected $resources;

    /**
     * Route prefix
     *
     * @var string
     */
    protected $prefix;

    public function compile()
    {
        $this->driver = Config::get('api-generator.driver');
        $this->resources = Config::get('api-generator.resources');
        $this->prefix = Config::get('api-generator.prefix');
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }
}