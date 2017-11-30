<?php

use Tian\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testloadEnv()
    {
    	$config = new Config();
    	$config->loadEnv(__DIR__);
    	$this->assertEquals("127.0.0.1",$config->env("REDIS_HOST"));
    	$this->assertEquals("mysql",$_ENV["DB_CONNECTION"]);
    }
    public function testloadFiles()
    {
        $config = new Config();
        $config->loadFiles(__DIR__.'/config');
        $this->assertEquals('Laravel',$config->get('app.name'));
        $this->assertEquals('bar',$config->get('app.arr.foo'));
        $this->assertEquals('AES-256-CBC',$config->get('app.cipher'));
    }
}

